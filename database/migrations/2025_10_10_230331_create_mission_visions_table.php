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
        Schema::create('mission_visions', function (Blueprint $table) {
            $table->id();
            $table->text('mission_title')->nullable();
            $table->text('mission_description')->nullable();
            $table->string('mission_icon', 10)->default('🎯');
            $table->text('vision_title')->nullable();
            $table->text('vision_description')->nullable();
            $table->string('vision_icon', 10)->default('🚀');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mission_visions');
    }
};
