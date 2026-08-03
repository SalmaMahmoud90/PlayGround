@extends('layouts.admin')

@section('title', 'Add Playground')
@section('page-title', 'Add New Playground')
@section('page-subtitle', 'Create a new playground')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-50 p-8">
            <form action="{{ route('admin.playgrounds.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-2 gap-6">
                    <div class="mb-4">
                        <label for="owner_id" class="block text-sm font-semibold text-gray-700 mb-2">Owner</label>
                        <select name="owner_id" id="owner_id"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('owner_id') border-red-500 @enderror text-sm">
                            <option value="">Select Owner</option>
                            @foreach($owners as $owner)
                                <option value="{{ $owner->id }}" {{ old('owner_id') == $owner->id ? 'selected' : '' }}>
                                    {{ $owner->user->name }} ({{ $owner->company_name }})
                                </option>
                            @endforeach
                        </select>
                        @error('owner_id')
                            <p class="text-red-500 text-sm mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Playground Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            placeholder="Enter playground name..."
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('name') border-red-500 @enderror text-sm">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="mb-4">
                        <label for="city_id" class="block text-sm font-semibold text-gray-700 mb-2">City</label>
                        <select name="city_id" id="city_id"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('city_id') border-red-500 @enderror text-sm">
                            <option value="">Select City</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                    {{ $city->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('city_id')
                            <p class="text-red-500 text-sm mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="zone_id" class="block text-sm font-semibold text-gray-700 mb-2">Zone</label>
                        <select name="zone_id" id="zone_id"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('zone_id') border-red-500 @enderror text-sm">
                            <option value="">Select Zone</option>
                            @foreach($zones as $zone)
                                <option value="{{ $zone->id }}" {{ old('zone_id') == $zone->id ? 'selected' : '' }}>
                                    {{ $zone->name }} ({{ $zone->city->name }})
                                </option>
                            @endforeach
                        </select>
                        @error('zone_id')
                            <p class="text-red-500 text-sm mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-6">
                    <div class="mb-4">
                        <label for="type" class="block text-sm font-semibold text-gray-700 mb-2">Type</label>
                        <select name="type" id="type"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('type') border-red-500 @enderror text-sm">
                            <option value="">Select Type</option>
                            <option value="football" {{ old('type') == 'football' ? 'selected' : '' }}>Football</option>
                            <option value="basketball" {{ old('type') == 'basketball' ? 'selected' : '' }}>Basketball</option>
                            <option value="tennis" {{ old('type') == 'tennis' ? 'selected' : '' }}>Tennis</option>
                            <option value="volleyball" {{ old('type') == 'volleyball' ? 'selected' : '' }}>Volleyball</option>
                            <option value="multi" {{ old('type') == 'multi' ? 'selected' : '' }}>Multi</option>
                        </select>
                        @error('type')
                            <p class="text-red-500 text-sm mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="price_per_hour" class="block text-sm font-semibold text-gray-700 mb-2">Price per Hour
                            ($)</label>
                        <input type="number" name="price_per_hour" id="price_per_hour" value="{{ old('price_per_hour') }}"
                            step="0.01" placeholder="0.00"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('price_per_hour') border-red-500 @enderror text-sm">
                        @error('price_per_hour')
                            <p class="text-red-500 text-sm mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="location_url" class="block text-sm font-semibold text-gray-700 mb-2">Location
                            URL</label>
                        <input type="url" name="location_url" id="location_url" value="{{ old('location_url') }}"
                            placeholder="https://maps.google.com/..."
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('location_url') border-red-500 @enderror text-sm">
                        @error('location_url')
                            <p class="text-red-500 text-sm mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="mb-4">
                        <label for="min_booking_hours" class="block text-sm font-semibold text-gray-700 mb-2">Min Booking
                            Hours</label>
                        <input type="number" name="min_booking_hours" id="min_booking_hours"
                            value="{{ old('min_booking_hours', 1) }}"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('min_booking_hours') border-red-500 @enderror text-sm">
                        @error('min_booking_hours')
                            <p class="text-red-500 text-sm mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="max_booking_hours" class="block text-sm font-semibold text-gray-700 mb-2">Max Booking
                            Hours</label>
                        <input type="number" name="max_booking_hours" id="max_booking_hours"
                            value="{{ old('max_booking_hours', 4) }}"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('max_booking_hours') border-red-500 @enderror text-sm">
                        @error('max_booking_hours')
                            <p class="text-red-500 text-sm mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="mb-4">
                        <label for="opening_time" class="block text-sm font-semibold text-gray-700 mb-2">Opening
                            Time</label>
                        <input type="time" name="opening_time" id="opening_time" value="{{ old('opening_time', '08:00') }}"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('opening_time') border-red-500 @enderror text-sm">
                        @error('opening_time')
                            <p class="text-red-500 text-sm mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="closing_time" class="block text-sm font-semibold text-gray-700 mb-2">Closing
                            Time</label>
                        <input type="time" name="closing_time" id="closing_time" value="{{ old('closing_time', '23:00') }}"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('closing_time') border-red-500 @enderror text-sm">
                        @error('closing_time')
                            <p class="text-red-500 text-sm mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                    <textarea name="description" id="description" rows="3" placeholder="Enter description..."
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('description') border-red-500 @enderror text-sm">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4 mb-8">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked
                            class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                        <span class="ml-3 text-sm text-gray-700 font-medium">Active</span>
                    </label>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.playgrounds.index') }}"
                        class="px-6 py-2.5 border border-gray-200 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 transition">
                        Cancel
                    </a>
                    <button type="submit"
                        class="btn-primary text-white px-8 py-2.5 rounded-xl text-sm font-medium shadow-lg shadow-emerald-500/25">
                        <i class="fas fa-save mr-2"></i> Create Playground
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection