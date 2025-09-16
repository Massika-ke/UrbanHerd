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
        Schema::create('market_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('users');
            $table->foreignId('animal_id')->constrained();
            $table->integer('shares_for_sale');
            $table->decimal('asking_price_per_share', 10, 2);
            $table->decimal('total_asking_price', 12, 2);
            $table->decimal('minimum_sale_shares', 10, 0)->default(1);
            $table->text('description')->nullable();
            $table->enum('listing_type', ['fixed_price', 'auction', 'negotiable']);
            $table->timestamp('listing_date');
            $table->timestamp('expires_at')->nullable();
            $table->enum('status', ['active', 'partial_filled', 'completed', 'cancelled', 'expired']);
            $table->integer('shares_sold')->default(0);
            $table->decimal('total_received', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('market_listings');
    }
};
