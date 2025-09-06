<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gateway_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gateway_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('order_id')->nullable(); // شماره سفارش داخلی
            $table->decimal('amount', 20, 2);
            $table->string('currency', 10)->default('IRR');
            $table->string('status')->default('pending'); // pending, paid, failed, refunded
            $table->string('transaction_id')->nullable(); // شناسه تراکنش سمت درگاه
            $table->string('tracking_code')->nullable(); // کد رهگیری
            $table->json('extra')->nullable(); // متادیتا
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gateway_transactions');
    }
};
