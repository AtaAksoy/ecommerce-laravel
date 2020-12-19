<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Discount;
use App\Models\Products;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function listProducts($category_slug) {
        $category = Category::where('slug', $category_slug)->where('state', 1)->first();
        if ($category){
            $category_discount = Discount::where('category_id', $category->id)->where('state', 1)->first();
            if ($category){
                $products = Products::where('category_id', $category->id)->where('state', 1)->orderBy('id', 'desc')->paginate(20);
                if ($category_discount){
                    return view('category', compact('products', 'category', 'category_discount'));
                }else {
                    return view('category', compact('products', 'category'));
                }
            }else {
                // NOT FOUND
                return redirect()->route('index')->with(['message' => 'Kategori bulunamadı!', 'messageType' => 'danger']);
            }
        }else {
            return view('errors.404');
        }
    }
}
