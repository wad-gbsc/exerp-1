<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Inty;
use App\Http\Resources\Reference;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Auth;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Inty::where('is_deleted', 0)->orderBy('product_desc', 'asc')->get();
        return Reference::collection($categories);
        
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
                'product_type' => 'required',
                'product_desc' => 'required',
            ]
        )->validate();

        $category = new Inty();
        $category->product_desc = $request->input('product_desc');
        $category->product_type = $request->input('product_type');
        $category->create_datetime = Carbon::now();
        $category->create_id = Auth::user()->user_hash;
    
        $category->save();

        //return json based from the resource data
        return ( new Reference( $category ))
                ->response()
                ->setStatusCode(201);
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
        $category = Inty::findOrFail($id);

        return ( new Reference( $category ) )
            ->response()
            ->setStatusCode(200);
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
        $category = Inty::findOrFail($id);
        
        Validator::make($request->all(),
            [
                'product_type' => 'required',
                'product_desc' => 'required',
            ]
        )->validate();

        
        $category->product_desc = $request->input('product_desc');
        $category->product_type = $request->input('product_type');
        $category->update_datetime = Carbon::now();
        $category->update_id = Auth::user()->user_hash;


        //update  based on the http json body that is sent
        $category->save();

        return ( new Reference( $category ) )
            ->response()
            ->setStatusCode(200);
    }

    public function delete($id)
    {   
        $category = Inty::findOrFail($id);

        $category->is_deleted = 1;
        $category->delete_datetime = Carbon::now();
        $category->delete_id = Auth::user()->user_hash;

        //update classification based on the http json body that is sent
        $category->save();

        return ( new Reference( $category ) )
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
