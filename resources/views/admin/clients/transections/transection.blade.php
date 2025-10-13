<x-app-layout>
    <!-- Paper-Style Transactions View -->
    <style>
        :root {
            --bg: #f9f8f4;
            --paper: #fff;
            --ink: #2b2b2b;
            --accent: #3b82f6;
            --border: #e5e2da;
            --shadow: rgba(0, 0, 0, 0.05);
        }

        body {
            background: var(--bg);
            color: var(--ink);
            font-family: "Inter", "Poppins", sans-serif;
        }

        .paper-page {
            max-width: 1100px;
            margin: 0 auto;
            padding: 2rem;
        }

        .paper-card {
            background: var(--paper);
            border: 1px solid var(--border);
            border-radius: 8px;
            box-shadow: 0 3px 6px var(--shadow);
            padding: 1.5rem;
        }

        .paper-header {
            border-bottom: 1px dashed #d6d3cd;
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
        }

        .paper-avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: #f4f2ed;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: var(--accent);
        }

        .paper-btn {
            border: 1px solid var(--border);
            background: #fafafa;
            border-radius: 6px;
            padding: 0.45rem 0.9rem;
            font-weight: 600;
            color: var(--accent);
        }

        .paper-transaction {
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 1rem;
            background: #fffefc;
            margin-bottom: 1rem;
        }

        .paper-items li {
            display: flex;
            justify-content: space-between;
            padding: 0.4rem 0;
            border-bottom: 1px dotted #e2dfd8;
            font-size: 0.95rem;
        }

        .no-transactions {
            text-align: center;
            color: #888;
            font-style: italic;
            padding: 2rem 0;
        }
    </style>

    <div class="paper-page">
        <div class="paper-card mb-6">
            <!-- Header -->
            <div class="flex items-center justify-between paper-header">
                <div class="flex items-center gap-4">
                    <div class="paper-avatar">{{ strtoupper(substr($customer->name ?? 'C', 0, 1)) }}</div>
                    <div>
                        <h2 class="text-xl font-bold">
                            Transactions for
                            <span class="text-blue-600">{{ $customer->name ?? 'Unknown' }}</span>
                        </h2>
                        <p class="text-sm text-gray-500">Customer ID: {{ $customer->id ?? '—' }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ url()->previous() }}" class="paper-btn">← Back</a>
                    <a href="#" class="paper-btn">Export</a>
                </div>
            </div>

            @if($transactions->isEmpty())
                <p class="no-transactions">No transactions found for this customer.</p>
            @else
                @php
                    $totalAmount = $transactions->sum(fn($t) => $t->total ?? $t->items->sum(fn($i) => $i->price * $i->quantity));
                    $totalPaid = $transactions->sum('paid');
                    $totalRemaining = $totalAmount - $totalPaid;
                @endphp

                <!-- Overall Summary (Table Format) -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <h3 class="text-lg font-semibold text-blue-700 mb-3">Overall Summary</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left border border-blue-200 rounded-lg">
                            <thead class="bg-blue-100 text-blue-800">
                                <tr>
                                    <th class="px-4 py-2 border-b border-blue-200">Total Transactions</th>
                                    <th class="px-4 py-2 border-b border-blue-200">Total Amount</th>
                                    <th class="px-4 py-2 border-b border-blue-200">Total Paid</th>
                                    <th class="px-4 py-2 border-b border-blue-200">Remaining Balance</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <tr class="hover:bg-blue-50 transition">
                                    <td class="px-4 py-2 border-b border-blue-100 text-gray-800">
                                        {{ $transactions->count() }}
                                    </td>
                                    <td class="px-4 py-2 border-b border-blue-100 text-gray-800">
                                        {{ number_format($totalAmount, 2) }}
                                    </td>
                                    <td class="px-4 py-2 border-b border-blue-100 text-green-700 font-semibold">
                                        {{ number_format($totalPaid, 2) }}
                                    </td>
                                    <td class="px-4 py-2 border-b border-blue-100 text-red-600 font-semibold">
                                        {{ number_format($totalRemaining, 2) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


                <!-- Individual Transactions -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($transactions as $transaction)
                                <div class="paper-transaction">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-3">
                                        <div class="text-gray-500 font-medium">
                                            Transaction ID: #{{ $transaction->id }}
                                        </div>
                                        <div class="text-gray-500 font-medium">
                                            Date: {{ optional($transaction->created_at)->format('d M Y, h:i A') }}
                                        </div>
                                    </div>

                                    <ul class="paper-items">
                                        @foreach($transaction->items as $item)
                                            <li>
                                                <span>{{ $item->item_name ?? 'Item' }} (x{{ $item->quantity }})</span>
                                                <span>{{ number_format($item->quantity * $item->price, 2) }}</span>
                                            </li>
                                        @endforeach
                                    </ul>

                                    <!-- Transaction Summary (Table View) -->
                                    <div class="mt-3 overflow-x-auto">
                                        <table class="min-w-full text-sm border border-gray-200 rounded-lg">
                                            <thead class="bg-gray-100 text-gray-700">
                                                <tr>
                                                    <th class="px-4 py-2 text-left border-b">Items</th>
                                                    <th class="px-4 py-2 text-left border-b">Total</th>
                                                    <th class="px-4 py-2 text-left border-b">Paid</th>
                                                    <th class="px-4 py-2 text-left border-b">Remaining</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white">
                                                <tr class="hover:bg-gray-50 transition">
                                                    <td class="px-4 py-2 border-b text-gray-800">
                                                        {{ $transaction->items->count() }}
                                                    </td>
                                                    <td class="px-4 py-2 border-b text-gray-800">
                                                        {{ number_format($transaction->total ?? $transaction->items->sum(fn($i) => $i->price * $i->quantity), 2) }}
                                                    </td>
                                                    <td class="px-4 py-2 border-b text-green-700 font-semibold">
                                                        {{ number_format($transaction->paid ?? 0, 2) }}
                                                    </td>
                                                    <td class="px-4 py-2 border-b text-red-600 font-semibold">
                                                        {{ number_format(
                            ($transaction->total ?? $transaction->items->sum(fn($i) => $i->price * $i->quantity)) - ($transaction->paid ?? 0),
                            2
                        ) }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>