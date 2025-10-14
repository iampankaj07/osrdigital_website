<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Setting extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'description',
        'is_public',
        'file_path',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    /**
     * Register media collections for settings assets
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml']);

        $this->addMediaCollection('favicon')
            ->singleFile()
            ->acceptsMimeTypes(['image/x-icon', 'image/png', 'image/gif']);
    }

    /**
     * Get a setting value by key
     */
    public static function getValue(string $key, $default = null)
    {
        return Cache::remember("setting_{$key}", 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();

            if (!$setting) {
                return $default;
            }

            return match ($setting->type) {
                'boolean' => (bool) $setting->value,
                'json' => json_decode($setting->value, true),
                'integer' => (int) $setting->value,
                'float' => (double) $setting->value,
                default => $setting->value,
            };
        });
    }

    /**
     * Set a setting value
     */
    public static function set(string $key, $value, string $type = 'text', string $group = 'general', ?string $description = null, bool $isPublic = false)
    {
        $processedValue = match ($type) {
            'boolean' => $value ? '1' : '0',
            'json' => json_encode($value),
            default => (string) $value,
        };

        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $processedValue,
                'type' => $type,
                'group' => $group,
                'description' => $description,
                'is_public' => $isPublic,
            ]
        );

        Cache::forget("setting_{$key}");
        Cache::forget('public_settings');

        return $setting;
    }

    /**
     * Get all public settings for frontend
     */
    public static function getPublicSettings()
    {
        return Cache::remember('public_settings', 3600, function () {
            return static::where('is_public', true)
                ->get()
                ->pluck('value', 'key')
                ->toArray();
        });
    }

    /**
     * Get settings by group
     */
    public static function getByGroup(string $group)
    {
        return static::where('group', $group)->get();
    }

    /**
     * Clear all settings cache
     */
    public static function clearCache()
    {
        $settings = static::all();
        foreach ($settings as $setting) {
            Cache::forget("setting_{$setting->key}");
        }
        Cache::forget('public_settings');
    }

    /**
     * Get file URL for file-type settings
     */
    public function getFileUrlAttribute()
    {
        if ($this->type === 'file' && $this->file_path) {
            return Storage::url($this->file_path);
        }
        return null;
    }

    /**
     * Get theme settings grouped by category
     */
    public static function getThemeSettings()
    {
        return Cache::remember('theme_settings', 3600, function () {
            return static::whereIn('group', ['branding', 'theme', 'general', 'footer', 'header'])
                ->get()
                ->groupBy('group');
        });
    }
}
