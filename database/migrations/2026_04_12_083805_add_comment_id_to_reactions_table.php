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
        if (!Schema::hasColumn('reactions', 'comment_id')) {
            Schema::table('reactions', function (Blueprint $table) {
                $table->unsignedBigInteger('comment_id')->nullable()->after('post_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('reactions', 'comment_id')) {
            Schema::table('reactions', function (Blueprint $table) {
                $table->dropColumn('comment_id');
            });
        }
    }
};
