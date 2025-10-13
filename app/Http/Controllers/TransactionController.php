<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // public function index() {
    //     $transactions = Transaction::with('customer', 'items')->where('shopkeeper_id', Auth::id())->get();
    //     return view('transactions.index', compact('transactions'));
    // }

    // public function create() {
    //     $customers = Customer::where('shopkeeper_id', Auth::id())->get();
    //     return view('transactions.create', compact('customers'));
    // }

    // public function store(Request $request) {
    //     $request->validate([
    //         'customer_id' => 'required|exists:customers,id',
    //         'items'       => 'required|array',
    //     ]);

    //     $total = collect($request->items)->sum(function ($item) {
    //         return $item['quantity'] * $item['price'];
    //     });

    //     $paid = $request->paid ?? 0;
    //     $remaining = $total - $paid;

    //     $transaction = Transaction::create([
    //         'customer_id'   => $request->customer_id,
    //         'shopkeeper_id' => Auth::id(),
    //         'total'         => $total,
    //         'paid'          => $paid,
    //         'remaining'     => $remaining,
    //     ]);

    //     foreach ($request->items as $item) {
    //         Transaction::create([
    //             'transaction_id' => $transaction->id,
    //             'item_name'      => $item['name'],
    //             'quantity'       => $item['quantity'],
    //             'price'          => $item['price'],
    //             'total'          => $item['quantity'] * $item['price'],
    //         ]);
    //     }

    //     return redirect()->route('transactions.index')->with('success', 'Transaction added successfully!');
    // }



    public function create()
    {
        $user=Auth::user()->id;
        $customers = Customer::where('shopkeeper_id',$user)->get();
        return view('admin.clients.customer.index', compact('customers'));
    }

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

        return redirect()->route('transactions.create')->with('success', 'Transaction saved successfully.');
    }
   public function show($customer_id)
{
    $user = Auth::id();
    $customer = Customer::where('id', $customer_id)->where('shopkeeper_id', $user)->firstOrFail();
    $transactions = Transaction::with('items')->where('customer_id', $customer_id)->get();
    // dd($customer, $transactions);
    return view('admin.clients.transections.transection', compact('customer', 'transactions'));
}

}
