<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Поля, доступные для массового заполнения
    protected $fillable = [
        'name',           // Название продукта
        'description',    // Описание продукта (длинный текст)
        'image',          // Основное изображение
        'images',         // Список изображений в формате JSON
        'category_id', // Внешний ключ для подкатегории
    ];

    /**
     * Связь с моделью SubCategory (многие к одному).
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
