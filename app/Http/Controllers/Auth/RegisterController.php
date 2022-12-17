<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;

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
    protected $redirectTo = '/home';

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
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'mobileno' => ['required', 'unique:users', 'numeric', 'min:10'],
            'account_type' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        # Generate 6 letters key
        $key = mt_rand(100000, 999999);
        # Make capital letter after space
        $nameCapital = ucwords($data['name']);
        # Replace empty with '_'
        $name = str_replace(' ', '_', $nameCapital);

        return User::create([
            'uuid' => (string) Str::uuid(),
            'name' => $data['name'],
            'code' => strtolower($name.'_'.$key),
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'mobileno' => $data['mobileno'],
            'account_type' => $data['account_type'],
            'status' => 0,
            'api_token' => str_random(60),
        ]);
    }
}