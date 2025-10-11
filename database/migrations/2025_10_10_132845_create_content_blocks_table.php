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
        Schema::create('content_blocks', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // hero, text, image, gallery, cta, etc.
            $table->string('name'); // Human-readable name
            $table->json('data'); // Block-specific data
            $table->json('settings')->nullable(); // Block-specific settings
            $table->string('category')->default('general'); // Grouping
            $table->boolean('is_reusable')->default(false); // Can be reused across pages
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_blocks');
    }
};
