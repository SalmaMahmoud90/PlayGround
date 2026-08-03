<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('play_grounds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->nullable()->constrained('owners')->nullOnDelete();
            $table->foreignId('city_id')->nullable()->constrained('cities')->nullOnDelete();
            $table->foreignId('zone_id')->nullable()->constrained('zones')->nullOnDelete();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->text('location');
            $table->string('city');
            $table->string('type');
            $table->string('image')->nullable();
            $table->decimal('hourPrice', 10, 2);
            $table->string('hourWork');
            $table->integer('minHours');
            $table->integer('maxHours');
            $table->decimal('price_per_hour', 10, 2)->nullable();
            $table->integer('min_booking_hours')->nullable();
            $table->integer('max_booking_hours')->nullable();
            $table->time('opening_time')->nullable();
            $table->time('closing_time')->nullable();
            $table->string('location_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('play_grounds');
    }
};
