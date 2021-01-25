<?php

namespace App\Http\Controllers;

use App\Models\Inmr;
use App\Models\Psoh;
use App\Models\Psol;
use App\Models\Psgh;
use App\Models\Psgl;
use Illuminate\Http\Request;
use App\Http\Resources\Reference;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;

class GoodsReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data['products'] = Inmr::select('*')->get();

        $data['psoh'] = Psoh::select('*')->where('status_code', 'A' )->get();
        
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
            'doc_ref_no' => 'required',
        ]
        )->validate();

        $code = DB::table('brmr')->select('*')->where('co_no', '01')->where('br_no', '01')->first();

        $goodreceipt = new Psgh();
        $goodreceipt->co_no = '01';
        $goodreceipt->br_no = '01';
        $goodreceipt->gr_no = $code->pfx_psgh_gr_no.str_pad($code->nx_psgh_gr_no, 13, '0', STR_PAD_LEFT);
        $goodreceipt->psoh_hash = $request->input('psoh_hash');
        $goodreceipt->ord_req_no = $request->input('ord_req_no');
        $goodreceipt->doc_ref_no = $request->input('doc_ref_no');
        $goodreceipt->receipt_date = date('Y-m-d');
        $goodreceipt->status_code = 'R';
        $goodreceipt->issued_dt = Carbon::now();
        $goodreceipt->create_date = Carbon::now();
        $goodreceipt->update_id = Auth::user()->user_hash;
        $goodreceipt->save();

        DB::table('brmr')->where('co_no', '01')->where('br_no', '01')->increment('nx_psgh_gr_no');
        
        $items = $request->input('items');
    
        $items_dataset = [];
        foreach($items as $item)
        {
            $items_dataset[] = [
                'psgh_hash'=>$goodreceipt->psgh_hash,
                'inmr_hash'=>$item['inmr_hash'],
                'uom_code'=>$item['uom_code'],
                'psol_hash'=>$item['psol_hash'],
                'order_qty'=>$item['order_qty'],
                'receipt_qty'=>$item['new_receipt_qty'],
                'act_cost'=>$item['act_cost'],
                'sale_price'=>$item['sale_price'],
                'create_id' => Auth::user()->user_hash,
                'create_date'=>Carbon::now(),
        
            ];
        }
    
        DB::table('psgl')->insert($items_dataset);

        $items_inlo = [];
        foreach($items as $item)
        {
            $items_inlo[] = [
                'gr_no'=>$goodreceipt->gr_no,
                'reference'=>$goodreceipt->doc_ref_no,
                'uom_code'=>$item['uom_code'],
                'qty'=>$item['new_receipt_qty'],
                'cost'=>$item['act_cost'],
                'date'=>date("Y-m-d"),
                'expiry_date'=>$item['expiry_date'],
                // 'create_id' => Auth::user()->user_hash,
                'create_date'=>Carbon::now()
        
            ];
        }
    
        DB::table('inlo')->insert($items_inlo);

        foreach($items as $item)
        {
            DB::table('psol')->where('psoh_hash', $request->input('psoh_hash'))
            ->where('inmr_hash', $item['inmr_hash'])
            ->increment('receipt_qty',$item['new_receipt_qty']);
        }

        foreach($items as $item)
        {
            DB::table('inwh')->where('inmr_hash', $item['inmr_hash'])
            ->increment('on_hand',$item['new_receipt_qty']);
        }

        foreach($items as $item)
        {
            DB::table('inwh')->where('inmr_hash', $item['inmr_hash'])
            ->decrement('on_order',$item['new_receipt_qty']);
        }
        
    //return json based from the resource data
    $data['products'] = Inmr::select('*')->get();

    $data['psoh'] = Psoh::select('*')->get();
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
        //
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
    public function getPoItems($id)
    {
        $poitems = Psol::select(
            'psol.*',
            'inmr.item_no',
            'inmr.description',
            'inmr.uom_code'
        )
                ->leftJoin('inmr', 'inmr.inmr_hash', '=', 'psol.inmr_hash')
                ->where('psoh_hash', $id)
                ->get();

        
        return $poitems;
    }
    // public function checkQty($id)
    // {
    //     $poitems = Psol::select(
    //         '*'
    //     )
    //             ->leftJoin('inmr', 'inmr.inmr_hash', '=', 'psol.inmr_hash')
    //             ->where('psoh_hash', $id)
    //             ->get();

        
    //     return $poitems;
    // }
}
