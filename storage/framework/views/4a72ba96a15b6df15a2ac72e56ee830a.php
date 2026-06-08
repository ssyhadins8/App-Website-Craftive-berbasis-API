<?php $__env->startSection('content'); ?>
<div class="py-12 bg-transparent min-h-screen" x-data="productDetail">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Loading State -->
        <div x-show="loading" class="flex flex-col items-center justify-center py-32 gap-3">
            <span class="animate-spin border-4 border-brand-terracotta border-t-transparent w-8 h-8 rounded-full"></span>
            <span class="text-xs text-brand-accent font-bold">Menyelaraskan detail karya seni...</span>
        </div>

        <!-- Back Button -->
        <div x-show="!loading && product" class="mb-8" style="display: none;">
            <a href="<?php echo e(url('/products')); ?>" class="inline-flex items-center gap-2 text-xs font-bold text-brand-accent hover:text-brand-terracotta transition-colors">
                &larr; Kembali ke Katalog Produk
            </a>
        </div>

        <!-- Main Product Card: Editorial Split Layout -->
        <div x-show="!loading && product" class="bg-[#FCFAF7]/95 rounded-[2.5rem] border border-brand-beige shadow-xl p-6 sm:p-10 flex flex-col lg:flex-row gap-12 lg:gap-16 items-start" style="display: none;">
            
            <!-- Left Side: Product Image & Guarantee -->
            <div class="flex-1 w-full lg:max-w-lg">
                <!-- Framed Image Display -->
                <div class="relative bg-brand-cream border border-brand-beige/70 rounded-3xl overflow-hidden shadow-inner flex items-center justify-center min-h-[350px] sm:min-h-[450px]">
                    <template x-if="product.image_url">
                        <img :src="product.image_url" class="w-full h-full object-cover max-h-[500px] hover:scale-105 transition-transform duration-700" :alt="product.name">
                    </template>
                    <template x-if="!product.image_url">
                        <span class="text-xs uppercase tracking-widest text-brand-dark/40 font-bold">No Image</span>
                    </template>
                    
                    <span class="absolute bottom-4 right-4 bg-brand-dark/90 text-brand-gold text-[9px] font-extrabold px-3 py-1 rounded-full uppercase tracking-wider shadow-md">Otentik Nusantara</span>
                </div>

                <!-- Artisan Wax Seal Guarantee -->
                <div class="mt-6 p-5 bg-[#FAF4EA] rounded-2xl border border-brand-beige/80 flex items-start gap-4">
                    <div class="text-3xl select-none">✦</div>
                    <div>
                        <h4 class="font-heading font-bold text-xs text-brand-dark mb-1">Jaminan Autentisitas Craftive</h4>
                        <p class="text-[10px] text-brand-dark/70 leading-relaxed">
                            Karya ini sepenuhnya diproduksi secara manual oleh perajin lokal kami. Sedikit variasi dalam bentuk, warna, dan guratan merupakan ciri khas kriya buatan tangan dan bukan cacat produksi.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Side: Details & Interaction -->
            <div class="flex-1 w-full flex flex-col justify-between self-stretch">
                <div>
                    <!-- Category Badge & Origin location -->
                    <div class="flex items-center justify-between border-b border-brand-beige/50 pb-4">
                        <span class="bg-brand-terracotta/10 text-brand-terracotta text-[10px] font-extrabold px-3.5 py-1.5 rounded-full border border-brand-terracotta/25 uppercase tracking-wider" x-text="product.category?.name">Kategori</span>
                        <span class="text-[11px] text-gray-500 font-bold" x-text="product.shop?.address || 'Indonesia'">Lokasi</span>
                    </div>
                    
                    <!-- Product Title -->
                    <h1 class="font-heading font-extrabold text-3xl sm:text-4xl text-brand-dark mt-6" x-text="product.name">Nama Produk</h1>
                    
                    <!-- Shop Name -->
                    <p class="text-xs text-brand-accent font-bold mt-2 flex items-center gap-1.5">
                        <span>Kerajinan:</span> 
                        <span class="underline" x-text="product.shop?.name">Nama Toko</span>
                    </p>

                    <!-- Price -->
                    <div class="text-brand-terracotta font-extrabold text-3xl sm:text-4xl mt-6 font-heading" x-text="'Rp ' + Number(product.price).toLocaleString('id-ID')">Rp 0</div>
                    
                    <!-- Stock and Rating metadata -->
                    <div class="grid grid-cols-2 gap-4 border-t border-b border-brand-beige/50 my-6 py-4 text-xs font-semibold text-gray-500">
                        <div>Ketersediaan Karya: <span class="text-brand-dark font-extrabold" x-text="product.stock + ' unit'">0 unit</span></div>
                        <div class="flex items-center gap-1">Penilaian Kerajinan: <span class="text-brand-gold font-extrabold" x-text="'★ ' + (Number(product.rating_avg || 5.0).toFixed(1)) + ' / 5.0'">★ 5.0 / 5.0</span></div>
                    </div>

                    <!-- Description -->
                    <h3 class="text-[10px] font-extrabold uppercase tracking-wider text-brand-accent mb-2">Cerita di Balik Karya</h3>
                    <p class="text-xs text-gray-600 leading-relaxed mb-6" x-text="product.description">Deskripsi lengkap produk.</p>

                    <!-- Dynamic Handmade Technical Specs Grid -->
                    <h3 class="text-[10px] font-extrabold uppercase tracking-wider text-brand-accent mb-3">Spesifikasi Kriya Buatan Tangan</h3>
                    <div class="grid grid-cols-2 gap-3 mb-8 text-[11px] bg-brand-cream/30 p-4 rounded-2xl border border-brand-beige">
                        <div>
                            <span class="block text-gray-400 font-bold text-[9px] uppercase tracking-wider">Teknik Pembuatan</span>
                            <span class="font-bold text-brand-dark" x-text="getTechnicalSpecs().technique">Pahat</span>
                        </div>
                        <div>
                            <span class="block text-gray-400 font-bold text-[9px] uppercase tracking-wider">Bahan Utama</span>
                            <span class="font-bold text-brand-dark" x-text="getTechnicalSpecs().material">Bahan</span>
                        </div>
                        <div>
                            <span class="block text-gray-400 font-bold text-[9px] uppercase tracking-wider">Estimasi Waktu Pengerjaan</span>
                            <span class="font-bold text-brand-dark">~3-5 Hari Kerja</span>
                        </div>
                        <div>
                            <span class="block text-gray-400 font-bold text-[9px] uppercase tracking-wider">Tingkat Keunikan</span>
                            <span class="font-bold text-brand-gold">★★★★★ (Eksklusif)</span>
                        </div>
                    </div>
                </div>

                <!-- Add to Cart Widget -->
                <div class="mt-auto">
                    <div class="bg-brand-cream rounded-2xl p-4 border border-brand-beige flex items-center justify-between gap-4">
                        <div class="flex items-center border border-brand-beige rounded-xl bg-white shadow-sm">
                            <button @click="decreaseQty()" class="px-3.5 py-2.5 text-brand-terracotta font-bold hover:bg-brand-cream transition-colors rounded-l-xl select-none">-</button>
                            <span class="px-4 text-xs font-bold text-brand-dark" x-text="qty">1</span>
                            <button @click="increaseQty()" class="px-3.5 py-2.5 text-brand-terracotta font-bold hover:bg-brand-cream transition-colors rounded-r-xl select-none">+</button>
                        </div>
                        
                        <button @click="addToCart()" 
                                class="flex-grow btn-gradient text-white py-4 rounded-xl font-bold text-xs hover:shadow-lg transition-all flex items-center justify-center gap-2 uppercase tracking-wider">
                            Tambah ke Keranjang Belanja
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <!-- Artisan Bio Showcase Section -->
        <div x-show="!loading && product" class="bg-[#FCFAF7] rounded-3xl border border-brand-beige p-8 shadow-sm flex flex-col md:flex-row items-center gap-8" style="display: none;">
            <div class="w-20 h-20 rounded-full btn-gradient text-brand-cream flex items-center justify-center text-xs font-bold shadow-md select-none">KERAJINAN</div>
            <div class="flex-grow text-center md:text-left">
                <h3 class="font-heading font-bold text-xl text-brand-dark mb-2" x-text="'Mengenal Kerajinan ' + product.shop?.name">Mengenal Kerajinan</h3>
                <p class="text-xs text-gray-500 leading-relaxed mb-1" x-text="'Usaha kerajinan kriya ini berlokasi di ' + (product.shop?.address || 'Indonesia') + ' dan telah berkomitmen mendukung mata pencaharian perajin kriya setempat dengan mengutamakan material organik dan lokal.'">Deskripsi toko.</p>
                <div class="flex flex-wrap justify-center md:justify-start gap-4 mt-3 text-[10px] font-bold text-brand-accent uppercase tracking-wider">
                    <span>✓ Pengrajin Terverifikasi</span>
                    <span>✓ Pembayaran Adil (Fair Trade)</span>
                    <span>✓ Kemasan Ramah Lingkungan</span>
                </div>
            </div>
        </div>

        <!-- ── DYNAMIC REVIEWS SECTION ── -->
        <div x-show="!loading" class="mt-20 border-t border-brand-beige pt-16">
            <h3 class="font-heading font-extrabold text-2xl text-brand-dark mb-2">Ulasan Kolektor Seni</h3>
            <p class="text-xs text-gray-500 mb-8">Umpan balik otentik dari pembeli yang telah memiliki mahakarya kriya ini.</p>

            <div x-show="reviews.length > 0" class="space-y-6">
                <template x-for="r in reviews" :key="r.id">
                    <div class="bg-[#FCFAF7] border border-brand-beige p-6 rounded-2xl relative shadow-sm artisan-card">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-brand-cream border border-brand-beige overflow-hidden flex items-center justify-center flex-shrink-0">
                                    <template x-if="r.user?.avatar">
                                        <img :src="r.user.avatar" class="w-full h-full object-cover" alt="Avatar">
                                    </template>
                                    <template x-if="!r.user?.avatar">
                                        <span class="font-heading font-extrabold text-sm text-brand-dark" x-text="r.user?.name ? r.user.name.charAt(0).toUpperCase() : 'U'"></span>
                                    </template>
                                </div>
                                <div>
                                    <div class="font-bold text-xs text-brand-dark" x-text="r.user?.name || 'Kolektor Craftive'">Nama</div>
                                    <div class="text-[9px] text-gray-400 mt-0.5" x-text="new Date(r.created_at).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'})">Tanggal</div>
                                </div>
                            </div>
                            <div class="flex text-brand-gold text-sm">
                                <template x-for="star in [1,2,3,4,5]">
                                    <span x-text="r.rating >= star ? '★' : '☆'"></span>
                                </template>
                            </div>
                        </div>
                        <p class="text-xs text-brand-dark leading-relaxed italic" x-text="r.comment"></p>
                    </div>
                </template>
            </div>

            <!-- Empty Reviews state -->
            <div x-show="reviews.length === 0" class="text-center py-12 text-gray-400 bg-[#FCFAF7] border border-dashed border-brand-beige rounded-2xl">
                <p class="text-xs">Belum ada ulasan untuk mahakarya kriya ini. Jadilah yang pertama memberikan ulasan setelah membelinya!</p>
            </div>
        </div>

        <!-- ── DYNAMIC RELATED PRODUCTS SECTION ── -->
        <div x-show="!loading && relatedProducts.length > 0" class="mt-20 border-t border-brand-beige pt-16" style="display: none;">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-brand-accent">Koleksi Senada</span>
                    <h3 class="font-heading font-bold text-2xl text-brand-dark mt-1">Karya Serupa dari Kategori Ini</h3>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
                <template x-for="rp in relatedProducts" :key="rp.id">
                    <a :href="'<?php echo e(url('/products')); ?>/' + rp.id" class="group bg-white border border-brand-beige/80 rounded-2xl p-4 shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col justify-between min-h-[300px]">
                        <div>
                            <div class="bg-brand-cream rounded-xl h-36 flex items-center justify-center overflow-hidden mb-3 border border-brand-beige/40">
                                <template x-if="rp.image_url">
                                    <img :src="rp.image_url" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" :alt="rp.name">
                                </template>
                                <template x-if="!rp.image_url">
                                    <span class="text-xs uppercase tracking-widest text-brand-dark/40 font-bold">No Image</span>
                                </template>
                            </div>
                            <h4 class="font-bold text-brand-dark text-sm leading-snug group-hover:text-brand-terracotta transition-colors" x-text="rp.name">Nama Produk</h4>
                            <div class="text-[10px] text-brand-accent mt-1" x-text="rp.shop.name">Toko</div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-brand-beige/40 flex justify-between items-center text-xs">
                            <span class="text-brand-terracotta font-extrabold" x-text="'Rp ' + Number(rp.price).toLocaleString('id-ID')">Rp 0</span>
                            <span class="text-brand-accent font-bold">Detail &rarr;</span>
                        </div>
                    </a>
                </template>
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('productDetail', () => ({
            productId: '<?php echo e($id); ?>',
            product: null,
            relatedProducts: [],
            reviews: [],
            loading: true,
            qty: 1,

            async init() {
                this.loadReviews();
                try {
                    const response = await fetch(`<?php echo e(url("/api/products")); ?>/${this.productId}`, {
                        headers: { 'X-API-KEY': 'craftive-public-key-2026' }
                    });
                    if (!response.ok) {
                        throw new Error('Produk tidak ditemukan');
                    }
                    this.product = await response.json();
                    
                    // Fetch related products in the same category
                    if (this.product && this.product.category_id) {
                        const relatedRes = await fetch(`<?php echo e(url("/api/products")); ?>?category_id=${this.product.category_id}`, {
                            headers: { 'X-API-KEY': 'craftive-public-key-2026' }
                        });
                        const relatedData = await relatedRes.json();
                        if (relatedData && relatedData.data) {
                            // Filter out current product & take top 3
                            this.relatedProducts = relatedData.data
                                .filter(p => p.id != this.product.id)
                                .slice(0, 3);
                        }
                    }
                } catch (error) {
                    console.error('Gagal memuat detail produk:', error);
                    this.$root.__x.$data.addToast('error', 'Karya seni tidak ditemukan di database.');
                } finally {
                    this.loading = false;
                }
            },

            increaseQty() {
                if (this.qty < this.product.stock) {
                    this.qty++;
                }
            },

            decreaseQty() {
                if (this.qty > 1) {
                    this.qty--;
                }
            },

            getTechnicalSpecs() {
                if (!this.product || !this.product.category_id) return { technique: 'Pahat Tangan', material: 'Bahan Organik' };
                const catId = Number(this.product.category_id);
                switch(catId) {
                    case 1:
                        return { technique: 'Roda Putar & Glazur Keramik Tradisional', material: 'Tanah Liat Kasongan Pilihan' };
                    case 2:
                        return { technique: 'Ukiran Pahat Jepara Manual', material: 'Kayu Jati Solid Pilihan (Legal Wood)' };
                    case 3:
                        return { technique: 'Tenun Ikat Sade / Batik Canting Malam', material: 'Benang Katun Organik / Serat Sutra' };
                    case 4:
                        return { technique: 'Anyaman Serat Rapat & Rajut Manual', material: 'Serat Daun Pandan / Rotan Alami' };
                    default:
                        return { technique: 'Kerajinan Tangan Tradisional', material: 'Bahan Alam Terpilih' };
                }
            },

            async addToCart() {
                const globalData = Alpine.$data(document.body);
                const isLoggedIn = globalData.isLoggedIn;
                const userRole = globalData.userRole;

                if (!isLoggedIn) {
                    window.addToast('warning', 'Silakan masuk terlebih dahulu untuk belanja.');
                    window.location.href = '<?php echo e(route("login")); ?>';
                    return;
                }

                if (userRole !== 'buyer') {
                    window.addToast('error', 'Hanya pembeli yang dapat berbelanja.');
                    return;
                }

                try {
                    const result = await window.apiFetch('/api/cart', {
                        method: 'POST',
                        body: JSON.stringify({
                            product_id: this.product.id,
                            qty: this.qty
                        })
                    });

                    window.addToast('success', 'Produk berhasil ditambahkan ke keranjang belanja!');
                    // Trigger cart count update in layout
                    window.dispatchEvent(new CustomEvent('cart-updated'));

                } catch (error) {
                    window.addToast('error', 'Gagal menambahkan produk ke keranjang.');
                }
            },

            async loadReviews() {
                try {
                    const response = await fetch(`<?php echo e(url("/api/products")); ?>/${this.productId}/reviews`, {
                        headers: { 'X-API-KEY': 'craftive-public-key-2026' }
                    });
                    if (response.ok) {
                        this.reviews = await response.json();
                    }
                } catch (error) {
                    console.error('Gagal memuat ulasan:', error);
                }
            }
        }));
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp1\htdocs\craftive\resources\views/pages/show.blade.php ENDPATH**/ ?>