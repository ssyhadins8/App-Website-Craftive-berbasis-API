<?php
namespace App\Http\Controllers\Seller;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class SellerOrderController extends Controller
{
    public function index()
    {
        return response()->json(Order::where('seller_id', Auth::guard('api')->id())->with('items.product')->paginate(10));
    }

    public function update(Request $request, $id)
    {
        $order = Order::where('seller_id', Auth::guard('api')->id())->findOrFail($id);
        
        if ($order->status === 'pending') {
            return response()->json([
                'status' => 'error',
                'message' => 'Pesanan belum dibayar atau pembayaran belum dikonfirmasi oleh Admin.'
            ], 403);
        }
        
        $request->validate([
            'status' => 'required|in:paid,shipped,delivered,cancelled'
        ]);

        $order->update(['status' => $request->status]);
        return response()->json($order);
    }
}