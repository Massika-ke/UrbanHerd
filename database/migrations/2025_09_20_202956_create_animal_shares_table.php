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
        Schema::create('animal_shares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_id')->constrained()->onDelete('cascade');
            $table->integer('total_shares');
            $table->integer('available_shares');
            $table->decimal('price_per_share', 10, 2);
            $table->decimal('minimum_investment', 10, 2);
            $table->boolean('is_available')->default(true);
            $table->timestamp('listing_date');
            $table->timestamp('last_price_update');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animal_shares');
    }
};
