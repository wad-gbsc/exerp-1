<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Acbw;
use App\Models\Lpwd;
use Illuminate\Http\Request;
use App\Http\Resources\Reference;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
use Hash;

class UserAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['users'] = User::select(
                    'user.user_hash',
                    'user.username',
                    'user.fullname',
                    'acbw.company_access',
                    'acbw.branch_access',
                    'acbw.warehouse_access',
                    'comr.co_code',
                    'brmr.br_code',
                    'whmr.wh_code'
        )
                    ->leftJoin('acbw', 'acbw.username', '=', 'user.username')
                    ->leftJoin('comr', 'comr.comr_hash', '=', 'acbw.company_access')
                    ->leftJoin('brmr', 'brmr.brmr_hash', '=', 'acbw.branch_access')
                    ->leftJoin('whmr', 'whmr.whmr_hash', '=', 'acbw.warehouse_access')
                    ->where('user.is_deleted', 0)
                    ->get();

        $data['company'] = DB::table('comr')->select('*')->get();
        $data['branch'] = DB::table('brmr')->select('*')->get();
        $data['ware'] = DB::table('whmr')->select('*')->get();

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
            'fullname' => 'required|regex:/^[a-zA-Z\s]+$/',
            'username' => 'required',
            'password' => 'required',
            'company_access' => 'required',
            'branch_access' => 'required',
            'warehouse_access' => 'required',

        ]
        )->validate();

        $user = new User();
        $user->fullname = $request->input('fullname');
        $user->username = $request->input('username');
        $user->password = Hash::make($request['password']);
        $user->create_date = Carbon::now();
        $user->create_id = Auth::user()->user_hash;
        $user->save();

        $lpwd = new Lpwd();
        // $lpwd->user_hash = $user->user_hash;
        $lpwd->fullname = $request->input('fullname');
        $lpwd->username = $request->input('username');
        $lpwd->password = $request->input('password');
        $lpwd->save();

        $acbw = new Acbw();
        // $acbw->user_hash = $user->user_hash;
        $acbw->username = $request->input('username');
        $acbw->company_access = $request->input('company_access');
        $acbw->branch_access = $request->input('branch_access');
        $acbw->warehouse_access = $request->input('warehouse_access');
        $acbw->save();

    //return json based from the resource data
    $data['users'] = User::select(
        'user.user_hash',
        'user.username',
        'user.fullname',
        'acbw.company_access',
        'acbw.branch_access',
        'acbw.warehouse_access',
        'comr.co_code',
        'brmr.br_code',
        'whmr.wh_code'
)
        ->leftJoin('acbw', 'acbw.username', '=', 'user.username')
        ->leftJoin('comr', 'comr.comr_hash', '=', 'acbw.company_access')
        ->leftJoin('brmr', 'brmr.brmr_hash', '=', 'acbw.branch_access')
        ->leftJoin('whmr', 'whmr.whmr_hash', '=', 'acbw.warehouse_access')
        ->where('user.is_deleted', 0)
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
        $data['users'] = User::select(
            'user.user_hash',
            'user.username',
            'user.fullname',
            'acbw.company_access',
            'acbw.branch_access',
            'acbw.warehouse_access',
            'comr.co_code',
            'brmr.br_code',
            'whmr.wh_code'
)
            ->leftJoin('acbw', 'acbw.username', '=', 'user.username')
            ->leftJoin('comr', 'comr.comr_hash', '=', 'acbw.company_access')
            ->leftJoin('brmr', 'brmr.brmr_hash', '=', 'acbw.branch_access')
            ->leftJoin('whmr', 'whmr.whmr_hash', '=', 'acbw.warehouse_access')
            ->where('user.is_deleted', 0)
            ->findOrFail($id);

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
        Validator::make($request->all(),
        [
            'fullname' => 'required|regex:/^[a-zA-Z\s]+$/',
            'company_access' => 'required',
            'branch_access' => 'required',
            'warehouse_access' => 'required',

        ]
        )->validate();

        $data['user'] = User::findOrFail($id);
        $data['user']->fullname = $request->input('fullname');
        $data['user']->username = $request->input('username');
        $data['user']->password = Hash::make($request['password']);
        $data['user']->create_date = Carbon::now();
        $data['user']->create_id = Auth::user()->user_hash;
        $data['user']->save();

        $data['lpwd'] = Lpwd::findOrFail($id);
        $data['lpwd']->fullname = $request->input('fullname');
        $data['lpwd']->username = $request->input('username');
        $data['lpwd']->password = $request->input('password');
        $data['lpwd']->save();

        $data['acbw'] = Acbw::findOrFail($id);
        $data['acbw']->username = $request->input('username');
        $data['acbw']->company_access = $request->input('company_access');
        $data['acbw']->branch_access = $request->input('branch_access');
        $data['acbw']->warehouse_access = $request->input('warehouse_access');
        $data['acbw']->save();

        return ( new Reference( $data ) )
        ->response()
        ->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {   
        $user = User::findOrFail($id);

        $user->is_deleted = 1;
        // $user->deleted_datetime = Carbon::now();
        // $user->deleted_by = Auth::user()->user_id;

        //update classification based on the http json body that is sent
        $user->save();

        return ( new Reference( $user ) )
            ->response()
            ->setStatusCode(200);
    }

    public function destroy($id)
    {
        //
    }
}
