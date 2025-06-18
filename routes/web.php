<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\InventoryOrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\CreditCardController;
use App\Http\Controllers\PaymentGatewayController;
use App\Http\Controllers\OrdersPaymentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\RefundController;
use App\Http\Controllers\AuditLogPaymentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MovementTypeController;
use App\Http\Controllers\InventoryMovementController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\AdminDashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// Customer dashboard
Route::get('/customer-dashboard', function () {
    return view('customer-dashboard');
})->middleware(['auth', 'verified'])->name('customer.dashboard');

// Vendor dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin dashboard with advanced metrics
Route::get('/admin-dashboard', [AdminDashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('admin.dashboard');

// API endpoint for dashboard chart data
Route::get('/admin-dashboard/chart-data', [AdminDashboardController::class, 'getChartData'])
    ->middleware(['auth', 'verified'])
    ->name('admin.dashboard.chart-data');

// Profile routes accessible to all authenticated users
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Debug route to check user roles
    Route::get('/debug-roles', function () {
        $user = Auth::user();
        return response()->json([
            'user_id' => $user->id,
            'user_email' => $user->email,
            'roles' => $user->roles->pluck('name', 'id'),
            'role_ids' => $user->roles->pluck('id'),
            'has_cliente_role' => $user->roles()->whereIn('id', [1])->exists(),
            'has_vendedor_role' => $user->roles()->whereIn('id', [2])->exists(),
        ]);
    });
});

// ===== CLIENTE ROUTES - Only access to shopping features =====
Route::middleware(['auth', 'verified', 'check.user.type:cliente'])->group(function () {
    // Cart management for customers (full CRUD for their own carts)
    Route::resource('carts', CartController::class);
    Route::resource('cart-items', CartItemController::class);
    Route::get('/api/carts/active', [CartController::class, 'getActiveCarts'])->name('api.carts.active');
    Route::post('/api/carts/add-to-cart', [CartController::class, 'addToCart'])->name('api.carts.add-to-cart');
    
    // Catalog access (all catalog routes)
    Route::get('/catalog', [ProductController::class, 'catalog'])->name('products.catalog');
    Route::get('/catalog/{category}', [ProductController::class, 'catalogByCategory'])->name('products.catalog.category');
    Route::get('/product/{product}', [ProductController::class, 'show'])->name('products.show');
    
    // Checkout process (full access)
    Route::resource('checkout', CheckoutController::class);
    Route::get('/checkout/payment-methods/{cart_id}', [CheckoutController::class, 'paymentMethods'])->name('checkout.payment-methods');
    Route::post('/checkout/select-payment-type', [CheckoutController::class, 'selectPaymentType'])->name('checkout.select-payment-type');
    Route::get('/checkout/select-card/{cart_id}/{type}', [CheckoutController::class, 'selectCard'])->name('checkout.select-card');
    Route::post('/checkout/process-with-existing-card', [CheckoutController::class, 'processWithExistingCard'])->name('checkout.process-with-existing-card');
    Route::get('/checkout/add-card/{cart_id}/{type}', [CheckoutController::class, 'addCard'])->name('checkout.add-card');
    Route::post('/checkout/process-payment', [CheckoutController::class, 'processPayment'])->name('checkout.process-payment');
    
    // Stripe PaymentIntent route
    Route::post('/stripe/payment-intent', [CheckoutController::class, 'createPaymentIntent'])->name('stripe.payment-intent');
    
    // Customer's orders (read-only)
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    
    // Customer's payment methods and cards
    Route::resource('payment-methods', PaymentMethodController::class)->except(['destroy']);
    Route::resource('credit-cards', CreditCardController::class)->except(['destroy']);
});

