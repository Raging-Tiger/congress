<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(25);
        return view('users/admin_users', ['users' => $users]);
    }

    public function search(Request $request)
    {
           //dd($users);

        if($request->get('search')!= NULL)
        {
            return DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->leftJoin('names', 'users.name_id', '=', 'names.id')
            ->leftJoin('companies', 'users.company_id', '=', 'companies.id')
            ->select('users.name as login', 'users.email', 'names.name', 'names.surname', 'companies.name as companyName',
                    'users.id', 'roles.name as roleName' )
            ->where('names.name', 'LIKE', '%'.$request->get('search').'%')
            ->orWhere('names.surname', 'LIKE', '%'.$request->get('search').'%')
            ->orWhere('companies.name', 'LIKE', '%'.$request->get('search').'%')
            ->get();
           //return User::where('name', 'LIKE', '%'.$request->get('search').'%')->get(); 
        }
        
    
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
        $roles = Role::all();
        $roles_list = $roles->pluck('name', 'id');
        
        
        $user = User::where('id', $id)->first();
        return view('users/admin_edit_user', ['user' => $user, 'roles' => $roles_list]);

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
        $user = User::where('id', $id)->first();
        
        $user->role_id=$request->role;
        $user->save();
      
      return redirect()->action('App\Http\Controllers\UserController@index');
    }

}
