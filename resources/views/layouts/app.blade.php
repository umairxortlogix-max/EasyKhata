<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- ===== Inline CSS ===== -->
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background: #e0e5ec;
            margin: 0;
            overflow-x: hidden;
        }

        /* ===== Neumorphic Global Styles ===== */
        .neumorphic {
            background: #e0e5ec;
            border-radius: 16px;
            box-shadow: 5px 5px 15px #babecc,
                -5px -5px 15px #ffffff;
            transition: all 0.3s ease;
        }

        .neumorphic:hover {
            box-shadow: 3px 3px 8px #babecc,
                -3px -3px 8px #ffffff;
            transform: translateY(-2px);
        }

        .form-control.neumorphic {
            border-radius: 12px;
            background: #e0e5ec;
            box-shadow: inset 3px 3px 7px #babecc,
                inset -3px -3px 7px #ffffff;
            border: none;
            transition: all 0.3s ease;
            padding: 12px;
        }

        .form-control.neumorphic:focus {
            outline: none;
            box-shadow: inset 3px 3px 7px #babecc,
                inset -3px -3px 7px #ffffff;
        }

        .btn-neumorphic {
            border-radius: 12px;
            background: #e0e5ec;
            box-shadow: 5px 5px 15px #babecc,
                -5px -5px 15px #ffffff;
            transition: all 0.3s ease;
            border: none;
            font-weight: 600;
            color: #333;
        }

        .btn-neumorphic:hover {
            box-shadow: inset 3px 3px 7px #babecc,
                inset -3px -3px 7px #ffffff;
            transform: translateY(-2px);
        }

        table.neumorphic-table {
            background: #e0e5ec;
            border-radius: 16px;
            box-shadow: 5px 5px 15px #babecc,
                -5px -5px 15px #ffffff;
            overflow: hidden;
        }

        table.neumorphic-table th,
        table.neumorphic-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #d1d9e6;
        }

        table.neumorphic-table tr:hover {
            background: #d1d9e6;
            box-shadow: inset 3px 3px 7px #babecc,
                inset -3px -3px 7px #ffffff;
        }

        /* ===== Sidebar ===== */
        .sidebar {
            width: 250px;
            height: 100vh;
            background: #e0e5ec;
            position: fixed;
            left: 0;
            top: 0;
            border-radius: 0 20px 20px 0;
            box-shadow: 5px 5px 15px #babecc,
                -5px -5px 15px #ffffff;
            transition: all 0.3s ease;
            z-index: 1030;
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar .brand {
            font-weight: 600;
            font-size: 18px;
            text-align: center;
            padding: 15px;
            border-bottom: 1px solid #d1d9e6;
        }

        .sidebar .brand i {
            color: #2575fc;
            margin-right: 8px;
        }

        .sidebar .nav {
            padding-top: 15px;
        }

        .sidebar .nav-link {
            color: #333;
            display: flex;
            align-items: center;
            padding: 12px 20px;
            border-radius: 12px;
            margin: 8px 12px;
            font-weight: 500;
            transition: all 0.3s ease;
            background: #e0e5ec;
            box-shadow: inset 3px 3px 7px #babecc,
                inset -3px -3px 7px #ffffff;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #2575fc;
            box-shadow: 3px 3px 8px #babecc,
                -3px -3px 8px #ffffff;
            transform: translateY(-2px);
        }

        .sidebar .nav-link i {
            font-size: 18px;
            margin-right: 12px;
            width: 24px;
            text-align: center;
        }

        .sidebar.collapsed .nav-link span {
            display: none;
        }

        .sidebar.collapsed .nav-link i {
            margin: auto;
        }

        /* ===== Navbar ===== */
        .navbar-custom {
            background: #e0e5ec;
            border-radius: 16px;
            margin: 10px;
            box-shadow: 5px 5px 15px #babecc,
                -5px -5px 15px #ffffff;
            height: 60px;
            transition: all 0.3s ease;
            padding-left: 260px;
        }

        .sidebar.collapsed~.navbar-custom {
            padding-left: 80px;
        }

        .navbar-custom .btn {
            border-radius: 8px;
        }

        /* ===== Main Content ===== */
        .main-content {
            margin-left: 260px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed~.main-content {
            margin-left: 80px;
        }

        @media (max-width: 991px) {
            .sidebar {
                left: -250px;
            }

            .sidebar.active {
                left: 0;
            }

            .navbar-custom {
                padding-left: 20px;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    @include('layouts.sidebar')
    <!-- ===== Navbar ===== -->
    @include('layouts.navigation')
    <!-- ===== Main Content ===== -->
    <div class="main-content">
        @isset($header)
            <header class="neumorphic border rounded p-3 mb-4">
                <h4 class="m-0">{{ $header }}</h4>
            </header>
        @endisset

        {{ $slot }}
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Sidebar Toggle Script -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleSidebar');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });
    </script>
</body>

</html>