@extends('layouts.admin')

@section('title', 'Bookings')
@section('page-title', 'Bookings Management')
@section('page-subtitle', 'Manage all bookings and their status')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm border border-gray-50 p-6">
        <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
            <div class="flex flex-wrap items-center gap-3">
                <div class="relative">
                    <input type="text" placeholder="Search bookings..."
                        class="pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm w-64">
                    <i class="fas fa-search absolute left-3.5 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                </div>
                <select
                    class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="cancelled">Cancelled</option>
                    <option value="completed">Completed</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 rounded-xl">
                        <th class="text-left py-3 px-4 text-[11px] font-semibold text-gray-400 uppercase tracking-wider">ID
                        </th>
                        <th class="text-left py-3 px-4 text-[11px] font-semibold text-gray-400 uppercase tracking-wider">
                            User</th>
                        <th class="text-left py-3 px-4 text-[11px] font-semibold text-gray-400 uppercase tracking-wider">
                            Playground</th>
                        <th class="text-left py-3 px-4 text-[11px] font-semibold text-gray-400 uppercase tracking-wider">
                            Date</th>
                        <th class="text-left py-3 px-4 text-[11px] font-semibold text-gray-400 uppercase tracking-wider">
                            Time</th>
                        <th class="text-left py-3 px-4 text-[11px] font-semibold text-gray-400 uppercase tracking-wider">
                            Amount</th>
                        <th class="text-center py-3 px-4 text-[11px] font-semibold text-gray-400 uppercase tracking-wider">
                            Status</th>
                        <th class="text-center py-3 px-4 text-[11px] font-semibold text-gray-400 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr class="table-row border-t border-gray-50">
                            <td class="py-3 px-4 text-sm text-gray-500">#{{ $booking->id }}</td>
                            <td class="py-3 px-4 font-semibold text-gray-800">{{ $booking->user->name ?? 'N/A' }}</td>
                            <td class="py-3 px-4 text-sm text-gray-600">{{ $booking->playground->name ?? 'N/A' }}</td>
                            <td class="py-3 px-4 text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($booking->start_date_time)->format('d/m/Y') }}</td>
                            <td class="py-3 px-4 text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($booking->start_date_time)->format('h:i A') }} -
                                {{ \Carbon\Carbon::parse($booking->end_date_time)->format('h:i A') }}
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-600">${{ number_format($booking->total_price, 2) }}</td>
                            <td class="text-center py-3 px-4">
                                <span class="badge

                                    @if($booking->status == 'pending') badge-pending
                                    @elseif($booking->status == 'confirmed') badge-confirmed
                                    @elseif($booking->status == 'cancelled') badge-cancelled
                                    @else badge-completed @endif">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td class="text-center py-3 px-4">
                                <div class="flex items-center justify-center gap-1.5">
                                    @if($booking->status == 'pending')
                                        <form action="{{ route('admin.bookings.approve', $booking) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="p-2 bg-emerald-50 text-emerald-600 rounded-lg hover:bg-emerald-100 transition text-sm">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.bookings.reject', $booking) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" onclick="return confirm('Reject this booking?')"
                                                class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition text-sm">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @elseif($booking->status == 'confirmed')
                                        <form action="{{ route('admin.bookings.complete', $booking) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition text-sm">
                                                <i class="fas fa-check-double"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-16">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-calendar-check text-gray-300 text-3xl"></i>
                                    </div>
                                    <h4 class="text-lg font-semibold text-gray-600">No bookings found</h4>
                                    <p class="text-sm text-gray-400 mt-0.5">Bookings will appear here</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $bookings->links() }}
        </div>
    </div>
@endsection
