<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laundry Altek')</title>
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8FAFC;
        }
        .sidebar {
            background-color: #FFFFFF;
            border-right: 1px solid #E2E8F0;
        }
        .nav-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            margin-bottom: 0.25rem;
            border-radius: 0.5rem;
            color: #64748B;
            font-weight: 500;
            transition: all 0.2s;
        }
        .nav-item:hover {
            background-color: #F1F5F9;
            color: #0D9488;
        }
        .nav-item.active {
            background-color: #99F6E4;
            color: #0F172A;
        }
        .card-premium {
            background: white;
            border: 1px solid #E2E8F0;
            border-radius: 0.75rem;
            padding: 1.25rem;
        }
        .btn-tab {
            padding: 0.5rem 1rem;
            border: 1px solid #E2E8F0;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #1E293B;
            background: white;
        }
        .btn-tab.active {
            background-color: #1E293B;
            color: white;
            border-color: #1E293B;
        }
        .btn-login {
            background-color: #99F6E4;
            color: #0F172A;
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.875rem;
        }
        @keyframes logoFade {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .logo-animation {
            animation: logoFade 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen flex">
    <!-- Sidebar -->
    <aside class="sidebar w-64 flex-shrink-0 hidden md:flex flex-col sticky top-0 h-screen">
        <a href="{{ route('dashboard') }}" class="px-6 py-10 flex flex-col items-center justify-center border-b border-gray-50 mb-4 hover:bg-gray-50/50 transition-colors logo-animation">
            <div class="relative group">
                <div class="absolute -inset-4 bg-teal-50 rounded-full blur-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                <img src="{{ asset('photo/logo.png') }}" alt="Logo" class="relative w-44 h-auto object-contain transition-all duration-500 group-hover:scale-105 filter brightness-110 drop-shadow-md hover:drop-shadow-lg">
            </div>
        </a>
        
        <nav class="flex-1 px-4 overflow-y-auto">
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('pos') }}" class="nav-item {{ request()->routeIs('pos') ? 'active' : '' }}">
                <i data-lucide="shopping-cart" class="w-5 h-5 mr-3"></i>
                <span>POS(kasir)</span>
            </a>
            <a href="{{ route('transaksi.index') }}" class="nav-item {{ request()->routeIs('transaksi.*') ? 'active' : '' }}">
                <i data-lucide="history" class="w-5 h-5 mr-3"></i>
                <span>History Transaksi</span>
            </a>
            <a href="{{ route('pelanggan.index') }}" class="nav-item {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}">
                <i data-lucide="users" class="w-5 h-5 mr-3"></i>
                <span>Pelanggan</span>
            </a>
            <a href="{{ route('layanan.index') }}" class="nav-item {{ request()->routeIs('layanan.*') ? 'active' : '' }}">
                <i data-lucide="washing-machine" class="w-5 h-5 mr-3"></i>
                <span>Layanan</span>
            </a>
            <a href="{{ route('pengeluaran.index') }}" class="nav-item {{ request()->routeIs('pengeluaran.*') ? 'active' : '' }}">
                <i data-lucide="wallet" class="w-5 h-5 mr-3"></i>
                <span>Pengeluaran</span>
            </a>
            <a href="{{ route('laporan.index') }}" class="nav-item {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                <i data-lucide="file-text" class="w-5 h-5 mr-3"></i>
                <span>Laporan</span>
            </a>
        </nav>

        <div class="p-4 border-t border-gray-100">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center text-red-500 hover:bg-red-50 px-4 py-2 rounded-lg transition">
                    <i data-lucide="log-out" class="w-5 h-5 mr-3"></i>
                    <span class="font-medium text-sm">Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col min-w-0">
        <!-- Header -->
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 md:px-8">
            <div class="flex items-center">
                <!-- Mobile Logo & Title -->
                <div class="flex items-center md:hidden mr-4">
                    <img src="{{ asset('photo/logo.png') }}" alt="Logo" class="h-8 w-auto mr-2">
                </div>
                <h2 class="text-lg font-semibold text-gray-800">@yield('page_title', 'Dashboard')</h2>
            </div>
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2 text-sm font-medium text-gray-600">
                    <span>{{ Auth::user()->name ?? 'Admin' }}</span>
                    <div class="w-8 h-8 bg-teal-100 rounded-full flex items-center justify-center text-teal-700 font-bold">
                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-8">
            @yield('content')
        </div>
    </main>

    <script>
        lucide.createIcons();
    </script>
    @stack('scripts')
</body>
</html>
