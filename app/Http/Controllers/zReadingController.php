<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Reference;
use Mpdf\Mpdf;
use DB;

class zReadingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function PrintBetweenName($from_date, $to_date, $id)
    {   
        


        $data['printbetweendate'] = DB::table('pssh')->select('*')->orderBy('trans_no', 'asc');
        $data['beginning'] = DB::table('pssh')->select('trans_no');
        $data['ending'] = DB::table('pssh')->select('trans_no');
        $data['beginningamount'] = DB::table('pssh')->select('net_amount')->where('trans_date', '<=', "$from_date");
        $data['scdiscount'] = DB::table('pssh')->select('disc_amount')->where('disc_code' ,'=', 'SCD');
        $data['qty'] = DB::table('pssh')->select('pssh.*','pssl.sale_qty')->leftJoin('pssl', 'pssl.pssh_hash', '=', 'pssh.pssh_hash');  
        $data['user'] = DB::table('pssh')->select('pssh.create_id','user.user_hash','user.username')
        ->leftJoin('user', 'user.user_hash', '=', 'pssh.create_id')->where('create_id', '=', $id)->groupBy('create_id'); 
         

        if($from_date != 0 || $to_date != 0 || $id != null)
        {   
            $data['user']->whereRaw('DATE(trans_date) BETWEEN DATE("'.$from_date.'") AND DATE("'.$to_date.'")')->where('pssh.create_id',  $id);
            $data['qty']->whereRaw('DATE(trans_date) BETWEEN DATE("'.$from_date.'") AND DATE("'.$to_date.'")')->where('pssh.create_id',  $id);
            $data['scdiscount']->whereRaw('DATE(trans_date) BETWEEN DATE("'.$from_date.'") AND DATE("'.$to_date.'")')->where('pssh.create_id',  $id);
            $data['beginningamount']->whereRaw('DATE(trans_date) BETWEEN DATE("'.$from_date.'") AND DATE("'.$to_date.'")')->where('pssh.create_id',  $id);
            $data['beginning']->whereRaw('DATE(trans_date) BETWEEN DATE("'.$from_date.'") AND DATE("'.$to_date.'")')->where('pssh.create_id',  $id);
            $data['ending']->whereRaw('DATE(trans_date) BETWEEN DATE("'.$from_date.'") AND DATE("'.$to_date.'")')->where('pssh.create_id',  $id);
            $data['printbetweendate']->whereRaw('DATE(trans_date) BETWEEN DATE("'.$from_date.'") AND DATE("'.$to_date.'")')->where('pssh.create_id',  $id);
        }
        $data['user'] = $data['user']->select('username')->get();
        $data['qty'] = $data['qty']->get();
        $data['scdiscount'] = $data['scdiscount']->get();
        $data['beginningamount'] = $data['beginningamount']->get();
        $data['beginning'] = $data['beginning']->min('trans_no');
        $data['ending'] = $data['ending']->max('trans_no');
        $data['printbetweendate'] = $data['printbetweendate']->get();
        $data['date_from'] = $from_date;
        $data['date_to'] = $to_date;

        $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => [80, 236]]);
        $content = view('print.zreadingname')->with($data);
        $mpdf->WriteHTML($content);
        $mpdf->Output(); 
        
    }
    public function PrintBetweenDate($from_date, $to_date)
    {   
        $data['printbetweendate'] = DB::table('pssh')->select('*')->orderBy('trans_no', 'asc');
        $data['beginning'] = DB::table('pssh')->select('trans_no');
        $data['ending'] = DB::table('pssh')->select('trans_no');
        $data['beginningamount'] = DB::table('pssh')->select('net_amount')->where('trans_date', '<=', "$from_date");
        $data['scdiscount'] = DB::table('pssh')->select('disc_amount')->where('disc_code' ,'=', 'SCD');


        $data['qty'] = DB::table('pssh')->select('pssh.*','pssl.sale_qty')->leftJoin('pssl', 'pssl.pssh_hash', '=', 'pssh.pssh_hash');
            
        if($from_date != 0 || $to_date != 0)
        {   
            $data['qty']->whereRaw('DATE(trans_date) BETWEEN DATE("'.$from_date.'") AND DATE("'.$to_date.'")');
            $data['scdiscount']->whereRaw('DATE(trans_date) BETWEEN DATE("'.$from_date.'") AND DATE("'.$to_date.'")');
            $data['beginningamount']->whereRaw('DATE(trans_date) BETWEEN DATE("'.$from_date.'") AND DATE("'.$to_date.'")');
            $data['beginning']->whereRaw('DATE(trans_date) BETWEEN DATE("'.$from_date.'") AND DATE("'.$to_date.'")');
            $data['ending']->whereRaw('DATE(trans_date) BETWEEN DATE("'.$from_date.'") AND DATE("'.$to_date.'")');
            $data['printbetweendate']->whereRaw('DATE(trans_date) BETWEEN DATE("'.$from_date.'") AND DATE("'.$to_date.'")');
        }
        $data['qty'] = $data['qty']->get();
        $data['scdiscount'] = $data['scdiscount']->get();
        $data['beginningamount'] = $data['beginningamount']->get();
        $data['beginning'] = $data['beginning']->min('trans_no');
        $data['ending'] = $data['ending']->max('trans_no');
        $data['printbetweendate'] = $data['printbetweendate']->get();
        $data['date_from'] = $from_date;
        $data['date_to'] = $to_date;

        $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => [80, 236]]);
        $content = view('print.zreading')->with($data);
        $mpdf->WriteHTML($content);
        $mpdf->Output(); 
    }
    public function Between($from_date, $to_date)
    {   
            $data['betweendate'] = DB::table('pssh')->select('*')
            ->whereRaw('DATE(trans_date) BETWEEN DATE("'.$from_date.'") AND DATE("'.$to_date.'")')
            ->get();
            return $data;
        
    }
    public function BetweenName($from_date, $to_date, $id)
    {   
            $data['betweenname'] = DB::table('pssh')->select('*')
            ->whereRaw('DATE(trans_date) BETWEEN DATE("'.$from_date.'") AND DATE("'.$to_date.'")')
            ->where('pssh.create_id',  $id)
            ->get();
            return $data;
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['user'] = DB::table('user')->select('*')->where('user.user_type', 'Cashier')->get();
        $data['term'] = DB::table('term')->select('*')->get();
        return $data;
    }
    
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
    public function Select()
    {
        $data['comr'] = DB::table('comr')->select('*')->get();
        $data['brmr'] = DB::table('brmr')->select('*')->get();
        $data['whmr'] = DB::table('whmr')->select('*')->get();
        return $data;
    }
}
