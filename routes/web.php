<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Default
// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['prefix' => 'admin'], function () {
    Auth::routes();
});
// Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

// ------------------- Custom -------------------
// ===== Adminstrator ===== //
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('admin', 'Adminstrator\DashboardController@index');
    Route::get('admin/dashboard', 'Adminstrator\DashboardController@index')->name('admin.dashboard');




    // User - DONE
    #Access Control
    Route::get('admin/access/list', 'Adminstrator\AccessController@list')->name('admin.access.list')->middleware('CheckPermission:Access,List');
    Route::post('admin/access/action', 'Adminstrator\AccessController@action')->name('admin.access.action')->middleware('CheckPermission:Access,Action');
    Route::get('admin/access/create', 'Adminstrator\AccessController@create')->name('admin.access.create')->middleware('CheckPermission:Access,Create');
    Route::post('admin/access/store', 'Adminstrator\AccessController@store')->name('admin.access.store')->middleware('CheckPermission:Access,Store');

    Route::get('admin/access/destroy/{id}', 'Adminstrator\AccessController@destroy')->name('admin.access.destroy')->middleware('CheckPermission:Access,Destroy', 'CheckId:User');
    Route::get('admin/access/forceDelete/{id}', 'Adminstrator\AccessController@forceDelete')->name('admin.access.forceDelete')->middleware('CheckPermission:Access,forceDelete', 'CheckId:User');
    Route::get('admin/access/edit/{id}', 'Adminstrator\AccessController@edit')->name('admin.access.edit')->middleware('CheckPermission:User,Edit', 'CheckId:Access');
    Route::post('admin/access/update/{id}', 'Adminstrator\AccessController@update')->name('admin.access.update')->middleware('CheckPermission:Access,Update', 'CheckId:User');

    #My Profile
    Route::get('admin/user/profile', "Adminstrator\UserController@profile")->name('admin.user.profile');
    Route::get('admin/user/edit_info', "Adminstrator\UserController@edit_info")->name('admin.user.edit_info');
    Route::post('admin/user/update_info/{id}', "Adminstrator\UserController@update_info")->name('admin.user.update_info');

    // Page - DONE
    Route::get('admin/page/list', 'Adminstrator\PageController@list')->name('admin.page.list')->middleware('CheckPermission:Page,List');
    Route::post('admin/page/action', 'Adminstrator\PageController@action')->name('admin.page.action')->middleware('CheckPermission:Page,Action');
    Route::get('admin/page/create', 'Adminstrator\PageController@create')->name('admin.page.create')->middleware('CheckPermission:Page,Create');
    Route::post('admin/page/store', 'Adminstrator\PageController@store')->name('admin.page.store')->middleware('CheckPermission:Page,Store');

    Route::get('admin/page/destroy/{id}', 'Adminstrator\PageController@destroy')->name('admin.page.destroy')->middleware('CheckPermission:Page,Destroy', 'CheckId:Page');
    Route::get('admin/page/edit/{id}', 'Adminstrator\PageController@edit')->name('admin.page.edit')->middleware('CheckPermission:Page,Edit', 'CheckId:Page');
    Route::post('admin/page/update/{id}', 'Adminstrator\PageController@update')->name('admin.page.update')->middleware('CheckPermission:Page,Update', 'CheckId:Page');




    // Post Category - DONE
    Route::get('admin/post/cat/list', 'Adminstrator\PostController@cat_list')->name('admin.post.cat.list')->middleware('CheckPermission:Category,List');
    Route::post('admin/post/cat/store', 'Adminstrator\PostController@cat_store')->name('admin.post.cat.store')->middleware('CheckPermission:Category,Store');

    Route::get('admin/post/cat/destroy/{id}', 'Adminstrator\PostController@cat_destroy')->name('admin.post.cat.destroy')->middleware('CheckPermission:Category,Destroy', 'CheckId:PostCat');
    Route::get('admin/post/cat/edit/{id}', 'Adminstrator\PostController@cat_edit')->name('admin.post.cat.edit')->middleware('CheckPermission:Category,Edit', 'CheckId:PostCat');
    Route::post('admin/post/cat/update/{id}', 'Adminstrator\PostController@cat_update')->name('admin.post.cat.update')->middleware('CheckPermission:Category,Update', 'CheckId:PostCat');




    // Post - DONE
    Route::get('admin/post/list', 'Adminstrator\PostController@list')->name('admin.post.list')->middleware('CheckPermission:Post,List');
    Route::get('admin/post/create', 'Adminstrator\PostController@create')->name('admin.post.create')->middleware('CheckPermission:Post,Create');
    Route::post('admin/post/store', 'Adminstrator\PostController@store')->name('admin.post.store')->middleware('CheckPermission:Post,Store');
    Route::post('admin/post/action', 'Adminstrator\PostController@action')->name('admin.post.action')->middleware('CheckPermission:Post,Action');

    Route::get('admin/post/destroy/{id}', 'Adminstrator\PostController@destroy')->name('admin.post.destroy')->middleware('CheckPermission:Post,Destroy', 'CheckId:Post');
    Route::get('admin/post/edit/{id}', 'Adminstrator\PostController@edit')->name('admin.post.edit')->middleware('CheckPermission:Post,Edit', 'CheckId:Post');
    Route::post('admin/post/update/{id}', 'Adminstrator\PostController@update')->name('admin.post.update')->middleware('CheckPermission:Post,Update', 'CheckId:Post');




    // Product Category - DONE
    Route::get('admin/product/cat/list', 'Adminstrator\ProductController@cat_list')->name('admin.product.cat.list')->middleware('CheckPermission:Category,List');
    Route::post('admin/product/cat/store', 'Adminstrator\ProductController@cat_store')->name('admin.product.cat.store')->middleware('CheckPermission:Category,Store');

    Route::get('admin/product/cat/destroy/{id}', 'Adminstrator\ProductController@cat_destroy')->name('admin.product.cat.destroy')->middleware('CheckPermission:Category,Destroy', 'CheckId:ProductCat');
    Route::get('admin/product/cat/edit/{id}', 'Adminstrator\ProductController@cat_edit')->name('admin.product.cat.edit')->middleware('CheckPermission:Category,Edit', 'CheckId:ProductCat');
    Route::post('admin/product/cat/update/{id}', 'Adminstrator\ProductController@cat_update')->name('admin.product.cat.update')->middleware('CheckPermission:Category,Update', 'CheckId:ProductCat');



    // Product Brand
    Route::get('admin/product/brand/list', 'Adminstrator\ProductController@brand_list')->name('admin.product.brand.list');
    Route::post('admin/product/brand/store', 'Adminstrator\ProductController@brand_store')->name('admin.product.brand.store');

    Route::get('admin/product/brand/destroy/{id}', 'Adminstrator\ProductController@brand_destroy')->name('admin.product.brand.destroy');
    Route::get('admin/product/brand/edit/{id}', 'Adminstrator\ProductController@brand_edit')->name('admin.product.brand.edit');
    Route::post('admin/product/brand/update/{id}', 'Adminstrator\ProductController@brand_update')->name('admin.product.brand.update');




    // Product Color
    Route::get('admin/product/color/list', 'Adminstrator\ProductController@color_list')->name('admin.product.color.list');
    Route::post('admin/product/color/store', 'Adminstrator\ProductController@color_store')->name('admin.product.color.store');

    Route::get('admin/product/color/destroy/{id}', 'Adminstrator\ProductController@color_destroy')->name('admin.product.color.destroy');
    Route::get('admin/product/color/edit/{id}', 'Adminstrator\ProductController@color_edit')->name('admin.product.color.edit');
    Route::post('admin/product/color/update/{id}', 'Adminstrator\ProductController@color_update')->name('admin.product.color.update');



    




    // Product -DONE
    Route::get('admin/product/list', 'Adminstrator\ProductController@list')->name('admin.product.list')->middleware('CheckPermission:Product,List');
    Route::get('admin/product/create', 'Adminstrator\ProductController@create')->name('admin.product.create')->middleware('CheckPermission:Product,Create');
    Route::post('admin/product/store', 'Adminstrator\ProductController@store')->name('admin.product.store')->middleware('CheckPermission:Product,Store');
    Route::post('admin/product/action', 'Adminstrator\ProductController@action')->name('admin.product.action')->middleware('CheckPermission:Product,Action');

    Route::get('admin/product/load_brand_ajax', 'Adminstrator\ProductController@load_brand_ajax')->name('admin.product.load_brand_ajax');
    Route::get('admin/product/destroy/{id}', 'Adminstrator\ProductController@destroy')->name('admin.product.destroy')->middleware('CheckPermission:Product,Destroy', 'CheckId:Product');
    Route::get('admin/product/edit/{id}', 'Adminstrator\ProductController@edit')->name('admin.product.edit')->middleware('CheckPermission:Product,Edit', 'CheckId:Product');
    Route::post('admin/product/update/{id}', 'Adminstrator\ProductController@update')->name('admin.product.update')->middleware('CheckPermission:Product,Update', 'CheckId:Product');
    Route::get('admin/product/delete_image_ajax', 'Adminstrator\ProductController@delete_image_ajax')->name('admin.product.delete_image_ajax')->middleware('CheckPermission:Product,Delete_Image_Ajax');
    Route::post('admin/product/upload_image_ajax', 'Adminstrator\ProductController@upload_image_ajax')->name('admin.product.upload_image_ajax')->middleware('CheckPermission:Product,Upload_Image_Ajax');
    Route::get('admin/product/swap_order_image_ajax', 'Adminstrator\ProductController@swap_order_image_ajax')->name('admin.product.swap_order_image_ajax')->middleware('CheckPermission:Product,Swap_Order_Image_Ajax');




    // Order - DONE
    Route::get('admin/order/list', 'Adminstrator\OrderController@list')->name('admin.order.list')->middleware('CheckPermission:Order,List');
    Route::post('admin/order/action', 'Adminstrator\OrderController@action')->name('admin.order.action')->middleware('CheckPermission:Order,Action');

    Route::get('admin/order/detail/{id}', 'Adminstrator\OrderController@detail')->name('admin.order.detail')->middleware('CheckPermission:Order,Detail', 'CheckId:Order');
    Route::post('admin/order/update/{id}', 'Adminstrator\OrderController@update')->name('admin.order.update')->middleware('CheckPermission:Order,Update', 'CheckId:Order');




    // Widget
    Route::get('admin/widget/list', 'Adminstrator\WidgetController@list')->name('admin.widget.list')->middleware('CheckPermission:Widget,List');
    Route::post('admin/widget/store', 'Adminstrator\WidgetController@store')->name('admin.widget.store')->middleware('CheckPermission:Widget,Store');
    Route::get('admin/widget/get_widget_image_ajax', 'Adminstrator\WidgetController@get_widget_image_ajax')->name('admin.widget.get_widget_image_ajax')->middleware('CheckPermission:Widget,Get_Widget_Image_Ajax');




    // Widget Content 
    Route::get('admin/widget/content/list/{id}', 'Adminstrator\WidgetController@content_list')->name('admin.widget.content.list')->middleware('CheckPermission:Widget,List', 'CheckId:Widget');
    Route::get('admin/widget/content/create/{id}', 'Adminstrator\WidgetController@content_create')->name('admin.widget.content.create')->middleware('CheckPermission:Widget,Create', 'CheckId:Widget');
    Route::post('admin/widget/content/store', 'Adminstrator\WidgetController@content_store')->name('admin.widget.content.store')->middleware('CheckPermission:Widget,Store');
    Route::get('admin/widget/content/destroy/{id}', 'Adminstrator\WidgetController@content_destroy')->name('admin.widget.content.destroy')->middleware('CheckPermission:Widget,Destroy', 'CheckId:Widget');




    // Slider
    Route::get('admin/slider/list', "Adminstrator\SliderController@list")->name('admin.slider.list')->middleware('CheckPermission:Slider,List');
    Route::post('admin/slider/store', "Adminstrator\SliderController@store")->name('admin.slider.store')->middleware('CheckPermission:Slider,Store');
    Route::get('admin/slider/edit/{id}', "Adminstrator\SliderController@edit")->name('admin.slider.edit')->middleware('CheckPermission:Slider,Edit', 'CheckId:Slider');
    Route::post('admin/slider/update/{id}', "Adminstrator\SliderController@update")->name('admin.slider.update')->middleware('CheckPermission:Slider,Update', 'CheckId:Slider');
    Route::get('admin/slider/destroy/{id}', "Adminstrator\SliderController@destroy")->name('admin.slider.destroy')->middleware('CheckPermission:Slider,Destroy', 'CheckId:Slider');




    // Banner
    Route::get('admin/banner/list', "Adminstrator\BannerController@list")->name('admin.banner.list')->middleware('CheckPermission:Banner,List');
    Route::post('admin/banner/store', "Adminstrator\BannerController@store")->name('admin.banner.store')->middleware('CheckPermission:Banner,Store');
    Route::get('admin/banner/edit/{id}', "Adminstrator\BannerController@edit")->name('admin.banner.edit')->middleware('CheckPermission:Banner,Edit', 'CheckId:Banner');
    Route::post('admin/banner/update/{id}', "Adminstrator\BannerController@update")->name('admin.banner.update')->middleware('CheckPermission:Banner,Update', 'CheckId:Banner');
    Route::get('admin/banner/destroy/{id}', "Adminstrator\BannerController@destroy")->name('admin.banner.destroy')->middleware('CheckPermission:Banner,Destroy', 'CheckId:Banner');


});

