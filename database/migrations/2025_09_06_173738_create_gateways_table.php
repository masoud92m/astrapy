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
        Schema::create('gateways', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // عنوان نمایشی: زرین‌پال، Pay.ir
            $table->string('driver'); // zarinpal, payir ...
            $table->string('merchant_id')->nullable(); // کلید API یا merchant
            $table->string('callback_url')->nullable(); // آدرس بازگشت
            $table->string('sandbox')->default('0'); // مثلا برای تست/لایو
            $table->boolean('active')->default(true);
            $table->string('card_number')->nullable();   // شماره کارت پرداخت کننده
            $table->string('ip')->nullable();            // آی‌پی کاربر
            $table->string('payment_method')->nullable(); // روش پرداخت (مثلا شتابی، رمز پویا...)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gateways');
    }
};
