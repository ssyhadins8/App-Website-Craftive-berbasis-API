<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun — Craftive</title>
    
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
                            terracotta: '#8B3A0F',
                            'terracotta-light': '#C1440E',
                            cream: '#EFE3D3',
                            dark: '#3D1C08',
                            accent: '#A0522D',
                            beige: '#F5E6D0',
                            gold: '#E9A800'
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
    </style>
</head>
<body class="font-sans min-h-screen flex items-center justify-center p-6 relative overflow-hidden" x-data="registerPage">

    <!-- Background blobs -->
    <div class="absolute -top-40 -left-40 w-96 h-96 rounded-full bg-brand-terracotta/10 blur-3xl"></div>
    <div class="absolute -bottom-40 -right-40 w-96 h-96 rounded-full bg-brand-gold/10 blur-3xl"></div>

    <!-- Register Container -->
    <div class="bg-[#FCFAF7]/95 rounded-3xl border border-brand-beige shadow-2xl p-8 max-w-md w-full relative z-10">
        
        <!-- Logo & Header -->
        <div class="text-center mb-6">
            <a href="<?php echo e(url('/')); ?>" class="inline-flex flex-col items-center gap-2">
                <img src="<?php echo e(asset('images/logo.png')); ?>" class="h-16 w-auto object-contain rounded-2xl mb-2" style="height: 64px !important; width: auto;" alt="Craftive Logo">
                <span class="font-heading font-extrabold text-3xl text-brand-dark hover:text-brand-terracotta transition-colors">Craftive<span class="text-brand-terracotta-light">.</span></span>
            </a>
            <h2 class="text-xl font-bold mt-4 text-brand-dark">Daftar Akun Baru</h2>
            <p class="text-xs text-gray-500 mt-1">Bergabung dengan komunitas pengrajin dan pecinta seni</p>
        </div>

        <!-- Alert messages -->
        <div x-show="errorMessage" x-text="errorMessage" class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 text-xs font-semibold rounded-2xl" style="display: none;"></div>
        <div x-show="successMessage" x-text="successMessage" class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 text-xs font-semibold rounded-2xl" style="display: none;"></div>

        <!-- Form -->
        <form @submit.prevent="submitRegister">
            <div class="mb-4">
                <label class="block text-xs font-bold uppercase tracking-wider text-brand-accent mb-2">Nama Lengkap</label>
                <input type="text" x-model="name" class="w-full bg-white border border-brand-beige rounded-2xl p-3 text-sm outline-none focus:border-brand-terracotta transition-colors shadow-inner" placeholder="Masukkan nama lengkap Anda" required>
            </div>

            <div class="mb-4">
                <label class="block text-xs font-bold uppercase tracking-wider text-brand-accent mb-2">Email</label>
                <input type="email" x-model="email" class="w-full bg-white border border-brand-beige rounded-2xl p-3 text-sm outline-none focus:border-brand-terracotta transition-colors shadow-inner" placeholder="you@email.com" required>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-brand-accent mb-2">Sandi</label>
                    <input type="password" x-model="password" class="w-full bg-white border border-brand-beige rounded-2xl p-3 text-sm outline-none focus:border-brand-terracotta transition-colors shadow-inner" placeholder="Min. 6 karakter" required>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-brand-accent mb-2">Konfirmasi</label>
                    <input type="password" x-model="password_confirmation" class="w-full bg-white border border-brand-beige rounded-2xl p-3 text-sm outline-none focus:border-brand-terracotta transition-colors shadow-inner" placeholder="Ulangi sandi" required>
                </div>
            </div>

            <!-- Role Selection -->
            <div class="mb-6">
                <label class="block text-xs font-bold uppercase tracking-wider text-brand-accent mb-2">Tipe Akun</label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="border border-brand-beige rounded-2xl p-3 flex items-center justify-center gap-2 cursor-pointer transition-all hover:bg-brand-cream/50"
                           :class="role === 'buyer' ? 'border-brand-terracotta bg-brand-cream text-brand-terracotta font-bold' : 'bg-white text-gray-500'">
                        <input type="radio" value="buyer" x-model="role" class="hidden">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        <span>Pembeli</span>
                    </label>
                    <label class="border border-brand-beige rounded-2xl p-3 flex items-center justify-center gap-2 cursor-pointer transition-all hover:bg-brand-cream/50"
                           :class="role === 'seller' ? 'border-brand-terracotta bg-brand-cream text-brand-terracotta font-bold' : 'bg-white text-gray-500'">
                        <input type="radio" value="seller" x-model="role" class="hidden">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span>Penjual</span>
                    </label>
                </div>
            </div>

            <!-- Register Action -->
            <button type="submit" 
                    :disabled="loading"
                    class="w-full bg-gradient-to-r from-brand-terracotta-light to-brand-terracotta text-white py-3.5 rounded-2xl font-bold text-sm hover:opacity-95 hover:shadow-lg transition-all flex items-center justify-center gap-2 shadow-brand-terracotta/20">
                <span x-show="loading" class="animate-spin border-2 border-white border-t-transparent w-4 h-4 rounded-full"></span>
                <span x-text="loading ? 'Memproses...' : 'Daftarkan Akun'"></span>
            </button>
        </form>

        <div class="my-5 flex items-center gap-3">
            <div class="flex-grow h-px bg-brand-beige/50"></div>
            <span class="text-[10px] uppercase font-bold text-gray-400">Atau</span>
            <div class="flex-grow h-px bg-brand-beige/50"></div>
        </div>

        <!-- Login Link -->
        <p class="text-center text-xs text-brand-dark/80">
            Sudah punya akun? 
            <a href="<?php echo e(route('login')); ?>" class="font-bold text-brand-terracotta hover:underline">Masuk Sekarang</a>
        </p>
    </div>

    <!-- Script Page -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('registerPage', () => ({
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                role: 'buyer',
                loading: false,
                errorMessage: '',
                successMessage: '',

                init() {
                    // Check URL parameter for role setup
                    const urlParams = new URLSearchParams(window.location.search);
                    const paramRole = urlParams.get('role');
                    if (paramRole === 'seller' || paramRole === 'buyer') {
                        this.role = paramRole;
                    }
                },

                async submitRegister() {
                    if (this.password !== this.password_confirmation) {
                        this.errorMessage = 'Konfirmasi sandi tidak sesuai.';
                        return;
                    }

                    this.loading = true;
                    this.errorMessage = '';
                    this.successMessage = '';

                    try {
                        const response = await fetch('<?php echo e(url("/api/auth/register")); ?>', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-API-KEY': 'craftive-public-key-2026'
                            },
                            body: JSON.stringify({
                                name: this.name,
                                email: this.email,
                                password: this.password,
                                password_confirmation: this.password_confirmation,
                                role: this.role
                            })
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            // Validation details parsing
                            const errMessage = data.message || 'Registrasi gagal. Cek kembali data Anda.';
                            throw new Error(errMessage);
                        }

                        // Save details to localStorage
                        localStorage.setItem('jwt_token', data.token);
                        localStorage.setItem('user', JSON.stringify(data.user));

                        this.successMessage = 'Registrasi berhasil! Mengalihkan...';

                        // Notify layout of auth state change
                        window.dispatchEvent(new CustomEvent('auth-changed'));

                        // Sync session
                        await fetch('<?php echo e(url("/register")); ?>', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                            },
                            body: JSON.stringify({
                                name: this.name,
                                email: this.email,
                                password: this.password,
                                password_confirmation: this.password_confirmation,
                                role: this.role
                            })
                        });

                        setTimeout(() => {
                            if (data.user.role === 'seller') {
                                window.location.href = '<?php echo e(url("/seller/dashboard")); ?>';
                            } else {
                                window.location.href = '<?php echo e(url("/user/dashboard")); ?>';
                            }
                        }, 1000);

                    } catch (error) {
                        this.errorMessage = error.message;
                    } finally {
                        this.loading = false;
                    }
                }
            }));
        });
    </script>
</body>
</html>
<?php /**PATH C:\xampp1\htdocs\craftive\resources\views/auth/register.blade.php ENDPATH**/ ?>