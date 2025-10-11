<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get category IDs
        $companyCategory = NewsCategory::where('slug', 'company-news')->first();
        $partnershipCategory = NewsCategory::where('slug', 'partnerships')->first();
        $industryCategory = NewsCategory::where('slug', 'industry-insights')->first();
        $technologyCategory = NewsCategory::where('slug', 'technology')->first();
        $awardsCategory = NewsCategory::where('slug', 'awards-recognition')->first();

        $newsArticles = [
            [
                'title' => 'OSR Digital Media Expands Global Distribution Network',
                'slug' => 'osr-digital-media-expands-global-distribution-network',
                'excerpt' => 'We are excited to announce the expansion of our YouTube distribution network to over 100 countries, bringing diverse content to audiences worldwide and opening new opportunities for creators.',
                'content' => '<p>OSR Digital Media is proud to announce a significant milestone in our company\'s growth: the expansion of our global distribution network to over 100 countries worldwide. This expansion represents our commitment to bringing diverse, high-quality content to audiences across the globe while providing creators with unprecedented reach and revenue opportunities.</p>
<h3>What This Means for Creators</h3>
<p>This expansion opens doors to new markets and audiences that were previously difficult to access. Our creators can now reach viewers in emerging markets across Asia, Africa, and Latin America, significantly increasing their potential audience and revenue streams.</p>
<h3>Enhanced Revenue Opportunities</h3>
<p>With access to 100+ countries, our partners can expect to see increases in their monetization potential. Different regions offer varying CPM rates and audience behaviors, allowing for more diversified income streams and reduced dependency on single markets.</p>
<h3>Technical Infrastructure</h3>
<p>Our expansion is supported by robust technical infrastructure including localized content delivery networks, multi-language support systems, and region-specific optimization algorithms to ensure optimal performance across all markets.</p>
<p>We look forward to continuing our mission of connecting exceptional content with global audiences while maintaining our commitment to creator success and transparent partnerships.</p>',
                'featured_image' => 'https://images.pexels.com/photos/3183150/pexels-photo-3183150.jpeg?auto=compress&cs=tinysrgb&w=1200',
                'published_at' => '2024-01-15 10:00:00',
                'author_name' => 'OSR Digital Team',
                'tags' => ['expansion', 'global', 'distribution', 'creators'],
                'status' => 'published',
                'featured' => true,
                'category_id' => $companyCategory->id,
            ],
            [
                'title' => 'New Partnership with Emerging Creators Program',
                'slug' => 'new-partnership-with-emerging-creators-program',
                'excerpt' => 'Announcing our collaboration with the Emerging Creators Program to support new talent in the digital content space with mentorship and resources.',
                'content' => '<p>OSR Digital Media is thrilled to announce our strategic partnership with the Emerging Creators Program, a groundbreaking initiative designed to nurture and support the next generation of digital content creators.</p>
<h3>Program Benefits</h3>
<p>The Emerging Creators Program provides comprehensive support including mentorship from industry veterans, access to professional-grade equipment, and guaranteed distribution opportunities across our network.</p>
<h3>Selection Process</h3>
<p>We are looking for passionate creators who demonstrate unique storytelling abilities and a commitment to producing high-quality content. Applications are reviewed quarterly by our panel of industry experts.</p>
<h3>Success Stories</h3>
<p>Previous participants in similar programs have gone on to achieve millions of views and secure major brand partnerships, demonstrating the power of proper guidance and support in the creator economy.</p>
<p>Applications for the next cohort open in March 2024. Visit our creators portal for more information and application details.</p>',
                'featured_image' => 'https://images.pexels.com/photos/3184291/pexels-photo-3184291.jpeg?auto=compress&cs=tinysrgb&w=1200',
                'published_at' => '2024-02-20 14:30:00',
                'author_name' => 'Sarah Martinez',
                'tags' => ['partnership', 'creators', 'mentorship', 'program'],
                'status' => 'published',
                'featured' => false,
                'category_id' => $partnershipCategory->id,
            ],
            [
                'title' => 'Industry Report: The Future of Digital Media in 2024',
                'slug' => 'industry-report-future-of-digital-media-2024',
                'excerpt' => 'Our comprehensive analysis of digital media trends reveals key insights into consumer behavior, emerging technologies, and market opportunities for content creators.',
                'content' => '<p>Our annual industry report provides in-depth analysis of the digital media landscape, revealing crucial trends that will shape the industry in 2024 and beyond.</p>
<h3>Key Findings</h3>
<p>Short-form content continues to dominate engagement metrics, with videos under 60 seconds showing 40% higher completion rates. However, long-form educational content is experiencing a resurgence, particularly in niche markets.</p>
<h3>Emerging Technologies</h3>
<p>AI-powered content creation tools are becoming increasingly sophisticated, enabling creators to produce higher quality content more efficiently. Virtual reality and augmented reality content is gaining traction in educational and entertainment sectors.</p>
<h3>Market Opportunities</h3>
<p>Untapped markets in emerging economies present significant growth opportunities. Regional content that addresses local interests and languages shows exceptional performance metrics.</p>
<p>Download the complete 45-page report from our resources section to access detailed statistics, market projections, and actionable insights for content creators and brands.</p>',
                'featured_image' => 'https://images.pexels.com/photos/590022/pexels-photo-590022.jpeg?auto=compress&cs=tinysrgb&w=1200',
                'published_at' => '2024-03-10 09:15:00',
                'author_name' => 'Dr. Michael Chen',
                'tags' => ['industry', 'report', 'trends', 'digital media', '2024'],
                'status' => 'published',
                'featured' => false,
                'category_id' => $industryCategory->id,
            ],
            [
                'title' => 'OSR Digital Media Achieves Carbon Neutral Operations',
                'slug' => 'osr-digital-media-achieves-carbon-neutral-operations',
                'excerpt' => 'We are proud to announce that OSR Digital Media has achieved carbon neutral operations through renewable energy initiatives and carbon offset programs.',
                'content' => '<p>OSR Digital Media is proud to announce a major environmental milestone: achieving carbon neutral operations across all our facilities and digital infrastructure.</p>
<h3>Renewable Energy Initiative</h3>
<p>Our data centers now run entirely on renewable energy sources, including solar and wind power. This transition has reduced our carbon footprint by 78% compared to traditional energy sources.</p>
<h3>Carbon Offset Programs</h3>
<p>For remaining emissions, we have partnered with verified carbon offset programs focused on reforestation and renewable energy projects in developing countries.</p>
<h3>Sustainable Practices</h3>
<p>Beyond energy, we have implemented comprehensive recycling programs, reduced paper usage by 90% through digital workflows, and encourage remote work to minimize commuting emissions.</p>
<h3>Industry Leadership</h3>
<p>As one of the first media distribution companies to achieve carbon neutrality, we hope to inspire industry-wide adoption of sustainable practices.</p>
<p>Our commitment to environmental responsibility extends to working exclusively with partners who share our values of sustainability and social responsibility.</p>',
                'featured_image' => 'https://images.pexels.com/photos/9800029/pexels-photo-9800029.jpeg?auto=compress&cs=tinysrgb&w=1200',
                'published_at' => '2024-04-22 11:00:00',
                'author_name' => 'Environmental Team',
                'tags' => ['sustainability', 'carbon neutral', 'environment', 'renewable energy'],
                'status' => 'published',
                'featured' => false,
                'category_id' => $companyCategory->id,
            ],
            [
                'title' => 'Upcoming Industry Conference: Digital Media Summit 2024',
                'slug' => 'upcoming-industry-conference-digital-media-summit-2024',
                'excerpt' => 'Join us at the Digital Media Summit 2024 where industry leaders will discuss the future of content creation, distribution strategies, and emerging technologies.',
                'content' => '<p>OSR Digital Media is excited to participate in the Digital Media Summit 2024, taking place in Los Angeles from June 15-17. This premier industry event brings together creators, distributors, and technology innovators.</p>
<h3>Conference Highlights</h3>
<p>The summit features keynote presentations from industry pioneers, hands-on workshops covering the latest production techniques, and networking sessions with potential collaborators and partners.</p>
<h3>OSR Digital Presence</h3>
<p>Our team will be presenting on "The Future of Global Content Distribution" and hosting a workshop on "Maximizing Creator Revenue Through Strategic Partnerships."</p>
<h3>Special Announcements</h3>
<p>We will be unveiling several exciting new initiatives, including our Creator Innovation Fund and expanded international distribution partnerships.</p>
<h3>Registration Information</h3>
<p>Early bird registration is available until May 1st. OSR Digital partners receive a 25% discount on conference passes. Contact our events team for registration codes.</p>
<p>We look forward to connecting with fellow industry professionals and exploring new opportunities for collaboration and growth.</p>',
                'featured_image' => 'https://images.pexels.com/photos/2774556/pexels-photo-2774556.jpeg?auto=compress&cs=tinysrgb&w=1200',
                'published_at' => '2024-03-25 16:45:00',
                'author_name' => 'Events Team',
                'tags' => ['conference', 'summit', 'industry', 'networking', 'events'],
                'status' => 'published',
                'featured' => false,
                'category_id' => $industryCategory->id,
            ],
        ];

        foreach ($newsArticles as $article) {
            News::updateOrCreate(
                ['slug' => $article['slug']], // Find by slug
                $article // Update or create with these values
            );
        }
    }
}
