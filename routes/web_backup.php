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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('products', ProductController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('order-items', OrderItemController::class);
    Route::resource('inventory-orders', InventoryOrderController::class);    Route::resource('carts', CartController::class);    Route::resource('cart-items', CartItemController::class);
    Route::resource('checkout', CheckoutController::class);
      // Rutas específicas para el flujo de checkout
    Route::get('/checkout/payment-methods/{cart_id}', [CheckoutController::class, 'paymentMethods'])->name('checkout.payment-methods');
    Route::post('/checkout/select-payment-type', [CheckoutController::class, 'selectPaymentType'])->name('checkout.select-payment-type');
    Route::get('/checkout/select-card/{cart_id}/{type}', [CheckoutController::class, 'selectCard'])->name('checkout.select-card');
    Route::post('/checkout/process-with-existing-card', [CheckoutController::class, 'processWithExistingCard'])->name('checkout.process-with-existing-card');
    Route::get('/checkout/add-card/{cart_id}/{type}', [CheckoutController::class, 'addCard'])->name('checkout.add-card');
    Route::post('/checkout/process-payment', [CheckoutController::class, 'processPayment'])->name('checkout.process-payment');
    
    Route::resource('payment-methods', PaymentMethodController::class);
    Route::resource('credit-cards', CreditCardController::class);
    Route::resource('payment-gateways', PaymentGatewayController::class);
    Route::resource('orders-payments', OrdersPaymentController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('refunds', RefundController::class);
    Route::resource('audit-logs-payments', AuditLogPaymentController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('users', UserController::class);
    Route::resource('movement-types', MovementTypeController::class);
    Route::resource('inventory-movements', InventoryMovementController::class);
    Route::resource('product-images', ProductImageController::class);
});

require __DIR__.'/auth.php';
