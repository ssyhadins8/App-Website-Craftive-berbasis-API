@extends('layouts.app')

@section('content')
<div class="py-12 bg-brand-cream min-h-screen" x-data="adminDashboard">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-10 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div>
                <h1 class="font-heading font-extrabold text-3xl text-brand-dark">Dasbor Administratif</h1>
                <p class="text-xs text-gray-500 mt-1">Panel kendali pusat manajemen data platform Craftive.</p>
            </div>
            
            <!-- Tabs Nav -->
            <div class="flex flex-wrap bg-white/90 border border-brand-beige p-1.5 rounded-2xl gap-1 text-xs font-bold shadow-sm">
                <button @click="setTab('stats')" :class="activeTab === 'stats' ? 'bg-brand-terracotta text-white shadow-md' : 'text-gray-500 hover:text-brand-terracotta'" class="px-4 py-2.5 rounded-xl transition-all flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2"></path></svg>
                    Ringkasan
                </button>
                <button @click="setTab('categories')" :class="activeTab === 'categories' ? 'bg-brand-terracotta text-white shadow-md' : 'text-gray-500 hover:text-brand-terracotta'" class="px-4 py-2.5 rounded-xl transition-all flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Kategori
                </button>
                <button @click="setTab('products')" :class="activeTab === 'products' ? 'bg-brand-terracotta text-white shadow-md' : 'text-gray-500 hover:text-brand-terracotta'" class="px-4 py-2.5 rounded-xl transition-all flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    CRUD Produk
                </button>
                <button @click="setTab('shops')" :class="activeTab === 'shops' ? 'bg-brand-terracotta text-white shadow-md' : 'text-gray-500 hover:text-brand-terracotta'" class="px-4 py-2.5 rounded-xl transition-all flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Kelola Toko
                </button>
                <button @click="setTab('users')" :class="activeTab === 'users' ? 'bg-brand-terracotta text-white shadow-md' : 'text-gray-500 hover:text-brand-terracotta'" class="px-4 py-2.5 rounded-xl transition-all flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Pengguna
                </button>
                <button @click="setTab('orders')" :class="activeTab === 'orders' ? 'bg-brand-terracotta text-white shadow-md' : 'text-gray-500 hover:text-brand-terracotta'" class="px-4 py-2.5 rounded-xl transition-all flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Transaksi
                </button>
                <button @click="setTab('monitoring')" :class="activeTab === 'monitoring' ? 'bg-brand-terracotta text-white shadow-md' : 'text-gray-500 hover:text-brand-terracotta'" class="px-4 py-2.5 rounded-xl transition-all flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Monitoring
                </button>
                <button @click="setTab('profile')" :class="activeTab === 'profile' ? 'bg-brand-terracotta text-white shadow-md' : 'text-gray-500 hover:text-brand-terracotta'" class="px-4 py-2.5 rounded-xl transition-all flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Profil Saya
                </button>
            </div>
        </div>

        <!-- ── TAB: STATS (OVERVIEW) ── -->
        <div x-show="activeTab === 'stats'" class="space-y-6">
            <!-- Stats cards grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white border border-brand-beige p-6 rounded-3xl shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div>
                        <div class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Total Pengguna</div>
                        <div class="text-2xl font-extrabold text-brand-dark mt-0.5" x-text="stats.total_users || 0">0</div>
                    </div>
                </div>
                <div class="bg-white border border-brand-beige p-6 rounded-3xl shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <div>
                        <div class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Total Produk</div>
                        <div class="text-2xl font-extrabold text-brand-dark mt-0.5" x-text="stats.total_products || 0">0</div>
                    </div>
                </div>
                <div class="bg-white border border-brand-beige p-6 rounded-3xl shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                    <div>
                        <div class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Total Transaksi</div>
                        <div class="text-2xl font-extrabold text-brand-dark mt-0.5" x-text="stats.total_orders || 0">0</div>
                    </div>
                </div>
                <div class="bg-white border border-brand-beige p-6 rounded-3xl shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16v1M5 12h14"></path></svg>
                    </div>
                    <div>
                        <div class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Total Pendapatan</div>
                        <div class="text-lg font-extrabold text-brand-dark mt-0.5" x-text="'Rp ' + (stats.revenue || 0).toLocaleString('id-ID')">Rp 0</div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders & platform security -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="bg-white rounded-3xl border border-brand-beige p-8 shadow-lg lg:col-span-2">
                    <h2 class="font-heading font-bold text-lg text-brand-dark mb-4">Aktivitas Transaksi Terbaru</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-brand-beige font-extrabold text-brand-accent uppercase tracking-wider">
                                    <th class="pb-3">ID Pesanan</th>
                                    <th class="pb-3">Pembeli</th>
                                    <th class="pb-3">Penjual</th>
                                    <th class="pb-3">Total Belanja</th>
                                    <th class="pb-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-brand-beige/50 font-semibold text-brand-dark">
                                <template x-for="order in stats.recent_orders" :key="order.id">
                                    <tr>
                                        <td class="py-3 font-bold" x-text="'#' + order.id">ID</td>
                                        <td class="py-3" x-text="order.buyer.name">Buyer</td>
                                        <td class="py-3" x-text="order.seller.name">Seller</td>
                                        <td class="py-3 text-brand-terracotta" x-text="'Rp ' + Number(order.total_amount).toLocaleString('id-ID')">Total</td>
                                        <td class="py-3">
                                            <span class="px-2.5 py-1 rounded-full text-[9px] uppercase tracking-wider font-extrabold"
                                                  :class="{
                                                      'bg-amber-100 text-amber-800': order.status === 'pending',
                                                      'bg-blue-100 text-blue-800': order.status === 'paid',
                                                      'bg-purple-100 text-purple-800': order.status === 'shipped',
                                                      'bg-green-100 text-green-800': order.status === 'delivered',
                                                      'bg-red-100 text-red-800': order.status === 'cancelled'
                                                  }"
                                                  x-text="order.status">Status</span>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-[#FAF4EA] rounded-3xl border-2 border-brand-beige p-6 flex flex-col justify-between shadow-inner">
                    <div>
                        <span class="text-[10px] font-extrabold uppercase tracking-widest text-brand-terracotta bg-brand-terracotta/10 px-3 py-1 rounded-full">Sistem Pengawasan</span>
                        <h3 class="font-heading font-extrabold text-xl text-brand-dark mt-4 mb-2">Panduan Admin Proyek</h3>
                        <p class="text-[11px] text-brand-dark/75 leading-relaxed">
                            Panel ini menghubungkan data dari model secara dinamis ke REST API yang diproteksi menggunakan token JWT. Anda dapat menguji CRUD, status otorisasi, dan simulasi payment bukti pembayaran secara langsung.
                        </p>
                    </div>
                    <div class="mt-6 border-t border-brand-beige pt-4 text-[10px] text-brand-accent/80 font-bold uppercase tracking-wider">
                        Keamanan Akses: JWT Token & API Key
                    </div>
                </div>
            </div>
        </div>

        <!-- ── TAB: CATEGORIES ── -->
        <div x-show="activeTab === 'categories'" class="space-y-6" style="display: none;">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Create Category Form -->
                <div class="bg-white rounded-3xl border border-brand-beige p-6 shadow-sm flex flex-col justify-between">
                    <div>
                        <h3 class="font-heading font-bold text-brand-dark text-lg mb-4">Tambah Kategori Baru</h3>
                        <form @submit.prevent="submitAddCategory">
                            <div class="mb-4">
                                <label class="block text-xs font-bold uppercase tracking-wider text-brand-accent mb-2">Nama Kategori</label>
                                <input type="text" x-model="formCategoryName" class="w-full bg-brand-cream border border-brand-beige rounded-2xl p-3.5 text-xs font-semibold outline-none focus:border-brand-terracotta shadow-inner" placeholder="Misal: Kerajinan Batu" required>
                            </div>
                            <div class="mb-6">
                                <label class="block text-xs font-bold uppercase tracking-wider text-brand-accent mb-2">Inisial Ikon (2 Huruf)</label>
                                <input type="text" x-model="formCategoryIcon" class="w-full bg-brand-cream border border-brand-beige rounded-2xl p-3.5 text-xs font-semibold outline-none focus:border-brand-terracotta shadow-inner" placeholder="Misal: KB" required maxlength="2">
                            </div>
                            <button type="submit" :disabled="formLoading" class="w-full btn-gradient text-white py-3.5 rounded-2xl font-bold text-sm hover:shadow-lg transition-all flex items-center justify-center gap-2">
                                <span x-show="formLoading" class="animate-spin border-2 border-white border-t-transparent w-4 h-4 rounded-full"></span>
                                <span x-text="formLoading ? 'Menyimpan...' : 'Simpan Kategori'"></span>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Category list table -->
                <div class="bg-white rounded-3xl border border-brand-beige p-8 shadow-lg md:col-span-2">
                    <h3 class="font-heading font-bold text-lg text-brand-dark mb-6">Daftar Kategori Aktif</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-brand-beige font-extrabold text-brand-accent uppercase tracking-wider">
                                    <th class="pb-3 w-16">Ikon</th>
                                    <th class="pb-3">Nama Kategori</th>
                                    <th class="pb-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-brand-beige/50 font-semibold text-brand-dark">
                                <template x-for="cat in categories" :key="cat.id">
                                    <tr>
                                        <td class="py-4 font-bold">
                                            <div class="w-8 h-8 rounded-lg bg-brand-terracotta/10 text-brand-terracotta flex items-center justify-center font-heading text-sm" x-text="cat.icon || cat.name.substring(0, 2).toUpperCase()"></div>
                                        </td>
                                        <td class="py-4 font-extrabold text-brand-dark" x-text="cat.name">Kategori</td>
                                        <td class="py-4 text-right text-gray-400">Master Data Default</td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── TAB: PRODUCTS (CRUD) ── -->
        <div x-show="activeTab === 'products'" class="space-y-6" style="display: none;">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Add Product Form -->
                <div class="bg-white rounded-3xl border border-brand-beige p-6 shadow-sm flex flex-col justify-between">
                    <div>
                        <h3 class="font-heading font-bold text-brand-dark text-lg mb-4" x-text="editingProduct ? 'Edit Produk Kriya' : 'Tambah Produk Kriya'">Tambah Produk Kriya</h3>
                        <form @submit.prevent="submitProductForm">
                            <div class="mb-4">
                                <label class="block text-xs font-bold uppercase tracking-wider text-brand-accent mb-2">Pilih Toko / Perajin</label>
                                <select x-model="formProduct.shop_id" class="w-full bg-brand-cream border border-brand-beige rounded-2xl p-3.5 text-xs font-semibold outline-none focus:border-brand-terracotta" required>
                                    <option value="">Pilih Toko Pemilik</option>
                                    <template x-for="shop in shops" :key="shop.id">
                                        <option :value="shop.id" x-text="shop.name" :selected="formProduct.shop_id == shop.id"></option>
                                    </template>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-xs font-bold uppercase tracking-wider text-brand-accent mb-2">Kategori</label>
                                <select x-model="formProduct.category_id" class="w-full bg-brand-cream border border-brand-beige rounded-2xl p-3.5 text-xs font-semibold outline-none focus:border-brand-terracotta" required>
                                    <option value="">Pilih Kategori</option>
                                    <template x-for="cat in categories" :key="cat.id">
                                        <option :value="cat.id" x-text="cat.name"></option>
                                    </template>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-xs font-bold uppercase tracking-wider text-brand-accent mb-2">Nama Produk Kriya</label>
                                <input type="text" x-model="formProduct.name" class="w-full bg-brand-cream border border-brand-beige rounded-2xl p-3 text-xs font-semibold outline-none focus:border-brand-terracotta" placeholder="Misal: Teko Glazur Kasongan" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-xs font-bold uppercase tracking-wider text-brand-accent mb-2">Harga (Rupiah)</label>
                                <input type="number" x-model="formProduct.price" class="w-full bg-brand-cream border border-brand-beige rounded-2xl p-3 text-xs font-semibold outline-none focus:border-brand-terracotta" placeholder="Misal: 150000" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-xs font-bold uppercase tracking-wider text-brand-accent mb-2">Stok</label>
                                <input type="number" x-model="formProduct.stock" class="w-full bg-brand-cream border border-brand-beige rounded-2xl p-3 text-xs font-semibold outline-none focus:border-brand-terracotta" placeholder="Misal: 10" required>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-brand-accent mb-2">Gaya Estetika</label>
                                    <input type="text" x-model="formProduct.style" class="w-full bg-brand-cream border border-brand-beige rounded-2xl p-3 text-xs font-semibold outline-none focus:border-brand-terracotta" placeholder="etnik / minimalis">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-brand-accent mb-2">Target Penerima</label>
                                    <select x-model="formProduct.target_demographic" class="w-full bg-brand-cream border border-brand-beige rounded-2xl p-3 text-xs font-semibold outline-none focus:border-brand-terracotta">
                                        <option value="">Semua Umur</option>
                                        <option value="anak-anak">Anak-anak</option>
                                        <option value="remaja">Remaja</option>
                                        <option value="mahasiswa">Mahasiswa</option>
                                        <option value="dewasa">Dewasa</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-4" x-data="{ uploadType: 'file' }">
                                <label class="block text-xs font-bold uppercase tracking-wider text-brand-accent mb-2">Gambar Produk</label>
                                
                                <!-- Toggle Input Type -->
                                <div class="flex bg-brand-cream border border-brand-beige p-1 rounded-xl mb-3 text-[10px] font-bold">
                                    <button type="button" @click="uploadType = 'file'" :class="uploadType === 'file' ? 'bg-brand-terracotta text-white shadow-sm' : 'text-gray-500'" class="flex-1 py-1.5 rounded-lg transition-all text-center">
                                        Upload File
                                    </button>
                                    <button type="button" @click="uploadType = 'url'" :class="uploadType === 'url' ? 'bg-brand-terracotta text-white shadow-sm' : 'text-gray-500'" class="flex-1 py-1.5 rounded-lg transition-all text-center">
                                        URL Gambar
                                    </button>
                                </div>

                                <!-- File Input (Upload) -->
                                <div x-show="uploadType === 'file'" class="relative">
                                    <label class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-brand-beige rounded-2xl cursor-pointer bg-brand-cream hover:bg-white transition-all">
                                        <div class="flex flex-col items-center justify-center pt-4 pb-4 px-2 text-center">
                                            <svg class="w-6 h-6 text-brand-accent mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            <p class="text-[10px] text-brand-dark font-bold">Klik untuk unggah foto</p>
                                            <p class="text-[8px] text-gray-400 mt-0.5">PNG, JPG, JPEG (Maks. 2MB)</p>
                                        </div>
                                        <input type="file" accept="image/*" @change="
                                            const file = $event.target.files[0];
                                            if (file) {
                                                if (file.size > 2 * 1024 * 1024) {
                                                    window.addToast('error', 'Ukuran file terlalu besar! Maksimal 2MB.');
                                                    $event.target.value = '';
                                                    return;
                                                }
                                                const reader = new FileReader();
                                                reader.onload = (e) => {
                                                    formProduct.image_url = e.target.result;
                                                };
                                                reader.readAsDataURL(file);
                                            }
                                        " class="hidden">
                                    </label>
                                </div>

                                <!-- URL Input -->
                                <div x-show="uploadType === 'url'">
                                    <input type="url" x-model="formProduct.image_url" class="w-full bg-brand-cream border border-brand-beige rounded-2xl p-3 text-xs font-semibold outline-none focus:border-brand-terracotta" placeholder="https://example.com/gambar.jpg">
                                </div>

                                <!-- Preview Image -->
                                <template x-if="formProduct.image_url">
                                    <div class="mt-3 flex items-center justify-between bg-brand-cream border border-brand-beige p-2.5 rounded-2xl shadow-inner">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-12 h-12 bg-white border border-brand-beige rounded-xl overflow-hidden shadow-inner flex items-center justify-center">
                                                <img :src="formProduct.image_url" class="w-full h-full object-cover">
                                            </div>
                                            <div>
                                                <span class="text-[10px] text-brand-dark font-bold block">Pratinjau Gambar</span>
                                                <span class="text-[8px] text-gray-400 font-semibold" x-text="formProduct.image_url.startsWith('data:') ? 'Tipe: File Terunggah' : 'Tipe: URL Eksternal'"></span>
                                            </div>
                                        </div>
                                        <button type="button" @click="formProduct.image_url = ''" class="text-red-500 hover:text-red-700 font-bold text-xs bg-red-50 hover:bg-red-100 p-1.5 rounded-lg">
                                            Hapus
                                        </button>
                                    </div>
                                </template>
                            </div>
                            <div class="mb-4">
                                <label class="block text-xs font-bold uppercase tracking-wider text-brand-accent mb-2">Deskripsi Produk</label>
                                <textarea x-model="formProduct.description" class="w-full bg-brand-cream border border-brand-beige rounded-2xl p-3 text-xs font-semibold outline-none focus:border-brand-terracotta h-24" placeholder="Tulis rincian pembuatan kriya" required></textarea>
                            </div>
                            
                            <div class="flex gap-2">
                                <button type="submit" :disabled="formLoading" class="flex-grow btn-gradient text-white py-3.5 rounded-2xl font-bold text-sm hover:shadow-lg transition-all flex items-center justify-center gap-2">
                                    <span x-show="formLoading" class="animate-spin border-2 border-white border-t-transparent w-4 h-4 rounded-full"></span>
                                    <span x-text="editingProduct ? 'Perbarui' : 'Simpan Produk'"></span>
                                </button>
                                <button type="button" x-show="editingProduct" @click="resetProductForm()" class="bg-gray-100 text-gray-500 py-3.5 px-5 rounded-2xl text-xs font-bold">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Product Table list -->
                <div class="bg-white rounded-3xl border border-brand-beige p-8 shadow-lg lg:col-span-2">
                    <h3 class="font-heading font-bold text-lg text-brand-dark mb-6">Kelola Katalog Produk Kriya</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-brand-beige font-extrabold text-brand-accent uppercase tracking-wider">
                                    <th class="pb-3">Gambar</th>
                                    <th class="pb-3">Nama Produk</th>
                                    <th class="pb-3">Toko</th>
                                    <th class="pb-3">Harga</th>
                                    <th class="pb-3">Stok</th>
                                    <th class="pb-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-brand-beige/50 font-semibold text-brand-dark">
                                <template x-for="p in products" :key="p.id">
                                    <tr>
                                        <td class="py-3">
                                            <div class="w-12 h-12 bg-brand-cream border border-brand-beige rounded-xl overflow-hidden shadow-inner flex items-center justify-center">
                                                <img :src="p.image_url || 'https://picsum.photos/200/200'" class="w-full h-full object-cover">
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            <div class="font-bold text-brand-dark" x-text="p.name">Produk</div>
                                            <div class="text-[9px] text-gray-400 font-extrabold uppercase mt-0.5" x-text="p.category.name">Category</div>
                                        </td>
                                        <td class="py-3 text-gray-600" x-text="p.shop.name">Shop</td>
                                        <td class="py-3 text-brand-terracotta font-extrabold" x-text="'Rp ' + Number(p.price).toLocaleString('id-ID')">Price</td>
                                        <td class="py-3" x-text="p.stock">Stock</td>
                                        <td class="py-3 text-right flex justify-end gap-2 mt-2">
                                            <button @click="editProduct(p)" class="bg-blue-50 text-blue-600 px-3 py-1.5 rounded-lg font-bold hover:bg-blue-100">Ubah</button>
                                            <button @click="deleteProduct(p.id)" class="bg-red-50 text-red-600 px-3 py-1.5 rounded-lg font-bold hover:bg-red-100">Hapus</button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── TAB: SHOPS (KELOLA TOKO) ── -->
        <div x-show="activeTab === 'shops'" class="space-y-6" style="display: none;">
            <div class="bg-white rounded-3xl border border-brand-beige p-8 shadow-lg">
                <h3 class="font-heading font-bold text-lg text-brand-dark mb-6">Kelola Verifikasi Toko Perajin</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-brand-beige font-extrabold text-brand-accent uppercase tracking-wider">
                                <th class="pb-3">ID Toko</th>
                                <th class="pb-3">Nama Toko</th>
                                <th class="pb-3">Pemilik (User)</th>
                                <th class="pb-3">Alamat</th>
                                <th class="pb-3">Status Verifikasi</th>
                                <th class="pb-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-brand-beige/50 font-semibold text-brand-dark">
                            <template x-for="shop in shops" :key="shop.id">
                                <tr>
                                    <td class="py-4 font-bold" x-text="'Toko #' + shop.id">ID</td>
                                    <td class="py-4 font-extrabold text-brand-dark" x-text="shop.name">Shop Name</td>
                                    <td class="py-4 text-gray-500" x-text="shop.user.name + ' (' + shop.user.email + ')'">Owner</td>
                                    <td class="py-4" x-text="shop.address || '-'">Address</td>
                                    <td class="py-4">
                                        <span class="px-2 py-0.5 rounded text-[8px] font-extrabold uppercase tracking-widest"
                                              :class="shop.is_verified ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-500'"
                                              x-text="shop.is_verified ? 'Verified' : 'Unverified'">Status</span>
                                    </td>
                                    <td class="py-4 text-right">
                                        <button @click="toggleShopVerification(shop)" 
                                                class="px-4 py-2 rounded-xl text-xs font-bold border"
                                                :class="shop.is_verified ? 'border-red-200 text-red-600 bg-red-50 hover:bg-red-100' : 'border-green-200 text-green-600 bg-green-50 hover:bg-green-100'"
                                                x-text="shop.is_verified ? 'Cabut Verifikasi' : 'Verifikasi Toko'"></button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ── TAB: USERS ── -->
        <div x-show="activeTab === 'users'" class="space-y-6" style="display: none;">
            <div class="bg-white rounded-3xl border border-brand-beige p-8 shadow-lg">
                <h3 class="font-heading font-bold text-lg text-brand-dark mb-6">Manajemen Pengguna Platform</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-brand-beige font-extrabold text-brand-accent uppercase tracking-wider">
                                <th class="pb-3">Nama</th>
                                <th class="pb-3">Email</th>
                                <th class="pb-3">Hak Akses (Role)</th>
                                <th class="pb-3">Status Akun</th>
                                <th class="pb-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-brand-beige/50 font-semibold text-brand-dark">
                            <template x-for="u in users" :key="u.id">
                                <tr>
                                    <td class="py-4">
                                        <div class="font-extrabold text-brand-dark" x-text="u.name">Name</div>
                                    </td>
                                    <td class="py-4 text-gray-500" x-text="u.email">Email</td>
                                    <td class="py-4 font-bold text-brand-accent uppercase tracking-wider text-[10px]" x-text="u.role">Role</td>
                                    <td class="py-4">
                                        <span class="px-2 py-0.5 rounded text-[8px] font-extrabold uppercase tracking-widest"
                                              :class="u.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                                              x-text="u.is_active ? 'Aktif' : 'Diblokir'">Status</span>
                                    </td>
                                    <td class="py-4 text-right flex justify-end gap-2 mt-2">
                                        <button @click="toggleUserStatus(u)" 
                                                class="px-3 py-1.5 rounded-lg text-xs font-bold border"
                                                :class="u.is_active ? 'bg-red-50 border-red-100 text-red-600 hover:bg-red-100' : 'bg-green-50 border-green-100 text-green-600 hover:bg-green-100'"
                                                x-text="u.is_active ? 'Blokir' : 'Aktifkan'"></button>
                                        <button @click="deleteUser(u.id)" class="bg-gray-100 text-gray-500 px-3 py-1.5 rounded-lg font-bold hover:bg-gray-200">Hapus</button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ── TAB: ORDERS (KELOLA TRANSAKSI) ── -->
        <div x-show="activeTab === 'orders'" class="space-y-6" style="display: none;">
            <div class="bg-white rounded-3xl border border-brand-beige p-8 shadow-lg">
                <h3 class="font-heading font-bold text-lg text-brand-dark mb-6">Manajemen Transaksi & Pembayaran</h3>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-brand-beige font-extrabold text-brand-accent uppercase tracking-wider">
                                <th class="pb-3">Pesanan</th>
                                <th class="pb-3">Pembeli</th>
                                <th class="pb-3">Total Belanja</th>
                                <th class="pb-3">Bukti Bayar</th>
                                <th class="pb-3">Status Pembayaran</th>
                                <th class="pb-3">Status Pengiriman</th>
                                <th class="pb-3 text-right">Aksi Verifikasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-brand-beige/50 font-semibold text-brand-dark">
                            <template x-for="order in orders" :key="order.id">
                                <tr>
                                    <td class="py-4">
                                        <div class="font-bold text-brand-dark" x-text="'Pesanan #' + order.id">ID</div>
                                        <div class="text-[9px] text-gray-400 mt-0.5" x-text="new Date(order.created_at).toLocaleDateString('id-ID')">Date</div>
                                    </td>
                                    <td class="py-4">
                                        <div class="font-bold text-brand-dark" x-text="order.buyer.name">Buyer</div>
                                        <div class="text-[10px] text-gray-400" x-text="order.shipping_address">Address</div>
                                    </td>
                                    <td class="py-4 text-brand-terracotta font-extrabold" x-text="'Rp ' + Number(order.total_amount).toLocaleString('id-ID')">Total</td>
                                    
                                    <!-- Payment Proof Image -->
                                    <td class="py-4">
                                        <template x-if="order.payment">
                                            <button @click="showPaymentModal(order.payment)" class="bg-brand-cream border border-brand-beige text-brand-accent font-bold px-3 py-1.5 rounded-xl hover:bg-white flex items-center gap-1.5 shadow-sm">
                                                <svg class="w-4 h-4 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                Lihat Bukti
                                            </button>
                                        </template>
                                        <template x-if="!order.payment">
                                            <span class="text-gray-400 italic">Belum bayar</span>
                                        </template>
                                    </td>

                                    <!-- Payment Status -->
                                    <td class="py-4">
                                        <span class="px-2 py-0.5 rounded text-[8px] font-extrabold uppercase tracking-widest"
                                              :class="{
                                                  'bg-amber-100 text-amber-800': !order.payment || order.payment.status === 'pending',
                                                  'bg-green-100 text-green-800': order.payment && order.payment.status === 'confirmed',
                                                  'bg-red-100 text-red-800': order.payment && order.payment.status === 'rejected'
                                              }"
                                              x-text="order.payment ? order.payment.status : 'pending'">Status</span>
                                    </td>

                                    <!-- Shipping Status -->
                                    <td class="py-4">
                                        <span class="px-2.5 py-1 rounded-full text-[9px] font-extrabold uppercase tracking-wider"
                                              :class="{
                                                  'bg-amber-100 text-amber-800': order.status === 'pending',
                                                  'bg-blue-100 text-blue-800': order.status === 'paid',
                                                  'bg-purple-100 text-purple-800': order.status === 'shipped',
                                                  'bg-green-100 text-green-800': order.status === 'delivered',
                                                  'bg-red-100 text-red-800': order.status === 'cancelled'
                                              }"
                                              x-text="order.status">Status</span>
                                    </td>

                                    <!-- Verification Action -->
                                    <td class="py-4 text-right flex justify-end gap-2 mt-2">
                                        <template x-if="order.payment && order.payment.status === 'pending'">
                                            <div class="flex gap-1">
                                                <button @click="approvePayment(order)" class="bg-green-50 text-green-600 px-3 py-1.5 rounded-lg font-bold hover:bg-green-100">Setujui</button>
                                                <button @click="rejectPayment(order)" class="bg-red-50 text-red-600 px-3 py-1.5 rounded-lg font-bold hover:bg-red-100">Tolak</button>
                                            </div>
                                        </template>
                                        <template x-if="order.status === 'paid'">
                                            <button @click="updateShipStatus(order, 'shipped')" class="bg-purple-50 text-purple-600 px-3 py-1.5 rounded-lg font-bold hover:bg-purple-100">Kirim Barang</button>
                                        </template>
                                        <template x-if="order.status === 'shipped'">
                                            <button @click="updateShipStatus(order, 'delivered')" class="bg-green-50 text-green-600 px-3 py-1.5 rounded-lg font-bold hover:bg-green-100">Selesaikan</button>
                                        </template>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ── TAB: MONITORING PENGUNJUNG ── -->
        <div x-show="activeTab === 'monitoring'" class="space-y-6" style="display: none;">
            <div class="bg-white rounded-3xl border border-brand-beige p-8 shadow-lg">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="font-heading font-bold text-lg text-brand-dark">Sistem Monitoring Server & Pengunjung (Simulasi)</h3>
                        <p class="text-xs text-gray-500 mt-1">Mengawasi stabilitas, beban database, dan sesi pengguna secara waktu nyata.</p>
                    </div>
                    <span class="w-3.5 h-3.5 bg-green-500 rounded-full animate-ping" title="Sistem Aktif"></span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Visitors widget -->
                    <div class="p-6 bg-brand-cream border border-brand-beige rounded-2xl shadow-inner flex flex-col justify-between h-36">
                        <div class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Pengunjung Online Saat Ini</div>
                        <div class="text-4xl font-extrabold text-brand-dark flex items-baseline gap-2">
                            <span x-text="liveStats.visitors">0</span>
                            <span class="text-xs text-green-600 font-bold">▲ Live</span>
                        </div>
                        <div class="text-[10px] text-gray-400 font-semibold leading-relaxed">
                            Simulasi lalu lintas real-time berdasarkan aktivitas REST API request.
                        </div>
                    </div>
                    <!-- CPU/Memory load widget -->
                    <div class="p-6 bg-brand-cream border border-brand-beige rounded-2xl shadow-inner flex flex-col justify-between h-36">
                        <div class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Beban Database & Memori</div>
                        <div class="text-4xl font-extrabold text-brand-dark" x-text="liveStats.dbLoad + '%'">0%</div>
                        <!-- Progress bar -->
                        <div class="w-full bg-brand-beige/50 h-2 rounded-full overflow-hidden mt-2">
                            <div class="bg-brand-terracotta h-full transition-all duration-1000" :style="'width: ' + liveStats.dbLoad + '%'"></div>
                        </div>
                    </div>
                    <!-- Throughput (Req/sec) widget -->
                    <div class="p-6 bg-brand-cream border border-brand-beige rounded-2xl shadow-inner flex flex-col justify-between h-36">
                        <div class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">API Throughput (Request/Sec)</div>
                        <div class="text-4xl font-extrabold text-brand-dark" x-text="liveStats.throughput + ' req/s'">0 req/s</div>
                        <div class="text-[10px] text-gray-400 font-semibold leading-relaxed">
                            Mengukur request JWT Authorization per detik.
                        </div>
                    </div>
                </div>

                <div class="mt-8 border-t border-brand-beige pt-8">
                    <h4 class="font-heading font-bold text-brand-dark text-sm mb-4">Grafik Beban Server Simulasi (10 Detik Terakhir)</h4>
                    <div class="flex items-end gap-1.5 h-36 pt-4 bg-brand-cream border border-brand-beige rounded-2xl px-6 relative shadow-inner">
                        <template x-for="load in liveStats.loadHistory">
                            <div class="flex-grow bg-brand-terracotta/20 hover:bg-brand-terracotta transition-colors rounded-t-md" 
                                 :style="'height: ' + load + '%'" 
                                 :title="'Beban: ' + load + '%'"></div>
                        </template>
                        <!-- Grid lines -->
                        <div class="absolute inset-y-0 left-0 right-0 flex flex-col justify-between pointer-events-none px-6 opacity-30 text-[9px] font-bold text-brand-accent">
                            <div class="border-b border-brand-accent/20 w-full pt-1">100% Load</div>
                            <div class="border-b border-brand-accent/20 w-full">50% Load</div>
                            <div class="w-full pb-1">0% Load</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── TAB: PROFILE (PROFIL SAYA) ── -->
        <div x-show="activeTab === 'profile'" class="bg-white rounded-3xl border border-brand-beige shadow-lg p-8 relative" style="display: none;">
            <div class="absolute inset-1 border border-dashed border-brand-beige/40 rounded-2xl pointer-events-none"></div>
            
            <h2 class="relative z-10 font-heading font-bold text-xl md:text-2xl text-brand-dark mb-6 border-b border-brand-beige/50 pb-4">
                <span>Profil Administrator</span>
            </h2>

            <div class="relative z-10 grid grid-cols-1 md:grid-cols-3 gap-8 text-xs font-semibold">
                <!-- Left avatar -->
                <div class="md:col-span-1 bg-gradient-to-b from-brand-cream via-[#FFFDFC] to-brand-cream/40 border border-brand-beige rounded-2xl p-6 flex flex-col items-center text-center relative overflow-hidden artisan-card">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-brand-accent to-brand-terracotta border-4 border-brand-beige/60 flex items-center justify-center shadow-lg relative mb-4 overflow-hidden">
                        <template x-if="adminUser.avatar">
                            <img :src="adminUser.avatar" class="w-full h-full object-cover" alt="Avatar">
                        </template>
                        <template x-if="!adminUser.avatar">
                            <span class="font-heading font-extrabold text-4xl text-white select-none" x-text="adminUser.name ? adminUser.name.charAt(0).toUpperCase() : 'A'">A</span>
                        </template>
                        <div class="absolute -bottom-1 -right-1 bg-brand-dark text-white text-[9px] font-extrabold px-2.5 py-0.5 rounded-full border border-brand-beige shadow">ADMIN</div>
                    </div>
                    <h3 class="font-heading font-bold text-lg text-brand-dark" x-text="adminUser.name">Admin</h3>
                    <p class="text-xs text-brand-clay font-semibold mt-1" x-text="adminUser.email">admin@craftive.id</p>
                </div>

                <!-- Right fields -->
                <div class="md:col-span-2 space-y-6">
                    <div x-show="!isEditingProfile" class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] text-brand-accent uppercase tracking-wider mb-2 font-bold">Nama Lengkap</label>
                            <div class="bg-brand-cream/60 border border-brand-beige p-4 rounded-xl text-brand-dark font-extrabold shadow-sm" x-text="adminUser.name">Nama</div>
                        </div>
                        <div>
                            <label class="block text-[10px] text-brand-accent uppercase tracking-wider mb-2 font-bold">Email</label>
                            <div class="bg-brand-cream/60 border border-brand-beige p-4 rounded-xl text-brand-dark font-extrabold shadow-sm" x-text="adminUser.email">Email</div>
                        </div>
                        <div>
                            <label class="block text-[10px] text-brand-accent uppercase tracking-wider mb-2 font-bold">Nomor Telepon</label>
                            <div class="bg-brand-cream/60 border border-brand-beige p-4 rounded-xl text-brand-dark font-extrabold shadow-sm" x-text="adminUser.phone || 'Belum diisi'">Telepon</div>
                        </div>
                        <div>
                            <label class="block text-[10px] text-brand-accent uppercase tracking-wider mb-2 font-bold">Alamat Kantor</label>
                            <div class="bg-brand-cream/60 border border-brand-beige p-4 rounded-xl text-brand-dark font-extrabold shadow-sm" x-text="adminUser.address || 'Indonesia'">Alamat</div>
                        </div>
                    </div>

                    <div x-show="!isEditingProfile" class="flex justify-end pt-4">
                        <button @click="startEditProfile" class="bg-gradient-to-r from-brand-terracotta-light to-brand-terracotta text-white py-3 px-6 rounded-xl font-bold text-xs hover:shadow-lg transition-all flex items-center gap-1.5 shadow-brand-terracotta/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00-2 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Edit Profil Admin
                        </button>
                    </div>

                    <!-- Editing Form -->
                    <form x-show="isEditingProfile" @submit.prevent="saveProfile" class="space-y-6" style="display: none;">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="sm:col-span-2">
                                <label class="block text-[10px] text-brand-accent uppercase tracking-wider mb-2 font-bold">Foto Profil (Avatar)</label>
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-full border border-brand-beige overflow-hidden bg-brand-cream/35 flex items-center justify-center">
                                        <template x-if="editAvatar">
                                            <img :src="editAvatar" class="w-full h-full object-cover" alt="Preview">
                                        </template>
                                        <template x-if="!editAvatar">
                                            <span class="text-[9px] font-bold text-gray-400">No Pic</span>
                                        </template>
                                    </div>
                                    <input type="file" @change="handleAvatarUpload" accept="image/*" class="text-[10px] text-brand-clay file:mr-4 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-[10px] file:font-bold file:bg-brand-cream file:text-brand-dark hover:file:bg-brand-beige transition-all">
                                    <button type="button" x-show="editAvatar" @click="editAvatar = ''" class="text-red-500 hover:text-red-700 font-bold text-[10px] uppercase">Hapus</button>
                                </div>
                            </div>
                            <div>
                                <label class="block text-[10px] text-brand-accent uppercase tracking-wider mb-2 font-bold">Nama Lengkap</label>
                                <input type="text" x-model="editName" class="w-full bg-white border border-brand-beige rounded-xl p-3.5 text-xs outline-none focus:border-brand-terracotta transition-colors shadow-inner font-extrabold text-brand-dark" required>
                            </div>
                            <div>
                                <label class="block text-[10px] text-brand-accent uppercase tracking-wider mb-2 font-bold">Email</label>
                                <input type="email" x-model="editEmail" class="w-full bg-white border border-brand-beige rounded-xl p-3.5 text-xs outline-none focus:border-brand-terracotta transition-colors shadow-inner font-extrabold text-brand-dark" required>
                            </div>
                            <div>
                                <label class="block text-[10px] text-brand-accent uppercase tracking-wider mb-2 font-bold">Nomor Telepon</label>
                                <input type="text" x-model="editPhone" class="w-full bg-white border border-brand-beige rounded-xl p-3.5 text-xs outline-none focus:border-brand-terracotta transition-colors shadow-inner font-extrabold text-brand-dark" placeholder="Masukkan nomor telepon">
                            </div>
                            <div>
                                <label class="block text-[10px] text-brand-accent uppercase tracking-wider mb-2 font-bold">Alamat Kantor</label>
                                <input type="text" x-model="editAddress" class="w-full bg-white border border-brand-beige rounded-xl p-3.5 text-xs outline-none focus:border-brand-terracotta transition-colors shadow-inner font-extrabold text-brand-dark" placeholder="Masukkan alamat lengkap">
                            </div>
                        </div>
                        <div class="flex justify-end gap-3 pt-4">
                            <button type="button" @click="isEditingProfile = false" class="border border-brand-beige text-brand-dark py-3 px-6 rounded-xl font-bold text-xs hover:bg-brand-beige/20 transition-all">
                                Batal
                            </button>
                            <button type="submit" 
                                    :disabled="profileSaving"
                                    class="bg-gradient-to-r from-brand-terracotta-light to-brand-terracotta text-white py-3 px-6 rounded-xl font-bold text-xs hover:opacity-95 hover:shadow-lg transition-all flex items-center justify-center gap-1.5 shadow-brand-terracotta/20">
                                <span x-show="profileSaving" class="animate-spin border-2 border-white border-t-transparent w-3 h-3 rounded-full"></span>
                                <span x-text="profileSaving ? 'Menyimpan...' : 'Simpan Perubahan'"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- ── PAYMENT PROOF VIEW MODAL ── -->
    <div x-show="paymentModalOpen" class="fixed inset-0 bg-brand-dark/65 backdrop-blur-sm z-50 flex items-center justify-center p-4" style="display: none;">
        <div class="bg-white border-2 border-brand-beige rounded-3xl p-8 max-w-sm w-full shadow-2xl relative" @click.away="paymentModalOpen = false">
            <button @click="paymentModalOpen = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
            <h3 class="font-heading font-extrabold text-lg text-brand-dark mb-4">Bukti Pembayaran</h3>
            <div class="bg-brand-cream border border-brand-beige rounded-2xl h-64 overflow-hidden mb-4 shadow-inner flex items-center justify-center">
                <template x-if="activePayment && activePayment.proof_image">
                    <img :src="activePayment.proof_image" class="w-full h-full object-contain" alt="Bukti Transfer">
                </template>
            </div>
            <div class="text-xs space-y-2 text-brand-dark font-semibold">
                <div>Jumlah Transfer: <span class="text-brand-terracotta font-extrabold" x-text="activePayment ? 'Rp ' + Number(activePayment.amount).toLocaleString('id-ID') : 'Rp 0'"></span></div>
                <div>Metode Bayar: <span class="text-brand-accent uppercase" x-text="activePayment ? activePayment.method : ''"></span></div>
                <div>Status Konfirmasi: <span class="uppercase tracking-widest text-[9px] px-2 py-0.5 rounded font-extrabold bg-amber-50 text-brand-accent" x-text="activePayment ? activePayment.status : ''"></span></div>
            </div>
            <button @click="paymentModalOpen = false" class="mt-6 w-full bg-brand-dark hover:bg-brand-terracotta text-white py-3 rounded-xl text-xs font-bold uppercase transition-colors">Tutup Jendela</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('adminDashboard', () => ({
            activeTab: 'stats',
            stats: {},
            categories: [],
            products: [],
            shops: [],
            users: [],
            orders: [],
            formLoading: false,
            adminUser: {},

            // Edit Profile States
            isEditingProfile: false,
            editName: '',
            editEmail: '',
            editPhone: '',
            editAddress: '',
            editAvatar: '',
            profileSaving: false,

            startEditProfile() {
                this.editName = this.adminUser.name || '';
                this.editEmail = this.adminUser.email || '';
                this.editPhone = this.adminUser.phone || '';
                this.editAddress = this.adminUser.address || '';
                this.editAvatar = this.adminUser.avatar || '';
                this.isEditingProfile = true;
            },

            handleAvatarUpload(e) {
                const file = e.target.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = (event) => {
                    this.editAvatar = event.target.result;
                };
                reader.readAsDataURL(file);
            },

            async saveProfile() {
                this.profileSaving = true;
                try {
                    const data = await window.apiFetch('/api/auth/profile', {
                        method: 'PUT',
                        body: JSON.stringify({
                            name: this.editName,
                            email: this.editEmail,
                            phone: this.editPhone,
                            address: this.editAddress,
                            avatar: this.editAvatar
                        })
                    });

                    // Update localStorage user details
                    localStorage.setItem('user', JSON.stringify(data.user));
                    this.adminUser = data.user;
                    
                    // Dispatch event to layout header/avatar
                    window.dispatchEvent(new CustomEvent('auth-changed'));
                    
                    window.addToast('success', 'Profil admin berhasil diperbarui.');
                    this.isEditingProfile = false;
                } catch (error) {
                    window.addToast('error', error.message || 'Gagal memperbarui profil.');
                } finally {
                    this.profileSaving = false;
                }
            },

            // Product CRUD form state
            formProduct: {
                shop_id: '',
                category_id: '',
                name: '',
                price: '',
                stock: '',
                style: '',
                target_demographic: '',
                description: ''
            },
            editingProduct: null,

            // Category form state
            formCategoryName: '',
            formCategoryIcon: '',

            // Payment modal state
            paymentModalOpen: false,
            activePayment: null,

            // Server monitoring state (simulasi real-time)
            liveStats: {
                visitors: 12,
                dbLoad: 42,
                throughput: 8.5,
                loadHistory: [25, 30, 42, 60, 48, 55, 38, 41, 52, 45]
            },

            async init() {
                const user = JSON.parse(localStorage.getItem('user'));
                if (!user || user.role !== 'admin') {
                    window.location.href = '{{ route("login") }}';
                    return;
                }
                this.adminUser = user;

                // Load initial stats
                await this.loadStats();
                await this.loadCategories();
                await this.loadProducts();
                await this.loadShops();
                await this.loadUsers();
                await this.loadOrders();

                // Start simulated server monitor ticker (setiap 3 detik)
                setInterval(() => {
                    this.liveStats.visitors = Math.max(5, this.liveStats.visitors + randRange(-3, 4));
                    this.liveStats.dbLoad = Math.max(10, Math.min(95, this.liveStats.dbLoad + randRange(-5, 6)));
                    this.liveStats.throughput = parseFloat(Math.max(1, this.liveStats.throughput + randRange(-2, 3) * 0.5).toFixed(1));
                    this.liveStats.loadHistory.shift();
                    this.liveStats.loadHistory.push(this.liveStats.dbLoad);
                }, 3000);
            },

            setTab(tab) {
                this.activeTab = tab;
            },

            async loadStats() {
                try {
                    const data = await window.apiFetch('/api/admin/dashboard');
                    if (data) this.stats = data;
                } catch (error) {
                    console.error('Gagal memuat statistik platform:', error);
                }
            },

            async loadCategories() {
                try {
                    const response = await fetch('{{ url("/api/categories") }}', {
                        headers: { 'X-API-KEY': 'craftive-public-key-2026' }
                    });
                    this.categories = await response.json();
                } catch (error) {
                    console.error('Gagal mengambil kategori:', error);
                }
            },

            async loadProducts() {
                try {
                    this.products = await window.apiFetch('/api/admin/products');
                } catch (error) {
                    console.error('Gagal memuat produk kriya:', error);
                }
            },

            async loadShops() {
                try {
                    this.shops = await window.apiFetch('/api/admin/shops');
                } catch (error) {
                    console.error('Gagal memuat daftar toko:', error);
                }
            },

            async loadUsers() {
                try {
                    this.users = await window.apiFetch('/api/admin/users');
                } catch (error) {
                    console.error('Gagal memuat daftar pengguna:', error);
                }
            },

            async loadOrders() {
                try {
                    this.orders = await window.apiFetch('/api/admin/orders');
                } catch (error) {
                    console.error('Gagal memuat daftar transaksi:', error);
                }
            },

            // ── ACTIONS ──

            // Add/Edit Product CRUD
            async submitProductForm() {
                this.formLoading = true;
                try {
                    if (this.editingProduct) {
                        await window.apiFetch('/api/admin/products/' + this.editingProduct.id, {
                            method: 'PUT',
                            body: JSON.stringify(this.formProduct)
                        });
                        window.addToast('success', 'Produk berhasil diperbarui.');
                    } else {
                        await window.apiFetch('/api/admin/products', {
                            method: 'POST',
                            body: JSON.stringify(this.formProduct)
                        });
                        window.addToast('success', 'Produk baru berhasil ditambahkan.');
                    }
                    this.resetProductForm();
                    await this.loadProducts();
                    await this.loadStats();
                } catch (error) {
                    window.addToast('error', error.message || 'Gagal menyimpan produk.');
                } finally {
                    this.formLoading = false;
                }
            },

            editProduct(p) {
                this.editingProduct = p;
                this.formProduct = {
                    shop_id: p.shop_id,
                    category_id: p.category_id,
                    name: p.name,
                    price: Math.floor(p.price),
                    stock: p.stock,
                    style: p.style || '',
                    target_demographic: p.target_demographic || '',
                    description: p.description,
                    image_url: p.image_url || ''
                };
            },

            async deleteProduct(id) {
                if (!confirm('Apakah Anda yakin ingin menghapus produk kriya ini?')) return;
                try {
                    await window.apiFetch('/api/admin/products/' + id, { method: 'DELETE' });
                    window.addToast('success', 'Produk berhasil dihapus.');
                    await this.loadProducts();
                    await this.loadStats();
                } catch (error) {
                    window.addToast('error', error.message || 'Gagal menghapus produk.');
                }
            },

            resetProductForm() {
                this.editingProduct = null;
                this.formProduct = {
                    shop_id: '',
                    category_id: '',
                    name: '',
                    price: '',
                    stock: '',
                    style: '',
                    target_demographic: '',
                    description: '',
                    image_url: ''
                };
            },

            // Verify Shop
            async toggleShopVerification(shop) {
                try {
                    await window.apiFetch('/api/admin/shops/' + shop.id + '/verify', {
                        method: 'PUT',
                        body: JSON.stringify({ is_verified: !shop.is_verified })
                    });
                    window.addToast('success', 'Status verifikasi toko berhasil diubah.');
                    await this.loadShops();
                } catch (error) {
                    window.addToast('error', error.message || 'Gagal mengubah verifikasi toko.');
                }
            },

            // Toggle User Status
            async toggleUserStatus(u) {
                try {
                    await window.apiFetch('/api/admin/users/' + u.id, {
                        method: 'PUT',
                        body: JSON.stringify({
                            name: u.name,
                            email: u.email,
                            role: u.role,
                            is_active: !u.is_active
                        })
                    });
                    window.addToast('success', 'Status pengguna berhasil diperbarui.');
                    await this.loadUsers();
                } catch (error) {
                    window.addToast('error', error.message || 'Gagal mengubah status pengguna.');
                }
            },

            async deleteUser(id) {
                if (!confirm('Hapus pengguna ini secara permanen?')) return;
                try {
                    await window.apiFetch('/api/admin/users/' + id, { method: 'DELETE' });
                    window.addToast('success', 'Pengguna berhasil dihapus.');
                    await this.loadUsers();
                } catch (error) {
                    window.addToast('error', error.message || 'Gagal menghapus pengguna.');
                }
            },

            // Verify Payment & shipping
            showPaymentModal(payment) {
                this.activePayment = payment;
                this.paymentModalOpen = true;
            },

            async approvePayment(order) {
                try {
                    await window.apiFetch('/api/admin/orders/' + order.id + '/status', {
                        method: 'PUT',
                        body: JSON.stringify({
                            status: 'paid',
                            payment_status: 'confirmed'
                        })
                    });
                    window.addToast('success', 'Pembayaran disetujui. Status pesanan diubah ke Paid.');
                    await this.loadOrders();
                    await this.loadStats();
                } catch (error) {
                    window.addToast('error', error.message || 'Gagal mengkonfirmasi pembayaran.');
                }
            },

            async rejectPayment(order) {
                try {
                    await window.apiFetch('/api/admin/orders/' + order.id + '/status', {
                        method: 'PUT',
                        body: JSON.stringify({
                            status: 'cancelled',
                            payment_status: 'rejected'
                        })
                    });
                    window.addToast('success', 'Pembayaran ditolak. Transaksi dibatalkan.');
                    await this.loadOrders();
                    await this.loadStats();
                } catch (error) {
                    window.addToast('error', error.message || 'Gagal membatalkan pembayaran.');
                }
            },

            async updateShipStatus(order, newStatus) {
                try {
                    await window.apiFetch('/api/admin/orders/' + order.id + '/status', {
                        method: 'PUT',
                        body: JSON.stringify({ status: newStatus })
                    });
                    window.addToast('success', 'Status pengiriman diperbarui ke: ' + newStatus);
                    await this.loadOrders();
                } catch (error) {
                    window.addToast('error', error.message || 'Gagal memperbarui status pengiriman.');
                }
            },

            // Create Category
            async submitAddCategory() {
                this.formLoading = true;
                try {
                    await window.apiFetch('/api/admin/categories', {
                        method: 'POST',
                        body: JSON.stringify({
                            name: this.formCategoryName,
                            icon: this.formCategoryIcon
                        })
                    });

                    window.addToast('success', 'Kategori baru berhasil disimpan!');
                    this.formCategoryName = '';
                    this.formCategoryIcon = '';
                    await this.loadCategories();
                    await this.loadStats();
                } catch (error) {
                    window.addToast('error', error.message || 'Gagal menyimpan kategori baru.');
                } finally {
                    this.formLoading = false;
                }
            }
        }));

        // Helper random range
        function randRange(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }
    });
</script>
@endsection
