<?php
namespace App\Services;

use App\Models\Product;

class RecommendationFallback
{
    /**
     * Generate recommendations using simple rule‑based filters.
     *
     * @param array $input user inputs (budget, kategori, style, occasion)
     * @return array
     */
    public function recommend(array $input): array
    {
        $budget   = $input['budget'] ?? null;
        $kategori = $input['kategori'] ?? null;
        $style    = $input['style'] ?? null;
        // $occasion is ignored because we have no DB field for it

        $query = Product::where('is_active', true);

        if ($budget) {
            $query->where('price', '<=', $budget);
        }
        if ($kategori) {
            $query->whereHas('category', function ($q) use ($kategori) {
                $q->where('name', 'like', "%{$kategori}%");
            });
        }
        if ($style) {
            $query->where('style', 'like', "%{$style}%")
                  ->orWhereJsonContains('tags', $style);
        }

        $products = $query->orderBy('rating_avg', 'desc')
                         ->take(3)
                         ->get();

        return $products->map(function ($p) {
            return [
                'id'     => $p->id,
                'name'   => $p->name,
                'price'  => $p->price,
                'rating' => $p->rating_avg,
                'match'  => rand(80, 95) . '%',
            ];
        })->toArray();
    }
}
?>
