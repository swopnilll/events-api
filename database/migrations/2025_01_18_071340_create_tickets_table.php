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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Links to users table
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade'); // Links to events table
            $table->string('ticket_type'); // e.g., "VIP", "General", etc.
            $table->string('ticket_status')->default('active'); // e.g., "active", "used", "expired"
            $table->date('purchase_date')->nullable();
            $table->decimal('price', 10, 2); // Ticket price
            $table->string('generated_code')->unique(); // Unique ticket code
            $table->string('entry_password')->nullable(); // For secure entry

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