// ===== Client ===== //
// Home
Route::get('/', "Client\HomeController@index")->name('client.home');
Route::get('/quickview', "Client\HomeController@quickview")->name('client.home.quickview');
Route::get('/news', "Client\HomeController@news")->name('client.home.news');


// Product
Route::get('product/category/{slug}', "Client\ProductController@index")->name('client.product.category.index')->middleware('CheckIdClient:ProductCat');
Route::get('product/{slug}', "Client\ProductController@detail")->name('client.product.detail')->middleware('CheckIdClient:Product');;
// Post
Route::get('post/category/{slug}', "Client\PostController@index")->name('client.post.category.index')->middleware("CheckIdClient:PostCat");
Route::get('post/{slug}', "Client\PostController@detail")->name('client.post.detail')->middleware("CheckIdClient:Post");

// Page
Route::get('page/{slug}', "Client\PageController@detail")->name('client.page.detail')->middleware("CheckIdClient:Page");
// Cart
Route::get('cart/', "Client\CartController@index")->name('client.cart.index');
Route::get('cart/add', "Client\CartController@add")->name('client.cart.add');
Route::get('cart/add_checkout', "Client\CartController@add_checkout")->name('client.cart.add_checkout');
Route::get('cart/update', "Client\CartController@update")->name('client.cart.update');
Route::get('cart/update_buy_now', "Client\CartController@update_buy_now")->name('client.cart.update_buy_now');
Route::get('cart/remove/{row_id}', "Client\CartController@remove")->name('client.cart.remove')->middleware("CheckIdClient:Cart");
Route::get('cart/destroy', "Client\CartController@destroy")->name('client.cart.destroy');
Route::post('cart/set_info', "Client\CartController@set_info")->name('client.cart.set_info');
Route::get('cart/checkout/{id?}', "Client\CartController@checkout")->name('client.cart.checkout');
Route::get('cart/thanks', "Client\CartController@thanks")->name('client.cart.thanks');



