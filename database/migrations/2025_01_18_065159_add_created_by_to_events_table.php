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
        Schema::table('events', function (Blueprint $table) {
            $table->foreignId('created_by')
                ->nullable() // If an event might not have a creator initially
                ->constrained('users') // References 'id' on the 'users' table
                ->onDelete('set null'); // Set to null if the user is deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['created_by']); // Drop the foreign key
            $table->dropColumn('created_by');    // Remove the column
        });
    }
};
