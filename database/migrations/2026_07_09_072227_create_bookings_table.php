<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('play_ground_id')->constrained('play_grounds')->cascadeOnDelete();
            $table->foreignId('coupon_id')->constrained('coupons')->cascadeOnDelete();
            $table->dateTime('start_date_time');
            $table->dateTime('end_date_time');
            $table->dateTime('cancelled_at')->nullable();
            $table->enum('status',['pending', 'confirmed', 'rejected', 'cancelled']);
            $table->string('payment_method');
            $table->enum('payment_status', ['paid', 'unpaid']);
            $table->decimal('total_price', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
