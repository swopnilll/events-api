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

            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // References users table
            $table->foreignId('event_id')->constrained()->onDelete('cascade'); // References events table
            $table->decimal('amount', 10, 2); // Payment amount
            $table->string('payment_method'); // Payment method (e.g., card, PayPal)
            $table->enum('payment_status', ['pending', 'completed', 'failed'])->default('pending'); // Payment status
            $table->string('transaction_id')->unique(); // Unique transaction ID
            $table->timestamp('payment_date')->nullable(); // Payment date

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
