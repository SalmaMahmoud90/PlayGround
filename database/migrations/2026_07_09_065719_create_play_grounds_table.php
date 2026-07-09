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
        Schema::create('play_grounds', function (Blueprint $table) {
            $table->id();
            $table->text('location');
            $table->string('city');
            $table->string('type');
            $table->string('image')->nullable();
            $table->decimal('hourPrice', 10, 2);
            $table->decimal('hourWork', 10, 2);
            $table->integer('minHours');
            $table->integer('maxHours');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('play_grounds');
    }
};
