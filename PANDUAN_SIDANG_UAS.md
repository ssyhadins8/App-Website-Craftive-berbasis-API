# 🎓 PANDUAN SIDANG UAS — CRAFTIVE API
## "Alur Kode dari Request ke Response"
> Dokumen ini membantu kamu menjawab pertanyaan penguji seperti:
> *"Kode ini ada di mana?"*, *"Endpoint ini nyambung ke mana?"*, *"Middleware-nya fungsinya apa?"*

---

## 📁 STRUKTUR FOLDER PENTING

```
craftive/
├── routes/
│   └── api.php              ← PINTU MASUK semua endpoint
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Controller.php              ← Base class (global Swagger info)
│   │   │   ├── Auth/
│   │   │   │   └── AuthController.php      ← Register, Login, Logout, Me
│   │   │   ├── Public/
│   │   │   │   ├── ProductController.php   ← Lihat produk (publik)
│   │   │   │   ├── CategoryController.php  ← Lihat kategori (publik)
│   │   │   │   └── ShopController.php      ← Lihat toko (publik)
│   │   │   ├── Buyer/
│   │   │   │   ├── CartController.php      ← Keranjang belanja
│   │   │   │   ├── OrderController.php     ← Buat & lihat pesanan
│   │   │   │   ├── PaymentController.php   ← Upload bukti pembayaran
│   │   │   │   ├── ReviewController.php    ← Beri ulasan produk
│   │   │   │   └── CustomProposalController.php ← Pesan kriya custom
│   │   │   ├── Seller/
│   │   │   │   ├── SellerProductController.php  ← Kelola produk milik seller
│   │   │   │   └── SellerOrderController.php    ← Kelola pesanan masuk
│   │   │   ├── Admin/
│   │   │   │   ├── AdminDashboardController.php ← Statistik & manajemen semua data
│   │   │   │   └── AdminCategoryController.php  ← Tambah kategori
│   │   │   └── AiRecommendationController.php   ← AI Planner & Rekomendasi
│   │   └── Middleware/
│   │       ├── JwtMiddleware.php    ← Cek token JWT valid
│   │       └── RoleMiddleware.php   ← Cek role user (buyer/seller/admin)
│   └── Models/
│       ├── User.php        ← Data pengguna + relasi ke Shop
│       ├── Product.php     ← Data produk + relasi ke Shop & Category
│       ├── Order.php       ← Data pesanan
│       ├── OrderItem.php   ← Item dalam pesanan
│       ├── Cart.php        ← Keranjang belanja
│       ├── Payment.php     ← Bukti pembayaran
│       ├── Shop.php        ← Data toko seller
│       ├── Category.php    ← Kategori produk
│       ├── Review.php      ← Ulasan produk
│       ├── CustomProposal.php  ← Pesanan kriya custom
│       └── AiRecommendation.php ← Riwayat rekomendasi AI
└── database/
    └── migrations/         ← Definisi struktur tabel database
```

---

## 🔄 ALUR KERJA SETIAP REQUEST (WAJIB HAFAL!)

```
CLIENT (Postman/Frontend)
        │
        ▼
  routes/api.php          ← Menentukan endpoint mana yang dipanggil
        │
        ▼
  MIDDLEWARE               ← Memeriksa izin akses
  ├── api.key             → Cek X-API-Key di header
  ├── jwt.auth (JwtMiddleware) → Cek Bearer Token JWT
  └── role:buyer/seller/admin (RoleMiddleware) → Cek role user
        │
        ▼
  CONTROLLER              ← Logika bisnis utama
  └── Mengambil data dari Model (Eloquent ORM)
        │
        ▼
  MODEL (Eloquent)        ← Berinteraksi dengan Database MySQL
        │
        ▼
  JSON RESPONSE           ← Dikirim balik ke client
```

---

## 🗺️ PETA ENDPOINT LENGKAP

