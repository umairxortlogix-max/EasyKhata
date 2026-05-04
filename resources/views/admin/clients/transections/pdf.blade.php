<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Transactions Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
        }
        .summary {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
        }
        .summary div {
            text-align: center;
        }
        .summary .value {
            font-size: 18px;
            font-weight: bold;
            color: #2563eb;
        }
        .summary .label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .transaction-items {
            margin-top: 10px;
        }
        .transaction-items table {
            font-size: 12px;
        }
        .transaction-items th, .transaction-items td {
            padding: 4px;
        }
        .status {
            padding: 4px 8px;
            border-radius: 4px;
            color: white;
            font-size: 12px;
        }
        .status-paid {
            background-color: #16a34a;
        }
        .status-due {
            background-color: #dc2626;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Customer Transactions Report</h1>
        <p><strong>Customer:</strong> {{ $customer->name }}</p>
        <p><strong>Customer ID:</strong> {{ $customer->id }}</p>
        @if($fromDate || $toDate)
            <p><strong>Report Period:</strong>
                @if($fromDate) From {{ \Carbon\Carbon::parse($fromDate)->format('d M Y') }} @endif
                @if($toDate) To {{ \Carbon\Carbon::parse($toDate)->format('d M Y') }} @endif
            </p>
        @endif
        <p><strong>Generated on:</strong> {{ now()->format('d M Y, H:i') }}</p>
    </div>

    <div class="summary">
        <div>
            <div class="value">{{ number_format($totalAmount, 2) }}</div>
            <div class="label">Total Amount</div>
        </div>
        <div>
            <div class="value" style="color: #16a34a;">{{ number_format($totalPaid, 2) }}</div>
            <div class="label">Total Paid</div>
        </div>
        <div>
            <div class="value" style="color: #dc2626;">{{ number_format($totalRemaining, 2) }}</div>
            <div class="label">Remaining</div>
        </div>
        <div>
            <div class="value">{{ $transactions->count() }}</div>
            <div class="label">Transactions</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Total</th>
                <th>Paid</th>
                <th>Remaining</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->created_at->format('d M Y, H:i') }}</td>
                    <td>{{ number_format($transaction->total ?? $transaction->items->sum(fn($i) => $i->price * $i->quantity), 2) }}</td>
                    <td>{{ number_format($transaction->paid ?? 0, 2) }}</td>
                    <td>{{ number_format(($transaction->total ?? $transaction->items->sum(fn($i) => $i->price * $i->quantity)) - ($transaction->paid ?? 0), 2) }}</td>
                    <td>
                        <span class="status {{ (($transaction->total ?? $transaction->items->sum(fn($i) => $i->price * $i->quantity)) - ($transaction->paid ?? 0)) > 0 ? 'status-due' : 'status-paid' }}">
                            {{ (($transaction->total ?? $transaction->items->sum(fn($i) => $i->price * $i->quantity)) - ($transaction->paid ?? 0)) > 0 ? 'Pending' : 'Settled' }}
                        </span>
                    </td>
                </tr>
                @if($transaction->items->count() > 0)
                    <tr>
                        <td colspan="6">
                            <div class="transaction-items">
                                <strong>Items:</strong>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Item Name</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($transaction->items as $item)
                                            <tr>
                                                <td>{{ $item->item_name }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ number_format($item->price, 2) }}</td>
                                                <td>{{ number_format($item->total ?? ($item->price * $item->quantity), 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>This report was generated by EasyKhata system.</p>
    </div>
</body>
</html>