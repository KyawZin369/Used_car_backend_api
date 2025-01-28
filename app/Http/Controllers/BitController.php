<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bid;
use App\Models\User;

class BitController extends Controller
{

    public function index()
    {
        $bids = Bid::all();
        return response()->json(['bids' => $bids], 200);
    }

    public function show($bidId)
    {
        $bid = Bid::findOrFail($bidId);
        return response()->json(['bid' => $bid], 200);
    }

    public function update(Request $request, $carId)
    {
        $validated = $request->validate([
            'bid_price' => 'required|numeric',
        ]);

        $bid = Bid::where('car_id', $carId)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$bid) {
            return response()->json(['message' => 'Bid not found'], 404);
        }

        $bid->update($validated);

        // Return the updated bid
        return response()->json(['bid' => $bid], 200);
    }

    public function create(Request $request) {

        $validated = $request->validate(([
            'bid_price' => 'required|numeric',
            'car_id' =>  'required|integer|exists:cars,id',
        ]));

        $validated['user_id'] = auth()->id();

        $bid = Bid::create($validated);

        return response()->json(['bid' => $bid], 201);
    }
}
