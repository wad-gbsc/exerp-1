<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inmr;
use App\Models\Inty;
use App\Http\Resources\Reference;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['inmr'] = Inmr::select('*')->get();

        $data['inty'] =  DB::table('inty')->select('*')->get();
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
       'item_no' => 'required',
       'description' => 'required',
       'barcode' => 'required'
        ]
       )->setAttributeNames([
           'item_no' => 'Item Code',
           'description' => 'Item Name',
           'barcode' => 'Barcode',
        ])->validate();

        
        $product = new Inmr();
        $product->item_no = $request->input('item_no');
        $product->description = $request->input('description');
        $product->status = $request->input('status');
        $product->product_type = $request->input('product_type');
        $product->barcode = $request->input('barcode');
        $product->costing = $request->input('costing');
        $product->cost = $request->input('cost');
        $product->markup_pc = $request->input('markup_pc');
        $product->create_date = Carbon::now();
        $product->create_id = Auth::user()->user_hash;

        $product->save();

        return ( new Reference( $product ) )
        ->response()
        ->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function delete($id)
    {   
        $product = Inmr::findOrFail($id);
        $product->is_deleted = 1;

        //update classification based on the http json body that is sent
        $product->save();
        

        return ( new Reference( $product ) )
            ->response()
            ->setStatusCode(200);
    }
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
       'item_no' => 'required',
       'description' => 'required',
       'barcode' => 'required'
        ]
       )->setAttributeNames([
           'item_no' => 'Item Code',
           'description' => 'Item Name',
           'barcode' => 'Barcode',
        ])->validate();

        
        $product = Inmr::findOrFail($id);
        $product->item_no = $request->input('item_no');
        $product->description = $request->input('description');
        $product->status = $request->input('status');
        $product->product_type = $request->input('product_type');
        $product->barcode = $request->input('barcode');
        $product->costing = $request->input('costing');
        $product->cost = $request->input('cost');
        $product->markup_pc = $request->input('markup_pc');
        $product->create_date = Carbon::now();
        $product->create_id = Auth::user()->user_hash;

        $product->save();

        return ( new Reference( $product ) )
        ->response()
        ->setStatusCode(200);
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
}
