<x-app-layout>
    <style>
        :root {
            --bg: #f3f4f6;
            --surface: #ffffff;
            --text: #0f172a;
            --muted: #64748b;
            --primary: #2563eb;
            --success: #16a34a;
            --danger: #dc2626;
            --border: #e2e8f0;
            --shadow: 0 18px 50px rgba(15, 23, 42, 0.08);
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: "Inter", "Poppins", sans-serif;
        }

        .transaction-page {
            max-width: 1160px;
            margin: 0 auto;
            padding: 2rem 1rem 3rem;
        }

        .transaction-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 1.25rem;
            box-shadow: var(--shadow);
            padding: 1.75rem;
        }

        .transaction-header {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 1.25rem;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 1.5rem;
            margin-bottom: 1.75rem;
        }

        .transaction-details {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .avatar {
            width: 64px;
            height: 64px;
            border-radius: 1rem;
            background: #eff6ff;
            display: grid;
            place-items: center;
            font-weight: 700;
            color: var(--primary);
            font-size: 1.35rem;
        }

        .transaction-title {
            margin: 0;
            font-size: 2rem;
            line-height: 1.1;
            color: var(--text);
        }

        .transaction-subtitle {
            margin: 0.35rem 0 0;
            color: var(--muted);
        }

        .button-group {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            align-items: center;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.85rem 1.25rem;
            border-radius: 0.85rem;
            border: 1px solid transparent;
            font-weight: 600;
            text-decoration: none;
            transition: transform 150ms ease, box-shadow 150ms ease, background-color 150ms ease;
        }

        .btn-primary {
            background: var(--primary);
            color: #ffffff;
            border-color: transparent;
        }

        .btn-secondary {
            background: #f8fafc;
            color: var(--primary);
            border-color: #c7d2fe;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.12);
        }

        .summary-grid {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            margin-bottom: 1.75rem;
        }

        .summary-card {
            background: #f8fafc;
            border: 1px solid #e0e7ff;
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .summary-label {
            margin: 0;
            color: var(--muted);
            font-size: 0.82rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .summary-value {
            margin: 0.9rem 0 0;
            font-size: 1.85rem;
            color: var(--text);
            font-weight: 700;
        }

        .transaction-grid {
            display: grid;
            gap: 1.5rem;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        }

        .transaction-card-item {
            border: 1px solid var(--border);
            border-radius: 1.25rem;
            padding: 1.5rem;
            background: #ffffff;
            transition: transform 150ms ease, box-shadow 150ms ease;
        }

        .transaction-card-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.08);
        }

        .transaction-meta {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }

        .transaction-meta span {
            color: var(--muted);
            font-size: 0.95rem;
        }

        .item-list {
            list-style: none;
            margin: 0;
            padding: 0;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            overflow: hidden;
            background: #f8fafc;
        }

        .item-row {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 1rem;
            padding: 0.9rem 1rem;
            border-bottom: 1px solid #e2e8f0;
            color: var(--text);
        }

        .item-row:last-child {
            border-bottom: none;
        }

        .table-wrap {
            overflow-x: auto;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .summary-table th,
        .summary-table td {
            padding: 0.85rem 0.9rem;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .summary-table th {
            color: #475569;
            font-size: 0.86rem;
            font-weight: 700;
            background: #f8fafc;
        }

        .summary-table td {
            color: var(--text);
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.45rem 0.85rem;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .status-paid {
            background: #dcfce7;
            color: #166534;
        }

        .status-due {
            background: #fee2e2;
            color: #991b1b;
        }

        .pagination-wrap {
            margin-top: 2.5rem;
            display: flex;
            justify-content: center;
            padding: 0 1rem;
        }

        .pagination-wrap nav {
            display: inline-flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
        }

        .pagination-wrap a,
        .pagination-wrap span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 2.85rem;
            height: 2.85rem;
            padding: 0 0.5rem;
            color: var(--text);
            text-decoration: none;
            border: 1px solid #cbd5e1;
            border-radius: 0.75rem;
            background: #ffffff;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 200ms cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }

        .pagination-wrap a:hover:not(.disabled) {
            background: #eff6ff;
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(37, 99, 235, 0.12);
        }

        .pagination-wrap span.relative {
            border: none;
            background: transparent;
            color: var(--muted);
            cursor: default;
        }

        .pagination-wrap .active span {
            background: var(--primary);
            color: #ffffff;
            border-color: var(--primary);
            font-weight: 700;
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.15);
        }

        .pagination-wrap .disabled {
            color: #cbd5e1;
            cursor: not-allowed;
            opacity: 0.5;
        }

        .pagination-wrap .disabled:hover {
            background: #ffffff;
            border-color: #cbd5e1;
            transform: none;
            box-shadow: none;
        }

        .no-transactions {
            text-align: center;
            color: var(--muted);
            font-style: italic;
            padding: 3rem 0;
        }

        .filter-form {
            background: #f8fafc;
            border: 1px solid #e0e7ff;
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 1.75rem;
        }

        .filter-row {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            align-items: flex-end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .filter-label {
            color: var(--muted);
            font-size: 0.82rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-weight: 600;
        }

        .filter-input {
            padding: 0.75rem 1rem;
            border: 1px solid #cbd5e1;
            border-radius: 0.75rem;
            background: #ffffff;
            color: var(--text);
            font-size: 0.95rem;
            font-family: inherit;
            transition: all 200ms ease;
        }

        .filter-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .filter-button {
            display: inline-flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .btn-filter {
            padding: 0.75rem 1.25rem;
            border-radius: 0.75rem;
            border: none;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 200ms ease;
        }

        .btn-apply {
            background: var(--primary);
            color: #ffffff;
        }

        .btn-apply:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(37, 99, 235, 0.12);
        }

        .btn-reset {
            background: #e2e8f0;
            color: var(--text);
            border: 1px solid #cbd5e1;
        }

        .btn-reset:hover {
            background: #f1f5f9;
        }

        .btn-whatsapp {
            background: #25D366 !important;
            color: #ffffff !important;
        }

        .btn-whatsapp:hover {
            background: #20BA5A !important;
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(37, 211, 102, 0.3) !important;
        }

        @media print {
            body {
                background: white !important;
                color: black !important;
            }

            .transaction-page {
                max-width: none;
                margin: 0;
                padding: 0;
            }

            .transaction-card {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
            }

            .button-group,
            .filter-form,
            .pagination-wrap {
                display: none !important;
            }

            .transaction-header {
                border-bottom: 2px solid black !important;
                margin-bottom: 20px !important;
            }

            .summary-grid {
                background: white !important;
                border: 1px solid black !important;
                margin-bottom: 20px !important;
            }

            .summary-card {
                background: white !important;
                border: 1px solid #ccc !important;
            }

            table {
                border: 1px solid black !important;
            }

            th, td {
                border: 1px solid #666 !important;
            }

            .status-pill {
                border: 1px solid currentColor !important;
                background: white !important;
                color: black !important;
                font-weight: bold;
            }

            .no-transactions {
                border: 1px solid black !important;
                padding: 20px !important;
                text-align: center !important;
            }
        }
    </style>

    <div class="transaction-page">
        <div class="transaction-card">
            <div class="transaction-header">
                <div class="transaction-details">
                    <div class="avatar">{{ strtoupper(substr($customer->name ?? 'C', 0, 1)) }}</div>
                    <div>
                        <p class="summary-label">Customer Ledger</p>
                        <h1 class="transaction-title">{{ $customer->name ?? 'Unknown Customer' }}</h1>
                        <p class="transaction-subtitle">Customer ID: {{ $customer->id ?? '—' }}</p>
                    </div>
                </div>

                <div class="button-group">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">← Back</a>
                    <button onclick="window.print()" class="btn btn-primary">Print</button>
                    <a href="{{ route('transactions.export-pdf', $customer->id) . '?' . http_build_query(request()->only(['from_date', 'to_date'])) }}" class="btn btn-primary">Export PDF</a>
                    <form method="POST" action="{{ route('transactions.send-whatsapp', $customer->id) }}" style="display: inline;">
                        @csrf
                        <input type="hidden" name="from_date" value="{{ request('from_date') }}">
                        <input type="hidden" name="to_date" value="{{ request('to_date') }}">
                        <button type="submit" class="btn btn-whatsapp" onclick="return confirm('Send transaction summary to WhatsApp?\n\nPhone: {{ $customer->phone }}');">📱 Send WhatsApp Message</button>
                    </form>
                </div>
            </div>

            @if($transactions->isEmpty())
                <p class="no-transactions">No transactions found for this customer.</p>
            @else
                <form method="GET" action="{{ route('transactions.show', $customer->id) }}" class="filter-form">
                    <div class="filter-row">
                        <div class="filter-group">
                            <label class="filter-label">From Date</label>
                            <input type="date" name="from_date" class="filter-input" value="{{ old('from_date', $fromDate) }}">
                        </div>

                        <div class="filter-group">
                            <label class="filter-label">To Date</label>
                            <input type="date" name="to_date" class="filter-input" value="{{ old('to_date', $toDate) }}">
                        </div>

                        <div class="filter-button">
                            <button type="submit" class="btn-filter btn-apply">Apply Filter</button>
                            <a href="{{ route('transactions.show', $customer->id) }}" class="btn-filter btn-reset">Reset</a>
                        </div>
                    </div>
                </form>

                <div class="summary-grid">
                    <div class="summary-card">
                        <p class="summary-label">Transactions</p>
                        <p class="summary-value">{{ $transactions->total() }}</p>
                    </div>
                    <div class="summary-card">
                        <p class="summary-label">Total Amount</p>
                        <p class="summary-value">{{ number_format($totalAmount, 2) }}</p>
                    </div>
                    <div class="summary-card">
                        <p class="summary-label">Total Paid</p>
                        <p class="summary-value" style="color: var(--success);">{{ number_format($totalPaid, 2) }}</p>
                    </div>
                    <div class="summary-card">
                        <p class="summary-label">Remaining</p>
                        <p class="summary-value" style="color: var(--danger);">{{ number_format($totalRemaining, 2) }}</p>
                    </div>
                </div>

                <div class="transaction-grid">
                    @foreach($transactions as $transaction)
                        @php
                            $transactionTotal = $transaction->total ?? $transaction->items->sum(fn($i) => $i->price * $i->quantity);
                            $transactionDue = $transactionTotal - ($transaction->paid ?? 0);
                        @endphp
                        <div class="transaction-card-item">
                            <div class="transaction-meta">
                                <div>
                                    <p class="summary-label">Transaction ID</p>
                                    <p class="transaction-subtitle">#{{ $transaction->id }}</p>
                                </div>
                                <div>
                                    <p class="summary-label">Date</p>
                                    <p class="transaction-subtitle">{{ optional($transaction->created_at)->format('d M Y, h:i A') }}</p>
                                </div>
                                <div>
                                    <p class="summary-label">Status</p>
                                    <span class="status-pill {{ $transactionDue > 0 ? 'status-due' : 'status-paid' }}">
                                        {{ $transactionDue > 0 ? 'Pending' : 'Settled' }}
                                    </span>
                                </div>
                            </div>

                            <ul class="item-list">
                                @foreach($transaction->items as $item)
                                    <li class="item-row">
                                        <span>{{ $item->item_name ?? 'Item' }} <strong>x{{ $item->quantity }}</strong></span>
                                        <span>{{ number_format($item->quantity * $item->price, 2) }}</span>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="table-wrap">
                                <table class="summary-table">
                                    <thead>
                                        <tr>
                                            <th>Total</th>
                                            <th>Paid</th>
                                            <th>Remaining</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ number_format($transactionTotal, 2) }}</td>
                                            <td style="color: var(--success);">{{ number_format($transaction->paid ?? 0, 2) }}</td>
                                            <td style="color: var(--danger);">{{ number_format($transactionDue, 2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pagination-wrap">
                    {{ $transactions->links('pagination::simple-bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>