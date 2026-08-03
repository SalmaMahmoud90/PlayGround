@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Welcome back, ' . auth()->user()->name . '! Here\'s what\'s happening with your platform.')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="stat-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Bookings</p>
                <p class="text-3xl font-extrabold text-gray-800 mt-1">{{ $totalBookings ?? 0 }}</p>
                <p class="text-xs text-emerald-600 mt-2 flex items-center">
                    <i class="fas fa-arrow-up mr-1"></i> 12.5%
                </p>
            </div>
            <div class="stat-icon bg-blue-50 text-blue-600">
                <i class="fas fa-calendar-check"></i>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Pending Bookings</p>
                <p class="text-3xl font-extrabold text-gray-800 mt-1">{{ $pendingBookings ?? 0 }}</p>
                <p class="text-xs text-amber-600 mt-2 flex items-center">
                    <i class="fas fa-clock mr-1"></i> Awaiting confirmation
                </p>
            </div>
            <div class="stat-icon bg-amber-50 text-amber-600">
                <i class="fas fa-hourglass-half"></i>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Playgrounds</p>
                <p class="text-3xl font-extrabold text-gray-800 mt-1">{{ $totalPlaygrounds ?? 0 }}</p>
                <p class="text-xs text-emerald-600 mt-2 flex items-center">
                    <i class="fas fa-arrow-up mr-1"></i> 5 new this month
                </p>
            </div>
            <div class="stat-icon bg-emerald-50 text-emerald-600">
                <i class="fas fa-football"></i>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Users</p>
                <p class="text-3xl font-extrabold text-gray-800 mt-1">{{ $totalUsers ?? 0 }}</p>
                <p class="text-xs text-purple-600 mt-2 flex items-center">
                    <i class="fas fa-arrow-up mr-1"></i> 8 new this week
                </p>
            </div>
            <div class="stat-icon bg-purple-50 text-purple-600">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>
</div>


<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-50 p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Recent Bookings</h3>
            <a href="{{ route('admin.bookings.index') }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium flex items-center">
                View All <i class="fas fa-arrow-right ml-1.5 text-xs"></i>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left py-3 px-3 text-[11px] font-semibold text-gray-400 uppercase tracking-wider">User</th>
                        <th class="text-left py-3 px-3 text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Playground</th>
                        <th class="text-left py-3 px-3 text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Date</th>
                        <th class="text-left py-3 px-3 text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentBookings ?? [] as $booking)
                    <tr class="table-row border-b border-gray-50">
                        <td class="py-3 px-3">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-xs font-bold text-gray-600">
                                    {{ substr($booking->user->name ?? 'U', 0, 1) }}
                                </div>
                                <span class="text-sm font-medium text-gray-700">{{ $booking->user->name ?? 'Unknown' }}</span>
                            </div>
                        </td>
                        <td class="py-3 px-3 text-sm text-gray-600">{{ $booking->playground->name ?? 'N/A' }}</td>
                        <td class="py-3 px-3 text-sm text-gray-600">{{ \Carbon\Carbon::parse($booking->start_date_time)->format('d/m/Y') }}</td>
                        <td class="py-3 px-3">
                            <span class="badge 
                                @if($booking->status == 'pending') badge-pending
                                @elseif($booking->status == 'confirmed') badge-confirmed
                                @elseif($booking->status == 'cancelled') badge-cancelled
                                @else badge-completed @endif">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-12">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                    <i class="fas fa-inbox text-gray-300 text-2xl"></i>
                                </div>
                                <p class="text-gray-500 font-medium">No bookings found</p>
                                <p class="text-sm text-gray-400 mt-0.5">Bookings will appear here</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


    <div class="space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-50 p-6">
            <h3 class="text-sm font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-bolt text-emerald-500 mr-2 text-xs"></i>
                Quick Actions
            </h3>
            <div class="space-y-2.5">
                <a href="{{ route('admin.playgrounds.create') }}" class="action-card flex items-center p-3.5 bg-gray-50 rounded-xl">
                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-xl flex items-center justify-center mr-3 shadow-lg shadow-emerald-500/20">
                        <i class="fas fa-plus text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Add Playground</p>
                        <p class="text-xs text-gray-400">Create a new playground</p>
                    </div>
                    <i class="fas fa-chevron-right ml-auto text-gray-300 text-xs"></i>
                </a>
                <a href="{{ route('admin.coupons.create') }}" class="action-card flex items-center p-3.5 bg-gray-50 rounded-xl">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl flex items-center justify-center mr-3 shadow-lg shadow-purple-500/20">
                        <i class="fas fa-ticket-alt text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Create Coupon</p>
                        <p class="text-xs text-gray-400">Add discount coupons</p>
                    </div>
                    <i class="fas fa-chevron-right ml-auto text-gray-300 text-xs"></i>
                </a>
                <a href="{{ route('admin.cities.create') }}" class="action-card flex items-center p-3.5 bg-gray-50 rounded-xl">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center mr-3 shadow-lg shadow-blue-500/20">
                        <i class="fas fa-city text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Add City</p>
                        <p class="text-xs text-gray-400">Create a new city</p>
                    </div>
                    <i class="fas fa-chevron-right ml-auto text-gray-300 text-xs"></i>
                </a>
            </div>
        </div>

        <div class="bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-2xl shadow-lg shadow-emerald-500/20 p-6 text-white">
            <h3 class="text-sm font-bold mb-4 flex items-center">
                <i class="fas fa-calendar-day mr-2 text-emerald-200"></i>
                Today's Overview
            </h3>
            <div class="space-y-3.5">
                <div class="flex justify-between items-center border-b border-emerald-500/30 pb-3">
                    <span class="text-emerald-100 text-sm">Bookings</span>
                    <span class="text-2xl font-extrabold">{{ \App\Models\Booking::whereDate('created_at', today())->count() ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center border-b border-emerald-500/30 pb-3">
                    <span class="text-emerald-100 text-sm">Revenue</span>
                    <span class="text-2xl font-extrabold">${{ number_format(\App\Models\Booking::whereDate('created_at', today())->sum('total_price') ?? 0, 2) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-emerald-100 text-sm">New Users</span>
                    <span class="text-2xl font-extrabold">{{ \App\Models\User::whereDate('created_at', today())->count() ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
