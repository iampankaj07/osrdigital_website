<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class AdminSettings extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'description',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'value' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($setting) {
            Cache::forget("admin_setting_{$setting->key}");
            Cache::forget("admin_settings_group_{$setting->group}");
        });

        static::deleted(function ($setting) {
            Cache::forget("admin_setting_{$setting->key}");
            Cache::forget("admin_settings_group_{$setting->group}");
        });
    }

    /**
     * Get setting value by key
     */
    public static function get($key, $default = null)
    {
        return Cache::remember("admin_setting_{$key}", 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set setting value
     */
    public static function set($key, $value, $type = 'string', $group = 'general', $description = null, $isPublic = false)
    {
        return static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'group' => $group,
                'description' => $description,
                'is_public' => $isPublic,
            ]
        );
    }

    /**
     * Get settings by group
     */
    public static function getGroup($group)
    {
        return Cache::remember("admin_settings_group_{$group}", 3600, function () use ($group) {
            return static::where('group', $group)->get()->pluck('value', 'key')->toArray();
        });
    }

    /**
     * Get all public settings
     */
    public static function getPublicSettings()
    {
        return Cache::remember('admin_public_settings', 3600, function () {
            return static::where('is_public', true)->get()->pluck('value', 'key')->toArray();
        });
    }
}
