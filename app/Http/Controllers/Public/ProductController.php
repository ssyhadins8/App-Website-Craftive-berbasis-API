<?php
namespace App\Http\Controllers\Public;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['shop', 'category'])->where('is_active', true);
        
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('shop_id')) {
            $query->where('shop_id', $request->shop_id);
        }

        if ($request->has('target_demographic')) {
            $query->where('target_demographic', $request->target_demographic);
        }

        if ($request->has('style')) {
            $query->where('style', $request->style);
        }

        // Filter berdasarkan range harga
        if ($request->has('price_range')) {
            $range = $request->price_range;
            if ($range === 'murah') {
                $query->where('price', '<', 50000);
            } elseif ($range === 'menengah') {
                $query->whereBetween('price', [50000, 250000]);
            } elseif ($range === 'tinggi') {
                $query->where('price', '>', 250000);
            }
        }

        return response()->json($query->paginate(12));
    }

    public function show($id)
    {
        $product = Product::with(['shop', 'category', 'reviews.user'])->findOrFail($id);
        return response()->json($product);
    }
}