### 🌍 1. PUBLIC ROUTES — Middleware: `api.key`
> Header wajib: `X-API-Key: craftive-secret-key-2024`

| Method | Endpoint | Controller | Method |
|--------|----------|------------|--------|
| GET | `/api/products` | ProductController | `index()` |
| GET | `/api/products/{id}` | ProductController | `show()` |
| GET | `/api/categories` | CategoryController | `index()` |
| GET | `/api/shops` | ShopController | `index()` |
| GET | `/api/shops/{id}` | ShopController | `show()` |
| POST | `/api/ai/recommend` | AiRecommendationController | `recommend()` |
| GET | `/api/products/{id}/reviews` | ReviewController | `index()` |

---

### 🔐 2. AUTH ROUTES — Tanpa Middleware (Publik)
> Tidak perlu token

| Method | Endpoint | Controller | Method | Fungsi |
|--------|----------|------------|--------|--------|
| POST | `/api/auth/register` | AuthController | `register()` | Daftar akun baru |
| POST | `/api/auth/login` | AuthController | `login()` | Masuk & dapat token JWT |
| POST | `/api/auth/forgot-password` | AuthController | `forgotPassword()` | Minta OTP reset password |
| POST | `/api/auth/reset-password` | AuthController | `resetPassword()` | Reset password pakai OTP |

> Header wajib (Basic Auth):

| Method | Endpoint | Fungsi |
|--------|----------|--------|
| GET | `/api/auth/basic-profile` | Profil via HTTP Basic Auth |
| GET | `/api/profile/me` | Profil via HTTP Basic Auth |

> Header wajib (JWT Token):

| Method | Endpoint | Controller | Method | Fungsi |
|--------|----------|------------|--------|--------|
| POST | `/api/auth/logout` | AuthController | `logout()` | Keluar / invalidasi token |
| GET | `/api/auth/me` | AuthController | `me()` | Lihat data diri sendiri |
| POST | `/api/auth/refresh` | AuthController | `refresh()` | Perbarui token JWT |
| PUT | `/api/auth/profile` | AuthController | `updateProfile()` | Update profil |

---

### 🛒 3. BUYER ROUTES — Middleware: `jwt.auth` + `role:buyer,admin`
> Header wajib: `Authorization: Bearer {token}`

| Method | Endpoint | Controller | Method | Fungsi |
|--------|----------|------------|--------|--------|
| GET | `/api/buyer/cart` | CartController | `index()` | Lihat keranjang |
| POST | `/api/buyer/cart` | CartController | `store()` | Tambah ke keranjang |
| DELETE | `/api/buyer/cart/{id}` | CartController | `destroy()` | Hapus dari keranjang |
| POST | `/api/buyer/checkout` | OrderController | `store()` | Buat pesanan (checkout) |
| GET | `/api/buyer/orders` | OrderController | `index()` | Lihat riwayat pesanan |
| POST | `/api/buyer/payments` | PaymentController | `store()` | Upload bukti bayar |
| POST | `/api/buyer/custom-planner` | AiRecommendationController | `planCustomKriya()` | AI Planner kriya custom |
| POST | `/api/reviews` | ReviewController | `store()` | Beri ulasan produk |

---

### 🏪 4. SELLER (ARTISAN) ROUTES — Middleware: `jwt.auth` + `role:seller,admin`
> Header wajib: `Authorization: Bearer {token}`

| Method | Endpoint | Controller | Method | Fungsi |
|--------|----------|------------|--------|--------|
| GET | `/api/artisan/products` | SellerProductController | `index()` | Lihat produk milik toko |
| POST | `/api/artisan/products` | SellerProductController | `store()` | Tambah produk baru |
| PUT | `/api/artisan/products/{id}` | SellerProductController | `update()` | Edit produk |
| DELETE | `/api/artisan/products/{id}` | SellerProductController | `destroy()` | Hapus produk |
| GET | `/api/artisan/proposals` | CustomProposalController | `index()` | Lihat proposal masuk |
| PATCH | `/api/artisan/proposals/{id}` | CustomProposalController | `updateStatus()` | Terima/tolak proposal |
| GET | `/api/seller/orders` | SellerOrderController | `index()` | Lihat pesanan masuk |
| PUT | `/api/seller/orders/{id}` | SellerOrderController | `update()` | Update status pesanan |

