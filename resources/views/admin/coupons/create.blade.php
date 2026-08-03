@extends('layouts.admin')

@section('title', 'Add Coupon')
@section('page-title', 'Add New Coupon')
@section('page-subtitle', 'Create a new discount coupon')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-50 p-8">
            <form action="{{ route('admin.coupons.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="code" class="block text-sm font-semibold text-gray-700 mb-2">Coupon Code</label>
                    <input type="text" name="code" id="code" value="{{ old('code') }}" placeholder="e.g. SUMMER2025"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('code') border-red-500 @enderror text-sm uppercase">
                    @error('code')
                        <p class="text-red-500 text-sm mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="discount_type" class="block text-sm font-semibold text-gray-700 mb-2">Discount
                            Type</label>
                        <select name="discount_type" id="discount_type"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('discount_type') border-red-500 @enderror text-sm">
                            <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Percentage
                                (%)</option>
                            <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Fixed Amount ($)
                            </option>
                        </select>
                        @error('discount_type')
                            <p class="text-red-500 text-sm mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="discount_value" class="block text-sm font-semibold text-gray-700 mb-2">Discount
                            Value</label>
                        <input type="number" name="discount_value" id="discount_value" value="{{ old('discount_value') }}"
                            step="0.01" placeholder="0.00"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('discount_value') border-red-500 @enderror text-sm">
                        @error('discount_value')
                            <p class="text-red-500 text-sm mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="max_uses" class="block text-sm font-semibold text-gray-700 mb-2">Max Uses (leave empty for
                        unlimited)</label>
                    <input type="number" name="max_uses" id="max_uses" value="{{ old('max_uses') }}" placeholder="e.g. 100"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('max_uses') border-red-500 @enderror text-sm">
                    @error('max_uses')
                        <p class="text-red-500 text-sm mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="starts_at" class="block text-sm font-semibold text-gray-700 mb-2">Start Date</label>
                        <input type="datetime-local" name="starts_at" id="starts_at" value="{{ old('starts_at') }}"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('starts_at') border-red-500 @enderror text-sm">
                        @error('starts_at')
                            <p class="text-red-500 text-sm mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="expires_at" class="block text-sm font-semibold text-gray-700 mb-2">Expiry Date</label>
                        <input type="datetime-local" name="expires_at" id="expires_at" value="{{ old('expires_at') }}"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('expires_at') border-red-500 @enderror text-sm">
                        @error('expires_at')
                            <p class="text-red-500 text-sm mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-8">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked
                            class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                        <span class="ml-3 text-sm text-gray-700 font-medium">Active</span>
                    </label>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.coupons.index') }}"
                        class="px-6 py-2.5 border border-gray-200 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 transition">
                        Cancel
                    </a>
                    <button type="submit"
                        class="btn-primary text-white px-8 py-2.5 rounded-xl text-sm font-medium shadow-lg shadow-emerald-500/25">
                        <i class="fas fa-save mr-2"></i> Create Coupon
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection