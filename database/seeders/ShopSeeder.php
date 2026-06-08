<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Shop;
use App\Models\User;

class ShopSeeder extends Seeder
{
    public function run(): void
    {
        $namedSellers = [
            ['email' => 'suwito@craftive.id', 'shop' => 'Gerabah Kasongan Pak Suwito', 'desc' => 'Workshop gerabah tradisional turun-temurun dari Desa Kasongan, Bantul. Spesialisasi vas, guci, dan dekorasi gerabah etnik.', 'address' => 'Desa Kasongan, Bantul, Yogyakarta'],
            ['email' => 'kartini@craftive.id', 'shop' => 'Batik Laweyan Bu Kartini', 'desc' => 'Rumah produksi batik tulis dan cap premium dari Kampung Batik Laweyan, Solo. Menggunakan pewarna alami.', 'address' => 'Kampung Batik Laweyan, Solo'],
            ['email' => 'agus@craftive.id', 'shop' => 'Anyaman Rajapolah Mas Agus', 'desc' => 'Kerajinan anyaman bambu dan rotan berkualitas dari Rajapolah, Tasikmalaya. Mulai dari tas hingga dekorasi rumah.', 'address' => 'Desa Rajapolah, Tasikmalaya'],
        ];

        foreach ($namedSellers as $s) {
            $user = User::where('email', $s['email'])->first();
            if ($user) {
                Shop::create([
                    'user_id' => $user->id,
                    'name' => $s['shop'],
                    'description' => $s['desc'],
                    'address' => $s['address'],
                    'is_verified' => true,
                ]);
            }
        }

        // Toko tambahan untuk seller lainnya
        $otherSellers = User::where('role', 'seller')
            ->whereNotIn('email', ['suwito@craftive.id', 'kartini@craftive.id', 'agus@craftive.id'])
            ->get();

        $shopNames = [
            'Ukiran Jepara Indah', 'Tenun Flores Cantik', 'Keramik Bali Artistik',
            'Lukisan Ubud Gallery', 'Kulit Garut Premium', 'Wayang Surakarta',
            'Songket Palembang Asli'
        ];

        foreach ($otherSellers as $i => $seller) {
            $name = $shopNames[$i] ?? "Toko Kerajinan " . ($i + 4);
            Shop::create([
                'user_id' => $seller->id,
                'name' => $name,
                'description' => "Menjual berbagai macam produk kerajinan tangan berkualitas tinggi dari pengrajin lokal Indonesia.",
                'address' => "Jl. Kerajinan No. " . ($i + 4) . ", Indonesia",
                'is_verified' => true,
            ]);
        }
    }
}