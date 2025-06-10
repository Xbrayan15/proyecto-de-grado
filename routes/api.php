<?php

use Illuminate\Support\Facades\Route;

// Categorías
Route::apiResource('categories', App\Http\Controllers\CategoryController::class);
// Proveedores
Route::apiResource('suppliers', App\Http\Controllers\SupplierController::class);
// Productos
Route::apiResource('products', App\Http\Controllers\ProductController::class);
// Órdenes
Route::apiResource('orders', App\Http\Controllers\OrderController::class);
// Órdenes de Inventario
Route::apiResource('inventory-orders', App\Http\Controllers\InventoryOrderController::class);
// Carritos
Route::apiResource('carts', App\Http\Controllers\CartController::class);
Route::middleware(['web', 'auth'])->get('carts/active', [App\Http\Controllers\CartController::class, 'getActiveCarts']);
Route::middleware(['web', 'auth'])->post('carts/add-to-cart', [App\Http\Controllers\CartController::class, 'addToCart']);
Route::apiResource('cart-items', App\Http\Controllers\CartItemController::class);
// Checkout
Route::apiResource('checkout', App\Http\Controllers\CheckoutController::class);
// Métodos de pago
Route::apiResource('payment-methods', App\Http\Controllers\PaymentMethodController::class);
Route::apiResource('credit-cards', App\Http\Controllers\CreditCardController::class);
Route::apiResource('payment-gateways', App\Http\Controllers\PaymentGatewayController::class);
// Órdenes de pago
Route::apiResource('orders-payments', App\Http\Controllers\OrdersPaymentController::class);
// Transacciones
Route::apiResource('transactions', App\Http\Controllers\TransactionController::class);
// Reembolsos
Route::apiResource('refunds', App\Http\Controllers\RefundController::class);
// Logs de auditoría de pagos
Route::apiResource('audit-logs-payments', App\Http\Controllers\AuditLogPaymentController::class)->only(['index', 'show']);
// Roles y permisos
Route::apiResource('roles', App\Http\Controllers\RoleController::class);
Route::apiResource('permissions', App\Http\Controllers\PermissionController::class);
// Usuarios
Route::apiResource('users', App\Http\Controllers\UserController::class)->except(['create', 'edit']);
