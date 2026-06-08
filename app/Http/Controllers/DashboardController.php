<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function admin()
    {
        // Example stats (replace with real queries)
        $stats = [
            'total_products' => 120,
            'total_users' => 45,
            'today_transactions' => 8,
            'monthly_revenue' => 1250000,
        ];
        $recentOrders = [];
        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }

    public function seller()
    {
        $seller = Auth::guard('web')->user();
        $stats = [
            'total_products' => 20,
            'incoming_orders' => 5,
            'revenue' => 350000,
        ];
        $recentOrders = [];
        return view('seller.dashboard', compact('stats', 'recentOrders'));
    }

    public function user()
    {
        $user = Auth::guard('web')->user();
        $stats = [
            'total_orders' => 12,
            'wishlist_count' => 3,
            'order_history' => [],
        ];
        return view('user.dashboard', compact('stats'));
    }
}
