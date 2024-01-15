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
        Schema::table('quiz_subscribers', function (Blueprint $table) {
            // Drop the existing primary key
            $table->dropPrimary();

            // Change the type of the 'id' column to string
            $table->uuid('id')->change();

            // Add the primary key back
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quiz_subscribers', function (Blueprint $table) {
            // Revert back to the auto-increment ID
            $table->dropPrimary();
            $table->integer('id', true)->change();
            $table->primary('id');
        });
    }
};
