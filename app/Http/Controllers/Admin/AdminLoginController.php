<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminLoginController extends Controller
{


    public function index() {
        return view('back-end.authenticate.login');
    }

    public function loginForm(Request $request) {
        $userdata = [
            'email' => request('email'),
            'password' => request('password')
        ];
        if (Auth::guard('admins')->attempt($userdata)){
            return redirect()->route('admin.dashboard');
        }else {
            return redirect()->route('admin.login')->with('messageType', 'danger')->with('message', 'Admin can not found!');
        }
    }
}
