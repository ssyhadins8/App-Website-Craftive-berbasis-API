# Panduan Lengkap Swagger (L5‑Swagger) untuk Craftive API

## ✅ Ringkasan
Dokumen ini menjelaskan langkah‑langkah **dari instalasi hingga testing** API Craftive menggunakan Swagger UI serta cara meng‑export request ke Postman.

---

## 1️⃣ Persiapan Lingkungan
1. Pastikan **PHP ≥ 8.1**, **Composer**, dan **XAMPP** sudah berjalan.
2. Buka terminal di root proyek (`c:/xampp1/htdocs/craftive`).
3. Install paket L5‑Swagger (jika belum):
   ```bash
   composer require darkaonline/l5-swagger
   ```
4. Publish konfigurasi & view:
   ```bash
   php artisan vendor:publish --provider="L5Swagger\L5SwaggerServiceProvider"
   ```
   File konfigurasi berada di `config/l5-swagger.php`.

---

## 2️⃣ Mengonfigurasi Swagger
- **Info & Security** – Didefinisikan di `app/Http/Controllers/Controller.php` menggunakan PHP 8 attribute:
  ```php
  #[OA\Info(version: '1.0.0', title: 'Craftive REST API', ...)]
  #[OA\SecurityScheme(securityScheme: 'bearerAuth', type: 'http', scheme: 'bearer', bearerFormat: 'JWT')]
  ```
- **Base Path** – Pastikan `L5_SWAGGER_BASE_PATH` di `.env` mengarah ke `/api` atau biarkan `null` untuk autodetect.
- **Generate selalu** – Untuk development, set `L5_SWAGGER_GENERATE_ALWAYS=true` agar UI selalu menampilkan perubahan terbaru.

---

## 3️⃣ Menambahkan Anotasi pada Controller
1. Buka controller, contoh `AuthController.php`.
2. Tambahkan attribute **#[OA\Post]**, **#[OA\Get]**, **#[OA\Put]**, **#[OA\Delete]** pada setiap metode.
3. Pastikan setiap properti request/response dideklarasikan dengan `OA\Property`.
4. Simpan file, lalu jalankan:
   ```bash
   php artisan l5-swagger:generate
   ```
   (Jika `generate_always` aktif, langkah ini optional.)

---

## 4️⃣ Membuka Swagger UI
- URL default: `http://127.0.0.1:8000/api/documentation`
- Pada UI, Anda akan melihat semua endpoint dengan **try‑it‑out**.
- Tekan **Authorize** → masukkan token JWT (`Bearer <token>`) untuk mengakses endpoint yang dilindungi.

---

## 5️⃣ Meng‑test Endpoint di Swagger
1. Pilih endpoint, misalnya **POST /auth/login**.
2. Klik **Try it out** → isi JSON body:
   ```json
   {"email":"siti@craftive.id","password":"password123"}
   ```
3. Tekan **Execute**.
4. Respons ditampilkan di panel **Response body**. Salin `access_token`.
5. Klik **Authorize** (icon kunci) → paste token: `Bearer eyJ0eXAiOiJKV...`.
6. Uji endpoint ber‑auth lainnya (misal **GET /auth/me**) – token otomatis ditambahkan ke header.

---

## 6️⃣ Export Request ke Postman
Swagger UI menyediakan **Generate client** → pilih **Postman Collection**.
1. Klik **Export** → **Postman Collection** → simpan file `craftive-postman.json`.
2. Buka **Postman** → **Import** → pilih file yang disimpan.
3. Semua endpoint otomatis ter‑import dengan contoh request body.
4. Pada tab **Authorization** di koleksi, pilih **Bearer Token** dan masukkan token JWT yang didapat dari login.
5. Sekarang Anda dapat menjalankan request di Postman dengan satu klik.

---

## 7️⃣ Menangani Error Umum
| Error | Penyebab | Solusi |
|-------|----------|--------|
| `Required @OA\Info() not found` | Info belum didefinisikan di *Controller.php* | Tambahkan attribute `#[OA\Info]` seperti pada langkah 2 |
| `Attribute "OA" not found` | Namespace tidak di‑import | `use OpenApi\Attributes as OA;` di bagian atas file |
| `401 Unauthorized` di Swagger UI | Token tidak di‑set atau expired | Klik **Authorize** lagi dengan token baru (login ulang) |
| `DELETE endpoint missing` | Anotasi `#[OA\Delete]` belum ditambahkan | Tambahkan attribute di method `deleteProduct` pada `AdminDashboardController` |

---

## 8️⃣ Tips Visual & Premium UI
- Aktifkan **dark mode** pada UI dengan mengubah env `L5_SWAGGER_UI_DARK_MODE=true`.
- Set `doc_expansion='list'` agar tag‑tag langsung terbuka.
- Tambahkan logo brand di `resources/views/vendor/l5-swagger/swagger-ui.blade.php` (custom CSS) untuk tampilan premium.

---

## 9️⃣ Ringkasnya
1. **Install** → `composer require darkaonline/l5-swagger`.
2. **Publish** → `php artisan vendor:publish …`.
3. **Konfigurasi** → edit `Controller.php` & `.env`.
4. **Anotasi** → tambahkan attribute pada semua controller.
5. **Generate** → `php artisan l5-swagger:generate` (opsional).
6. **Buka UI** → `http://127.0.0.1:8000/api/documentation`.
7. **Authorize** → masukkan JWT.
8. **Test** → gunakan *Try it out* atau export ke Postman.

Dengan langkah‑langkah di atas, dokumentasi API Anda akan selalu terbaru, mudah di‑test, dan siap dipresentasikan.

---

*File ini berada di `docs/TUTORIAL_SWAGGER.md` untuk referensi tim pengembang.*
