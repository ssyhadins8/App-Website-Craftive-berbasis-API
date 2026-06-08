<?php
namespace App\Http\Controllers\Auth;

use OpenApi\Attributes as OA;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Mail\ResetOtpMail;

#[OA\Tag(name: 'Autentikasi', description: 'Registrasi, Login, Logout, dan manajemen token JWT')]
class AuthController extends Controller
{
    #[OA\Post(
        path: '/auth/register',
        tags: ['Autentikasi'],
        summary: 'Registrasi Akun Baru',
        description: 'Mendaftarkan buyer atau seller baru. Setelah berhasil, token JWT langsung diberikan.',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'email', 'password', 'password_confirmation', 'role'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Siti Rahayu'),
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'siti@craftive.id'),
                    new OA\Property(property: 'password', type: 'string', format: 'password', example: 'password123'),
                    new OA\Property(property: 'password_confirmation', type: 'string', format: 'password', example: 'password123'),
                    new OA\Property(property: 'role', type: 'string', enum: ['buyer', 'seller'], example: 'buyer'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Registrasi berhasil, token JWT diberikan'),
            new OA\Response(response: 422, description: 'Validasi gagal'),
        ]
    )]
    // API Register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:buyer,seller'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        $token = Auth::guard('api')->login($user);
        return response()->json(compact('user', 'token'), 201);
    }

    #[OA\Post(
        path: '/auth/login',
        tags: ['Autentikasi'],
        summary: 'Login',
        description: 'Login dengan email dan password. Token JWT dikembalikan untuk dipakai di request selanjutnya.',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['email', 'password'],
                properties: [
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'siti@craftive.id'),
                    new OA\Property(property: 'password', type: 'string', format: 'password', example: 'password123'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Login berhasil, token JWT diberikan',
                content: new OA\JsonContent(properties: [
                    new OA\Property(property: 'access_token', type: 'string'),
                    new OA\Property(property: 'token_type', type: 'string', example: 'bearer'),
                    new OA\Property(property: 'expires_in', type: 'integer', example: 3600),
                    new OA\Property(property: 'user', type: 'object'),
                ])
            ),
            new OA\Response(response: 401, description: 'Email atau password salah'),
        ]
    )]
    // API Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (! $token = Auth::guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Email atau password salah'], 401);
        }

        return $this->respondWithToken($token);
    }

    // Process login form (POST) – session based
    public function loginWeb(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::guard('web')->attempt($credentials)) {
            // Authentication passed… redirect based on role
            $user = Auth::guard('web')->user();
            switch ($user->role) {
                case 'admin':
                    return redirect('/admin/dashboard');
                case 'seller':
                    return redirect('/seller/dashboard');
                default:
                    return redirect('/user/dashboard');
            }
        }
        return back()->withErrors(['email' => 'Email atau password salah'])->withInput();
    }

    // Process register form (POST) – session based
    public function registerWeb(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:buyer,seller',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        Auth::guard('web')->login($user);
        
        // Redirect based on role after registration
        switch ($user->role) {
            case 'admin':
                return redirect('/admin/dashboard');
            case 'seller':
                return redirect('/seller/dashboard');
            default:
                return redirect('/user/dashboard');
        }
    }

    // Logout web session
    public function logoutWeb(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    #[OA\Get(
        path: '/auth/me',
        tags: ['Autentikasi'],
        summary: 'Profil Saya',
        description: 'Mendapatkan data user yang sedang login berdasarkan token JWT.',
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Data profil user berhasil diambil'),
            new OA\Response(response: 401, description: 'Token tidak valid atau tidak ditemukan'),
        ]
    )]
    public function me()
    {
        return response()->json(Auth::guard('api')->user());
    }

    #[OA\Post(
        path: '/auth/logout',
        tags: ['Autentikasi'],
        summary: 'Logout',
        description: 'Keluar dan invalidasi token JWT.',
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Logout berhasil',
                content: new OA\JsonContent(properties: [
                    new OA\Property(property: 'message', type: 'string', example: 'Successfully logged out'),
                ])
            ),
            new OA\Response(response: 401, description: 'Token tidak valid'),
        ]
    )]
    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    #[OA\Post(
        path: '/auth/refresh',
        tags: ['Autentikasi'],
        summary: 'Refresh Token',
        description: 'Memperbarui token JWT sebelum kadaluarsa.',
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Token berhasil diperbarui'),
            new OA\Response(response: 401, description: 'Token tidak valid'),
        ]
    )]
    public function refresh()
    {
        /** @var \Tymon\JWTAuth\JWTGuard $guard */
        $guard = Auth::guard('api');
        return $this->respondWithToken($guard->refresh());
    }

    /**
     * @param string $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken(string $token)
    {
        /** @var \Tymon\JWTAuth\JWTGuard $guard */
        $guard = Auth::guard('api');
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $guard->factory()->getTTL() * 60,
            'user' => $guard->user()
        ]);
    }

    #[OA\Post(
        path: '/auth/forgot-password',
        tags: ['Autentikasi'],
        summary: 'Lupa Password (Minta OTP)',
        description: 'Mengirim kode OTP 6 digit ke email untuk proses reset password.',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['email'],
                properties: [new OA\Property(property: 'email', type: 'string', format: 'email', example: 'siti@craftive.id')]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'OTP berhasil dikirim ke email'),
            new OA\Response(response: 422, description: 'Email tidak terdaftar'),
        ]
    )]
    // Request OTP for password reset
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Email tidak terdaftar di sistem kami.',
        ]);

        $user = User::where('email', $request->email)->first();
        $otp = random_int(100000, 999999);

        // Store OTP in Cache for 10 minutes
        Cache::put('reset_otp_' . $request->email, $otp, now()->addMinutes(10));
        Log::info("OTP reset password untuk {$request->email}: {$otp}");

        $emailSent = false;
        try {
            Mail::to($request->email)->send(new ResetOtpMail($otp, $user->name));
            $emailSent = true;
        } catch (\Exception $e) {
            Log::warning('SMTP Mail sending failed: ' . $e->getMessage());
        }

        if ($emailSent) {
            return response()->json([
                'message' => 'Kode OTP telah berhasil dikirim ke email Anda.',
                'demo_mode' => false
            ]);
        }

        // Fallback for presentation / local offline mode
        return response()->json([
            'message' => 'Gagal mengirim email (Demo Mode aktif). Kode OTP tercatat di sistem.',
            'otp_demo' => $otp,
            'demo_mode' => true
        ]);
    }

    #[OA\Post(
        path: '/auth/reset-password',
        tags: ['Autentikasi'],
        summary: 'Reset Password dengan OTP',
        description: 'Mengatur ulang password menggunakan kode OTP yang diterima via email.',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['email', 'otp', 'password', 'password_confirmation'],
                properties: [
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'siti@craftive.id'),
                    new OA\Property(property: 'otp', type: 'string', example: '123456'),
                    new OA\Property(property: 'password', type: 'string', format: 'password', example: 'newpassword123'),
                    new OA\Property(property: 'password_confirmation', type: 'string', format: 'password', example: 'newpassword123'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Password berhasil diperbarui'),
            new OA\Response(response: 422, description: 'OTP tidak valid atau kadaluarsa'),
        ]
    )]
    // Reset password using OTP
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|numeric|digits:6',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.exists' => 'Email tidak terdaftar.',
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.digits' => 'Kode OTP harus 6 digit.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $cachedOtp = Cache::get('reset_otp_' . $request->email);

        if (!$cachedOtp || $cachedOtp != $request->otp) {
            return response()->json(['error' => 'Kode OTP tidak valid atau telah kedaluwarsa.'], 422);
        }

        /** @var \App\Models\User $user */
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Remove OTP from Cache
        Cache::forget('reset_otp_' . $request->email);

        return response()->json([
            'message' => 'Kata sandi Anda berhasil diperbarui. Silakan masuk kembali.'
        ]);
    }

    #[OA\Put(
        path: '/auth/profile',
        tags: ['Autentikasi'],
        summary: 'Update Profil',
        description: 'Memperbarui nama, email, nomor telepon, dan alamat user yang sedang login.',
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'email'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Siti Rahayu'),
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'siti@craftive.id'),
                    new OA\Property(property: 'phone', type: 'string', example: '081234567890'),
                    new OA\Property(property: 'address', type: 'string', example: 'Jl. Batik No.5, Yogyakarta'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Profil berhasil diperbarui'),
            new OA\Response(response: 401, description: 'Token tidak valid'),
            new OA\Response(response: 422, description: 'Validasi gagal'),
        ]
    )]
    // Update user profile details
    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json(['error' => 'Sesi Anda telah berakhir. Silakan keluar dan masuk kembali.'], 401);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'avatar' => 'nullable|string',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh akun lain.',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        if ($request->has('avatar')) {
            $user->avatar = $request->avatar;
        }
        $user->save();

        return response()->json([
            'message' => 'Profil berhasil diperbarui.',
            'user' => $user
        ]);
    }
}