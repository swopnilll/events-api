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
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            $table->string('title'); // Event title
            $table->text('description'); // Event description
            $table->dateTime('start_date'); // Start date and time
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // Foreign key to categories
            $table->string('language'); // Language of the event
            $table->enum('event_type', ['online', 'offline']); // Type of event
            $table->string('location')->nullable(); // Location (optional for online events)
            $table->string('online_link')->nullable(); // Link for online events
            $table->boolean('is_paid')->default(false); // Whether the event is paid
            $table->unsignedInteger('max_capacity')->nullable(); // Maximum attendees
            $table->unsignedInteger('current_capacity')->default(0); // Current attendees

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
