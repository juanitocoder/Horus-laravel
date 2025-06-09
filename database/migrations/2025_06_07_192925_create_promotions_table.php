<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre de la promoción
            $table->string('type')->unique(); // Identificador único del tipo
            $table->decimal('value', 8, 2)->nullable(); // Valor fijo si aplica
            $table->integer('discount_percentage')->nullable(); // Porcentaje de descuento
            $table->string('title_color')->default('text-gray-900'); // Color del título
            $table->string('price_color')->default('text-gray-900'); // Color del precio
            $table->text('description_text')->nullable(); // Texto descriptivo
            $table->boolean('is_active')->default(true); // Si está activa
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};

