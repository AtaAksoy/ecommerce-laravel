<?php

namespace App\Http\Controllers;

use App\Mail\Customer\CreatedBySystem;
use App\Mail\Order\OrderSuccess;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Discount;
use App\Models\Products;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Iyzipay\Model\Address;
use Iyzipay\Model\BasketItem;
use Iyzipay\Model\BasketItemType;
use Iyzipay\Model\Buyer;
use Iyzipay\Model\CheckoutFormInitialize;
use Iyzipay\Model\Currency;
use Iyzipay\Model\Locale;
use Iyzipay\Model\PaymentGroup;
use Iyzipay\Options;
use Iyzipay\Request\CreateCheckoutFormInitializeRequest;

class CheckoutController extends Controller
{
    public function index() {
        if (\App\Http\Controllers\CartController::getCart()){
            $cart = \App\Http\Controllers\CartController::getCart();
            return view('checkout', compact('cart'));
        }else {
            return redirect()->route('index')->with(['message' => 'Lütfen sepetinize ürün ekleyin!', 'messageType' => 'warning']);
        }
    }

    public function createAnAccount($email, $name, $password, $address, $phone){
        $newpwd = Hash::make($password);
        $check = Customer::where('email', $email)->first();
        if (!$check){
            $customer = Customer::create([
                'email' => $email,
                'name' => $name,
                'password' => $newpwd,
                'token' => Str::random(30),
                'address' => $address,
                'phone' => $phone
            ]);
            if ($customer) {
                $mail = Mail::to($email)->send(new CreatedBySystem($customer, $password));
                Auth::logout();
                Auth::login($customer);
                return true;
            }else {
                return false;
            }
        }else{return false;}
    }

    public function updateStock($id, $stock) {
        $update = Products::where('id', $id)->update([ 'stock' => $stock ]);
        if ($update) { return true; }else { return false; }
    }

    public function checkOutCheck() {
        $options = new \Iyzipay\Options();
        $options->setApiKey(config('app.iyzico_api_key'));
        $options->setSecretKey(config('app.iyzico_secret_key'));
        $options->setBaseUrl(config('app.iyzico_base_url'));
        $request = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setToken($_POST['token']);
        $checkoutForm = \Iyzipay\Model\CheckoutForm::retrieve($request, $options);
        $status = $checkoutForm->getStatus();
        $basketId = $checkoutForm->getBasketId();
        if ($status == "success"){
            // SUCCESS
            $cart = Cart::where('code', $basketId)->where('state', 0)->first();
            $update = Cart::where('code', $basketId)->where('state', 0)->update(['state' => 1]);
            $items = json_decode($cart->content);
            $products = [];
            foreach ($items as $item ) {
                $product = Products::where('code', $item->code)->first();
                $this->updateStock($product->id, ($product->stock - $item->quantity));
                $checkdiscount = Discount::where('product_id', $product->id)->where('state', 1)->first();
                if ($checkdiscount){
                    $product->discount_type = $checkdiscount->type;
                    $product->discount_value = $checkdiscount->value;
                }else {
                    $checkdiscount = Discount::where('category_id', $product->category_id)->where('state', 1)->first();
                    if ($checkdiscount && $product->discount_type == null){
                        $product->discount_type = $checkdiscount->type;
                        $product->discount_value = $checkdiscount->value;
                    }
                }
                if ($product->discount_type != null){
                    $discount = true;
                    if ($product->discount_type == 'percent'){
                        $price = ($product->price - ( ($product->discount_value / 100) * $product->price ));
                    }else{
                        $price = ($product->price - $product->discount_value);
                    }
                }else{
                    $price = $product->price;
                }
                $data = [
                    'name' => $product->name,
                    'code' => $item->code,
                    'size' => $item->size,
                    'color' => $item->color,
                    'price' => $price,
                    'quantity' => $item->quantity
                ];
                array_push($products, $data);
            }
            $purchase = Purchase::create([
                'code' => Str::random(15),
                'content' => json_encode($products),
                'user_id' => $cart->user_id,
                'address' => session()->get('orderaddress')
            ]);
            $customer = Customer::where('id', $cart->user_id)->first();
            $mail = Mail::to($customer->email)->send(new OrderSuccess($customer, $purchase));
            return redirect()->route('ordersuccess', $purchase->code);
        }else {
            return redirect()->route('checkout')->with(['message' => 'Satın alırken hata oluştu! Lütfen bakiyenizi kontrol ediniz, veya bankanızla iletişime geçin!', 'messageType' => 'danger']);
        }
    }

