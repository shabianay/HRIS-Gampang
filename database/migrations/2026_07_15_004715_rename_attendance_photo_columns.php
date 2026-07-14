<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->renameColumn('photo_url', 'photo_in');
            $table->renameColumn('clock_out_photo_url', 'photo_out');
        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->renameColumn('photo_in', 'photo_url');
            $table->renameColumn('photo_out', 'clock_out_photo_url');
        });
    }
};
