# Dokumentasi API - Craftive Marketplace

## Base URL
Semua endpoint diakses melalui `http://localhost/craftive/public/api` atau `http://localhost:8000/api`

---

## 1. Autentikasi & Otorisasi
Sistem ini menggunakan 3 jenis keamanan (sesuai syarat UAS Pemrograman API):
1. **API Key**: Untuk akses katalog publik yang dibatasi.
   - Header Wajib: `X-API-KEY: craftive-public-key-2026`
2. **JWT Token (JSON Web Token)**: Untuk transaksi user dan dasbor.
   - Header Wajib: `Authorization: Bearer {token}`
3. **Basic Auth**: Untuk akses data profil dasar.
   - Header Wajib: `Authorization: Basic {credentials_base64}`

### Login (Mendapatkan JWT)
- **URL**: `/auth/login`
- **Method**: `POST`
- **Body**:
  ```json
  {
    "email": "siti@craftive.id",
    "password": "password"
  }
  ```
- **Response**: Mengembalikan `access_token` JWT.

---

## 2. Public Data (Butuh API Key)
**Header Wajib**: 
- `X-API-KEY: craftive-public-key-2026`

### Get Semua Kategori
- **URL**: `/categories`
- **Method**: `GET`

### Get Semua Produk
- **URL**: `/products`
- **Method**: `GET`

---

## 3. Fitur Utama Pembeli & AI (Butuh JWT Token)
**Header Wajib**: 
- `Authorization: Bearer {token}`

### Kriya Custom Planner (Agentic AI)
- **URL**: `/ai/custom-planner`
- **Method**: `POST`
- **Body**:
  ```json
  {
    "specifications": "Meja kopi kayu jati bulat diameter 60cm ukir mega mendung",
    "materials": "Kayu Jati, Politur",
    "budget": 500000,
    "timeline": 7
  }
  ```
- **Response**:
  ```json
  {
    "message": "CRAFTIVE AI Custom Planner",
    "planning": {
      "specifications": "Meja kopi...",
      "materials": "Kayu Jati...",
      "budget": 500000.0,
      "timeline_requested": 7,
      "difficulty": "Sedang",
      "material_cost": 175000.0,
      "labor_cost": 225000.0,
      "estimated_price": 400000.0,
      "estimated_days": 6,
      "shop_recommendation": "Sanggar Ukir Kasongan",
      "agent_reasoning": "Berdasarkan spesifikasi custom..."
    }
  }
  ```

---

## 4. Admin API Dashboard (Butuh JWT Token & Role Admin)
**Header Wajib**: 
- `Authorization: Bearer {token}` (Pengguna login dengan role `admin`)

### Statistik Global
- **URL**: `/admin/dashboard`
- **Method**: `GET`

### Kelola Pengguna (Users)
- **Get List Users**: `GET /admin/users`
- **Update User**: `PUT /admin/users/{id}`
- **Delete User**: `DELETE /admin/users/{id}`

### Kelola Produk (Products CRUD)
- **Get List Products**: `GET /admin/products`
- **Create Product**: `POST /api/admin/products`
- **Update Product**: `PUT /api/admin/products/{id}`
- **Delete Product**: `DELETE /api/admin/products/{id}`

### Kelola Toko (Shops)
- **Get List Shops**: `GET /admin/shops`
- **Verify Shop**: `PUT /admin/shops/{id}/verify` (Body: `{"is_verified": true}`)
- **Delete Shop**: `DELETE /admin/shops/{id}`

### Kelola Transaksi & Status Pembayaran
- **Get List Orders**: `GET /admin/orders`
- **Confirm Order / Payment**: `PUT /admin/orders/{id}/status`
  ```json
  {
    "status": "paid",
    "payment_status": "confirmed"
  }
  ```