    public function viewPurchasePage($code) {
        if (Auth::check()){
            $purchase = Purchase::where('code', $code)->where('user_id', Auth::user()->id)->first();
            if (!$purchase){return redirect()->route('authenticate.login')->with(['message' => 'Siparişiniz bulunamadı!', 'messageType' => 'danger']);}
            $user = Customer::where('id', $purchase->user_id)->first();
            return view('order_check', compact('purchase', 'user'));
        }
        return redirect()->route('authenticate.login')->with(['message' => 'Bu işlem için giriş yapmalısınız!', 'messageType' => 'danger']);
    }
    public function checkOut(Request $request){
        if (!Auth::check()){
            $check = Customer::where('email', request('email'))->first();
            if (!$check){
                if (\App\Http\Controllers\CartController::getCart()){
                    $cart = \App\Http\Controllers\CartController::getCart();
                    $options = new Options();
                    $options->setApiKey(config('app.iyzico_api_key'));
                    $options->setSecretKey(config('app.iyzico_secret_key'));
                    $options->setBaseUrl(config('app.iyzico_base_url'));

                    $request = new CreateCheckoutFormInitializeRequest();
                    $request->setLocale(Locale::TR);
                    $request->setConversationId(session()->get('cartid'));
                    $request->setCurrency(Currency::TL);
                    $request->setBasketId(session()->get('cartid'));
                    $request->setPaymentGroup(PaymentGroup::PRODUCT);
                    $request->setCallbackUrl(config('app.iyzico_callback_url'));
                    $request->setEnabledInstallments(array(2, 3, 6, 9));
                    $address = request('address').' '.request('mahalle').' '.request('city').' '.request('postcode');
                    session()->put('orderaddress', $address);
                    if (!Auth::check()){

                        if ($this->createAnAccount(request('email'), request('firstname').' '.request('lastname'), Str::random(8), $address, request('phone'))){
                            $create = Cart::create([
                                'user_id' => Auth::user()->id,
                                'code' => session()->get('cartid'),
                                'content' => session()->get('cart'),
                            ]);
                        }else{ return redirect()->back()->with(['message' => 'Hesabınız oluşturulamadı!', 'messageType' => 'danger']); }
                    }else {
                        $update = Customer::where('id', Auth::user()->id)->update(['address' => $address]);
                    }
                    $buyer = new Buyer();
                    $buyer->setId(Auth::user()->id);
                    $buyer->setName(request('firstname'));
                    $buyer->setSurname(request('lastname'));
                    $buyer->setGsmNumber(request('phone'));
                    $buyer->setEmail(request('email'));
                    $buyer->setIdentityNumber("74300864791");
                    $buyer->setLastLoginDate("2015-10-05 12:43:35");
                    $buyer->setRegistrationDate("2013-04-21 15:12:09");
                    $buyer->setRegistrationAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
                    $buyer->setIp("85.34.78.112");
                    $buyer->setCity(request('city'));
                    $buyer->setCountry("Turkey");
                    $buyer->setZipCode(request('postcode'));
                    $request->setBuyer($buyer);

                    $shippingAddress = new Address();
                    $shippingAddress->setContactName(Auth::user()->name);
                    $shippingAddress->setCity(request('city'));
                    $shippingAddress->setCountry("Turkey");
                    $shippingAddress->setAddress(request('address'));
                    $shippingAddress->setZipCode(request('postcode'));
                    $request->setShippingAddress($shippingAddress);

                    $billingAddress = new Address();
                    $billingAddress->setContactName(Auth::user()->name);
                    $billingAddress->setCity(request('city'));
                    $billingAddress->setCountry("Turkey");
                    $billingAddress->setAddress(request('address'));
                    $billingAddress->setZipCode(request('postcode'));
                    $request->setBillingAddress($billingAddress);

                    $basketItems = array();
                    $totalprice = 0;
                    for ($i=0; $i < count($cart); $i++) {
                        $firstBasketItem = new BasketItem();
                        $firstBasketItem->setId($cart[$i]->id);
                        $firstBasketItem->setName($cart[$i]->name);
                        $firstBasketItem->setCategory1($cart[$i]->category_slug);
                        $firstBasketItem->setItemType(BasketItemType::PHYSICAL);
                        if ($cart[$i]->discount_type != null){
                            $discount = true;
                            if ($cart[$i]->discount_type == 'percent'){
                                $price = ($cart[$i]->price - ( ($cart[$i]->discount_value / 100) * $cart[$i]->price ));
                            }else{
                                $price = ($cart[$i]->price - $cart[$i]->discount_value);
                            }
                        }else{
                            $price = $cart[$i]->price;
                        }
                        $firstBasketItem->setPrice(($price * $cart[$i]->quantity));
                        $totalprice += ($price * $cart[$i]->quantity);
                        $basketItems[$i] = $firstBasketItem;
                    }
                    $request->setBasketItems($basketItems);
                    $request->setPrice($totalprice);
                    $request->setPaidPrice($totalprice);
                    $checkoutFormInitialize = CheckoutFormInitialize::create($request, $options);
                    return view('checkout', compact('cart', 'checkoutFormInitialize'));
                }else{
                    return redirect()->back()->with(['message' => 'Sepetiniz boş gözüküyor!', 'messageType' => 'danger']);
                }
            }else {
                return redirect()->route('checkout')->with(['message' => 'Kullanmış olduğunuz mail adresi kullanılmakta, lütfen giriş yapın veya başka bir mail adresi deneyin!', 'messageType' => 'danger']);
            }
        }

    }

}
