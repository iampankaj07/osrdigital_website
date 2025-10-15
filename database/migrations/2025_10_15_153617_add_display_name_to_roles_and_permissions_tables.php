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
        $tableNames = config('permission.table_names');

        // Add display_name to permissions table
        Schema::table($tableNames['permissions'], function (Blueprint $table) {
            $table->string('display_name')->nullable()->after('name');
        });

        // Add display_name to roles table
        Schema::table($tableNames['roles'], function (Blueprint $table) {
            $table->string('display_name')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tableNames = config('permission.table_names');

        // Remove display_name from permissions table
        Schema::table($tableNames['permissions'], function (Blueprint $table) {
            $table->dropColumn('display_name');
        });

        // Remove display_name from roles table
        Schema::table($tableNames['roles'], function (Blueprint $table) {
            $table->dropColumn('display_name');
        });
    }
};