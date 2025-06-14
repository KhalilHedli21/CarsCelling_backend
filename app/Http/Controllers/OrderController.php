<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Car;
use App\Http\Requests\StoreOrderRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function store(StoreOrderRequest $request)
    {
        try {
            $car = Car::findOrFail($request->car_id);
            
            $order = Order::create([
                'user_id' => Auth::id(),
                'car_id' => $request->car_id,
                'fullname' => $request->fullname,
                'email' => $request->email,
                'phone' => $request->phone,
                'status' => 'pending',
                'total_price' => $car->price
            ]);

            return response()->json([
                'message' => 'Commande créée avec succès',
                'order' => $order
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la création de la commande',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        $orders = Order::with('car')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return response()->json($orders);
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        return response()->json($order->load('car'));
    }

    public function update(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return response()->json([
            'message' => 'Statut de la commande mis à jour',
            'order' => $order
        ]);
    }
}