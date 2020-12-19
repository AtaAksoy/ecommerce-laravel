<?php

namespace App\Http\Controllers;

use App\Mail\Customer\ForgotPassword;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
class UserController extends Controller
{
    public function loginIndex() {
        if (!Auth::check()){
            return view('authenticate.login');
        }else {
            return redirect()->route('index');
        }
    }
    public function registerIndex() {
        if (!Auth::check()){
            return view('authenticate.register');
        }else {
            return redirect()->route('index');
        }
    }
    public function loginCustomer() {
        $userdata = [
            'email' => request('login_email'),
            'password' => request('login_password')
        ];
        if (Auth::attempt($userdata)){
            return redirect()->intended('/');
        }else {
            return redirect()->route('authenticate.login')->with('messageType', 'danger')->with('message', 'Customer can not found!');
        }
    }
    public function registerCustomer() {
        $customer = Customer::create([
            'email' => request('register_email'),
            'name' => request('register_firstname'). ' '.request('register_lastname'),
            'password' => Hash::make(request('register_password')),
            'token' => Str::random(30)
        ]);
        if ($customer) {
            Mail::to(request('register_email'))->send(new \App\Mail\Customer\NewCustomer);
            Auth::login($customer);
            return redirect()->route('index');
        }else {
            return redirect()->route('authenticate.register')->with('message', 'Failed!')->with('messageType', 'danger');
        }
    }

    public function forgetPassword(){
        return view('authenticate.forget_pwd');
    }
    public function sendResetPasswordMail() {
            $customer = Customer::where('email', request('forgot_email'))->first();
            if ($customer){
                // CUSTOMER BULUNMADI HATASI ALIYOSUN
                $mail = Mail::to(request('forgot_email'))->send(new ForgotPassword($customer));
                if (!Mail::failures()){
                    try {
                        $customer = Customer::where('email', request('forgot_email'))->update(['reset_password_state' => 1]);
                    } catch (\Throwable $th) {
                        return redirect()->route('customer.forgetpassword')->with('message', 'Please try again later!')->with('messageType', 'danger');
                    }
                    return redirect()->route('customer.forgetpassword')->with('message', 'Password Reset Mail Sent To Customer!')->with('messageType', 'success');
                }else {
                    return redirect()->route('customer.forgetpassword')->with('message', 'Please try again later!')->with('messageType', 'danger');
                }
            }else {
                return redirect()->route('customer.forgetpassword')->with('message', 'Password Reset Mail Sent To Customer!')->with('messageType', 'success');
            }

    }

    public function resetPasswordView($reset_token) {
        $customer = Customer::where('token', $reset_token)->where('reset_password_state', 1)->first();
        if ($customer) {
            return view('authenticate.reset_pwd', compact('customer'));
        }else {
            // USER CAN NOT FOUND
            return redirect()->route('authenticate.login')->with('message', 'Customer which password will change can not found !')->with('messageType', 'danger');
        }
    }
    public function resetPassword(Request $request) {
        if (request()->isMethod('POST')){
            if (strlen($request->reset_pwd) < 6 || strlen($request->reset_pwd_repeat) < 6){
                return redirect()->route('customer.resetpassword', $request->token)->with('message', 'Password has to be min 6 characters!')->with('messageType', 'danger'); // send back all errors to the login form
            }
            else
            {
                if ($request->reset_pwd == $request->reset_pwd_repeat){

                    $customer = Customer::where('token', $request->token)->where('reset_password_state', 1)->update([
                        'password' => Hash::make($request->reset_pwd),
                        'reset_password_state' => 0,
                        'token' => Str::random(30)]);
                    if ($customer){
                        return redirect()->route('authenticate.login')->with('message', 'Password changed successfully!')->with('messageType', 'success');
                    }else{
                        return redirect()->route('authenticate.login')->with('message', 'Password change failure!')->with('messageType', 'success');
                    }
                }else {
                    return redirect()->route('customer.resetpassword', $request->token)->with('message', 'Password not match!')->with('messageType', 'danger'); // send back all errors to the login form
                }
            }
        }else {
            return redirect()->route('authenticate.login');
        }
    }

    public function profileIndex() {
        if (Auth::check()){
            return view('authenticate.profile');
        }else {
            return redirect()->route('authenticate.login');
        }
    }
}
