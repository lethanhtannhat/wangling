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
        Schema::table('assets', function (Blueprint $col) {
            $col->string('encryption_status')->nullable()->after('os');
            $col->string('user_type')->nullable()->after('encryption_status');
            $col->string('admin_password_status')->nullable()->after('user_type');
            $col->string('account_status')->nullable()->after('admin_password_status');
            $col->decimal('speedometer_score', 8, 2)->nullable()->after('account_status');
            $col->decimal('novabench_score', 8, 2)->nullable()->after('speedometer_score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $col) {
            $col->dropColumn([
                'encryption_status',
                'user_type',
                'admin_password_status',
                'account_status',
                'speedometer_score',
                'novabench_score'
            ]);
        });
    }
};
