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
        Schema::create('trip_flights', function (Blueprint $table) {
            $table->foreignId('trip_id');
            $table->foreignId('flight_id');

            $table->foreign('trip_id')->references('id')->on('trips');
            $table->foreign('flight_id')->references('id')->on('flights');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            Schema::table('trip_flights', function (Blueprint $table) {
                $table->dropForeign('trip_id')->cascadeOnDelete();
                $table->dropForeign('flight_id')->cascadeOnDelete();
            });
        } catch (Exception $e) {
            //
        }
        Schema::dropIfExists('trip_flights');
    }
};
