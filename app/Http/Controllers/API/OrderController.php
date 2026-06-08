<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // List orders for the authenticated buyer
    public function index()
    {
        $user = Auth::guard('api')->user();
        $orders = $user->orders()->with(['items.product', 'payment'])->get();
        return response()->json($orders);
    }

    // Create a new order from the buyer's cart
    public function store(Request $request)
    {
        $request->validate(['shipping_address' => 'required|string']);
        $user = Auth::guard('api')->user();
        $carts = $user->carts()->with('product')->get();
        if ($carts->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }
        // Assuming single seller per order (simplified)
        $seller_id = $carts->first()->product->shop->user_id;
        $total_amount = $carts->sum(fn($c) => $c->qty * $c->product->price);
        $order = Order::create([
            'buyer_id' => $user->id,
            'seller_id' => $seller_id,
            'total_amount' => $total_amount,
            'shipping_address' => $request->shipping_address,
            'notes' => $request->notes ?? null,
        ]);
        foreach ($carts as $cart) {
            $order->items()->create([
                'product_id' => $cart->product_id,
                'qty' => $cart->qty,
                'price' => $cart->product->price,
            ]);
        }
        // Clear cart after order creation
        $user->carts()->delete();
        return response()->json($order->load('items'), 201);
    }
}
?>
