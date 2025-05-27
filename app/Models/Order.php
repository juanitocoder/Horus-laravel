<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
    $table->string('transaction_id');
    $table->decimal('amount', 10, 2);
    $table->string('currency', 10);
    $table->string('email');
    $table->string('status'); // Aceptada, Rechazada, etc.
    $table->timestamps();
});
}
