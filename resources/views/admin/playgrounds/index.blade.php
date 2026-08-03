@extends('layouts.admin')

@section('title', 'Playgrounds')
@section('page-title', 'Playgrounds Management')
@section('page-subtitle', 'Manage all playgrounds and their details')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm border border-gray-50 p-6">
        <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
            <div class="flex flex-wrap items-center gap-3">
                <div class="relative">
                    <input type="text" placeholder="Search playgrounds..."
                        class="pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm w-64">
                    <i class="fas fa-search absolute left-3.5 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                </div>
                <select
                    class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                    <option value="">All Types</option>
                    <option value="football">Football</option>
                    <option value="basketball">Basketball</option>
                    <option value="tennis">Tennis</option>
                    <option value="volleyball">Volleyball</option>
                    <option value="multi">Multi</option>
                </select>
                <select
                    class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                    <option value="">All Status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <a href="{{ route('admin.playgrounds.create') }}"
                class="btn-primary text-white px-6 py-2.5 rounded-xl flex items-center gap-2 text-sm font-medium shadow-lg shadow-emerald-500/25">
                <i class="fas fa-plus text-xs"></i> Add Playground
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 rounded-xl">
                        <th class="text-left py-3 px-4 text-[11px] font-semibold text-gray-400 uppercase tracking-wider">ID
                        </th>
                        <th class="text-left py-3 px-4 text-[11px] font-semibold text-gray-400 uppercase tracking-wider">
                            Name</th>
                        <th class="text-left py-3 px-4 text-[11px] font-semibold text-gray-400 uppercase tracking-wider">
                            Owner</th>
                        <th class="text-left py-3 px-4 text-[11px] font-semibold text-gray-400 uppercase tracking-wider">
                            Type</th>
                        <th class="text-left py-3 px-4 text-[11px] font-semibold text-gray-400 uppercase tracking-wider">
                            Price/Hour</th>
                        <th class="text-center py-3 px-4 text-[11px] font-semibold text-gray-400 uppercase tracking-wider">
                            Status</th>
                        <th class="text-center py-3 px-4 text-[11px] font-semibold text-gray-400 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($playgrounds as $playground)
                        <tr class="table-row border-t border-gray-50">
                            <td class="py-3 px-4 text-sm text-gray-500">#{{ $playground->id }}</td>
                            <td class="py-3 px-4 font-semibold text-gray-800">{{ $playground->name }}</td>
                            <td class="py-3 px-4 text-sm text-gray-600">{{ $playground->owner->user->name ?? 'N/A' }}</td>
                            <td class="py-3 px-4 text-sm text-gray-500">
                                <span class="badge badge-confirmed">{{ ucfirst($playground->type) }}</span>
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-600">${{ number_format($playground->price_per_hour, 2) }}
                            </td>
                            <td class="text-center py-3 px-4">
                                <span class="badge {{ $playground->is_active ? 'badge-confirmed' : 'badge-cancelled' }}">
                                    {{ $playground->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-center py-3 px-4">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('admin.playgrounds.edit', $playground) }}"
                                        class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition text-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.playgrounds.destroy', $playground) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure?')"
                                            class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition text-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-16">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-football text-gray-300 text-3xl"></i>
                                    </div>
                                    <h4 class="text-lg font-semibold text-gray-600">No playgrounds found</h4>
                                    <p class="text-sm text-gray-400 mt-0.5">Get started by creating your first playground</p>
                                    <a href="{{ route('admin.playgrounds.create') }}"
                                        class="mt-4 btn-primary text-white px-6 py-2.5 rounded-xl flex items-center gap-2 text-sm font-medium shadow-lg shadow-emerald-500/25">
                                        <i class="fas fa-plus text-xs"></i> Add Playground
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $playgrounds->links() }}
        </div>
    </div>
@endsection