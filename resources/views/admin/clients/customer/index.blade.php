<x-app-layout>
    <x-slot name="header">
        <h2 class="h4">💳 Add Transaction</h2>
    </x-slot>

    <style>
        .card-modern {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            border: none;
        }

        .card-modern .card-header {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: #fff;
            padding: 20px;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
            border: 1px solid #ddd;
            transition: 0.3s ease;
        }

        .form-control:focus {
            border-color: #2575fc;
            box-shadow: 0 0 6px rgba(37,117,252,0.4);
        }

        table {
            border-radius: 12px;
            overflow: hidden;
        }

        #itemsTable th {
            background: #f1f3f5;
        }

        #itemsTable tbody tr:hover {
            background: #f8f9fa;
        }

        .btn-modern {
            border-radius: 10px;
            padding: 10px 22px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
        }

        .btn-success:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #6c757d;
            border: none;
        }

        .btn-secondary:hover {
            opacity: 0.85;
            transform: translateY(-2px);
        }

        .btn-danger {
            border-radius: 6px;
        }

        h5.section-title {
            font-weight: 600;
            color: #333;
            margin-top: 20px;
            margin-bottom: 15px;
        }
    </style>

    <div class="container py-5">
        <div class="card card-modern">
            <div class="card-header">
                <h4 class="mb-0">➕ Add Transaction</h4>
            </div>
            <div class="card-body p-4">

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('transactions.store') }}" method="POST" onsubmit="prepareData()">
                    @csrf
                    <input type="hidden" name="items" id="itemsInput">
                    <input type="hidden" name="total_amount" id="totalAmountInput">
                    <input type="hidden" name="paid_amount" id="paidAmountInput">
                    <input type="hidden" name="remaining_amount" id="remainingAmountInput">

                    <!-- Customer -->
                    <div class="mb-3">
                        <label class="form-label">Select Customer <span class="text-danger">*</span></label>
                        <select name="customer_id" class="form-control" required>
                            <option value="">-- Choose Customer --</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                        @error('customer_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Item Entry -->
                    <h5 class="section-title">🛒 Item Entry</h5>
                    <div class="row g-2 mb-3">
                        <div class="col-md-4">
                            <input type="text" id="itemName" class="form-control" placeholder="Item name">
                        </div>
                        <div class="col-md-3">
                            <input type="number" id="itemQty" class="form-control" placeholder="Qty">
                        </div>
                        <div class="col-md-3">
                            <input type="number" id="itemPrice" class="form-control" placeholder="Price">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-success w-100 btn-modern" onclick="addItem()">Add</button>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <table class="table table-bordered text-center align-middle" id="itemsTable">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                    <!-- Totals -->
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Total Amount</label>
                            <input type="text" id="totalAmount" class="form-control" value="0" readonly>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Paid Amount</label>
                            <input type="number" id="paidAmount" class="form-control" placeholder="Enter paid amount" oninput="calculateBalance()">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Remaining Balance</label>
                            <input type="text" id="remainingBalance" class="form-control" value="0" readonly>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <button type="submit" class="btn btn-success btn-modern">💾 Save Transaction</button>
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-modern">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let items = [];

        function addItem() {
            let name = document.getElementById("itemName").value;
            let qty = parseInt(document.getElementById("itemQty").value);
            let price = parseFloat(document.getElementById("itemPrice").value);

            if (!name || !qty || !price) {
                alert("Please fill all item fields!");
                return;
            }

            let total = qty * price;
            items.push({ item_name: name, qty, price, total });

            renderTable();
            updateTotal();

            document.getElementById("itemName").value = "";
            document.getElementById("itemQty").value = "";
            document.getElementById("itemPrice").value = "";
        }

        function renderTable() {
            let tbody = document.querySelector("#itemsTable tbody");
            tbody.innerHTML = "";

            items.forEach((item, index) => {
                tbody.innerHTML += `
                    <tr>
                        <td>${item.item_name}</td>
                        <td>${item.qty}</td>
                        <td>${item.price}</td>
                        <td>${item.total}</td>
                        <td><button class="btn btn-danger btn-sm" type="button" onclick="removeItem(${index})">Delete</button></td>
                    </tr>
                `;
            });
        }

        function removeItem(index) {
            items.splice(index, 1);
            renderTable();
            updateTotal();
        }

        function updateTotal() {
            let total = items.reduce((sum, item) => sum + item.total, 0);
            document.getElementById("totalAmount").value = total;
            calculateBalance();
        }

        function calculateBalance() {
            let total = parseFloat(document.getElementById("totalAmount").value) || 0;
            let paid = parseFloat(document.getElementById("paidAmount").value) || 0;
            let remaining = total - paid;
            document.getElementById("remainingBalance").value = remaining;
        }

        function prepareData() {
            document.getElementById("itemsInput").value = JSON.stringify(items);
            document.getElementById("totalAmountInput").value = document.getElementById("totalAmount").value;
            document.getElementById("paidAmountInput").value = document.getElementById("paidAmount").value;
            document.getElementById("remainingAmountInput").value = document.getElementById("remainingBalance").value;
        }
    </script>
</x-app-layout>
