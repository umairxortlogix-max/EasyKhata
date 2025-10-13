<!-- ===== Sidebar ===== -->
    <div class="sidebar" id="sidebar">
        <div class="brand">
            <i class="fa-solid fa-chart-line"></i> <span>{{ config('app.name', 'Laravel') }}</span>
        </div>

        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="fa-solid fa-gauge"></i> <span>Dashboard</span>
            </a>

            @role('super-admin')
            <a class="nav-link" href="{{ route('admin.clients.index') }}">
                <i class="fa-solid fa-users"></i> <span>Clients</span>
            </a>
            @endrole

            @role('Client')
            <a class="nav-link" href="{{ route('transactions.create') }}">
                <i class="fa-solid fa-exchange-alt"></i> <span>Transactions</span>
            </a>
            <a class="nav-link" href="{{ route('customers.index') }}">
                <i class="fa-solid fa-shop"></i> <span>Shop Customers</span>
            </a>
            @endrole

            <a class="nav-link" href="{{ route('profile.edit') }}">
                <i class="fa-solid fa-user"></i> <span>Profile</span>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link text-start border-0 bg-transparent">
                    <i class="fa-solid fa-right-from-bracket"></i> <span>Logout</span>
                </button>
            </form>
        </nav>
    </div>
