<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Transaction Wizard - Easy Khata</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .step { display: none; }
    .step.active { display: block; }
  </style>
</head>
<body class="bg-light">

<div class="container py-5">
  <div class="card shadow-lg">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0">🧾 Add Transaction (Wizard)</h4>
    </div>
    <div class="card-body">

      <!-- Step 1: Customer -->
      <div class="step active" id="step1">
        <h5>Step 1: Customer Information</h5>
        <div class="mb-3">
          <label class="form-label">Customer Name</label>
          <input type="text" id="customerName" class="form-control" placeholder="Enter customer name">
        </div>
        <div class="d-flex justify-content-end">
          <button class="btn btn-primary" onclick="nextStep(2)">Next ➡</button>
        </div>
      </div>

      <!-- Step 2: Items -->
      <div class="step" id="step2">
        <h5>Step 2: Add Items</h5>
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
            <button type="button" class="btn btn-success w-100" onclick="addItem()">Add</button>
          </div>
        </div>

        <table class="table table-bordered" id="itemsTable">
          <thead class="table-light">
            <tr>
              <th>Item</th><th>Qty</th><th>Price</th><th>Total</th><th>Action</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>

        <div class="d-flex justify-content-between">
          <button class="btn btn-secondary" onclick="prevStep(1)">⬅ Back</button>
          <button class="btn btn-primary" onclick="nextStep(3)">Next ➡</button>
        </div>
      </div>

      <!-- Step 3: Payment -->
      <div class="step" id="step3">
        <h5>Step 3: Payment Details</h5>
        <div class="mb-3">
          <label>Total Amount</label>
          <input type="text" id="totalAmount" class="form-control" value="0" readonly>
        </div>
        <div class="mb-3">
          <label>Paid Amount</label>
          <input type="number" id="paidAmount" class="form-control" oninput="calculateBalance()">
        </div>
        <div class="mb-3">
          <label>Remaining Balance</label>
          <input type="text" id="remainingBalance" class="form-control" value="0" readonly>
        </div>

        <div class="d-flex justify-content-between">
          <button class="btn btn-secondary" onclick="prevStep(2)">⬅ Back</button>
          <button class="btn btn-primary" onclick="nextStep(4)">Next ➡</button>
        </div>
      </div>

      <!-- Step 4: Confirm -->
      <div class="step" id="step4">
        <h5>Step 4: Review & Confirm</h5>
        <div id="reviewSection" class="mb-3"></div>

        <div class="d-flex justify-content-between">
          <button class="btn btn-secondary" onclick="prevStep(3)">⬅ Back</button>
          <button class="btn btn-success" onclick="saveTransaction()">✅ Confirm & Save</button>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
  let items = [];

  function nextStep(step) {
    if (step === 2 && !document.getElementById("customerName").value) {
      alert("⚠️ Please enter customer name first!");
      return;
    }
    if (step === 3 && items.length === 0) {
      alert("⚠️ Please add at least one item!");
      return;
    }
    if (step === 4) {
      generateReview();
    }
    document.querySelectorAll(".step").forEach(s => s.classList.remove("active"));
    document.getElementById("step" + step).classList.add("active");
  }

  function prevStep(step) {
    document.querySelectorAll(".step").forEach(s => s.classList.remove("active"));
    document.getElementById("step" + step).classList.add("active");
  }

  function addItem() {
    let name = document.getElementById("itemName").value;
    let qty = parseInt(document.getElementById("itemQty").value);
    let price = parseFloat(document.getElementById("itemPrice").value);

    if (!name || !qty || !price) {
      alert("⚠️ Fill item fields properly!");
      return;
    }

    let total = qty * price;
    items.push({ name, qty, price, total });
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
          <td>${item.name}</td>
          <td>${item.qty}</td>
          <td>${item.price}</td>
          <td>${item.total}</td>
          <td><button class="btn btn-danger btn-sm" onclick="removeItem(${index})">Delete</button></td>
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

  function generateReview() {
    let customer = document.getElementById("customerName").value;
    let total = document.getElementById("totalAmount").value;
    let paid = document.getElementById("paidAmount").value;
    let remaining = document.getElementById("remainingBalance").value;

    let reviewHtml = `
      <h6>Customer: ${customer}</h6>
      <ul>
        ${items.map(i => `<li>${i.name} (${i.qty} x ${i.price}) = ${i.total}</li>`).join("")}
      </ul>
      <p><strong>Total:</strong> ${total}</p>
      <p><strong>Paid:</strong> ${paid}</p>
      <p><strong>Remaining:</strong> ${remaining}</p>
    `;
    document.getElementById("reviewSection").innerHTML = reviewHtml;
  }

  function saveTransaction() {
    alert("✅ Transaction saved successfully!");
    window.location.reload();
  }
</script>

</body>
</html>
