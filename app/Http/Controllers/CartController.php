<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

    public static function getCart() {
        if (Auth::check()){
            $cart = Cart::where('user_id', Auth::user()->id)->where('state', 0)->first();
        }else{
            $cart = session()->get('cart');
        }
        if ($cart){
            $contents = [];
            if (Auth::check()){ $products = json_decode($cart->content); session()->put('cartid', $cart->code);}
            else { $products = json_decode($cart); }
            foreach ($products as $product) {
                $content = Products::where('code', $product->code)->where('state' , 1)->first();
                $category = Category::where('id', $content->category_id)->first();
                $content->quantity = $product->quantity;
                $content->size = $product->size;
                $content->category_slug = $category->slug;
                $checkdiscount = Discount::where('product_id', $content->id)->where('state', 1)->first();
                if ($checkdiscount){
                    $content->discount_type = $checkdiscount->type;
                    $content->discount_value = $checkdiscount->value;
                }else {
                    $checkdiscount = Discount::where('category_id', $content->category_id)->where('state', 1)->first();
                    if ($checkdiscount && $content->discount_type == null){
                        $content->discount_type = $checkdiscount->type;
                        $content->discount_value = $checkdiscount->value;
                    }
                }
                array_push($contents, $content);
            }
            return $contents;
        }else {
            return false;
        }
    }
    public function index() {
        if ($this->getCart()) {
            if (!$this->getCart()){
                return redirect()->route('authenticate.login')->with(['message' => 'Lütfen sepetinize ürün ekleyin!', 'messageType' => 'warning']);
            }else {
                $totalprice = 0;
                $contents = $this->getCart();
                return view('cart', compact('contents', 'totalprice'));
            }
        }else {
            return redirect()->route('search')->with(['message' => 'Sepet içeriğini görebilmek için lütfen sepetinize ürün ekleyin!', 'messageType' => 'warning']);
        }
    }

    public function removeFromCart($code){
        $ex = explode('|', $code);
        if ($this->getCart()){
            if (Auth::user()){
                $cart = Cart::where('user_id', Auth::user()->id)->first();
                $content = json_decode($cart->content);
            }else {
                $content = json_decode(session()->get('cart'));
            }
            foreach ($content as $item => $product) {
                if ($product->code == $ex[0] && $product->size == $ex[1]) {
                    unset($content[$item]);
                }
            }
            if (Auth::user()){
                $update = Cart::where('user_id', Auth::user()->id)->update(['content' => json_encode($content)]);
            }else {
                session()->put('cart', json_encode($content));
                session()->save();
            }
            return redirect()->back();
        }
    }
}
