<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Administrator Craftive',
            'email' => 'admin@craftive.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081200000001',
            'address' => 'Kantor Pusat Craftive, Jakarta'
        ]);

        // Seller - Pak Suwito (Pengrajin Gerabah)
        User::create([
            'name' => 'Pak Suwito',
            'email' => 'suwito@craftive.id',
            'password' => Hash::make('password'),
            'role' => 'seller',
            'phone' => '081234567890',
            'address' => 'Desa Kasongan, Bantul, Yogyakarta'
        ]);

        // Seller - Bu Kartini (Pengrajin Batik)
        User::create([
            'name' => 'Bu Kartini',
            'email' => 'kartini@craftive.id',
            'password' => Hash::make('password'),
            'role' => 'seller',
            'phone' => '081234567891',
            'address' => 'Kampung Batik Laweyan, Solo'
        ]);

        // Seller - Mas Agus (Pengrajin Anyaman)
        User::create([
            'name' => 'Mas Agus',
            'email' => 'agus@craftive.id',
            'password' => Hash::make('password'),
            'role' => 'seller',
            'phone' => '081234567892',
            'address' => 'Desa Rajapolah, Tasikmalaya'
        ]);

        // Seller Tambahan
        for ($i = 1; $i <= 7; $i++) {
            User::create([
                'name' => "Pengrajin Nusantara $i",
                'email' => "seller$i@craftive.id",
                'password' => Hash::make('password'),
                'role' => 'seller',
                'phone' => '08120000' . str_pad($i + 10, 4, '0', STR_PAD_LEFT),
                'address' => "Jl. Kerajinan No. $i, Indonesia"
            ]);
        }

        // Buyer - Adinda H (User Mahasiswa)
        User::create([
            'name' => 'Adinda H',
            'email' => 'sharllandinshy68@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'buyer',
            'phone' => '081234567899',
            'address' => 'Jl. Ketintang No. 12, Surabaya'
        ]);

        // Buyer - Siti Rahayu (User Utama)
        User::create([
            'name' => 'Siti Rahayu',
            'email' => 'siti@craftive.id',
            'password' => Hash::make('password'),
            'role' => 'buyer',
            'phone' => '081298765432',
            'address' => 'Jl. Sudirman No. 45, Jakarta Selatan'
        ]);

        // Buyer Tambahan
        for ($i = 1; $i <= 19; $i++) {
            User::create([
                'name' => "Buyer $i",
                'email' => "buyer$i@craftive.id",
                'password' => Hash::make('password'),
                'role' => 'buyer',
                'phone' => '08130000' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'address' => "Jl. Pembeli No. $i, Indonesia"
            ]);
        }
    }
}