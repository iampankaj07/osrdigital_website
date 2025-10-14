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
        Schema::table('team_members', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('name');
            $table->text('description')->nullable()->after('department');
            $table->string('phone')->nullable()->after('email');
            $table->json('social_links')->nullable()->after('twitter');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('team_members', function (Blueprint $table) {
            $table->dropColumn(['slug', 'description', 'phone', 'social_links']);
        });
    }
};
