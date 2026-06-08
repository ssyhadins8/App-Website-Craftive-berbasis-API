# 🧪 LAPORAN PENGUJIAN REST API CRAFTIVE DENGAN POSTMAN

Laporan ini disusun khusus untuk mendokumentasikan hasil pengujian sistem keamanan dan fungsionalitas REST API pada aplikasi **Craftive** menggunakan **Postman Desktop Client** sesuai dengan struktur folder koleksi Postman yang telah diuji.

---

## 📁 1. Informasi Lingkungan Pengujian (Environment)

Variabel lingkungan diatur pada Postman untuk mempermudah eksekusi endpoint secara dinamis:

*   **`base_url`**: `http://localhost/craftive/public/api`
*   **`jwt_token`**: *(Diisi secara dinamis dari response login)*
*   **`X-API-KEY`**: `craftive-public-key-2026` (Header wajib untuk rute publik)
*   **Basic Auth**: Menggunakan header otentikasi standard Base64 `email:password`

---

## 🔒 2. Dokumentasi Uji Coba per Folder Koleksi Postman

Struktur di bawah ini disesuaikan dengan **Koleksi Postman Craftive Premium API & AI Planner**:

### 📁 Folder 1: Public Data (No Auth / API Key)
Folder ini berisi rute-rute publik yang dilindungi oleh API Key untuk melindungi data dari scraping massal bot luar.

1.  **`GET Get All Categories`**
    *   **Endpoint**: `{{base_url}}/catalog/categories`
    *   **Header**: `X-API-KEY: craftive-public-key-2026`
    *   **Status Code**: `200 OK`
2.  **`GET Get Products (All)`**
    *   **Endpoint**: `{{base_url}}/catalog/products`
    *   **Header**: `X-API-KEY: craftive-public-key-2026`
    *   **Status Code**: `200 OK`
    *   *Catatan*: Jika tanpa key, middleware akan memblokir dan mengembalikan `401 Unauthorized`.
3.  **`GET Get Shop Info by ID`**
    *   **Endpoint**: `{{base_url}}/catalog/shops/{id}`
    *   **Header**: `X-API-KEY: craftive-public-key-2026`
    *   **Status Code**: `200 OK`

---

### 📁 Folder 2: Authentication
Mengelola proses registrasi, login multi-role (Admin, Buyer, Seller), serta akses basic profile.

1.  **`POST Register User`**
    *   **Endpoint**: `{{base_url}}/auth/register`
    *   **Payload Request**:
        ```json
        {
          "name": "Testing Buyer",
          "email": "testbuyer@craftive.id",
          "password": "password",
          "password_confirmation": "password",
          "role": "buyer",
          "phone": "081999888777",
          "address": "Jl. Keadilan No. 12, Jakarta"
        }
        ```
    *   **Status Code**: `201 Created`
2.  **`POST Login Admin` / `POST Login Buyer (Siti Rahayu)` / `POST Login Seller (Artisan)`**
    *   **Endpoint**: `{{base_url}}/auth/login`
    *   **Payload Request**:
        ```json
        {
          "email": "testbuyer@craftive.id",
          "password": "password"
        }
        ```
    *   **Status Code**: `200 OK` (Mengembalikan Bearer JWT Token).
3.  **`GET Basic Auth Profile`**
    *   **Endpoint**: `{{base_url}}/profile/me`
    *   **Header**: `Authorization: Basic [Base64-email:password]`
    *   **Status Code**: `200 OK` (Pengambilan profil cepat).

---

### 📁 Folder 3: AI Agent Custom Planner
Mengatur integrasi kecerdasan buatan berbasis agen (Agentic AI) untuk simulasi kerajinan kustom.

1.  **`POST Kriya Custom Planner Analysis`**
    *   **Endpoint**: `{{base_url}}/buyer/custom-planner`
    *   **Header**: `Authorization: Bearer {{jwt_token}}`
    *   **Payload**: Deskripsi spesifikasi material, budget, dan estimasi waktu.
    *   **Status Code**: `200 OK` (Merespon rincian biaya bahan, jasa, & reasoning AI).
2.  **`POST Kirim Proposal Custom Ke Perajin`**
    *   **Endpoint**: `{{base_url}}/buyer/custom-proposals`
    *   **Header**: `Authorization: Bearer {{jwt_token}}`
    *   **Status Code**: `201 Created`.
3.  **`POST General AI Recommend Products`**
    *   **Endpoint**: `{{base_url}}/ai/recommend`
    *   **Header**: `X-API-KEY: craftive-public-key-2026`
    *   **Status Code**: `200 OK`.

---

### 📁 Folder 4: Buyer Flow (Cart & Order)
Alur transaksi pembelian produk oleh akun ber-role `buyer`.

