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
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Public catalog route
Route::get('/catalog', [ProductController::class, 'catalog'])->name('products.catalog');

// Customer dashboard
Route::get('/customer-dashboard', function () {
    return view('customer-dashboard');
})->middleware(['auth', 'verified'])->name('customer.dashboard');

// Vendor dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes accessible to all authenticated users
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===== CLIENTE ROUTES - Only access to shopping features =====
Route::middleware(['auth', 'verified', 'check.user.type:cliente'])->group(function () {
    // Cart management for customers
    Route::get('/api/carts/active', [CartController::class, 'getActiveCarts'])->name('api.carts.active');
    Route::post('/api/carts/add-to-cart', [CartController::class, 'addToCart'])->name('api.carts.add-to-cart');
    
    // Checkout process
    Route::resource('checkout', CheckoutController::class)->only(['index', 'show', 'store']);
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
    Route::resource('movement-types', MovementTypeController::class);
    Route::resource('inventory-movements', InventoryMovementController::class);
    
    // Cart management (admin view)
    Route::resource('carts', CartController::class);
    Route::resource('cart-items', CartItemController::class);
    
    // Checkout management (admin)
    Route::resource('checkout', CheckoutController::class);
    Route::get('/admin/checkout/payment-methods/{cart_id}', [CheckoutController::class, 'paymentMethods'])->name('admin.checkout.payment-methods');
    Route::post('/admin/checkout/select-payment-type', [CheckoutController::class, 'selectPaymentType'])->name('admin.checkout.select-payment-type');
    Route::get('/admin/checkout/select-card/{cart_id}/{type}', [CheckoutController::class, 'selectCard'])->name('admin.checkout.select-card');
    Route::post('/admin/checkout/process-with-existing-card', [CheckoutController::class, 'processWithExistingCard'])->name('admin.checkout.process-with-existing-card');
    Route::get('/admin/checkout/add-card/{cart_id}/{type}', [CheckoutController::class, 'addCard'])->name('admin.checkout.add-card');
    Route::post('/admin/checkout/process-payment', [CheckoutController::class, 'processPayment'])->name('admin.checkout.process-payment');
    Route::post('/admin/stripe/payment-intent', [CheckoutController::class, 'createPaymentIntent'])->name('admin.stripe.payment-intent');
    
    // Payment management
    Route::resource('payment-methods', PaymentMethodController::class);
    Route::resource('credit-cards', CreditCardController::class);
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
