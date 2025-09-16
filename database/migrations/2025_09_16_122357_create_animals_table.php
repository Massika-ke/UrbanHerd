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
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
             $table->foreignId('farm_id')->constrained()->onDelete('cascade');
            $table->string('tag_number')->unique(); // Physical tag identifier
            $table->enum('animal_type', ['cow', 'goat', 'sheep', 'chicken']);
            $table->string('breed');
            $table->integer('age_months');
            $table->enum('gender', ['male', 'female']);
            $table->decimal('weight_kg', 8, 2);
            $table->enum('health_status', ['excellent', 'good', 'fair', 'poor']);
            $table->decimal('purchase_price', 12, 2);
            $table->decimal('current_value', 12, 2);
            $table->date('last_health_check')->nullable();
            $table->json('medical_history')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['active', 'sold', 'deceased', 'transferred']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
