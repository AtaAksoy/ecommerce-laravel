<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Products;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class WishlistController extends Controller
{
    public static function getWishlist() {
        if (Auth::check()){
            $wishlist = Wishlist::where('user_id', Auth::user()->id)->first();
        }else{
            $wishlist = session()->get('wishlist');
        }
        if ($wishlist){
            $contents = [];
            if (Auth::check()){ $products = json_decode($wishlist->content); session()->put('wishlistcode', $wishlist->code);}
            else { $products = json_decode($wishlist); }
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
        if ($this->getWishlist()){
            $totalprice = 0;
            $contents = $this->getWishlist();
            return view('wishlist', compact('contents', 'totalprice'));
        }else {
            return redirect()->route('search')->with(['message' => 'Liste içeriğini görebilmek için lütfen listenize ürün ekleyin!', 'messageType' => 'warning']);
        }
    }

    public function removeFromList($code) {
        if ($this->getWishlist()){
            $content = json_decode(session()->get('wishlist'));
            foreach ($content as $item => $product) {
                if ($product->code == $code){
                    unset($content[$item]);
                }
            }
            session()->put('wishlist', json_encode($content));
            session()->save();
        }
        return redirect()->route('wishlist');
    }
    public function addToCart($code) {
        if ($this->getWishlist()){
            $content = json_decode(session()->get('wishlist'));
            foreach ($content as $cart => $item) {
                if (Auth::check()){
                    // USER LOGGED IN
                    $product = Products::where('code', $item->code)->first();
                    if ($product){
                        if ($product->stock > 0){
                            $product = [
                                'code' => $item->code,
                                'color' => $item->color,
                                'size' => $item->size,
                                'quantity' => $item->quantity
                            ];
                            $cart = Cart::where('user_id', Auth::user()->id)->where('state', 0)->first();
                            if (!$cart){
                                $products = [];
                                array_push($products, $product);
                                Cart::create([
                                    'user_id' => Auth::user()->id,
                                    'code' => Str::random(15),
                                    'content' => json_encode($products)
                                ]);
                                return redirect()->back();
                            }else {
                                $products = json_decode($cart->content, true);
                                $addtoarray = true;
                                for ($i=0; $i < count($products); $i++) {
                                    if ($products[$i]['code'] == $item->code && $products[$i]['color'] == $item->color && $products[$i]['size'] == $item->size){
                                        $products[$i]['quantity'] += $item->quantity;
                                        $addtoarray = false;
                                    }
                                }
                                if ($addtoarray){
                                    array_push($products, $product);
                                }
                                $cart->update([
                                    'content' => json_encode($products)
                                ]);
                                return redirect()->back();
                            }
                        }else{
                            return redirect()->back()->with(['message' => 'Bu ürün tükenmiştir!', 'messageType' => 'warning']);
                        }
                    }else {
                        return redirect()->back()->with(['message' => 'Hatalı ürün kodu, lütfen sayfayı yeniden yüklemeyi deneyin!', 'messageType' => 'danger']);
                    }
                }else {
                    // ANONYMOUS
                    $product = Products::where('code', $item->code)->first();
                    if ($product){
                        if ($product->stock > 0){
                            $product = [
                                'code' => $item->code,
                                'color' => $item->color,
                                'size' => $item->size,
                                'quantity' => $item->quantity
                            ];
                            if (session()->has('cart')){
                                // CART ALREADY SETTED
                                $products = json_decode(session()->get('cart'), true);
                                $addtoarray = true;
                                for ($i=0; $i < count($products); $i++) {
                                    if ($products[$i]['code'] == $item->code && $products[$i]['color'] == $item->color && $products[$i]['size'] == $item->size){
                                        $products[$i]['quantity'] += $item->quantity;
                                        $addtoarray = false;
                                    }
                                }
                                if ($addtoarray){
                                    array_push($products, $product);
                                }
                                session()->put('cart', json_encode($products));
                                session()->save();
                                return redirect()->back();
                            }else {
                                // CREATE CART SESSION
                                $products = [];
                                array_push($products, $product);
                                session()->put('cart', json_encode($products));
                                session()->put('cartid', Str::random(15));
                                return redirect()->back();
                            }

                        }else {
                            return redirect()->back()->with(['message' => 'Bu ürün tükenmiştir!', 'messageType' => 'warning']);
                        }
                    }else {
                        return redirect()->back()->with(['message' => 'Hatalı ürün kodu, lütfen sayfayı yeniden yüklemeyi deneyin!', 'messageType' => 'danger']);
                    }
                }
            }
        }
    }
}
