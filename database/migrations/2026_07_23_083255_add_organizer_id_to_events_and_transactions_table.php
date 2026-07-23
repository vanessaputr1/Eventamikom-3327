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
        if (!Schema::hasColumn('events', 'organizer_id')) {
            Schema::table('events', function (Blueprint $table) {
                $table->unsignedBigInteger('organizer_id')->nullable()->after('category_id');
            });
        }

        if (!Schema::hasColumn('transactions', 'organizer_id')) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->unsignedBigInteger('organizer_id')->nullable()->after('event_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('transactions', 'organizer_id')) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->dropColumn('organizer_id');
            });
        }

        if (Schema::hasColumn('events', 'organizer_id')) {
            Schema::table('events', function (Blueprint $table) {
                $table->dropColumn('organizer_id');
            });
        }
    }
};
