<?php
namespace App\Http\Controllers\Buyer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        return response()->json(Auth::guard('api')->user()->orders()->with('items.product', 'payment')->get());
    }

    public function store(Request $request)
    {
        $request->validate(['shipping_address' => 'required|string']);
        $user = Auth::guard('api')->user();
        $carts = $user->carts()->with('product')->get();
        if($carts->isEmpty()) return response()->json(['message' => 'Cart is empty'], 400);

        // simplified: assuming single seller for now or grouping by seller logic
        $seller_id = $carts->first()->product->shop->user_id;
        $total_amount = $carts->sum(function($c) { return $c->qty * $c->product->price; });

        $order = Order::create([
            'buyer_id' => $user->id,
            'seller_id' => $seller_id,
            'total_amount' => $total_amount,
            'shipping_address' => $request->shipping_address,
            'notes' => $request->notes
        ]);

        foreach ($carts as $cart) {
            $order->items()->create([
                'product_id' => $cart->product_id,
                'qty' => $cart->qty,
                'price' => $cart->product->price
            ]);
        }
        $user->carts()->delete();

        return response()->json($order->load('items'), 201);
    }
}