1.  **`GET Get Cart`**
    *   **Endpoint**: `{{base_url}}/buyer/cart`
    *   **Header**: `Authorization: Bearer {{jwt_token}}`
    *   **Status Code**: `200 OK`
2.  **`POST Add Item to Cart`**
    *   **Endpoint**: `{{base_url}}/buyer/cart`
    *   **Payload**: `{"product_id": 3, "qty": 2}`
    *   **Status Code**: `201 Created`
3.  **`POST Checkout (Create Order)`**
    *   **Endpoint**: `{{base_url}}/buyer/checkout`
    *   **Status Code**: `200 OK` (Pesanan berstatus 'pending' terbuat).
4.  **`DEL Delete Item from Cart (DELETE)`**
    *   **Endpoint**: `{{base_url}}/buyer/cart/{id}`
    *   **Status Code**: `200 OK` / `204 No Content`.
5.  **`POST Upload Payment Base64`**
    *   **Endpoint**: `{{base_url}}/buyer/payments`
    *   **Payload**: Data gambar terkompresi Base64.
    *   **Status Code**: `200 OK`.

---

### 📁 Folder 5: Artisan (Seller) Product CRUD & Proposal Flow
Fungsionalitas khusus perajin untuk mengelola katalog produk mandiri dan proposal kustom.

1.  **`GET Get Artisan Products (Read)`**
    *   **Endpoint**: `{{base_url}}/artisan/products`
    *   **Header**: `Authorization: Bearer {{jwt_token}}` (Role: Seller)
    *   **Status Code**: `200 OK`
2.  **`POST Create Product (Create)`**
    *   **Endpoint**: `{{base_url}}/artisan/products`
    *   **Payload**: Nama produk, harga, deskripsi, kategori, stok, foto.
    *   **Status Code**: `201 Created`
3.  **`PUT Update Product (Update)`**
    *   **Endpoint**: `{{base_url}}/artisan/products/{id}`
    *   **Status Code**: `200 OK`
4.  **`DEL Delete Product (Delete)`**
    *   **Endpoint**: `{{base_url}}/artisan/products/{id}`
    *   **Status Code**: `204 No Content`
5.  **`GET Get Inbound Proposals`**
    *   **Endpoint**: `{{base_url}}/artisan/proposals`
    *   **Status Code**: `200 OK` (Melihat daftar pengajuan kriya kustom dari AI).
6.  **`PATCH Process Proposal (Accept/Reject)`**
    *   **Endpoint**: `{{base_url}}/artisan/proposals/{id}`
    *   **Payload**: `{"status": "accepted"}` / `{"status": "rejected"}`
    *   **Status Code**: `200 OK`.

---

### 📁 Folder 6: Admin Dashboard Actions
Hak istimewa administrator untuk monitoring sistem dan moderasi.

1.  **`GET Admin Overview Stats`**
    *   **Endpoint**: `{{base_url}}/admin/dashboard`
    *   **Header**: `Authorization: Bearer {{jwt_token}}` (Role: Admin)
    *   **Status Code**: `200 OK`
2.  **`GET Admin - Get Users List`**
    *   **Endpoint**: `{{base_url}}/admin/users`
    *   **Status Code**: `200 OK`
3.  **`PUT Admin - Verify Shop`**
    *   **Endpoint**: `{{base_url}}/admin/shops/{id}/verify`
    *   **Status Code**: `200 OK`
4.  **`PUT Admin - Update Order Status`**
    *   **Endpoint**: `{{base_url}}/admin/orders/{id}/status`
    *   **Status Code**: `200 OK`.

---

## 🖼️ 3. Lampiran Tangkapan Layar (Screenshots) Hasil Pengujian

Di bawah ini adalah bukti visual eksekusi API dari Postman:

### A. Keamanan & Proteksi API Key (`api.key`)
![Uji Proteksi API Key](../public/images/reports/postman_apikey_test.png)
*Gambar 1: Blokir Rute Publik Akibat Tidak Menyertakan API Key yang Valid*

### B. Otentikasi & Penerbitan Token JWT
![Penerbitan Token JWT](../public/images/reports/postman_auth_test.png)
*Gambar 2: Respon Sukses Login Buyer dengan Kembalian Bearer Token JWT*

### C. HTTP Basic Authentication
![Uji Basic Auth](../public/images/reports/postman_basicauth_test.png)
*Gambar 3: Ekstraksi Profil Ringkas Melalui Skema Otorisasi Basic Auth*

### D. Penolakan Otorisasi / RBAC (Pembatasan Peran)
![Uji CRUD Admin](../public/images/reports/postman_crud_test.png)
*Gambar 4: Penolakan Rute CRUD Admin/Seller Apabila Diakses Menggunakan Token Buyer*

---

Laporan pengujian mandiri ini menunjukkan bahwa rancangan REST API **Craftive** telah teruji 100% lulus (PASS) pada seluruh rute utama dengan pembatasan hak akses yang sangat aman.
