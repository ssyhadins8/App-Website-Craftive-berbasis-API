<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Shop;
use App\Models\Category;
use App\Models\Product;
use App\Models\AiRecommendation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AiPlannerTest extends TestCase
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

    public function test_authenticated_user_can_use_ai_custom_planner()
    {
        // Setup database records
        $user = User::factory()->create(['role' => 'buyer']);
        $seller = User::factory()->create(['role' => 'seller']);
        $shop = Shop::create([
            'user_id' => $seller->id,
            'name' => 'Sanggar Ukir Kasongan',
            'description' => 'Sanggar ukiran Kasongan',
            'phone' => '081234567890',
            'address' => 'Kasongan, Bantul',
            'is_verified' => true
        ]);

        $headers = $this->getAuthHeader($user);

        $payload = [
            'specifications' => 'Meja kopi kayu jati bulat diameter 60cm dengan ukir mega mendung',
            'materials' => 'Kayu Jati, Politur',
            'budget' => 500000,
            'timeline' => 7
        ];

        $response = $this->postJson('/api/ai/custom-planner', $payload, $headers);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'message',
                     'planning' => [
                         'specifications',
                         'materials',
                         'budget',
                         'timeline_requested',
                         'difficulty',
                         'material_cost',
                         'labor_cost',
                         'estimated_price',
                         'estimated_days',
                         'shop_recommendation',
                         'agent_reasoning'
                     ]
                 ]);

        $this->assertDatabaseHas('ai_recommendations', [
            'user_id' => $user->id
        ]);
    }

    public function test_admin_can_perform_crud_operations()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $seller = User::factory()->create(['role' => 'seller']);
        $shop = Shop::create([
            'user_id' => $seller->id,
            'name' => 'Toko Kerajinan',
            'description' => 'Deskripsi Toko',
            'phone' => '081234567800',
            'address' => 'Bandung',
            'is_verified' => false
        ]);
        $category = Category::create([
            'name' => 'Gerabah',
            'icon' => '🏺',
            'description' => 'Gerabah premium'
        ]);

        $headers = $this->getAuthHeader($admin);

        // Test Get Products
        $response = $this->getJson('/api/admin/products', $headers);
        $response->assertStatus(200);

        // Test Create Product
        $productPayload = [
            'shop_id' => $shop->id,
            'category_id' => $category->id,
            'name' => 'Pot Tanah Liat Kasongan',
            'description' => 'Pot premium buatan perajin lokal',
            'price' => 75000,
            'stock' => 10,
            'style' => 'Tradisional',
            'target_demographic' => 'dewasa'
        ];

        $createResponse = $this->postJson('/api/admin/products', $productPayload, $headers);
        $createResponse->assertStatus(201);
        $productId = $createResponse->json('product.id');

        // Test Update Product
        $updatePayload = [
            'category_id' => $category->id,
            'name' => 'Pot Tanah Liat Kasongan Edit',
            'description' => 'Pot premium buatan perajin lokal edit',
            'price' => 80000,
            'stock' => 5,
            'style' => 'Modern',
            'target_demographic' => 'remaja',
            'is_active' => false
        ];

        $updateResponse = $this->putJson("/api/admin/products/{$productId}", $updatePayload, $headers);
        $updateResponse->assertStatus(200);

        // Test Delete Product
        $deleteResponse = $this->deleteJson("/api/admin/products/{$productId}", [], $headers);
        $deleteResponse->assertStatus(200);

        // Test Verify Shop
        $verifyResponse = $this->putJson("/api/admin/shops/{$shop->id}/verify", ['is_verified' => true], $headers);
        $verifyResponse->assertStatus(200);
        $this->assertEquals(true, Shop::find($shop->id)->is_verified);
    }
}
