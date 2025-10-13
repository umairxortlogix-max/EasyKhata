<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth; // ✅ Correct import
use Illuminate\Http\Request;

class TransactionController extends Controller
{
//   public function showTransactions($customer_id)
// {
//     $user = Auth::id();

//     $customer = Customer::where('id', $customer_id)
//         ->where('shopkeeper_id', $user)
//         ->firstOrFail();

//     $transactions = Transaction::with('items')
//         ->where('customer_id', $customer_id)
//         ->get();

//     return response()->json([
//         'customer' => $customer,
//         'transactions' => $transactions,
//     ], 200);
// }


  public function showTransactions($customer_id)
{
    // Get customer (for now, shopkeeper_id = 11)
    $customer = Customer::where('id', $customer_id)
        ->firstOrFail();

    // Fetch transactions with items
    $transactions = Transaction::with('items')
        ->where('customer_id', $customer_id)
        ->get();

    // Compute summary
    $totalAmount = $transactions->sum(function ($t) {
        return $t->total ?? $t->items->sum(fn($i) => $i->price * $i->quantity);
    });

    $totalPaid = $transactions->sum('paid');
    $totalRemaining = $totalAmount - $totalPaid;

    // Return full structured data
    return response()->json([
        'customer' => $customer,
        'transactions' => $transactions,
        'summary' => [
            'total_transactions' => $transactions->count(),
            'total_amount' => $totalAmount,
            'total_paid' => $totalPaid,
            'total_remaining' => $totalRemaining,
        ]
    ], 200);
}

}
