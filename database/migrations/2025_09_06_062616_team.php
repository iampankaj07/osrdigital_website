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
         Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('designation')->nullable();
            $table->string('image')->default('text'); 
            $table->string('linkedIn')->nullable();
            $table->string('github')->nullable();
            $table->string('email')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    Schema::dropIfExists('team');
    }
};
