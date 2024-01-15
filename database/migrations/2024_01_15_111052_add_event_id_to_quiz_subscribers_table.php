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
            $table->string('event_id')->nullable()->after('tenant_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quiz_subscribers', function (Blueprint $table) {
            $table->dropColumn('event_id');
        });
    }
};
