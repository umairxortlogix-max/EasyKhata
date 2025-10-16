<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{


public function index()
{
    $LoginUser = auth()->user();

    // ===== Super Admin Data =====
    $clientCount = User::role('Client')->where('is_active', 1)->count();
    $adminCount = User::role('super-admin')->count();
    $totalUsers = User::count();

    // ===== Client Data =====
    $customersCount = Customer::where('shopkeeper_id', $LoginUser->id)->count();
    $transectionQuery = Transaction::where('shopkeeper_id', $LoginUser->id);

    $transectionCount = $transectionQuery->count();

    // ✅ Transaction sums
    $transectionPaid = (clone $transectionQuery)->sum('paid');
    $transectionTotal = (clone $transectionQuery)->sum('total');
    $transectionRemaining = (clone $transectionQuery)->sum('remaining');

    $transactionStats = (object) [
        'paid' => $transectionPaid,
        'total' => $transectionTotal,
        'remaining' => $transectionRemaining,
    ];

    // ===== Transaction History for Charts =====
    $transactionStatsHistory = [];

    // Collect last 30 days for daily chart
    $transactions = $transectionQuery
        ->select(
            DB::raw("DATE(created_at) as date"),
            DB::raw("SUM(paid) as paid"),
            DB::raw("SUM(total) as total"),
            DB::raw("SUM(remaining) as remaining"),
            DB::raw("COUNT(DISTINCT customer_id) as customers_count"),
            DB::raw("COUNT(*) as transactions_count")
        )
        ->where('created_at', '>=', Carbon::now()->subDays(30))
        ->groupBy(DB::raw("DATE(created_at)"))
        ->orderBy('date')
        ->get();

    foreach ($transactions as $t) {
        $transactionStatsHistory[] = [
            'date' => $t->date,
            'paid' => $t->paid,
            'total' => $t->total,
            'remaining' => $t->remaining,
            'customers_count' => $t->customers_count,
            'transactions_count' => $t->transactions_count,
        ];
    }

    // ✅ Pass all data to the view
    return view('dashboard', compact(
        'clientCount',
        'adminCount',
        'totalUsers',
        'customersCount',
        'transectionCount',
        'transactionStats',
        'transactionStatsHistory'
    ));
}


}
