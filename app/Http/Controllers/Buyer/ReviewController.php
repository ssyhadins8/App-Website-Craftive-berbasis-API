<?php
namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index($productId)
    {
        $reviews = Review::where('product_id', $productId)
            ->with(['user' => function ($q) {
                $q->select('id', 'name', 'avatar');
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($reviews);
    }

    public function store(Request $request)
    {
        $user = Auth::guard('api')->user();
        if (!$user || $user->role !== 'buyer') {
            return response()->json(['message' => 'Hanya pembeli yang dapat memberikan ulasan.'], 403);
        }

        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);

        // Verify that the user has bought the product and that the order is delivered
        $order = Order::where('buyer_id', $user->id)
            ->where('status', 'delivered')
            ->whereHas('items', function ($q) use ($request) {
                $q->where('product_id', $request->product_id);
            })
            ->where('id', $request->order_id)
            ->first();

        if (!$order) {
            return response()->json([
                'message' => 'Anda hanya dapat memberikan ulasan pada produk yang telah Anda beli dan telah selesai dikirim.'
            ], 403);
        }

        // Check if user has already reviewed this product for this order
        $existing = Review::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->where('order_id', $request->order_id)
            ->first();

        if ($existing) {
            return response()->json([
                'message' => 'Anda sudah memberikan ulasan untuk produk ini pada pesanan ini.'
            ], 400);
        }

        // Save review
        $review = Review::create([
            'user_id' => $user->id,
            'product_id' => $request->product_id,
            'order_id' => $request->order_id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        // Recalculate average rating for the product
        $product = Product::find($request->product_id);
        $avgRating = Review::where('product_id', $product->id)->avg('rating');
        $product->update(['rating_avg' => $avgRating]);

        return response()->json([
            'status' => 'success',
            'message' => 'Ulasan berhasil disimpan.',
            'review' => $review
        ], 201);
    }
}
