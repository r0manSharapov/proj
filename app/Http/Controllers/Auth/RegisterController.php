<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use http\Env\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
            'nif' => ['nullable','numeric', 'digits:9','unique:users'],
            'telefone' => ['nullable','numeric', 'digits:9','unique:users'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
            'foto' => ['nullable'],
        ]);
    }

//    public function store(Request $request){
//        if(hasFile('foto')){
//            $path = foto->store('public/fotos');
//            basename($path);
//        }
//        return basename
//    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        if(\request()->hasFile('foto')){
            $path = \request()->foto->store('public/fotos');
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'nif' => $data['nif'],
            'telefone' => $data['telefone'],
            'foto' => basename($path),
            'password' => Hash::make($data['password']),
        ]);
    }
}
