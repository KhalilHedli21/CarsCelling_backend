<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Http\Requests\StoreCarRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CarController extends Controller
{
    // Récupérer toutes les voitures (pour les visiteurs)
    public function index() {
        return Car::with('user', 'images')->paginate(10);
    }

    // Créer une nouvelle annonce (client)
    public function store(StoreCarRequest $request) {
        $car = auth()->user()->cars()->create($request->validated());
        return response()->json($car, 201);
    }

    // Mettre à jour une annonce (client/admin)
    public function update(StoreCarRequest $request, Car $car) {
        $car->update($request->validated());
        return response()->json($car);
    }

    // Supprimer une annonce (client/admin)
    public function destroy(Car $car) {
        $car->delete();
        return response()->json(null, 204);
    }
}