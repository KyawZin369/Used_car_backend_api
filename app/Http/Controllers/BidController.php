<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Car;
use Illuminate\Http\Request;

class BidController extends Controller
{
    public function getBids($id)
{
    try {
        $bids = Bid::where('car_id', $id)
            ->with('car', 'user') // Eager load relationships
            ->orderBy('bid_price', 'desc')
            ->get();

        if ($bids->isEmpty()) {
            return response()->json(['message' => 'No bids found for this car.'], 404);
        }

        return response()->json(['bids' => $bids]);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Server error. Please try again later.', 'error' => $e->getMessage()], 500);
    }
}

    public function placeBid(Request $request, $id)
    {
        $request->validate([
            'bid_price' => 'required|numeric|min:0',
        ]);

        $highestBid = Bid::where('car_id', $id)->max('bid_price');
        if ($request->bid_price <= $highestBid) {
            return response()->json(['message' => 'Bid must be higher than the current highest bid.'], 400);
        }

        $bid = Bid::create([
            'car_id' => $id,
            'user_id' => auth()->id(),
            'bid_price' => $request->bid_price,
        ]);

        return response()->json(['message' => 'Bid placed successfully!', 'bid' => $bid]);
    }
}
