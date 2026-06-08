<?php $__env->startSection('content'); ?>
<div class="relative py-12 bg-transparent min-h-screen" x-data="productsPage">

    <!-- Header Banner: Gallery Exhibition Header in Mahogany Gold Plaque -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
        <div class="bg-gradient-to-br from-brand-dark via-[#3A2318] to-brand-dark rounded-[2rem] border-2 border-brand-gold/30 p-8 sm:p-12 shadow-2xl flex flex-col md:flex-row md:items-center justify-between gap-8 relative overflow-hidden text-brand-cream">
            <div class="absolute top-0 right-0 w-64 h-64 bg-brand-terracotta/10 rounded-full blur-2xl pointer-events-none"></div>
            
            <div class="relative z-10">
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-brand-gold">Nusantara Curation</span>
                <h1 class="font-heading font-extrabold text-3xl sm:text-4xl text-white mt-1 mb-3">Katalog Kerajinan Nusantara</h1>
                <p class="text-xs text-brand-cream/80 max-w-lg leading-relaxed">Explore and collect the finest handcrafted products by local Indonesian artisans. Every item is shipped directly from the artisan's workshop.</p>
            </div>
            
            <!-- Search bar with dynamic focus states -->
            <div class="relative w-full md:max-w-xs flex items-center relative z-10">
                <input type="text" x-model="searchQuery" @input.debounce.500ms="loadProducts()" class="w-full bg-[#FCF8F2] border-2 border-brand-beige text-brand-dark rounded-2xl py-4 pl-5 pr-12 text-xs font-semibold outline-none focus:border-brand-terracotta transition-all shadow-sm" placeholder="Search crafts by name...">
                <span class="absolute right-4 text-brand-terracotta text-sm">
                    <svg class="w-4 h-4 text-brand-terracotta" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
            </div>
        </div>
    </div>

    <!-- Main Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- ── SIDEBAR FILTERS (Artisan Curated Sidebar with Thick Borders) ── -->
            <aside class="flex flex-col gap-6">
                
                <!-- Category Filters Card -->
                <div class="artisan-card rounded-3xl p-6 shadow-sm">
                    <h3 class="font-heading font-bold text-brand-dark text-base mb-4 flex items-center justify-between">
                        <span>Categories</span>
                    </h3>
                    <div class="flex flex-col gap-1 text-xs">
                        <button @click="setCategory('')" class="w-full text-left p-3 rounded-2xl font-bold transition-all flex items-center justify-between border-2 border-transparent shadow-sm"
                                :class="selectedCategory === '' ? 'bg-gradient-to-r from-brand-terracotta to-brand-terracotta-light text-white shadow-md shadow-brand-terracotta/20' : 'bg-white/70 text-brand-dark/75 hover:bg-brand-cream'">
                            <span>All Crafts</span>
                        </button>
                        <template x-for="cat in categories" :key="cat.id">
                            <button @click="setCategory(cat.id)" class="w-full text-left p-3 rounded-2xl font-bold transition-all flex items-center justify-between border-2 border-transparent shadow-sm"
                                    :class="selectedCategory == cat.id ? 'bg-gradient-to-r from-brand-terracotta to-brand-terracotta-light text-white shadow-md shadow-brand-terracotta/20' : 'bg-white/70 text-brand-dark/75 hover:bg-brand-cream'">
                                <span x-text="cat.name">Category</span>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Estetika Gaya (Style Filter) Card -->
                <div class="artisan-card rounded-3xl p-6 shadow-sm">
                    <h3 class="font-heading font-bold text-brand-dark text-base mb-4 flex items-center justify-between">
                        <span>Aesthetic Style</span>
                    </h3>
                    <div class="flex flex-col gap-1 text-xs">
                        <button @click="setStyle('')" class="w-full text-left p-3 rounded-2xl font-bold transition-all border-2 border-transparent shadow-sm"
                                :class="selectedStyle === '' ? 'bg-gradient-to-r from-brand-terracotta to-brand-terracotta-light text-white shadow-md shadow-brand-terracotta/20' : 'bg-white/70 text-brand-dark/75 hover:bg-brand-cream'">
                            All Styles
                        </button>
                        <button @click="setStyle('Minimalis')" class="w-full text-left p-3 rounded-2xl font-bold transition-all border-2 border-transparent shadow-sm"
                                :class="selectedStyle === 'Minimalis' ? 'bg-gradient-to-r from-brand-terracotta to-brand-terracotta-light text-white shadow-md shadow-brand-terracotta/20' : 'bg-white/70 text-brand-dark/75 hover:bg-brand-cream'">
                            Minimalist & Wabi-Sabi
                        </button>
                        <button @click="setStyle('Etnik')" class="w-full text-left p-3 rounded-2xl font-bold transition-all border-2 border-transparent shadow-sm"
                                :class="selectedStyle === 'Etnik' ? 'bg-gradient-to-r from-brand-terracotta to-brand-terracotta-light text-white shadow-md shadow-brand-terracotta/20' : 'bg-white/70 text-brand-dark/75 hover:bg-brand-cream'">
                            Ethnic & Traditional
                        </button>
                        <button @click="setStyle('Bohemian')" class="w-full text-left p-3 rounded-2xl font-bold transition-all border-2 border-transparent shadow-sm"
                                :class="selectedStyle === 'Bohemian' ? 'bg-gradient-to-r from-brand-terracotta to-brand-terracotta-light text-white shadow-md shadow-brand-terracotta/20' : 'bg-white/70 text-brand-dark/75 hover:bg-brand-cream'">
                            Bohemian Boho Style
                        </button>
                        <button @click="setStyle('Vintage')" class="w-full text-left p-3 rounded-2xl font-bold transition-all border-2 border-transparent shadow-sm"
                                :class="selectedStyle === 'Vintage' ? 'bg-gradient-to-r from-brand-terracotta to-brand-terracotta-light text-white shadow-md shadow-brand-terracotta/20' : 'bg-white/70 text-brand-dark/75 hover:bg-brand-cream'">
                            Vintage Rustic
                        </button>
                        <button @click="setStyle('Cute')" class="w-full text-left p-3 rounded-2xl font-bold transition-all border-2 border-transparent shadow-sm"
                                :class="selectedStyle === 'Cute' ? 'bg-gradient-to-r from-brand-terracotta to-brand-terracotta-light text-white shadow-md shadow-brand-terracotta/20' : 'bg-white/70 text-brand-dark/75 hover:bg-brand-cream'">
                            Cute & Adorable
                        </button>
                        <button @click="setStyle('Aesthetic')" class="w-full text-left p-3 rounded-2xl font-bold transition-all border-2 border-transparent shadow-sm"
                                :class="selectedStyle === 'Aesthetic' ? 'bg-gradient-to-r from-brand-terracotta to-brand-terracotta-light text-white shadow-md shadow-brand-terracotta/20' : 'bg-white/70 text-brand-dark/75 hover:bg-brand-cream'">
                            Aesthetic Retro
                        </button>
                    </div>
                </div>

                <!-- Price Range Filter Card -->
                <div class="artisan-card rounded-3xl p-6 shadow-sm">
                    <h3 class="font-heading font-bold text-brand-dark text-base mb-4 flex items-center justify-between">
                        <span>Price Range</span>
                    </h3>
                    <div class="flex flex-col gap-1 text-xs">
                        <button @click="setPriceRange('')" class="w-full text-left p-3 rounded-2xl font-bold transition-all border-2 border-transparent shadow-sm"
                                :class="priceRange === '' ? 'bg-gradient-to-r from-brand-terracotta to-brand-terracotta-light text-white shadow-md shadow-brand-terracotta/20' : 'bg-white/70 text-brand-dark/75 hover:bg-brand-cream'">
                            All Prices
                        </button>
                        <button @click="setPriceRange('murah')" class="w-full text-left p-3 rounded-2xl font-bold transition-all border-2 border-transparent shadow-sm"
                                :class="priceRange === 'murah' ? 'bg-gradient-to-r from-brand-terracotta to-brand-terracotta-light text-white shadow-md shadow-brand-terracotta/20' : 'bg-white/70 text-brand-dark/75 hover:bg-brand-cream'">
                            Under IDR 50k
                        </button>
                        <button @click="setPriceRange('menengah')" class="w-full text-left p-3 rounded-2xl font-bold transition-all border-2 border-transparent shadow-sm"
                                :class="priceRange === 'menengah' ? 'bg-gradient-to-r from-brand-terracotta to-brand-terracotta-light text-white shadow-md shadow-brand-terracotta/20' : 'bg-white/70 text-brand-dark/75 hover:bg-brand-cream'">
                            IDR 50k - 250k
                        </button>
                        <button @click="setPriceRange('tinggi')" class="w-full text-left p-3 rounded-2xl font-bold transition-all border-2 border-transparent shadow-sm"
                                :class="priceRange === 'tinggi' ? 'bg-gradient-to-r from-brand-terracotta to-brand-terracotta-light text-white shadow-md shadow-brand-terracotta/20' : 'bg-white/70 text-brand-dark/75 hover:bg-brand-cream'">
                            Above IDR 250k
                        </button>
                    </div>
                </div>
            </aside>

            <!-- ── PRODUCT LISTING GRID ── -->
            <div class="lg:col-span-3 flex flex-col gap-6">
                
                <!-- Info Summary and Reset button -->
                <div class="flex justify-between items-center text-xs px-2">
                    <span class="font-bold text-brand-dark/70" x-text="totalProducts + ' karya seni ditemukan'">0 karya seni ditemukan</span>
                    <button x-show="selectedCategory || targetDemographic || priceRange || searchQuery || selectedStyle"
                            @click="resetAllFilters()"
                            class="text-brand-terracotta font-extrabold hover:underline">
                        Hapus Semua Filter &times;
                    </button>
                </div>

                <!-- Products Grid -->
                <div x-show="products.length > 0 && !loading" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <template x-for="p in products" :key="p.id">
                        <div class="group artisan-card rounded-3xl p-5 hover:border-brand-terracotta hover:shadow-xl transition-all duration-500 flex flex-col justify-between min-h-[440px]">
                            <div>
                                <!-- Image Container -->
                                <div class="relative bg-gradient-to-br from-[#FCFAF7] via-[#F5E5D5] to-[#E3C6AB] border border-brand-beige rounded-2xl h-44 flex items-center justify-center shadow-inner mb-4 overflow-hidden">
                                    <template x-if="p.image_url">
                                        <img :src="p.image_url" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" :alt="p.name">
                                    </template>
                                    <template x-if="!p.image_url">
                                        <span class="text-xs uppercase tracking-widest text-brand-dark/40 font-bold">No Image</span>
                                    </template>
                                    
                                    <!-- Authenticity Seal -->
                                    <span class="absolute top-12 right-2 authenticity-seal px-2 py-1 rounded shadow-md">Karya Asli</span>
                                    <!-- Category overlay -->
                                    <span class="absolute top-3 left-3 bg-brand-dark/90 backdrop-blur-sm text-brand-cream text-[9px] font-extrabold px-3 py-1 rounded-full uppercase tracking-wider" x-text="p.category.name">Kategori</span>
                                    <!-- Handmade seal -->
                                    <span class="absolute bottom-3 right-3 bg-brand-gold text-brand-dark text-[8.5px] font-extrabold px-2.5 py-0.5 rounded-md uppercase tracking-wider shadow-sm">Otentik</span>
                                </div>
                                
                                <!-- Product Name -->
                                <h3 class="font-heading font-bold text-brand-dark text-base leading-snug group-hover:text-brand-terracotta transition-colors line-clamp-2">
                                    <a :href="'<?php echo e(url('/products')); ?>/' + p.id" x-text="p.name">Nama Produk</a>
                                </h3>
                                
                                <!-- Shop details with location -->
                                <div class="flex items-center gap-1.5 text-[11px] text-brand-accent font-bold mt-2">
                                    <span x-text="p.shop.name">Toko</span>
                                    <span class="text-gray-300">|</span>
                                    <span class="text-gray-400 font-normal" x-text="p.shop.address || 'Indonesia'">Lokasi</span>
                                </div>

                                <!-- Aesthetic Tags: Customized Colors based on target demographic -->
                                <div class="flex flex-wrap gap-1.5 mt-3">
                                    <span class="bg-[#F8F1E7] text-brand-terracotta text-[9px] font-bold px-2 py-0.5 rounded-md border border-brand-terracotta/10" x-text="p.style || 'Artisan'">Gaya</span>
                                    
                                    <!-- Target tags -->
                                    <template x-if="p.target_demographic === 'anak-anak'">
                                        <span class="bg-[#FAF0D7] text-[#9F5F00] text-[9px] font-bold px-2.5 py-0.5 rounded-md">Anak-anak</span>
                                    </template>
                                    <template x-if="p.target_demographic === 'remaja'">
                                        <span class="bg-[#FFD9C0] text-brand-terracotta text-[9px] font-bold px-2.5 py-0.5 rounded-md">Remaja</span>
                                    </template>
                                    <template x-if="p.target_demographic === 'mahasiswa'">
                                        <span class="bg-[#CCEEF9] text-[#1F5F7A] text-[9px] font-bold px-2.5 py-0.5 rounded-md">Mahasiswa</span>
                                    </template>
                                    <template x-if="p.target_demographic === 'dewasa'">
                                        <span class="bg-[#EAD0B8] text-brand-dark text-[9px] font-bold px-2.5 py-0.5 rounded-md">Dewasa</span>
                                    </template>
                                </div>
                            </div>
                            
                            <!-- Card Footer -->
                            <div class="mt-5 pt-4 border-t border-brand-beige/50 flex flex-col gap-3">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <div class="text-[9px] text-gray-400 font-bold uppercase tracking-wider">Price</div>
                                        <div class="text-brand-terracotta font-extrabold text-lg" x-text="'Rp ' + Number(p.price).toLocaleString('id-ID')">Rp 0</div>
                                    </div>
                                    <div class="text-xs text-brand-gold font-bold flex items-center gap-0.5">★ <span x-text="p.rating_avg || '4.8'"></span></div>
                                </div>
                                
                                <!-- Actions: Detail and Add to Cart -->
                                <div class="flex gap-2">
                                    <a :href="'<?php echo e(url('/products')); ?>/' + p.id" 
                                       class="flex-1 border-2 border-brand-dark hover:bg-brand-dark hover:text-white text-brand-dark py-2.5 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-1.5 shadow-sm text-center">
                                        Detail
                                    </a>
                                    <button @click="addToCart(p.id)" 
                                            class="flex-1 bg-brand-dark hover:bg-brand-terracotta text-white py-2.5 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-1.5 shadow-md shadow-brand-dark/10">
                                        Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Loading State -->
                <div x-show="loading" class="flex flex-col items-center justify-center py-32 gap-3">
                    <span class="animate-spin border-4 border-brand-terracotta border-t-transparent w-8 h-8 rounded-full"></span>
                    <span class="text-xs text-brand-accent font-bold">Curating masterpieces...</span>
                </div>

                <!-- Empty State -->
                <div x-show="products.length === 0 && !loading" class="bg-[#FCFAF7] rounded-3xl border-2 border-brand-beige p-20 text-center shadow-sm" style="display: none;">
                    <h3 class="font-heading font-bold text-xl mt-4 text-brand-dark">No Artworks Found</h3>
                    <p class="text-xs text-gray-500 mt-2">Try clearing filters or search for another craft.</p>
                    <button @click="resetAllFilters()" class="mt-6 bg-brand-terracotta text-white px-6 py-2.5 rounded-xl text-xs font-bold hover:bg-brand-terracotta-light">Show All Products</button>
                </div>

            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('productsPage', () => ({
            products: [],
            categories: [],
            selectedCategory: '',
            targetDemographic: '',
            selectedStyle: '',
            priceRange: '',
            searchQuery: '',
            loading: false,
            totalProducts: 0,

            async init() {
                const urlParams = new URLSearchParams(window.location.search);
                const catParam = urlParams.get('category_id');
                if (catParam) {
                    this.selectedCategory = catParam;
                }

                const targetDemographicParam = urlParams.get('target_demographic');
                if (targetDemographicParam) {
                    this.targetDemographic = targetDemographicParam;
                }

                const styleParam = urlParams.get('style');
                if (styleParam) {
                    this.selectedStyle = styleParam;
                }

                // Load categories list
                try {
                    const response = await fetch('<?php echo e(url("/api/categories")); ?>', {
                        headers: { 'X-API-KEY': 'craftive-public-key-2026' }
                    });
                    this.categories = await response.json();
                } catch (error) {
                    console.error('Gagal mengambil kategori:', error);
                }

                // Load products catalog
                this.loadProducts();
            },

            async loadProducts() {
                this.loading = true;
                try {
                    let query = `?search=${this.searchQuery}`;
                    if (this.selectedCategory) {
                        query += `&category_id=${this.selectedCategory}`;
                    }
                    if (this.targetDemographic) {
                        query += `&target_demographic=${this.targetDemographic}`;
                    }
                    if (this.selectedStyle) {
                        query += `&style=${this.selectedStyle}`;
                    }
                    if (this.priceRange) {
                        query += `&price_range=${this.priceRange}`;
                    }

                    const response = await fetch(`<?php echo e(url("/api/products")); ?>${query}`, {
                        headers: { 'X-API-KEY': 'craftive-public-key-2026' }
                    });
                    const data = await response.json();
                    
                    if (data && data.data) {
                        this.products = data.data;
                        this.totalProducts = data.total;
                    }
                } catch (error) {
                    console.error('Gagal memuat katalog produk:', error);
                } finally {
                    this.loading = false;
                }
            },

            setCategory(catId) {
                this.selectedCategory = catId;
                this.loadProducts();
            },

            setDemographic(demo) {
                this.targetDemographic = demo;
                this.loadProducts();
            },

            setStyle(style) {
                this.selectedStyle = style;
                this.loadProducts();
            },

            setPriceRange(range) {
                this.priceRange = range;
                this.loadProducts();
            },

            resetAllFilters() {
                this.selectedCategory = '';
                this.targetDemographic = '';
                this.selectedStyle = '';
                this.priceRange = '';
                this.searchQuery = '';
                this.loadProducts();
            },

            async addToCart(productId) {
                const globalData = Alpine.$data(document.body);
                const isLoggedIn = globalData.isLoggedIn;
                const userRole = globalData.userRole;

                if (!isLoggedIn) {
                    window.addToast('warning', 'Silakan masuk terlebih dahulu untuk berbelanja.');
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
                            product_id: productId,
                            qty: 1
                        })
                    });

                    window.addToast('success', 'Produk berhasil ditambahkan ke keranjang!');
                    // Trigger cart count update
                    window.dispatchEvent(new CustomEvent('cart-updated'));

                } catch (error) {
                    window.addToast('error', 'Gagal menambahkan produk ke keranjang.');
                }
            }
        }));
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp1\htdocs\craftive\resources\views/pages/products.blade.php ENDPATH**/ ?>