<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inventory_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->decimal('total', 10, 2);
            $table->enum('status', ['pendiente', 'completado', 'cancelado'])->default('pendiente');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('inventory_orders');
    }
};
