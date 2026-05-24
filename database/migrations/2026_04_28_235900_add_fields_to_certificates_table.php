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
        Schema::table('certificates', function (Blueprint $table) {
            if (!Schema::hasColumn('certificates', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable();
            }
            if (!Schema::hasColumn('certificates', 'first')) {
                $table->string('first')->nullable();
            }
            if (!Schema::hasColumn('certificates', 'last')) {
                $table->string('last')->nullable();
            }
            if (!Schema::hasColumn('certificates', 'score')) {
                $table->integer('score')->nullable();
            }
            if (!Schema::hasColumn('certificates', 'percentage')) {
                $table->decimal('percentage', 5, 2)->nullable();
            }
            if (!Schema::hasColumn('certificates', 'passed')) {
                $table->boolean('passed')->default(false);
            }
            if (!Schema::hasColumn('certificates', 'awarded_at')) {
                $table->timestamp('awarded_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropUnique(['username', 'course_name']);
            $table->dropColumn([
                'user_id',
                'username',
                'first',
                'last',
                'course_name',
                'score',
                'percentage',
                'passed',
                'awarded_at',
            ]);
        });
    }
};
