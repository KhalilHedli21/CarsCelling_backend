<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Http\Requests\StoreCarRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
    // Récupérer toutes les voitures (pour les visiteurs)
    public function index() {
        $cars = Car::with('images')->latest()->get();
        return response()->json($cars);
    }

    // Créer une nouvelle annonce (client)
    public function store(StoreCarRequest $request) {
        try {
            \Log::info('Car creation request data:', $request->all());

            // Collect features into an array
            $features = [];
            if ($request->has('engine_size')) $features['engine_size'] = $request->engine_size;
            if ($request->has('power')) $features['power'] = $request->power;
            if ($request->has('seats')) $features['seats'] = $request->seats;
            if ($request->has('doors')) $features['doors'] = $request->doors;

            $car = Car::create([
                'make' => $request->brand,
                'model' => $request->model,
                'year' => $request->year,
                'price' => $request->price,
                'mileage' => $request->mileage,
                'fuel_type' => $request->fuel_type,
                'transmission' => $request->transmission,
                'description' => $request->description,
                'color' => $request->color,
                'location' => $request->location,
                'condition' => $request->condition,
                'status' => $request->status ?? 'available',
                'features' => $features,
                'user_id' => Auth::id()
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('car-images', 'public');
                    $car->images()->create(['image_path' => $path]);
                }
            }

            return response()->json([
                'message' => 'Voiture ajoutée avec succès',
                'car' => $car->load('images')
            ], 201);
        } catch (\Exception $e) {
            \Log::error('Error creating car: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'message' => 'Erreur lors de l\'ajout de la voiture',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Mettre à jour une annonce (client/admin)
    public function update(StoreCarRequest $request, Car $car) {
        if ($car->user_id !== Auth::id()) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        try {
            $car->update([
                'make' => $request->make,
                'model' => $request->model,
                'year' => $request->year,
                'price' => $request->price,
                'mileage' => $request->mileage,
                'fuel_type' => $request->fuel_type,
                'transmission' => $request->transmission,
                'description' => $request->description
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('car-images', 'public');
                    $car->images()->create(['image_path' => $path]);
                }
            }

            return response()->json([
                'message' => 'Voiture mise à jour avec succès',
                'car' => $car->load('images')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la mise à jour de la voiture',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Supprimer une annonce (client/admin)
    public function destroy(Car $car) {
        if ($car->user_id !== Auth::id()) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        try {
            $car->delete();
            return response()->json(['message' => 'Voiture supprimée avec succès']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la suppression de la voiture',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Car $car)
    {
        return response()->json($car->load('images'));
    }
}