<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->string('currency', 3)->default('USD');
            $table->enum('reason', ['customer_request', 'duplicate', 'fraudulent', 'product_issue']);
            $table->enum('status', ['pending', 'completed', 'failed']);
            $table->foreignId('processed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->string('gateway_reference')->nullable();
            $table->timestamps();
            $table->index('transaction_id');
            $table->index('status');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('refunds');
    }
};
