<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Core\ConnectionManager;
use Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{

    public function login(Request $request)
    {

        $credentials = array(
            "email" => $request->email, 
            "password" => $request->password,
        );

        $connectionManager = new ConnectionManager(env('API_URL'));
        $out = $connectionManager->stream('/login', 'POST', $credentials, array(), true);
         
        if ($out['dt']['success']) {
            $request->session()->put('token', $out['dt']['token']);
            $request->session()->put('user', $out['dt']['user']['id']);
            $request->session()->put('username', $out['dt']['user']['name']);
            return redirect()->intended('home');
        } else {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }
    }

    public function logout(Request $request){
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/');
    }
    public function showLoginForm(){

        if (Session::get('token')){
            return redirect(route('home'));
        } else {
            return view('auth.login');
        }
    }
}
