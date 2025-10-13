<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user()->id;
        // Har customer ke transactions ka total, paid aur remaining nikal lenge
        $customers = Customer::where('shopkeeper_id', $user)->withSum('transactions', 'total')
            ->withSum('transactions', 'paid')
            ->withSum('transactions', 'remaining')
            ->get();
        // dd($customers);
        // // Remaining calculate karna hai (total - paid)
        // foreach ($customers as $customer) {
        //     $customer->remaining_amount = $customer->transactions_sum_total_amount - $customer->transactions_sum_paid_amount;
        // }
        //    dd($customers);
        return view('admin.clients.customer.indexcusto', compact('customers'));
    }

    //  public function index()
    // {
    //     try {
    //         $user = Auth::user()->id;

    //         // Customers list with transaction sums
    //         $customers = Customer::where('shopkeeper_id', $user)
    //             ->withSum('transactions', 'total')
    //             ->withSum('transactions', 'paid')
    //             ->withSum('transactions', 'remaining')
    //             ->get();

    //         // ✅ Optional: Add custom calculated remaining
    //         $customers->map(function ($customer) {
    //             $customer->calculated_remaining = 
    //                 ($customer->transactions_sum_total ?? 0) - ($customer->transactions_sum_paid ?? 0);
    //             return $customer;
    //         });

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Customers fetched successfully',
    //             'data' => $customers
    //         ], 200);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Error fetching customers',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    /**
     * Show the form for creating a new resource.
     */
    // Show create form
    public function create()
    {
        return view('admin.clients.customer.customer');
    }

    // Store customer
    public function store(Request $request)
    {
        // dd($request->all());
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20|unique:customers,phone',
            // 'email'  => 'nullable|email|unique:customers,email',
            'address' => 'nullable|string|max:500',
        ]);
        $data['shopkeeper_id'] = Auth::id();
        // dd($data);
        Customer::create($data);

        return redirect()->route('customers.index')->with('success', 'Customer created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found.'
            ], 404);
        }

        $updated = $customer->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        if ($updated) {
            return response()->json([
                'success' => true,
                'message' => 'Customer updated successfully!',
                'data' => $customer
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No changes made or update failed.'
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        foreach ($customer->transactions as $transaction) {
            $transaction->items()->delete();
            $transaction->delete();
        }
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer and related transactions deleted successfully!');
    }

}
