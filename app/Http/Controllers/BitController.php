<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bid;

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

        $validated['car_id'] = $carId;
        $validated['user_id'] = $request->user()->id;

        $bid = Bid::create($validated);

        return response()->json(['bid' => $bid], 201);
    }
}
