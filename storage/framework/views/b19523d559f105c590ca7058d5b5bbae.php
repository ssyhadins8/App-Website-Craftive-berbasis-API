<?php $__env->startSection('content'); ?>
<div class="relative overflow-hidden" x-data="homePage">

    <!-- Hero Section: Premium Magazine Style with Warm Vibrant Gradients -->
    <div class="relative pt-12 pb-24 lg:pt-20 lg:pb-36 bg-gradient-to-br from-brand-cream via-[#F5E5D5]/40 to-[#FCF8F2] overflow-hidden">
        <!-- Parallax Background Blobs -->
        <div class="absolute top-10 right-10 w-[600px] h-[600px] rounded-full bg-radial-gradient bg-brand-terracotta/10 blur-3xl pointer-events-none animate-pulse"></div>
        <div class="absolute -bottom-20 -left-10 w-[450px] h-[450px] rounded-full bg-brand-terracotta/5 blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                
                <!-- Left Side text: Editorial Copy -->
                <div class="lg:col-span-6 flex flex-col items-start text-left">
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-brand-terracotta/10 text-brand-terracotta text-[10px] font-extrabold uppercase tracking-widest mb-6 shadow-sm border border-brand-terracotta/20">
                        ✦ From Their Hands to Your Heart
                    </span>
                    <h1 class="font-heading text-4xl sm:text-5xl lg:text-[3.5rem] font-extrabold leading-[1.1] text-brand-dark mb-6">
                        Dari tangan perajin lokal,<br>
                        langsung ke <span class="text-gradient font-heading italic font-semibold">tanganmu.</span>
                    </h1>
                    <p class="text-sm sm:text-base text-brand-dark/80 mb-8 max-w-xl leading-relaxed">
                        Temukan kerajinan autentik Nusantara, setiap karya punya jiwa, setiap pembelian punya makna.
                    </p>
                    <div class="flex flex-wrap gap-5 w-full sm:w-auto">
                        <a href="<?php echo e(url('/products')); ?>" class="w-full sm:w-auto text-center bg-gradient-to-r from-brand-terracotta to-brand-terracotta-light hover:from-brand-terracotta-light hover:to-brand-accent text-white px-10 py-5 rounded-2xl font-extrabold text-sm hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 tracking-widest uppercase shadow-lg shadow-brand-terracotta/25">
                            Jelajahi Kerajinan
                        </a>
                        <a href="<?php echo e(route('register')); ?>?role=seller" class="w-full sm:w-auto text-center bg-brand-dark hover:bg-brand-terracotta text-white px-10 py-5 rounded-2xl font-extrabold text-sm hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 border border-brand-dark/20 tracking-widest uppercase shadow-lg shadow-brand-dark/25">
                            Gabung Jadi Perajin
                        </a>
                    </div>
                </div>

                <!-- Right Side: Overlapping Editorial Collage -->
                <div class="lg:col-span-6 relative h-[450px] w-full hidden sm:block">
                    <!-- Image 1 (Back/Pottery) -->
                    <div class="absolute top-4 left-6 w-[240px] h-[300px] rounded-3xl overflow-hidden shadow-xl border-2 border-brand-beige rotate-[-4deg] transition-all hover:rotate-0 duration-500 hover:scale-105 z-10 bg-brand-beige">
                        <img src="<?php echo e(asset('images/hero/pottery.png')); ?>" class="w-full h-full object-cover" alt="Gerabah Terakota">
                        <div class="absolute bottom-3 left-3 bg-brand-dark/90 text-brand-cream px-3 py-1 rounded-xl text-[10px] font-bold">Gerabah Terakota</div>
                    </div>
                    
                    <!-- Image 2 (Front-Left/Weaving) -->
                    <div class="absolute bottom-4 left-32 w-[220px] h-[260px] rounded-3xl overflow-hidden shadow-2xl border-2 border-brand-beige rotate-[6deg] transition-all hover:rotate-0 duration-500 hover:scale-105 z-20 bg-brand-beige">
                        <img src="<?php echo e(asset('images/hero/weaving.jpg')); ?>" class="w-full h-full object-cover" alt="Tenun Ikat Sumba">
                        <div class="absolute bottom-3 left-3 bg-brand-dark/90 text-brand-cream px-3 py-1 rounded-xl text-[10px] font-bold">Tenun Ikat Sumba</div>
                    </div>

                    <!-- Image 3 (Front-Right/Woodwork) -->
                    <div class="absolute top-12 right-6 w-[200px] h-[220px] rounded-3xl overflow-hidden shadow-xl border-2 border-brand-beige rotate-[-6deg] transition-all hover:rotate-0 duration-500 hover:scale-105 z-30 bg-brand-beige">
                        <img src="<?php echo e(asset('images/hero/woodcarving.jpg')); ?>" class="w-full h-full object-cover" alt="Ukiran Kayu Jati">
                        <div class="absolute bottom-3 left-3 bg-brand-dark/90 text-brand-cream px-3 py-1 rounded-xl text-[10px] font-bold">Ukiran Kayu Jati</div>
                    </div>

                    <!-- Floating Badge -->
                    <div class="absolute -bottom-4 right-16 bg-brand-terracotta text-brand-cream border border-brand-accent/30 w-28 h-28 rounded-full flex flex-col items-center justify-center text-center shadow-2xl z-40 p-2 animate-bounce">
                        <span class="text-[9px] uppercase tracking-widest font-extrabold text-brand-gold">Otentik</span>
                        <span class="font-heading italic text-xs font-semibold text-white my-0.5">100%</span>
                        <span class="text-[8px] uppercase tracking-wider text-brand-cream/80">Buatan Tangan</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Platform Stats: Premium Light Clay Brown Plaque -->
    <div class="bg-gradient-to-r from-[#EAD0B8] via-[#F5DFCC] to-[#EAD0B8] text-brand-dark py-14 relative z-10 -mt-10 mx-4 sm:mx-8 lg:mx-auto max-w-6xl rounded-[2rem] shadow-2xl border-2 border-[#D7B198] overflow-hidden">
        <div class="grid grid-cols-2 md:grid-cols-4 divide-y md:divide-y-0 md:divide-x divide-[#D7B198]/40 text-center relative z-10">
            <div class="p-4">
                <div class="text-3xl sm:text-4xl font-heading font-extrabold text-brand-terracotta mb-1">2.4K+</div>
                <div class="text-[10px] text-brand-dark/80 font-bold uppercase tracking-widest">Perajin Terverifikasi</div>
            </div>
            <div class="p-4">
                <div class="text-3xl sm:text-4xl font-heading font-extrabold text-brand-dark mb-1">18K+</div>
                <div class="text-[10px] text-brand-dark/80 font-bold uppercase tracking-widest">Karya Seni Unik</div>
            </div>
            <div class="p-4">
                <div class="text-3xl sm:text-4xl font-heading font-extrabold text-brand-terracotta mb-1">50K+</div>
                <div class="text-[10px] text-brand-dark/80 font-bold uppercase tracking-widest">Kolektor Puas</div>
            </div>
            <div class="p-4">
                <div class="text-3xl sm:text-4xl font-heading font-extrabold text-brand-dark mb-1">4.9★</div>
                <div class="text-[10px] text-brand-dark/80 font-bold uppercase tracking-widest">Kepuasan Transaksi</div>
            </div>
        </div>
    </div>

    <!-- Section: Philosophy of Handmade (High Contrast Deep Mahogany Gradient Block) -->
    <section class="py-24 bg-gradient-to-br from-[#2E1A11] via-[#4A2D1B] to-[#1C0E07] text-brand-cream relative overflow-hidden">
        <!-- Background light rays -->
        <div class="absolute top-0 right-0 w-[400px] h-[400px] rounded-full bg-brand-terracotta/10 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-20 -left-10 w-[400px] h-[400px] rounded-full bg-brand-gold/5 blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-xs font-bold uppercase tracking-widest text-brand-gold">Filosofi Perajin</span>
                <h2 class="font-heading text-3xl sm:text-4xl font-bold mt-2 text-white">Mengapa Kerajinan Buatan Tangan Begitu Istimewa?</h2>
                <div class="w-12 h-0.5 bg-brand-terracotta mx-auto mt-4"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Card 1 -->
                <div class="artisan-card rounded-3xl p-8 hover:border-brand-gold hover:shadow-2xl hover:-translate-y-1.5 text-brand-dark flex flex-col justify-between min-h-[250px]">
                    <div>
                        <div class="w-12 h-12 bg-brand-terracotta/10 rounded-2xl flex items-center justify-center text-3xl mb-5 shadow-inner">
                            <svg class="w-6 h-6 text-brand-terracotta" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                        </div>
                        <h3 class="font-heading font-bold text-brand-dark text-lg mb-2">Unik & Tiada Dua</h3>
                        <p class="text-xs text-brand-dark/70 leading-relaxed">
                            Tidak ada dua produk yang persis sama. Setiap sapuan kuas, bentuk gerabah, dan rajutan membawa jejak unik sang perajin.
                        </p>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="artisan-card rounded-3xl p-8 hover:border-brand-gold hover:shadow-2xl hover:-translate-y-1.5 text-brand-dark flex flex-col justify-between min-h-[250px]">
                    <div>
                        <div class="w-12 h-12 bg-brand-gold/15 rounded-2xl flex items-center justify-center text-3xl mb-5 shadow-inner">
                            <svg class="w-6 h-6 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <h3 class="font-heading font-bold text-brand-dark text-lg mb-2">Warisan Budaya</h3>
                        <p class="text-xs text-brand-dark/70 leading-relaxed">
                            Mendukung pelestarian kerajinan tradisional Indonesia yang diwariskan secara murni dari generasi ke generasi.
                        </p>
                    </div>
                </div>
                <!-- Card 3 -->
                <div class="artisan-card rounded-3xl p-8 hover:border-brand-gold hover:shadow-2xl hover:-translate-y-1.5 text-brand-dark flex flex-col justify-between min-h-[250px]">
                    <div>
                        <div class="w-12 h-12 bg-brand-terracotta/10 rounded-2xl flex items-center justify-center text-3xl mb-5 shadow-inner">
                            <svg class="w-6 h-6 text-brand-terracotta" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                        </div>
                        <h3 class="font-heading font-bold text-brand-dark text-lg mb-2">Bahan Alami Pilihan</h3>
                        <p class="text-xs text-brand-dark/70 leading-relaxed">
                            Menggunakan bahan ramah lingkungan dari alam seperti tanah liat Kasongan, kayu jati legal, serat pandan, dan pewarna tumbuhan organik.
                        </p>
                    </div>
                </div>
                <!-- Card 4 -->
                <div class="artisan-card rounded-3xl p-8 hover:border-brand-gold hover:shadow-2xl hover:-translate-y-1.5 text-brand-dark flex flex-col justify-between min-h-[250px]">
                    <div>
                        <div class="w-12 h-12 bg-brand-gold/15 rounded-2xl flex items-center justify-center text-3xl mb-5 shadow-inner">
                            <svg class="w-6 h-6 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h3 class="font-heading font-bold text-brand-dark text-lg mb-2">Dampak Sosial</h3>
                        <p class="text-xs text-brand-dark/70 leading-relaxed">
                            Setiap pembelian langsung mendukung mata pencaharian keluarga perajin lokal di berbagai pelosok desa di Indonesia.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Galeri Proses: Langkah Kreatif Pembuatan (Warm sand block) -->
    <section class="py-20 bg-[#F5EAD8]/30 border-t border-b border-brand-beige">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-xs font-bold uppercase tracking-widest text-brand-accent">Proses Pembuatan</span>
                <h2 class="font-heading text-3xl font-bold mt-2 text-brand-dark">Bagaimana Karya Seni Kami Diciptakan?</h2>
                <div class="w-12 h-0.5 bg-brand-terracotta mx-auto mt-4"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 relative">
                <!-- Step 1 -->
                <div class="flex flex-col items-center text-center p-4 bg-white/60 backdrop-blur rounded-2xl border border-brand-beige shadow-sm">
                    <div class="w-16 h-16 rounded-full bg-brand-terracotta text-white shadow-md flex items-center justify-center text-xl font-heading font-bold mb-4">1</div>
                    <h3 class="font-bold text-brand-dark text-sm mb-2">Pemilihan Bahan</h3>
                    <p class="text-[11px] text-gray-600 max-w-[200px]">Memilih kayu jati solid, serat alam, dan tanah liat terbaik langsung dari alam.</p>
                </div>
                <!-- Step 2 -->
                <div class="flex flex-col items-center text-center p-4 bg-white/60 backdrop-blur rounded-2xl border border-brand-beige shadow-sm">
                    <div class="w-16 h-16 rounded-full bg-brand-dark text-white shadow-md flex items-center justify-center text-xl font-heading font-bold mb-4">2</div>
                    <h3 class="font-bold text-brand-dark text-sm mb-2">Pengerjaan Tangan</h3>
                    <p class="text-[11px] text-gray-600 max-w-[200px]">Dipahat, ditenun, atau dibentuk secara manual dengan tangan, menghindari mesin pabrik massal.</p>
                </div>
                <!-- Step 3 -->
                <div class="flex flex-col items-center text-center p-4 bg-white/60 backdrop-blur rounded-2xl border border-brand-beige shadow-sm">
                    <div class="w-16 h-16 rounded-full bg-brand-terracotta text-white shadow-md flex items-center justify-center text-xl font-heading font-bold mb-4">3</div>
                    <h3 class="font-bold text-brand-dark text-sm mb-2">Sentuhan Akhir</h3>
                    <p class="text-[11px] text-gray-600 max-w-[200px]">Pengamplasan halus, pelapisan lilin lebah alami, atau pembakaran tungku bersuhu tinggi.</p>
                </div>
                <!-- Step 4 -->
                <div class="flex flex-col items-center text-center p-4 bg-white/60 backdrop-blur rounded-2xl border border-brand-beige shadow-sm">
                    <div class="w-16 h-16 rounded-full bg-brand-dark text-white shadow-md flex items-center justify-center text-xl font-heading font-bold mb-4">4</div>
                    <h3 class="font-bold text-brand-dark text-sm mb-2">Kartu Seniman</h3>
                    <p class="text-[11px] text-gray-600 max-w-[200px]">Kemasan ramah lingkungan yang dilengkapi kartu profil perajin bertandatangan pembuatnya.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Bento Grid Kategori Kriya (Vibrant Solid Gradients) -->
    <section id="kategori" class="py-24 bg-transparent border-t border-brand-beige relative overflow-hidden">
        <!-- Floating organic circle background shapes to add depth -->
        <div class="absolute -top-20 -right-20 w-[350px] h-[350px] rounded-full bg-brand-terracotta/5 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-20 -left-20 w-[300px] h-[300px] rounded-full bg-brand-gold/5 blur-3xl pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-xs font-bold uppercase tracking-widest text-brand-accent">Galeri Karya</span>
                <h2 class="font-heading text-3xl md:text-4xl font-bold mt-2 text-brand-dark">Kategori Kerajinan Unggulan</h2>
                <div class="w-12 h-0.5 bg-brand-terracotta mx-auto mt-4"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Bento 1: Keramik (Wide, category_id = 1) -->
                <a href="<?php echo e(url('/products?category_id=1')); ?>" class="group relative rounded-3xl overflow-hidden p-8 min-h-[280px] bg-gradient-to-br from-[#FFF8F0] via-[#FBE9D7] to-[#E9C6A7] border-2 border-brand-beige/80 flex flex-col justify-between md:col-span-2 transition-all hover:shadow-2xl hover:border-brand-terracotta/30 hover:-translate-y-1.5 duration-300">
                    <div>
                        <span class="text-[10px] font-extrabold tracking-widest text-brand-terracotta uppercase">Tradisional Kasongan & Bali</span>
                        <h3 class="font-heading text-2xl font-bold mt-1 text-brand-dark">Keramik & Gerabah</h3>
                        <p class="text-xs text-brand-dark/80 mt-2 max-w-md leading-relaxed">Cangkir tanah liat berglasir, vas terakota, dan piring wabi-sabi hasil pembakaran suhu tinggi.</p>
                    </div>
                </a>

                <!-- Bento 2: Kayu (category_id = 2) -->
                <a href="<?php echo e(url('/products?category_id=2')); ?>" class="group relative rounded-3xl overflow-hidden p-8 min-h-[280px] bg-gradient-to-br from-[#3D2517] via-[#5C3A24] to-[#201007] border-2 border-brand-gold/30 flex flex-col justify-between transition-all hover:shadow-2xl hover:border-brand-gold/60 hover:-translate-y-1.5 duration-300">
                    <div>
                        <span class="text-[10px] font-extrabold tracking-widest text-brand-gold uppercase">Pahatan Tangan Jepara</span>
                        <h3 class="font-heading text-2xl font-bold mt-1 text-brand-cream">Ukiran Kayu & Pahat</h3>
                        <p class="text-xs text-brand-cream/80 mt-2 leading-relaxed">Nampan saji jati, kotak perhiasan beludru, mainan kayu Montessori halus, dan wadah pensil minimalis.</p>
                    </div>
                </a>

                <!-- Bento 3: Tekstil & Rajut (category_id = 3) -->
                <a href="<?php echo e(url('/products?category_id=3')); ?>" class="group relative rounded-3xl overflow-hidden p-8 min-h-[280px] bg-gradient-to-br from-[#4A200F] via-[#73351A] to-[#2E1205] border-2 border-brand-terracotta/30 flex flex-col justify-between transition-all hover:shadow-2xl hover:border-brand-terracotta/60 hover:-translate-y-1.5 duration-300">
                    <div>
                        <span class="text-[10px] font-extrabold tracking-widest text-brand-gold uppercase">Pewarna Alami & Canting</span>
                        <h3 class="font-heading text-2xl font-bold mt-1 text-brand-cream">Tekstil & Batik Tulis</h3>
                        <p class="text-xs text-brand-cream/80 mt-2 leading-relaxed">Kain batik tradisional, kemeja batik modern, rajutan amigurumi, dan syal tenun Sade Lombok.</p>
                    </div>
                </a>

                <!-- Bento 4: Anyaman (Wide, category_id = 4) -->
                <a href="<?php echo e(url('/products?category_id=4')); ?>" class="group relative rounded-3xl overflow-hidden p-8 min-h-[280px] bg-gradient-to-br from-[#FCFAF7] via-[#F5E5D5] to-[#E3C6AB] border-2 border-brand-beige/80 flex flex-col justify-between md:col-span-2 transition-all hover:shadow-2xl hover:border-brand-terracotta/30 hover:-translate-y-1.5 duration-300">
                    <div>
                        <span class="text-[10px] font-extrabold tracking-widest text-brand-terracotta uppercase">Serat Pandan & Anyaman Rotan</span>
                        <h3 class="font-heading text-2xl font-bold mt-1 text-brand-dark">Anyaman & Kerajinan Kulit</h3>
                        <p class="text-xs text-brand-dark/80 mt-2 max-w-md leading-relaxed">Tas pandan hiasan makrame, tatakan gelas boho, keranjang rotan gantung, binder kulit, dan tas kulit sapi.</p>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- CRAFTIVE AI Recommendation: Premium Interactive Finder Quiz -->
    <section class="py-24 relative overflow-hidden bg-gradient-to-b from-[#FAF6F0] via-[#FAF4EA] to-[#FAF6F0] border-t border-b border-brand-beige">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-brand-terracotta/5 via-transparent to-transparent pointer-events-none"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Section Header -->
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-xs font-bold uppercase tracking-widest text-brand-accent">Kurator AI Kriya</span>
                <h2 class="font-heading text-3xl md:text-4xl font-bold mt-2 text-brand-dark">Temukan Karya Kriya Sempurna Anda</h2>
                <div class="w-12 h-0.5 bg-brand-terracotta mx-auto mt-4"></div>
                <p class="text-xs text-gray-500 mt-3">Pilih preferensi Anda di bawah ini dan biarkan asisten cerdas kami memilih kerajinan terverifikasi dari perajin lokal.</p>
            </div>

            <!-- Main Interactive Card -->
            <div class="bg-[#FCFAF7]/90 backdrop-blur-md rounded-[2.5rem] border border-brand-beige shadow-xl p-8 md:p-12 space-y-12">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                    
                    <!-- Form Selectors (Left / Column 1) -->
                    <div class="lg:col-span-5 space-y-8">
                        <!-- Budget Input -->
                        <div>
                            <label class="block text-xs font-extrabold uppercase text-brand-dark tracking-wider mb-4 flex justify-between items-center">
                                <span>1. Pilih Anggaran Maksimal</span>
                                <span class="text-brand-terracotta font-bold text-xs" x-show="aiBudget" x-text="'Rp ' + Number(aiBudget).toLocaleString('id-ID')"></span>
                            </label>
                            
                            <!-- Budget Presets Grid -->
                            <div class="grid grid-cols-3 gap-3 mb-4">
                                <button @click="aiBudget = 100000" :class="aiBudget == 100000 ? 'bg-brand-terracotta text-white border-brand-terracotta shadow-sm' : 'bg-brand-cream/40 border-brand-beige text-brand-dark hover:bg-brand-cream/70'" class="border py-4 rounded-2xl text-xs sm:text-sm font-extrabold transition-all text-center hover:scale-[1.02] active:scale-[0.98]">
                                    &lt; Rp 100k
                                </button>
                                <button @click="aiBudget = 250000" :class="aiBudget == 250000 ? 'bg-brand-terracotta text-white border-brand-terracotta shadow-sm' : 'bg-brand-cream/40 border-brand-beige text-brand-dark hover:bg-brand-cream/70'" class="border py-4 rounded-2xl text-xs sm:text-sm font-extrabold transition-all text-center hover:scale-[1.02] active:scale-[0.98]">
                                    Rp 100k - 250k
                                </button>
                                <button @click="aiBudget = 500000" :class="aiBudget == 500000 ? 'bg-brand-terracotta text-white border-brand-terracotta shadow-sm' : 'bg-brand-cream/40 border-brand-beige text-brand-dark hover:bg-brand-cream/70'" class="border py-4 rounded-2xl text-xs sm:text-sm font-extrabold transition-all text-center hover:scale-[1.02] active:scale-[0.98]">
                                    Rp 250k - 500k
                                </button>
                            </div>
                            
                            <!-- Custom Budget Input -->
                            <div class="relative flex items-center">
                                <span class="absolute left-4 text-sm font-bold text-brand-accent">Rp</span>
                                <input type="number" x-model="aiBudget" class="w-full bg-brand-cream/30 border border-brand-beige text-brand-dark rounded-2xl py-4 px-5 text-sm font-bold outline-none focus:border-brand-terracotta focus:bg-white pl-11 transition-all shadow-sm" placeholder="Masukkan harga maksimal kustom...">
                            </div>
                        </div>

                        <!-- Art Style Input -->
                        <div>
                            <label class="block text-xs font-extrabold uppercase text-brand-dark tracking-wider mb-4">
                                2. Pilih Gaya Estetika
                            </label>
                            
                            <!-- Style List Select -->
                            <div class="grid grid-cols-2 gap-3">
                                <button @click="aiStyle = 'minimalis'" :class="aiStyle === 'minimalis' ? 'bg-brand-terracotta text-white border-brand-terracotta shadow-md' : 'bg-brand-cream/40 border-brand-beige text-brand-dark hover:bg-brand-cream/70'" class="border py-3.5 px-4 rounded-2xl text-xs sm:text-sm font-extrabold transition-all flex flex-col items-center justify-center gap-2 hover:scale-[1.02] active:scale-[0.98]">
                                    <span>Wabi-Sabi (Minimalis)</span>
                                </button>
                                <button @click="aiStyle = 'etnik'" :class="aiStyle === 'etnik' ? 'bg-brand-terracotta text-white border-brand-terracotta shadow-md' : 'bg-brand-cream/40 border-brand-beige text-brand-dark hover:bg-brand-cream/70'" class="border py-3.5 px-4 rounded-2xl text-xs sm:text-sm font-extrabold transition-all flex flex-col items-center justify-center gap-2 hover:scale-[1.02] active:scale-[0.98]">
                                    <span>Etnik</span>
                                </button>
                                <button @click="aiStyle = 'bohemian'" :class="aiStyle === 'bohemian' ? 'bg-brand-terracotta text-white border-brand-terracotta shadow-md' : 'bg-brand-cream/40 border-brand-beige text-brand-dark hover:bg-brand-cream/70'" class="border py-3.5 px-4 rounded-2xl text-xs sm:text-sm font-extrabold transition-all flex flex-col items-center justify-center gap-2 hover:scale-[1.02] active:scale-[0.98]">
                                    <span>Bohemian</span>
                                </button>
                                <button @click="aiStyle = 'vintage'" :class="aiStyle === 'vintage' ? 'bg-brand-terracotta text-white border-brand-terracotta shadow-md' : 'bg-brand-cream/40 border-brand-beige text-brand-dark hover:bg-brand-cream/70'" class="border py-3.5 px-4 rounded-2xl text-xs sm:text-sm font-extrabold transition-all flex flex-col items-center justify-center gap-2 hover:scale-[1.02] active:scale-[0.98]">
                                    <span>Vintage</span>
                                </button>
                                <button @click="aiStyle = 'cute'" :class="aiStyle === 'cute' ? 'bg-brand-terracotta text-white border-brand-terracotta shadow-md' : 'bg-brand-cream/40 border-brand-beige text-brand-dark hover:bg-brand-cream/70'" class="border py-3.5 px-4 rounded-2xl text-xs sm:text-sm font-extrabold transition-all flex flex-col items-center justify-center gap-2 col-span-2 hover:scale-[1.02] active:scale-[0.98]">
                                    <span>Lucu & Menggemaskan</span>
                                </button>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <button @click="getAiRecommendations()"
                                :disabled="aiLoading || !aiBudget"
                                class="w-full btn-gradient text-white py-5 rounded-2xl font-extrabold text-sm hover:shadow-xl hover:shadow-brand-terracotta/20 transition-all flex items-center justify-center gap-2.5 uppercase tracking-widest hover:scale-[1.01] active:scale-[0.99]">
                            <template x-if="aiLoading">
                                <span class="animate-spin border-2 border-white border-t-transparent w-4 h-4 rounded-full"></span>
                            </template>
                            <span x-text="aiLoading ? 'Mengurasi Rekomendasi...' : 'Pindai Katalog dengan Kurator AI'"></span>
                        </button>
                    </div>

                    <!-- Display Panel (Right / Column 2) -->
                    <div class="lg:col-span-7 bg-gradient-to-br from-[#FAF5EE] via-[#F4EBE0] to-[#EBDDCB] border border-brand-beige/85 rounded-[2.5rem] p-8 flex flex-col justify-center min-h-[350px] relative overflow-hidden shadow-inner">
                        
                        <!-- Artisan Mandala Watermark SVG -->
                        <svg class="absolute inset-0 w-full h-full text-brand-terracotta/[0.035] pointer-events-none p-6" fill="none" stroke="currentColor" viewBox="0 0 100 100">
                            <circle cx="50" cy="50" r="45" stroke-width="0.35"/>
                            <circle cx="50" cy="50" r="38" stroke-width="0.35" stroke-dasharray="1,1"/>
                            <circle cx="50" cy="50" r="30" stroke-width="0.35"/>
                            <circle cx="50" cy="50" r="22" stroke-width="0.35" stroke-dasharray="0.75,0.75"/>
                            <circle cx="50" cy="50" r="14" stroke-width="0.35"/>
                            <line x1="50" y1="5" x2="50" y2="95" stroke-width="0.25" stroke-dasharray="1,2"/>
                            <line x1="5" y1="50" x2="95" y2="50" stroke-width="0.25" stroke-dasharray="1,2"/>
                            <path d="M15,15 L85,85" stroke-width="0.15"/>
                            <path d="M85,15 L15,85" stroke-width="0.15"/>
                        </svg>

                        <!-- Initial Placeholder -->
                        <div x-show="!aiSearched && !aiLoading" class="text-center py-10 space-y-4 relative z-10">
                            <!-- Premium Icon Badge -->
                            <div class="w-16 h-16 rounded-full bg-brand-terracotta/10 border border-brand-terracotta/20 flex items-center justify-center mx-auto mb-4 shadow-sm">
                                <svg class="w-8 h-8 text-brand-terracotta" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                            </div>
                            <div class="text-2xl font-heading font-extrabold text-brand-terracotta tracking-widest">CRAFTIVE AI</div>
                            <h3 class="font-heading font-bold text-brand-dark text-xl mt-1">Asisten AI Anda Siap Membantu</h3>
                            <p class="text-xs text-brand-dark/75 max-w-sm mx-auto leading-relaxed">Pilih batas anggaran dan gaya kriya pilihan Anda di kiri, lalu klik <strong>Pindai</strong> untuk menemukan karya kriya Nusantara yang paling cocok.</p>
                        </div>

                        <!-- Loading Indicator -->
                        <div x-show="aiLoading" class="text-center py-10 space-y-4">
                            <div class="w-14 h-14 rounded-full border-4 border-brand-terracotta border-t-transparent animate-spin mx-auto"></div>
                            <p class="text-xs text-brand-accent font-bold uppercase tracking-wider animate-pulse">Menganalisis katalog sanggar perajin lokal...</p>
                        </div>

                        <!-- Results List -->
                        <div x-show="aiResults.length > 0 && !aiLoading" class="space-y-4">
                            <div class="flex items-center justify-between border-b border-brand-beige/55 pb-3">
                                <span class="text-[10px] font-extrabold uppercase text-brand-accent tracking-widest">Karya Pilihan Kurator AI:</span>
                                <span class="text-[10px] bg-brand-terracotta/10 text-brand-terracotta font-extrabold px-3 py-1 rounded-full uppercase" x-text="aiResults.length + ' Karya Ditemukan'"></span>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <template x-for="rec in aiResults" :key="rec.id">
                                    <div class="bg-white border border-brand-beige rounded-2xl p-4 flex flex-col justify-between shadow-sm hover:shadow-md transition-all group">
                                        <div>
                                            <div class="relative bg-brand-cream border border-brand-beige rounded-xl h-28 overflow-hidden mb-3.5">
                                                <template x-if="rec.image_url">
                                                    <img :src="rec.image_url" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" :alt="rec.name">
                                                </template>
                                                <template x-if="!rec.image_url">
                                                    <div class="w-full h-full flex items-center justify-center text-xs uppercase tracking-widest text-brand-dark/40 font-bold bg-brand-cream">Tidak Ada Gambar</div>
                                                </template>
                                                <span class="absolute top-2 right-2 bg-brand-gold text-brand-dark text-[8px] font-extrabold px-2 py-0.5 rounded shadow" x-text="rec.match"></span>
                                            </div>
                                            <h4 class="font-heading font-bold text-brand-dark text-xs truncate group-hover:text-brand-terracotta transition-colors" x-text="rec.name"></h4>
                                            <p class="text-brand-terracotta text-xs font-bold mt-1" x-text="'Rp ' + Number(rec.price).toLocaleString('id-ID')"></p>
                                        </div>
                                        <a :href="'<?php echo e(url('/products')); ?>/' + rec.id" class="mt-4 block text-center bg-brand-dark hover:bg-brand-terracotta text-white py-2 rounded-xl text-[10px] font-bold transition-all uppercase tracking-wider">
                                            Lihat Detail Produk &rarr;
                                        </a>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Empty State -->
                        <div x-show="aiResults.length === 0 && !aiLoading && aiSearched" class="text-center py-10 space-y-3">
                            <h4 class="font-bold text-brand-dark text-sm">Produk Tidak Ditemukan</h4>
                            <p class="text-xs text-gray-500 max-w-xs mx-auto leading-relaxed">Coba naikkan batas anggaran Anda atau pilih kombinasi gaya estetika lain.</p>
                            <button @click="aiBudget = ''; aiStyle = ''; aiResults = []; aiSearched = false;" class="text-xs text-brand-terracotta font-bold underline hover:text-brand-terracotta-light">Atur Ulang Pilihan Filter</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- ── SECTION: SOROTAN MAESTRO KRIYA (Artisan Spotlight) ── -->
    <section class="py-24 bg-gradient-to-b from-brand-cream/60 via-[#F3ECE0]/40 to-brand-cream/60 border-t border-brand-beige relative overflow-hidden" x-data="maestroSpotlight">
        <div class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(rgba(46,26,17,0.015)_1.5px,transparent_1.5px)] bg-[size:24px_24px] pointer-events-none"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-xs font-bold uppercase tracking-widest text-brand-accent">Maestro Perajin</span>
                <h2 class="font-heading text-3xl md:text-4xl font-bold mt-2 text-brand-dark">Sorotan Maestro Perajin Indonesia</h2>
                <div class="w-12 h-0.5 bg-brand-terracotta mx-auto mt-4"></div>
                <p class="text-xs text-gray-500 mt-3">Menghadirkan karya legendaris dari maestro perajin terbaik, sangat dicari dan dicintai kolektor nasional.</p>
            </div>

            <!-- Showcase Box: Large Magazine Spread -->
            <div class="artisan-card rounded-[2.5rem] p-8 md:p-12 flex flex-col lg:flex-row items-stretch gap-12 bg-[#FCFAF7]/90">
                <!-- Left Side: Bio & Portrait -->
                <div class="lg:w-2/5 flex flex-col justify-between gap-6 border-b lg:border-b-0 lg:border-r border-brand-beige/50 pb-8 lg:pb-0 lg:pr-8">
                    <div>
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-16 h-16 rounded-full bg-brand-beige border-2 border-brand-terracotta/30 overflow-hidden shadow-inner">
                                <img src="https://images.unsplash.com/photo-1541832676-9b763b0239ab?w=300&auto=format&fit=crop" class="w-full h-full object-cover grayscale contrast-125" alt="Bu Kartini">
                            </div>
                            <div>
                                <h3 class="font-heading font-extrabold text-brand-dark text-xl">Bu Kartini</h3>
                                <span class="text-[10px] bg-brand-terracotta/10 text-brand-terracotta font-extrabold px-3 py-1 rounded-full uppercase tracking-wider">Maestro Terverifikasi</span>
                            </div>
                        </div>
                        
                        <h4 class="font-heading italic text-lg text-brand-accent mb-4">"Batik adalah doa yang ditulis dengan canting di atas kain suci..."</h4>
                        <p class="text-xs text-gray-600 leading-relaxed mb-6">
                            Bu Kartini adalah perajin batik tulis generasi ketiga dari Kampung Batik Laweyan, Solo. Menggunakan canting tembaga dan resep warisan alami dari kayu secang dan kulit manggis, karya-karyanya terkenal dengan detail yang sangat halus dan sangat dicari oleh para kolektor.
                        </p>
                    </div>
                    
                    <div class="flex items-center justify-between border-t border-brand-beige/30 pt-6">
                       <div>
                           <div class="text-[9px] uppercase tracking-wider text-gray-400 font-bold">Asal Perajin</div>
                           <div class="text-xs font-bold text-brand-dark">Solo, Jawa Tengah</div>
                       </div>
                       <a href="<?php echo e(url('/products?style=Etnik')); ?>" class="font-bold text-xs uppercase tracking-wider text-brand-terracotta hover:underline">
                           Lihat Semua Kerajinan Etnik &rarr;
                       </a>
                    </div>
                </div>

                <!-- Right Side: Masterpieces Showcase -->
                <div class="lg:w-3/5">
                    <h4 class="font-heading font-bold text-brand-dark text-lg mb-6 flex items-center justify-between">
                        <span>Karya Legendaris Bu Kartini</span>
                        <span class="text-xs text-brand-gold">★ Terlaris</span>
                    </h4>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6" x-show="maestroProducts.length > 0">
                        <template x-for="p in maestroProducts" :key="p.id">
                            <div class="group artisan-card rounded-2xl p-4 bg-[#FFF] flex flex-col justify-between min-h-[300px]">
                                <div class="relative bg-brand-cream border border-brand-beige rounded-xl h-36 overflow-hidden mb-3">
                                    <img :src="p.image_url" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" :alt="p.name">
                                </div>
                                <div>
                                    <h5 class="font-heading font-bold text-brand-dark text-xs line-clamp-2" x-text="p.name">Karya</h5>
                                    <div class="text-[10px] text-brand-accent font-semibold mt-1">Rp <span x-text="Number(p.price).toLocaleString('id-ID')"></span></div>
                                </div>
                                <a :href="'<?php echo e(url('/products')); ?>/' + p.id" class="mt-3 block text-center bg-brand-dark hover:bg-brand-terracotta text-white py-2 rounded-lg text-[10px] font-bold transition-colors animate-pulse">
                                    Lihat Karya Seni
                                </a>
                            </div>
                        </template>
                    </div>
                    
                    <div x-show="maestroProducts.length === 0" class="py-12 text-center text-xs text-gray-400 font-semibold animate-pulse">
                        Menghubungkan ke Sanggar Bu Kartini...
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Top Products Grid: Gallery Exhibition Showcase -->
    <section class="py-24 bg-transparent border-t border-brand-beige relative overflow-hidden">
        <!-- Background light rays -->
        <div class="absolute top-1/4 left-10 w-[500px] h-[500px] rounded-full bg-brand-terracotta/5 blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-1/4 right-10 w-[400px] h-[400px] rounded-full bg-brand-gold/5 blur-3xl pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-16 flex-wrap gap-4 border-b border-brand-beige pb-6">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-brand-accent">Sorotan Karya Seni</span>
                    <h2 class="font-heading text-3xl md:text-4xl font-bold mt-2 text-brand-dark">Pilihan Kurator Terpopuler</h2>
                </div>
                <a href="<?php echo e(url('/products')); ?>" class="font-bold text-xs uppercase tracking-wider text-brand-terracotta hover:underline flex items-center gap-1">
                    Lihat Seluruh Katalog &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <template x-for="p in popularProducts" :key="p.id">
                    <div class="group artisan-card rounded-3xl p-5 hover:border-brand-terracotta hover:-translate-y-1.5 flex flex-col justify-between min-h-[420px]">
                        <div>
                            <!-- Image Container -->
                            <div class="relative bg-gradient-to-br from-[#FCFAF7] via-[#F5E5D5] to-[#E3C6AB] border border-brand-beige rounded-2xl h-52 flex items-center justify-center shadow-inner mb-5 overflow-hidden">
                                <template x-if="p.image_url">
                                    <img :src="p.image_url" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" :alt="p.name">
                                </template>
                                <template x-if="!p.image_url">
                                    <span class="text-xs uppercase tracking-widest text-brand-dark/40 font-bold">Tidak Ada Gambar</span>
                                </template>
                                <!-- Authenticity Seal -->
                                <span class="absolute top-12 right-2 authenticity-seal px-2 py-1 rounded shadow-md">Karya Orisinil</span>
                                <!-- Category Badge -->
                                <span class="absolute top-3 left-3 bg-brand-dark/95 backdrop-blur-sm text-brand-cream text-[9px] font-extrabold px-3 py-1 rounded-full uppercase tracking-wider shadow-sm" x-text="p.category.name">Category</span>
                                <!-- Handmade signature badge -->
                                <span class="absolute bottom-3 right-3 bg-brand-gold text-brand-dark text-[8px] font-extrabold px-2.5 py-0.5 rounded uppercase tracking-widest shadow-sm">100% Buatan Tangan</span>
                            </div>
                            
                            <!-- Product Name & Shop details -->
                            <h3 class="font-heading font-bold text-brand-dark text-lg leading-snug mb-1 group-hover:text-brand-terracotta transition-colors" x-text="p.name">Product Name</h3>
                            
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-xs text-brand-accent font-bold" x-text="p.shop.name">Shop Name</span>
                                <span class="text-gray-300">|</span>
                                <span class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider" x-text="p.shop.address || 'Indonesia'">Region</span>
                            </div>
                            
                            <p class="text-[11px] text-gray-500 line-clamp-2 mt-3 leading-relaxed" x-text="p.description">Short description.</p>
                        </div>
                        
                        <!-- Product Footer details -->
                        <div class="mt-6 pt-4 border-t border-brand-beige/50 flex justify-between items-center">
                            <div>
                                <div class="text-[9px] text-gray-400 font-bold uppercase tracking-wider">Harga Perajin</div>
                                <div class="text-brand-terracotta font-extrabold text-lg" x-text="'Rp ' + Number(p.price).toLocaleString('id-ID')">Rp 0</div>
                            </div>
                            <a :href="'<?php echo e(url('/products')); ?>/' + p.id" class="btn-gradient text-white p-3 rounded-xl hover:scale-105 transition-transform flex items-center justify-center shadow-md">
                                <span class="text-xs font-bold px-3">Detail Karya Seni &rarr;</span>
                            </a>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </section>

