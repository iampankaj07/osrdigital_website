<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Helpers\ImageHelper;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'filename',
        'path',
        'url',
        'mime_type',
        'extension',
        'size',
        'width',
        'height',
        'alt_text',
        'description',
        'category',
        'metadata',
        'is_public',
        'uploaded_by',
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_public' => 'boolean',
        'size' => 'integer',
        'width' => 'integer',
        'height' => 'integer',
    ];

    /**
     * Get the user who uploaded this media
     */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Get the public URL for this media
     */
    public function getPublicUrlAttribute(): string
    {
        return ImageHelper::getStorageUrl($this->path);
    }

    /**
     * Get the thumbnail URL for images
     */
    public function getThumbnailUrlAttribute(): string
    {
        if ($this->isImage()) {
            return ImageHelper::getContextualImage(
                $this->path,
                'thumbnail',
                ['width' => 150, 'height' => 150, 'text' => $this->name]
            );
        }
        
        return $this->public_url;
    }

    /**
     * Get the preview URL for images
     */
    public function getPreviewUrlAttribute(): string
    {
        if ($this->isImage()) {
            return ImageHelper::getContextualImage(
                $this->path,
                'preview',
                ['width' => 400, 'height' => 300, 'text' => $this->name]
            );
        }
        
        return $this->public_url;
    }

    /**
     * Check if this media is an image
     */
    public function isImage(): bool
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    /**
     * Check if this media is a document
     */
    public function isDocument(): bool
    {
        $documentMimes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'text/plain',
        ];
        
        return in_array($this->mime_type, $documentMimes);
    }

    /**
     * Get file size in human readable format
     */
    public function getHumanSizeAttribute(): string
    {
        $bytes = $this->size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Get file icon based on MIME type
     */
    public function getIconAttribute(): string
    {
        if ($this->isImage()) {
            return 'fas fa-image';
        }
        
        if ($this->isDocument()) {
            return 'fas fa-file-alt';
        }
        
        return 'fas fa-file';
    }

    /**
     * Scope for public media
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope for images only
     */
    public function scopeImages($query)
    {
        return $query->where('mime_type', 'like', 'image/%');
    }

    /**
     * Scope for documents only
     */
    public function scopeDocuments($query)
    {
        return $query->where('mime_type', 'not like', 'image/%');
    }

    /**
     * Scope by category
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope by uploaded by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('uploaded_by', $userId);
    }
}
