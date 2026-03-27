<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('grand_total');

        $todayOrders = Order::whereDate('created_at', now())->count();
        $todayRevenue = Order::whereDate('created_at', now())->sum('grand_total');

        return view('admin.dashboard', compact('totalOrders', 'totalRevenue', 'todayOrders', 'todayRevenue'));
    }


    public function report(Request $request){
        $query = Order::query();

        // filter bulan & tahun
        if ($request->month) {
            $query->whereMonth('created_at', $request->month);
        }

        if ($request->year) {
            $query->whereYear('created_at', $request->year);
        }

        // contoh filter status (opsional)
        $query->whereIn('status', ['cooked', 'settlement']);

        $reports = $query->latest()->get();

        return view('admin.report.index', compact('reports'));
    }

    public function reportShow(string $id){
        $order = Order::findOrFail($id);
        $orderItems = OrderItem::where('order_id', $order->id)->get();

        // Return the view with the order details
        return view('admin.order.show', compact('order', 'orderItems'));
    }
}
