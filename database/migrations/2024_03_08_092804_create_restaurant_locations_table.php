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
        Schema::create('restaurant_locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rider_id');
            $table->decimal('lat', 8, 6);
            $table->decimal('long', 9, 6);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_locations');
    }
};
