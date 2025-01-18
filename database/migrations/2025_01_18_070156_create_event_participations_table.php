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
        Schema::create('event_participations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id') // References the user participating
                ->constrained('users') // Links to 'id' on 'users' table
                ->onDelete('cascade'); // Delete participations if user is deleted
            $table->foreignId('event_id') // References the event being participated in
                ->constrained('events') // Links to 'id' on 'events' table
                ->onDelete('cascade'); // Delete participations if event is deleted
            $table->foreignId('role_id') // Role in the participation
                ->nullable() // Nullable if the role is optional
                ->constrained('roles') // Links to 'id' on 'roles' table
                ->onDelete('set null'); // Set role_id to null if role is deleted
            $table->string('payment_status')->default('pending'); // Payment status


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_participations');
    }
};
