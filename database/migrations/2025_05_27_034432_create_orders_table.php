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
        Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
    $table->string('transaction_id')->nullable(); // ✅
    $table->decimal('amount', 10, 2)->nullable();  // ✅
    $table->string('currency')->nullable();       // ✅
    $table->string('email')->nullable();          // ✅
    $table->string('status')->default('completado');
    $table->decimal('total', 10, 2)->nullable();  // ✅ opcional si ya usas amount
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
