<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Name;
use App\Models\Company;
use App\Models\Role;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
define('ENABLED_NOTIFICATIONS', 1);
define('PRIVATE_USER', "1");

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        if ($data['userType'] == PRIVATE_USER)
        {
           
            
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'name_id' => Name::create([
                                'name' => $data['PersonName'], 
                                'surname' => $data['PersonSurname'], 
                                'title' => $data['Title'],                 
                                ])->id,
                'email_notifications' => ENABLED_NOTIFICATIONS,
                'role_id' => Role::whereName('Private participant')->firstOrFail()->id,
             ]);
        }
        
        else{
            
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'company_id' => Company::create([
                                    'name' => $data['CompanyName'], 
                                    'country' => $data['CompanyCountry'],  
                                    ])->id,
                'email_notifications' => ENABLED_NOTIFICATIONS,
                'role_id' => Role::whereName('Commercial participant')->firstOrFail()->id,
            ]);
        }
        
    }
}
