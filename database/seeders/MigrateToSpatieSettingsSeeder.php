<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MigrateToSpatieSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get data from the old general_settings table
        $generalSettingsData = DB::table('general_settings')->first();
        
        if (!$generalSettingsData) {
            $this->command->info('No data found in general_settings table.');
            return;
        }

        // Decode JSON fields
        $seoMetadata = $generalSettingsData->seo_metadata ? json_decode($generalSettingsData->seo_metadata, true) : null;
        $emailSettings = $generalSettingsData->email_settings ? json_decode($generalSettingsData->email_settings, true) : null;
        $socialNetwork = $generalSettingsData->social_network ? json_decode($generalSettingsData->social_network, true) : null;
        $moreConfigs = $generalSettingsData->more_configs ? json_decode($generalSettingsData->more_configs, true) : null;

        // Create the settings payload
        $settingsData = [
            'site_name' => $generalSettingsData->site_name,
            'site_description' => $generalSettingsData->site_description,
            'site_logo' => $generalSettingsData->site_logo,
            'site_favicon' => $generalSettingsData->site_favicon,
            'theme_color' => $generalSettingsData->theme_color,
            'support_email' => $generalSettingsData->support_email,
            'support_phone' => $generalSettingsData->support_phone,
            'google_analytics_id' => $generalSettingsData->google_analytics_id,
            'posthog_html_snippet' => $generalSettingsData->posthog_html_snippet,
            'seo_title' => $generalSettingsData->seo_title,
            'seo_keywords' => $generalSettingsData->seo_keywords,
            'seo_metadata' => $seoMetadata,
            'email_settings' => $emailSettings,
            'email_from_address' => $generalSettingsData->email_from_address,
            'email_from_name' => $generalSettingsData->email_from_name,
            'social_network' => $socialNetwork,
            'more_configs' => $moreConfigs,
        ];

        // Insert into spatie_settings table
        DB::table('spatie_settings')->updateOrInsert(
            ['group' => 'general', 'name' => 'general'],
            [
                'group' => 'general',
                'name' => 'general',
                'locked' => false,
                'payload' => json_encode($settingsData),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $this->command->info('Successfully migrated general settings to Spatie Laravel Settings format.');
    }
}
