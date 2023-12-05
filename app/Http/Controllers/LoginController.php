<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function showLoginForm(){
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ];
        $customeMessages = [
            'email.required' => 'Email tidak boleh kosong!!!',
            'email.email' => 'Email tidak sesuai format!!!',
            'password.required' => 'Password tidak boleh kosong!!!',
        ];
        $this->validate($request, $rules, $customeMessages);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('authuser')->attempt($credentials)) {
            $user = Auth::guard('authuser')->user();

            // Check user role and redirect accordingly
            switch ($user->role->role_id) {
                case 1: // Admin
                    Session::flash('success_message', 'Berhasil Login');
                    return redirect()->route('periode');
                default:
                    Session::flash('error_message', 'Anda tidak memiliki akses.');
                    return redirect()->back();
                    break;
            }
        } else {
            return redirect()->back()->with("error_message", "Email atau Password tidak sesuai. Silahkan masukan data dengan benar!!!!!");
        }
    }

    public function logout()
    {
        Auth::guard('authuser')->logout();
        Session::flash('success_message_logout', 'Berhasil Logout');
        return redirect()->route('login');
    }
}