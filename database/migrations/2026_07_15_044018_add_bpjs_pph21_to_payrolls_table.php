<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payrolls', function (Blueprint $table) {
            $table->decimal('bpjs_kesehatan_employee', 12, 2)->default(0)->after('total_deduction');
            $table->decimal('bpjs_ketenagakerjaan_employee', 12, 2)->default(0)->after('bpjs_kesehatan_employee');
            $table->decimal('pph21', 12, 2)->default(0)->after('bpjs_ketenagakerjaan_employee');
        });
    }

    public function down(): void
    {
        Schema::table('payrolls', function (Blueprint $table) {
            $table->dropColumn(['bpjs_kesehatan_employee', 'bpjs_ketenagakerjaan_employee', 'pph21']);
        });
    }
};
