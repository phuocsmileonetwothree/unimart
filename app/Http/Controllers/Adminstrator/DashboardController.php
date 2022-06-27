<?php

namespace App\Http\Controllers\Adminstrator;

use App\Http\Controllers\Controller;
use App\Order;
use App\Order_Detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    function __construct()
    {
        $this -> middleware(function($request, $next){
            session(['module_active' => 'dashboard']);

            return $next($request);
        });
    }
    public function index(Request $request){
        $count = [
            'successful' => Order::withTrashed()->where('status', 'successful')->count(),
            'cancelled' => Order::withTrashed()->where('status', 'cancelled')->count(),
            'sales' => DB::table('order_details')->selectRaw("SUM(price * qty) as total_sales")->get()->toArray(),
            'processing' => Order::withTrashed()->where('status', 'processing')->count(),
        ];

        $orders = Order::orderBy('created_at', 'desc')->paginate(10);
        foreach($orders as $order){
            $order->total_qty = 0;
            $order->total_price = 0;
            foreach($order->order_details as $item){
                $order->total_qty += $item->qty;
                $order->total_price += $item->price;
            }
        }
        return view('admin.dashboard', compact('orders', 'count'));
    }
}
