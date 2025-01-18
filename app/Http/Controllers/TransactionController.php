<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{

    protected $dataWith = ["user", "car", "bid"];

    public function index() {
        $transactions = Transaction::with($this->dataWith)->get();

        if($transactions) {
            return response()->json(['transactions' => $transactions], 200);
        }
        return response()->json(['message' => 'No transactions found'], 404);
    }
}
