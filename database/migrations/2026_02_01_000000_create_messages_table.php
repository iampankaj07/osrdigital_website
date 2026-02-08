<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('company')->nullable();
            $table->string('phone')->nullable();
            $table->string('type')->nullable();
            $table->string('subject')->nullable();
            $table->text('body')->nullable();
            $table->enum('status', ['new', 'read', 'archived'])->default('new');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
};
