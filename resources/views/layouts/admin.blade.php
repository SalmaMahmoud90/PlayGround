<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - PlayGround</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        .sidebar {
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            width: 288px;
        }

        .sidebar-link {
            color: #94a3b8;
            transition: all 0.3s ease;
            border-radius: 12px;
            margin: 2px 0;
        }

        .sidebar-link:hover {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white !important;
            transform: translateX(8px);
            box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.3);
        }

        .sidebar-link.active {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white !important;
            box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.3);
        }

        .sidebar-link i {
            width: 20px;
            text-align: center;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.04);
        }

        .stat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.08), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #10b981, #059669);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.4);
        }

        .badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-confirmed {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-completed {
            background: #dbeafe;
            color: #1e40af;
        }

        .table-row {
            transition: all 0.2s ease;
        }

        .table-row:hover {
            background: #f8fafc;
        }

        .action-card {
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .action-card:hover {
            border-color: #10b981;
            transform: translateX(6px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #10b981;
            border-radius: 10px;
        }
    </style>
    
</head>

<body class="bg-gray-50">
    <div class="min-h-screen flex">
        <aside class="sidebar w-72 min-h-screen fixed top-0 left-0 overflow-y-auto shadow-2xl z-50 flex flex-col">
            <div class="p-6 border-b border-gray-700/50 sticky top-0 bg-gray-900 z-10">
                <div class="flex items-center gap-3">
                    <div
                        class="w-11 h-11 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/30">
                        <span class="text-xl">⚽</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-extrabold text-white tracking-tight">PlayGround</h1>
                        <p class="text-[10px] text-gray-400 uppercase tracking-widest">Admin Panel</p>
                    </div>
                </div>
            </div>

            <nav class="p-4 flex-1 overflow-y-auto">
                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-3 px-3">Main Menu</p>
                <ul class="space-y-0.5">
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="sidebar-link flex items-center p-3 {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-gray-300 hover:text-white' }}">
                            <i class="fas fa-chart-pie mr-3 text-sm"></i>
                            <span class="text-sm font-medium">Dashboard</span>
                        </a>
                    </li>
                    <!-- <li>
                        <a href="{{ route('admin.cities.index') }}"
                            class="sidebar-link flex items-center p-3 {{ request()->routeIs('admin.cities.*') || request()->routeIs('admin.zones.*') ? 'active' : 'text-gray-300 hover:text-white' }}">
                            <i class="fas fa-city mr-3 text-sm"></i>
                            <span class="text-sm font-medium">Cities & Zones</span>
                        </a>
                    </li> -->
                    <li>
                        <a href="#" class="sidebar-link flex items-center p-3 text-gray-300 hover:text-white">
                            <i class="fas fa-city mr-3 text-sm"></i>
                            <span class="text-sm font-medium">Cities & Zones</span>
                            <i class="fas fa-chevron-down ml-auto text-xs"></i>
                        </a>
                        <ul class="pl-8 space-y-0.5 mt-1">
                            <li>
                                <a href="{{ route('admin.cities.index') }}"
                                    class="sidebar-link flex items-center p-2.5 text-gray-400 hover:text-white text-sm">
                                    <i class="fas fa-circle text-[6px] mr-2"></i>
                                    Cities
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.zones.index') }}"
                                    class="sidebar-link flex items-center p-2.5 text-gray-400 hover:text-white text-sm">
                                    <i class="fas fa-circle text-[6px] mr-2"></i>
                                    Zones
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('admin.owners.index') }}"
                            class="sidebar-link flex items-center p-3 {{ request()->routeIs('admin.owners.*') ? 'active' : 'text-gray-300 hover:text-white' }}">
                            <i class="fas fa-user-tie mr-3 text-sm"></i>
                            <span class="text-sm font-medium">Owners</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.playgrounds.index') }}"
                            class="sidebar-link flex items-center p-3 {{ request()->routeIs('admin.playgrounds.*') ? 'active' : 'text-gray-300 hover:text-white' }}">
                            <i class="fas fa-football mr-3 text-sm"></i>
                            <span class="text-sm font-medium">Playgrounds</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.bookings.index') }}"
                            class="sidebar-link flex items-center p-3 {{ request()->routeIs('admin.bookings.*') ? 'active' : 'text-gray-300 hover:text-white' }}">
                            <i class="fas fa-calendar-check mr-3 text-sm"></i>
                            <span class="text-sm font-medium">Bookings</span>
                            <span
                                class="ml-auto bg-yellow-500/20 text-yellow-400 text-[10px] px-2 py-0.5 rounded-full font-bold">12</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.coupons.index') }}"
                            class="sidebar-link flex items-center p-3 {{ request()->routeIs('admin.coupons.*') ? 'active' : 'text-gray-300 hover:text-white' }}">
                            <i class="fas fa-ticket-alt mr-3 text-sm"></i>
                            <span class="text-sm font-medium">Coupons</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.payments.index') }}"
                            class="sidebar-link flex items-center p-3 {{ request()->routeIs('admin.payments.*') ? 'active' : 'text-gray-300 hover:text-white' }}">
                            <i class="fas fa-credit-card mr-3 text-sm"></i>
                            <span class="text-sm font-medium">Payments</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="p-4 border-t border-gray-700/50 bg-gray-800/30">
                <div class="flex items-center gap-3 mb-3 p-3 bg-white/5 rounded-xl">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-full flex items-center justify-center shadow-lg shadow-emerald-500/20">
                        <span
                            class="text-white font-bold text-sm">{{ substr(auth()->user()->name ?? 'A', 0, 1) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <p class="text-[10px] text-gray-400 truncate">{{ auth()->user()->email ?? 'admin@playground.com'
                            }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center w-full p-2.5 rounded-xl bg-red-500/10 text-red-400 hover:bg-red-500/20 transition-all text-sm font-medium">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>
        <main class="flex-1 p-8" style="margin-left: 288px; min-height: 100vh;">
            <div class="flex flex-wrap justify-between items-center gap-4 mb-8">
                <div>
                    <h2 class="text-2xl font-extrabold text-gray-800">@yield('page-title', 'Dashboard')</h2>
                    <p class="text-sm text-gray-500 mt-0.5">
                        @yield('page-subtitle', 'Welcome back, ' . auth()->user()->name . '!')</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <button
                            class="w-10 h-10 bg-white rounded-xl shadow-sm hover:shadow-md transition flex items-center justify-center text-gray-500">
                            <i class="fas fa-bell"></i>
                            <span
                                class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-red-500 text-white text-[9px] rounded-full flex items-center justify-center font-bold">3</span>
                        </button>
                    </div>
                    <div class="w-px h-8 bg-gray-200"></div>
                    <div class="flex items-center gap-2 text-sm text-gray-500 bg-white px-4 py-2 rounded-xl shadow-sm">
                        <i class="far fa-calendar-alt text-emerald-500"></i>
                        <span>{{ now()->format('d M Y, h:i A') }}</span>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div
                    class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded-xl flex items-center shadow-sm">
                    <i class="fas fa-check-circle text-emerald-500 mr-3 text-lg"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div
                    class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-xl flex items-center shadow-sm">
                    <i class="fas fa-exclamation-circle text-red-500 mr-3 text-lg"></i>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>

</html>