</div>

<script>
    document.addEventListener('alpine:init', () => {
        // Maestro Showcase Registration
        Alpine.data('maestroSpotlight', () => ({
            maestroProducts: [],
            async init() {
                try {
                    const response = await fetch('<?php echo e(url("/api/products?shop_id=2")); ?>', {
                        headers: { 'X-API-KEY': 'craftive-public-key-2026' }
                    });
                    const data = await response.json();
                    if (data && data.data) {
                        this.maestroProducts = data.data.slice(0, 3);
                    }
                } catch (error) {
                    console.error('Failed to load maestro products:', error);
                }
            }
        }));

        Alpine.data('homePage', () => ({
            popularProducts: [],
            aiBudget: '',
            aiStyle: '',
            aiLoading: false,
            aiResults: [],
            aiSearched: false,

            async init() {
                // Fetch best sellers on page load
                try {
                    const response = await fetch('<?php echo e(url("/api/products")); ?>', {
                        headers: { 'X-API-KEY': 'craftive-public-key-2026' }
                    });
                    const data = await response.json();
                    if (data && data.data) {
                        // Limit to top 3 products
                        this.popularProducts = data.data.slice(0, 3);
                    }
                } catch (error) {
                    console.error('Failed to load best seller products:', error);
                }
            },

            async getAiRecommendations() {
                this.aiLoading = true;
                this.aiSearched = true;
                this.aiResults = [];

                try {
                    const data = await window.apiFetch('/api/ai/recommend', {
                        method: 'POST',
                        body: JSON.stringify({
                            budget: this.aiBudget,
                            style: this.aiStyle
                        })
                    });

                    if (data && data.recommendations) {
                        this.aiResults = data.recommendations;
                    }
                } catch (error) {
                    console.error('Failed to fetch AI recommendations:', error);
                    window.addToast('warning', 'Gagal memuat rekomendasi AI. Silakan coba beberapa saat lagi.');
                } finally {
                    this.aiLoading = false;
                }
            }
        }));
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp1\htdocs\craftive\resources\views/pages/home.blade.php ENDPATH**/ ?>