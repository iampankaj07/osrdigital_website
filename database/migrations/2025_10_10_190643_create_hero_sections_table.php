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
        Schema::create('hero_sections', function (Blueprint $table) {
            $table->id();
            $table->string('page')->unique(); // home, about, partners, team, news
            $table->string('title');
            $table->text('subtitle')->nullable();
            $table->longText('content'); // Rich content editor
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();
            $table->string('button_text_secondary')->nullable();
            $table->string('button_link_secondary')->nullable();
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
        Schema::dropIfExists('hero_sections');
    }
};