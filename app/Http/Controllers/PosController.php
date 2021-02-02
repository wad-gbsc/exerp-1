<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pssh;
use App\Models\Psds;
use App\Models\Inlo;
use App\Http\Resources\Reference;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
class PosController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data['products'] = Inmr::select('*')->get();
        $data['products'] = Inlo::select(
            'inlo.*',
            'inwh.*',
            'inmr.*'
            )
        ->leftJoin('inwh', 'inwh.inwh_hash', 'inlo.inwh_hash')
        ->leftJoin('inmr', 'inmr.inmr_hash', 'inwh.inmr_hash')
        ->get();

        $data['psds'] = Psds::select('*')->where('status', 'A' )->where('type', 'H' )->get();
        $data['special'] = Psds::select('*')->where('status', 'A' )->where('type', 'L' )->get();

        
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        Validator::make($request->all(),
        [
            'cash_rendered' => 'required',
        ]
        )->validate();

        $code = DB::table('brmr')->select('*')->where('co_no', '01')->where('br_no', '01')->first();

        $pos = new Pssh();
        $pos->trans_no = $code->pfx_pssh_trans_no.str_pad($code->nx_pssh_trans_no, 13, '0', STR_PAD_LEFT);
        $pos->trans_date = date('Y-m-d');
        $pos->sold_to = 'CASH';
        $pos->payment_mode = 'CA';
        $pos->co_no = '01';
        $pos->br_no = '01';
        $pos->gross_amount = $request->input('gross_amount');
        $pos->disc_code = $request->input('disc_code');
        $pos->disc_amount = $request['disc_amount_header'];
        $pos->tot_taxable_amount = $request['net_amount'];
        $pos->vat_amount = $request->input('vat_amount');
        $pos->net_amount = $request->input('tot_taxable_amount');
        $pos->cash_rendered = $request->input('cash_rendered');
        $pos->create_date = Carbon::now();
        $pos->create_id = Auth::user()->user_hash;
        $pos->save();

        DB::table('brmr')->where('co_no', '01')->where('br_no', '01')->increment('nx_pssh_trans_no');
        
        $items = $request->input('items');
    
        $items_dataset = [];
        $line_no = 0;
        foreach($items as $item)
        {
            $items_dataset[] = [
                'pssh_hash'=>$pos->pssh_hash,
                'inmr_hash'=>$item['inmr_hash'],
                'line_no' => $line_no++,
                'inlo_hash'=>$item['inlo_hash'],
                'uom_code'=>$item['uom_code'],
                'base_price'=>$item['price'],
                'sale_price'=>$item['price'],
                'sale_qty'=>$item['product_quantity'],
                'disc_amount'=>$item['disc_amount'],
                'extended'=>$item['extended'],
                // 'sale_qty'=>$item['sale_qty'],
                'create_id' => Auth::user()->user_hash,
                'create_date'=>Carbon::now()
        
            ];
        }
    
        DB::table('pssl')->insert($items_dataset);
        
        foreach($items as $item)
        {
            DB::table('inlo')->where('inlo_hash', $item['inlo_hash'])
            ->decrement('qty',$item['product_quantity']);
        }

        foreach($items as $item)
        {
            DB::table('inwh')->where('inmr_hash', $item['inmr_hash'])->where('inwh_hash', $item['inwh_hash'])
            ->decrement('on_hand',$item['product_quantity']);
        }

        $data['pos'] = DB::table('pssl')->select(
            '*'
            )
        ->leftJoin('pssh', 'pssh.pssh_hash', 'pssl.pssh_hash')
        ->get();

        return ( new Reference( $data ) )
        ->response()
        ->setStatusCode(200);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['psds'] = Psds::select(
            '*'
            )->where('status', 'A' )->get();

        
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function delete($id)
    {   
        // $pos = PosItems::findOrFail($id);

        // $pos->is_deleted = 1;
        // $pos->deleted_datetime = Carbon::now();
        // $pos->deleted_by = Auth::user()->user_id;

        // //update classification based on the http json body that is sent
        // $pos->save();

        // return ( new Reference( $pos ) )
        //     ->response()
        //     ->setStatusCode(200);
    }
    public function getBarcode($id)
    {

        $barcode  = Inlo::select(
            'inlo.*',
            'inwh.*',
            'inmr.*'
            )
        ->leftJoin('inwh', 'inwh.inwh_hash', 'inlo.inwh_hash')
        ->leftJoin('inmr', 'inmr.inmr_hash', 'inwh.inmr_hash')
        ->where('inmr.barcode', $id)
        ->get();

        
        return $barcode;
    }
}
