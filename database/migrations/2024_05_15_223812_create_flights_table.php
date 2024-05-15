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
        Schema::create('flights', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->foreignId('airline_id');
            $table->integer('number')->nullable(false);
            $table->foreignId('departure_airport_id');
            $table->datetime('departure_time')->nullable(false);
            $table->foreignId('arrival_airport_id');
            $table->datetime('arrival_time')->nullable(false);
            $table->double('price')->nullable(false);

            $table->foreign('airline_id')->references('id')->on('airlines')->cascadeOnDelete();
            $table->foreign('departure_airport_id')->references('id')->on('airports')->cascadeOnDelete();
            $table->foreign('arrival_airport_id')->references('id')->on('airports')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            Schema::table('flights', function (Blueprint $table) {
                $table->dropForeign('airline_id');
                $table->dropForeign('departure_airport_id');
                $table->dropForeign('arrival_airport_id');
            });
        } catch (Exception $e) {
            //
        }
        Schema::dropIfExists('flights');
    }
};
