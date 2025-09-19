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
        Schema::table('pages', function (Blueprint $table) {
            // Add title fields for About page sections
            $table->string('about_mission_title')->nullable()->default('Our Mission');
            $table->string('about_vision_title')->nullable()->default('Our Vision');
            $table->string('about_what_we_do_title')->nullable()->default('What We Do');
            $table->text('about_what_we_do_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn([
                'about_mission_title',
                'about_vision_title',
                'about_what_we_do_title',
                'about_what_we_do_description',
            ]);
        });
    }
};
