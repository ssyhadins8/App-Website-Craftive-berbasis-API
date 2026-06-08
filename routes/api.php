<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Public\ProductController;
use App\Http\Controllers\Public\CategoryController;
use App\Http\Controllers\Public\ShopController;
use App\Http\Controllers\Buyer\CartController;
use App\Http\Controllers\Buyer\OrderController;
use App\Http\Controllers\Buyer\PaymentController;
use App\Http\Controllers\Seller\SellerProductController;
use App\Http\Controllers\Seller\SellerOrderController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\AiRecommendationController;
use App\Http\Controllers\Buyer\CustomProposalController;
use App\Http\Controllers\Buyer\ReviewController;

// Public Routes (Protected by API Key)
Route::middleware(['api.key'])->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/shops', [ShopController::class, 'index']);
    Route::get('/shops/{id}', [ShopController::class, 'show']);
    Route::post('/ai/recommend', [AiRecommendationController::class, 'recommend']);
    Route::get('/products/{id}/reviews', [ReviewController::class, 'index']);

    // New catalog routes matching the screenshot
    Route::get('/catalog/products', [ProductController::class, 'index']);
    Route::get('/catalog/products/{id}', [ProductController::class, 'show']);
});

// Auth Routes
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
    
    // Basic Auth (Ditambahkan untuk syarat eksplisit UAS)
    Route::middleware(['auth.basic'])->get('basic-profile', function (Request $request) {
        return response()->json([
            'message' => 'Basic Auth Berhasil!',
            'user' => $request->user()
        ]);
    });

    Route::middleware(['jwt.auth'])->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::put('profile', [AuthController::class, 'updateProfile']);
    });
});

// GET /api/profile/me (Basic Auth - matching the screenshot)
Route::middleware(['auth.basic'])->get('/profile/me', function (Request $request) {
    return response()->json([
        'message' => 'Basic Auth Berhasil!',
        'user' => $request->user()
    ]);
});

// Protected Routes (Require JWT)
Route::middleware(['jwt.auth'])->group(function () {
    
    // AI Recommendation (Open to all authenticated users)
    Route::post('/ai/custom-planner', [AiRecommendationController::class, 'planCustomKriya']);

    // Custom Proposals
    Route::get('/custom-proposals', [CustomProposalController::class, 'index']);
    Route::post('/custom-proposals', [CustomProposalController::class, 'store']);
    Route::put('/custom-proposals/{id}/accept', [CustomProposalController::class, 'accept']);
    Route::put('/custom-proposals/{id}/reject', [CustomProposalController::class, 'reject']);
    Route::delete('/custom-proposals/{id}', [CustomProposalController::class, 'destroy']);

    // Reviews
    Route::post('/reviews', [ReviewController::class, 'store']);

    // Buyer Routes (Old aliases)
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index']);
        Route::post('/', [CartController::class, 'store']);
        Route::put('/{id}', [CartController::class, 'update']);
        Route::delete('/{id}', [CartController::class, 'destroy']);
    });

    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index']);
        Route::post('/', [OrderController::class, 'store']);
    });

    Route::post('/payments', [PaymentController::class, 'store']);

    // Buyer Routes (Matching the screenshot)
    Route::middleware(['role:buyer,admin'])->prefix('buyer')->group(function () {
        Route::get('/cart', [CartController::class, 'index']);
        Route::post('/cart', [CartController::class, 'store']);
        Route::delete('/cart/{id}', [CartController::class, 'destroy']);
        Route::post('/checkout', [OrderController::class, 'store']);
        Route::get('/orders', [OrderController::class, 'index']);
        Route::post('/custom-planner', [AiRecommendationController::class, 'planCustomKriya']);
        Route::post('/payments', [PaymentController::class, 'store']);
    });

    // Seller Routes (Old aliases)
    Route::middleware(['role:seller,admin'])->prefix('seller')->group(function () {
        Route::get('/products', [SellerProductController::class, 'index']);
        Route::post('/products', [SellerProductController::class, 'store']);
        Route::get('/orders', [SellerOrderController::class, 'index']);
        Route::put('/orders/{id}', [SellerOrderController::class, 'update']);
    });

    // Artisan (Seller) Routes (Matching the screenshot)
    Route::middleware(['role:seller,admin'])->prefix('artisan')->group(function () {
        Route::get('/products', [SellerProductController::class, 'index']);
        Route::post('/products', [SellerProductController::class, 'store']);
        Route::put('/products/{id}', [SellerProductController::class, 'update']);
        Route::delete('/products/{id}', [SellerProductController::class, 'destroy']);
        Route::get('/proposals', [CustomProposalController::class, 'index']);
        Route::patch('/proposals/{id}', [CustomProposalController::class, 'updateStatus']);
    });

    // Admin Routes
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index']);
        Route::post('/categories', [AdminCategoryController::class, 'store']);
        
        // Users Management
        Route::get('/users', [AdminDashboardController::class, 'users']);
        Route::put('/users/{id}', [AdminDashboardController::class, 'updateUser']);
        Route::delete('/users/{id}', [AdminDashboardController::class, 'deleteUser']);

        // Products CRUD
        Route::get('/products', [AdminDashboardController::class, 'products']);
        Route::post('/products', [AdminDashboardController::class, 'storeProduct']);
        Route::put('/products/{id}', [AdminDashboardController::class, 'updateProduct']);
        Route::delete('/products/{id}', [AdminDashboardController::class, 'deleteProduct']);
        Route::patch('/products/{id}/approve', [AdminDashboardController::class, 'approveProduct']);

        // Shops Management
        Route::get('/shops', [AdminDashboardController::class, 'shops']);
        Route::put('/shops/{id}/verify', [AdminDashboardController::class, 'verifyShop']);
        Route::delete('/shops/{id}', [AdminDashboardController::class, 'deleteShop']);

        // Transactions/Orders Management
        Route::get('/orders', [AdminDashboardController::class, 'orders']);
        Route::put('/orders/{id}/status', [AdminDashboardController::class, 'updateOrderStatus']);
    });
});
