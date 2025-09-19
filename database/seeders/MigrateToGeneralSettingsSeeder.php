<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MigrateToGeneralSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing settings from our old system
        $settings = Setting::all();

        // Prepare data for the general_settings table
        $generalSettingsData = [
            'site_name' => null,
            'site_description' => null,
            'site_logo' => null,
            'site_favicon' => null,
            'theme_color' => null,
            'support_email' => null,
            'support_phone' => null,
            'google_analytics_id' => null,
            'seo_title' => null,
            'seo_keywords' => null,
            'social_network' => [],
            'more_configs' => [],
        ];

        // Map our existing settings to the plugin structure
        foreach ($settings as $setting) {
            switch ($setting->key) {
                case 'company_name':
                    $generalSettingsData['site_name'] = $setting->value;
                    break;
                case 'site_tagline':
                    $generalSettingsData['site_description'] = $setting->value;
                    break;
                case 'site_logo':
                    $generalSettingsData['site_logo'] = $setting->file_path;
                    break;
                case 'site_favicon':
                    $generalSettingsData['site_favicon'] = $setting->file_path;
                    break;
                case 'primary_color':
                    $generalSettingsData['theme_color'] = $setting->value;
                    break;
                case 'contact_email':
                    $generalSettingsData['support_email'] = $setting->value;
                    break;
                case 'contact_phone':
                    $generalSettingsData['support_phone'] = $setting->value;
                    break;
                case 'facebook_url':
                    $generalSettingsData['social_network']['facebook'] = $setting->value;
                    break;
                case 'twitter_url':
                    $generalSettingsData['social_network']['twitter'] = $setting->value;
                    break;
                case 'linkedin_url':
                    $generalSettingsData['social_network']['linkedin'] = $setting->value;
                    break;
                default:
                    // Store other settings in more_configs
                    $generalSettingsData['more_configs'][$setting->key] = [
                        'value' => $setting->value,
                        'type' => $setting->type,
                        'group' => $setting->group,
                        'description' => $setting->description,
                        'file_path' => $setting->file_path,
                    ];
                    break;
            }
        }

        // Convert arrays to JSON
        $generalSettingsData['social_network'] = json_encode($generalSettingsData['social_network']);
        $generalSettingsData['more_configs'] = json_encode($generalSettingsData['more_configs']);

        // Insert or update the general_settings record
        DB::table('general_settings')->updateOrInsert(
            ['id' => 1],
            array_merge($generalSettingsData, [
                'created_at' => now(),
                'updated_at' => now(),
            ])
        );

        $this->command->info('Successfully migrated settings to General Settings plugin!');
    }
}
