<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-semibold text-dark mb-0">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- ===== Custom CSS for Modern Cards ===== --}}
    <style>
        .dashboard-card {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
        .dashboard-card h5 { font-size: 1rem; margin-bottom: 0.5rem; }
        .dashboard-card h3, .dashboard-card h4 { font-size: 1.5rem; }
        .dashboard-chart-card { min-height: 250px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); }
        @media (max-width: 768px) { .dashboard-card, .dashboard-chart-card { min-height: auto; } }
    </style>

    <div class="container my-5">

        {{-- ===== Top Summary Cards ===== --}}
        <div class="row mb-4 text-center">
            @role('super-admin')
            <div class="col-md-4 mb-3">
                <div class="card dashboard-card border-0 text-primary">
                    <div class="card-body">
                        <h5 class="fw-bold">Total Users</h5>
                        <h3 class="fw-bold">{{ $totalUsers ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card dashboard-card border-0 text-success">
                    <div class="card-body">
                        <h5 class="fw-bold">Active Clients</h5>
                        <h3 class="fw-bold">{{ $clientCount ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card dashboard-card border-0 text-warning">
                    <div class="card-body">
                        <h5 class="fw-bold">Admins</h5>
                        <h3 class="fw-bold">{{ $adminCount ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            @endrole

            @role('Client')
            <div class="col-md-6 mb-3">
                <div class="card dashboard-card border-0 text-info">
                    <div class="card-body">
                        <h5 class="fw-bold">Customers</h5>
                        <h3 class="fw-bold">{{ $customersCount ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card dashboard-card border-0 text-danger">
                    <div class="card-body">
                        <h5 class="fw-bold">Transactions</h5>
                        <h3 class="fw-bold">{{ $transectionCount ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            @endrole
        </div>

        {{-- ===== Charts Section ===== --}}
        <div class="row text-center">
            @role('super-admin')
            <div class="col-md-4 mb-4">
                <div class="card dashboard-chart-card border-0">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3 text-primary">Users Overview</h5>
                        <canvas id="chart1" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card dashboard-chart-card border-0">
                    <div class="card-body" style="height: 320px;">
                        <h5 class="fw-bold mb-3 text-success">Roles Distribution</h5>
                        <canvas id="chart2"></canvas>
                    </div>
                </div>
            </div>
            @endrole
        </div>

        {{-- ===== Client Transaction Overview ===== --}}
        @role('Client')
        <div class="row justify-content-center mt-5">

            {{-- Transaction Overview --}}
            <div class="col-md-6 mb-4">
                <div class="card dashboard-chart-card border-0 text-center">
                    <div class="card-body">
                        <h4 class="mb-3 text-primary">Transaction Overview</h4>

                        {{-- Filter Buttons --}}
                        <div class="mb-3">
                            <button class="btn btn-sm btn-outline-primary" onclick="updateChart('day')">Day</button>
                            <button class="btn btn-sm btn-outline-primary" onclick="updateChart('week')">Week</button>
                            <button class="btn btn-sm btn-outline-primary" onclick="updateChart('month')">Month</button>
                            <button class="btn btn-sm btn-outline-primary" onclick="updateChart('year')">Year</button>
                        </div>

                        <canvas id="clientTransactionChart" height="200"></canvas>
                    </div>
                </div>
            </div>

            {{-- Business Trend --}}
            <div class="col-md-6 mb-4">
                <div class="card dashboard-chart-card border-0">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3 text-warning">Business Trend</h5>
                        <canvas id="chart3" height="250"></canvas>
                    </div>
                </div>
            </div>

        </div>
        @endrole

    </div>

    {{-- ===== Chart.js Scripts ===== --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@3"></script>

    <script>
        @role('super-admin')
        // Users Overview
        new Chart(document.getElementById('chart1'), {
            type: 'bar',
            data: {
                labels: ['Users', 'Clients', 'Admins'],
                datasets: [{ label: 'User Overview', data: [{{ $totalUsers ?? 0 }}, {{ $clientCount ?? 0 }}, {{ $adminCount ?? 0 }}], backgroundColor: ['#4e73df', '#1cc88a', '#f6c23e'], borderRadius: 8 }]
            },
            options: { responsive: true, plugins: { legend: { display: false } } }
        });

        // Roles Distribution
        new Chart(document.getElementById('chart2'), {
            type: 'doughnut',
            data: { labels: ['Clients', 'Admins'], datasets: [{ data: [{{ $clientCount ?? 0 }}, {{ $adminCount ?? 0 }}], backgroundColor: ['#1cc88a', '#f6c23e'] }] },
            options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
        });
        @endrole

        @role('Client')
        // Prepare client transaction data
        const transactions = @json($transactionStatsHistory ?? []);

        function getTransactionChartData() {
            return {
                datasets: [
                    { label: 'Paid', data: transactions.map(t => ({ x: t.date, y: t.paid })), borderColor: '#4bc0c0', backgroundColor: 'rgba(75, 192, 192, 0.3)', tension: 0.2, fill: true },
                    { label: 'Total', data: transactions.map(t => ({ x: t.date, y: t.total })), borderColor: '#36a2eb', backgroundColor: 'rgba(54, 162, 235, 0.3)', tension: 0.2, fill: true },
                    { label: 'Remaining', data: transactions.map(t => ({ x: t.date, y: t.remaining })), borderColor: '#ff6384', backgroundColor: 'rgba(255, 99, 132, 0.3)', tension: 0.2, fill: true }
                ]
            };
        }

        let selectedUnit = 'day';
        const ctx = document.getElementById('clientTransactionChart').getContext('2d');
        const clientTransactionChart = new Chart(ctx, {
            type: 'line',
            data: getTransactionChartData(),
            options: {
                responsive: true,
                plugins: { legend: { display: true } },
                scales: {
                    x: {
                        type: 'time',
                        time: { unit: selectedUnit, tooltipFormat: 'PP', displayFormats: { day: 'dd/MM', week: "dd/MM/yyyy", month: 'MMM yyyy', year: 'yyyy' } },
                        title: { display: true, text: 'Date' }
                    },
                    y: { beginAtZero: true, title: { display: true, text: 'Amount (PKR)' } }
                }
            }
        });

        function updateChart(unit) {
            selectedUnit = unit;
            clientTransactionChart.options.scales.x.time.unit = unit;
            clientTransactionChart.update();
        }

        // Business Trend chart
        const chart3 = new Chart(document.getElementById('chart3'), {
            type: 'line',
            data: {
                labels: transactions.map(t => t.date),
                datasets: [
                    { label: 'Customers', data: transactions.map(t => t.customers_count ?? 0), borderColor: '#f6c23e', backgroundColor: 'rgba(246, 194, 62, 0.3)', tension: 0.2, fill: true },
                    { label: 'Transactions', data: transactions.map(t => t.transactions_count ?? 0), borderColor: '#1cc88a', backgroundColor: 'rgba(28, 200, 138, 0.3)', tension: 0.2, fill: true }
                ]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: true } },
                scales: {
                    x: { type: 'time', time: { unit: 'day', tooltipFormat: 'PP' }, title: { display: true, text: 'Date' } },
                    y: { beginAtZero: true }
                }
            }
        });
        @endrole
    </script>
</x-app-layout>
