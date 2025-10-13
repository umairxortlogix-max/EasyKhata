<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{

    public function index(Request $request)
    {

        $user = $request->user(); // 👈 must return logged-in user
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
        }

        // Only fetch customers for logged-in user
        $customers = Customer::where('shopkeeper_id', $user->id)
            ->withSum('transactions', 'total')
            ->get()
            ->map(function ($customer) {
                $customer->calculated_remaining = $customer->transactions_sum_total - $customer->paid_amount;
                return $customer;
            });

        return response()->json([
            'status' => true,
            'data' => $customers,
        ]);
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20|unique:customers,phone',
            // 'email'  => 'nullable|email|unique:customers,email',
            'address' => 'nullable|string|max:500',
        ]);
        $data['shopkeeper_id'] = $request->user()->id;
        // dd($data);
        Customer::create($data);
       return response()->json([
            'status' => true,
            'message' => 'Customer created successfully',
        ], 201);
        // return redirect()->route('customers.index')->with('success', 'Customer created successfully!');
    }

}
