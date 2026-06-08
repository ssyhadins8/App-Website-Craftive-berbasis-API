<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Shop;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CustomProposal;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\Facades\JWTAuth;

class CustomProposalsAndReviewsTest extends TestCase
{
    use RefreshDatabase;

    private function getAuthHeader(User $user)
    {
        $token = JWTAuth::fromUser($user);
        return [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
            'X-API-KEY' => 'craftive-public-key-2026',
        ];
    }

    public function test_custom_proposal_workflow_and_strict_order_and_reviews()
    {
        // 1. Setup Users, Shop, and Category
        $buyer = User::factory()->create(['role' => 'buyer', 'address' => 'Surabaya']);
        $seller = User::factory()->create(['role' => 'seller']);
        $shop = Shop::create([
            'user_id' => $seller->id,
            'name' => 'Kerajinan Kasongan',
            'description' => 'Toko kerajinan tradisional',
            'phone' => '081234567890',
            'address' => 'Yogyakarta',
            'is_verified' => true
        ]);
        $category = Category::create([
            'name' => 'Gerabah',
            'icon' => '🏺',
            'description' => 'Kriya gerabah'
        ]);

        $buyerHeaders = $this->getAuthHeader($buyer);
        $sellerHeaders = $this->getAuthHeader($seller);

        // 2. Buyer submits Custom Proposal
        $proposalPayload = [
            'craft_type' => 'Meja Ukir Jati',
            'material' => 'Kayu Jati',
            'budget' => 500000,
            'deadline_days' => 14,
            'description' => 'Meja bulat motif mega mendung',
            'difficulty' => 'Sedang',
            'estimated_days' => 10,
            'material_cost' => 150000,
            'labor_cost' => 300000,
            'shop_recommendation' => 'Kerajinan Kasongan',
            'agent_reasoning' => 'Taksiran AI mencukupi.'
        ];

        $response = $this->postJson('/api/custom-proposals', $proposalPayload, $buyerHeaders);
        $response->assertStatus(201);
        $proposalId = $response->json('proposal.id');

        $this->assertDatabaseHas('custom_proposals', [
            'id' => $proposalId,
            'status' => 'pending',
            'seller_id' => $seller->id
        ]);

        // 3. Seller accepts Proposal -> Spawns Order
        $acceptResponse = $this->putJson("/api/custom-proposals/{$proposalId}/accept", [], $sellerHeaders);
        $acceptResponse->assertStatus(200);
        $orderId = $acceptResponse->json('order.id');

        $this->assertDatabaseHas('custom_proposals', [
            'id' => $proposalId,
            'status' => 'accepted',
            'order_id' => $orderId
        ]);

        $this->assertDatabaseHas('orders', [
            'id' => $orderId,
            'buyer_id' => $buyer->id,
            'seller_id' => $seller->id,
            'status' => 'pending'
        ]);

        // 4. STRICT WORKFLOW TEST: Seller attempts to process pending (unpaid) order -> Denied (403)
        $processResponse = $this->putJson("/api/seller/orders/{$orderId}", ['status' => 'shipped'], $sellerHeaders);
        $processResponse->assertStatus(403);

        // 5. Admin confirms payment (simulated by updating order status to 'paid')
        $order = Order::find($orderId);
        $order->update(['status' => 'paid']);

        // 6. Seller processes order now -> Allowed
        $processResponse = $this->putJson("/api/seller/orders/{$orderId}", ['status' => 'shipped'], $sellerHeaders);
        $processResponse->assertStatus(200);
        $this->assertEquals('shipped', Order::find($orderId)->status);

        // 7. Complete the order (mark as delivered)
        $completeResponse = $this->putJson("/api/seller/orders/{$orderId}", ['status' => 'delivered'], $sellerHeaders);
        $completeResponse->assertStatus(200);
        $this->assertEquals('delivered', Order::find($orderId)->status);

        // 8. Buyer submits a review
        $product = Product::where('shop_id', $shop->id)->first(); // Spawned by accepted proposal
        $this->assertNotNull($product);

        $reviewPayload = [
            'order_id' => $orderId,
            'product_id' => $product->id,
            'rating' => 5,
            'comment' => 'Karya yang sangat luar biasa indah dan rapi!'
        ];

        $reviewResponse = $this->postJson('/api/reviews', $reviewPayload, $buyerHeaders);
        $reviewResponse->assertStatus(201);

        $this->assertDatabaseHas('reviews', [
            'user_id' => $buyer->id,
            'product_id' => $product->id,
            'rating' => 5
        ]);

        // Check if rating_avg was updated on the product
        $product = Product::find($product->id);
        $this->assertEquals(5.0, (double)$product->rating_avg);

        // 9. Public reviews fetch
        $publicReviewsResponse = $this->getJson("/api/products/{$product->id}/reviews", [
            'X-API-KEY' => 'craftive-public-key-2026'
        ]);
        $publicReviewsResponse->assertStatus(200)
                             ->assertJsonCount(1)
                             ->assertJsonFragment(['comment' => 'Karya yang sangat luar biasa indah dan rapi!']);
    }
}
