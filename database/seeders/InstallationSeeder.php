<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Setting;
use App\Models\HeroSection;
use App\Models\HeroSlider;
use App\Models\FilmCategory;
use App\Models\FilmPortfolio;
use App\Models\NewsCategory;
use App\Models\News;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\TeamValue;
use App\Models\CoreValue;
use App\Models\Service;
use App\Models\DistributionService;
use App\Models\TrustedPartner;
use App\Models\PartnershipBenefit;
use App\Models\Testimonial;
use App\Models\DynamicPage;
use App\Models\ContentBlock;
use App\Models\GeneralSetting;
use App\Models\FooterSettings;
use App\Models\LegalPage;
use App\Models\Portfolio;
use App\Models\MissionVision;
use App\Models\Associate;

class InstallationSeeder extends Seeder
{
    /**
     * Run the database seeds for a complete installation.
     */
    public function run(): void
    {
        $this->command->info('🚀 Starting OSR Digital installation...');
        
        // Clear existing data
        $this->clearExistingData();
        
        // Create core data
        $this->createAdminUser();
        $this->createRolesAndPermissions();
        $this->createSettings();
        $this->createHeroSections();
        $this->createHeroSliders();
        $this->createFilmCategories();
        $this->createFilmPortfolios();
        $this->createNewsCategories();
        $this->createNews();
        $this->createTeams();
        $this->createTeamMembers();
        $this->createTeamValues();
        $this->createCoreValues();
        $this->createServices();
        $this->createDistributionServices();
        $this->createTrustedPartners();
        $this->createPartnershipBenefits();
        $this->createTestimonials();
        $this->createDynamicPages();
        $this->createContentBlocks();
        $this->createLegalPages();
        $this->createPortfolio();
        $this->createMissionVision();
        $this->createAssociates();
        
        $this->command->info('✅ OSR Digital installation completed successfully!');
        $this->command->info('📧 Admin Login: admin@osrdigital.com');
        $this->command->info('🔑 Admin Password: password');
        $this->command->info('🌐 Visit: /admin to access the admin panel');
    }

