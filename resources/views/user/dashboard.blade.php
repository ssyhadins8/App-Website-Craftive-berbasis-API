@extends('layouts.app')

@section('content')
<div class="py-12 bg-brand-cream min-h-screen" x-data="buyerDashboard">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Banner -->
        <div class="relative overflow-hidden bg-gradient-to-r from-brand-dark via-[#3d271e] to-brand-terracotta rounded-3xl p-8 md:p-10 mb-10 shadow-xl border border-brand-beige/20 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
            <!-- Decorative artisan dash border -->
            <div class="absolute inset-1 border border-dashed border-white/10 rounded-2xl pointer-events-none"></div>
            <!-- Decorative circles -->
            <div class="absolute -right-16 -bottom-16 w-48 h-48 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute right-12 -top-12 w-32 h-32 bg-brand-terracotta/20 rounded-full blur-xl pointer-events-none"></div>

            <div class="relative z-10 flex items-center gap-4">
                <!-- User avatar dynamic initial -->
                <div class="w-16 h-16 rounded-full bg-brand-cream border-2 border-brand-beige/50 flex items-center justify-center shadow-inner select-none flex-shrink-0">
                    <span class="font-heading font-extrabold text-2xl text-brand-dark" x-text="profile.name ? profile.name.charAt(0).toUpperCase() : 'B'">B</span>
                </div>
                <div>
                    <span class="text-[10px] text-brand-beige uppercase font-extrabold tracking-wider bg-white/10 px-2.5 py-0.5 rounded-full border border-white/5">Kolektor Seni Kriya</span>
                    <h1 class="font-heading font-extrabold text-2xl md:text-3xl text-brand-cream mt-1">Selamat Datang, <span x-text="profile.name || 'Siti Rahayu'">Siti Rahayu</span></h1>
                    <p class="text-xs text-brand-beige/80 mt-1">Kelola keranjang kurasi Anda dan pantau riwayat mahakarya pesanan Anda.</p>
                </div>
            </div>

            <!-- Tabs Nav (Premium styling) -->
            <div class="relative z-10 flex flex-wrap bg-[#1a0e0a]/40 backdrop-blur-md border border-white/10 p-1.5 rounded-2xl gap-1 text-xs font-bold shadow-lg">
                <button @click="setTab('cart')" :class="activeTab === 'cart' ? 'bg-gradient-to-br from-brand-accent to-brand-terracotta text-white shadow-lg' : 'text-brand-beige/80 hover:text-white'" class="px-5 py-2.5 rounded-xl transition-all flex items-center gap-2">
                    <!-- Icon Cart -->
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span>Keranjang</span>
                </button>
                <button @click="setTab('orders')" :class="activeTab === 'orders' ? 'bg-gradient-to-br from-brand-accent to-brand-terracotta text-white shadow-lg' : 'text-brand-beige/80 hover:text-white'" class="px-5 py-2.5 rounded-xl transition-all flex items-center gap-2">
                    <!-- Icon Receipt -->
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    <span>Pesanan Saya</span>
                </button>
                <button @click="setTab('planner')" :class="activeTab === 'planner' ? 'bg-gradient-to-br from-brand-accent to-brand-terracotta text-white shadow-lg' : 'text-brand-beige/80 hover:text-white'" class="px-5 py-2.5 rounded-xl transition-all flex items-center gap-2">
                    <!-- Icon AI Magic Sparkle -->
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                    <span>AI Planner</span>
                </button>
                <button @click="setTab('profile')" :class="activeTab === 'profile' ? 'bg-gradient-to-br from-brand-accent to-brand-terracotta text-white shadow-lg' : 'text-brand-beige/80 hover:text-white'" class="px-5 py-2.5 rounded-xl transition-all flex items-center gap-2">
                    <!-- Icon Profile -->
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>Profil</span>
                </button>
            </div>
        </div>

        <!-- ── TAB: CART ── -->
        <div x-show="activeTab === 'cart'" class="space-y-6">
            <div class="bg-white rounded-3xl border border-brand-beige shadow-xl p-6 md:p-8 relative">
                <!-- Dashed inner border -->
                <div class="absolute inset-1 border border-dashed border-brand-beige/40 rounded-2xl pointer-events-none"></div>

                <div class="relative z-10 flex items-center justify-between mb-8 border-b border-brand-beige/50 pb-4">
                    <h2 class="font-heading font-bold text-xl md:text-2xl text-brand-dark flex items-center gap-2">
                        <span>Keranjang Belanja Anda</span>
                        <span class="text-xs bg-brand-terracotta text-white font-extrabold px-2.5 py-0.5 rounded-full" x-text="cartItems.length">0</span>
                    </h2>
                </div>

                <div x-show="cartItems.length > 0" class="relative z-10">
                    <!-- Grouped Cart Items -->
                    <template x-for="group in groupedCartItems" :key="group.shopName">
                        <div class="mb-8 bg-brand-cream/35 border border-brand-beige/60 rounded-2xl p-5 artisan-card">
                            <!-- Shop Header -->
                            <div class="flex items-center justify-between pb-3 mb-4 border-b border-dashed border-brand-beige/80">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-brand-terracotta" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <span class="font-heading font-extrabold text-xs uppercase tracking-wider text-brand-dark" x-text="group.shopName">Nama Sanggar</span>
                                </div>
                                <span class="text-[9px] bg-emerald-50 text-emerald-700 font-extrabold px-2.5 py-0.5 rounded-full border border-emerald-200 uppercase tracking-wide">Pengiriman Langsung</span>
                            </div>

                            <!-- List inside Group -->
                            <div class="divide-y divide-brand-beige/30">
                                <template x-for="item in group.items" :key="item.id">
                                    <div class="py-4 flex flex-col md:flex-row md:items-center justify-between gap-4">
                                        <!-- Product Info -->
                                        <div class="flex items-center gap-4 flex-1">
                                            <div class="w-20 h-20 rounded-2xl bg-brand-cream border border-brand-beige overflow-hidden flex items-center justify-center flex-shrink-0 shadow-sm">
                                                <template x-if="item.product.image_url">
                                                    <img :src="item.product.image_url" class="w-full h-full object-cover" :alt="item.product.name">
                                                </template>
                                                <template x-if="!item.product.image_url">
                                                    <span class="text-[10px] uppercase font-extrabold text-brand-dark/30 text-center p-1">Kriya Lokal</span>
                                                </template>
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-brand-dark text-sm md:text-base" x-text="item.product.name">Nama Produk</h4>
                                                <p class="text-xs text-brand-terracotta font-extrabold mt-1" x-text="'Rp ' + Number(item.product.price).toLocaleString('id-ID')">Rp 0</p>
                                            </div>
                                        </div>

                                        <!-- Quantity Controls and Subtotal -->
                                        <div class="flex flex-wrap items-center justify-between md:justify-end gap-6 border-t md:border-t-0 border-brand-beige/20 pt-3 md:pt-0">
                                            <!-- Qty selector -->
                                            <div class="flex items-center gap-2">
                                                <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Jumlah:</span>
                                                <div class="flex items-center bg-white border border-brand-beige rounded-xl overflow-hidden shadow-sm">
                                                    <button @click="updateCartQty(item.id, item.qty - 1)" 
                                                            class="px-2.5 py-1 text-xs font-bold text-brand-dark hover:bg-brand-cream transition-colors disabled:opacity-30 border-r border-brand-beige"
                                                            :disabled="item.qty <= 1">&minus;</button>
                                                    <span class="px-3.5 py-1 text-xs font-extrabold text-brand-dark bg-brand-cream/10 select-none min-w-[24px] text-center" x-text="item.qty">1</span>
                                                    <button @click="updateCartQty(item.id, item.qty + 1)" 
                                                            class="px-2.5 py-1 text-xs font-bold text-brand-dark hover:bg-brand-cream transition-colors border-l border-brand-beige">+</button>
                                                </div>
                                            </div>

                                            <!-- Subtotal -->
                                            <div class="text-right">
                                                <span class="text-[9px] text-gray-400 font-semibold block uppercase">Subtotal</span>
                                                <span class="text-sm font-extrabold text-brand-dark" x-text="'Rp ' + (item.qty * item.product.price).toLocaleString('id-ID')">Rp 0</span>
                                            </div>

                                            <!-- Remove button -->
                                            <button @click="deleteCartItem(item.id)" class="text-red-500 hover:text-red-700 font-bold text-xs flex items-center gap-1 bg-red-50 hover:bg-red-100/50 px-3 py-1.5 rounded-xl transition-all border border-red-100">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                <span>Hapus</span>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>

                    <!-- Total amount and checkout -->
                    <div class="border-t border-brand-beige mt-8 pt-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                        <div>
                            <div class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Total Tagihan Keranjang</div>
                            <div class="text-brand-terracotta font-extrabold text-3xl mt-1" x-text="'Rp ' + totalCartPrice.toLocaleString('id-ID')">Rp 0</div>
                        </div>
                        
                        <button @click="openCheckoutModal = true" class="btn-gradient text-white px-8 py-4 rounded-2xl font-bold text-sm hover:shadow-xl hover:scale-[1.02] transition-all flex items-center gap-2">
                            <span>Checkout Sekarang</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Empty Cart State -->
                <div x-show="cartItems.length === 0" class="text-center py-20 relative z-10 flex flex-col items-center justify-center">
                    <div class="w-28 h-28 rounded-full bg-brand-cream border border-dashed border-brand-beige flex items-center justify-center mb-6 relative shadow-inner">
                        <!-- Basket SVG design -->
                        <svg class="w-12 h-12 text-brand-clay/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span class="absolute top-2 right-2 text-brand-gold animate-bounce">✦</span>
                    </div>
                    <h3 class="font-heading font-extrabold text-xl text-brand-dark">Keranjang Belanja Kosong</h3>
                    <p class="text-xs text-gray-500 max-w-sm mt-2">Anda belum mengurasi produk kriya apa pun ke keranjang belanja Anda.</p>
                    <a href="{{ url('/products') }}" class="inline-block btn-gradient text-white px-8 py-3.5 rounded-xl font-bold text-xs mt-6 hover:shadow-lg hover:scale-[1.02] transition-all">
                        Jelajahi Galeri Produk
                    </a>
                </div>
            </div>

            <!-- Checkout Modal -->
            <div x-show="openCheckoutModal" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4" style="display: none;">
                <div class="bg-white rounded-3xl border border-brand-beige max-w-md w-full p-8 shadow-2xl relative">
                    <button @click="openCheckoutModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
                    
                    <h3 class="font-heading font-bold text-xl text-brand-dark mb-6">Detail Pengiriman</h3>
                    
                    <form @submit.prevent="submitCheckout">
                        <div class="mb-5">
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-brand-accent mb-2">Alamat Lengkap Pengiriman</label>
                            <textarea x-model="shippingAddress" class="w-full bg-brand-cream border border-brand-beige rounded-2xl p-4 text-xs outline-none focus:border-brand-terracotta h-24" placeholder="Jl. Raya Perjuangan No. 45, Kebon Jeruk, Jakarta Barat" required></textarea>
                        </div>
                        <div class="mb-6">
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-brand-accent mb-2">Catatan Tambahan (Opsional)</label>
                            <input type="text" x-model="orderNotes" class="w-full bg-brand-cream border border-brand-beige rounded-2xl p-3.5 text-xs outline-none focus:border-brand-terracotta" placeholder="Misal: Warna merah, bungkus rapi">
                        </div>
                        
                        <button type="submit" 
                                :disabled="checkoutLoading"
                                class="w-full btn-gradient text-white py-4 rounded-2xl font-bold text-sm hover:shadow-lg transition-all flex items-center justify-center gap-2">
                            <span x-show="checkoutLoading" class="animate-spin border-2 border-white border-t-transparent w-4 h-4 rounded-full"></span>
                            <span x-text="checkoutLoading ? 'Memproses Pesanan...' : 'Konfirmasi & Buat Pesanan'"></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- ── TAB: ORDERS ── -->
        <div x-show="activeTab === 'orders'" class="bg-white rounded-3xl border border-brand-beige shadow-xl p-6 md:p-8 relative" style="display: none;">
            <!-- Dashed inner border -->
            <div class="absolute inset-1 border border-dashed border-brand-beige/40 rounded-2xl pointer-events-none"></div>

            <h2 class="relative z-10 font-heading font-bold text-xl md:text-2xl text-brand-dark mb-8 border-b border-brand-beige/50 pb-4 flex items-center gap-2">
                <span>Riwayat Pesanan Kriya Anda</span>
            </h2>

            <div x-show="orders.length > 0" class="relative z-10 flex flex-col gap-6">
                <template x-for="order in orders" :key="order.id">
                    <div class="border border-brand-beige/80 rounded-2xl p-5 md:p-6 bg-brand-cream/10 hover:shadow-lg transition-all duration-300 relative artisan-card">
                        <!-- Head info -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 border-b border-dashed border-brand-beige pb-4 mb-4 text-xs">
                            <div>
                                <span class="text-[9px] text-gray-400 font-bold uppercase tracking-wider block">ID Pesanan</span>
                                <div class="font-extrabold text-brand-dark mt-0.5" x-text="'#CRF-' + order.id">ID</div>
                            </div>
                            <div>
                                <span class="text-[9px] text-gray-400 font-bold uppercase tracking-wider block">Tanggal</span>
                                <div class="font-extrabold text-brand-dark mt-0.5" x-text="new Date(order.created_at).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'})">Tanggal</div>
                            </div>
                            <div>
                                <span class="text-[9px] text-gray-400 font-bold uppercase tracking-wider block">Total Transaksi</span>
                                <div class="font-extrabold text-brand-terracotta text-sm mt-0.5" x-text="'Rp ' + Number(order.total_amount).toLocaleString('id-ID')">Total</div>
                            </div>
                            <div>
                                <span class="text-[9px] text-gray-400 font-bold uppercase tracking-wider block">Status Pengiriman</span>
                                <div class="mt-1">
                                    <span class="text-[9px] uppercase font-extrabold px-3 py-1 rounded-full border shadow-sm select-none"
                                          :class="{
                                              'bg-amber-50 text-amber-700 border-amber-200': order.status === 'pending',
                                              'bg-blue-50 text-blue-700 border-blue-200': order.status === 'paid',
                                              'bg-indigo-50 text-indigo-700 border-indigo-200': order.status === 'shipped',
                                              'bg-green-50 text-green-700 border-green-200': order.status === 'delivered',
                                              'bg-red-50 text-red-700 border-red-200': order.status === 'cancelled'
                                          }"
                                          x-text="order.status === 'pending' ? 'Belum Bayar' : (order.status === 'paid' ? 'Diproses Penjual' : (order.status === 'shipped' ? 'Dalam Pengiriman' : (order.status === 'delivered' ? 'Selesai' : 'Dibatalkan')))">Pending</span>
                                </div>
                            </div>
                        </div>

                        <!-- Address Info if available -->
                        <div class="text-[11px] text-gray-500 mb-4 bg-brand-cream/35 p-3 rounded-xl border border-brand-beige/30 flex items-start gap-1.5">
                            <svg class="w-3.5 h-3.5 text-brand-clay mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <div>
                                <span class="font-extrabold text-brand-dark">Alamat Pengiriman: </span>
                                <span x-text="order.shipping_address">Alamat</span>
                                <template x-if="order.notes">
                                    <span class="block mt-1 font-medium text-gray-400 italic" x-text="'Catatan: ' + order.notes">Catatan</span>
                                </template>
                            </div>
                        </div>

                        <!-- Items list inside order -->
                        <div class="space-y-3">
                            <span class="text-[9px] text-gray-400 font-bold uppercase tracking-wider block">Detail Barang</span>
                            <template x-for="item in order.items" :key="item.id">
                                <div class="flex justify-between items-center text-xs bg-white p-3.5 rounded-xl border border-brand-beige/40">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-brand-cream border border-brand-beige overflow-hidden flex items-center justify-center flex-shrink-0">
                                            <template x-if="item.product?.image_url">
                                                <img :src="item.product.image_url" class="w-full h-full object-cover" :alt="item.product.name">
                                            </template>
                                            <template x-if="!item.product?.image_url">
                                                <span class="text-[8px] font-bold text-brand-dark/40">Craft</span>
                                            </template>
                                        </div>
                                        <div>
                                            <div class="font-extrabold text-brand-dark" x-text="item.product?.name || 'Kriya Masterpiece'">Produk</div>
                                            <div class="text-[10px] text-brand-accent font-semibold flex items-center gap-1 mt-0.5">
                                                <span x-text="item.product?.shop?.name || 'Sanggar Perajin'">Toko</span>
                                                <span class="text-gray-400 font-normal">&bull;</span>
                                                <span class="text-gray-400 font-normal" x-text="item.qty + ' barang'">x1</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="font-extrabold text-brand-dark" x-text="'Rp ' + Number(item.price).toLocaleString('id-ID')">Harga</span>
                                        <template x-if="order.status === 'delivered'">
                                            <button @click="openReviewModal(order.id, item.product_id, item.product?.name)" class="bg-brand-gold text-brand-dark border border-brand-gold hover:bg-brand-gold/80 px-2.5 py-1 rounded-lg text-[10px] font-extrabold transition-all">Beri Ulasan</button>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Payment Section -->
                        <div class="mt-4 pt-4 border-t border-dashed border-brand-beige">
                            <!-- No payment yet or rejected -->
                            <template x-if="!order.payment || order.payment.status === 'rejected'">
                                <div class="bg-brand-cream/50 p-4 rounded-xl border border-brand-beige/50 text-xs text-brand-dark">
                                    <div class="font-extrabold text-[10px] uppercase tracking-wider text-brand-accent mb-2">Instruksi Pembayaran Transfer Bank</div>
                                    <p class="mb-3 text-[11px] text-gray-500">Silakan transfer sebesar <span class="text-brand-terracotta font-extrabold" x-text="'Rp ' + Number(order.total_amount).toLocaleString('id-ID')"></span> ke salah satu rekening berikut:</p>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4 font-extrabold text-[10px] text-brand-dark">
                                        <div class="bg-white p-2.5 rounded-lg border border-brand-beige">
                                            <span class="text-gray-400 block uppercase">BCA Transfer</span>
                                            <span>8910-2345-6789 &bull; Craftive Nusantara</span>
                                        </div>
                                        <div class="bg-white p-2.5 rounded-lg border border-brand-beige">
                                            <span class="text-gray-400 block uppercase">Mandiri Transfer</span>
                                            <span>137-00-1234-5678 &bull; Craftive Nusantara</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Rejection Banner if rejected -->
                                    <template x-if="order.payment && order.payment.status === 'rejected'">
                                        <div class="bg-red-50 text-red-700 p-2.5 rounded-xl border border-red-200 mb-4 font-extrabold text-[10px]">
                                            ⚠️ Bukti Transfer Sebelumnya Ditolak. Silakan unggah bukti transfer yang valid.
                                        </div>
                                    </template>

                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-t border-brand-beige/30 pt-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded bg-white border border-brand-beige overflow-hidden flex items-center justify-center flex-shrink-0">
                                                <template x-if="uploadingProofs[order.id]">
                                                    <img :src="uploadingProofs[order.id]" class="w-full h-full object-cover" alt="Preview">
                                                </template>
                                                <template x-if="!uploadingProofs[order.id]">
                                                    <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                </template>
                                            </div>
                                            <div>
                                                <label class="block text-[9px] font-extrabold uppercase text-gray-400">Unggah Bukti Transfer</label>
                                                <input type="file" @change="e => handleProofUpload(e, order.id)" accept="image/*" class="text-[10px] text-brand-clay file:mr-2 file:py-1 file:px-2.5 file:rounded file:border-0 file:text-[9px] file:font-bold file:bg-brand-cream file:text-brand-dark hover:file:bg-brand-beige transition-all">
                                            </div>
                                        </div>
                                        <button @click="submitPaymentProof(order.id, order.total_amount)" 
                                                :disabled="paymentLoading[order.id] || !uploadingProofs[order.id]"
                                                class="bg-brand-dark hover:bg-brand-terracotta text-white py-2 px-5 rounded-xl text-xs font-bold transition-all disabled:opacity-30">
                                            <span x-text="paymentLoading[order.id] ? 'Mengirim...' : 'Kirim Bukti'"></span>
                                        </button>
                                    </div>
                                </div>
                            </template>

                            <!-- Payment uploaded and not rejected -->
                            <template x-if="order.payment && order.payment.status !== 'rejected'">
                                <div class="bg-brand-cream/40 p-4 rounded-xl border border-brand-beige/50 text-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded border border-brand-beige overflow-hidden bg-white flex items-center justify-center flex-shrink-0">
                                            <img :src="order.payment.proof_image" class="w-full h-full object-cover" alt="Bukti Transfer">
                                        </div>
                                        <div>
                                            <div class="font-extrabold text-brand-dark">Bukti Transfer Telah Diunggah</div>
                                            <div class="text-[10px] text-gray-400 font-semibold mt-0.5">Jumlah Transfer: <span class="text-brand-terracotta font-extrabold" x-text="'Rp ' + Number(order.payment.amount).toLocaleString('id-ID')"></span></div>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="text-[9px] uppercase font-extrabold px-3 py-1 rounded-full border shadow-sm select-none"
                                              :class="{
                                                  'bg-amber-50 text-amber-700 border-amber-200': order.payment.status === 'pending',
                                                  'bg-emerald-50 text-emerald-700 border-emerald-200': order.payment.status === 'confirmed'
                                              }"
                                              x-text="order.payment.status === 'pending' ? 'Menunggu Konfirmasi Admin' : 'Pembayaran Lunas / Lunas'">Pending</span>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Empty orders state -->
            <div x-show="orders.length === 0" class="text-center py-20 relative z-10 flex flex-col items-center justify-center">
                <div class="w-28 h-28 rounded-full bg-brand-cream border border-dashed border-brand-beige flex items-center justify-center mb-6 relative shadow-inner">
                    <svg class="w-12 h-12 text-brand-clay/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="absolute top-2 right-2 text-brand-gold animate-bounce">✦</span>
                </div>
                <h3 class="font-heading font-extrabold text-xl text-brand-dark">Belum Ada Pesanan</h3>
                <p class="text-xs text-gray-500 max-w-sm mt-2">Anda belum melakukan pemesanan mahakarya kriya apa pun di platform Craftive.</p>
                <a href="{{ url('/products') }}" class="inline-block btn-gradient text-white px-8 py-3.5 rounded-xl font-bold text-xs mt-6 hover:shadow-lg hover:scale-[1.02] transition-all">
                    Mulai Belanja Karya Seni
                </a>
            </div>
        </div>

        <!-- ── TAB: PROFILE ── -->
        <div x-show="activeTab === 'profile'" class="bg-white rounded-3xl border border-brand-beige shadow-xl p-6 md:p-8 relative" style="display: none;">
            <!-- Dashed inner border -->
            <div class="absolute inset-1 border border-dashed border-brand-beige/40 rounded-2xl pointer-events-none"></div>

            <h2 class="relative z-10 font-heading font-bold text-xl md:text-2xl text-brand-dark mb-8 border-b border-brand-beige/50 pb-4">
                <span>Profil Anggota Kolektor</span>
            </h2>

            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left: Collector Card Monogram -->
                <div class="lg:col-span-1 bg-gradient-to-b from-brand-cream via-[#FFFDFC] to-brand-cream/40 border border-brand-beige rounded-2xl p-6 flex flex-col items-center text-center relative overflow-hidden artisan-card">
                    <!-- Subtle seal in background -->
                    <div class="absolute -right-6 -top-6 w-24 h-24 border-4 border-dashed border-brand-terracotta/10 rounded-full flex items-center justify-center pointer-events-none">
                        <div class="w-16 h-16 border-2 border-dashed border-brand-terracotta/10 rounded-full"></div>
                    </div>

                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-brand-accent to-brand-terracotta border-4 border-brand-beige/60 flex items-center justify-center shadow-lg relative mb-4 overflow-hidden">
                        <template x-if="profile.avatar">
                            <img :src="profile.avatar" class="w-full h-full object-cover" alt="Avatar">
                        </template>
                        <template x-if="!profile.avatar">
                            <span class="font-heading font-extrabold text-4xl text-white select-none" x-text="profile.name ? profile.name.charAt(0).toUpperCase() : 'B'">B</span>
                        </template>
                        <div class="absolute -bottom-1 -right-1 bg-brand-gold text-brand-dark text-[9px] font-extrabold px-2.5 py-0.5 rounded-full border border-brand-beige shadow">PREMIUM</div>
                    </div>

                    <h3 class="font-heading font-bold text-lg text-brand-dark" x-text="profile.name || 'Siti Rahayu'">Siti Rahayu</h3>
                    <p class="text-xs text-brand-clay font-semibold mt-1" x-text="profile.email">email@craftive.id</p>
                    
                    <div class="w-full border-t border-dashed border-brand-beige/80 my-4 pt-4 text-xs text-left space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Status Akun:</span>
                            <span class="text-green-600 font-extrabold">Terverifikasi</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Bergabung Sejak:</span>
                            <span class="text-brand-dark font-extrabold">Juni 2026</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Total Transaksi:</span>
                            <span class="text-brand-terracotta font-extrabold" x-text="orders.length + ' Pesanan'">0 Pesanan</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Profile Fields -->
                <div class="lg:col-span-2 space-y-6 font-semibold">
                    <div x-show="!isEditingProfile" class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
                        <div class="group">
                            <label class="block text-[10px] text-brand-accent uppercase tracking-wider mb-2 font-bold flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-brand-clay" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                <span>Nama Lengkap</span>
                            </label>
                            <div class="bg-brand-cream/60 border border-brand-beige p-4 rounded-xl text-brand-dark font-extrabold shadow-sm transition-all group-hover:border-brand-accent" x-text="profile.name">Nama</div>
                        </div>

                        <div class="group">
                            <label class="block text-[10px] text-brand-accent uppercase tracking-wider mb-2 font-bold flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-brand-clay" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <span>Email</span>
                            </label>
                            <div class="bg-brand-cream/60 border border-brand-beige p-4 rounded-xl text-brand-dark font-extrabold shadow-sm transition-all group-hover:border-brand-accent" x-text="profile.email">Email</div>
                        </div>

                        <div class="group">
                            <label class="block text-[10px] text-brand-accent uppercase tracking-wider mb-2 font-bold flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-brand-clay" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                <span>Nomor Telepon</span>
                            </label>
                            <div class="bg-brand-cream/60 border border-brand-beige p-4 rounded-xl text-brand-dark font-extrabold shadow-sm transition-all group-hover:border-brand-accent" x-text="profile.phone || 'Belum diisi'">Telepon</div>
                        </div>

                        <div class="group">
                            <label class="block text-[10px] text-brand-accent uppercase tracking-wider mb-2 font-bold flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-brand-clay" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>Alamat Profil Utama</span>
                            </label>
                            <div class="bg-brand-cream/60 border border-brand-beige p-4 rounded-xl text-brand-dark font-extrabold shadow-sm transition-all group-hover:border-brand-accent" x-text="profile.address || 'Belum diisi'">Alamat</div>
                        </div>
                    </div>

                    <div x-show="!isEditingProfile" class="flex justify-end pt-4">
                        <button @click="startEditProfile" class="bg-gradient-to-r from-brand-terracotta-light to-brand-terracotta text-white py-3 px-6 rounded-xl font-bold text-xs hover:shadow-lg transition-all flex items-center gap-1.5 shadow-brand-terracotta/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00-2 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Edit Profil
                        </button>
                    </div>

                    <!-- Editing Form -->
                    <form x-show="isEditingProfile" @submit.prevent="saveProfile" class="space-y-6 text-xs" style="display: none;">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
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
                                <label class="block text-[10px] text-brand-accent uppercase tracking-wider mb-2 font-bold">Alamat Profil Utama</label>
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

        <!-- ── TAB: PLANNER ── -->
        <div x-show="activeTab === 'planner'" class="space-y-6" style="display: none;">
            <div class="bg-white rounded-3xl border border-brand-beige shadow-xl p-6 md:p-8 relative">
                <!-- Dashed inner border -->
                <div class="absolute inset-1 border border-dashed border-brand-beige/40 rounded-2xl pointer-events-none"></div>

                <div class="relative z-10 flex items-center justify-between mb-8 border-b border-brand-beige/50 pb-4">
                    <div>
                        <h2 class="font-heading font-bold text-xl md:text-2xl text-brand-dark flex items-center gap-2">
                            <span>Kriya Custom Planner</span>
                            <span class="text-xs bg-brand-terracotta text-white font-extrabold px-2.5 py-0.5 rounded-full">Agentic AI</span>
                        </h2>
                        <p class="text-xs text-gray-500 mt-1">Konsultasikan spesifikasi kerajinan kustom Anda. AI Agent kami akan menganalisis kelayakan, estimasi biaya, dan merekomendasikan perajin terbaik secara otomatis.</p>
                    </div>
                </div>

                <div class="relative z-10 grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left: Form -->
                    <div class="lg:col-span-1 border-r border-brand-beige/50 pr-0 lg:pr-6">
                        <form @submit.prevent="runAiPlanner" class="space-y-5">
                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-brand-accent mb-2">Spesifikasi Kriya Custom</label>
                                <textarea x-model="plannerInput.specifications" 
                                          class="w-full bg-brand-cream/45 border-2 border-brand-beige rounded-2xl p-4 text-xs outline-none focus:border-brand-terracotta focus:bg-white transition-all h-28" 
                                          placeholder="Contoh: Meja kopi kayu jati bulat diameter 60cm dengan ukiran motif mega mendung di tepinya" 
                                          required></textarea>
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-brand-accent mb-2">Bahan / Material Utama</label>
                                <input type="text" x-model="plannerInput.materials" 
                                       class="w-full bg-brand-cream/45 border-2 border-brand-beige rounded-2xl p-3.5 text-xs outline-none focus:border-brand-terracotta focus:bg-white transition-all" 
                                       placeholder="Contoh: Kayu Jati Tua, Pelitur Alami" 
                                       required>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-bold uppercase tracking-wider text-brand-accent mb-2">Anggaran (Rp)</label>
                                    <div class="relative">
                                        <span class="absolute left-3.5 top-3.5 text-xs text-gray-400 font-bold">Rp</span>
                                        <input type="number" x-model.number="plannerInput.budget" 
                                               class="w-full bg-brand-cream/45 border-2 border-brand-beige rounded-2xl pl-9 pr-3.5 py-3.5 text-xs outline-none focus:border-brand-terracotta focus:bg-white transition-all" 
                                               placeholder="250000" 
                                               required min="10000">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold uppercase tracking-wider text-brand-accent mb-2">Waktu (Hari)</label>
                                    <div class="relative">
                                        <input type="number" x-model.number="plannerInput.timeline" 
                                               class="w-full bg-brand-cream/45 border-2 border-brand-beige rounded-2xl pr-12 pl-3.5 py-3.5 text-xs outline-none focus:border-brand-terracotta focus:bg-white transition-all text-left" 
                                               placeholder="7" 
                                               required min="1">
                                        <span class="absolute right-3.5 top-3.5 text-[10px] text-gray-400 font-bold uppercase">Hari</span>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" 
                                    :disabled="plannerLoading" 
                                    class="w-full btn-gradient text-white py-4 rounded-2xl font-bold text-sm hover:shadow-lg hover:scale-[1.02] transition-all flex items-center justify-center gap-2">
                                <span x-show="plannerLoading" class="animate-spin border-2 border-white border-t-transparent w-4 h-4 rounded-full"></span>
                                <span x-text="plannerLoading ? 'Menganalisis Proyek...' : 'Mulai Analisis AI'"></span>
                            </button>
                        </form>
                    </div>

                    <!-- Right: Results -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Initial State -->
                        <div x-show="!plannerResult" class="flex flex-col items-center justify-center py-20 text-center text-gray-400">
                            <div class="w-24 h-24 rounded-full bg-brand-cream border border-dashed border-brand-beige flex items-center justify-center mb-6 relative shadow-inner">
                                <svg class="w-10 h-10 text-brand-clay/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                </svg>
                                <span class="absolute top-2 right-2 text-brand-gold animate-bounce">✦</span>
                            </div>
                            <h4 class="font-heading font-extrabold text-lg text-brand-dark">Asisten Perencanaan Custom Kriya</h4>
                            <p class="text-xs max-w-sm mt-2">Silakan isi detail spesifikasi di panel kiri dan klik 'Mulai Analisis AI' untuk mendapatkan taksiran biaya pengerjaan, tingkat kesulitan, serta rekomendasi sanggar perajin lokal.</p>
                        </div>

                        <!-- Result Card -->
                        <div x-show="plannerResult" class="space-y-6 bg-brand-cream/40 border border-brand-beige p-6 rounded-3xl relative overflow-hidden" style="display: none;">
                            <div class="flex justify-between items-start border-b border-brand-beige/50 pb-4 flex-wrap gap-4">
                                <div>
                                    <span class="text-[9px] text-gray-400 font-bold uppercase tracking-wider block">Hasil Analisis Spesifikasi</span>
                                    <h4 class="font-bold text-sm md:text-base text-brand-dark" x-text="plannerResult?.specifications"></h4>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] uppercase font-extrabold px-3.5 py-1.5 rounded-full border border-brand-terracotta/20 bg-white text-brand-terracotta shadow-sm"
                                          x-text="'Tingkat Kesulitan: ' + (plannerResult?.difficulty || 'Sedang')"></span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="bg-white p-4 rounded-xl border border-brand-beige/50 shadow-sm">
                                    <span class="text-[9px] text-gray-400 font-bold uppercase tracking-wider">Estimasi Waktu</span>
                                    <div class="font-extrabold text-lg text-brand-dark mt-1 flex items-center gap-1">
                                        <svg class="w-4 h-4 text-brand-clay" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span x-text="(plannerResult?.estimated_days || 0) + ' Hari Kerja'">0 Hari</span>
                                    </div>
                                </div>
                                <div class="bg-white p-4 rounded-xl border border-brand-beige/50 shadow-sm">
                                    <span class="text-[9px] text-gray-400 font-bold uppercase tracking-wider">Estimasi Bahan Baku</span>
                                    <div class="font-extrabold text-lg text-brand-terracotta mt-1" x-text="'Rp ' + Number(plannerResult?.material_cost || 0).toLocaleString('id-ID')">Rp 0</div>
                                </div>
                                <div class="bg-white p-4 rounded-xl border border-brand-beige/50 shadow-sm">
                                    <span class="text-[9px] text-gray-400 font-bold uppercase tracking-wider">Estimasi Jasa Perajin</span>
                                    <div class="font-extrabold text-lg text-brand-dark mt-1" x-text="'Rp ' + Number(plannerResult?.labor_cost || 0).toLocaleString('id-ID')">Rp 0</div>
                                </div>
                            </div>

                            <div class="bg-white p-5 rounded-2xl border border-brand-beige/50 shadow-sm">
                                <div class="flex items-center gap-1.5 text-xs font-bold text-brand-accent mb-2">
                                    <svg class="w-4 h-4 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    <span>Rekomendasi Sanggar Perajin</span>
                                </div>
                                <div class="font-extrabold text-sm text-brand-dark" x-text="plannerResult?.shop_recommendation">Nama Toko</div>
                                <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                                    <span>Status: </span>
                                    <span class="text-green-600 font-bold">Terverifikasi (Verified Seller)</span>
                                </p>
                            </div>

                            <div class="bg-white p-5 rounded-2xl border border-brand-beige/50 shadow-sm space-y-2">
                                <div class="flex items-center gap-1.5 text-xs font-bold text-brand-accent">
                                    <svg class="w-4 h-4 text-brand-terracotta" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 113.536 0V21h2v-2.757a5.02 5.02 0 010-3.536z"/></svg>
                                    <span>Ulasan Penalaran AI Agent</span>
                                </div>
                                <p class="text-xs text-brand-dark leading-relaxed italic bg-brand-cream/35 p-4 rounded-xl border border-brand-beige/30" x-text="plannerResult?.agent_reasoning"></p>
                            </div>

                            <div class="flex justify-end pt-2">
                                <button @click="submitCustomProposal" class="btn-gradient text-white px-8 py-3.5 rounded-xl font-bold text-xs hover:shadow-lg hover:scale-[1.02] transition-all flex items-center gap-2">
                                    <span>Ajukan Pesanan Custom ke Perajin</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sub-bagian: Histori Proposal Custom -->
                <div class="relative z-10 mt-12 border-t border-brand-beige/60 pt-10">
                    <h3 class="font-heading font-bold text-lg text-brand-dark mb-6 flex items-center gap-2">
                        <span>Histori Pengajuan Proposal Kriya Custom</span>
                        <span class="text-xs bg-brand-dark text-white font-extrabold px-2.5 py-0.5 rounded-full" x-text="customProposals.length">0</span>
                    </h3>

                    <div x-show="customProposals.length > 0" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <template x-for="prop in customProposals" :key="prop.id">
                            <div class="bg-[#FCFAF7] border border-brand-beige rounded-2xl p-5 hover:shadow-md transition-shadow relative overflow-hidden flex flex-col justify-between">
                                <div>
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <span class="text-[9px] text-gray-400 font-bold uppercase tracking-wider block" x-text="'Proposal #' + prop.id"></span>
                                            <h4 class="font-bold text-brand-dark text-sm" x-text="prop.craft_type">Nama Kriya</h4>
                                        </div>
                                        <div>
                                            <span class="text-[9px] uppercase font-extrabold px-2.5 py-1 rounded-full border shadow-sm"
                                                  :class="{
                                                      'bg-amber-50 text-amber-700 border-amber-200': prop.status === 'pending',
                                                      'bg-emerald-50 text-emerald-700 border-emerald-200': prop.status === 'accepted',
                                                      'bg-red-50 text-red-700 border-red-200': prop.status === 'rejected',
                                                      'bg-blue-50 text-blue-700 border-blue-200': prop.status === 'ordered'
                                                  }"
                                                  x-text="prop.status === 'pending' ? 'Menunggu' : (prop.status === 'accepted' ? 'Disetujui' : (prop.status === 'rejected' ? 'Ditolak' : prop.status))"></span>
                                        </div>
                                    </div>
                                    <p class="text-[11px] text-gray-500 line-clamp-2 mb-3" x-text="prop.description"></p>
                                    <div class="grid grid-cols-3 gap-2 bg-brand-cream/35 p-3 rounded-xl border border-brand-beige/35 text-[10px] font-semibold text-brand-dark mb-4">
                                        <div>
                                            <span class="text-[8px] text-gray-400 font-bold uppercase block">Bahan</span>
                                            <span class="truncate block" x-text="prop.material"></span>
                                        </div>
                                        <div>
                                            <span class="text-[8px] text-gray-400 font-bold uppercase block">Budget</span>
                                            <span class="text-brand-terracotta font-extrabold" x-text="'Rp ' + Number(prop.budget).toLocaleString('id-ID')"></span>
                                        </div>
                                        <div>
                                            <span class="text-[8px] text-gray-400 font-bold uppercase block">Toko</span>
                                            <span class="truncate block" x-text="prop.shop_recommendation"></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="border-t border-brand-beige/50 pt-3 flex justify-between items-center mt-auto">
                                    <span class="text-[9px] text-gray-400 font-semibold" x-text="'Taksiran AI: ' + prop.estimated_days + ' hari (' + prop.difficulty + ')'"></span>
                                    <div class="flex gap-2">
                                        <template x-if="prop.status === 'accepted' && prop.order_id">
                                            <button @click="setTab('orders')" class="bg-brand-terracotta text-white px-3 py-1.5 rounded-lg text-[10px] font-bold hover:shadow transition-all">Bayar Pesanan</button>
                                        </template>
                                        <button @click="deleteProposal(prop.id)" class="text-red-500 hover:text-red-700 font-bold text-[10px] uppercase bg-red-50 px-2.5 py-1 rounded-lg border border-red-100">Hapus</button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div x-show="customProposals.length === 0" class="text-center py-10 text-gray-400 bg-brand-cream/10 border border-dashed border-brand-beige rounded-2xl">
                        <p class="text-xs">Belum ada histori pengajuan proposal kriya custom.</p>
                    </div>
                </div>
            </div>
        </div>

            <!-- Review Modal -->
            <div x-show="openReviewModalState" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4" style="display: none;">
                <div class="bg-white rounded-3xl border border-brand-beige max-w-md w-full p-8 shadow-2xl relative">
                    <button @click="openReviewModalState = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
                    
                    <h3 class="font-heading font-bold text-xl text-brand-dark mb-2">Beri Ulasan Karya</h3>
                    <p class="text-[11px] text-gray-500 mb-6" x-text="'Produk: ' + reviewProductName">Nama Produk</p>
                    
                    <form @submit.prevent="submitReview">
                        <div class="mb-5">
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-brand-accent mb-2">Penilaian Bintang</label>
                            <div class="flex gap-2 text-2xl">
                                <template x-for="star in [1,2,3,4,5]">
                                    <button type="button" @click="reviewRating = star" class="hover:scale-110 transition-transform focus:outline-none" :class="reviewRating >= star ? 'text-brand-gold' : 'text-gray-300'">★</button>
                                </template>
                            </div>
                        </div>
                        <div class="mb-6">
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-brand-accent mb-2">Komentar & Ulasan Anda</label>
                            <textarea x-model="reviewComment" class="w-full bg-brand-cream border border-brand-beige rounded-2xl p-4 text-xs outline-none focus:border-brand-terracotta h-24" placeholder="Bagikan pengalaman Anda tentang keindahan, teknik pengerjaan, atau detail karya kriya ini..." required></textarea>
                        </div>
                        
                        <button type="submit" 
                                :disabled="reviewLoading"
                                class="w-full btn-gradient text-white py-4 rounded-2xl font-bold text-sm hover:shadow-lg transition-all flex items-center justify-center gap-2">
                            <span x-show="reviewLoading" class="animate-spin border-2 border-white border-t-transparent w-4 h-4 rounded-full"></span>
                            <span x-text="reviewLoading ? 'Mengirim Ulasan...' : 'Kirim Ulasan Resmi'"></span>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('buyerDashboard', () => ({
            activeTab: 'cart',
            cartItems: [],
            totalCartPrice: 0,
            orders: [],
            profile: {},
            openCheckoutModal: false,
            shippingAddress: '',
            orderNotes: '',
            checkoutLoading: false,
            uploadingProofs: {},
            paymentLoading: {},

            // Edit Profile States
            isEditingProfile: false,
            editName: '',
            editEmail: '',
            editPhone: '',
            editAddress: '',
            editAvatar: '',
            profileSaving: false,

            startEditProfile() {
                this.editName = this.profile.name || '';
                this.editEmail = this.profile.email || '';
                this.editPhone = this.profile.phone || '';
                this.editAddress = this.profile.address || '';
                this.editAvatar = this.profile.avatar || '';
                this.isEditingProfile = true;
            },

            handleAvatarUpload(e) {
                const file = e.target.files[0];
                if (!file) return;
                if (file.size > 2 * 1024 * 1024) {
                    window.addToast('error', 'Ukuran berkas gambar maksimal 2MB.');
                    return;
                }
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
                    this.profile = data.user;
                    this.shippingAddress = data.user.address || '';
                    
                    // Dispatch event to layout header/avatar
                    window.dispatchEvent(new CustomEvent('auth-changed'));
                    
                    window.addToast('success', 'Profil Anda berhasil diperbarui.');
                    this.isEditingProfile = false;
                } catch (error) {
                    window.addToast('error', error.message || 'Gagal memperbarui profil.');
                } finally {
                    this.profileSaving = false;
                }
            },

            // AI Planner States
            plannerInput: {
                specifications: '',
                materials: '',
                budget: 150000,
                timeline: 7
            },
            plannerLoading: false,
            plannerResult: null,
            customProposals: [],
            openReviewModalState: false,
            reviewOrderId: null,
            reviewProductId: null,
            reviewProductName: '',
            reviewRating: 5,
            reviewComment: '',
            reviewLoading: false,

            get groupedCartItems() {
                const groups = {};
                this.cartItems.forEach(item => {
                    const shopName = (item.product && item.product.shop) ? item.product.shop.name : 'Perajin Lokal';
                    if (!groups[shopName]) {
                        groups[shopName] = [];
                    }
                    groups[shopName].push(item);
                });
                return Object.keys(groups).map(name => ({
                    shopName: name,
                    items: groups[name]
                }));
            },

            init() {
                // Read anchor hash from URL (e.g. #cart or #orders)
                const hash = window.location.hash.substring(1);
                if (hash === 'orders' || hash === 'profile' || hash === 'cart' || hash === 'planner') {
                    this.activeTab = hash;
                }

                // Check profile & auth redirect
                const user = JSON.parse(localStorage.getItem('user'));
                if (!user || user.role !== 'buyer') {
                    window.location.href = '{{ route("login") }}';
                    return;
                }
                this.profile = user;
                this.shippingAddress = user.address || '';

                this.loadCart();
                this.loadOrders();
                this.loadCustomProposals();
            },

            setTab(tab) {
                this.activeTab = tab;
                window.location.hash = tab;
            },

            async loadCart() {
                try {
                    const data = await window.apiFetch('/api/cart');
                    if (data && Array.isArray(data)) {
                        this.cartItems = data;
                        this.totalCartPrice = data.reduce((sum, item) => sum + (item.qty * item.product.price), 0);
                    }
                } catch (error) {
                    console.error('Gagal mengambil keranjang:', error);
                }
            },

            async loadOrders() {
                try {
                    const data = await window.apiFetch('/api/orders');
                    if (data && Array.isArray(data)) {
                        this.orders = data.reverse(); // Newest first
                    }
                } catch (error) {
                    console.error('Gagal mengambil riwayat pesanan:', error);
                }
            },

            async updateCartQty(itemId, newQty) {
                if (newQty < 1) return;
                try {
                    await window.apiFetch(`/api/cart/${itemId}`, {
                        method: 'PUT',
                        body: JSON.stringify({ qty: newQty })
                    });
                    this.loadCart();
                    window.dispatchEvent(new CustomEvent('cart-updated'));
                } catch (error) {
                    window.addToast('error', 'Gagal memperbarui jumlah produk.');
                }
            },

            async deleteCartItem(itemId) {
                try {
                    await window.apiFetch(`/api/cart/${itemId}`, { method: 'DELETE' });
                    window.addToast('success', 'Produk dihapus dari keranjang.');
                    this.loadCart();
                    window.dispatchEvent(new CustomEvent('cart-updated'));
                } catch (error) {
                    window.addToast('error', 'Gagal menghapus produk.');
                }
            },

            handleProofUpload(e, orderId) {
                const file = e.target.files[0];
                if (!file) return;
                if (file.size > 2 * 1024 * 1024) {
                    window.addToast('error', 'Ukuran berkas gambar bukti transfer maksimal 2MB.');
                    return;
                }
                const reader = new FileReader();
                reader.onload = (event) => {
                    this.uploadingProofs[orderId] = event.target.result;
                };
                reader.readAsDataURL(file);
            },

            async submitPaymentProof(orderId, amount) {
                const proof = this.uploadingProofs[orderId];
                if (!proof) {
                    window.addToast('error', 'Silakan pilih file gambar bukti transfer terlebih dahulu.');
                    return;
                }
                this.paymentLoading[orderId] = true;
                try {
                    await window.apiFetch('/api/payments', {
                        method: 'POST',
                        body: JSON.stringify({
                            order_id: orderId,
                            amount: amount,
                            proof_image: proof
                        })
                    });
                    window.addToast('success', 'Bukti transfer berhasil dikirim. Menunggu verifikasi admin.');
                    delete this.uploadingProofs[orderId];
                    this.loadOrders();
                } catch (error) {
                    window.addToast('error', error.message || 'Gagal mengirim bukti pembayaran.');
                } finally {
                    this.paymentLoading[orderId] = false;
                }
            },

            async submitCheckout() {
                this.checkoutLoading = true;
                try {
                    const order = await window.apiFetch('/api/orders', {
                        method: 'POST',
                        body: JSON.stringify({
                            shipping_address: this.shippingAddress,
                            notes: this.orderNotes
                        })
                    });

                    window.addToast('success', 'Checkout berhasil! Pesanan Anda telah dibuat.');
                    this.openCheckoutModal = false;
                    this.shippingAddress = '';
                    this.orderNotes = '';
                    
                    // Reload data
                    this.loadCart();
                    this.loadOrders();
                    
                    // Reset nav bag count
                    window.dispatchEvent(new CustomEvent('cart-updated'));
                    
                    // Direct user to orders history tab
                    this.setTab('orders');

                } catch (error) {
                    window.addToast('error', error.message || 'Gagal memproses checkout.');
                } finally {
                    this.checkoutLoading = false;
                }
            },

            async runAiPlanner() {
                this.plannerLoading = true;
                this.plannerResult = null;
                try {
                    const data = await window.apiFetch('/api/ai/custom-planner', {
                        method: 'POST',
                        body: JSON.stringify(this.plannerInput)
                    });
                    if (data && data.planning) {
                        this.plannerResult = data.planning;
                        window.addToast('success', 'Analisis AI selesai diproses!');
                    } else {
                        throw new Error('Gagal mendapatkan hasil perencanaan.');
                    }
                } catch (error) {
                    window.addToast('error', error.message || 'Terjadi kesalahan saat memproses perencanaan AI.');
                } finally {
                    this.plannerLoading = false;
                }
            },

            async submitCustomProposal() {
                if (!this.plannerResult) return;
                try {
                    await window.apiFetch('/api/custom-proposals', {
                        method: 'POST',
                        body: JSON.stringify({
                            craft_type: this.plannerResult.specifications,
                            material: this.plannerResult.materials,
                            budget: this.plannerResult.budget,
                            deadline_days: this.plannerResult.timeline_requested,
                            description: this.plannerResult.specifications,
                            difficulty: this.plannerResult.difficulty,
                            estimated_days: this.plannerResult.estimated_days,
                            material_cost: this.plannerResult.material_cost,
                            labor_cost: this.plannerResult.labor_cost,
                            shop_recommendation: this.plannerResult.shop_recommendation,
                            agent_reasoning: this.plannerResult.agent_reasoning
                        })
                    });

                    window.addToast('success', 'Proposal kriya custom berhasil diajukan ke perajin!');
                    this.plannerInput.specifications = '';
                    this.plannerInput.materials = '';
                    this.plannerInput.budget = 150000;
                    this.plannerInput.timeline = 7;
                    this.plannerResult = null;
                    
                    this.loadCustomProposals();
                } catch (error) {
                    window.addToast('error', error.message || 'Gagal mengajukan proposal.');
                }
            },

            async loadCustomProposals() {
                try {
                    const data = await window.apiFetch('/api/custom-proposals');
                    if (data && Array.isArray(data)) {
                        this.customProposals = data;
                    }
                } catch (error) {
                    console.error('Gagal mengambil proposal custom:', error);
                }
            },

            async deleteProposal(id) {
                if (!confirm('Apakah Anda yakin ingin menghapus proposal ini?')) return;
                try {
                    await window.apiFetch(`/api/custom-proposals/${id}`, { method: 'DELETE' });
                    window.addToast('success', 'Proposal berhasil dihapus.');
                    this.loadCustomProposals();
                } catch (error) {
                    window.addToast('error', 'Gagal menghapus proposal.');
                }
            },

            openReviewModal(orderId, productId, productName) {
                this.reviewOrderId = orderId;
                this.reviewProductId = productId;
                this.reviewProductName = productName;
                this.reviewRating = 5;
                this.reviewComment = '';
                this.openReviewModalState = true;
            },

            async submitReview() {
                this.reviewLoading = true;
                try {
                    await window.apiFetch('/api/reviews', {
                        method: 'POST',
                        body: JSON.stringify({
                            order_id: this.reviewOrderId,
                            product_id: this.reviewProductId,
                            rating: this.reviewRating,
                            comment: this.reviewComment
                        })
                    });
                    window.addToast('success', 'Ulasan Anda berhasil dikirim! Terima kasih.');
                    this.openReviewModalState = false;
                    this.loadOrders();
                } catch (error) {
                    window.addToast('error', error.message || 'Gagal mengirim ulasan.');
                } finally {
                    this.reviewLoading = false;
                }
            }
        }));
    });
</script>
@endsection
