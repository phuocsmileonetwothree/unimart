<?php

namespace App\Http\Controllers\Client;

use App\Color;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Mail\OrderSuccess;
use App\Order;
use App\Order_Detail;
use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{

    public function index(Request $request)
    {
        return view('client.cart.index');
    }

    public function add()
    {
        $product_id = $_GET['product_id'];
        $qty = $_GET['qty'];
        $color_id = $_GET['color_id'];
        $product = Product::find($product_id);
        if ($color_id != 0) {
            $color = Color::find($color_id);
            $color_title = $color->title;
            $color_code = $color->code;
        } else {
            $color_title = null;
            $color_code = null;
        }
        Cart::add([
            'id' => $product->id,
            'slug' => $product->slug,
            'name' => $product->name,
            'qty' => $qty,
            'price' => $product->price,
            'options' => ['url' => $product->images[0]->url, 'slug' => $product->slug, 'old_price' => $product->old_price, 'color_title' => $color_title, 'color_code' => $color_code],
        ]);

        $result = [];
        $html = "";
        foreach (Cart::content() as $item) {
            $route_update = route('client.cart.update'); #ajax
            $route_remove = route('client.cart.remove', $item->rowId); #php
            $route_product = route('client.product.detail', ['slug' => $item->options->slug]);
            $price = current_format($item->price);
            $image = url($item->options->url);

            $html .= "<li>";
            $html .=      "<div class='media'>";
            $html .=          "<a href='{$route_product}'>";
            $html .=              "<img class='me-3' src='{$image}'>";
            $html .=          "</a>";
            $html .=          "<div class='media-body'>";
            $html .=              "<a href='{$route_product}'>";
            $html .=                  "<h4>{$item->name}</h4>";
            $html .=              "</a>";
            $html .=              "<h6>{$price}</h6>";
            $html .=              "<div class='addit-box'>";
            $html .=                  "<input min='1' type='number' name='num-order-{$item->rowId}' value='{$item->qty}' class='num-order' data-id='{$item->rowId}' data-url='{$route_update}'>";
            $html .=                  "<div class='pro-add'>";
            $html .=                      "<a href='{$route_remove}'>";
            $html .=                          "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-trash-2'><polyline points='3 6 5 6 21 6'></polyline><path d='M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2'></path><line x1='10' y1='11' x2='10' y2='17'></line><line x1='14' y1='11' x2='14' y2='17'></line></svg>";
            $html .=                      "</a>";
            $html .=                  "</div>";
            $html .=              "</div>";
            $html .=          "</div>";
            $html .=      "</div>";
            $html .= "</li>";
        }

        $result = array(
            'html' => $html,
            'total_qty' => Cart::count(),
            'total_price' => current_format(Cart::subtotal()),
        );
        echo json_encode($result);
    }

    public function add_checkout()
    {
        $product_id = $_GET['product_id'];
        $qty = $_GET['qty'];
        $color_id = $_GET['color_id'];
        $product = Product::find($product_id);
        if ($color_id != 0) {
            $color = Color::find($color_id);
            $color_title = $color->title;
            $color_code = $color->code;
        } else {
            $color_title = null;
            $color_code = null;
        }
        session(
            ['buy_now' => [
                'id' => $product->id,
                'slug' => $product->slug,
                'name' => $product->name,
                'price' => $product->price,
                'old_price' => $product->old_price,
                'qty' => $qty,
                'url' => $product->images[0]->url,
                'color_title' => $color_title,
                'color_code' => $color_code
            ]]
        );

        $result = [
            'result' => true,
            'url_checkout' => route('client.cart.checkout', $product_id),
        ];
        echo json_encode($result);
    }

    public function update()
    {
        $row_id = $_GET['row_id'];
        $qty = $_GET['qty'];
        Cart::update($row_id, $qty);

        $item_cart = Cart::get($row_id);
        $result = [
            'qty' => $item_cart->qty,
            'sub_total' => current_format($item_cart->subtotal),
            'total_qty' => Cart::count(),
            'total_price' => current_format(Cart::subtotal()),
        ];

        echo json_encode($result);
    }

    public function update_buy_now()
    {
        $id = $_GET['id'];
        $qty = $_GET['qty'];
        $item = Product::find($id);
        $result = [
            'qty' => $qty,
            'sub_total' => current_format($qty * $item->price),
            'total_price' => current_format($qty * $item->price),
        ];

        echo json_encode($result);
    }

    public function remove($row_id)
    {
        Cart::remove($row_id);
        return redirect()->back();
    }

    public function destroy()
    {
        Cart::destroy();
        return redirect()->route('client.cart.index');
    }

    public function set_info()
    {
        $result = [];
        $fullname = $_POST['fullname'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $note = $_POST['note'];

        session(['info' => [
            'fullname' => $fullname,
            'phone' => $phone,
            'email' => $email,
            'address' => $address,
            'note' => $note,
        ]]);
        $result = array(
            'set_info' => true,
        );
        return json_encode($result);
    }

    public function checkout(Request $request, $id = 0)
    {

        $cart = [];
        $cart_total = 0;
        if ($id != 0 and $request->session()->has('buy_now')) {
            $tmp_buy_now = $request->session()->get('buy_now');
            $product_buy_now = collect();
            $product_buy_now->id = $tmp_buy_now['id'];
            $product_buy_now->name = $tmp_buy_now['name'];
            $product_buy_now->slug = $tmp_buy_now['slug'];
            $product_buy_now->qty = $tmp_buy_now['qty'];
            $product_buy_now->price = $tmp_buy_now['price'];
            $product_buy_now->old_price = $tmp_buy_now['old_price'];
            $product_buy_now->url = $tmp_buy_now['url'];
            $product_buy_now->color_code = $tmp_buy_now['color_code'];
            $product_buy_now->color_title = $tmp_buy_now['color_title'];
            $product_buy_now->subtotal = $tmp_buy_now['price'] * $tmp_buy_now['qty'];

            $cart[0] = $product_buy_now;
            $cart_total = $product_buy_now->subtotal;
            if ($request->input('btn_order')) {
                // Thêm dữ liệu đơn hàng vào table ORDERS
                if ($request->session()->has('info')) {
                    $data_order = [
                        'fullname' => session('info.fullname'),
                        'email' => session('info.email'),
                        'phone' => session('info.phone'),
                        'address' => session('info.address'),
                        'note' => session('info.note'),
                        'payment' => 'cod',
                        'order_code' => "UNIMART" . str_replace([' ', '-', ':'], '', Str::of(Carbon::now()->toDateTimeString())->trim()),
                    ];
                    $order = Order::create($data_order);
                    if ($order != null) {
                        $tmp_order_detail = [];
                        $data_order_detail = [
                            'qty' => $request->input('num_buy_now'),
                            'price' => $product_buy_now->price,
                            'color_code' => !empty($product_buy_now->color_code) ? $product_buy_now->color_code : '',
                            'color_title' => !empty($product_buy_now->color_title) ? $product_buy_now->color_title : '',
                            'product_id' => $product_buy_now->id,
                            'order_id' => $order->id,
                        ];
                        $order_detail = Order_Detail::create($data_order_detail);
                        Product::where('id', $data_order_detail['product_id'])->update(['purchased' => $order_detail->product->purchased + $data_order_detail['qty']]);
                        $tmp_order_detail[] = $order_detail;
                        if ($order_detail != null) {
                            session(['last_order' => $order->id]);
                            Mail::to($data_order['email'])->send(new OrderSuccess(array_merge(['order' => $order], ['order_detail' => $tmp_order_detail])));
                            return redirect()->route('client.cart.thanks');
                        } else {
                            return redirect()->route('client.home');
                        }
                    } else {
                        return redirect()->route('client.home');
                    }
                }
            }
        } else {
            if (Cart::count() == 0) {
                return redirect()->route('client.home');
            }
            $cart = Cart::content();
            $cart_total = Cart::subtotal();
            if ($request->input('btn_order')) {
                // Thêm dữ liệu đơn hàng vào table ORDERS
                if ($request->session()->has('info')) {
                    $data_order = [
                        'fullname' => session('info.fullname'),
                        'email' => session('info.email'),
                        'phone' => session('info.phone'),
                        'address' => session('info.address'),
                        'note' => session('info.note'),
                        'payment' => 'cod',
                        'order_code' => "UNIMART" . str_replace([' ', '-', ':'], '', Str::of(Carbon::now()->toDateTimeString())->trim()),
                    ];
                    $order = Order::create($data_order);
                    if ($order != null) {
                        $tmp_order_detail = [];
                        foreach (Cart::content() as $item) {
                            $data_order_detail = [
                                'qty' => $item->qty,
                                'price' => $item->price,
                                'color_code' => $item->options->color_code,
                                'color_title' => $item->options->color_title,
                                'product_id' => $item->id,
                                'order_id' => $order->id,
                            ];
                            $order_detail = Order_Detail::create($data_order_detail);

                            Product::where('id', $data_order_detail['product_id'])->update(['purchased' => $order_detail->product->purchased + $data_order_detail['qty']]);
                            $tmp_order_detail[] = $order_detail;
                        }
                        if ($order_detail != null) {
                            Cart::destroy();
                            session(['last_order' => $order->id]);
                            Mail::to($data_order['email'])->send(new OrderSuccess(array_merge(['order' => $order], ['order_detail' => $tmp_order_detail])));
                            return redirect()->route('client.cart.thanks');
                        } else {
                            return redirect()->route('client.home');
                        }
                    } else {
                        return redirect()->route('client.home');
                    }
                }
            }
        }
        return view('client.cart.checkout', compact('cart', 'cart_total'));
    }


    public function thanks(Request $request)
    {
        if ($request->session()->has('last_order')) {
            $order_id = $request->session()->get('last_order');
            $order = Order::find($order_id);
            $total_order = 0;
            foreach ($order->order_details as $item) {
                $total_order += ($item->product->price * $item->qty);
            }
            return view('client.cart.thanks', compact('order', 'total_order'));
        }
    }
}
