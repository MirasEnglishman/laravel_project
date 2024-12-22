<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Получить список всех заказов
    public function index()
    {
        $orders = Order::with(['product', 'user'])->get();
        return response()->json($orders);
    }

    // Создать новый заказ
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
        ]);

        $order = Order::create($validatedData);

        return response()->json(['message' => 'Заказ успешно создан', 'order' => $order], 201);
    }

    // Получить информацию о конкретном заказе
    public function show($id)
    {
        $order = Order::with(['product', 'user'])->findOrFail($id);
        return response()->json($order);
    }

    // Обновить информацию о заказе
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
        ]);

        $order->update($validatedData);

        return response()->json(['message' => 'Заказ успешно обновлен', 'order' => $order]);
    }

    // Удалить заказ
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json(['message' => 'Заказ успешно удален']);
    }
}
