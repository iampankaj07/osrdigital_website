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
            // About page template fields
            $table->text('about_mission')->nullable();
            $table->text('about_vision')->nullable();
            $table->string('about_youtube_link')->nullable();

            // What we do section fields
            $table->string('about_service_1_title')->nullable();
            $table->text('about_service_1_description')->nullable();
            $table->string('about_service_2_title')->nullable();
            $table->text('about_service_2_description')->nullable();
            $table->string('about_service_3_title')->nullable();
            $table->text('about_service_3_description')->nullable();

            // Statistics fields
            $table->integer('about_stat_1_value')->nullable();
            $table->string('about_stat_1_label')->nullable();
            $table->integer('about_stat_2_value')->nullable();
            $table->string('about_stat_2_label')->nullable();
            $table->integer('about_stat_3_value')->nullable();
            $table->string('about_stat_3_label')->nullable();
            $table->integer('about_stat_4_value')->nullable();
            $table->string('about_stat_4_label')->nullable();

            // Hero section fields
            $table->string('about_primary_button_text')->nullable();
            $table->string('about_secondary_button_text')->nullable();
            $table->string('about_hero_badge_text')->nullable();

            // Template type field
            $table->string('template_type')->nullable()->default('default');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn([
                'about_mission',
                'about_vision',
                'about_youtube_link',
                'about_service_1_title',
                'about_service_1_description',
                'about_service_2_title',
                'about_service_2_description',
                'about_service_3_title',
                'about_service_3_description',
                'about_stat_1_value',
                'about_stat_1_label',
                'about_stat_2_value',
                'about_stat_2_label',
                'about_stat_3_value',
                'about_stat_3_label',
                'about_stat_4_value',
                'about_stat_4_label',
                'about_primary_button_text',
                'about_secondary_button_text',
                'about_hero_badge_text',
                'template_type',
            ]);
        });
    }
};
