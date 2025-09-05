<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'key' => 'site_title',
                'value' => config('app.name', 'OSR Digital'),
                'type' => 'string',
                'is_public' => true,
            ],
            [
                'key' => 'site_description',
                'value' => 'Professional digital solutions and services',
                'type' => 'string',
                'is_public' => true,
            ],
            [
                'key' => 'logo_light',
                'value' => null,
                'type' => 'string',
                'is_public' => true,
            ],
            [
                'key' => 'logo_dark',
                'value' => null,
                'type' => 'string',
                'is_public' => true,
            ],
            [
                'key' => 'logo_admin',
                'value' => null,
                'type' => 'string',
                'is_public' => true,
            ],
            [
                'key' => 'logo_mobile',
                'value' => null,
                'type' => 'string',
                'is_public' => true,
            ],
            [
                'key' => 'logo_footer',
                'value' => null,
                'type' => 'string',
                'is_public' => true,
            ],
            [
                'key' => 'logo_email',
                'value' => null,
                'type' => 'string',
                'is_public' => true,
            ],
            [
                'key' => 'favicon',
                'value' => null,
                'type' => 'string',
                'is_public' => true,
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
