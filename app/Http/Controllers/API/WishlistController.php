<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // List wishlist items for authenticated user
    public function index()
    {
        $user = Auth::guard('api')->user();
        $items = $user->wishlist()->with('product')->get();
        return response()->json($items);
    }

    // Add a product to wishlist
    public function store(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);
        $user = Auth::guard('api')->user();
        $wishlist = Wishlist::firstOrCreate([
            'user_id' => $user->id,
            'product_id' => $request->product_id,
        ]);
        return response()->json($wishlist, 201);
    }

    // Remove a product from wishlist
    public function destroy($id)
    {
        $user = Auth::guard('api')->user();
        $wishlist = Wishlist::where('user_id', $user->id)->where('product_id', $id)->firstOrFail();
        $wishlist->delete();
        return response()->json(['message' => 'Removed']);
    }
}
?>
