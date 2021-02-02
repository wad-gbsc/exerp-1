<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mpdf\Mpdf;
use DB;
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
set_time_limit(300);
ini_set("pcre.backtrack_limit", "5000000");

class xReadingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    public function PrintDate($this_date)
    {   
            $data['date'] = DB::table('pssh')->select('*')->where('pssh.trans_date' , $this_date)->get();
            $data['beginningOR'] = DB::table('pssh')->select('*')->where('pssh.trans_date' , $this_date)->min('trans_no');
            $data['endingOR'] = DB::table('pssh')->select('*')->where('pssh.trans_date' , $this_date)->max('trans_no');
            $data['beginning'] = DB::table('pssh')->select('*')->where('trans_date' , '<' , $this_date)->sum('net_amount');
            $data['today'] = DB::table('pssh')->select('*')->where('pssh.trans_date' , $this_date)->sum('net_amount');

            $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => [80, 236]]);
            $content = view('print.xreading')->with($data);
            $mpdf->WriteHTML($content);
            $mpdf->Output(); 
        
    }
    public function date($this_date)
    {   
            $data['date'] = DB::table('pssh')->select('*')
            ->where('pssh.trans_date' , $this_date)
            ->get();
            return $data;
        
    }
    public function index()
    {
        $data['user'] = DB::table('user')->select('*')->where('user.user_type', 'Cashier')->get();
        $data['term'] = DB::table('term')->select('*')->get();
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
}
