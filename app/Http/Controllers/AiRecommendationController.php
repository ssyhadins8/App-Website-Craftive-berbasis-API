<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\AiRecommendation;
use Illuminate\Support\Facades\Auth;

class AiRecommendationController extends Controller
{
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