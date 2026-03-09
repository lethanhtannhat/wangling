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
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('novabench_score');
        });
        Schema::table('stocks', function (Blueprint $table) {
            $table->dropColumn('novabench_score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->decimal('novabench_score', 8, 2)->nullable();
        });
        Schema::table('stocks', function (Blueprint $table) {
            $table->decimal('novabench_score', 8, 2)->nullable();
        });
    }
};
