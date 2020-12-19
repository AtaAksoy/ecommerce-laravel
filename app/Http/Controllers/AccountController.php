<?php

namespace App\Http\Controllers;

use App\Mail\Customer\ForgotPassword;
use App\Models\Customer;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AccountController extends Controller
{
    public function checkLogin() {
        if (Auth::check()){
            return true;
        }else {
            return false;
        }
    }
    public function dashboard() {
        if ($this->checkLogin()){
            $newsletter = Newsletter::where('email', Auth::user()->email)->first();
            return view('account.dashboard', compact('newsletter'));
        }else {
            return redirect()->route('authenticate.login')->with(['messageType' => 'warning', 'message' => 'Bu sayfayı görüntüleyebilmek için giriş yapmalısınız!']);
        }
    }

    public function indexPost(Request $request) {
        if(request()->has('updateContact')){
            Customer::where('id', Auth::user()->id)->update(['name' => $request->name]);
            return redirect()->back();
        }elseif (request()->has('updateNewsletter')) {
            if ($request->newsletter == 'on'){
                $check = Newsletter::where('email', Auth::user()->email)->first();
                if (!$check){
                    Newsletter::create(['email' => Auth::user()->email]);
                }
            }else{
                try {
                    Newsletter::where('email', Auth::user()->email)->delete();
                } catch (\Throwable $th) {
                }
            }
            return redirect()->back();
        }elseif (request()->has('updateAddress')){
            Customer::where('id', Auth::user()->id)->update(['address' => $request->address]);
            return redirect()->back();
        }
    }

    public function changePassword() {
        if (Auth::check()){
            $customer = Customer::where('id', Auth::user()->id)->first();
            Customer::where('id', Auth::user()->id)->update(['reset_password_state' => 1]);
            if ($customer){
                // CUSTOMER BULUNMADI HATASI ALIYOSUN
                $mail = Mail::to(Auth::user()->email)->send(new ForgotPassword($customer));
                if (!Mail::failures()){
                    try {
                        $customer = Customer::where('email', request('forgot_email'))->update(['reset_password_state' => 1]);
                    } catch (\Throwable $th) {
                        return redirect()->route('customer.forgetpassword')->with('message', 'Please try again later!')->with('messageType', 'danger');
                    }
                    return redirect()->route('account.dashboard')->with('message', 'Şifre yenileme bağlantısı e-posta adresinize gönderildi!')->with('messageType', 'success');
                }else {
                    return redirect()->route('customer.forgetpassword')->with('message', 'Please try again later!')->with('messageType', 'danger');
                }
            }else {
                return redirect()->route('account.dashboard')->with('message', 'Şifre yenileme bağlantısı e-posta adresinize gönderildi!')->with('messageType', 'success');
            }
        }else {
            return redirect()->route('authenticate.login')->with(['messageType' => 'warning', 'message' => 'Bu sayfayı görüntüleyebilmek için giriş yapmalısınız!']);
        }
    }
}
