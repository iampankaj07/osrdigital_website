<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        Page::create([
            'title' => 'About OSR Digital Media',
            'slug' => 'about',
            'content' => '<h2>About OSR Digital Media</h2>
            <p>OSR Digital Media is a leading content distribution company specializing in YouTube network management and digital media distribution. We help creators and content owners maximize their reach and revenue through strategic partnerships and advanced optimization techniques.</p>

            <h3>Our Mission</h3>
            <p>To empower content creators and media companies by providing comprehensive distribution solutions that maximize audience reach and revenue potential across global digital platforms.</p>

            <h3>Our Vision</h3>
            <p>To become the premier digital content distribution network, connecting exceptional content with worldwide audiences while maintaining the highest standards of creator partnership and revenue optimization.</p>

            <h3>Core Values</h3>
            <ul>
                <li><strong>Creator First:</strong> We prioritize the success and satisfaction of our content partners</li>
                <li><strong>Transparency:</strong> Clear reporting and honest communication in all partnerships</li>
                <li><strong>Innovation:</strong> Continuous improvement in distribution technology and strategies</li>
                <li><strong>Global Reach:</strong> Expanding content accessibility to audiences worldwide</li>
                <li><strong>Quality Content:</strong> Supporting diverse, high-quality digital media</li>
            </ul>',
            'meta_description' => 'Learn about OSR Digital Media, a leading content distribution company specializing in YouTube network management and digital media distribution.',
            'is_published' => true,
            'featured_image' => 'https://images.pexels.com/photos/3153204/pexels-photo-3153204.jpeg?auto=compress&cs=tinysrgb&w=1200',
        ]);

        Page::create([
            'title' => 'Our Business Model',
            'slug' => 'business',
            'content' => '<h2>How We Help Content Creators Succeed</h2>
            <p>Our business model is built around empowering content creators and media companies through comprehensive distribution and optimization services.</p>

            <h3>Revenue Sharing Partnership</h3>
            <p>We operate on a transparent revenue-sharing model where creators retain the majority of their earnings while we provide the infrastructure, expertise, and support needed for global distribution success.</p>

            <h3>Services We Provide</h3>
            <ul>
                <li>YouTube Network Management</li>
                <li>Global Content Distribution</li>
                <li>Revenue Optimization</li>
                <li>Analytics and Reporting</li>
                <li>Marketing and Promotion</li>
                <li>Technical Support</li>
            </ul>

            <h3>Our Process</h3>
            <ol>
                <li><strong>Content Review:</strong> We evaluate submitted content for quality and market potential</li>
                <li><strong>Partnership Agreement:</strong> Transparent terms that protect creator rights</li>
                <li><strong>Distribution Setup:</strong> Technical integration and channel optimization</li>
                <li><strong>Launch & Promotion:</strong> Strategic release and marketing campaigns</li>
                <li><strong>Ongoing Support:</strong> Continuous optimization and performance monitoring</li>
            </ol>',
            'meta_description' => 'Discover OSR Digital Media\'s business model and how we help content creators succeed through transparent partnerships and comprehensive support.',
            'is_published' => true,
            'featured_image' => 'https://images.pexels.com/photos/3184360/pexels-photo-3184360.jpeg?auto=compress&cs=tinysrgb&w=1200',
        ]);

        Page::create([
            'title' => 'Privacy Policy',
            'slug' => 'privacy',
            'content' => '<h2>Privacy Policy</h2>
            <p>Last updated: ' . now()->format('F j, Y') . '</p>

            <h3>Information We Collect</h3>
            <p>We collect information you provide directly to us, such as when you create an account, submit content, or contact us for support.</p>

            <h3>How We Use Your Information</h3>
            <p>We use the information we collect to provide, maintain, and improve our services, process transactions, and communicate with you.</p>

            <h3>Information Sharing</h3>
            <p>We do not sell, trade, or otherwise transfer your personal information to third parties without your consent, except as described in this policy.</p>

            <h3>Data Security</h3>
            <p>We implement appropriate security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.</p>

            <h3>Contact Us</h3>
            <p>If you have any questions about this Privacy Policy, please contact us at privacy@osrdigitalmedia.com</p>',
            'meta_description' => 'OSR Digital Media Privacy Policy - Learn how we collect, use, and protect your personal information.',
            'is_published' => true,
        ]);

        Page::create([
            'title' => 'Terms of Service',
            'slug' => 'terms',
            'content' => '<h2>Terms of Service</h2>
            <p>Last updated: ' . now()->format('F j, Y') . '</p>

            <h3>Acceptance of Terms</h3>
            <p>By accessing and using OSR Digital Media services, you accept and agree to be bound by the terms and provision of this agreement.</p>

            <h3>Content Guidelines</h3>
            <p>All content submitted must comply with our content guidelines and applicable laws. We reserve the right to remove content that violates these terms.</p>

            <h3>Intellectual Property</h3>
            <p>You retain ownership of your content. By submitting content, you grant us a license to distribute and promote your content through our network.</p>

            <h3>Revenue Sharing</h3>
            <p>Revenue sharing terms are outlined in individual partnership agreements and may vary based on content type and distribution channels.</p>

            <h3>Termination</h3>
            <p>Either party may terminate the agreement with appropriate notice as specified in individual partnership contracts.</p>',
            'meta_description' => 'OSR Digital Media Terms of Service - Review our terms and conditions for using our content distribution services.',
            'is_published' => true,
        ]);
    }
}
