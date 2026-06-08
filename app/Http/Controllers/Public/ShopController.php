<?php
namespace App\Http\Controllers\Public;
use App\Http\Controllers\Controller;
use App\Models\Shop;

class ShopController extends Controller
{
    public function index()
    {
        return response()->json(Shop::where('is_verified', true)->paginate(10));
    }

    public function show($id)
    {
        $shop = Shop::with('products')->findOrFail($id);
        return response()->json($shop);
    }
}