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
        Schema::table('event_participations', function (Blueprint $table) {

            $table->foreignId('ticket_id')
                ->nullable()
                ->constrained('tickets')
                ->onDelete('cascade'); // Cascade delete to clean related data
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_participations', function (Blueprint $table) {

            $table->dropForeign(['ticket_id']);
            $table->dropColumn('ticket_id');
        });
    }
};
