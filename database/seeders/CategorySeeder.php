<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Keramik & Gerabah', 'icon' => '', 'description' => 'Vas bunga, cangkir tanah liat, piring saji, dan dekorasi unik khas perajin.'],
            ['name' => 'Kayu & Pahat', 'icon' => '', 'description' => 'Kotak perhiasan jati, tatakan kayu, nampan ukir, dan aksesoris kayu.'],
            ['name' => 'Tekstil & Batik', 'icon' => '', 'description' => 'Kain batik tulis, kemeja batik cap, tenun ikat, dan syal tradisional.'],
            ['name' => 'Anyaman Serat Alam', 'icon' => '', 'description' => 'Keranjang rotan, tas pandan, tatakan gelas macrame, dan anyaman bambu.'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}