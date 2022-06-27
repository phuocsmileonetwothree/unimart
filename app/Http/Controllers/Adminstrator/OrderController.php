<?php

namespace App\Http\Controllers\Adminstrator;

use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    function __construct(Request $request)
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'order']);
            return $next($request);
        });
    }

    public function list(Request $request)
    {
        $key = '';
        $count = [
            'all' => Order::all()->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
            'transported' => Order::where('status', 'transported')->count(),
            'successful' => Order::where('status', 'successful')->count(),
            'trash' => Order::onlyTrashed()->count(),
        ];
        if ($request->input('key') !== null) {
            $key = $request->input('key');
            $orders = Order::where('order_code', 'LIKE', "%{$key}%")->orderBy('created_at', 'desc')->paginate(10);
            $orders->list_action = ['processing', 'cancelled', 'transported', 'successful', 'destroy'];
        } else {
            if ($request->input('status') === 'processing') {
                $orders = Order::where('status', 'processing')->orderBy('created_at', 'desc')->paginate(10);
                $orders->list_action = ['cancelled', 'transported', 'successful'];
                // $orders->confirm = "Bạn chắc chắn xóa đơn hàng . Có thể hoàn tác";

            } elseif ($request->input('status') === 'cancelled') {
                $orders = Order::where('status', 'cancelled')->orderBy('created_at', 'desc')->paginate(10);
                $orders->list_action = ['processing', 'transported', 'successful', 'destroy'];
                $orders->confirm = "Bạn chắc chắn xóa đơn hàng . Có thể hoàn tác";

            } elseif ($request->input('status') === 'transported') {
                $orders = Order::where('status', 'transported')->orderBy('created_at', 'desc')->paginate(10);
                $orders->list_action = ['processing', 'cancelled', 'successful'];
                // $orders->confirm = "Bạn chắc chắn xóa đơn hàng . Có thể hoàn tác";

            } elseif ($request->input('status') === 'successful') {
                $orders = Order::where('status', 'successful')->orderBy('created_at', 'desc')->paginate(10);
                $orders->list_action = ['processing', 'cancelled', 'transported'];
                $orders->confirm = "Bạn chắc chắn xóa đơn hàng . Có thể hoàn tác";

            } elseif ($request->input('status') === 'trash') {
                $orders = Order::onlyTrashed()->orderBy('created_at', 'desc')->paginate(10);
                $orders->list_action = ['cancelled', 'transported', 'successful', 'restore', 'forceDelete'];
                $orders->confirm = "Bạn chắc chắn xóa vĩnh viễn đơn hàng . Không thể hoàn tác";

            } else {
                $orders = Order::orderBy('created_at', 'desc')->paginate(10);
                $orders->list_action = ['processing', 'cancelled', 'transported', 'successful'];
                $orders->confirm = "Bạn chắc chắn xóa sản phẩm . Có thể hoàn tác";
            }
        }
        foreach($orders as $order){
            $order->total_qty = 0;
            $order->total_price = 0;
            foreach($order->order_details as $item){
                $order->total_qty += $item->qty;
                $order->total_price += $item->price;
            }
        }
        $index = ($orders->perPage() * $orders->currentPage()) - $orders->perPage() + 1;
        return view('admin.order.list', compact('key', 'count', 'orders', 'index'));
    }

    public function action(Request $request)
    {
        $action = $request->input('action');
        $list_check = $request->input('list_check');
        if ($action !== null) {
            if ($list_check !== null) {
                // on off still out destroy forceDelete restore
                if ($action == 'processing') {
                    Order::withTrashed()->whereIn('id', $list_check)->update(['status' => 'processing']);
                }
                if ($action == 'cancelled') {
                    Order::withTrashed()->whereIn('id', $list_check)->update(['status' => 'cancelled']);
                }
                if ($action == 'transported') {
                    Order::withTrashed()->whereIn('id', $list_check)->update(['status' => 'transported']);
                }
                if ($action == 'successful') {
                    Order::withTrashed()->whereIn('id', $list_check)->update(['status' => 'successful']);
                }
                if ($action == 'destroy') {
                    Order::destroy($list_check);
                }
                if ($action == 'forceDelete') {
                    Order::onlyTrashed()->whereIn('id', $list_check)->forceDelete();
                }
                if ($action == 'restore') {
                    Order::onlyTrashed()->whereIn('id', $list_check)->restore();
                }

                return redirect()->back()->with('success', 'Đã áp dụng thao tác thành công cho đơn hàng');
            }
            return redirect()->back()->with('warning', 'Vui lòng chọn đơn hàng');
        }
        return redirect()->back()->with('warning', 'Vui lòng chọn thao tác áp dụng');
    }

    public function detail($id){
        $order = Order::find($id);
        $order->total_qty = 0;
        $order->total_price = 0;
        foreach($order->order_details as $item){
            $order->total_qty += $item->qty;
            $order->total_price += $item->qty * $item->price;
        }
        return view('admin.order.detail', compact('order'));
    }

    public function update(Request $request, $id){
        if($request->input('btn_update') !== null){
            $status = $request->input('status');
            Order::find($id)->update(['status' => $status]);
            return redirect()->route('admin.order.detail', ['id' => $id])->with('success', "Đã cập nhật tình trạng đơn hàng");
        }
    }
}
