<?php
namespace App\Http\Controllers;

use OpenApi\Attributes as OA;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\AiRecommendation;
use Illuminate\Support\Facades\Auth;

#[OA\Tag(name: 'AI Recommendation', description: 'Rekomendasi produk dan perencanaan kriya custom berbasis AI Rule-Based.')]
class AiRecommendationController extends Controller
{
    #[OA\Post(
        path: '/ai/recommend',
        tags: ['AI Recommendation'],
        summary: 'Rekomendasi Produk AI',
        description: 'Merekomendasikan hingga 3 produk sesuai budget dan style. Tidak perlu login, cukup API Key.',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['budget'],
                properties: [
                    new OA\Property(property: 'budget', type: 'number', example: 500000, description: 'Budget maksimum dalam Rupiah'),
                    new OA\Property(property: 'style', type: 'string', example: 'minimalist', description: 'Gaya produk (opsional)'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Rekomendasi berhasil',
                content: new OA\JsonContent(properties: [
                    new OA\Property(property: 'message', type: 'string', example: 'CRAFTIVE AI Recommendation'),
                    new OA\Property(property: 'recommendations', type: 'array', items: new OA\Items(properties: [
                        new OA\Property(property: 'id', type: 'integer'),
                        new OA\Property(property: 'name', type: 'string'),
                        new OA\Property(property: 'price', type: 'number'),
                        new OA\Property(property: 'rating', type: 'number'),
                        new OA\Property(property: 'match', type: 'string', example: '92%'),
                        new OA\Property(property: 'image_url', type: 'string'),
                        new OA\Property(property: 'style', type: 'string'),
                    ])),
                ])
            ),
            new OA\Response(response: 422, description: 'Validasi gagal'),
        ]
    )]
    public function recommend(Request $request)
    {
        $request->validate([
            'budget' => 'required|numeric',
            'style' => 'nullable|string',
        ]);

        $budget = $request->budget;
        $style = $request->style;

        // Query products matching budget
        $query = Product::where('is_active', true)->where('price', '<=', $budget);

        // Optional filtering by style
        if ($style) {
            $query->where(function ($q) use ($style) {
                $q->where('style', 'like', "%{$style}%")
                  ->orWhere('description', 'like', "%{$style}%")
                  ->orWhereJsonContains('tags', $style);
            });
        }

        $products = $query->orderBy('rating_avg', 'desc')->take(3)->get();

        $resultData = $products->map(function ($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'price' => $p->price,
                'rating' => $p->rating_avg,
                'match' => rand(85, 98) . '%',
                'image_url' => $p->image_url,
                'style' => $p->style
            ];
        });

        $user = Auth::guard('api')->user();

        // Save recommendation history
        AiRecommendation::create([
            'user_id' => $user ? $user->id : null,
            'input_data' => $request->only(['budget', 'style']),
            'result_data' => $resultData->toArray()
        ]);

        return response()->json([
            'message' => 'CRAFTIVE AI Recommendation',
            'recommendations' => $resultData
        ]);
    }

    #[OA\Post(
        path: '/buyer/custom-planner',
        tags: ['AI Recommendation'],
        summary: 'AI Custom Planner (Kriya)',
        description: 'Merencanakan produk kriya custom. AI menghitung biaya, tingkat kesulitan, estimasi hari, dan merekomendasikan artisan. Wajib login sebagai buyer.',
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['specifications', 'materials', 'budget', 'timeline'],
                properties: [
                    new OA\Property(property: 'specifications', type: 'string', example: 'Tas anyaman rotan ukuran 30x20cm dengan tali panjang'),
                    new OA\Property(property: 'materials', type: 'string', example: 'rotan alam, benang katun'),
                    new OA\Property(property: 'budget', type: 'number', example: 750000, description: 'Minimal Rp 10.000'),
                    new OA\Property(property: 'timeline', type: 'integer', example: 14, description: 'Hari pengerjaan (minimal 1)'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Rencana berhasil dibuat',
                content: new OA\JsonContent(properties: [
                    new OA\Property(property: 'message', type: 'string', example: 'CRAFTIVE AI Custom Planner'),
                    new OA\Property(property: 'planning', type: 'object', properties: [
                        new OA\Property(property: 'difficulty', type: 'string', example: 'Sedang'),
                        new OA\Property(property: 'material_cost', type: 'number', example: 262500),
                        new OA\Property(property: 'labor_cost', type: 'number', example: 337500),
                        new OA\Property(property: 'estimated_price', type: 'number', example: 600000),
                        new OA\Property(property: 'estimated_days', type: 'integer', example: 13),
                        new OA\Property(property: 'shop_recommendation', type: 'string', example: 'Sanggar Batik Nusantara'),
                        new OA\Property(property: 'agent_reasoning', type: 'string'),
                    ]),
                ])
            ),
            new OA\Response(response: 401, description: 'Unauthorized - Token tidak valid'),
            new OA\Response(response: 422, description: 'Validasi gagal'),
        ]
    )]
    public function planCustomKriya(Request $request)
    {
        $request->validate([
            'specifications' => 'required|string',
            'materials' => 'required|string',
            'budget' => 'required|numeric|min:10000',
            'timeline' => 'required|integer|min:1'
        ]);

        $specs = $request->specifications;
        $materials = $request->materials;
        $budget = $request->budget;
        $timeline = $request->timeline;

        // Find verified shop to recommend
        $shop = \App\Models\Shop::where('is_verified', true)->inRandomOrder()->first()
                ?? \App\Models\Shop::inRandomOrder()->first();
        $shopName = $shop ? $shop->name : "Sanggar Kriya Utama";
        $shopAddress = $shop ? $shop->address : "Yogyakarta, Indonesia";

        // Estimate difficulty
        $difficulty = "Mudah";
        if ($timeline < 7 || strlen($specs) > 100) {
            $difficulty = "Sedang";
        }
        if ($timeline < 4 || $budget > 1000000) {
            $difficulty = "Sangat Rumit";
        }

        // Estimations
        $materialCost = $budget * 0.35;
        $laborCost = $budget * 0.45;
        $estimatedPrice = $materialCost + $laborCost;
        $estimatedDays = max(3, min($timeline - 1, 14));

        // Reasoning
        $reasoning = "Berdasarkan spesifikasi custom yang Anda masukkan untuk '" . $specs . "', Asisten AI menganalisis bahwa penggunaan bahan '" . $materials . "' memiliki tingkat kesulitan '" . $difficulty . "'. Kami menyarankan pengerjaan dilakukan di studio '" . $shopName . "' (" . $shopAddress . ") yang memiliki keahlian kriya tersebut. Proses pengerjaan manual membutuhkan waktu sekitar " . $estimatedDays . " hari kerja agar hasil pengeringan dan pewarnaan selesai secara sempurna.";

        $resultData = [
            'specifications' => $specs,
            'materials' => $materials,
            'budget' => (double)$budget,
            'timeline_requested' => (int)$timeline,
            'difficulty' => $difficulty,
            'material_cost' => $materialCost,
            'labor_cost' => $laborCost,
            'estimated_price' => $estimatedPrice,
            'estimated_days' => $estimatedDays,
            'shop_recommendation' => $shopName,
            'agent_reasoning' => $reasoning
        ];

        $user = Auth::guard('api')->user();

        // Save AI Planning History
        AiRecommendation::create([
            'user_id' => $user ? $user->id : null,
            'input_data' => $request->only(['specifications', 'materials', 'budget', 'timeline']),
            'result_data' => $resultData
        ]);

        return response()->json([
            'message' => 'CRAFTIVE AI Custom Planner',
            'planning' => $resultData
        ]);
    }
}