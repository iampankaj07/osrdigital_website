<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // Add nullable company, phone, and type columns if they don't already exist
            if (!Schema::hasColumn('messages', 'company')) {
                $table->string('company')->nullable()->after('email');
            }

            if (!Schema::hasColumn('messages', 'phone')) {
                $table->string('phone')->nullable()->after('company');
            }

            if (!Schema::hasColumn('messages', 'type')) {
                $table->string('type')->nullable()->after('phone');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            if (Schema::hasColumn('messages', 'type')) {
                $table->dropColumn('type');
            }

            if (Schema::hasColumn('messages', 'phone')) {
                $table->dropColumn('phone');
            }

            if (Schema::hasColumn('messages', 'company')) {
                $table->dropColumn('company');
            }
        });
    }
};