    private function clearExistingData()
    {
        $this->command->info('🧹 Clearing existing data...');
        
        // Clear all tables in reverse dependency order
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        $tables = [
            'associates', 'mission_visions', 'portfolios', 'legal_pages',
            'content_blocks', 'dynamic_pages', 'testimonials', 'partnership_benefits',
            'trusted_partners', 'distribution_services', 'services', 'core_values',
            'team_values', 'team_members', 'teams', 'news', 'news_categories',
            'film_portfolios', 'film_categories', 'hero_sliders',
            'settings', 'footer_settings', 'general_settings', 'permissions', 'roles',
            'users'
        ];
        
        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    private function createAdminUser()
    {
        $this->command->info('👤 Creating admin user...');
        
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@osrdigital.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
    }

    private function createRolesAndPermissions()
    {
        $this->command->info('🔐 Creating roles and permissions...');
        
        // Create roles
        $adminRole = Role::create(['name' => 'admin', 'display_name' => 'Administrator']);
        $editorRole = Role::create(['name' => 'editor', 'display_name' => 'Editor']);
        $userRole = Role::create(['name' => 'user', 'display_name' => 'User']);
        
        // Create permissions
        $permissions = [
            'manage-users', 'manage-roles', 'manage-settings', 'manage-content',
            'manage-films', 'manage-news', 'manage-team', 'manage-testimonials',
            'manage-hero', 'manage-pages', 'view-admin'
        ];
        
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'display_name' => ucwords(str_replace('-', ' ', $permission))]);
        }
        
        // Assign all permissions to admin
        $adminRole->givePermissionTo(Permission::all());
        
        // Assign admin role to admin user
        User::first()->assignRole('admin');
    }

    private function createSettings()
    {
        $this->command->info('⚙️ Creating settings...');
        
        $settings = [
            // Branding
            ['key' => 'company_name', 'value' => 'OSR Digital', 'type' => 'text', 'group' => 'branding', 'description' => 'Company Name', 'is_public' => true],
            ['key' => 'site_tagline', 'value' => 'Your digital partner', 'type' => 'text', 'group' => 'branding', 'description' => 'Site Tagline', 'is_public' => true],
            ['key' => 'primary_color', 'value' => '#EC681D', 'type' => 'color', 'group' => 'branding', 'description' => 'Primary Brand Color', 'is_public' => true],
            ['key' => 'secondary_color', 'value' => '#64748b', 'type' => 'color', 'group' => 'branding', 'description' => 'Secondary Color', 'is_public' => true],
            
            // Contact
            ['key' => 'contact_email', 'value' => 'info@osrdigital.com', 'type' => 'email', 'group' => 'contact', 'description' => 'Contact Email', 'is_public' => true],
            ['key' => 'contact_phone', 'value' => '+1 (555) 123-4567', 'type' => 'text', 'group' => 'contact', 'description' => 'Contact Phone', 'is_public' => true],
            ['key' => 'contact_address', 'value' => '123 Digital Street, Los Angeles, CA 90210', 'type' => 'textarea', 'group' => 'contact', 'description' => 'Office Address', 'is_public' => true],
            
            // Social Media
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/osrdigital', 'type' => 'url', 'group' => 'social', 'description' => 'Facebook URL', 'is_public' => true],
            ['key' => 'twitter_url', 'value' => 'https://twitter.com/osrdigital', 'type' => 'url', 'group' => 'social', 'description' => 'Twitter URL', 'is_public' => true],
            ['key' => 'linkedin_url', 'value' => 'https://linkedin.com/company/osrdigital', 'type' => 'url', 'group' => 'social', 'description' => 'LinkedIn URL', 'is_public' => true],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/osrdigital', 'type' => 'url', 'group' => 'social', 'description' => 'Instagram URL', 'is_public' => true],
            ['key' => 'youtube_url', 'value' => 'https://youtube.com/channel/osrdigital', 'type' => 'url', 'group' => 'social', 'description' => 'YouTube URL', 'is_public' => true],
            
            // SEO
            ['key' => 'site_title', 'value' => 'OSR Digital - Global Entertainment Distribution', 'type' => 'text', 'group' => 'seo', 'description' => 'Website Title', 'is_public' => true],
            ['key' => 'site_description', 'value' => 'OSR Digital specializes in acquiring exceptional entertainment content and strategically distributing it to worldwide audiences through cutting-edge digital platforms.', 'type' => 'textarea', 'group' => 'seo', 'description' => 'Website Description', 'is_public' => true],
            
            // Hero Section
            ['key' => 'hero_main_title', 'value' => 'Bringing Stories to', 'type' => 'text', 'group' => 'hero', 'description' => 'Hero Main Title', 'is_public' => true],
            ['key' => 'hero_highlighted_title', 'value' => 'Global Screens', 'type' => 'text', 'group' => 'hero', 'description' => 'Hero Highlighted Title', 'is_public' => true],
            ['key' => 'hero_description', 'value' => 'OSR Digital specializes in acquiring exceptional entertainment content and strategically distributing it to worldwide audiences through cutting-edge digital platforms.', 'type' => 'textarea', 'group' => 'hero', 'description' => 'Hero Description', 'is_public' => true],
            ['key' => 'hero_primary_button_text', 'value' => 'Partner With Us', 'type' => 'text', 'group' => 'hero', 'description' => 'Hero Primary Button', 'is_public' => true],
            ['key' => 'hero_secondary_button_text', 'value' => 'Explore Portfolio', 'type' => 'text', 'group' => 'hero', 'description' => 'Hero Secondary Button', 'is_public' => true],
            
            // Stats
            ['key' => 'stats_movies_count', 'value' => '500+', 'type' => 'text', 'group' => 'stats', 'description' => 'Movies Count', 'is_public' => true],
            ['key' => 'stats_songs_count', 'value' => '2,000+', 'type' => 'text', 'group' => 'stats', 'description' => 'Songs Count', 'is_public' => true],
            ['key' => 'stats_films_count', 'value' => '800+', 'type' => 'text', 'group' => 'stats', 'description' => 'Short Films Count', 'is_public' => true],
            ['key' => 'stats_views_count', 'value' => '50M+', 'type' => 'text', 'group' => 'stats', 'description' => 'Total Views Count', 'is_public' => true],
            
            // Footer
            ['key' => 'footer_copyright', 'value' => '© 2025 OSR Digital. All rights reserved.', 'type' => 'text', 'group' => 'footer', 'description' => 'Footer Copyright', 'is_public' => true],
            ['key' => 'footer_description', 'value' => 'We are your trusted digital partner, providing innovative solutions for modern businesses.', 'type' => 'textarea', 'group' => 'footer', 'description' => 'Footer Description', 'is_public' => true],
        ];
        
        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }

    private function createHeroSections()
    {
        $this->command->info('🎬 Creating hero sections...');
        
        $heroSections = [
            [
                'page' => 'home',
                'title' => 'Bringing Stories to Global Screens',
                'subtitle' => 'Digital Media Excellence',
                'content' => 'OSR Digital specializes in acquiring exceptional entertainment content and strategically distributing it to worldwide audiences through cutting-edge digital platforms.',
                'button_text' => 'Partner With Us',
                'button_url' => '/contact',
                'button_text_secondary' => 'Explore Portfolio',
                'button_url_secondary' => '/portfolio',
                'is_active' => true,
            ],
            [
                'page' => 'about',
                'title' => 'About OSR Digital',
                'subtitle' => 'Your Digital Partner',
                'content' => 'We are passionate about helping creators and businesses reach their full potential through innovative digital solutions.',
                'is_active' => true,
            ],
            [
                'page' => 'portfolio',
                'title' => 'Our Portfolio',
                'subtitle' => 'Content Showcase',
                'content' => 'Explore our diverse collection of movies, documentaries, short films, and series that we\'ve successfully distributed to global audiences.',
                'is_active' => true,
            ],
            [
                'page' => 'contact',
                'title' => 'Get In Touch',
                'subtitle' => 'We\'d love to hear from you',
                'content' => 'Ready to start your digital content journey? Contact us today and let\'s discuss how we can help you reach your goals.',
                'is_active' => true,
            ]
        ];
        
        foreach ($heroSections as $hero) {
            HeroSection::create($hero);
        }
    }

    private function createHeroSliders()
    {
        $this->command->info('🎭 Creating hero sliders...');
        
        $sliders = [
            [
                'title' => 'Premium Movie Distribution',
                'subtitle' => 'Movie Distribution',
                'description' => 'We acquire and distribute exceptional films to worldwide audiences through cutting-edge digital platforms and traditional distribution channels.',
                'button_text' => 'Get Started',
                'button_url' => '/contact',
                'button_text_secondary' => 'View Films',
                'button_url_secondary' => '/portfolio',
                'is_active' => true,
            ],
            [
                'title' => 'Global Film Network',
                'subtitle' => 'Worldwide Reach',
                'description' => 'Connect with audiences across continents through our extensive distribution network and strategic partnerships with leading platforms.',
                'button_text' => 'Learn More',
                'button_url' => '/about',
                'button_text_secondary' => 'Our Network',
                'button_url_secondary' => '/services',
                'is_active' => true,
            ],
            [
                'title' => 'Award-Winning Content',
                'subtitle' => 'Quality Films',
                'description' => 'Discover our collection of critically acclaimed and commercially successful films that captivate audiences worldwide.',
                'button_text' => 'View Portfolio',
                'button_url' => '/portfolio',
                'button_text_secondary' => 'Contact Us',
                'button_url_secondary' => '/contact',
                'is_active' => true,
            ]
        ];
        
        foreach ($sliders as $slider) {
            HeroSlider::create($slider);
        }
    }

    private function createFilmCategories()
    {
        $this->command->info('🎬 Creating film categories...');
        
        $categories = [
            ['name' => 'Feature Films', 'slug' => 'feature-films', 'description' => 'Full-length feature films and movies', 'color' => '#3B82F6', 'is_active' => true, 'sort_order' => 1],
            ['name' => 'Documentaries', 'slug' => 'documentaries', 'description' => 'Documentary films and non-fiction content', 'color' => '#10B981', 'is_active' => true, 'sort_order' => 2],
            ['name' => 'Short Films', 'slug' => 'short-films', 'description' => 'Short films and experimental content', 'color' => '#F59E0B', 'is_active' => true, 'sort_order' => 3],
            ['name' => 'Series', 'slug' => 'series', 'description' => 'Television series and web series', 'color' => '#8B5CF6', 'is_active' => true, 'sort_order' => 4],
            ['name' => 'Music Videos', 'slug' => 'music-videos', 'description' => 'Music videos and promotional content', 'color' => '#EF4444', 'is_active' => true, 'sort_order' => 5]
        ];
        
        foreach ($categories as $category) {
            FilmCategory::create($category);
        }
    }

    private function createFilmPortfolios()
    {
        $this->command->info('🎥 Creating film portfolios...');
        
        $films = [
            [
                'title' => 'The Last Horizon',
                'slug' => 'the-last-horizon',
                'description' => 'A gripping sci-fi thriller about humanity\'s final journey to the stars.',
                'genre' => 'Sci-Fi Thriller',
                'year' => '2024',
                'rating' => 8.5,
                'duration' => '2h 15m',
                'category_id' => 1,
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'title' => 'Urban Legends',
                'slug' => 'urban-legends',
                'description' => 'A chilling horror anthology exploring modern urban myths.',
                'genre' => 'Horror',
                'year' => '2024',
                'rating' => 7.8,
                'duration' => '1h 45m',
                'category_id' => 1,
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'title' => 'Rising Stars',
                'slug' => 'rising-stars',
                'description' => 'An inspiring documentary about young artists breaking into the industry.',
                'genre' => 'Documentary',
                'year' => '2023',
                'rating' => 9.2,
                'duration' => '1h 30m',
                'category_id' => 2,
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'title' => 'Digital Dreams',
                'slug' => 'digital-dreams',
                'description' => 'A poignant drama about technology\'s impact on human relationships.',
                'genre' => 'Drama',
                'year' => '2024',
                'rating' => 8.1,
                'duration' => '1h 55m',
                'category_id' => 1,
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 4
            ],
            [
                'title' => 'Behind the Scenes',
                'slug' => 'behind-the-scenes',
                'description' => 'An exclusive look at the making of blockbuster films.',
                'genre' => 'Documentary',
                'year' => '2023',
                'rating' => 8.7,
                'duration' => '2h 10m',
                'category_id' => 2,
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 5
            ],
            [
                'title' => 'Night Shift',
                'slug' => 'night-shift',
                'description' => 'A tense thriller set in a 24-hour convenience store.',
                'genre' => 'Thriller',
                'year' => '2024',
                'rating' => 7.9,
                'duration' => '1h 40m',
                'category_id' => 3,
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 6
            ]
        ];
        
        foreach ($films as $film) {
            FilmPortfolio::create($film);
        }
    }

    private function createNewsCategories()
    {
        $this->command->info('📰 Creating news categories...');
        
        $categories = [
            ['name' => 'Industry News', 'slug' => 'industry-news', 'description' => 'Latest industry updates and trends', 'is_active' => true, 'sort_order' => 1],
            ['name' => 'Company Updates', 'slug' => 'company-updates', 'description' => 'OSR Digital company news and announcements', 'is_active' => true, 'sort_order' => 2],
            ['name' => 'Partnerships', 'slug' => 'partnerships', 'description' => 'New partnerships and collaborations', 'is_active' => true, 'sort_order' => 3],
            ['name' => 'Awards', 'slug' => 'awards', 'description' => 'Awards and recognition', 'is_active' => true, 'sort_order' => 4]
        ];
        
        foreach ($categories as $category) {
            NewsCategory::create($category);
        }
    }

    private function createNews()
    {
        $this->command->info('📄 Creating news articles...');
        
        $news = [
            [
                'title' => 'OSR Digital Expands Global Distribution Network',
                'slug' => 'osr-digital-expands-global-distribution-network',
                'excerpt' => 'We are excited to announce the expansion of our global distribution network to reach audiences in 50+ new countries.',
                'content' => '<p>OSR Digital is proud to announce a significant expansion of our global distribution network. This expansion will allow us to reach audiences in over 50 new countries, bringing our total reach to more than 100 countries worldwide.</p><p>This strategic move enables us to provide even better service to our content creators and partners, ensuring their stories reach the right audiences at the right time.</p>',
                'category_id' => 2,
                'status' => 'published',
                'featured' => true,
                'published_at' => now()->subDays(5)
            ],
            [
                'title' => 'New Partnership with Major Streaming Platform',
                'slug' => 'new-partnership-major-streaming-platform',
                'excerpt' => 'OSR Digital partners with a leading streaming platform to enhance content distribution capabilities.',
                'content' => '<p>We are thrilled to announce our new partnership with one of the world\'s leading streaming platforms. This collaboration will significantly enhance our content distribution capabilities and provide our partners with access to millions of new viewers.</p><p>The partnership includes exclusive content deals, advanced analytics, and enhanced monetization opportunities for our content creators.</p>',
                'category_id' => 3,
                'status' => 'published',
                'featured' => true,
                'published_at' => now()->subDays(10)
            ],
            [
                'title' => 'Digital Content Trends for 2025',
                'slug' => 'digital-content-trends-2025',
                'excerpt' => 'Industry experts share insights on the latest trends shaping digital content distribution in 2025.',
                'content' => '<p>As we look ahead to 2025, several key trends are emerging in the digital content distribution landscape. From AI-powered content optimization to immersive viewing experiences, the industry continues to evolve rapidly.</p><p>Our team of experts has compiled insights from industry leaders to help content creators and distributors stay ahead of the curve.</p>',
                'category_id' => 1,
                'status' => 'published',
                'featured' => false,
                'published_at' => now()->subDays(15)
            ]
        ];
        
        foreach ($news as $article) {
            News::create($article);
        }
    }

    private function createTeams()
    {
        $this->command->info('👥 Creating teams...');
        
        $teams = [
            [
                'name' => 'Leadership Team',
                'description' => 'Our executive leadership team driving OSR Digital\'s strategic vision.',
                'is_active' => true,
            ],
            [
                'name' => 'Content Team',
                'description' => 'Creative professionals responsible for content acquisition and curation.',
                'is_active' => true,
            ],
            [
                'name' => 'Technical Team',
                'description' => 'Technology experts ensuring seamless digital distribution.',
                'is_active' => true,
            ]
        ];
        
        foreach ($teams as $team) {
            Team::create($team);
        }
    }

    private function createTeamMembers()
    {
        $this->command->info('👤 Creating team members...');
        
        $members = [
            [
                'name' => 'Sarah Johnson',
                'position' => 'CEO & Founder',
                'department' => 'Executive',
                'description' => 'Sarah founded OSR Digital with a vision to democratize content distribution. With over 15 years in the entertainment industry, she leads our strategic initiatives.',
                'is_active' => true,
            ],
            [
                'name' => 'Michael Chen',
                'position' => 'CTO',
                'department' => 'Technology',
                'description' => 'Michael oversees our technology infrastructure and digital platform development. He brings 12 years of experience in scalable systems architecture.',
                'is_active' => true,
            ],
            [
                'name' => 'Emily Rodriguez',
                'position' => 'Head of Content',
                'department' => 'Content',
                'description' => 'Emily leads our content acquisition and curation efforts. Her keen eye for quality content has helped us build an impressive portfolio.',
                'is_active' => true,
            ],
            [
                'name' => 'David Kim',
                'position' => 'Lead Developer',
                'department' => 'Technology',
                'description' => 'David leads our development team, ensuring our platforms are robust, scalable, and user-friendly.',
                'is_active' => true,
            ]
        ];
        
        foreach ($members as $member) {
            TeamMember::create($member);
        }
    }

    private function createTeamValues()
    {
        $this->command->info('💎 Creating team values...');
        
        $values = [
            [
                'title' => 'Innovation',
                'description' => 'We constantly push the boundaries of what\'s possible in digital content distribution.',
                'icon' => '🚀',
                'is_active' => true,
            ],
            [
                'title' => 'Quality',
                'description' => 'We maintain the highest standards in everything we do, from content selection to platform performance.',
                'icon' => '⭐',
                'is_active' => true,
            ],
            [
                'title' => 'Partnership',
                'description' => 'We believe in building lasting relationships with creators, partners, and audiences.',
                'icon' => '🤝',
                'is_active' => true,
            ],
            [
                'title' => 'Transparency',
                'description' => 'We operate with complete transparency in all our business dealings and communications.',
                'icon' => '🔍',
                'is_active' => true,
                'sort_order' => 4
            ]
        ];
        
        foreach ($values as $value) {
            TeamValue::create($value);
        }
    }

    private function createCoreValues()
    {
        $this->command->info('🎯 Creating core values...');
        
        $values = [
            [
                'title' => 'Excellence',
                'description' => 'We strive for excellence in every aspect of our work, from content curation to customer service.',
                'icon' => '🏆',
                'is_active' => true,
            ],
            [
                'title' => 'Integrity',
                'description' => 'We conduct business with the highest ethical standards and complete honesty.',
                'icon' => '⚖️',
                'is_active' => true,
            ],
            [
                'title' => 'Innovation',
                'description' => 'We embrace new technologies and creative approaches to solve complex challenges.',
                'icon' => '💡',
                'is_active' => true,
            ],
            [
                'title' => 'Collaboration',
                'description' => 'We believe that the best results come from working together with our partners and team.',
                'icon' => '🤝',
                'is_active' => true,
                'sort_order' => 4
            ]
        ];
        
        foreach ($values as $value) {
            CoreValue::create($value);
        }
    }

    private function createServices()
    {
        $this->command->info('🛠️ Creating services...');
        
        $services = [
            [
                'title' => 'Content Distribution',
                'slug' => 'content-distribution',
                'description' => 'Distribute your content across multiple platforms worldwide with our comprehensive distribution network.',
                'icon' => '🌐',
                'is_active' => true,
            ],
            [
                'title' => 'Digital Marketing',
                'slug' => 'digital-marketing',
                'description' => 'Promote your content effectively with our targeted digital marketing strategies.',
                'icon' => '📈',
                'is_active' => true,
            ],
            [
                'title' => 'Content Optimization',
                'slug' => 'content-optimization',
                'description' => 'Optimize your content for maximum reach and engagement across all platforms.',
                'icon' => '⚡',
                'is_active' => true,
            ],
            [
                'title' => 'Analytics & Reporting',
                'slug' => 'analytics-reporting',
                'description' => 'Get detailed insights into your content performance with our advanced analytics tools.',
                'icon' => '📊',
                'is_active' => true,
                'sort_order' => 4
            ]
        ];
        
        foreach ($services as $service) {
            Service::create($service);
        }
    }

    private function createDistributionServices()
    {
        $this->command->info('📡 Creating distribution services...');
        
        $services = [
            [
                'title' => 'Streaming Platforms',
                'description' => 'Distribute to major streaming platforms including Netflix, Amazon Prime, and Hulu.',
                'icon_type' => 'emoji',
                'icon_data' => '📺',
                'is_active' => true,
            ],
            [
                'title' => 'YouTube Publishing',
                'description' => 'Professional YouTube channel management and monetization services.',
                'icon_type' => 'emoji',
                'icon_data' => '🎥',
                'is_active' => true,
            ],
            [
                'title' => 'Social Media Distribution',
                'description' => 'Cross-platform social media content distribution and management.',
                'icon_type' => 'emoji',
                'icon_data' => '📱',
                'is_active' => true,
            ],
            [
                'title' => 'International Markets',
                'description' => 'Expand your reach to international markets with localized content strategies.',
                'icon_type' => 'emoji',
                'icon_data' => '🌍',
                'is_active' => true,
                'sort_order' => 4
            ]
        ];
        
        foreach ($services as $service) {
            DistributionService::create($service);
        }
    }

    private function createTrustedPartners()
    {
        $this->command->info('🤝 Creating trusted partners...');
        
        $partners = [
            [
                'name' => 'Netflix',
                'description' => 'Leading streaming platform for global content distribution.',
                'logo' => null,
                'website_url' => 'https://netflix.com',
                'is_active' => true,
            ],
            [
                'name' => 'Amazon Prime Video',
                'description' => 'Premium streaming service with global reach.',
                'logo' => null,
                'website_url' => 'https://primevideo.com',
                'is_active' => true,
            ],
            [
                'name' => 'YouTube',
                'description' => 'World\'s largest video sharing platform.',
                'logo' => null,
                'website_url' => 'https://youtube.com',
                'is_active' => true,
            ],
            [
                'name' => 'Hulu',
                'description' => 'Popular streaming service for TV shows and movies.',
                'logo' => null,
                'website_url' => 'https://hulu.com',
                'is_active' => true,
                'sort_order' => 4
            ]
        ];
        
        foreach ($partners as $partner) {
            TrustedPartner::create($partner);
        }
    }

    private function createPartnershipBenefits()
    {
        $this->command->info('💼 Creating partnership benefits...');
        
        $benefits = [
            [
                'title' => 'Global Reach',
                'description' => 'Access to audiences in over 100 countries worldwide.',
                'icon' => '🌍',
                'is_active' => true,
            ],
            [
                'title' => 'Revenue Sharing',
                'description' => 'Competitive revenue sharing rates for content creators.',
                'icon' => '💰',
                'is_active' => true,
            ],
            [
                'title' => 'Marketing Support',
                'description' => 'Comprehensive marketing support to maximize your content\'s reach.',
                'icon' => '📈',
                'is_active' => true,
            ],
            [
                'title' => 'Analytics Dashboard',
                'description' => 'Real-time analytics and performance insights for your content.',
                'icon' => '📊',
                'is_active' => true,
                'sort_order' => 4
            ]
        ];
        
        foreach ($benefits as $benefit) {
            PartnershipBenefit::create($benefit);
        }
    }

    private function createTestimonials()
    {
        $this->command->info('💬 Creating testimonials...');
        
        $testimonials = [
            [
                'name' => 'John Smith',
                'role' => 'Independent Filmmaker',
                'company' => 'Smith Productions',
                'content' => 'OSR Digital transformed our content distribution strategy. Their platform made it easy to reach global audiences we never thought possible.',
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'name' => 'Maria Garcia',
                'role' => 'Content Creator',
                'company' => 'Creative Studios',
                'content' => 'The team at OSR Digital is incredibly professional and supportive. They helped us optimize our content for maximum engagement.',
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'name' => 'David Wilson',
                'role' => 'Studio Executive',
                'company' => 'Paramount Pictures',
                'content' => 'Working with OSR Digital has been a game-changer for our studio. Their distribution network is unmatched in the industry.',
                'is_featured' => true,
                'is_published' => true,
            ]
        ];
        
        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }

    private function createDynamicPages()
    {
        $this->command->info('📄 Creating dynamic pages...');
        
        $pages = [
            [
                'slug' => 'home',
                'title' => 'Home - OSR Digital',
                'meta_title' => 'OSR Digital - Leading Digital Content Distribution',
                'meta_description' => 'Leading digital content distribution company helping creators and businesses reach global audiences across multiple platforms.',
                'template' => 'landing',
                'content_blocks' => [],
                'is_published' => true,
                'is_homepage' => true,
            ],
            [
                'slug' => 'about',
                'title' => 'About Us - OSR Digital',
                'meta_title' => 'About OSR Digital - Your Digital Content Partner',
                'meta_description' => 'Learn about OSR Digital\'s mission to make content distribution accessible to everyone. Discover our story, values, and commitment to creators.',
                'template' => 'about',
                'content_blocks' => [],
                'is_published' => true,
                'is_homepage' => false,
            ],
            [
                'slug' => 'portfolio',
                'title' => 'Portfolio - OSR Digital',
                'meta_title' => 'Our Portfolio - OSR Digital',
                'meta_description' => 'Explore our portfolio of successful digital content distribution projects and client work.',
                'template' => 'portfolio',
                'content_blocks' => [],
                'is_published' => true,
                'is_homepage' => false,
            ],
            [
                'slug' => 'contact',
                'title' => 'Contact Us - OSR Digital',
                'meta_title' => 'Contact OSR Digital - Get In Touch Today',
                'meta_description' => 'Ready to start your digital content journey? Contact OSR Digital today and let\'s discuss how we can help you reach your goals.',
                'template' => 'contact',
                'content_blocks' => [],
                'is_published' => true,
                'is_homepage' => false,
                'sort_order' => 4
            ],
            [
                'slug' => 'team',
                'title' => 'Team - OSR Digital',
                'meta_title' => 'Our Team - OSR Digital',
                'meta_description' => 'Meet the talented team behind OSR Digital\'s success in digital content distribution.',
                'template' => 'team',
                'content_blocks' => [],
                'is_published' => true,
                'is_homepage' => false,
                'sort_order' => 5
            ],
            [
                'slug' => 'partners',
                'title' => 'Partners - OSR Digital',
                'meta_title' => 'Our Partners - OSR Digital',
                'meta_description' => 'Meet our trusted partners who help us deliver exceptional digital content distribution services.',
                'template' => 'partners',
                'content_blocks' => [],
                'is_published' => true,
                'is_homepage' => false,
                'sort_order' => 6
            ]
        ];
        
        foreach ($pages as $page) {
            DynamicPage::create($page);
        }
    }

    private function createContentBlocks()
    {
        $this->command->info('🧱 Creating content blocks...');
        
        $blocks = [
            [
                'type' => 'hero',
                'name' => 'Homepage Hero',
                'data' => [
                    'title' => 'Bringing Stories to Global Screens',
                    'subtitle' => 'Digital Media Excellence',
                    'description' => 'OSR Digital specializes in acquiring exceptional entertainment content and strategically distributing it to worldwide audiences through cutting-edge digital platforms.',
                    'primaryButton' => ['text' => 'Partner With Us', 'url' => '/contact'],
                    'secondaryButton' => ['text' => 'Explore Portfolio', 'url' => '/portfolio'],
                    'height' => 'full',
                    'alignment' => 'center'
                ],
                'category' => 'homepage',
                'is_reusable' => true,
                'is_active' => true,
            ],
            [
                'type' => 'stats',
                'name' => 'Homepage Stats',
                'data' => [
                    'title' => 'Our Impact',
                    'subtitle' => 'Numbers that speak for themselves',
                    'stats' => [
                        ['number' => '500+', 'label' => 'Movies Published'],
                        ['number' => '2,000+', 'label' => 'Songs Released'],
                        ['number' => '800+', 'label' => 'Short Films'],
                        ['number' => '50M+', 'label' => 'Total Views']
                    ],
                    'columns' => 4,
                    'backgroundColor' => 'primary'
                ],
                'category' => 'homepage',
                'is_reusable' => true,
                'is_active' => true,
            ],
            [
                'type' => 'features',
                'name' => 'Homepage Features',
                'data' => [
                    'title' => 'What We Do',
                    'subtitle' => 'Comprehensive digital content solutions',
                    'features' => [
                        [
                            'icon_type' => 'emoji',
                'icon_data' => '🎬',
                            'title' => 'Content Distribution',
                            'description' => 'Distribute your content across multiple platforms worldwide'
                        ],
                        [
                            'icon_type' => 'emoji',
                'icon_data' => '📱',
                            'title' => 'Mobile Optimization',
                            'description' => 'Optimized for all mobile devices and screen sizes'
                        ],
                        [
                            'icon' => '🌍',
                            'title' => 'Global Reach',
                            'description' => 'Reach audiences in over 100 countries worldwide'
                        ]
                    ],
                    'columns' => 3
                ],
                'category' => 'homepage',
                'is_reusable' => true,
                'is_active' => true,
            ],
            [
                'type' => 'cta',
                'name' => 'Homepage CTA',
                'data' => [
                    'title' => 'Ready to Get Started?',
                    'description' => 'Join thousands of creators who trust OSR Digital for their content distribution needs.',
                    'primaryButton' => ['text' => 'Start Your Journey', 'url' => '/contact'],
                    'secondaryButton' => ['text' => 'View Portfolio', 'url' => '/portfolio'],
                    'backgroundColor' => 'accent'
                ],
                'category' => 'homepage',
                'is_reusable' => true,
                'is_active' => true,
                'sort_order' => 4
            ]
        ];
        
        foreach ($blocks as $block) {
            ContentBlock::create($block);
        }
    }

    private function createLegalPages()
    {
        $this->command->info('📋 Creating legal pages...');
        
        $pages = [
            [
                'slug' => 'privacy-policy',
                'title' => 'Privacy Policy',
                'page_type' => 'privacy_policy',
                'content' => '<h1>Privacy Policy</h1><p>This privacy policy explains how OSR Digital collects, uses, and protects your information when you use our services.</p><h2>Information We Collect</h2><p>We collect information you provide directly to us, such as when you create an account, contact us, or use our services.</p><h2>How We Use Your Information</h2><p>We use the information we collect to provide, maintain, and improve our services.</p>',
                'is_published' => true,
            ],
            [
                'slug' => 'terms-of-service',
                'title' => 'Terms of Service',
                'page_type' => 'terms_of_service',
                'content' => '<h1>Terms of Service</h1><p>These terms of service govern your use of OSR Digital\'s website and services.</p><h2>Acceptance of Terms</h2><p>By accessing or using our services, you agree to be bound by these terms.</p><h2>Use of Services</h2><p>You may use our services only for lawful purposes and in accordance with these terms.</p>',
                'is_published' => true,
            ],
            [
                'slug' => 'cookie-policy',
                'title' => 'Cookie Policy',
                'page_type' => 'cookies_policy',
                'content' => '<h1>Cookie Policy</h1><p>This cookie policy explains how OSR Digital uses cookies and similar technologies on our website.</p><h2>What Are Cookies</h2><p>Cookies are small text files that are stored on your device when you visit our website.</p><h2>How We Use Cookies</h2><p>We use cookies to improve your experience on our website and to analyze how our website is used.</p>',
                'is_published' => true,
            ]
        ];
        
        foreach ($pages as $page) {
            LegalPage::create($page);
        }
    }


    private function createPortfolio()
    {
        $this->command->info('💼 Creating portfolio...');
        
        Portfolio::create([
            'title' => 'Our Portfolio',
            'description' => 'Explore our diverse collection of movies, documentaries, short films, and series that we\'ve successfully distributed to global audiences.',
            'is_published' => true
        ]);
    }

    private function createMissionVision()
    {
        $this->command->info('🎯 Creating mission and vision...');
        
        MissionVision::create([
            'mission_title' => 'Our Mission',
            'mission_description' => 'To democratize content distribution and empower creators to reach global audiences through innovative digital solutions.',
            'mission_icon' => '🎯',
            'vision_title' => 'Our Vision',
            'vision_description' => 'To be the world\'s leading platform for digital content distribution, connecting creators with audiences everywhere.',
            'vision_icon' => '👁️',
            'is_active' => true
        ]);
    }

    private function createAssociates()
    {
        $this->command->info('🤝 Creating associates...');
        
        $associates = [
            [
                'name' => 'Creative Studios Alliance',
                'logo' => null,
                'website' => 'https://creativestudiosalliance.com',
                'is_active' => true,
            ],
            [
                'name' => 'Digital Content Network',
                'logo' => null,
                'website' => 'https://digitalcontentnetwork.com',
                'is_active' => true,
            ],
            [
                'name' => 'Global Media Partners',
                'logo' => null,
                'website' => 'https://globalmediapartners.com',
                'is_active' => true,
            ]
        ];
        
        foreach ($associates as $associate) {
            Associate::create($associate);
        }
    }
}
