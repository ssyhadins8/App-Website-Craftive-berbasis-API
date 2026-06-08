<?php
namespace App\Http\Controllers\Seller;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class SellerProductController extends Controller
{
    public function index()
    {
        $shop = Auth::guard('api')->user()->shop;
        if (!$shop) return response()->json(['message' => 'No shop found'], 404);
        return response()->json($shop->products()->paginate(10));
    }

    public function store(Request $request)
    {
        $shop = Auth::guard('api')->user()->shop;
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'style' => 'nullable|string',
            'target_demographic' => 'nullable|string'
        ]);
        $validated['shop_id'] = $shop->id;
        return response()->json(Product::create($validated), 201);
    }

    public function update(Request $request, $id)
    {
        $shop = Auth::guard('api')->user()->shop;
        if (!$shop) return response()->json(['message' => 'No shop found'], 404);
        $product = $shop->products()->findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'sometimes|required|exists:categories,id',
            'name' => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
            'style' => 'nullable|string',
            'target_demographic' => 'nullable|string'
        ]);

        $product->update($validated);
        return response()->json($product);
    }

    public function destroy($id)
    {
        $shop = Auth::guard('api')->user()->shop;
        if (!$shop) return response()->json(['message' => 'No shop found'], 404);
        $product = $shop->products()->findOrFail($id);
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }
}