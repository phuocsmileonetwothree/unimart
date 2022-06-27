<?php

namespace App\Http\Middleware;

use App\Category;
use App\Page;
use App\Post;
use App\Product;
use Closure;
use Gloudemans\Shoppingcart\Facades\Cart;

class CheckIdClient
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $model)
    {
        if($model == 'PostCat'){
            $slug = $request->route()->parameter('slug');
            if($slug == 'all'){
                return $next($request);
            }else{
                if(empty(Category::where([['slug', $slug], ['type', 'post']])->first())){
                    return response()->make(view('client.404'), 404);
                }
            }
        }
        if($model == 'Post'){
            $slug = $request->route()->parameter('slug');
            if (empty(Post::where('slug', $slug)->first())) {
                return response()->make(view('client.404'), 404);
            }
        }
        if($model == "ProductCat"){
            $slug = $request->route()->parameter('slug');
            if($slug == 'all'){
                return $next($request);
            }else{
                if(empty(Category::where([['slug', $slug], ['type', 'product']])->first())){
                    return response()->make(view('client.404'), 404);
                }
            }
        }
        if($model == "Product"){
            $slug = $request->route()->parameter('slug');
            if (empty(Product::where('slug', $slug)->first())) {
                return response()->make(view('client.404'), 404);
            }
        }
        if($model == 'Page'){
            $slug = $request->route()->parameter('slug');
            if (empty(Page::where('slug', $slug)->first())) {
                return response()->make(view('client.404'), 404);
            }
        }
        if($model == "Cart"){
            $row_id = $request->route()->parameter('row_id');
            if(!array_key_exists($row_id, Cart::content()->toArray())){
                return response()->make(view('client.404'), 404);
            }
        }
        return $next($request);
    }
}
