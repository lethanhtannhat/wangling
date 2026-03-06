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
        // 1. Add columns to employees
        Schema::table('employees', function (Blueprint $table) {
            $table->string('os_version')->nullable();
            $table->string('encryption_status')->nullable();
            $table->string('user_type')->nullable();
            $table->string('admin_password_status')->nullable();
            $table->string('account_status')->nullable();
            $table->decimal('speedometer_score', 8, 2)->nullable();
            $table->decimal('novabench_score', 8, 2)->nullable();
        });

        // 2. Add columns to stocks
        Schema::table('stocks', function (Blueprint $table) {
            $table->string('os_version')->nullable();
            $table->string('encryption_status')->nullable();
            $table->string('user_type')->nullable();
            $table->string('admin_password_status')->nullable();
            $table->string('account_status')->nullable();
            $table->decimal('speedometer_score', 8, 2)->nullable();
            $table->decimal('novabench_score', 8, 2)->nullable();
        });

        // 3. Migrate Data
        $techColumns = [
            'os_version', 'encryption_status', 'user_type', 
            'admin_password_status', 'account_status', 
            'speedometer_score', 'novabench_score'
        ];

        // Move to employees
        $employees = DB::table('employees')->whereNotNull('asset_id')->get();
        foreach ($employees as $employee) {
            $asset = DB::table('assets')->where('asset_id', $employee->asset_id)->first();
            if ($asset) {
                $updateData = [];
                foreach ($techColumns as $col) {
                    $updateData[$col] = $asset->$col ?? null;
                }
                DB::table('employees')->where('id', $employee->id)->update($updateData);
            }
        }

        // Move to stocks
        $stocks = DB::table('stocks')->whereNotNull('asset_id')->get();
        foreach ($stocks as $stock) {
            $asset = DB::table('assets')->where('asset_id', $stock->asset_id)->first();
            if ($asset) {
                $updateData = [];
                foreach ($techColumns as $col) {
                    $updateData[$col] = $asset->$col ?? null;
                }
                DB::table('stocks')->where('id', $stock->id)->update($updateData);
            }
        }

        // 4. Drop columns from assets
        Schema::table('assets', function (Blueprint $table) use ($techColumns) {
            $table->dropColumn($techColumns);
        });
    }

    public function down(): void
    {
        $techColumns = [
            'os_version', 'encryption_status', 'user_type', 
            'admin_password_status', 'account_status', 
            'speedometer_score', 'novabench_score'
        ];

        Schema::table('assets', function (Blueprint $table) {
            $table->string('os_version')->nullable();
            $table->string('encryption_status')->nullable();
            $table->string('user_type')->nullable();
            $table->string('admin_password_status')->nullable();
            $table->string('account_status')->nullable();
            $table->decimal('speedometer_score', 8, 2)->nullable();
            $table->decimal('novabench_score', 8, 2)->nullable();
        });

        // Reverse migration of data if needed (optional)

        Schema::table('employees', function (Blueprint $table) use ($techColumns) {
            $table->dropColumn($techColumns);
        });

        Schema::table('stocks', function (Blueprint $table) use ($techColumns) {
            $table->dropColumn($techColumns);
        });
    }
};
