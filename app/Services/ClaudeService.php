<?php
namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ClaudeService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('ANTHROPIC_API_KEY');
        $this->client = new Client([
            'base_uri' => 'https://api.anthropic.com/v1/',
            'timeout'  => 10,
        ]);
    }

    /**
     * Send recommendation request to Claude and return product data array.
     *
     * @param array $input user inputs (budget, kategori, style, occasion)
     * @return array
     * @throws \Exception when API key missing or request fails
     */
    public function recommend(array $input): array
    {
        if (empty($this->apiKey)) {
            throw new \Exception('Claude API key not configured');
        }

        $prompt = $this->buildPrompt($input);

        $response = $this->client->post('messages', [
            'headers' => [
                'x-api-key'   => $this->apiKey,
                'Content-Type'=> 'application/json',
            ],
            'json' => [
                'model' => 'claude-sonnet-4-20250514',
                'max_tokens' => 1024,
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        $content = $data['content'] ?? '';
        // Expect Claude returns JSON string with key "product_ids"
        $decoded = json_decode($content, true);
        $ids = $decoded['product_ids'] ?? [];

        if (empty($ids)) {
            // If Claude didn't give ids, fallback to empty array
            return [];
        }

        // Load full product details
        $products = \App\Models\Product::whereIn('id', $ids)->get();
        return $products->map(function ($p) {
            return [
                'id'      => $p->id,
                'name'    => $p->name,
                'price'   => $p->price,
                'rating'  => $p->rating_avg,
                'match'   => $p->confidence ?? '90%',
            ];
        })->toArray();
    }

    /**
     * Build the textual prompt for Claude based on user input.
     */
    private function buildPrompt(array $input): string
    {
        return sprintf(
            "Berikan 3 rekomendasi produk Craftive dengan budget %s, kategori %s, style %s, occasion %s. Kembalikan dalam format JSON berisi product_ids.",
            $input['budget'] ?? 'tidak terbatas',
            $input['kategori'] ?? 'semua',
            $input['style'] ?? 'any',
            $input['occasion'] ?? 'any'
        );
    }
}
?>
