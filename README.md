# Craftive - Premium Handmade Goods Marketplace & REST API

[![Laravel Version](https://img.shields.io/badge/Laravel-v12.0-red?style=flat-square&logo=laravel)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-%5E8.2-blue?style=flat-square&logo=php)](https://php.net)
[![JWT Auth](https://img.shields.io/badge/JWT--Auth-v2.3-orange?style=flat-square&logo=json-web-tokens)](https://github.com/tymon/jwt-auth)
[![Swagger](https://img.shields.io/badge/OpenAPI-3.0-green?style=flat-square&logo=swagger)](https://swagger.io)
[![Postman](https://img.shields.io/badge/Postman-Tested-orange?style=flat-square&logo=postman)](https://postman.com)

**Craftive** adalah platform marketplace berbasis website dan REST API yang dikhususkan untuk produk kriya premium buatan tangan seniman lokal Indonesia. Aplikasi ini dikembangkan untuk memenuhi tugas proyek kelompok **Ujian Akhir Semester (UAS) Pemrograman API**.

Platform ini dilengkapi dengan fitur unggulan **Agentic AI Custom Planner** yang bertindak sebagai asisten kalkulasi biaya dan negosiasi dinamis untuk kerajinan kustom secara transparan.

---

## 🎓 Informasi Akademik
*   **Mata Kuliah:** Pemrograman API
*   **Program Studi:** D4 Manajemen Informatika, Jurusan Teknik Informatika
*   **Fakultas:** Vokasi, Universitas Negeri Surabaya (UNESA)
*   **Tahun Akademik:** Genap 2025/2026
*   **Dosen Pengampu:** M Adamu Islam Mashuri, S.Tr.T., M.Tr.Kom (Pak Adam)
*   **Disusun Oleh:** Selvi Adinda H. (NIM: **24091397145**)

---

## ✨ Fitur-Fitur Utama Platform

1.  **Katalog Produk Kriya:** Menampilkan produk kerajinan tangan lokal yang terbagi berdasarkan kategori material, asal sanggar, tingkat rating ulasan, dan gaya desain (estetika).
2.  **Sistem Keranjang & Checkout (Multi-Seller Cart Routing):** Mendukung pembelian produk kriya dari berbagai sanggar perajin sekaligus dalam satu transaksi, dengan sistem pemotongan stok aman.
3.  **Strict Order Workflow & Payment:** Alur pembayaran aman di mana pembeli dapat mengunggah bukti transfer bank digital dalam format string Base64 untuk divalidasi oleh Administrator.
4.  **Agentic AI Custom Planner (Fitur Unggulan):** Simulasi AI dinamis untuk menganalisis spesifikasi kriya buatan tangan guna menerbitkan estimasi detail biaya bahan baku, biaya jasa tukang, durasi pengerjaan, tingkat kesulitan, serta rekomendasi sanggar yang ideal.
5.  **Relasi Sistem Custom Proposal:** Pembeli dapat mengirimkan proposal resmi hasil perencanaan AI ke perajin. Jika disetujui oleh perajin, sistem akan membuat entri transaksi pesanan baru secara otomatis di database.

---

## 🔒 Arsitektur Keamanan & Otorisasi API

Sistem REST API dirancang kokoh menggunakan perlindungan keamanan tiga lapis:
1.  **API Key Statis (`X-API-KEY`):** Melindungi katalog umum (`GET /api/catalog/products`) dari aktivitas scraping data massal oleh bot luar.
2.  **HTTP Basic Authentication:** Autentikasi cepat terenkripsi Base64 untuk membaca data profil dasar secara reaktif (`GET /api/profile/me`).
3.  **JSON Web Token (JWT) Bearer Token:** Autentikasi *stateless* menggunakan tanda tangan kunci rahasia untuk mengamankan seluruh rute transaksi sensitif (keranjang, checkout, dashboard, dan persetujuan proposal).
4.  **Role-Based Access Control (RBAC):** Middleware khusus untuk menyaring hak akses rute berdasarkan peran pengguna (`buyer`, `seller`, dan `admin`).

---

## 🛠️ Panduan Instalasi & Setup Proyek

Ikuti langkah-langkah di bawah ini untuk menjalankan proyek di lingkungan lokal (XAMPP):

### 1. Prasyarat System
*   PHP >= 8.2
*   Composer
*   MySQL (melalui XAMPP)
*   Node.js (LTS) & NPM

### 2. Langkah Instalasi
Clone atau download repositori ini ke folder server lokal kamu (misal: `C:/xampp/htdocs/craftive`):

```bash
# 1. Masuk ke folder proyek
cd craftive

# 2. Instalasi package composer (PHP) & NPM (JavaScript)
composer install
npm install

# 3. Salin berkas lingkungan (.env)
copy .env.example .env

# 4. Generate key aplikasi utama & kunci rahasia JWT
php artisan key:generate
php artisan jwt:secret

# 5. Konfigurasi database di file .env Anda:
# DB_DATABASE=craftive
# DB_USERNAME=root
# DB_PASSWORD=

# 6. Jalankan migrasi tabel database beserta data awal (Seeding)
php artisan migrate --seed

# 7. Jalankan server lokal Laravel
php artisan serve
```

API sekarang berjalan dan dapat diakses pada alamat: **`http://127.0.0.1:8000/api`**

---

## 🌐 Dokumentasi API Interaktif (Swagger UI)

Proyek ini telah dilengkapi dengan dokumentasi interaktif **Swagger UI** (OpenAPI Specification 3.0) untuk memudahkan eksplorasi dan pengujian live endpoint tanpa perlu membuka Postman.

*   **URL Dokumentasi:** [http://localhost/craftive/public/api/documentation](http://localhost/craftive/public/api/documentation)  
    *(Atau jika menggunakan `artisan serve`: [http://127.0.0.1:8000/api/documentation](http://127.0.0.1:8000/api/documentation))*
*   **URL Akses Cepat:** `/docs` (akan dialihkan otomatis).

Kamu dapat melakukan otorisasi menggunakan tombol **Authorize** di halaman tersebut lalu menguji seluruh skenario API secara langsung menggunakan tombol **Try it out**.

---

## 📬 Pengujian API dengan Postman

Berkas koleksi Postman sudah tersedia di dalam repositori ini:
*   **File Koleksi:** `Craftive_API_Postman_Collection.json` (berada di root folder proyek).
*   **Cara Pakai:** Buka Postman -> Klik **Import** -> Pilih file tersebut -> Buat Environment dengan variabel `base_url` bernilai `http://127.0.0.1:8000/api` -> Jalankan pengujian secara berurutan.

---

## 📄 Berkas Laporan & Panduan Ujian
Seluruh laporan tugas akhir dan cheat sheet ujian telah dicetak ke berkas PDF berikut:
*   📘 **Laporan Tugas Akhir UAS:** [LAPORAN_UAS.pdf](LAPORAN_UAS.pdf)
*   🎓 **Panduan Uji & Q&A Demo API:** [PANDUAN_DEMO_API.pdf](PANDUAN_DEMO_API.pdf)
