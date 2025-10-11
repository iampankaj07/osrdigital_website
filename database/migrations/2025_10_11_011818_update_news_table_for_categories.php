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
        Schema::table('news', function (Blueprint $table) {
            // Add category_id column
            $table->unsignedBigInteger('category_id')->nullable()->after('featured');
            
            // Add foreign key constraint
            $table->foreign('category_id')->references('id')->on('news_categories')->onDelete('set null');
            
            // Drop the old category column
            $table->dropColumn('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['category_id']);
            
            // Drop category_id column
            $table->dropColumn('category_id');
            
            // Add back the old category column
            $table->string('category')->nullable()->after('featured');
        });
    }
};
