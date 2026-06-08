<?php
use Illuminate\Support\Facades\Route;

// ── Public Pages ──
Route::get('/', fn() => view('pages.home'));
Route::get('/products', fn() => view('pages.products'));
Route::get('/products/{id}', fn($id) => view('pages.show', compact('id')));

// ── API Documentation (Swagger UI) ──
Route::get('/api/documentation', fn() => view('pages.docs'))->name('api.documentation');
Route::get('/docs', fn() => redirect('/api/documentation'));


// ── Auth Pages (guest only) ──
Route::middleware('guest')->group(function () {
    Route::get('/login', fn() => view('auth.login'))->name('login');
    Route::get('/register', fn() => view('auth.register'))->name('register');
});

// ── Auth API Redirects (form POST) ──
Route::post('/login',    [\App\Http\Controllers\Auth\AuthController::class, 'loginWeb'])->name('login.post');
Route::post('/register', [\App\Http\Controllers\Auth\AuthController::class, 'registerWeb'])->name('register.post');
Route::post('/logout',   [\App\Http\Controllers\Auth\AuthController::class, 'logoutWeb'])->name('logout');

// ── Dashboard Routes (protected) ──
Route::middleware(['auth:web'])->group(function () {
    // Admin dashboard
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->middleware('role:admin')->name('admin.dashboard');

    // Seller dashboard
    Route::get('/seller/dashboard', function () {
        return view('seller.dashboard');
    })->middleware('role:seller')->name('seller.dashboard');

    // User (buyer) dashboard
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->middleware('role:buyer')->name('user.dashboard');
});



