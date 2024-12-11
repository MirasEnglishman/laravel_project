<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // Метод для получения всех продуктов
    public function index()
    {
        // Получение всех продуктов с их подкатегориями
        $products = Product::with('category')->get();
        return response()->json($products);
    }

    // Метод для сохранения нового продукта
    public function store(Request $request)
    {
        // Валидация данных
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'images' => 'nullable|array',
            'images.*' => 'nullable|string|max:255', // Проверка каждого изображения в массиве
            'category_id' => 'required|exists:category,id', // Проверка существования подкатегории
        ]);

        // Сохранение записи
        $validated['images'] = json_encode($request->images); // Преобразование массива в JSON
        Product::create($validated);

        return response()->json(['message' => 'Продукт успешно добавлен!'], 201);
    }

    // Метод для обновления существующего продукта
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Валидация данных
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'images' => 'nullable|array',
            'images.*' => 'nullable|string|max:255', // Проверка каждого изображения в массиве
            'category_id' => 'required|exists:category,id', // Проверка существования подкатегории
        ]);

        // Обновление записи
        $validated['images'] = json_encode($request->images); // Преобразование массива в JSON
        $product->update($validated);

        return response()->json(['message' => 'Продукт успешно обновлен!'], 200);
    }

    // Метод для удаления продукта
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['message' => 'Продукт успешно удален!'], 200);
    }
}
