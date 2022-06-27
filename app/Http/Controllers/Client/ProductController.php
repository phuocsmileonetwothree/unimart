<?php

namespace App\Http\Controllers\Client;

use App\Brand;
use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use App\Range_Price;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index($slug)
    {
        $categories = Category::where([['type', 'product'], ['parent_id', '!=', 999999]])->get()->toArray();
        $category = Category::where('slug', $slug)->first();
        $brands = !empty($category->brands) ? $category->brands->toArray() : Brand::all()->toArray();
        $range_prices = Range_Price::all()->toArray();


        $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($category !== null) {
            $brand = !empty($_GET['b']) ? $_GET['b'] : '';
            $price = !empty($_GET['p']) ? Range_Price::find((int)$_GET['p']) : '';
            $sort = !empty($_GET['s']) ? $_GET['s'] : '';
            $min_price = !empty($price) ? $price->start : '';
            $max_price = !empty($price) ? $price->end : '';
            if (empty($sort) or $sort == 2) {
                $order_by = "ASC";
            }else {
                $order_by = "DESC";
            }

            $categories_sub_id = get_all_id_sub_categories($category);
            $categories_sub_id[] = $category->id;
            $total_products = Product::whereIn('cat_id', $categories_sub_id)
                                    ->where(function ($query) use ($brand) {
                                        if (!empty($brand)) {
                                            $query->whereIn('brand_id', explode(',', $brand));
                                        }
                                    })
                                    ->where(function ($query) use ($price, $min_price, $max_price) {
                                        if (!empty($price)) {
                                            $query->whereBetween('price', [$min_price, $max_price]);
                                        }
                                    })->count();
            $paginate = get_param_pagging_offset_limit(10, $total_products, $page);
            $paginate['slug'] = $slug;

            $products = Product::whereIn('cat_id', $categories_sub_id)
                ->where(function ($query) use ($brand) {
                    if (!empty($brand)) {
                        $query->whereIn('brand_id', explode(',', $brand));
                    }
                })
                ->where(function ($query) use ($price, $min_price, $max_price) {
                    if (!empty($price)) {
                        $query->whereBetween('price', [$min_price, $max_price]);
                    }
                })
                ->orderBy('price', $order_by)
                ->offset($paginate['start'])
                ->limit($paginate['end'])
                ->get();
        } else {
            $paginate = get_param_pagging_offset_limit(10, Product::all()->count(), $page);
            $paginate['slug'] = $slug;
            $products = Product::all();
        }
        return view('client.product.index', compact('categories', 'category', 'products', 'paginate', 'brands', 'range_prices'));
    }

    public function detail($slug)
    {
        $product = Product::where('slug', $slug)->first();
        $related_products = Product::where([['brand_id', $product->brand_id], ['id', '!=', $product->id]])->get(['id', 'name', 'slug', 'price', 'old_price']);
        return view('client.product.detail', compact('product', 'related_products'));
    }
}
