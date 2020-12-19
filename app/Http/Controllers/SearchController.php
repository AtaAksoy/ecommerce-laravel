<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Discount;
use App\Models\Products;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request) {
        if ($request->q != null){
            $key = $request->q;
            $products = Products::where([
                ['name', 'like', '%'.$request->q.'%'],
                ['state', 1]
            ])->orderBy('id', 'desc')->paginate(1);
        }else {
            $key = "";
            $products = Products::where('state', 1)->orderBy('id', 'desc')->paginate(6);
        }
        foreach ($products as $product) {
            $category = Category::where('id', $product->category_id)->first();
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
            $product->category_slug = $category->slug;
        }
        return view('search', compact('products', 'key'));
    }
}
