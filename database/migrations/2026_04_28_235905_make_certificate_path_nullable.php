<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('certificates') && Schema::hasColumn('certificates', 'certificate_path')) {
            DB::statement('ALTER TABLE `certificates` MODIFY `certificate_path` VARCHAR(255) NULL');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('certificates') && Schema::hasColumn('certificates', 'certificate_path')) {
            DB::statement('ALTER TABLE `certificates` MODIFY `certificate_path` VARCHAR(255) NOT NULL');
        }
    }
};
