<?php
namespace App\Http\Controllers\Buyer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        return response()->json(Auth::guard('api')->user()->carts()->with('product')->get());
    }

    public function store(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id', 'qty' => 'required|integer|min:1']);
        $userId = Auth::guard('api')->id();
        $cart = Cart::where('user_id', $userId)
                    ->where('product_id', $request->product_id)
                    ->first();

        if ($cart) {
            $cart->qty += $request->qty;
            $cart->save();
        } else {
            $cart = Cart::create([
                'user_id' => $userId,
                'product_id' => $request->product_id,
                'qty' => $request->qty
            ]);
        }
        return response()->json($cart, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate(['qty' => 'required|integer|min:1']);
        $cart = Cart::where('user_id', Auth::guard('api')->id())->where('id', $id)->firstOrFail();
        $cart->qty = $request->qty;
        $cart->save();
        return response()->json($cart);
    }

    public function destroy($id)
    {
        Cart::where('user_id', Auth::guard('api')->id())->where('id', $id)->delete();
        return response()->json(['message' => 'Cart item deleted']);
    }
}