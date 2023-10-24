<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use App\Core\ConnectionManager;
use Illuminate\Http\Request;

class RegisterController extends Controller
{

    public function showRegistrationForm(){

        if (Session::get('token')){
            return redirect(route('home'));
        } else {
            return view('auth.register');
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function register(Request $request)
    {
        $data = array(
            "name" => $request->name,
            "email" => $request->email, 
            "password" => $request->password,
            "password_confirmation" => $request->password_confirmation
        );

        $connectionManager = new ConnectionManager(env('API_URL'));
        $out = $connectionManager->stream('/register', 'POST', $data, array(), true);

        if ($out['success']){
            Session::flash('message', 'Register berhasil. Silahkan Login');
            return redirect()->intended('login');

        } else {

            if (isset($out['dt']['email'])){
                return back()->withErrors([
                    'email' => $out['dt']['email'][0],
                ]);
            }

            if (isset($out['dt']['password'])){
                return back()->withErrors([
                    'password' => $out['dt']['password'][0],
                ]);
            }
        }
    }
}
