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
        Schema::table('users', function (Blueprint $table) {
            // Adding the foreign key column
            $table->foreignId('role_id')
                ->nullable() // Allows null if the user might not have a role initially
                ->constrained('roles') // References the 'id' column on the 'roles' table
                ->onDelete('cascade'); // Cascade delete if the role is deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']); // Drop the foreign key
            $table->dropColumn('role_id');    // Remove the column
        });
    }
};
