<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class UpdateLogoSeeder extends Seeder
{
    /**
     * Run the database seeder to update logos to use osrdigital-seeklogo.svg
     */
    public function run(): void
    {
        $logoPath = 'logos/osrdigital-seeklogo.svg';

        $logoSettings = [
            [
                'key' => 'logo_light',
                'value' => $logoPath,
                'type' => 'text',
                'group' => 'branding',
                'is_public' => true,
                'description' => 'Main logo for light theme'
            ],
            [
                'key' => 'logo_dark',
                'value' => $logoPath,
                'type' => 'text',
                'group' => 'branding',
                'is_public' => true,
                'description' => 'Main logo for dark theme'
            ],
            [
                'key' => 'logo_admin',
                'value' => $logoPath,
                'type' => 'text',
                'group' => 'branding',
                'is_public' => true,
                'description' => 'Logo for admin panel'
            ],
            [
                'key' => 'logo_mobile',
                'value' => $logoPath,
                'type' => 'text',
                'group' => 'branding',
                'is_public' => true,
                'description' => 'Logo for mobile devices'
            ],
            [
                'key' => 'logo_footer',
                'value' => $logoPath,
                'type' => 'text',
                'group' => 'branding',
                'is_public' => true,
                'description' => 'Logo for footer section'
            ],
            [
                'key' => 'logo_email',
                'value' => $logoPath,
                'type' => 'text',
                'group' => 'branding',
                'is_public' => true,
                'description' => 'Logo for email templates'
            ],
            [
                'key' => 'site_title',
                'value' => 'OSR Digital',
                'type' => 'text',
                'group' => 'general',
                'is_public' => true,
                'description' => 'Website title'
            ],
            [
                'key' => 'site_description',
                'value' => 'Entertaining the Nation - Your premier destination for digital entertainment content.',
                'type' => 'text',
                'group' => 'general',
                'is_public' => true,
                'description' => 'Website description'
            ]
        ];

        foreach ($logoSettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        $this->command->info('Logo settings updated successfully to use osrdigital-seeklogo.svg!');
    }
}