// ===== VENDEDOR ROUTES - Access to everything (admin panel) =====
Route::middleware(['auth', 'verified', 'check.user.type:vendedor'])->group(function () {
    // Categories management
    Route::resource('categories', CategoryController::class);
    
    // Suppliers management  
    Route::resource('suppliers', SupplierController::class);
    
    // Products management
    Route::resource('products', ProductController::class);
    Route::resource('product-images', ProductImageController::class);
    
    // Orders management (full CRUD)
    Route::resource('orders', OrderController::class);
    Route::resource('order-items', OrderItemController::class);
    
    // Inventory management
    Route::resource('inventory-orders', InventoryOrderController::class);
    Route::resource('movement-types', MovementTypeController::class);    Route::resource('inventory-movements', InventoryMovementController::class);
    
    // Cart management (admin view) - use different routes to avoid conflicts
    Route::get('/admin/carts', [CartController::class, 'index'])->name('admin.carts.index');
    Route::get('/admin/carts/{cart}', [CartController::class, 'show'])->name('admin.carts.show');
    Route::get('/admin/carts/create', [CartController::class, 'create'])->name('admin.carts.create');
    Route::post('/admin/carts', [CartController::class, 'store'])->name('admin.carts.store');    Route::get('/admin/carts/{cart}/edit', [CartController::class, 'edit'])->name('admin.carts.edit');
    Route::put('/admin/carts/{cart}', [CartController::class, 'update'])->name('admin.carts.update');
    Route::delete('/admin/carts/{cart}', [CartController::class, 'destroy'])->name('admin.carts.destroy');
      // Cart items management (admin view) - use different routes to avoid conflicts
    Route::get('/admin/cart-items', [CartItemController::class, 'index'])->name('admin.cart-items.index');
    Route::get('/admin/cart-items/{cartItem}', [CartItemController::class, 'show'])->name('admin.cart-items.show');
    Route::get('/admin/cart-items/create', [CartItemController::class, 'create'])->name('admin.cart-items.create');
    Route::post('/admin/cart-items', [CartItemController::class, 'store'])->name('admin.cart-items.store');
    Route::get('/admin/cart-items/{cartItem}/edit', [CartItemController::class, 'edit'])->name('admin.cart-items.edit');
    Route::put('/admin/cart-items/{cartItem}', [CartItemController::class, 'update'])->name('admin.cart-items.update');
    Route::delete('/admin/cart-items/{cartItem}', [CartItemController::class, 'destroy'])->name('admin.cart-items.destroy');
    
    // Checkout management (admin) - separate admin checkout routes
    Route::get('/admin/checkout', [CheckoutController::class, 'index'])->name('admin.checkout.index');
    Route::get('/admin/checkout/{checkout}', [CheckoutController::class, 'show'])->name('admin.checkout.show');
    Route::get('/admin/checkout/create', [CheckoutController::class, 'create'])->name('admin.checkout.create');
    Route::post('/admin/checkout', [CheckoutController::class, 'store'])->name('admin.checkout.store');
    Route::get('/admin/checkout/{checkout}/edit', [CheckoutController::class, 'edit'])->name('admin.checkout.edit');
    Route::put('/admin/checkout/{checkout}', [CheckoutController::class, 'update'])->name('admin.checkout.update');
    Route::delete('/admin/checkout/{checkout}', [CheckoutController::class, 'destroy'])->name('admin.checkout.destroy');
    Route::get('/admin/checkout/payment-methods/{cart_id}', [CheckoutController::class, 'paymentMethods'])->name('admin.checkout.payment-methods');
    Route::post('/admin/checkout/select-payment-type', [CheckoutController::class, 'selectPaymentType'])->name('admin.checkout.select-payment-type');
    Route::get('/admin/checkout/select-card/{cart_id}/{type}', [CheckoutController::class, 'selectCard'])->name('admin.checkout.select-card');
    Route::post('/admin/checkout/process-with-existing-card', [CheckoutController::class, 'processWithExistingCard'])->name('admin.checkout.process-with-existing-card');
    Route::get('/admin/checkout/add-card/{cart_id}/{type}', [CheckoutController::class, 'addCard'])->name('admin.checkout.add-card');
    Route::post('/admin/checkout/process-payment', [CheckoutController::class, 'processPayment'])->name('admin.checkout.process-payment');
    Route::post('/admin/stripe/payment-intent', [CheckoutController::class, 'createPaymentIntent'])->name('admin.stripe.payment-intent');    
    // Payment management (admin) - full CRUD for all payment methods
    Route::resource('admin/payment-methods', PaymentMethodController::class, ['as' => 'admin']);
    Route::resource('admin/credit-cards-mgmt', CreditCardController::class, ['as' => 'admin']);
    Route::resource('payment-gateways', PaymentGatewayController::class);
    Route::resource('orders-payments', OrdersPaymentController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('refunds', RefundController::class);
    Route::resource('audit-logs-payments', AuditLogPaymentController::class);
    
    // User and role management
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('users', UserController::class);
});

require __DIR__.'/auth.php';
