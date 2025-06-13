<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Car;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // User Management
    /**
     * List all users with pagination.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexUsers()
    {
        return User::select('id', 'name', 'email', 'role')->paginate(10);
    }

    /**
     * Create a new user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeUser(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:users|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:user,admin'
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role']
        ]);

        return response()->json(['data' => $user->only(['id', 'name', 'email', 'role']), 'message' => 'User created'], 201);
    }

    /**
     * Update an existing user.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUser(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|unique:users,name,' . $user->id . '|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id . '|max:255',
            'password' => 'sometimes|required|string|min:6|confirmed',
            'role' => 'sometimes|required|in:user,admin'
        ]);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return response()->json(['data' => $user->only(['id', 'name', 'email', 'role']), 'message' => 'User updated']);
    }

    /**
     * Delete a user.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function destroyUser(User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }

    // Car Management (Admin can manage all cars)
    /**
     * List all cars with related data.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexCars()
    {
        return Car::with('user', 'images')->paginate(10);
    }

    /**
     * Create a new car.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeCar(Request $request)
    {
        $data = $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            // Add other car fields as needed
        ]);

        $car = Car::create($data + ['user_id' => auth()->user()]); // Admin acts as creator
        return response()->json($car, 201);
    }

    /**
     * Update an existing car.
     *
     * @param Request $request
     * @param Car $car
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCar(Request $request, Car $car)
    {
        $data = $request->validate([
            'make' => 'sometimes|required|string|max:255',
            'model' => 'sometimes|required|string|max:255',
            'year' => 'sometimes|required|integer|min:1900|max:' . date('Y'),
            'price' => 'sometimes|required|numeric|min:0',
            'description' => 'nullable|string',
            // Add other car fields as needed
        ]);

        $car->update($data);
        return response()->json($car);
    }

    /**
     * Delete a car.
     *
     * @param Car $car
     * @return \Illuminate\Http\Response
     */
    public function destroyCar(Car $car)
    {
        $car->delete();
        return response()->json(null, 204);
    }

    // Order Management
    /**
     * List all orders with related data.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexOrders()
    {
        return Order::with('user', 'car')->paginate(10);
    }

    /**
     * Show a specific order.
     *
     * @param Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function showOrder(Order $order)
    {
        return response()->json($order->load('user', 'car'));
    }

    /**
     * Update an order.
     *
     * @param Request $request
     * @param Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateOrder(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
            'total_price' => 'sometimes|required|numeric|min:0'
        ]);

        $order->update($data);
        return response()->json($order);
    }

    /**
     * Delete an order.
     *
     * @param Order $order
     * @return \Illuminate\Http\Response
     */
    public function destroyOrder(Order $order)
    {
        $order->delete();
        return response()->json(null, 204);
    }
}