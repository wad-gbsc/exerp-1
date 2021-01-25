<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Reference;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Inmr;
use App\Models\Psoh;
use App\Models\Psol;
use Carbon\Carbon;
use Auth;
use DB;

class RequestOrderEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data['inmr'] = Inmr::select(
            'inmr.*',
            'inwh.on_hand'
)
                    ->leftJoin('inwh', 'inwh.inmr_hash', '=', 'inmr.inmr_hash')
                    ->where('whmr_hash', 1)
                    ->orderBy('inmr_hash', 'asc')
                    ->get();

        $data['psoh'] = DB::table('psoh')->select('*')->get();
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $code = DB::table('brmr')->select('*')->where('co_no', '01')->where('br_no', '01')->first();
        Validator::make($request->all(),

         [
        'request_user' => 'required',
        'required_date' => 'required',
        'reason' => 'required'
        ]
        )->setAttributeNames([
            'request_user' => 'Requesting User',
            'required_date' => 'Date',
            'reason' => 'Reason for Request',
    ])->validate();
    $poe = new Psoh();
    $poe->co_no = '01';
    $poe->br_no = '01';
    $poe->ord_req_no = DB::raw('code()');
    $poe->ord_req_no = $code->pfx_psoh_ord_req_no.str_pad($code->nx_psoh_ord_req_no, 13, '0', STR_PAD_LEFT);
    $poe->request_user = $request->input('request_user');
    $poe->required_date = date('Y-m-d H:i:s', strtotime($request->input('required_date')));
    $poe->reason = $request->input('reason');
    $poe->status_code = 'O';
    $poe->create_date = Carbon::now();
    $poe->create_id = Auth::user()->user_hash;
 
    $poe->save();

    DB::table('brmr')->where('co_no', '01')->where('br_no', '01')->increment('nx_psoh_ord_req_no');

    $items = $request->input('items');
    $items_dataset = [];
    foreach($items as $item)
    {
        $items_dataset[] = [
            'psoh_hash'=>$poe->psoh_hash,
            'inmr_hash'=>$item['inmr_hash'],
            'uom_code'=>$item['uom_code'],
            'available_qty'=>$item['available_qty'],
            'price'=>$item['price'],
            'act_cost'=>$item['price'],
            'order_qty'=>$item['order_qty'],
            'remarks'=>$item['remarks']
        ];
    }
    DB::table('psol')->insert($items_dataset);
    foreach($items as $item)
        {
            DB::table('inwh')->where('inmr_hash', $item['inmr_hash'])
            ->increment('on_order',$item['order_qty']);
        }

    //return json based from the resource data
    $data = Psoh::select(
        'psoh.*',
        'psol.*'
    )
        ->leftJoin('psol', 'psol.psol_hash', '=', 'psoh.psoh_hash')
        ->findOrFail($poe->psoh_hash);

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
        Validator::make($request->all(),
        [
            'request_user' => 'required',
            'required_date' => 'required',
            'reason' => 'required',

        ])->setAttributeNames([

            'request_user' => 'Request User',
            'required_date' => 'Date',
            'reason' => 'Reason for Request',
        ])->validate();      
        
        $poe = Psoh::findOrFail($id);
        $poe->request_user = $request->input('request_user');
        $poe->required_date = date('Y-m-d H:i:s', strtotime($request->input('required_date')));
        $poe->reason = $request->input('reason');
        $poe->status_code = $request->input('status_code');
        $poe->update_date = Carbon::now();
        $poe->update_id = Auth::user()->username;
        //update  based on the http json body that is sent
        $poe->save();

        $items = $request->input('items');
        $old_items = Psol::where('psoh_hash', $poe->psoh_hash);
        $old_items->delete();

        $items_dataset = [];
        foreach($items as $item)
        {
            $items_dataset[] = [
                'psoh_hash'=>$poe->psoh_hash,
                'inmr_hash'=>$item['inmr_hash'],
                'uom_code'=>$item['uom_code'],
                'available_qty'=>$item['available_qty'],
                'order_qty'=>$item['order_qty'],
                'remarks'=>$item['remarks']
            ];
        }
    
        DB::table('psol')->insert($items_dataset);

        //return json based from the resource data
        $data = Psoh::select(
            'psoh.*',
            'psol.*'
        )
            ->leftJoin('psol', 'psol.psol_hash', '=', 'psoh.psoh_hash')
            ->findOrFail($poe->psoh_hash);
    
        return ( new Reference( $data ) )
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage for deleting.
     * preventing force delete rather update the is_deleted = true
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function getRequestItems($id)
    {
        $poitems = Psol::select(
            'psol.*',
            'inmr.inmr_hash', 
            'inmr.item_no',
            'inmr.description'
            // 'inwh.on_hand'
        )
                            ->leftJoin('inmr', 'inmr.inmr_hash', '=', 'psol.inmr_hash')
                            // ->leftJoin('inwh', 'inwh.inmr_hash', '=', 'inmr.inmr_hash')
                            ->where('psoh_hash', $id)
                            ->get();

        
        return $poitems;
    }
    public function delete($id)
    {   
        $poe = Psoh::findOrFail($id);
        $poe->is_deleted = 1;

        //update classification based on the http json body that is sent
        $poe->save();
        

        return ( new Reference( $poe ) )
            ->response()
            ->setStatusCode(200);
    }
    public function getRequest()
    {
        $data = DB::table('psoh')->select('*')->get();
        return $data;
    }
}
