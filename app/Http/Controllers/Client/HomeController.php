<?php

namespace App\Http\Controllers\Client;

use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request){
        $new_products = Product::orderBy('created_at', 'desc')->inRandomOrder()->limit(10)->get(['id', 'name', 'slug', 'price']);
        $featured_categories = Category::where([['parent_id', '!=', 999999], ['type', 'product'], ['parent_id', 0]])->get(['id', 'title', 'slug', 'thumb']);
        $deal_products = Product::select("*")->selectRaw("(old_price - price) as discount_price")->where('old_price', ">=", 1)->orderBy('discount_price', 'desc')->limit(5)->get();

        $categories_and_products = $featured_categories;
        foreach($categories_and_products as $category){
            $category->all_sub_category = get_all_id_sub_categories($category);
            $category->all_sub_product = Product::whereIn('cat_id', $category->all_sub_category)->orderBy('purchased', 'desc')->limit(10)->get();
            foreach($category->all_sub_product as $item){
                $item->url = $item->images[0]->url;
            }
            $category->all_sub_product = $category->all_sub_product->toArray();
        }
        return view('client.home.index', compact('new_products', 'featured_categories', 'deal_products', 'categories_and_products'));
    }


    public function quickview(){
        $result = [];

        $product_id = $_GET['product_id'];
        $product = Product::find($product_id);
        $product_colors = $product->colors;

        if(!empty($product)){
            $result = [
                'result' => true,
                'id' => $product->id,
                'image' => url($product->images[0]->url),
                'name' => $product->name,
                'price' => current_format($product->price),
                'old_price' => current_format($product->old_price),
                'desc' => $product->desc,
                'url_detail' => route('client.product.detail', ['slug' => $product->slug]),
            ];

            if(!empty($product_colors)){
                $result['colors'] = $product_colors;
            }
        }else{
            $result = [
                'result' => false,
            ];
        }
        echo json_encode($result);
    }

}
