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
        Schema::create('fuel_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained();
            $table->foreignId('booking_id')->constrained();
            $table->date('date');
            $table->decimal('fuel_amount', 8, 2); // jumlah bahan bakar (liter)
            $table->decimal('fuel_cost', 12, 2); // biaya pengisian
            $table->integer('km_before');
            $table->integer('km_after');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuel_logs');
    }
};