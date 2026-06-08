<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRAFTIVE — From Their Hands to Your Heart</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,500;0,600;0,700;0,800;1,600&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            terracotta: '#C84B1E',       // Saturated, vibrant terracotta clay orange
                            'terracotta-light': '#F15A24', // Vivid terracotta orange
                            cream: '#EFE3D3',             // Rich warm clay cream (more premium contrast background)
                            dark: '#2E1A11',              // Coffee dark charcoal (rich brown)
                            accent: '#E06B3E',            // Bright rust orange
                            beige: '#E8D2C0',             // Rich oat beige for distinct borders
                            gold: '#DF9B00',              // Rich warm gold
                            clay: '#9E6B4E',              // Warm medium clay brown
                            'clay-light': '#C69E82'       // Soft sandy clay
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        heading: ['"Playfair Display"', 'serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        body {
            background-color: #EFE3D3;
            background-image: 
                radial-gradient(rgba(200, 75, 30, 0.16) 1.5px, transparent 1.5px),
                linear-gradient(to right, rgba(46, 26, 17, 0.05) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(46, 26, 17, 0.05) 1px, transparent 1px);
            background-size: 24px 24px, 48px 48px, 48px 48px;
            background-position: 0 0;
            color: #2E1A11;
            background-attachment: fixed;
        }
        .artisan-card {
            background: linear-gradient(135deg, #FFFDFC 0%, #F5EAE0 50%, #E5D5C5 100%);
            border: 1.5px solid rgba(46, 26, 17, 0.15);
            box-shadow: 0 8px 30px -4px rgba(46, 26, 17, 0.08);
            position: relative;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .artisan-card:hover {
            background: linear-gradient(135deg, #FFFDFC 0%, #EEDDC5 50%, #D7BEA5 100%);
            border-color: rgba(200, 75, 30, 0.5);
            box-shadow: 0 16px 40px -6px rgba(200, 75, 30, 0.2);
        }
        .artisan-card::before {
            content: '';
            position: absolute;
            top: 4px;
            left: 4px;
            right: 4px;
            bottom: 4px;
            border: 1px dashed rgba(46, 26, 17, 0.06);
            pointer-events: none;
            border-radius: inherit;
            z-index: 5;
        }
        .authenticity-seal {
            background: radial-gradient(circle, #FFF 60%, #FCF8F2 100%);
            border: 2px dashed #C84B1E;
            color: #C84B1E;
            font-family: 'Playfair Display', serif;
            font-weight: 800;
            text-transform: uppercase;
            font-size: 8px;
            letter-spacing: 0.1em;
            transform: rotate(-10deg);
            box-shadow: 0 4px 10px rgba(200, 75, 30, 0.15);
            z-index: 10;
        }
        .glass-nav {
            background: rgba(239, 227, 211, 0.88);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
        .text-gradient {
            background: linear-gradient(135deg, #F15A24, #C84B1E);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .btn-gradient {
            background: linear-gradient(135deg, #F15A24, #C84B1E);
        }
        .btn-gradient:hover {
            background: linear-gradient(135deg, #C84B1E, #2E1A11);
        }
        /* Premium borders */
        .artisan-border {
            border: 1px solid rgba(46, 26, 17, 0.15);
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #FCF8F2;
        }
        ::-webkit-scrollbar-thumb {
            background: #E8D2C0;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #C84B1E;
        }
    </style>
</head>
<body class="font-sans antialiased min-h-screen flex flex-col" x-data="globalApp">

    <!-- ── TOAST NOTIFICATIONS ── -->
    <div class="fixed bottom-5 right-5 z-50 flex flex-col gap-2 max-w-sm pointer-events-none">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-show="toast.show" 
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="translate-y-5 opacity-0"
                 x-transition:enter-end="translate-y-0 opacity-100"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="translate-y-0 opacity-100"
                 x-transition:leave-end="translate-y-2 opacity-0"
                 class="p-4 rounded-2xl shadow-xl flex items-center gap-3 border text-sm font-semibold pointer-events-auto transition-all"
                 :class="{
                     'bg-green-50 border-green-200 text-green-800': toast.type === 'success',
                     'bg-red-50 border-red-200 text-red-800': toast.type === 'error',
                     'bg-blue-50 border-blue-200 text-blue-800': toast.type === 'info',
                     'bg-amber-50 border-amber-200 text-amber-800': toast.type === 'warning'
                 }">
                 <span :class="toast.type === 'success' ? 'text-green-600' : (toast.type === 'error' ? 'text-red-600' : 'text-blue-600')">
                     <template x-if="toast.type === 'success'">✓</template>
                     <template x-if="toast.type === 'error'">✗</template>
                     <template x-if="toast.type !== 'success' && toast.type !== 'error'">i</template>
                 </span>
                <span x-text="toast.message"></span>
                <button @click="removeToast(toast.id)" class="ml-auto text-gray-400 hover:text-gray-600">&times;</button>
            </div>
        </template>
    </div>

    <!-- ── GLOBAL GLASS NAVIGATION BAR ── -->
    <nav class="fixed top-0 left-0 w-full z-40 border-b border-brand-beige/50 glass-nav transition-all duration-300">
        <!-- Top Announcement Bar -->
        <div class="bg-brand-dark text-brand-cream/95 text-center py-2.5 px-4 text-[10px] sm:text-xs font-semibold tracking-wider flex items-center justify-center gap-2 border-b border-brand-terracotta/25 shadow-sm">
             <span>✦</span>
            <span>Dukung Perajin Lokal: 100% Produk Seni Buatan Tangan Indonesia Asli</span>
            <span class="hidden md:inline bg-brand-terracotta text-white px-2 py-0.5 rounded text-[9px] uppercase font-bold tracking-widest ml-2">Karya Perajin</span>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-24 items-center">
                
                <!-- Brand/Logo -->
                <a href="{{ url('/') }}" class="flex items-center gap-4 group">
                    <img src="{{ asset('images/logo.png') }}" class="h-14 w-auto object-contain rounded-xl hover:scale-105 transition-transform duration-300" style="height: 56px !important; width: auto;" alt="Craftive Logo">
                    <div class="hidden sm:block">
                        <span class="font-heading font-extrabold text-3xl tracking-tight text-brand-dark group-hover:text-brand-terracotta transition-colors">Craftive<span class="text-brand-terracotta-light">.</span></span>
                        <div class="text-[10px] uppercase tracking-wider text-brand-accent font-bold">Dari Tangan Perajin ke Hati Anda</div>
                    </div>
                </a>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center gap-10 font-bold text-brand-dark/95 text-base">
                    <a href="{{ url('/') }}" class="hover:text-brand-terracotta transition-colors relative py-2 after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-brand-terracotta after:transition-all hover:after:w-full">Beranda</a>
                    <a href="{{ url('/products') }}" class="hover:text-brand-terracotta transition-colors relative py-2 after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-brand-terracotta after:transition-all hover:after:w-full">Produk</a>
                    <a href="{{ url('/') }}#kategori" class="hover:text-brand-terracotta transition-colors relative py-2 after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-brand-terracotta after:transition-all hover:after:w-full">Kategori</a>
                </div>

                <!-- Right Menu Buttons (Auth, Cart, Mobile Menu trigger) -->
                <div class="flex items-center gap-4">
                    
                    <!-- Cart Indicator (Visible if Buyer) -->
                    <template x-if="isLoggedIn && userRole === 'buyer'">
                        <a href="{{ url('/user/dashboard') }}#cart" class="relative bg-white/80 p-2.5 rounded-2xl hover:bg-brand-beige/20 transition-all border border-brand-beige flex items-center justify-center hover:scale-105 shadow-sm">
                             <span class="text-lg">
                                 <svg class="w-5 h-5 text-brand-dark hover:text-brand-terracotta transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                 </svg>
                             </span>
                            <span class="absolute -top-1.5 -right-1.5 bg-brand-terracotta-light text-white text-[10px] w-5 h-5 rounded-full flex items-center justify-center font-bold" x-text="cartCount">0</span>
                        </a>
                    </template>

                    <!-- Auth States -->
                    <div class="hidden md:flex items-center gap-4">
                        <!-- Guest State -->
                        <template x-if="!isLoggedIn">
                            <div class="flex items-center gap-4 font-bold text-base">
                                <a href="{{ route('login') }}" class="text-brand-dark hover:text-brand-terracotta py-2.5 px-6 transition-colors">Masuk</a>
                                <a href="{{ route('register') }}" class="btn-gradient text-white py-3.5 px-8 rounded-2xl transition-all hover:shadow-lg shadow-brand-terracotta/20 hover:-translate-y-0.5">Daftar</a>
                            </div>
                        </template>

                        <!-- Logged In State -->
                        <template x-if="isLoggedIn">
                            <div class="flex items-center gap-4 font-bold text-base" x-data="{ openProfile: false }">
                                <div class="relative">
                                    <button @click="openProfile = !openProfile" class="flex items-center gap-3 bg-white/80 border border-brand-beige rounded-2xl px-5 py-2.5 hover:bg-white hover:shadow-md transition-all">
                                        <template x-if="userAvatar">
                                            <img :src="userAvatar" class="w-9 h-9 rounded-full object-cover border border-brand-beige" alt="Avatar">
                                        </template>
                                        <template x-if="!userAvatar">
                                            <div class="w-9 h-9 rounded-full bg-brand-terracotta-light text-white flex items-center justify-center text-sm font-bold" x-text="userInitials">U</div>
                                        </template>
                                        <span class="text-brand-dark text-sm font-bold" x-text="userName">User</span>
                                        <span class="text-[10px] uppercase tracking-wider bg-brand-beige px-2 py-0.5 rounded-md text-brand-accent font-bold" x-text="userRole">ROLE</span>
                                    </button>
                                    <div x-show="openProfile" @click.away="openProfile = false" class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-xl border border-brand-beige p-2 z-50 flex flex-col gap-1">
                                         <a :href="getDashboardUrl()" class="px-4 py-2 hover:bg-brand-cream hover:text-brand-terracotta rounded-xl text-left transition-colors flex items-center gap-2">
                                             Dashboard
                                         </a>
                                        <hr class="border-brand-beige my-1">
                                         <button @click="logout()" class="px-4 py-2 hover:bg-red-50 text-red-600 rounded-xl text-left transition-colors flex items-center gap-2 font-semibold">
                                             Keluar
                                         </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Hamburger button for mobile -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden bg-white/80 p-2.5 rounded-2xl border border-brand-beige text-brand-dark hover:bg-brand-beige/20 transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Drawer menu -->
        <div x-show="mobileMenuOpen" x-transition class="md:hidden border-t border-brand-beige/50 px-4 py-6 bg-[#FDF6EE] flex flex-col gap-4 shadow-inner">
             <a href="{{ url('/') }}" class="font-bold text-brand-dark hover:text-brand-terracotta py-2">Beranda</a>
             <a href="{{ url('/products') }}" class="font-bold text-brand-dark hover:text-brand-terracotta py-2">Produk</a>
             <a href="{{ url('/') }}#kategori" class="font-bold text-brand-dark hover:text-brand-terracotta py-2">Kategori</a>
            
            <hr class="border-brand-beige my-1">
            
            <!-- Guest mobile view -->
            <template x-if="!isLoggedIn">
                <div class="flex flex-col gap-2 w-full">
                    <a href="{{ route('login') }}" class="w-full text-center border border-brand-terracotta text-brand-terracotta py-3 rounded-2xl font-bold">Masuk</a>
                    <a href="{{ route('register') }}" class="w-full text-center btn-gradient text-white py-3 rounded-2xl font-bold">Daftar</a>
                </div>
            </template>

            <!-- Logged in mobile view -->
            <template x-if="isLoggedIn">
                <div class="flex flex-col gap-2 w-full">
                    <div class="flex items-center gap-3 p-3 bg-white rounded-2xl border border-brand-beige">
                                        <template x-if="userAvatar">
                                            <img :src="userAvatar" class="w-10 h-10 rounded-full object-cover border border-brand-beige" alt="Avatar">
                                        </template>
                                        <template x-if="!userAvatar">
                                            <div class="w-10 h-10 rounded-full bg-brand-terracotta-light text-white flex items-center justify-center font-bold" x-text="userInitials">U</div>
                                        </template>
                        <div>
                            <div class="font-bold text-brand-dark text-sm" x-text="userName">User</div>
                            <div class="text-xs text-brand-accent uppercase tracking-wider font-semibold" x-text="userRole">Role</div>
                        </div>
                    </div>
                     <a :href="getDashboardUrl()" class="w-full text-center bg-white border border-brand-beige text-brand-dark py-3 rounded-2xl font-bold hover:bg-brand-cream">Dashboard</a>
                      <button @click="logout()" class="w-full text-center bg-red-50 text-red-600 py-3 rounded-2xl font-bold border border-red-100">Keluar</button>
                </div>
            </template>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="flex-grow pt-32 sm:pt-36">
        @yield('content')
    </main>

    <!-- ── FOOTER ── -->
    <footer class="bg-brand-dark text-brand-cream border-t border-brand-beige/10 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('images/logo.png') }}" class="h-10 w-auto object-contain rounded-xl bg-white/10 p-1" style="height: 40px !important; width: auto;" alt="Craftive Logo">
                        <div class="flex flex-col">
                            <span class="font-heading font-extrabold text-3xl text-brand-gold">Craftive<span class="text-brand-terracotta-light">.</span></span>
                            <span class="text-[9px] uppercase tracking-widest text-brand-cream/60 font-semibold italic mt-0.5">Dari Tangan Perajin ke Hati Anda</span>
                        </div>
                    </div>
                    <p class="text-brand-cream/70 mb-6 max-w-sm leading-relaxed">
                        Memberdayakan perajin lokal di seluruh Indonesia untuk menghadirkan kerajinan buatan tangan yang otentik langsung ke rumah Anda. Mulai dari tenun hingga keramik premium.
                    </p>
                    <!-- Redundant social box removed -->
                </div>
                <div>
                    <h3 class="font-semibold text-white mb-4 uppercase tracking-wider text-xs">Navigasi</h3>
                    <ul class="space-y-3 text-brand-cream/60 text-sm">
                        <li><a href="{{ url('/') }}" class="hover:text-brand-gold transition-colors font-semibold">Beranda</a></li>
                        <li><a href="{{ url('/products') }}" class="hover:text-brand-gold transition-colors font-semibold">Produk</a></li>
                        <li><a href="{{ url('/') }}#kategori" class="hover:text-brand-gold transition-colors font-semibold">Kategori</a></li>
                    </ul>
                </div>
                <div class="col-span-1">
                    <h3 class="font-semibold text-white mb-4 uppercase tracking-wider text-xs">Hubungi Kami</h3>
                    <div class="space-y-3">
                        <!-- Alamat -->
                        <div class="flex items-center gap-3 bg-gradient-to-br from-white to-[#F3EDE6] border border-white/20 p-3 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 group hover:-translate-y-0.5">
                            <span class="text-lg bg-brand-terracotta p-2.5 rounded-xl text-center flex items-center justify-center text-white shadow-sm group-hover:scale-105 transition-transform duration-300">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </span>
                            <div>
                                <div class="text-[9px] text-brand-dark/50 uppercase tracking-widest font-bold">Alamat</div>
                                <div class="text-xs text-brand-dark font-extrabold">Surabaya, Jawa Timur, Indonesia</div>
                            </div>
                        </div>

                        <!-- Email Resmi -->
                        <div class="flex items-center gap-3 bg-gradient-to-br from-white to-[#F3EDE6] border border-white/20 p-3 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 group hover:-translate-y-0.5">
                            <span class="text-lg bg-brand-terracotta p-2.5 rounded-xl text-center flex items-center justify-center text-white shadow-sm group-hover:scale-105 transition-transform duration-300">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 00-2 2z"></path>
                                </svg>
                            </span>
                            <div>
                                <div class="text-[9px] text-brand-dark/50 uppercase tracking-widest font-bold">Email Resmi</div>
                                <a href="mailto:support@craftive.id" class="text-xs text-brand-dark hover:text-brand-terracotta transition-colors font-extrabold">support@craftive.id</a>
                            </div>
                        </div>

                        <!-- Instagram -->
                        <div class="flex items-center gap-3 bg-gradient-to-br from-white to-[#F3EDE6] border border-white/20 p-3 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 group hover:-translate-y-0.5">
                            <span class="bg-brand-terracotta p-2.5 rounded-xl text-center flex items-center justify-center text-white shadow-sm group-hover:scale-105 transition-transform duration-300">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                    <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                                </svg>
                            </span>
                            <div>
                                <div class="text-[9px] text-brand-dark/50 uppercase tracking-widest font-bold">Instagram</div>
                                <a href="https://www.instagram.com/craftive26?igsh=MXU1Z3E3aXU2emNicw%3D%3D&utm_source=qr" target="_blank" rel="noopener noreferrer" class="text-xs text-brand-dark hover:text-brand-terracotta transition-colors font-extrabold">@craftive26</a>
                            </div>
                        </div>

                        <!-- TikTok -->
                        <div class="flex items-center gap-3 bg-gradient-to-br from-white to-[#F3EDE6] border border-white/20 p-3 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 group hover:-translate-y-0.5">
                            <span class="text-lg bg-brand-terracotta p-2.5 rounded-xl text-center flex items-center justify-center text-white shadow-sm group-hover:scale-105 transition-transform duration-300">
                                <svg class="w-4 h-4 text-white fill-current" viewBox="0 0 24 24">
                                    <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                                </svg>
                            </span>
                            <div>
                                <div class="text-[9px] text-brand-dark/50 uppercase tracking-widest font-bold">TikTok</div>
                                <a href="#" class="text-xs text-brand-dark hover:text-brand-terracotta transition-colors font-extrabold">@craftive.id</a>
                            </div>
                        </div>

                        <!-- WhatsApp -->
                        <div class="flex items-center gap-3 bg-gradient-to-br from-white to-[#F3EDE6] border border-white/20 p-3 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 group hover:-translate-y-0.5">
                            <span class="text-lg bg-brand-terracotta p-2.5 rounded-xl text-center flex items-center justify-center text-white shadow-sm group-hover:scale-105 transition-transform duration-300">
                                <svg class="w-4 h-4 text-white fill-current" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.746.953 3.71 1.458 5.704 1.46h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                            </span>
                            <div>
                                <div class="text-[9px] text-brand-dark/50 uppercase tracking-widest font-bold">WhatsApp</div>
                                <a href="https://wa.me/6281234567890" target="_blank" rel="noopener noreferrer" class="text-xs text-brand-dark hover:text-brand-terracotta transition-colors font-extrabold">+62 812 3456 7890</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-brand-beige/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-brand-cream/40">
                <p>&copy; {{ date('Y') }} CRAFTIVE. Hak Cipta Dilindungi Undang-Undang. &middot; Proyek UAS Pemrograman API.</p>
                <div class="flex gap-4">
                    <a href="#" class="hover:text-brand-cream transition-colors">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-brand-cream transition-colors">Kebijakan Privasi</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- ── GLOBAL JS SETUP ── -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('globalApp', () => ({
                isLoggedIn: false,
                userName: '',
                userRole: '',
                userInitials: '',
                userAvatar: '',
                cartCount: 0,
                mobileMenuOpen: false,
                toasts: [],

                init() {
                    // Check auth state
                    this.checkAuth();
                    
                    // Listen to global events
                    window.addEventListener('auth-changed', () => this.checkAuth());
                    window.addEventListener('cart-updated', () => this.updateCartCount());
                    
                    // Expose apiFetch and addToast globally for nested Alpine components
                    window.apiFetch = this.apiFetch.bind(this);
                    window.addToast = this.addToast.bind(this);
                },

                checkAuth() {
                    const token = localStorage.getItem('jwt_token');
                    const user = JSON.parse(localStorage.getItem('user'));
                    
                    if (token && user) {
                        this.isLoggedIn = true;
                        this.userName = user.name;
                        this.userRole = user.role;
                        this.userInitials = user.name.split(' ').map(n => n[0]).join('').substring(0,2).toUpperCase();
                        this.userAvatar = user.avatar || '';
                        
                        if (user.role === 'buyer') {
                            this.updateCartCount();
                        }
                    } else {
                        this.isLoggedIn = false;
                        this.userName = '';
                        this.userRole = '';
                        this.userInitials = '';
                        this.userAvatar = '';
                        this.cartCount = 0;
                    }
                },

                async updateCartCount() {
                    if (!this.isLoggedIn || this.userRole !== 'buyer') return;
                    try {
                        const response = await this.apiFetch('/api/cart');
                        if (response && Array.isArray(response)) {
                            this.cartCount = response.reduce((total, item) => total + item.qty, 0);
                        }
                    } catch (error) {
                        console.error('Gagal mengambil keranjang:', error);
                    }
                },

                getDashboardUrl() {
                    if (this.userRole === 'admin') return '{{ url("/admin/dashboard") }}';
                    if (this.userRole === 'seller') return '{{ url("/seller/dashboard") }}';
                    return '{{ url("/user/dashboard") }}';
                },

                async logout() {
                    localStorage.removeItem('jwt_token');
                    localStorage.removeItem('user');
                    this.isLoggedIn = false;
                    
                    try {
                        await fetch('{{ url("/logout") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });
                    } catch (e) {
                        console.error('Logout session failed', e);
                    }

                    this.addToast('success', 'Successfully logged out.');
                    setTimeout(() => {
                        window.location.href = '{{ url("/") }}';
                    }, 500);
                },

                addToast(type, message) {
                    const id = Date.now();
                    this.toasts.push({ id, type, message, show: true });
                    setTimeout(() => {
                        this.removeToast(id);
                    }, 3000);
                },

                removeToast(id) {
                    const index = this.toasts.findIndex(t => t.id === id);
                    if (index !== -1) {
                        this.toasts[index].show = false;
                        setTimeout(() => {
                            this.toasts = this.toasts.filter(t => t.id !== id);
                        }, 300);
                    }
                },

                // Global API fetch wrapper
                async apiFetch(url, options = {}) {
                    const token = localStorage.getItem('jwt_token');
                    const headers = {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-API-KEY': 'craftive-public-key-2026', // Sesuai dengan ApiKeyMiddleware
                        ...options.headers
                    };

                    if (token) {
                        headers['Authorization'] = `Bearer ${token}`;
                    }

                    const fetchOptions = {
                        ...options,
                        headers
                    };

                    try {
                        const fullUrl = url.startsWith('http') ? url : `{{ url('') }}${url}`;
                        const response = await fetch(fullUrl, fetchOptions);
                        
                        if (response.status === 401) {
                            // Token expired or invalid
                            localStorage.removeItem('jwt_token');
                            localStorage.removeItem('user');
                            window.dispatchEvent(new CustomEvent('auth-changed'));
                            this.addToast('warning', 'Your session has expired. Please login again.');
                            throw new Error('Unauthorized');
                        }

                        if (!response.ok) {
                            const errData = await response.json().catch(() => ({}));
                            throw new Error(errData.message || `API error: ${response.status}`);
                        }

                        return await response.json();
                    } catch (error) {
                        console.error('Fetch error:', error);
                        throw error;
                    }
                }
            }));
        });
    </script>
</body>
</html>