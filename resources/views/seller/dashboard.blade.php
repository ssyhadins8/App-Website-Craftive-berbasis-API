@extends('layouts.app')

@section('content')
<div class="py-12 bg-brand-cream min-h-screen" x-data="sellerDashboard">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="font-heading font-extrabold text-3xl text-brand-dark">Dashboard Penjual</h1>
                <p class="text-xs text-gray-500 mt-1" x-text="'Kelola toko ' + (shop?.name || '') + ' Anda.'">Kelola toko Anda.</p>
            </div>
            
            <!-- Tabs Nav -->
            <div class="flex bg-white/80 border border-brand-beige p-1.5 rounded-2xl gap-1 text-xs font-bold">
                <button @click="setTab('products')" :class="activeTab === 'products' ? 'bg-brand-terracotta text-white shadow-md' : 'text-gray-500 hover:text-brand-terracotta'" class="px-5 py-2.5 rounded-xl transition-all">Katalog Produk</button>
                <button @click="setTab('orders')" :class="activeTab === 'orders' ? 'bg-brand-terracotta text-white shadow-md' : 'text-gray-500 hover:text-brand-terracotta'" class="px-5 py-2.5 rounded-xl transition-all">Pesanan Masuk</button>
                <button @click="setTab('proposals')" :class="activeTab === 'proposals' ? 'bg-brand-terracotta text-white shadow-md' : 'text-gray-500 hover:text-brand-terracotta'" class="px-5 py-2.5 rounded-xl transition-all">Proposal Custom</button>
                <button @click="setTab('profile')" :class="activeTab === 'profile' ? 'bg-brand-terracotta text-white shadow-md' : 'text-gray-500 hover:text-brand-terracotta'" class="px-5 py-2.5 rounded-xl transition-all">Info Toko</button>
            </div>
        </div>

        <!-- ── TAB: PRODUCTS (CRUD LIST & ADD FORM) ── -->
        <div x-show="activeTab === 'products'" class="space-y-6">
            
            <!-- Add Product Trigger & Catalog Summary -->
            <div class="flex justify-between items-center bg-white rounded-2xl p-4 border border-brand-beige shadow-sm">
                <span class="text-xs font-bold text-gray-500" x-text="myProducts.length + ' produk aktif di katalog'">0 produk aktif</span>
                <button @click="openAddProductModal = true" class="btn-gradient text-white px-5 py-2.5 rounded-xl font-bold text-xs hover:shadow-md transition-all flex items-center gap-1.5">
                    Tambah Produk Baru
                </button>
            </div>

            <!-- Products List -->
            <div class="bg-white rounded-3xl border border-brand-beige shadow-lg p-8">
                <h2 class="font-heading font-bold text-xl text-brand-dark mb-6">Katalog Toko Anda</h2>

                <div x-show="myProducts.length > 0" class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-brand-beige font-extrabold text-brand-accent uppercase tracking-wider">
                                <th class="pb-3 w-16">Gambar</th>
                                <th class="pb-3">Nama Produk</th>
                                <th class="pb-3">Harga</th>
                                <th class="pb-3">Stok</th>
                                <th class="pb-3">Kategori</th>
                                <th class="pb-3">Target</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-brand-beige/50 font-semibold text-brand-dark">
                            <template x-for="p in myProducts" :key="p.id">
                                <tr>
                                    <td class="py-4">
                                        <div class="w-10 h-10 rounded-xl bg-brand-cream border border-brand-beige flex items-center justify-center overflow-hidden shadow-inner">
                                            <template x-if="p.image_url">
                                                <img :src="p.image_url" class="w-full h-full object-cover" :alt="p.name">
                                            </template>
                                            <template x-if="!p.image_url">
                                                <span class="text-[9px] uppercase font-bold text-brand-dark/40">Kriya</span>
                                            </template>
                                        </div>
                                    </td>
                                    <td class="py-4 font-bold text-brand-dark" x-text="p.name">Produk</td>
                                    <td class="py-4 text-brand-terracotta font-extrabold" x-text="'Rp ' + Number(p.price).toLocaleString('id-ID')">Rp 0</td>
                                    <td class="py-4" x-text="p.stock + ' unit'">0 unit</td>
                                    <td class="py-4"><span class="bg-brand-cream px-3 py-1 rounded-full text-brand-accent font-bold" x-text="p.category?.name || 'Kategori'">Kategori</span></td>
                                    <td class="py-4"><span class="bg-amber-50 border border-amber-200 text-amber-700 px-3 py-1 rounded-full font-bold uppercase text-[9px]" x-text="p.target_demographic || 'Semua'">Target</span></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <!-- Empty Products state -->
                <div x-show="myProducts.length === 0" class="text-center py-16">
                    <h3 class="font-heading font-bold text-lg mt-4 text-brand-dark">Belum Ada Produk</h3>
                    <p class="text-xs text-gray-500 mt-2">Toko Anda belum memiliki produk untuk dijual. Mulai tambahkan produk baru!</p>
                </div>
            </div>

            <!-- Add Product Modal -->
            <div x-show="openAddProductModal" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4" style="display: none;">
                <div class="bg-white rounded-3xl border border-brand-beige max-w-md w-full p-8 shadow-2xl relative">
                    <button @click="openAddProductModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
                    
                    <h3 class="font-heading font-bold text-xl text-brand-dark mb-6">Tambah Produk Baru</h3>
                    
                    <form @submit.prevent="submitAddProduct">
                        <div class="mb-4">
                            <label class="block text-xs font-bold uppercase tracking-wider text-brand-accent mb-2">Nama Kerajinan</label>
                            <input type="text" x-model="formName" class="w-full bg-brand-cream border border-brand-beige rounded-2xl p-3 text-xs outline-none focus:border-brand-terracotta" placeholder="Misal: Cangkir Tanah Liat Estetik" required>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-brand-accent mb-2">Harga (Rupiah)</label>
                                <input type="number" x-model="formPrice" class="w-full bg-brand-cream border border-brand-beige rounded-2xl p-3 text-xs outline-none focus:border-brand-terracotta" placeholder="125000" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-brand-accent mb-2">Stok Unit</label>
                                <input type="number" x-model="formStock" class="w-full bg-brand-cream border border-brand-beige rounded-2xl p-3 text-xs outline-none focus:border-brand-terracotta" placeholder="10" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-xs font-bold uppercase tracking-wider text-brand-accent mb-2">Kategori Produk</label>
                            <select x-model="formCategory" class="w-full bg-brand-cream border border-brand-beige rounded-2xl p-3 text-xs outline-none focus:border-brand-terracotta" required>
                                <option value="">Pilih Kategori</option>
                                <template x-for="cat in categories" :key="cat.id">
                                    <option :value="cat.id" x-text="cat.name"></option>
                                </template>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-xs font-bold uppercase tracking-wider text-brand-accent mb-2">Target Penerima / Usia</label>
                            <select x-model="formDemographic" class="w-full bg-brand-cream border border-brand-beige rounded-2xl p-3 text-xs outline-none focus:border-brand-terracotta" required>
                                <option value="">Pilih Target</option>
                                <option value="anak-anak">Khusus Anak-anak</option>
                                <option value="remaja">Gaya Remaja</option>
                                <option value="mahasiswa">Kebutuhan Mahasiswa</option>
                                <option value="dewasa">Gaya Dewasa</option>
                            </select>
                        </div>
                        <div class="mb-5">
                            <label class="block text-xs font-bold uppercase tracking-wider text-brand-accent mb-2">Deskripsi Detail</label>
                            <textarea x-model="formDescription" class="w-full bg-brand-cream border border-brand-beige rounded-2xl p-3 text-xs outline-none focus:border-brand-terracotta h-20" placeholder="Jelaskan detail bahan, teknik pembuatan, dan fungsi kerajinan ini..." required></textarea>
                        </div>
                        
                        <button type="submit" 
                                :disabled="formLoading"
                                class="w-full btn-gradient text-white py-3.5 rounded-2xl font-bold text-sm hover:shadow-lg transition-all flex items-center justify-center gap-2">
                            <span x-show="formLoading" class="animate-spin border-2 border-white border-t-transparent w-4 h-4 rounded-full"></span>
                            <span x-text="formLoading ? 'Menyimpan Produk...' : 'Simpan ke Katalog'"></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- ── TAB: ORDERS (PESANAN MASUK) ── -->
        <div x-show="activeTab === 'orders'" class="bg-white rounded-3xl border border-brand-beige shadow-lg p-8" style="display: none;">
            <h2 class="font-heading font-bold text-xl text-brand-dark mb-6">Pesanan Masuk dari Pembeli</h2>

            <div x-show="incomingOrders.length > 0" class="flex flex-col gap-6">
                <template x-for="order in incomingOrders" :key="order.id">
                    <div class="border border-brand-beige rounded-2xl p-6 hover:shadow-md transition-shadow">
                        
                        <!-- Header info -->
                        <div class="flex justify-between items-start border-b border-brand-beige/50 pb-4 mb-4 flex-wrap gap-2 text-xs font-semibold">
                            <div>
                                <span class="text-[10px] text-gray-400 font-semibold uppercase">ID Pesanan</span>
                                <div class="font-bold text-brand-dark" x-text="'#CRF-' + order.id">ID</div>
                            </div>
                            <div>
                                <span class="text-[10px] text-gray-400 font-semibold uppercase">Total Nilai</span>
                                <div class="font-extrabold text-brand-terracotta" x-text="'Rp ' + Number(order.total_amount).toLocaleString('id-ID')">Total</div>
                            </div>
                            <div>
                                <span class="text-[10px] text-gray-400 font-semibold uppercase">Alamat Kirim</span>
                                <div class="text-gray-600 max-w-[200px] truncate" x-text="order.shipping_address">Alamat</div>
                            </div>
                            <div>
                                <span class="text-[10px] text-gray-400 font-semibold uppercase">Status Saat Ini</span>
                                <div class="mt-0.5">
                                    <span class="text-[9px] uppercase font-extrabold px-3 py-1 rounded-full border"
                                          :class="{
                                              'bg-amber-50 text-amber-700 border-amber-200': order.status === 'pending',
                                              'bg-blue-50 text-blue-700 border-blue-200': order.status === 'paid',
                                              'bg-indigo-50 text-indigo-700 border-indigo-200': order.status === 'shipped',
                                              'bg-green-50 text-green-700 border-green-200': order.status === 'delivered',
                                              'bg-red-50 text-red-700 border-red-200': order.status === 'cancelled'
                                          }"
                                          x-text="order.status === 'pending' ? 'Pending' : (order.status === 'paid' ? 'Lunas / Siap Kirim' : (order.status === 'shipped' ? 'Dikirim' : (order.status === 'delivered' ? 'Selesai' : order.status)))">Pending</span>
                                </div>
                            </div>
                        </div>

                        <!-- Products list inside order -->
                        <div class="space-y-2 mb-4">
                            <template x-for="item in order.items" :key="item.id">
                                <div class="flex justify-between items-center text-xs">
                                    <span class="font-bold text-brand-dark" x-text="item.product?.name + ' (x' + item.qty + ')'">Produk x1</span>
                                    <span class="font-semibold text-brand-dark" x-text="'Rp ' + Number(item.price).toLocaleString('id-ID')">Harga</span>
                                </div>
                            </template>
                        </div>

                        <!-- Update action -->
                        <div class="border-t border-brand-beige/50 pt-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <template x-if="order.status === 'pending'">
                                    <span class="text-[10px] text-amber-600 font-extrabold uppercase bg-amber-50 border border-amber-200 px-3 py-1.5 rounded-xl tracking-wider flex items-center gap-1.5 shadow-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-ping"></span>
                                        Menunggu Verifikasi Pembayaran dari Admin
                                    </span>
                                </template>
                                <template x-if="order.status !== 'pending'">
                                    <span class="text-[10px] text-emerald-600 font-extrabold uppercase bg-emerald-50 border border-emerald-200 px-3 py-1.5 rounded-xl tracking-wider flex items-center gap-1">
                                        ✓ Pembayaran Aman & Terverifikasi
                                    </span>
                                </template>
                            </div>
                            
                            <div class="flex items-center gap-2">
                                <template x-if="order.status === 'paid'">
                                    <div class="flex items-center gap-2">
                                        <span class="text-[9px] text-gray-400 font-bold uppercase">Aksi:</span>
                                        <button @click="updateOrderStatus(order.id, 'shipped')" class="bg-blue-50 text-blue-700 border border-blue-200 px-3 py-1.5 rounded-xl text-[10px] font-bold hover:bg-blue-100 transition-colors shadow-sm">Kirim Barang</button>
                                    </div>
                                </template>
                                <template x-if="order.status === 'shipped'">
                                    <div class="flex items-center gap-2">
                                        <span class="text-[9px] text-gray-400 font-bold uppercase">Aksi:</span>
                                        <button @click="updateOrderStatus(order.id, 'delivered')" class="bg-green-50 text-green-700 border border-green-200 px-3 py-1.5 rounded-xl text-[10px] font-bold hover:bg-green-100 transition-colors shadow-sm">Tandai Selesai</button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Empty incoming orders state -->
            <div x-show="incomingOrders.length === 0" class="text-center py-16">
                <h3 class="font-heading font-bold text-lg mt-4 text-brand-dark">Belum Ada Pesanan Masuk</h3>
                <p class="text-xs text-gray-500 mt-2">Toko Anda belum menerima pesanan masuk dari pembeli.</p>
            </div>
        </div>

        <!-- ── TAB: PROPOSALS (PROPOSAL CUSTOM MASUK) ── -->
        <div x-show="activeTab === 'proposals'" class="bg-white rounded-3xl border border-brand-beige shadow-lg p-8" style="display: none;">
            <h2 class="font-heading font-bold text-xl text-brand-dark mb-6">Proposal Kriya Custom Masuk</h2>

            <div x-show="incomingProposals.length > 0" class="flex flex-col gap-6">
                <template x-for="prop in incomingProposals" :key="prop.id">
                    <div class="border border-brand-beige rounded-2xl p-6 hover:shadow-md transition-shadow relative overflow-hidden flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start border-b border-brand-beige/50 pb-4 mb-4 flex-wrap gap-2 text-xs font-semibold">
                                <div>
                                    <span class="text-[10px] text-gray-400 font-semibold uppercase">ID Proposal</span>
                                    <div class="font-bold text-brand-dark" x-text="'#PRP-' + prop.id">ID</div>
                                </div>
                                <div>
                                    <span class="text-[10px] text-gray-400 font-semibold uppercase">Nama Pengaju (Buyer)</span>
                                    <div class="font-bold text-brand-dark" x-text="prop.buyer?.name || 'Pembeli'">Nama</div>
                                </div>
                                <div>
                                    <span class="text-[10px] text-gray-400 font-semibold uppercase">Tawaran Budget</span>
                                    <div class="font-extrabold text-brand-terracotta" x-text="'Rp ' + Number(prop.budget).toLocaleString('id-ID')">Budget</div>
                                </div>
                                <div>
                                    <span class="text-[10px] text-gray-400 font-semibold uppercase">Status</span>
                                    <div class="mt-0.5">
                                        <span class="text-[9px] uppercase font-extrabold px-3 py-1 rounded-full border"
                                              :class="{
                                                  'bg-amber-50 text-amber-700 border-amber-200': prop.status === 'pending',
                                                  'bg-emerald-50 text-emerald-700 border-emerald-200': prop.status === 'accepted',
                                                  'bg-red-50 text-red-700 border-red-200': prop.status === 'rejected',
                                                  'bg-blue-50 text-blue-700 border-blue-200': prop.status === 'ordered'
                                              }"
                                              x-text="prop.status === 'pending' ? 'Pending' : (prop.status === 'accepted' ? 'Disetujui' : (prop.status === 'rejected' ? 'Ditolak' : prop.status))">Pending</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h4 class="font-bold text-sm text-brand-dark mb-1" x-text="prop.craft_type">Nama Kriya</h4>
                                <p class="text-xs text-gray-600 leading-relaxed bg-brand-cream/35 p-4 rounded-xl border border-brand-beige/30" x-text="prop.description"></p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4 text-xs font-semibold text-gray-500">
                                <div>Bahan Utama: <span class="text-brand-dark font-bold" x-text="prop.material"></span></div>
                                <div>Tenggat Waktu: <span class="text-brand-dark font-bold" x-text="prop.deadline_days + ' Hari'"></span></div>
                                <div>Estimasi AI: <span class="text-brand-dark font-bold" x-text="prop.estimated_days + ' Hari Kerja'"></span></div>
                                <div>Tingkat Kesulitan: <span class="text-brand-terracotta font-extrabold" x-text="prop.difficulty"></span></div>
                            </div>
                        </div>

                        <!-- Action buttons if pending -->
                        <div x-show="prop.status === 'pending'" class="border-t border-brand-beige/50 pt-4 flex justify-end items-center gap-3">
                            <span class="text-[10px] text-gray-400 font-bold uppercase">Aksi Proposal:</span>
                            <div class="flex gap-2">
                                <button @click="rejectProposal(prop.id)" class="bg-red-50 text-red-700 border border-red-200 px-3 py-1.5 rounded-xl text-xs font-bold hover:bg-red-100 transition-colors">Tolak</button>
                                <button @click="acceptProposal(prop.id)" class="bg-emerald-50 text-emerald-700 border border-emerald-200 px-3 py-1.5 rounded-xl text-xs font-bold hover:bg-emerald-100 transition-colors">Terima Proposal</button>
                            </div>
                        </div>

                        <!-- Info if accepted -->
                        <div x-show="prop.status === 'accepted'" class="border-t border-brand-beige/50 pt-4 flex justify-between items-center text-xs font-semibold text-emerald-700">
                            <span>✓ Proposal telah disetujui. Transaksi pemesanan otomatis terbuat.</span>
                            <button @click="setTab('orders')" class="text-brand-terracotta font-bold hover:underline">Lihat Pesanan &rarr;</button>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Empty proposals state -->
            <div x-show="incomingProposals.length === 0" class="text-center py-16">
                <h3 class="font-heading font-bold text-lg mt-4 text-brand-dark">Belum Ada Proposal Masuk</h3>
                <p class="text-xs text-gray-500 mt-2">Toko Anda belum menerima pengajuan proposal kriya custom dari pembeli.</p>
            </div>
        </div>

        <!-- ── TAB: PROFILE (INFO TOKO) ── -->
        <div x-show="activeTab === 'profile'" class="bg-white rounded-3xl border border-brand-beige shadow-lg p-8 relative" style="display: none;">
            <div class="absolute inset-1 border border-dashed border-brand-beige/40 rounded-2xl pointer-events-none"></div>

            <h2 class="relative z-10 font-heading font-bold text-xl md:text-2xl text-brand-dark mb-6 border-b border-brand-beige/50 pb-4">
                <span>Profil Toko Penjual</span>
            </h2>

            <div class="relative z-10 grid grid-cols-1 md:grid-cols-3 gap-8 text-xs font-semibold">
                <!-- Left avatar card -->
                <div class="md:col-span-1 bg-gradient-to-b from-brand-cream via-[#FFFDFC] to-brand-cream/40 border border-brand-beige rounded-2xl p-6 flex flex-col items-center text-center relative overflow-hidden artisan-card">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-brand-accent to-brand-terracotta border-4 border-brand-beige/60 flex items-center justify-center shadow-lg relative mb-4 overflow-hidden">
                        <template x-if="sellerUser.avatar">
                            <img :src="sellerUser.avatar" class="w-full h-full object-cover" alt="Avatar">
                        </template>
                        <template x-if="!sellerUser.avatar">
                            <span class="font-heading font-extrabold text-4xl text-white select-none" x-text="sellerUser.name ? sellerUser.name.charAt(0).toUpperCase() : 'S'">S</span>
                        </template>
                        <div class="absolute -bottom-1 -right-1 bg-brand-terracotta text-white text-[9px] font-extrabold px-2.5 py-0.5 rounded-full border border-brand-beige shadow">SELLER</div>
                    </div>
                    <h3 class="font-heading font-bold text-lg text-brand-dark" x-text="sellerUser.name">Penjual</h3>
                    <p class="text-xs text-brand-clay font-semibold mt-1" x-text="sellerUser.email">seller@craftive.id</p>
                </div>

                <!-- Right fields / form -->
                <div class="md:col-span-2 space-y-6">
                    <div x-show="!isEditingProfile" class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] text-brand-accent uppercase tracking-wider mb-2 font-bold">Pemilik Toko</label>
                            <div class="bg-brand-cream/60 border border-brand-beige p-4 rounded-xl text-brand-dark font-extrabold shadow-sm" x-text="sellerUser.name">Nama</div>
                        </div>
                        <div>
                            <label class="block text-[10px] text-brand-accent uppercase tracking-wider mb-2 font-bold">Email Akun</label>
                            <div class="bg-brand-cream/60 border border-brand-beige p-4 rounded-xl text-brand-dark font-extrabold shadow-sm" x-text="sellerUser.email">Email</div>
                        </div>
                        <div>
                            <label class="block text-[10px] text-brand-accent uppercase tracking-wider mb-2 font-bold">Nomor Telepon</label>
                            <div class="bg-brand-cream/60 border border-brand-beige p-4 rounded-xl text-brand-dark font-extrabold shadow-sm" x-text="sellerUser.phone || 'Belum diisi'">Telepon</div>
                        </div>
                        <div>
                            <label class="block text-[10px] text-brand-accent uppercase tracking-wider mb-2 font-bold">Alamat Produksi</label>
                            <div class="bg-brand-cream/60 border border-brand-beige p-4 rounded-xl text-brand-dark font-extrabold shadow-sm" x-text="sellerUser.address || 'Indonesia'">Alamat</div>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-[10px] text-brand-accent uppercase tracking-wider mb-2 font-bold">Nama Toko / Sanggar</label>
                            <div class="bg-brand-cream/40 border border-brand-beige/50 p-4 rounded-xl text-brand-dark font-extrabold italic shadow-sm" x-text="shop?.name || 'Toko Kerajinan Nusantara'">Toko</div>
                        </div>
                    </div>

                    <div x-show="!isEditingProfile" class="flex justify-end pt-4">
                        <button @click="startEditProfile" class="bg-gradient-to-r from-brand-terracotta-light to-brand-terracotta text-white py-3 px-6 rounded-xl font-bold text-xs hover:shadow-lg transition-all flex items-center gap-1.5 shadow-brand-terracotta/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00-2 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Edit Profil Penjual
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
                                <label class="block text-[10px] text-brand-accent uppercase tracking-wider mb-2 font-bold">Nama Pemilik</label>
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
                                <label class="block text-[10px] text-brand-accent uppercase tracking-wider mb-2 font-bold">Alamat Produksi</label>
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
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('sellerDashboard', () => ({
            activeTab: 'products',
            myProducts: [],
            incomingOrders: [],
            incomingProposals: [],
            categories: [],
            shop: null,
            sellerUser: {},
            openAddProductModal: false,
            formLoading: false,

            // Edit Profile States
            isEditingProfile: false,
            editName: '',
            editEmail: '',
            editPhone: '',
            editAddress: '',
            editAvatar: '',
            profileSaving: false,

            startEditProfile() {
                this.editName = this.sellerUser.name || '';
                this.editEmail = this.sellerUser.email || '';
                this.editPhone = this.sellerUser.phone || '';
                this.editAddress = this.sellerUser.address || '';
                this.editAvatar = this.sellerUser.avatar || '';
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
                    this.sellerUser = data.user;
                    
                    // Dispatch event to layout header/avatar
                    window.dispatchEvent(new CustomEvent('auth-changed'));
                    
                    window.addToast('success', 'Profil toko penjual berhasil diperbarui.');
                    this.isEditingProfile = false;
                } catch (error) {
                    window.addToast('error', error.message || 'Gagal memperbarui profil.');
                } finally {
                    this.profileSaving = false;
                }
            },

            // Form bindings
            formName: '',
            formPrice: '',
            formStock: '',
            formCategory: '',
            formDemographic: '',
            formDescription: '',

            async init() {
                const user = JSON.parse(localStorage.getItem('user'));
                if (!user || user.role !== 'seller') {
                    window.location.href = '{{ route("login") }}';
                    return;
                }
                this.sellerUser = user;

                // Load shop details
                try {
                    const shopsRes = await fetch('{{ url("/api/shops") }}', {
                        headers: { 'X-API-KEY': 'craftive-public-key-2026' }
                    });
                    const shopsData = await shopsRes.json();
                    
                    if (shopsData && Array.isArray(shopsData.data)) {
                        // Find the shop owned by this user
                        const matchedShop = shopsData.data.find(s => s.user_id === user.id);
                        if (matchedShop) {
                            this.shop = matchedShop;
                        }
                    }
                } catch (error) {
                    console.error('Gagal mengambil data toko:', error);
                }

                // Load product categories for the select box
                try {
                    const catRes = await fetch('{{ url("/api/categories") }}', {
                        headers: { 'X-API-KEY': 'craftive-public-key-2026' }
                    });
                    this.categories = await catRes.json();
                } catch (error) {
                    console.error('Gagal mengambil kategori:', error);
                }

                this.loadMyProducts();
                this.loadIncomingOrders();
                this.loadIncomingProposals();
            },

            setTab(tab) {
                this.activeTab = tab;
            },

            async loadMyProducts() {
                try {
                    const data = await window.apiFetch('/api/seller/products');
                    if (data && Array.isArray(data.data)) {
                        this.myProducts = data.data;
                    }
                } catch (error) {
                    console.error('Gagal mengambil katalog produk toko:', error);
                }
            },

            async loadIncomingOrders() {
                try {
                    const data = await window.apiFetch('/api/seller/orders');
                    if (data && Array.isArray(data.data)) {
                        this.incomingOrders = data.data.reverse();
                    }
                } catch (error) {
                    console.error('Gagal mengambil pesanan masuk:', error);
                }
            },

            async submitAddProduct() {
                this.formLoading = true;
                try {
                    await window.apiFetch('/api/seller/products', {
                        method: 'POST',
                        body: JSON.stringify({
                            category_id: this.formCategory,
                            name: this.formName,
                            description: this.formDescription,
                            price: this.formPrice,
                            stock: this.formStock,
                            target_demographic: this.formDemographic
                        })
                    });

                    window.addToast('success', 'Produk berhasil ditambahkan ke katalog!');
                    this.openAddProductModal = false;
                    
                    // Reset form fields
                    this.formName = '';
                    this.formPrice = '';
                    this.formStock = '';
                    this.formCategory = '';
                    this.formDemographic = '';
                    this.formDescription = '';
                    
                    this.loadMyProducts();

                } catch (error) {
                    window.addToast('error', error.message || 'Gagal menyimpan produk baru.');
                } finally {
                    this.formLoading = false;
                }
            },

            async updateOrderStatus(orderId, status) {
                try {
                    await window.apiFetch(`/api/seller/orders/${orderId}`, {
                        method: 'PUT',
                        body: JSON.stringify({ status })
                    });

                    window.addToast('success', 'Status pesanan berhasil diperbarui!');
                    this.loadIncomingOrders();

                } catch (error) {
                    window.addToast('error', 'Gagal memperbarui status pesanan.');
                }
            },

            async loadIncomingProposals() {
                try {
                    const data = await window.apiFetch('/api/custom-proposals');
                    if (data && Array.isArray(data)) {
                        this.incomingProposals = data;
                    }
                } catch (error) {
                    console.error('Gagal mengambil proposal custom:', error);
                }
            },

            async acceptProposal(id) {
                if (!confirm('Apakah Anda yakin ingin menyetujui proposal kriya custom ini?')) return;
                try {
                    const data = await window.apiFetch(`/api/custom-proposals/${id}/accept`, {
                        method: 'PUT'
                    });
                    window.addToast('success', data.message || 'Proposal disetujui! Pesanan kriya custom otomatis terbuat.');
                    this.loadIncomingProposals();
                    this.loadIncomingOrders();
                } catch (error) {
                    window.addToast('error', error.message || 'Gagal menyetujui proposal.');
                }
            },

            async rejectProposal(id) {
                if (!confirm('Apakah Anda yakin ingin menolak proposal kriya custom ini?')) return;
                try {
                    const data = await window.apiFetch(`/api/custom-proposals/${id}/reject`, {
                        method: 'PUT'
                    });
                    window.addToast('success', data.message || 'Proposal berhasil ditolak.');
                    this.loadIncomingProposals();
                } catch (error) {
                    window.addToast('error', error.message || 'Gagal menolak proposal.');
                }
            }
        }));
    });
</script>
@endsection
