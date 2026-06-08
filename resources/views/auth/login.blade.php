<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — Craftive</title>
    
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
<body class="font-sans min-h-screen flex items-center justify-center p-6 relative overflow-hidden" x-data="loginPage">

    <!-- Background blobs -->
    <div class="absolute -top-40 -left-40 w-96 h-96 rounded-full bg-brand-terracotta/10 blur-3xl"></div>
    <div class="absolute -bottom-40 -right-40 w-96 h-96 rounded-full bg-brand-gold/10 blur-3xl"></div>

    <!-- Login Container -->
    <div class="bg-[#FCFAF7]/95 rounded-3xl border border-brand-beige shadow-2xl p-8 max-w-md w-full relative z-10">
        
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="inline-flex flex-col items-center gap-2">
                <img src="{{ asset('images/logo.png') }}" class="h-16 w-auto object-contain rounded-2xl mb-2" style="height: 64px !important; width: auto;" alt="Craftive Logo">
                <span class="font-heading font-extrabold text-3xl text-brand-dark hover:text-brand-terracotta transition-colors">Craftive<span class="text-brand-terracotta-light">.</span></span>
            </a>
            <h2 class="text-xl font-bold mt-4 text-brand-dark">Selamat Datang Kembali</h2>
            <p class="text-xs text-gray-500 mt-1">Masuk untuk menikmati pengalaman kerajinan tangan autentik</p>
        </div>

        <!-- Alert messages -->
        <div x-show="errorMessage" x-text="errorMessage" class="mb-5 p-4 bg-red-50 border border-red-200 text-red-700 text-xs font-semibold rounded-2xl" style="display: none;"></div>
        <div x-show="successMessage" x-text="successMessage" class="mb-5 p-4 bg-green-50 border border-green-200 text-green-700 text-xs font-semibold rounded-2xl" style="display: none;"></div>

        <!-- Form -->
        <form @submit.prevent="submitLogin">
            <div class="mb-5">
                <label class="block text-xs font-bold uppercase tracking-wider text-brand-accent mb-2">Email</label>
                <input type="email" x-model="email" class="w-full bg-white border border-brand-beige rounded-2xl p-3.5 text-sm outline-none focus:border-brand-terracotta transition-colors shadow-inner" placeholder="siti@craftive.id (buyer) / suwito@craftive.id (seller)" required>
            </div>
            
            <div class="mb-6">
                <div class="flex justify-between items-center mb-2">
                    <label class="text-xs font-bold uppercase tracking-wider text-brand-accent">Password</label>
                    <a href="#" @click.prevent="openForgotModal" class="text-xs text-brand-terracotta hover:underline font-semibold">Lupa sandi?</a>
                </div>
                <input type="password" x-model="password" class="w-full bg-white border border-brand-beige rounded-2xl p-3.5 text-sm outline-none focus:border-brand-terracotta transition-colors shadow-inner" placeholder="Masukkan password Anda" required>
            </div>

            <!-- Login Action -->
            <button type="submit" 
                    :disabled="loading"
                    class="w-full bg-gradient-to-r from-brand-terracotta-light to-brand-terracotta text-white py-4 rounded-2xl font-bold text-sm hover:opacity-95 hover:shadow-lg transition-all flex items-center justify-center gap-2 shadow-brand-terracotta/20">
                <span x-show="loading" class="animate-spin border-2 border-white border-t-transparent w-4 h-4 rounded-full"></span>
                <span x-text="loading ? 'Memproses...' : 'Masuk ke Akun'"></span>
            </button>
        </form>

        <div class="my-6 flex items-center gap-3">
            <div class="flex-grow h-px bg-brand-beige/50"></div>
            <span class="text-[10px] uppercase font-bold text-gray-400">Atau</span>
            <div class="flex-grow h-px bg-brand-beige/50"></div>
        </div>

        <!-- Register Link -->
        <p class="text-center text-xs text-brand-dark/80">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="font-bold text-brand-terracotta hover:underline">Daftar Sekarang</a>
        </p>
        
        {{-- HIDE DEV NOTES FROM LECTURER
        <!-- Dev Note -->
        <div class="mt-8 p-3 bg-brand-cream border border-brand-beige rounded-2xl text-[10px] text-brand-accent/80 font-medium">
            <strong>Info Akun Uji Coba:</strong><br>
            • Buyer: <code>siti@craftive.id</code> | password: <code>password</code><br>
            • Seller: <code>suwito@craftive.id</code> | password: <code>password</code><br>
            • Admin: <code>admin@craftive.id</code> | password: <code>password</code>
        </div>
        --}}
    </div>

    <!-- Script Page -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('loginPage', () => ({
                email: '',
                password: '',
                loading: false,
                errorMessage: '',
                successMessage: '',

                // Forgot Password Modal State
                showForgotModal: false,
                forgotStep: 1,
                forgotEmail: '',
                forgotOtp: '',
                forgotNewPassword: '',
                forgotNewPasswordConfirm: '',
                forgotLoading: false,
                forgotError: '',
                forgotSuccess: '',
                demoOtpCode: '',
                showDemoBanner: false,

                openForgotModal() {
                    this.showForgotModal = true;
                    this.forgotStep = 1;
                    this.forgotEmail = '';
                    this.forgotOtp = '';
                    this.forgotNewPassword = '';
                    this.forgotNewPasswordConfirm = '';
                    this.forgotError = '';
                    this.forgotSuccess = '';
                    this.demoOtpCode = '';
                    this.showDemoBanner = false;
                },

                closeForgotModal() {
                    this.showForgotModal = false;
                },

                async sendOtp() {
                    this.forgotLoading = true;
                    this.forgotError = '';
                    this.forgotSuccess = '';
                    this.demoOtpCode = '';
                    this.showDemoBanner = false;

                    try {
                        const response = await fetch('{{ url("/api/auth/forgot-password") }}', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-API-KEY': 'craftive-public-key-2026'
                            },
                            body: JSON.stringify({
                                email: this.forgotEmail
                            })
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            throw new Error(data.message || 'Gagal mengirim kode OTP.');
                        }

                        if (data.demo_mode) {
                            this.demoOtpCode = data.otp_demo;
                            this.showDemoBanner = true;
                            this.forgotSuccess = 'Mode Demo Aktif: Kode OTP berhasil digenerate di backend.';
                        } else {
                            this.forgotSuccess = data.message;
                        }

                        setTimeout(() => {
                            this.forgotStep = 2;
                            this.forgotSuccess = '';
                        }, 1500);

                    } catch (error) {
                        this.forgotError = error.message;
                    } finally {
                        this.forgotLoading = false;
                    }
                },

                async resetPassword() {
                    this.forgotLoading = true;
                    this.forgotError = '';
                    this.forgotSuccess = '';

                    try {
                        const response = await fetch('{{ url("/api/auth/reset-password") }}', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-API-KEY': 'craftive-public-key-2026'
                            },
                            body: JSON.stringify({
                                email: this.forgotEmail,
                                otp: this.forgotOtp,
                                password: this.forgotNewPassword,
                                password_confirmation: this.forgotNewPasswordConfirm
                            })
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            throw new Error(data.error || data.message || 'Gagal mereset kata sandi.');
                        }

                        this.forgotSuccess = data.message;
                        this.successMessage = 'Kata sandi berhasil diubah! Silakan login.';

                        setTimeout(() => {
                            this.closeForgotModal();
                        }, 1500);

                    } catch (error) {
                        this.forgotError = error.message;
                    } finally {
                        this.forgotLoading = false;
                    }
                },

                async submitLogin() {
                    this.loading = true;
                    this.errorMessage = '';
                    this.successMessage = '';

                    try {
                        const response = await fetch('{{ url("/api/auth/login") }}', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-API-KEY': 'craftive-public-key-2026'
                            },
                            body: JSON.stringify({
                                email: this.email,
                                password: this.password
                            })
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            throw new Error(data.error || 'Autentikasi gagal. Email atau password salah.');
                        }

                        // Save details to localStorage
                        localStorage.setItem('jwt_token', data.access_token);
                        localStorage.setItem('user', JSON.stringify(data.user));

                        this.successMessage = 'Berhasil masuk! Mengalihkan ke dashboard...';

                        // Notify layout of auth state change
                        window.dispatchEvent(new CustomEvent('auth-changed'));

                        // Session bridge (OPTIONAL for standard session-based web guard routes)
                        // If we want web session to also exist, we call the local session login endpoint
                        const sessionResponse = await fetch('{{ url("/login") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                email: this.email,
                                password: this.password
                            })
                        });

                        setTimeout(() => {
                            if (data.user.role === 'admin') {
                                window.location.href = '{{ url("/admin/dashboard") }}';
                            } else if (data.user.role === 'seller') {
                                window.location.href = '{{ url("/seller/dashboard") }}';
                            } else {
                                window.location.href = '{{ url("/user/dashboard") }}';
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

    <!-- Forgot Password Modal -->
    <div x-show="showForgotModal" 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-brand-dark/60 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         style="display: none;">
        
        <div class="bg-[#FCFAF7] rounded-3xl border border-brand-beige shadow-2xl p-8 max-w-md w-full relative" @click.away="closeForgotModal">
            
            <!-- Close Button -->
            <button @click="closeForgotModal" class="absolute top-4 right-4 text-gray-400 hover:text-brand-terracotta transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <!-- Modal Header -->
            <div class="text-center mb-6">
                <h3 class="text-xl font-heading font-extrabold text-brand-dark">Atur Ulang Kata Sandi</h3>
                <p class="text-xs text-gray-500 mt-1" x-text="forgotStep === 1 ? 'Masukkan email terdaftar Anda untuk menerima kode OTP' : 'Masukkan kode OTP dan kata sandi baru Anda'"></p>
            </div>

            <!-- Error/Success Inside Modal -->
            <div x-show="forgotError" x-text="forgotError" class="mb-4 p-3.5 bg-red-50 border border-red-200 text-red-700 text-xs font-semibold rounded-2xl" style="display: none;"></div>
            <div x-show="forgotSuccess" x-text="forgotSuccess" class="mb-4 p-3.5 bg-green-50 border border-green-200 text-green-700 text-xs font-semibold rounded-2xl" style="display: none;"></div>

            <!-- Demo Mode Alert Banner -->
            <div x-show="showDemoBanner" class="mb-4 p-4 bg-brand-beige border border-brand-accent/30 text-brand-dark rounded-2xl text-xs" style="display: none;">
                <div class="flex items-center gap-2 font-bold text-brand-terracotta mb-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    Mode Demo Teraktifkan
                </div>
                Pengiriman email SMTP dinonaktifkan / offline. Gunakan kode OTP demo berikut untuk memverifikasi akun Anda:
                <div class="mt-2 text-center py-2 bg-white rounded-xl border border-brand-beige font-mono text-lg font-bold tracking-widest text-brand-terracotta select-all" x-text="demoOtpCode"></div>
            </div>

            <!-- Step 1: Request OTP -->
            <div x-show="forgotStep === 1">
                <form @submit.prevent="sendOtp">
                    <div class="mb-6">
                        <label class="block text-xs font-bold uppercase tracking-wider text-brand-accent mb-2">Email Akun</label>
                        <input type="email" x-model="forgotEmail" class="w-full bg-white border border-brand-beige rounded-2xl p-3.5 text-sm outline-none focus:border-brand-terracotta transition-colors shadow-inner" placeholder="Masukkan email Anda" required>
                    </div>

                    <button type="submit" 
                            :disabled="forgotLoading"
                            class="w-full bg-gradient-to-r from-brand-terracotta-light to-brand-terracotta text-white py-4 rounded-2xl font-bold text-sm hover:opacity-95 hover:shadow-lg transition-all flex items-center justify-center gap-2 shadow-brand-terracotta/20">
                        <span x-show="forgotLoading" class="animate-spin border-2 border-white border-t-transparent w-4 h-4 rounded-full"></span>
                        <span x-text="forgotLoading ? 'Mengirim...' : 'Kirim Kode OTP'"></span>
                    </button>
                </form>
            </div>

            <!-- Step 2: Verification and Reset -->
            <div x-show="forgotStep === 2" style="display: none;">
                <form @submit.prevent="resetPassword">
                    <div class="mb-4">
                        <label class="block text-xs font-bold uppercase tracking-wider text-brand-accent mb-2">Kode OTP 6-Digit</label>
                        <input type="text" x-model="forgotOtp" maxlength="6" class="w-full bg-white border border-brand-beige rounded-2xl p-3.5 text-sm outline-none focus:border-brand-terracotta transition-colors text-center font-bold tracking-widest shadow-inner" placeholder="######" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs font-bold uppercase tracking-wider text-brand-accent mb-2">Kata Sandi Baru</label>
                        <input type="password" x-model="forgotNewPassword" class="w-full bg-white border border-brand-beige rounded-2xl p-3.5 text-sm outline-none focus:border-brand-terracotta transition-colors shadow-inner" placeholder="Minimal 6 karakter" required>
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs font-bold uppercase tracking-wider text-brand-accent mb-2">Konfirmasi Kata Sandi</label>
                        <input type="password" x-model="forgotNewPasswordConfirm" class="w-full bg-white border border-brand-beige rounded-2xl p-3.5 text-sm outline-none focus:border-brand-terracotta transition-colors shadow-inner" placeholder="Ulangi kata sandi baru" required>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" @click="forgotStep = 1" class="w-1/3 border border-brand-beige text-brand-dark py-4 rounded-2xl font-bold text-sm hover:bg-brand-beige/20 transition-all text-center">
                            Kembali
                        </button>
                        <button type="submit" 
                                :disabled="forgotLoading"
                                class="w-2/3 bg-gradient-to-r from-brand-terracotta-light to-brand-terracotta text-white py-4 rounded-2xl font-bold text-sm hover:opacity-95 hover:shadow-lg transition-all flex items-center justify-center gap-2 shadow-brand-terracotta/20">
                            <span x-show="forgotLoading" class="animate-spin border-2 border-white border-t-transparent w-4 h-4 rounded-full"></span>
                            <span x-text="forgotLoading ? 'Menyimpan...' : 'Perbarui Sandi'"></span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</body>
</html>
