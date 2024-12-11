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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // ID продукта
            $table->string('name'); // Название продукта
            $table->string('image')->nullable(); // Основное изображение
            $table->longText('description')->nullable(); // Описание продукта (длинный текст)
            $table->json('images')->nullable(); // Список изображений в формате JSON
            $table->unsignedBigInteger('category_id'); // Внешний ключ для подкатегории
            $table->timestamps();

            // Добавление внешнего ключа для связи с подкатегориями
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
