<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\Auth; // ✅ Correct import
use Illuminate\Http\Request;

class TransactionController extends Controller
{
  public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'total_amount' => 'nullable|numeric',
            'paid_amount' => 'nullable|numeric',
            'remaining_amount' => 'nullable|numeric',
            'items' => 'nullable|string', // JSON string from form
        ]);
        $items = json_decode($request->items, true);
        if (!$items || count($items) === 0) {
            return back()->withErrors(['items' => 'At least one item is required.']);
        }
        $transaction = Transaction::create([
            'shopkeeper_id' => Auth::id(),
            'customer_id' => $request->customer_id,
            'total' => $request->total_amount,
            'paid' => $request->paid_amount,
            'remaining' => $request->remaining_amount,
        ]);
        //    dd($transaction);
        foreach ($items as $item) {
            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'item_name' => $item['item_name'],
                'quantity' => $item['qty'],
                'price' => $item['price'],
                'total' => $item['total'],
            ]);
        }

     return response()->json([
     'status'=>true,
     'massage'=>'Transections Created Successfully',
     ],201);
    }

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
