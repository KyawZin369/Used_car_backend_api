<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
// Add necessary imports
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class CarController extends Controller
{

    protected $queryWith = ['user'];

    public function publicIndex(): JsonResponse
{
    try {
        // Fetch all cars
        $cars = Car::all();

        // Check if cars exist
        if ($cars->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No cars found',
            ], 404);
        }

        // Return cars data
        return response()->json([
            'status' => 'success',
            'cars' => $cars,
        ], 200);
    } catch (\Exception $e) {
        // Log any unexpected errors
        Log::error('Error fetching cars:', ['error' => $e->getMessage()]);

        return response()->json([
            'status' => 'error',
            'message' => 'An error occurred while fetching cars',
        ], 500);
    }
}

    public function index()
    {
        $cars = Car::with($this->queryWith)->get();

        if($cars){
            return response()->json(['cars' => $cars], 200);
        }

        return response()->json(['message' => 'No cars found'], 404);
    }

    public function show($carId)
    {
        $car = Car::findOrFail($carId);

        if($car){
            return response()->json(['car' => $car], 200);
        }

        return response()->json(['message' => 'Car is not available'], 404);
    }

    public function searchCars(Request $request)
    {
        $query = Car::query();

        if ($request->has('make')) {
            $query->where('make', $request->make);
        }
        if ($request->has('model')) {
            $query->where('model', $request->model);
        }
        if ($request->has('registration_year')) {
            $query->where('registration_year', $request->registration_year);
        }
        if ($request->has('price_range')) {
            $range = explode('-', $request->price_range);
            $query->whereBetween('price', [$range[0], $range[1]]);
        }

        $cars = $query->get();
        return response()->json(['cars' => $cars], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'make' => 'required|string',
            'model' => 'required|string',
            'registration_year' => 'required|integer',
            'price' => 'required|numeric',
            'picture_url' => 'required|url',
        ]);

        $validated['user_id'] = $request->user()->id;
        $car = Car::create($validated);

        return response()->json(['car' => $car], 201);
    }

    public function update(Request $request, $carId)
    {
        $car = Car::findOrFail($carId);
        $car->update($request->only('make', 'model', 'registration_year', 'price', 'picture_url'));

        return response()->json(['car' => $car], 200);
    }

    public function destroy($carId)
    {
        $car = Car::findOrFail($carId);
        $car->delete();

        return response()->json(['message' => 'Car deleted successfully'], 200);
    }

    public function carsWithBids()
{
    // Fetch cars with their associated bids
    $cars = Car::whereHas('bids') // Only include cars that have bids
               ->with('bids') // Eager load the bids relationship
               ->get();

    return response()->json($cars);
}
}

