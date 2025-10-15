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
            // Add new JSON column for services
            $table->json('about_services')->nullable()->after('about_what_we_do_description');

            // Remove old individual service columns
            $table->dropColumn([
                'about_service_1_title',
                'about_service_1_description',
                'about_service_2_title',
                'about_service_2_description',
                'about_service_3_title',
                'about_service_3_description'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            // Restore old individual service columns
            $table->string('about_service_1_title')->nullable();
            $table->text('about_service_1_description')->nullable();
            $table->string('about_service_2_title')->nullable();
            $table->text('about_service_2_description')->nullable();
            $table->string('about_service_3_title')->nullable();
            $table->text('about_service_3_description')->nullable();

            // Remove JSON column
            $table->dropColumn('about_services');
        });
    }
};
