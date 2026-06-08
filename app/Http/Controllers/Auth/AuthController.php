<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Mail\ResetOtpMail;

class AuthController extends Controller
{
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

    public function me()
    {
        return response()->json(Auth::guard('api')->user());
    }

    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(Auth::guard('api')->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
            'user' => Auth::guard('api')->user()
        ]);
    }

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

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Remove OTP from Cache
        Cache::forget('reset_otp_' . $request->email);

        return response()->json([
            'message' => 'Kata sandi Anda berhasil diperbarui. Silakan masuk kembali.'
        ]);
    }

    // Update user profile details
    public function updateProfile(Request $request)
    {
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