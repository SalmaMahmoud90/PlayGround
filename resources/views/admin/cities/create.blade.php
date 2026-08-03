@extends('layouts.admin')

@section('title', 'Add City')
@section('page-title', 'Add New City')
@section('page-subtitle', 'Create a new city for your platform')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-50 p-8">
            <form action="{{ route('admin.cities.store') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">City Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Enter city name..."
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('name') border-red-500 @enderror text-sm">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1.5 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1.5"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-8">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked
                            class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                        <span class="ml-3 text-sm text-gray-700 font-medium">Active</span>
                    </label>
                    <p class="text-xs text-gray-400 mt-1 ml-7">Inactive cities won't appear in listings</p>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.cities.index') }}"
                        class="px-6 py-2.5 border border-gray-200 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 transition">
                        Cancel
                    </a>
                    <button type="submit"
                        class="btn-primary text-white px-8 py-2.5 rounded-xl text-sm font-medium shadow-lg shadow-emerald-500/25">
                        <i class="fas fa-save mr-2"></i> Create City
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection