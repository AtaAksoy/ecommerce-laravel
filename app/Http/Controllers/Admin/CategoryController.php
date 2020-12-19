<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index() {
        $admin = new AdminController();
        if ($admin->checkLogin()){
            $categories = Category::orderBy('id', 'desc')->paginate(10);
            return view('back-end.category.list', compact('categories'));
        }else {
            return redirect()->route('admin.login');
        }
    }

    public function addCategory(Request $request) {
        $admin = new AdminController();
        if ($admin->checkLogin()){
            $validatedData = $request->validate([
                'image' => 'image|max:1024|mimes:jpeg,jpg,png',
            ]);
            if($request->hasFile('image')){ /* resim geldi mi */
                $imagename =Str::slug($request->category_name).'.'.$request->image->getClientOriginalExtension();
                $request->image->move(public_path('/assets/images/category'),$imagename);
                $category_create = Category::create([
                    'name' => $request->category_name,
                    'slug' => Str::slug($request->category_name),
                    'image' => $imagename,
                    'description' => $request->category_desc
                ]);
                if ($category_create){
                    return redirect()->route('admin.category')->with(['message' => 'Kategori Eklendi!', 'messageType' => 'success']);
                }else {
                    return redirect()->route('admin.category')->with(['message' => 'Kategori Eklenemedi!', 'messageType' => 'danger']);
                }
            }else {
                return redirect()->route('admin.category')->with(['message' => 'Lütfen resim ekleyin!', 'messageType' => 'danger']);
            }
        }
    }
    public function editCategoryPage($slug) {
        $admin = new AdminController();
        if ($admin->checkLogin()){
            $category = Category::where('slug', $slug)->first();
            if ($category) {
                return view('back-end.category.edit-category', compact('category'));
            }else {
                return redirect()->route('admin.category')->with(['message' => 'Kategori Bulunamadı!', 'messageType' => 'danger']);
            }
        }
    }

    public function deleteCategory($slug) {
        $admin = new AdminController();
        if ($admin->checkLogin()){
            $category = Category::where('slug', $slug)->delete();
            if ($category){
                return redirect()->route('admin.category')->with(['message' => 'Kategori Silindi!', 'messageType' => 'success']);
            }else {
                return redirect()->route('admin.category')->with(['message' => 'Kategori Bulunamadı!', 'messageType' => 'danger']);
            }
        }
    }

    public function editCategory(Request $request) {
        $admin = new AdminController();
        if ($admin->checkLogin()){
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
                $imagename = Str::slug($request->name).'.'.$request->image->getClientOriginalExtension();
                $request->image->move(public_path('/assets/images/category'),$imagename);
                $category = Category::where('slug', $request->old_slug)->update([
                    'name' => $request->name,
                    'slug' => Str::slug($request->name),
                    'image' => $imagename,
                    'description' => $request->editor1,
                    'state' => $state
                ]);
            }else {
                $category = Category::where('slug', $request->old_slug)->update([
                    'name' => $request->name,
                    'slug' => Str::slug($request->name),
                    'description' => $request->editor1,
                    'state' => $state
                ]);
            }
            if ($category) {
                return redirect()->route('admin.category')->with(['message' => 'Kategori Güncellendi!', 'messageType' => 'success']);
            }else {
                return redirect()->route('admin.category')->with(['message' => 'Kategori Güncellenemedi!', 'messageType' => 'danger']);
            }
        }
    }
}
