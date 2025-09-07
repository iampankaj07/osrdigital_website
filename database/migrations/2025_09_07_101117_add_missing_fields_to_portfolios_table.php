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
        Schema::table('portfolios', function (Blueprint $table) {
            // Add fields that the WordPress-style form expects
            $table->longText('content')->nullable()->after('description');
            $table->text('excerpt')->nullable()->after('content');
            $table->string('status')->default('published')->after('is_published');

            // Add additional portfolio-specific fields
            $table->string('client_name')->nullable()->after('category');
            $table->datetime('project_date')->nullable()->after('client_name');
            $table->string('project_url')->nullable()->after('project_date');
            $table->string('github_url')->nullable()->after('project_url');
            $table->text('technologies')->nullable()->after('github_url');
            $table->string('industry')->nullable()->after('technologies');
            $table->string('completion_time')->nullable()->after('industry');
            $table->enum('difficulty_level', ['beginner', 'intermediate', 'advanced', 'expert'])->nullable()->after('completion_time');
            $table->integer('team_size')->nullable()->after('difficulty_level');
            $table->enum('project_status', ['completed', 'in_progress', 'on_hold', 'cancelled'])->default('completed')->after('team_size');
            $table->text('challenges_solved')->nullable()->after('project_status');
            $table->text('results_achieved')->nullable()->after('challenges_solved');
            $table->integer('likes')->default(0)->after('views');
            $table->longText('custom_css')->nullable()->after('likes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropColumn([
                'content', 'excerpt', 'status', 'client_name', 'project_date',
                'project_url', 'github_url', 'technologies', 'industry',
                'completion_time', 'difficulty_level', 'team_size', 'project_status',
                'challenges_solved', 'results_achieved', 'likes', 'custom_css'
            ]);
        });
    }
};
