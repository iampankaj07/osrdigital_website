<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LegalPage;

class LegalPageSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $legalPages = [
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'page_type' => 'privacy_policy',
                'meta_title' => 'Privacy Policy | OSR',
                'meta_description' => 'Learn about how we collect, use, and protect your personal information.',
                'excerpt' => 'Our privacy policy explains how we handle your personal information and protect your privacy.',
            ],
            [
                'title' => 'Terms of Service',
                'slug' => 'terms-of-service',
                'page_type' => 'terms_of_service',
                'meta_title' => 'Terms of Service | OSR',
                'meta_description' => 'Read our terms of service that govern your use of our website and services.',
                'excerpt' => 'These terms govern your use of our website and services.',
            ],
            [
                'title' => 'Cookies Policy',
                'slug' => 'cookies-policy',
                'page_type' => 'cookies_policy',
                'meta_title' => 'Cookies Policy | OSR',
                'meta_description' => 'Learn about how we use cookies to improve your browsing experience.',
                'excerpt' => 'Our cookies policy explains how we use cookies and similar technologies.',
            ],
        ];

        foreach ($legalPages as $pageData) {
            $pageData['content'] = LegalPage::getDefaultContent($pageData['page_type']);
            $pageData['is_published'] = true;
            $pageData['last_updated_at'] = now();

            LegalPage::updateOrCreate(
                ['page_type' => $pageData['page_type']],
                $pageData
            );
        }
    }
}
