<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('credit_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_method_id')->constrained()->onDelete('cascade');
            $table->string('last_four', 4);
            $table->string('expiry_month', 2);
            $table->string('expiry_year', 4);
            $table->string('card_holder');
            $table->enum('brand', ['visa', 'mastercard', 'amex', 'discover', 'other']);
            $table->string('token_id')->nullable();
            $table->timestamps();
            $table->index('payment_method_id');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('credit_cards');
    }
};
