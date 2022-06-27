<?php

namespace App\Http\Middleware;

use App\Banner;
use App\Category;
use App\Order;
use App\Page;
use App\Post;
use App\Product;
use App\Slider;
use App\User;
use App\Widget;
use App\Widget_Detail;
use Closure;

class CheckId
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
        if ($model == 'User') {
            $id = $request->route()->parameter('id');
            if (empty(User::withTrashed()->find($id))) {
                return redirect()->route('admin.user.list')->with('error', 'Thành viên không tồn tại');
            }
        }
        if($model == 'Page'){
            $id = $request->route()->parameter('id');
            if (empty(Page::withTrashed()->find($id))) {
                return redirect()->route('admin.page.list')->with('error', 'Trang không tồn tại');
            }
        }
        if($model == 'PostCat'){
            $id = $request->route()->parameter('id');
            if (empty(Category::find($id))) {
                return redirect()->route('admin.post.cat.list')->with('error', 'Danh mục bài viết không tồn tại');
            }
        }
        if($model == 'Post'){
            $id = $request->route()->parameter('id');
            if (empty(Post::withTrashed()->find($id))) {
                return redirect()->route('admin.post.list')->with('error', 'Bài viết không tồn tại');
            }
        }
        if($model == 'ProductCat'){
            $id = $request->route()->parameter('id');
            if (empty(Category::find($id))) {
                return redirect()->route('admin.product.cat.list')->with('error', 'Danh mục sản phẩm không tồn tại');
            }
        }
        if($model == 'Product'){
            $id = $request->route()->parameter('id');
            if (empty(Product::withTrashed()->find($id))) {
                return redirect()->route('admin.product.list')->with('error', 'Sản phẩm không tồn tại');
            }
        }
        if($model == 'Order'){
            $id = $request->route()->parameter('id');
            if (empty(Order::withTrashed()->find($id))) {
                return redirect()->route('admin.order.list')->with('error', 'Đơn hàng không tồn tại');
            }
        }
        if($model == 'Widget'){
            $id = $request->route()->parameter('id');
            if (empty(Widget::find($id))) {
                return redirect()->route('admin.widget.list')->with('error', 'Khối widget không tồn tại');
            }
        }
        if($model == 'Slider'){
            $id = $request->route()->parameter('id');
            if (empty(Slider::find($id))) {
                return redirect()->route('admin.slider.list')->with('error', 'Slider không tồn tại');
            }
        }
        if($model == 'Banner'){
            $id = $request->route()->parameter('id');
            if (empty(Banner::find($id))) {
                return redirect()->route('admin.banner.list')->with('error', 'Banner không tồn tại');
            }
        }
        return $next($request);
    }
}