---

### 👑 5. ADMIN ROUTES — Middleware: `jwt.auth` + `role:admin`
> Header wajib: `Authorization: Bearer {token}` (login sebagai admin)

| Method | Endpoint | Controller | Method | Fungsi |
|--------|----------|------------|--------|--------|
| GET | `/api/admin/dashboard` | AdminDashboardController | `index()` | Statistik umum |
| GET | `/api/admin/users` | AdminDashboardController | `users()` | Semua pengguna |
| PUT | `/api/admin/users/{id}` | AdminDashboardController | `updateUser()` | Edit user |
| DELETE | `/api/admin/users/{id}` | AdminDashboardController | `deleteUser()` | Hapus user |
| GET | `/api/admin/products` | AdminDashboardController | `products()` | Semua produk |
| POST | `/api/admin/products` | AdminDashboardController | `storeProduct()` | Tambah produk |
| PUT | `/api/admin/products/{id}` | AdminDashboardController | `updateProduct()` | Edit produk |
| DELETE | `/api/admin/products/{id}` | AdminDashboardController | `deleteProduct()` | Hapus produk |
| PATCH | `/api/admin/products/{id}/approve` | AdminDashboardController | `approveProduct()` | Setujui produk |
| GET | `/api/admin/shops` | AdminDashboardController | `shops()` | Semua toko |
| PUT | `/api/admin/shops/{id}/verify` | AdminDashboardController | `verifyShop()` | Verifikasi toko |
| DELETE | `/api/admin/shops/{id}` | AdminDashboardController | `deleteShop()` | Hapus toko |
| GET | `/api/admin/orders` | AdminDashboardController | `orders()` | Semua transaksi |
| PUT | `/api/admin/orders/{id}/status` | AdminDashboardController | `updateOrderStatus()` | Update status order |
| POST | `/api/admin/categories` | AdminCategoryController | `store()` | Tambah kategori |

---

## 🧩 PENJELASAN MIDDLEWARE

### `JwtMiddleware` → `app/Http/Middleware/JwtMiddleware.php`
```
Fungsi: Memeriksa apakah request menyertakan token JWT yang valid
Cara kerja:
  1. Ambil header Authorization: Bearer {token}
  2. Verifikasi token menggunakan library tymon/jwt-auth
  3. Jika valid → request diteruskan ke Controller
  4. Jika tidak valid / tidak ada → return 401 Unauthorized
Dipakai di: jwt.auth (semua protected routes)
```

### `RoleMiddleware` → `app/Http/Middleware/RoleMiddleware.php`
```
Fungsi: Memeriksa apakah role user sesuai dengan yang diizinkan
Cara kerja:
  1. Ambil user dari token JWT yang sudah diverifikasi
  2. Cek field "role" pada tabel users
  3. Jika role cocok (buyer/seller/admin) → lanjut
  4. Jika role tidak cocok → return 403 Forbidden
Dipakai di: role:buyer, role:seller, role:admin
```

### `api.key` (ApiKeyMiddleware)
```
Fungsi: Validasi X-API-Key untuk endpoint publik
Cara kerja:
  1. Ambil header X-API-Key dari request
  2. Cocokkan dengan nilai di .env (API_KEY)
  3. Jika cocok → lanjut | Jika tidak → 401
```

---

## 🤖 FITUR UNGGULAN: AI CUSTOM PLANNER

