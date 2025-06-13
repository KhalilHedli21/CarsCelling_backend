<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return Order::with('user', 'car')->paginate(10);
    }

    public function show(Order $order)
    {
        return $order->load('user', 'car');
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
            'total_price' => 'sometimes|required|numeric|min:0'
        ]);

        $order->update($data);
        return response()->json($order);
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(null, 204);
    }
}