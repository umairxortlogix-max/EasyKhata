<x-app-layout>
    <x-slot name="header">
        <h2 class="h4">Add Customer</h2>
    </x-slot>

    <style>
        /* === GENERAL PAGE LAYOUT === */
        body {
            margin: 0;
            padding: 0;
            font-family: "Inter", sans-serif;
            background-color: #f4f6f9;
        }

        .layout-wrapper {
            display: flex;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* === SIDEBAR === */
        .sidebar {
            width: 250px;
            background: #ffffff;
            border-right: 1px solid #e5e5e5;
            padding: 20px 0;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            overflow-y: auto;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .sidebar .logo {
            font-size: 1.4rem;
            font-weight: 700;
            color: #007bff;
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            padding: 12px 20px;
            color: #555;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
        }

        .sidebar ul li:hover,
        .sidebar ul li.active {
            background: #e9ecef;
            color: #007bff;
        }

        .sidebar ul li i {
            margin-right: 10px;
            font-size: 1.1rem;
        }

        /* === MAIN CONTENT === */
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 30px;
            transition: all 0.3s ease;
        }

        /* === TOGGLE BUTTON === */
        .toggle-btn {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 10px 12px;
            font-size: 20px;
            cursor: pointer;
            z-index: 1100;
        }

        /* === FORM DESIGN === */
        .card-modern {
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            border: none;
            background: #fff;
        }

        .card-modern .card-header {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: #fff;
            font-weight: 600;
            padding: 18px 20px;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
            border: 1px solid #ddd;
            transition: 0.3s ease;
            width: 100%;
        }

        .form-control:focus {
            border-color: #6a11cb;
            box-shadow: 0 0 6px rgba(106,17,203,0.3);
        }

        .btn-modern {
            border-radius: 10px;
            padding: 10px 24px;
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

        /* === RESPONSIVE DESIGN === */
        @media (max-width: 1200px) {
            .main-content {
                padding: 20px;
            }
        }

        @media (max-width: 992px) {
            .sidebar {
                width: 220px;
            }

            .main-content {
                margin-left: 220px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                left: -250px;
            }

            .sidebar.active {
                left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .toggle-btn {
                display: block;
            }
        }

        @media (max-width: 576px) {
            .card-modern {
                box-shadow: none;
                border-radius: 8px;
            }

            .btn-modern {
                width: 100%;
                margin-bottom: 10px;
            }

            .d-flex {
                flex-direction: column;
            }
        }
    </style>

    <button class="toggle-btn" onclick="toggleSidebar()">☰</button>

    <div class="layout-wrapper">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="logo">🧭 Admin Panel</div>
            <ul>
                <li class="active"><i class="bi bi-house"></i> Dashboard</li>
                <li><i class="bi bi-person"></i> Customers</li>
                <li><i class="bi bi-cart"></i> Orders</li>
                <li><i class="bi bi-box-seam"></i> Products</li>
                <li><i class="bi bi-gear"></i> Settings</li>
                <li><i class="bi bi-door-open"></i> Logout</li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="container mt-4">
                <div class="card card-modern">
                    <div class="card-header">
                        <h5 class="mb-0">➕ New Customer</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('customers.store') }}" method="POST">
                            @csrf

                            <!-- Name -->
                            <div class="mb-3">
                                <label class="form-label">Customer Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <!-- Phone -->
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                                @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <!-- Address -->
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control" rows="3">{{ old('address') }}</textarea>
                                @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-success btn-modern">💾 Save</button>
                                <a href="{{ route('customers.index') }}" class="btn btn-secondary btn-modern">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("active");
        }
    </script>
</x-app-layout>
