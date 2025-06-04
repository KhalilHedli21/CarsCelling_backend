<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Http\Requests\StoreCarRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CarController extends Controller
{
    // Récupérer toutes les voitures (pour les visiteurs)
    public function index(Request $request) {
        $query = Car::with('user', 'images');
        
        // Filter by price range
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        
        // Filter by model/brand
        if ($request->has('model')) {
            $query->where('model', 'like', '%' . $request->model . '%');
        }
        
        return $query->paginate(10);
    }

    // Créer une nouvelle annonce (client)
    public function store(StoreCarRequest $request) {
        $car = auth()->user()->cars()->create($request->validated());
        
        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('cars', 'public');
                $car->images()->create(['path' => $path]);
            }
        }
        
        return response()->json($car->load('images'), 201);
    }

    // Mettre à jour une annonce (client/admin)
    public function update(StoreCarRequest $request, Car $car) {
        $car->update($request->validated());
        
        // Handle image uploads
        if ($request->hasFile('images')) {
            // Optionally delete old images first
            $car->images()->delete();
            
            foreach ($request->file('images') as $image) {
                $path = $image->store('cars', 'public');
                $car->images()->create(['path' => $path]);
            }
        }
        
        return response()->json($car->load('images'));
    }

    // Supprimer une annonce (client/admin)
    public function destroy(Car $car) {
        $car->delete();
        return response()->json(null, 204);
    }
}