<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('provider'); // stripe, paypal, etc.
            $table->string('public_key');
            $table->string('secret_key');
            $table->boolean('sandbox_mode')->default(true);
            $table->json('webhook_config')->nullable(); // URL y secret
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('payment_gateways');
    }
};
