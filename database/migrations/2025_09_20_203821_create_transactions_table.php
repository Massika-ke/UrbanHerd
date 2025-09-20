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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
             $table->foreignId('user_id')->constrained();
            $table->foreignId('animal_id')->nullable()->constrained();
            $table->string('reference')->unique();
            $table->enum('type', ['deposit', 'withdrawal', 'investment', 'dividend', 'sale', 'fee']);
            $table->enum('method', ['mpesa', 'bank', 'card', 'internal'])->nullable();
            $table->decimal('amount', 15, 2);
            $table->integer('shares')->nullable();
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'cancelled']);
            $table->string('external_reference')->nullable(); // Payment gateway reference
            $table->json('metadata')->nullable(); // Additional transaction details
            $table->text('notes')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
