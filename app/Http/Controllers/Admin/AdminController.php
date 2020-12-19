<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Discount;
use App\Models\Products;
use App\Models\Purchase;
use App\Models\Settings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function checkLogin() {
        if (!Auth::guard('admins')->check()){
            return false;
        }else {
            return true;
        }
    }
    public function index() {
        if ($this->checkLogin()) {
            $purchases = Purchase::where('state', '!=', '5')->whereMonth('date', '=', Carbon::now()->subMonth()->month())->get();
            $customers = Customer::whereMonth('create_date', '=', Carbon::now()->subMonth()->month())->get();
            $totalprice = 0;
            foreach ($purchases as $purchase => $item) {
                $content = json_decode($item->content);
                foreach ($content as $product) {
                    $totalprice += $product->price * $product->quantity;
                }
            }
            return view('back-end.index', compact('totalprice', 'customers'));
        }else {
            return redirect()->route('admin.login');
        }
    }
    public function logout(Request $request) {

        Auth::guard('admins')->logout();
        $request->session()->flush();

        $request->session()->regenerate();

        return redirect()->guest(route('admin.login'));

    }

    public function blogCreatePage() {
        if ($this->checkLogin()) {
            return view('back-end.blog.create-post');
        }
    }

    public function blogList() {
        $blogPosts = Blog::orderBy('id', 'desc')->paginate(10);
        return view('back-end.blog.list', compact('blogPosts'));
    }

    public function blogCreate(Request $request) {
        $blogCheck = Blog::where('title', $request->title)->first();
        if (!$blogCheck){
            $validatedData = $request->validate([
                'image' => 'image|max:2048|mimes:jpeg,jpg,png',
            ]);
            if($request->hasFile('image')){ /* resim geldi mi */
                $state = 0;
                if ($request->state == "on") { $state = 1; }
                $imagename = Str::slug($request->title).'.'.$request->image->getClientOriginalExtension();
                $request->image->move(public_path('/assets/images/blog'),$imagename);
                $blog_create = Blog::create([
                    'title' => $request->title,
                    'slug' => Str::slug($request->title),
                    'image' => $imagename,
                    'content' => $request->editor1,
                    'meta_desc' => $request->seo_desc,
                    'state' => $state,
                    'posted_by' => Auth::guard('admins')->user()->name
                ]);
                if ($blog_create) {
                    return redirect()->route('admin.blog.list')->with(['message' => 'Blog Gönderisi Başarıyla Oluşturuldu!', 'messageType' => 'success']);
                }else {
                    return redirect()->route('admin.blog.createPage')->with(['message' => 'Blog Gönderisi Oluşturulamadı!', 'messageType' => 'danger']);
                }
            }else {
                return redirect()->route('admin.blog.createPage')->with(['message' => 'Lütfen Resim Ekleyin!', 'messageType' => 'danger']);
            }
        }else {
            return redirect()->route('admin.blog.createPage')->with(['message' => 'Bu isimle eklenmiş gönderi var!', 'messageType' => 'danger']);
        }
    }

    public function blogEditPage($slug) {
        $blog = Blog::where('slug', $slug)->first();
        if ($blog) {
            return view('back-end.blog.edit-post', compact('blog'));
        }else {
            return redirect()->route('admin.blog.list')->with(['message' => 'Blog Gönderisi Bulunamadı!', 'messageType' => 'danger']);
        }
    }

    public function blogEdit(Request $request) {
        $validatedData = $request->validate([
            'image' => 'image|max:2048|mimes:jpeg,jpg,png',
        ]);
        $reset_image = 0;
        if($request->hasFile('image')){
            $reset_image = 1;
        }
        $state = 0;
        if ($request->state == "on") { $state = 1; }
        if ($reset_image){
            $imagename = Str::slug($request->title).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('/assets/images/blog'),$imagename);
            $blog = Blog::where('slug', $request->old_slug)->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'image' => $imagename,
                'content' => $request->editor1,
                'meta_desc' => $request->seo_desc,
                'state' => $state
            ]);
        }else {
            $blog = Blog::where('slug', $request->old_slug)->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->editor1,
                'meta_desc' => $request->seo_desc,
                'state' => $state
            ]);
        }
        if ($blog) {
            return redirect()->route('admin.blog.list')->with(['message' => 'Blog Gönderisi Güncellendi!', 'messageType' => 'success']);
        }else {
            return redirect()->route('admin.blog.list')->with(['message' => 'Blog Gönderisi Güncellenemedi!', 'messageType' => 'danger']);
        }
    }

    public function settingHomePage() {
        if ($this->checkLogin()) {
            $newsletterSetting = Settings::where('setting', 'newsletter_popup')->first();
            return view('back-end.settings.homepage', compact('newsletterSetting'));
        }else {
            return redirect()->route('admin.login');
        }
    }

    public function settingHomePagePost(Request $request) {
        //$array = json_decode('[{"1":{"image":"homebanner-1.PNG","maintext":"Test Banner","subtext":"Its test"}},{"2":{"image":"homebanner-2.jpg","maintext":"Lorem Ipsum","subtext":"Dolor Sit"}}]', true);
        //foreach ($array as $key => $value) {
        //    dd($value[1]['image']);
        //}
        if ($request->has('bannerPost')){
            // BANNER POST
            $settings = [];
            if($files=$request->file('banner')){
                $i = 0;
                foreach($files as $file){
                    $i++;
                    $imagename = 'homebanner-'.$i.'.'.$file->getClientOriginalExtension();
                    $file->move(public_path('/assets/images/home-banner'),$imagename);
                    $setting = [
                        $i => ['image' => $imagename, 'maintext' => $request->{'mainText'.$i}, 'subtext' => $request->{'subText'.$i}, 'url' => $request->{'subUrl'.$i}]
                    ];
                    array_push($settings, $setting);
                }
                $update = Settings::where('setting', 'home-banner')->update([
                    'value' => json_encode($settings)
                ]);
                if ($update) {
                    return redirect()->route('admin.settings.homepage')->with(['message' => 'Başarıyla Güncellendi!', 'messageType' => 'success']);
                }else {
                    return redirect()->route('admin.settings.homepage')->with(['message' => 'Güncellenemedi!', 'messageType' => 'danger']);
                }
            }else {
                return redirect()->route('admin.settings.homepage')->with(['message' => 'Resim Bulunamadı!', 'messageType' => 'danger']);
            }
        }else if ($request->has('smallbannerPost')) {
            // BANNER POST
            $settings = [];
            if($files=$request->file('banner')){
                $i = 0;
                foreach($files as $file){
                    $i++;
                    $imagename = 'smallbanner-'.$i.'.'.$file->getClientOriginalExtension();
                    $file->move(public_path('/assets/images/home-banner'),$imagename);
                    $setting = [
                        $i => ['image' => $imagename, 'maintext' => $request->{'mainText'.$i}, 'subtext' => $request->{'subText'.$i}]
                    ];
                    array_push($settings, $setting);
                }
                $update = Settings::where('setting', 'small-home-banner')->update([
                    'value' => json_encode($settings)
                ]);
                if ($update) {
                    return redirect()->route('admin.settings.homepage')->with(['message' => 'Başarıyla Güncellendi!', 'messageType' => 'success']);
                }else {
                    return redirect()->route('admin.settings.homepage')->with(['message' => 'Güncellenemedi!', 'messageType' => 'danger']);
                }
            }else {
                return redirect()->route('admin.settings.homepage')->with(['message' => 'Resim Bulunamadı!', 'messageType' => 'danger']);
            }
        }else if ($request->has('settingPost')){
            $state = 0;
            if ($request->state == "on") { $state = 1; }
            $update = Settings::where('setting', 'newsletter_popup')->update([ 'value' => $state]);
            if ($update) {
                return redirect()->route('admin.settings.homepage')->with(['message' => 'Başarıyla Güncellendi!', 'messageType' => 'success']);
            }else {
                return redirect()->route('admin.settings.homepage')->with(['message' => 'Güncellenemedi!', 'messageType' => 'danger']);
            }
        }
    }

    public function announcement() {
        if ($this->checkLogin()){
            return view('back-end.announcement.announcement');
        }else {
            return redirect()->route('admin.login');
        }
    }

    public function listDiscount() {
        if ($this->checkLogin()){
            $discounts = Discount::orderBy('id', 'desc')->paginate(20);
            return view('back-end.discounts.list', compact('discounts'));
        }else {
            return redirect()->route('admin.login');
        }
    }

    public function editDiscount($id) {
        if ($this->checkLogin()){
            $categories = Category::get();
            $products = Products::get();
            $discount = Discount::where('id', $id)->first();
            return view('back-end.discounts.edit-discount', compact('discount', 'categories', 'products'));
        }else {
            return redirect()->route('admin.login');
        }
    }
    public function deleteDiscount($id) {
        if ($this->checkLogin()){
            $discount = Discount::where('id', $id)->delete();
            if ($discount) {
                return redirect()->route('admin.listDiscount')->with(['message' => 'İndirim başarıyla silindi!', 'messageType' => 'success']);
            }else {
                return redirect()->route('admin.listDiscount')->with(['message' => 'İndirim silinemedi lütfen linkleri kontrol edin!', 'messageType' => 'danger']);
            }
        }else {
            return redirect()->route('admin.login');
        }
    }

    public function newDiscount() {
        if ($this->checkLogin()){
            $categories = Category::get();
            $products = Products::get();
            return view('back-end.discounts.new-discount', compact('categories', 'products'));
        }else {
            return redirect()->route('admin.login');
        }
    }

    public function applyDiscount(Request $request) {
        switch ($request->discountCategory) {
            case 'product':
                // ÜRÜN TİPİNDE İNDİRİM
                $products = explode(',', $request->discountProductCodes);
                for ($i=0; $i < count($products); $i++) {
                    $checkProduct = Products::where('code', $products[$i])->first();
                    if ($checkProduct){
                        Discount::create([
                            'product_id' => $checkProduct->id,
                            'type' => $request->discountType,
                            'value' => $request->quantity
                        ]);
                    }
                }
                return redirect()->back()->with(['message' => 'İndirim Başarıyla Uygulandı!', 'messageType' => 'success']);
                break;
            case 'category':
                Discount::create([
                    'category_id' => $request->discountCategoryName,
                    'type' => $request->discountType,
                    'value' => $request->quantity
                ]);
                return redirect()->back()->with(['message' => 'İndirim Başarıyla Uygulandı!', 'messageType' => 'success']);
                break;
            default:
                return redirect()->back()->with(['message' => 'İndirim Tipinde Hata Var!', 'messageType' => 'danger']);
                break;
        }
    }
}
