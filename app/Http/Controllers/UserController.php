<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
     /**
     * Middleware, setting access control for specified function.
     */
     public function __construct() {
       
        $this->middleware('admin')->only(['index', 'search', 'edit', 'update']);
    } 
    /**
     * Display a listing of all users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(25);
        return view('users/admin_users', ['users' => $users]);
    }

    /**
     * AJAX users search in the database by name, surname, company name or nickname.
     *
     * @param  $request - search query.
     * @return DB query.
     */
    public function search(Request $request)
    {
        /* If query is not empty - avoiding of returning all data */
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
            ->orWhere('users.name', 'LIKE', '%'.$request->get('search').'%')
            ->get();
           //return User::where('name', 'LIKE', '%'.$request->get('search').'%')->get(); 
        }        
    
    }
    
    /**
     * Show the form for editing user role.
     *
     * @param  int  $id - corresponds to the database user ID entry.
     * @return corresponing view.
     */
    public function edit($id)
    {
        $user = User::where('id', $id)->first();
        
        /* If user not exists - abort */
        if($user == NULL)
        {
            abort(404);
        }
       
        $roles;
        
        /* If user is not admin and if not private participant */
        if($user->name_id == NULL && $user->role_id != ADMIN)
        {
            /* Can only have COMMERCIAL or BLOCKED role*/
            $roles = Role::where('id', COMMERCIAL)->orWhere('id', BLOCKED)->get();
        }
        else
        {
            /* Can only have any role, but not COMMERCIAL*/
             $roles = Role::where('id', '!=' , COMMERCIAL)->get();
        }

        $roles_list = $roles->pluck('name', 'id');

        return view('users/admin_edit_user', ['user' => $user, 'roles' => $roles_list]);

    }

    /**
     * Update the specified user role in DB.
     *
     * @param  $request from the form.
     * @param  int  $id - corresponds to the database user ID entry.
     * @return action UserController@index
     */
    public function update(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        
        $user->role_id=$request->role;
        $user->save();
      
      return redirect()->action('App\Http\Controllers\UserController@index');
    }

}
