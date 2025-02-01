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

    // Method to get bids related to the carId
    public function showBids($carId)
    {
        $bids = Bid::where('car_id', $carId)->get();

        return response()->json([
            'bids' => $bids
        ]);
    }

    // Method to approve a bid
    public function approveBid($bidId)
    {
        // First, make sure no other bid for this car is approved
        $bid = Bid::find($bidId);

        if ($bid) {
            // Set all bids for this car to not approved
            Bid::where('car_id', $bid->car_id)->update(['approve' => false]);

            // Set the clicked bid as approved
            $bid->approve = true;
            $bid->save();

            return response()->json([
                'message' => 'Bid approved successfully!',
                'approved_bid' => $bid
            ]);
        }

        return response()->json(['message' => 'Bid not found'], 404);
    }

    public function myBids(Request $request, $user_id)
{
    $bids = Bid::where('user_id', $user_id)
        ->where('approve', true)
        ->with('car') // Load car details
        ->get();

    return response()->json(['bids' => $bids]);
}

}
