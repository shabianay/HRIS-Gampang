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
        Schema::table('attendances', function (Blueprint $table) {
            // Rename existing columns to clock_in_latitude and clock_in_longitude
            $table->renameColumn('latitude', 'clock_in_latitude');
            $table->renameColumn('longitude', 'clock_in_longitude');

            // Add new columns for clock out latitude and longitude
            $table->decimal('clock_out_latitude', 10, 7)->nullable()->after('clock_in_longitude');
            $table->decimal('clock_out_longitude', 10, 7)->nullable()->after('clock_out_latitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            // Reverse rename
            $table->renameColumn('clock_in_latitude', 'latitude');
            $table->renameColumn('clock_in_longitude', 'longitude');

            // Drop new columns
            $table->dropColumn(['clock_out_latitude', 'clock_out_longitude']);
        });
    }
};
