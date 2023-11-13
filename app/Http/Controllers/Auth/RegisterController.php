<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Company;
// use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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
            'designation' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'signature' => ['required'],
            'company' => ['required', 'string', 'max:255'],
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
        $newSignatureName = $data['name'] . '-' . $data['email'] . '.' . $data['signature']->extension();
        $data['signature']->move(public_path('signatures'), $newSignatureName);

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'designation' => $data['designation'],
            'department' => $data['department'],
            'signature' => $newSignatureName,
            'company' => $data['company'],
            'password' => $data['password'],
        ]);
    }

    public function getCompany()
    {
        $companiesData['companies'] = DB::table('companies')->get();
        $DepartmentsData['departments'] = DB::table('departments')->get();
        return view('auth.register', $companiesData, $DepartmentsData);
    }
}