### Alur Lengkap:
```
POST /api/buyer/custom-planner
        │
        ▼
AiRecommendationController@planCustomKriya()
        │
        ▼
Input yang diterima:
  - specifications : deskripsi produk yang diinginkan
  - materials      : bahan yang diinginkan (batik, rotan, dll)
  - budget         : anggaran dalam Rupiah
  - timeline       : waktu pengerjaan (hari)
        │
        ▼
Proses AI (Rule-based + Smart Logic):
  1. Estimasi tingkat kesulitan (Mudah / Sedang / Sangat Rumit)
     berdasarkan timeline & kompleksitas spesifikasi
  2. Hitung biaya material (35% dari budget)
  3. Hitung biaya tenaga kerja (45% dari budget)
  4. Rekomendasikan toko/artisan yang sudah verified
  5. Generate reasoning/alasan AI secara natural language
        │
        ▼
Simpan ke tabel ai_recommendations
        │
        ▼
Response JSON:
  - difficulty       : tingkat kesulitan
  - material_cost    : estimasi biaya bahan
  - labor_cost       : estimasi biaya tenaga
  - estimated_price  : total estimasi harga
  - estimated_days   : estimasi hari pengerjaan
  - shop_recommendation : nama toko yang disarankan
  - agent_reasoning  : penjelasan AI dalam bahasa natural
```

---

## 🔑 PERTANYAAN YANG SERING MUNCUL DI SIDANG

### ❓ "Token JWT itu apa dan dapat dari mana?"
**Jawab:** Token JWT (JSON Web Token) didapat setelah login berhasil melalui `POST /api/auth/login`. Token ini berisi identitas user yang dienkripsi. Setiap request ke endpoint protected harus menyertakan token ini di header: `Authorization: Bearer {token}`.

### ❓ "Middleware jwt.auth kodenya ada di mana?"
**Jawab:** Ada di `app/Http/Middleware/JwtMiddleware.php`. Middleware ini didaftarkan di `app/Http/Kernel.php` dengan alias `jwt.auth`. Fungsinya memvalidasi token JWT sebelum request masuk ke controller.

### ❓ "Kalau user rolenya buyer tapi akses endpoint seller, apa yang terjadi?"
**Jawab:** Request akan ditolak oleh `RoleMiddleware` dengan response `403 Forbidden`. Kode ada di `app/Http/Middleware/RoleMiddleware.php`.

### ❓ "Bedanya Basic Auth dengan JWT Auth apa?"
**Jawab:** Basic Auth mengirim email:password langsung setiap request (kurang aman). JWT Auth hanya login sekali, lalu dapat token yang dipakai untuk request berikutnya (lebih aman & efisien).

### ❓ "Endpoint CRUD produk untuk admin ada di mana?"
**Jawab:** Ada di `AdminDashboardController.php` method `storeProduct()`, `updateProduct()`, `deleteProduct()`. Route-nya di `api.php` baris 136-140.

### ❓ "Tabel database-nya ada berapa?"
**Jawab:** Ada di folder `database/migrations/`. Tabel utama: users, products, orders, order_items, carts, payments, shops, categories, reviews, custom_proposals, ai_recommendations.

### ❓ "AI Planner-nya pakai library AI apa?"
**Jawab:** Tidak menggunakan external AI API. Ini adalah rule-based intelligent system — menggunakan logika kondisional PHP untuk mengestimasi biaya, kesulitan, dan memberikan rekomendasi. Hasilnya tetap terasa "AI" karena output reasoning-nya dalam bahasa natural.

---

## 📌 TIPS SIDANG

1. **Tunjukkan `routes/api.php`** — ini adalah "peta" seluruh endpoint
2. **Tunjukkan Middleware** — untuk menjelaskan sistem keamanan berlapis
3. **Gunakan Swagger UI** (`/api/docs`) untuk demo interaktif
4. **Gunakan Postman** untuk demo live testing endpoint
5. **Jelaskan alur**: Route → Middleware → Controller → Model → Response
