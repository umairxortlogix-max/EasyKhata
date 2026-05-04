<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Twilio\Rest\Client;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::id();
        $query = Transaction::with('customer', 'items')->where('shopkeeper_id', $user);

        // Filtering by customer
        if ($request->has('customer_id') && $request->customer_id) {
            $query->where('customer_id', $request->customer_id);
        }

        // Filtering by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $transactions = $query->paginate(10); // Paginate with 10 per page

        $customers = Customer::where('shopkeeper_id', $user)->get(); // For filter dropdown

        return view('transactions.index', compact('transactions', 'customers'));
    }

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
        $user = Auth::user()->id;
        $customers = Customer::where('shopkeeper_id', $user)->get();
        return view('admin.clients.customer.index', compact('customers'));
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'customer_id' => 'required|exists:customers,id',
    //         'total_amount' => 'nullable|numeric',
    //         'paid_amount' => 'nullable|numeric',
    //         'remaining_amount' => 'nullable|numeric',
    //         'items' => 'nullable|string', // JSON string from form
    //     ]);

    //     $items = json_decode($request->items, true);

    //     if (!$items || count($items) === 0) {
    //         return back()->withErrors(['items' => 'At least one item is required.']);
    //     }

    //     $transaction = Transaction::create([
    //         'shopkeeper_id' => Auth::id(),
    //         'customer_id' => $request->customer_id,
    //         'total' => $request->total_amount,
    //         'paid' => $request->paid_amount ??0.00,
    //         'remaining' => $request->remaining_amount,
    //     ]);
    //     //    dd($transaction);
    //     foreach ($items as $item) {
    //         TransactionItem::create([
    //             'transaction_id' => $transaction->id,
    //             'item_name' => $item['item_name'],
    //             'quantity' => $item['qty'],
    //             'price' => $item['price'],
    //             'total' => $item['total'],
    //         ]);
    //     }

    //     return redirect()->route('transactions.create')->with('success', 'Transaction saved successfully.');
    // }

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

        // Create transaction
        $transaction = Transaction::create([
            'shopkeeper_id' => Auth::id(),
            'customer_id' => $request->customer_id,
            'total' => $request->total_amount,
            'paid' => $request->paid_amount ?? 0.00,
            'remaining' => $request->remaining_amount,
        ]);

        // Save transaction items
        foreach ($items as $item) {
            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'item_name' => $item['item_name'],
                'quantity' => $item['qty'],
                'price' => $item['price'],
                'total' => $item['total'],
            ]);
        }

        // --- Send SMS to Jazz number ---
        $customer = Customer::find($request->customer_id);

        if ($customer && $customer->phone) {
            $phone = preg_replace('/\D+/', '', $customer->phone); // keep digits only

            if (preg_match('/^0\d{10}$/', $phone)) {
                $message = "Hello {$customer->name}, your transaction of amount {$transaction->total} has been recorded. Paid: {$transaction->paid}, Remaining: {$transaction->remaining}";
                $gatewayEmail = $phone . '@sms.jazz.com.pk'; // Jazz Email-to-SMS

                \Log::info('Attempting SMS send', ['phone' => $phone, 'gateway' => $gatewayEmail, 'message' => $message]);

                try {
                    \Illuminate\Support\Facades\Mail::raw($message, function ($mail) use ($gatewayEmail) {
                        $mail->to($gatewayEmail)
                            ->subject(''); // SMS does not need subject
                    });

                    if (count(\Illuminate\Support\Facades\Mail::failures()) > 0) {
                        \Log::error('SMS send reported failures', ['gateway' => $gatewayEmail, 'failures' => \Illuminate\Support\Facades\Mail::failures()]);
                    }
                } catch (\Exception $e) {
                    \Log::error('SMS sending failed: ' . $e->getMessage(), ['phone' => $phone, 'gateway' => $gatewayEmail]);
                }
            } else {
                \Log::warning('Invalid customer phone format for SMS', ['phone' => $customer->phone, 'customer_id' => $customer->id]);
            }
        }

        return redirect()->route('transactions.create')->with('success', 'Transaction saved successfully.');
    }
    public function show($customer_id)
    {
        $user = Auth::id();

        $customer = Customer::where('id', $customer_id)
            ->where('shopkeeper_id', $user)
            ->firstOrFail();

        // BASE QUERY
        $baseQuery = Transaction::with('items')
            ->where('customer_id', $customer_id);

        // DATE FILTERS
        $fromDate = request('from_date');
        $toDate = request('to_date');

        if ($fromDate) {
            $baseQuery->whereDate('created_at', '>=', $fromDate);
        }

        if ($toDate) {
            $baseQuery->whereDate('created_at', '<=', $toDate);
        }

        // PAGINATION (ONLY LIST)
        $transactions = (clone $baseQuery)
            ->latest()
            ->paginate(9);

        // FULL DATA (SUMMARY)
        $summaryTransactions = (clone $baseQuery)
            ->get();

        // SUMMARY CALCULATION
        $totalAmount = 0;
        $totalPaid = 0;

        foreach ($summaryTransactions as $t) {

            $transactionTotal = $t->total;

            if ($transactionTotal === null) {
                $transactionTotal = $t->items->sum(function ($i) {
                    return ($i->price ?? 0) * ($i->quantity ?? 0);
                });
            }

            $totalAmount += $transactionTotal;
            $totalPaid += $t->paid ?? 0;
        }

        $totalRemaining = $totalAmount - $totalPaid;

        return view('admin.clients.transections.transection', compact(
            'customer',
            'transactions',
            'totalAmount',
            'totalPaid',
            'totalRemaining',
            'fromDate',
            'toDate'
        ));
    }

    public function exportPdf($customer_id)
    {
        $user = Auth::id();
        $customer = Customer::where('id', $customer_id)->where('shopkeeper_id', $user)->firstOrFail();

        $baseQuery = Transaction::with('items')->where('customer_id', $customer_id);

        // DATE FILTERS
        $fromDate = request('from_date');
        $toDate = request('to_date');

        if ($fromDate) {
            $baseQuery->whereDate('created_at', '>=', $fromDate);
        }

        if ($toDate) {
            $baseQuery->whereDate('created_at', '<=', $toDate);
        }

        $transactions = $baseQuery->get();

        // SUMMARY CALCULATION
        $totalAmount = 0;
        $totalPaid = 0;

        foreach ($transactions as $t) {
            $transactionTotal = $t->total;

            if ($transactionTotal === null) {
                $transactionTotal = $t->items->sum(function ($i) {
                    return ($i->price ?? 0) * ($i->quantity ?? 0);
                });
            }

            $totalAmount += $transactionTotal;
            $totalPaid += $t->paid ?? 0;
        }

        $totalRemaining = $totalAmount - $totalPaid;

        $pdf = Pdf::loadView('admin.clients.transections.pdf', compact('customer', 'transactions', 'totalAmount', 'totalPaid', 'totalRemaining', 'fromDate', 'toDate'));

        return $pdf->download('customer_transactions_' . $customer->name . '.pdf');
    }

    public function sendWhatsAppPdf($customer_id)
    {
        $user = Auth::id();
        $customer = Customer::where('id', $customer_id)->where('shopkeeper_id', $user)->firstOrFail();

        $baseQuery = Transaction::with('items')->where('customer_id', $customer_id);

        // DATE FILTERS
        $fromDate = request('from_date');
        $toDate = request('to_date');

        if ($fromDate) {
            $baseQuery->whereDate('created_at', '>=', $fromDate);
        }

        if ($toDate) {
            $baseQuery->whereDate('created_at', '<=', $toDate);
        }

        $transactions = $baseQuery->get();

        // SUMMARY CALCULATION
        $totalAmount = 0;
        $totalPaid = 0;
        $transactionCount = $transactions->count();

        foreach ($transactions as $t) {
            $transactionTotal = $t->total;

            if ($transactionTotal === null) {
                $transactionTotal = $t->items->sum(function ($i) {
                    return ($i->price ?? 0) * ($i->quantity ?? 0);
                });
            }

            $totalAmount += $transactionTotal;
            $totalPaid += $t->paid ?? 0;
        }

        $totalRemaining = $totalAmount - $totalPaid;

        try {
            // Validate credentials
            $accountSid = config('services.twilio.account_sid');
            $authToken = config('services.twilio.auth_token');
            $twilioWhatsappNumber = config('services.twilio.whatsapp_number');
            
            if (!$accountSid || !$authToken || !$twilioWhatsappNumber) {
                return back()->with('error', 'Twilio credentials not configured. Please add TWILIO_ACCOUNT_SID, TWILIO_AUTH_TOKEN, and TWILIO_WHATSAPP_NUMBER to .env');
            }

            // Send via Twilio WhatsApp
            $phoneNumber = preg_replace('/\D+/', '', $customer->phone);
            
            // Format phone number to international format (assuming Pakistan +92)
            if (substr($phoneNumber, 0, 1) === '0') {
                $phoneNumber = '92' . substr($phoneNumber, 1);
            }
            
            $whatsappNumber = 'whatsapp:+' . $phoneNumber;
            
            // Clean Twilio WhatsApp number (remove any + or whatsapp: prefix)
            $cleanTwilioNumber = preg_replace('/[^\d]/', '', $twilioWhatsappNumber);
            $twilioNumber = 'whatsapp:+' . $cleanTwilioNumber;

            $client = new Client($accountSid, $authToken);

            // Format message with transaction details
            $messageText = "📋 *EasyKhata Transaction Report*\n\n";
            $messageText .= "👤 *Customer:* {$customer->name}\n";
            $messageText .= "🆔 *ID:* {$customer->id}\n";
            $messageText .= "📱 *Phone:* {$customer->phone}\n\n";
            
            $messageText .= "💰 *Summary*\n";
            $messageText .= "━━━━━━━━━━━━━━━\n";
            $messageText .= "*Total Amount:* Rs. " . number_format($totalAmount, 2) . "\n";
            $messageText .= "*Paid:* Rs. " . number_format($totalPaid, 2) . "\n";
            $messageText .= "*Remaining:* Rs. " . number_format($totalRemaining, 2) . "\n";
            $messageText .= "*Transactions:* " . $transactionCount . "\n\n";
            
            // Add recent transactions
            if ($transactionCount > 0) {
                $messageText .= "📊 *Recent Transactions*\n";
                $messageText .= "━━━━━━━━━━━━━━━\n";
                
                foreach ($transactions->take(5) as $t) {
                    $trxAmount = $t->total ?? $t->items->sum(fn($i) => $i->price * $i->quantity);
                    $trxDate = $t->created_at->format('d M Y');
                    $remaining = $trxAmount - ($t->paid ?? 0);
                    $status = $remaining > 0 ? '⏳ Pending' : '✅ Settled';
                    $messageText .= "\n#{$t->id} | Rs. " . number_format($trxAmount, 2) . " | {$trxDate}\n";
                    $messageText .= "   {$status}\n";
                }
                
                if ($transactionCount > 5) {
                    $messageText .= "\n... and " . ($transactionCount - 5) . " more transactions\n";
                }
            }
            
            $messageText .= "\n━━━━━━━━━━━━━━━\n";
            $messageText .= "📅 Generated: " . now()->format('d M Y, H:i') . "\n";
            $messageText .= "🔗 For full details, visit the app\n\n";
            $messageText .= "_This is an automated message from EasyKhata_";

            // Send message
            $message = $client->messages->create(
                $whatsappNumber,
                [
                    'from' => $twilioNumber,
                    'body' => $messageText
                ]
            );

            return back()->with('success', 'Transaction report sent via WhatsApp successfully!');
        } catch (\Exception $e) {
            \Log::error('WhatsApp sending failed: ' . $e->getMessage(), ['file' => $e->getFile(), 'line' => $e->getLine()]);
            
            $errorMsg = $e->getMessage();
            if (strpos($errorMsg, 'Invalid media URL') !== false) {
                $errorMsg = 'Invalid media URL - For local testing, use ngrok to expose your localhost to the internet.';
            }
            
            return back()->with('error', 'Failed to send via WhatsApp: ' . $errorMsg);
        }
    }

}
