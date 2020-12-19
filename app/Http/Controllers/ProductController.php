<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Products;
use App\Models\Review;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function showProduct($category_slug, $product_slug) {
        $category = Category::where('slug', $category_slug)->where('state', 1)->first();
        if ($category) {
            $product = Products::where('slug', $product_slug)->where('category_id', $category->id)->where('state', 1)->first();
            if ($product){
                $reviews = Review::where('product_id', $product->id)->where('state', 1)->orderBy('id', 'desc')->paginate(10);
                return view('product', compact('product', 'category', 'reviews'));
            }else { return view('errors.404'); }
        }else { return view('errors.404'); }
    }

    public function addToCart(Request $request){

        if (request()->has('add_to_cart')){
            if (Auth::check()){
                // USER LOGGED IN
                $product = Products::where('code', $request->code)->first();
                if ($product){
                    if ($product->stock > 0){
                        $product = [
                            'code' => $request->code,
                            'color' => $request->color,
                            'size' => $request->size,
                            'quantity' => $request->quantity
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
                                if ($products[$i]['code'] == $request->code && $products[$i]['color'] == $request->color && $products[$i]['size'] == $request->size){
                                    $products[$i]['quantity'] += $request->quantity;
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
                $product = Products::where('code', $request->code)->first();
                if ($product){
                    if ($product->stock > 0){
                        $product = [
                            'code' => $request->code,
                            'color' => $request->color,
                            'size' => $request->size,
                            'quantity' => $request->quantity
                        ];
                        if (session()->has('cart')){
                            // CART ALREADY SETTED
                            $products = json_decode(session()->get('cart'), true);
                            $addtoarray = true;
                            for ($i=0; $i < count($products); $i++) {
                                if ($products[$i]['code'] == $request->code && $products[$i]['color'] == $request->color && $products[$i]['size'] == $request->size){
                                    $products[$i]['quantity'] += $request->quantity;
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
        }else if (request()->has('add_to_wishlist')){
            if (Auth::check()){
                // USER LOGGED IN
                $product = Products::where('code', $request->code)->first();
                if ($product){
                    if ($product->stock > 0){
                        $product = [
                            'code' => $request->code,
                            'color' => $request->color,
                            'size' => $request->size,
                            'quantity' => $request->quantity
                        ];
                        $wishlist = Wishlist::where('user_id', Auth::user()->id)->first();
                        if (!$wishlist){
                            $products = [];
                            array_push($products, $product);
                            Wishlist::create([
                                'user_id' => Auth::user()->id,
                                'code' => Str::random(15),
                                'content' => json_encode($products)
                            ]);
                            return redirect()->back();
                        }else {
                            $products = json_decode($wishlist->content, true);
                            $addtoarray = true;
                            for ($i=0; $i < count($products); $i++) {
                                if ($products[$i]['code'] == $request->code && $products[$i]['color'] == $request->color && $products[$i]['size'] == $request->size){
                                    $products[$i]['quantity'] += $request->quantity;
                                    $addtoarray = false;
                                }
                            }
                            if ($addtoarray){
                                array_push($products, $product);
                            }
                            $wishlist->update([
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
                $product = Products::where('code', $request->code)->first();
                if ($product){
                    if ($product->stock > 0){
                        $product = [
                            'code' => $request->code,
                            'color' => $request->color,
                            'size' => $request->size,
                            'quantity' => $request->quantity
                        ];
                        if (session()->has('wishlist')){
                            // CART ALREADY SETTED
                            $products = json_decode(session()->get('wishlist'), true);
                            $addtoarray = true;
                            for ($i=0; $i < count($products); $i++) {
                                if ($products[$i]['code'] == $request->code && $products[$i]['color'] == $request->color && $products[$i]['size'] == $request->size){
                                    $products[$i]['quantity'] += $request->quantity;
                                    $addtoarray = false;
                                }
                            }
                            if ($addtoarray){
                                array_push($products, $product);
                            }
                            session()->put('wishlist', json_encode($products));
                            session()->save();
                            return redirect()->back();
                        }else {
                            // CREATE CART SESSION
                            $products = [];
                            array_push($products, $product);
                            session()->put('wishlist', json_encode($products));
                            session()->put('wishlistid', Str::random(15));
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
    public function makeReview(Request $request){
        $path = explode('/', $request->path());
        $categoryslug = $path[0];
        $productslug = $path[1];
        if (Auth::check()){
            $cart = Cart::where('user_id', Auth::user()->id)->where('state', 4)->first();
            if ($cart){
                $content = json_decode($cart->content);
                $buyed = false;
                foreach ($content as $item ) {
                    $product = Products::where('code', $item->code)->where('slug', $productslug)->first();
                    if ($product) { $buyed = true; }
                }
                if ($buyed){
                    $review = Review::create([
                        'product_id' => $product->id,
                        'name' => $request->name,
                        'email' => $request->email,
                        'title' => $request->rev_title,
                        'comment' => $request->rev_comment,
                        'rate' => $request->rate
                    ]);
                    if ($review){
                        return redirect()->back()->with(['message' => 'Değerlendirmeniz başarıyla yapıldı!', 'messageType' => 'success']);
                    }else {
                        return redirect()->back()->with(['message' => 'Değerlendirme yaparken hata oluştu!', 'messageType' => 'danger']);
                    }
                }else {
                    return redirect()->back()->with(['message' => 'Değerlendirme yapabilmek için ürünü satın almış olmalısınız!', 'messageType' => 'danger']);
                }
            }else {
                return redirect()->back()->with(['message' => 'Değerlendirme yapabilmek için ürünün size ulaşması gerekmektedir!', 'messageType' => 'danger']);
            }
        }else{
            return redirect()->back()->with(['message' => 'Değerlendirme yapabilmek için giriş yapmış olmalısınız!', 'messageType' => 'danger']);
        }


    }
}
