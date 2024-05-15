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
        Schema::create('airports', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('code')->nullable(false);
            $table->foreignId('city_id');
            $table->string('name')->nullable(false);
            $table->double('latitude')->nullable(false);
            $table->double('longitude')->nullable(false);
            $table->string('timezone')->nullable(false);

            $table->foreign('city_id')->references('id')->on('locations')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            Schema::table('airports', function (Blueprint $table) {
                $table->dropForeign('city_id');
            });
        } catch (Exception $e) {
            //
        }
        Schema::dropIfExists('airports');
    }
};
