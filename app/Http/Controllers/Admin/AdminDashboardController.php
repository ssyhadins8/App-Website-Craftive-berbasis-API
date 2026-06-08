<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Shop;
use App\Models\Payment;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    // ── 1. STATS OVERVIEW ──
    public function index()
    {
        return response()->json([
            'total_users' => User::count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'revenue' => Order::where('status', 'delivered')->sum('total_amount'),
            'recent_orders' => Order::with(['buyer', 'seller'])->orderBy('created_at', 'desc')->take(5)->get()
        ]);
    }

    // ── 2. USER MANAGEMENT ──
    public function users()
    {
        return response()->json(User::orderBy('created_at', 'desc')->get());
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|in:buyer,seller,admin',
            'is_active' => 'required|boolean',
            'email' => 'required|email|unique:users,email,' . $id
        ]);

        $user->update($request->only(['name', 'email', 'role', 'is_active']));

        return response()->json(['message' => 'Pengguna berhasil diperbarui', 'user' => $user]);
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'Pengguna berhasil dihapus']);
    }

    // ── 3. PRODUCT MANAGEMENT (CRUD) ──
    public function products()
    {
        return response()->json(Product::with(['shop', 'category'])->orderBy('created_at', 'desc')->get());
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'shop_id' => 'required|exists:shops,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'style' => 'nullable|string',
            'target_demographic' => 'nullable|string|in:anak-anak,remaja,mahasiswa,dewasa',
            'images' => 'nullable|array',
            'image_url' => 'nullable|string'
        ]);

        $images = $request->images;
        if ($request->has('image_url') && $request->image_url) {
            $images = [$request->image_url];
        }

        $product = Product::create([
            'shop_id' => $request->shop_id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'style' => $request->style,
            'target_demographic' => $request->target_demographic,
            'images' => $images ?? ['https://images.unsplash.com/photo-1578749556568-bc2c40e68b61?w=600&auto=format&fit=crop'],
            'is_active' => true,
            'rating_avg' => 5.0
        ]);

        return response()->json(['message' => 'Produk berhasil ditambahkan', 'product' => $product], 201);
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'shop_id' => 'sometimes|required|exists:shops,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'style' => 'nullable|string',
            'target_demographic' => 'nullable|string|in:anak-anak,remaja,mahasiswa,dewasa',
            'is_active' => 'sometimes|required|boolean',
            'images' => 'nullable|array',
            'image_url' => 'nullable|string'
        ]);

        $data = $request->only([
            'shop_id', 'category_id', 'name', 'description', 'price', 'stock', 'style', 'target_demographic', 'is_active'
        ]);

        if ($request->has('image_url') && $request->image_url) {
            $data['images'] = [$request->image_url];
        } elseif ($request->has('images')) {
            $data['images'] = $request->images;
        }

        $product->update($data);

        return response()->json(['message' => 'Produk berhasil diperbarui', 'product' => $product]);
    }

    #[OA\Delete(
        path: '/admin/products/{id}',
        tags: ['Admin'],
        summary: 'Hapus Produk',
        description: 'Menghapus produk berdasarkan ID. Hanya untuk admin.',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                description: 'ID produk yang akan dihapus',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(response: 200, description: 'Produk berhasil dihapus'),
            new OA\Response(response: 404, description: 'Produk tidak ditemukan'),
            new OA\Response(response: 401, description: 'Tidak berwenang')
        ]
    )]
    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(['message' => 'Produk berhasil dihapus']);
    }

    public function approveProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['is_active' => true]);
        return response()->json(['message' => 'Produk berhasil disetujui', 'product' => $product]);
    }

    // ── 4. SHOP MANAGEMENT ──
    public function shops()
    {
        return response()->json(Shop::with('user')->orderBy('created_at', 'desc')->get());
    }

    public function verifyShop(Request $request, $id)
    {
        $shop = Shop::findOrFail($id);
        
        $request->validate([
            'is_verified' => 'required|boolean'
        ]);

        $shop->update(['is_verified' => $request->is_verified]);

        return response()->json(['message' => 'Status verifikasi toko berhasil diubah', 'shop' => $shop]);
    }

    public function deleteShop($id)
    {
        $shop = Shop::findOrFail($id);
        $shop->delete();
        return response()->json(['message' => 'Toko berhasil dihapus']);
    }

    // ── 5. TRANSACTION MANAGEMENT (ORDERS & PAYMENTS) ──
    public function orders()
    {
        return response()->json(
            Order::with(['buyer', 'seller', 'payment', 'items.product'])
                ->orderBy('created_at', 'desc')
                ->get()
        );
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,paid,shipped,delivered,cancelled',
            'payment_status' => 'nullable|in:pending,confirmed,rejected'
        ]);

        $order->update(['status' => $request->status]);

        if ($request->has('payment_status') && $order->payment) {
            $order->payment->update([
                'status' => $request->payment_status,
                'confirmed_at' => $request->payment_status === 'confirmed' ? Carbon::now() : null
            ]);

            // Jika pembayaran dikonfirmasi, otomatis ubah status pesanan ke paid
            if ($request->payment_status === 'confirmed' && $order->status === 'pending') {
                $order->update(['status' => 'paid']);
            }
        }

        return response()->json(['message' => 'Status transaksi berhasil diperbarui', 'order' => $order]);
    }
}