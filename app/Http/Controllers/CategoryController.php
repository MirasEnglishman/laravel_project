<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Получить все категории
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    // Создать новую категорию
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::create($validatedData);

        return response()->json(['message' => 'Категория успешно создана', 'category' => $category], 201);
    }

    // Получить одну категорию по ID
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    // Обновить категорию
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',

        ]);

        $category->update($validatedData);

        return response()->json(['message' => 'Категория успешно обновлена', 'category' => $category]);
    }

    // Удалить категорию
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json(['message' => 'Категория успешно удалена']);
    }
}
