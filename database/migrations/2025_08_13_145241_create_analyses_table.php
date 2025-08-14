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
        Schema::create('analyses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->nullable()->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->foreignId('causer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name')->nullable();
            $table->unsignedTinyInteger('gender')->nullable();
            $table->unsignedTinyInteger('relationship')->nullable();
            $table->date('dob')->nullable();
            $table->text('prompt')->nullable();
            $table->text('analysis')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analyses');
    }
};
