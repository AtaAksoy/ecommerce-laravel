<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function showOrders() {
        $admin = new AdminController();
        if ($admin->checkLogin()){
            $purchases = Purchase::orderBy('id', 'asc')->paginate(10);
            return view('back-end.order.orders', compact('purchases'));
        }else {
            return redirect()->route('admin.login');
        }
    }

    public function showOrder($code) {
        $admin = new AdminController();
        if ($admin->checkLogin()){
            $order = Purchase::where('code', $code)->first();
            $user = Customer::where('id', $order->user_id)->first();
            if ($order){
                return view('back-end.order.order', compact('order', 'user'));
            }else {
                return redirect()->route('admin.orders.show');
            }
        }
    }

    public function updateOrder($code) {
        $order = Purchase::where('code', $code)->first();
        $user = Customer::where('id', $order->user_id)->first();
        if ($order){
            $update = Purchase::where('code', $code)->update(['state' => request('orderState')]);
            if ($update){
                $ordernew = Purchase::where('code', $code)->first();
                $mail = Mail::to($user->email)->send(new \App\Mail\Order\OrderStateUpdate($user, $ordernew));
                return redirect()->route('admin.orders.show');
            }else {
                return redirect()->route('admin.orders.show');
            }
        }else {
            return redirect()->route('admin.orders.show');
        }
    }
}
