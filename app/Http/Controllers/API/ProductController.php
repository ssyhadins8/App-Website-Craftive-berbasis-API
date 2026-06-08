<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // List products (public) – same as existing but API version
    public function index(Request $request)
    {
        $query = Product::with(['shop', 'category']);
        if ($request->has('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->has('price_range')) {
            $range = $request->price_range;
            if ($range === 'low') {
                $query->where('price', '<', 50000);
            } elseif ($range === 'mid') {
                $query->whereBetween('price', [50000, 250000]);
            } elseif ($range === 'high') {
                $query->where('price', '>', 250000);
            }
        }
        return response()->json($query->paginate(12));
    }

    // Show single product
    public function show($id)
    {
        $product = Product::with(['shop', 'category', 'reviews.user'])->findOrFail($id);
        return response()->json($product);
    }

    // Create product (seller only)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'material' => 'nullable|string',
            'has_gift_option' => 'required|boolean',
        ]);
        $user = Auth::guard('api')->user();
        // assume seller has a shop
        $shop = $user->shop;
        $product = Product::create(array_merge($request->all(), [
            'shop_id' => $shop->id,
        ]));
        return response()->json($product, 201);
    }

    // Update product (owner seller)
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $this->authorize('update', $product);
        $product->update($request->all());
        return response()->json($product);
    }

    // Delete product (owner seller)
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $this->authorize('delete', $product);
        $product->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
?>
