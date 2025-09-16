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
        Schema::create('market_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id')->constrained('users');
            $table->foreignId('seller_id')->constrained('users');
            $table->foreignId('listing_id')->constrained('market_listings');
            $table->foreignId('animal_id')->constrained();
            $table->integer('shares_traded');
            $table->decimal('price_per_share', 10, 2);
            $table->decimal('total_price', 12, 2);
            $table->decimal('platform_commission', 10, 2);
            $table->decimal('seller_receives', 12, 2);
            $table->string('transaction_reference')->unique();
            $table->enum('status', ['pending', 'completed', 'failed', 'cancelled']);
            $table->timestamp('completed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('market_transactions');
    }
};
