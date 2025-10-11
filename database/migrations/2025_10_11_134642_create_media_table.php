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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Original filename
            $table->string('filename'); // Stored filename
            $table->string('path'); // Storage path
            $table->string('url'); // Public URL
            $table->string('mime_type'); // File MIME type
            $table->string('extension'); // File extension
            $table->bigInteger('size'); // File size in bytes
            $table->integer('width')->nullable(); // Image width
            $table->integer('height')->nullable(); // Image height
            $table->string('alt_text')->nullable(); // Alt text for accessibility
            $table->text('description')->nullable(); // Description
            $table->string('category')->nullable(); // Category (images, documents, etc.)
            $table->json('metadata')->nullable(); // Additional metadata
            $table->boolean('is_public')->default(true); // Public visibility
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade'); // Who uploaded it
            $table->timestamps();
            
            // Indexes
            $table->index(['category', 'is_public']);
            $table->index(['uploaded_by']);
            $table->index(['mime_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
