<?php
namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomProposal;
use App\Models\Shop;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CustomProposalController extends Controller
{
    public function index()
    {
        $user = Auth::guard('api')->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $query = CustomProposal::with(['buyer', 'seller.shop', 'order']);

        if ($user->role === 'seller') {
            $query->where('seller_id', $user->id);
        } else if ($user->role === 'buyer') {
            $query->where('buyer_id', $user->id);
        }

        $proposals = $query->orderBy('created_at', 'desc')->get();

        return response()->json($proposals);
    }

    public function store(Request $request)
    {
        $user = Auth::guard('api')->user();
        if (!$user || $user->role !== 'buyer') {
            return response()->json(['message' => 'Hanya pembeli yang dapat mengajukan proposal custom.'], 403);
        }

        $request->validate([
            'craft_type' => 'required|string',
            'material' => 'required|string',
            'budget' => 'required|numeric|min:10000',
            'deadline_days' => 'required|integer|min:1',
            'description' => 'required|string',
            'difficulty' => 'required|string',
            'estimated_days' => 'required|integer',
            'material_cost' => 'required|numeric',
            'labor_cost' => 'required|numeric',
            'shop_recommendation' => 'required|string',
            'agent_reasoning' => 'nullable|string'
        ]);

        // Map recommended shop name to a seller user ID
        $shop = Shop::where('name', 'like', "%{$request->shop_recommendation}%")->first();
        if ($shop) {
            $sellerId = $shop->user_id;
        } else {
            // Find any verified seller or fallback
            $seller = User::where('role', 'seller')->inRandomOrder()->first();
            if (!$seller) {
                return response()->json(['message' => 'Tidak ada toko perajin terdaftar untuk menerima proposal.'], 404);
            }
            $sellerId = $seller->id;
        }

        $proposal = CustomProposal::create([
            'buyer_id' => $user->id,
            'seller_id' => $sellerId,
            'craft_type' => $request->craft_type,
            'material' => $request->material,
            'budget' => $request->budget,
            'deadline_days' => $request->deadline_days,
            'description' => $request->description,
            'difficulty' => $request->difficulty,
            'estimated_days' => $request->estimated_days,
            'material_cost' => $request->material_cost,
            'labor_cost' => $request->labor_cost,
            'shop_recommendation' => $request->shop_recommendation,
            'agent_reasoning' => $request->agent_reasoning,
            'status' => 'pending'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Proposal kriya custom berhasil diajukan.',
            'proposal' => $proposal
        ], 201);
    }

    public function accept($id)
    {
        $user = Auth::guard('api')->user();
        if (!$user || $user->role !== 'seller') {
            return response()->json(['message' => 'Hanya perajin yang dapat menyetujui proposal.'], 403);
        }

        $proposal = CustomProposal::where('seller_id', $user->id)->findOrFail($id);

        if ($proposal->status !== 'pending') {
            return response()->json(['message' => 'Proposal ini sudah diproses.'], 400);
        }

        // 1. Find or fallback shop
        $shop = Shop::where('user_id', $user->id)->first();
        if (!$shop) {
            return response()->json(['message' => 'Toko perajin Anda belum dikonfigurasi.'], 400);
        }

        // 2. Create custom product (so it aligns with relational design in orders/order_items)
        $category = Category::first() ?? Category::create([
            'name' => 'Custom Craft',
            'description' => 'Produk Kriya Custom AI'
        ]);

        $product = Product::create([
            'shop_id' => $shop->id,
            'category_id' => $category->id,
            'name' => 'Custom: ' . $proposal->craft_type,
            'description' => $proposal->description . ' (Bahan: ' . $proposal->material . ')',
            'price' => $proposal->budget,
            'stock' => 1,
            'is_active' => false,
            'images' => ['https://images.unsplash.com/photo-1618220179428-22790b461013?w=600&auto=format&fit=crop'],
            'style' => 'Custom',
            'rating_avg' => 5.0
        ]);

        // 3. Create Order
        $buyer = User::find($proposal->buyer_id);
        $order = Order::create([
            'buyer_id' => $proposal->buyer_id,
            'seller_id' => $proposal->seller_id,
            'total_amount' => $proposal->budget,
            'shipping_address' => $buyer->address ?? 'Alamat Pemesan Custom',
            'notes' => 'Pesanan Custom AI: ' . $proposal->craft_type,
            'status' => 'pending'
        ]);

        // 4. Create OrderItem
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'qty' => 1,
            'price' => $proposal->budget
        ]);

        // 5. Update proposal
        $proposal->update([
            'status' => 'accepted',
            'order_id' => $order->id
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Proposal disetujui. Pesanan transaksi #' . $order->id . ' telah dibuat.',
            'proposal' => $proposal,
            'order' => $order
        ]);
    }

    public function reject($id)
    {
        $user = Auth::guard('api')->user();
        if (!$user || $user->role !== 'seller') {
            return response()->json(['message' => 'Hanya perajin yang dapat menolak proposal.'], 403);
        }

        $proposal = CustomProposal::where('seller_id', $user->id)->findOrFail($id);

        if ($proposal->status !== 'pending') {
            return response()->json(['message' => 'Proposal ini sudah diproses.'], 400);
        }

        $proposal->update(['status' => 'rejected']);

        return response()->json([
            'status' => 'success',
            'message' => 'Proposal kriya custom berhasil ditolak.',
            'proposal' => $proposal
        ]);
    }

    public function destroy($id)
    {
        $user = Auth::guard('api')->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $proposal = CustomProposal::findOrFail($id);

        if ($user->role === 'buyer' && $proposal->buyer_id !== $user->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        if ($user->role === 'seller' && $proposal->seller_id !== $user->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $proposal->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Proposal berhasil dihapus dari sistem.'
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected'
        ]);

        if ($request->status === 'accepted') {
            return $this->accept($id);
        } else {
            return $this->reject($id);
        }
    }
}
