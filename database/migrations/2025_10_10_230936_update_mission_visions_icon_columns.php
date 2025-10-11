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
        Schema::table('mission_visions', function (Blueprint $table) {
            $table->string('mission_icon', 50)->change();
            $table->string('vision_icon', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mission_visions', function (Blueprint $table) {
            $table->string('mission_icon', 10)->change();
            $table->string('vision_icon', 10)->change();
        });
    }
};