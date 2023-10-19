<?php

namespace App\Http\Controllers\Client;

use App\Client;
use App\Http\Controllers\Controller;
use App\Mail\ForgotPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function __construct()
    {
        Auth::setDefaultDriver('client');
        config(['auth.defaults.passwords' => 'client']);
    }
    public function register(Request $request)
    {
        return view('client.auth.register');
    }

    public function registerHandle(Request $request)
    {
        // dd(config(['auth.defaults.passwords' => 'client']));
        // dd($request->all());
        $data = $request->validate([
            'name' => 'required',
            'password' => 'required|min:5',
            'email' => 'required|email|unique:clients'
        ]);
        $data['password'] = Hash::make($data['password']);
        $data = Client::create($data);
        return view('client.auth.login');
    }

    public function login(Request $request)
    {
        if(Auth::guard('client')->check()){
            return redirect()->route('client.home');;
        }
        return view('client.auth.login');
    }

    public function loginHandle(Request $request)
    {
        $data = $request->validate([
            'password' => 'required|min:5',
            'email' => 'required|email'
        ]);
        $check = Client::where(['email' => $data['email']])->first();

        if (!empty($check)) {
            if (Hash::check($data['password'], $check->password)) {
                Auth::guard('client')->login($check);
                if (Auth::guard('client')->check()) {
                    return redirect()->route('client.home');
                }
            } else {
                
            }
        } else {
            
        }
    }

    public function logout()
    {
        if(Auth::guard('client')->check()){
            Auth::guard('client')->logout();
        }
        return redirect()->to(route('client.login'));
    }

    public function forgotPassword(Request $request)
    {
        return view('client.auth.forgot_password');
    }

    public function forgotPasswordHandle(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|exists:clients'
        ]);
        $random = Str::random(20);
        Cookie::queue('change_password', $random, 5);
        Cookie::queue('email_change_password', $data['email'], 5);
        Mail::to($data['email'])->send(new ForgotPassword(['random' => $random]));
        return redirect(route('client.forgot_password'))->with('success', true);
    }

    public function changePassword(Request $request)
    {
        if($request->cookie('change_password') != $request->crypt){
            return redirect()->route('client.home');
        }
        return view('client.auth.change_password');
    }

    public function changePasswordHandle(Request $request)
    {
        $data = $request->validate([
            'password' => 'required|min:5|confirmed',
        ]);
        Client::where('email', $request->cookie('email_change_password'))->update(['password' => Hash::make($data['password'])]);
        return redirect()->route('client.login');
    }
}
