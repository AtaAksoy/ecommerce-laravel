<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Category;
use App\Models\Products;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class ProductController extends Controller
{

    public function addProductPage() {
        $admin = new AdminController();
        $categories = Category::get();
        if ($admin->checkLogin()) {
            return view('back-end.product.add-product', compact('categories'));
        }else {
            return redirect()->route('admin.login');
        }
    }

    public function listProduct() {
        $admin = new AdminController();
        if ($admin->checkLogin()) {
            $products = Products::orderBy('id', 'asc')->paginate(20);
            return view('back-end.product.list-product', compact('products'));
        }else {
            return redirect()->route('admin.login');
        }
    }

    public function editProductPage($code) {
        $admin = new AdminController();
        if ($admin->checkLogin()){
            $product = Products::where('code', $code)->first();
            if ($product){
                $images = explode('|', $product->images);
                $categories = Category::get();
                $features = json_decode($product->features);
                $colors = implode(',', json_decode($features->colors));
                $sizes = implode(',', json_decode($features->size));
                return view('back-end.product.edit-product', compact('product', 'images', 'categories', 'colors', 'sizes'));
            }else {
                return redirect()->route('admin.products.list')->with(['message' => 'Ürün Bulunamadı Lütfen Kodunu Kontrol Edin!', 'messageType' => 'danger']);
            }
        }else {
            return redirect()->route('admin.login');
        }
    }
    public function editProduct($code, Request $request) {
        $input=$request->all();
        $colors = explode(',', $request->colors);
        $size = explode(',', $request->size);
        $features = [
            'colors' => json_encode($colors),
            'size' => json_encode($size)
        ];
        $state = 0;
        if ($request->state == "on") { $state = 1; }
        $urun = Products::where('code', $code)->update([
            'category_id' => $request->category,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->editor1,
            'price' => $request->price,
            'code' => Str::random(5).Str::slug($request->name).Str::random(5),
            'stock' => $request->stock,
            'features' => json_encode($features),
            'state' => $state
        ]);
        if ($urun) {
            // PRODUCT CREATED SUCCESSFULLY
            return redirect()->route('admin.products.list')->with(['message' => 'Ürün Başarıyla Düzenlendi!', 'messageType' => 'success']);
        }else {
            // ERROR
            return redirect()->route('admin.products.list')->with(['message' => 'Ürün Düzenlenemedi!', 'messageType' => 'danger']);
        }
    }


    public function addProduct(Request $request) {
        $input=$request->all();
        $images=array();
        if($files=$request->file('image')){
            foreach($files as $file){
                $imagename = Str::slug($request->name).Str::random(5).'.'.$file->getClientOriginalExtension();
                $file->move(public_path('/assets/images/products'),$imagename);
                $images[]=$imagename;
            }
        }
        $colors = explode(',', $request->colors);
        $size = explode(',', $request->size);
        $features = [
            'colors' => json_encode($colors),
            'size' => json_encode($size)
        ];
        $state = 0;
        if ($request->state == "on") { $state = 1; }
        $urun = Products::create([
            'category_id' => $request->category,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'images' => implode('|', $images),
            'description' => $request->editor1,
            'price' => $request->price,
            'code' => Str::random(5).Str::slug($request->name).Str::random(5),
            'stock' => $request->stock,
            'features' => json_encode($features),
            'state' => $state
        ]);
        if ($urun) {
            // PRODUCT CREATED SUCCESSFULLY
            return redirect()->route('admin.products.list')->with(['message' => 'Ürün Başarıyla Eklendi!', 'messageType' => 'success']);
        }else {
            // ERROR
            return redirect()->route('admin.products.list')->with(['message' => 'Ürün Eklenemedi!', 'messageType' => 'danger']);
        }
    }
}
