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
        Schema::table('hero_sections', function (Blueprint $table) {
            // Add new columns for home page hero sections
            $table->string('button_url')->nullable()->after('button_text');
            $table->string('button_url_secondary')->nullable()->after('button_text_secondary');
            $table->enum('background_type', ['color', 'image'])->default('color')->after('button_url_secondary');
            $table->string('background_color')->nullable()->after('background_type');
            $table->string('background_image')->nullable()->after('background_color');
            $table->string('text_color')->default('#ffffff')->after('background_image');
            
            // Drop old columns if they exist
            if (Schema::hasColumn('hero_sections', 'button_link')) {
                $table->dropColumn('button_link');
            }
            if (Schema::hasColumn('hero_sections', 'button_link_secondary')) {
                $table->dropColumn('button_link_secondary');
            }
            if (Schema::hasColumn('hero_sections', 'page')) {
                $table->dropColumn('page');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hero_sections', function (Blueprint $table) {
            // Reverse the changes
            $table->dropColumn([
                'button_url',
                'button_url_secondary', 
                'background_type',
                'background_color',
                'background_image',
                'text_color'
            ]);
            
            // Restore old columns
            $table->string('button_link')->nullable();
            $table->string('button_link_secondary')->nullable();
            $table->string('page')->nullable();
        });
    }
};
