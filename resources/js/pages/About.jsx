

import { useTheme } from '../contexts/ThemeContext';
import { useState, useEffect } from 'react';
import PageHeader from '../components/PageHeader';

function About() {
    const { isDark } = useTheme();
    const [pageData, setPageData] = useState(null);
    const [loading, setLoading] = useState(true);
    const [stats, setStats] = useState({
        contentPieces: 0,
        globalReach: 0,
        partnerships: 0,
        yearsExperience: 0
    });
    const [settings, setSettings] = useState({});

    useEffect(() => {
        // Fetch page data and settings
        const fetchData = async () => {
            try {
                const [pageResponse, settingsResponse] = await Promise.all([
                    fetch('/api/pages/about'),
                    fetch('/api/settings/flat')
                ]);

                if (pageResponse.ok) {
                    const pageResult = await pageResponse.json();
                    setPageData(pageResult);
                }

                if (settingsResponse.ok) {
                    const settingsResult = await settingsResponse.json();
                    setSettings(settingsResult);
                }

                setLoading(false);
            } catch (error) {
                console.error('Error fetching data:', error);
                setLoading(false);
            }
        };

        fetchData();
    }, []);

    useEffect(() => {
        if (!loading) {
            // Default content if no page data found
            const defaultContent = {
                title: 'About OSR Digital',
                excerpt: 'Leading the future of digital content distribution, connecting exceptional entertainment with global audiences through strategic YouTube publishing and innovative media solutions.',
                content: '',
                featured_image: null,
                meta_title: 'About OSR Digital',
                meta_description: 'Learn about OSR Digital, a leading digital content distribution company connecting exceptional entertainment with global audiences.'
            };

            const content = pageData || defaultContent;

            // Update document title and meta tags
            if (content && content.meta_title) {
                document.title = content.meta_title;
            } else if (content && content.title) {
                document.title = `${content.title} - OSR Digital`;
            }

            if (content && content.meta_description) {
                let metaDescription = document.querySelector('meta[name="description"]');
                if (metaDescription) {
                    metaDescription.setAttribute('content', content.meta_description);
                } else {
                    metaDescription = document.createElement('meta');
                    metaDescription.name = 'description';
                    metaDescription.content = content.meta_description;
                    document.getElementsByTagName('head')[0].appendChild(metaDescription);
                }
            }

            // Animate counter numbers using page template data
            const targets = {
                contentPieces: parseInt(pageData?.about_stat_1_value) || parseInt(settings.about_content_pieces) || 1200,
                globalReach: parseInt(pageData?.about_stat_2_value) || parseInt(settings.about_global_reach) || 50,
                partnerships: parseInt(pageData?.about_stat_3_value) || parseInt(settings.about_partnerships) || 300,
                yearsExperience: parseInt(pageData?.about_stat_4_value) || parseInt(settings.about_years_experience) || 8
            };

            const animateCounter = (key, target) => {
                let current = 0;
                const increment = target / 100;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }
                    setStats(prev => ({ ...prev, [key]: Math.floor(current) }));
                }, 20);
            };

            Object.entries(targets).forEach(([key, target]) => {
                setTimeout(() => animateCounter(key, target), 500);
            });
        }
    }, [loading, settings, pageData]);

    if (loading) {
        return (
            <div className={`min-h-screen ${isDark ? 'bg-gray-900' : 'bg-white'} flex items-center justify-center`}>
                <div className="text-center">
                    <div className="animate-spin rounded-full h-32 w-32 border-b-2 mx-auto mb-4" style={{ borderColor: '#ff6b35' }}></div>
                    <p className={`text-xl ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>Loading...</p>
                </div>
            </div>
        );
    }

    // Default content if no page data found
    const defaultContent = {
        title: 'About OSR Digital',
        excerpt: 'Leading the future of digital content distribution, connecting exceptional entertainment with global audiences through strategic YouTube publishing and innovative media solutions.',
        content: '',
        featured_image: null
    };

    const content = pageData || defaultContent;

    return (
        <div className={`min-h-screen ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
            {/* Hero Section */}
            <section className={`relative pt-24 pb-20 overflow-hidden ${isDark ? 'bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900' : 'bg-gradient-to-br from-gray-50 via-white to-gray-100'}`}>
                <div className="absolute inset-0 bg-gradient-to-r from-orange-500/10 to-red-500/10"></div>
                <div className="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <h1 className={`text-5xl lg:text-6xl font-bold mb-6`}>
                        <span className={isDark ? 'text-white' : 'text-gray-900'}>
                            {content.title.split(' ').slice(0, -2).join(' ')}
                        </span>{' '}
                        <span style={{ color: '#ff6b35' }}>
                            {content.title.split(' ').slice(-2).join(' ')}
                        </span>
                    </h1>
                    <p className={`text-xl ${isDark ? 'text-gray-300' : 'text-gray-600'} mb-8 leading-relaxed max-w-3xl mx-auto`}>
                        {content.excerpt || settings.about_hero_description || 'Leading the future of digital content distribution, connecting exceptional entertainment with global audiences through strategic YouTube publishing and innovative media solutions.'}
                    </p>
                    <div className="flex flex-wrap gap-4 justify-center">
                        <button
                            className="px-8 py-3 rounded-lg font-semibold text-white transition-all duration-300 hover:scale-105 hover:shadow-lg"
                            style={{ backgroundColor: '#ff6b35' }}
                        >
                            {pageData?.about_primary_button_text || settings.about_primary_button_text || 'Our Story'}
                        </button>
                        <button className={`px-8 py-3 rounded-lg font-semibold border-2 transition-all duration-300 hover:scale-105 ${isDark ? 'border-gray-600 text-gray-300 hover:bg-gray-800' : 'border-gray-300 text-gray-700 hover:bg-gray-50'}`}>
                            {pageData?.about_secondary_button_text || settings.about_secondary_button_text || 'Watch Video'}
                        </button>
                    </div>
                </div>
            </section>

            {/* Stats Section */}
            <section className={`py-16 ${isDark ? 'bg-gray-800' : 'bg-gray-50'}`}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="grid grid-cols-2 lg:grid-cols-4 gap-8">
                        <div className="text-center">
                            <div className="text-4xl lg:text-5xl font-bold mb-2" style={{ color: '#ff6b35' }}>
                                {stats.contentPieces.toLocaleString()}+
                            </div>
                            <p className={`text-lg font-medium ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                                {pageData?.about_stat_1_label || settings.about_stat_1_label || 'Content Pieces'}
                            </p>
                        </div>
                        <div className="text-center">
                            <div className="text-4xl lg:text-5xl font-bold mb-2" style={{ color: '#ff6b35' }}>
                                {stats.globalReach}M+
                            </div>
                            <p className={`text-lg font-medium ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                                {pageData?.about_stat_2_label || settings.about_stat_2_label || 'Global Reach'}
                            </p>
                        </div>
                        <div className="text-center">
                            <div className="text-4xl lg:text-5xl font-bold mb-2" style={{ color: '#ff6b35' }}>
                                {stats.partnerships}+
                            </div>
                            <p className={`text-lg font-medium ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                                {pageData?.about_stat_3_label || settings.about_stat_3_label || 'Partnerships'}
                            </p>
                        </div>
                        <div className="text-center">
                            <div className="text-4xl lg:text-5xl font-bold mb-2" style={{ color: '#ff6b35' }}>
                                {stats.yearsExperience}+
                            </div>
                            <p className={`text-lg font-medium ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                                {pageData?.about_stat_4_label || settings.about_stat_4_label || 'Years Experience'}
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            {/* Dynamic Content Section */}
            {content.content && (
                <section className={`py-20 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                    <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div
                            className={`prose prose-lg max-w-none ${isDark ? 'prose-invert' : ''}`}
                            dangerouslySetInnerHTML={{ __html: content.content }}
                            style={{
                                '--tw-prose-headings': isDark ? '#ffffff' : '#111827',
                                '--tw-prose-body': isDark ? '#d1d5db' : '#374151',
                                '--tw-prose-links': '#ff6b35',
                                '--tw-prose-bold': isDark ? '#ffffff' : '#111827',
                            }}
                        />
                    </div>
                </section>
            )}

            {/* Mission & Vision Section */}
            <section className={`py-20 ${isDark ? 'bg-gray-800' : 'bg-gray-50'}`}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="grid lg:grid-cols-2 gap-16">
                        <div className="space-y-8">
                            <div>
                                <div className="flex items-center mb-6">
                                    <div className="w-12 h-12 rounded-lg flex items-center justify-center mr-4" style={{ backgroundColor: '#ff6b35' }}>
                                        <svg className="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    </div>
                                    <h2 className={`text-4xl font-bold ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                        {pageData?.about_mission_title || settings.about_mission_title || 'Our Mission'}
                                    </h2>
                                </div>
                                <p className={`text-lg ${isDark ? 'text-gray-300' : 'text-gray-600'} leading-relaxed`}>
                                    {pageData?.about_mission || settings.about_mission || 'To bridge the gap between content creators and global audiences by acquiring rights to exceptional movies, songs, and short films, and distributing them through strategic YouTube publishing. We believe in the power of storytelling to connect cultures and inspire communities worldwide.'}
                                </p>
                            </div>

                            <div>
                                <div className="flex items-center mb-6">
                                    <div className="w-12 h-12 rounded-lg flex items-center justify-center mr-4" style={{ backgroundColor: '#ff6b35' }}>
                                        <svg className="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.94-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
                                        </svg>
                                    </div>
                                    <h2 className={`text-4xl font-bold ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                        {pageData?.about_vision_title || settings.about_vision_title || 'Our Vision'}
                                    </h2>
                                </div>
                                <p className={`text-lg ${isDark ? 'text-gray-300' : 'text-gray-600'} leading-relaxed`}>
                                    {pageData?.about_vision || settings.about_vision || 'To become the premier digital media company that brings diverse, high-quality entertainment content to screens worldwide, fostering cultural exchange and creative appreciation. We envision a world where great content knows no boundaries.'}
                                </p>
                            </div>
                        </div>

                        <div className="relative">
                            <div className="aspect-video rounded-2xl overflow-hidden bg-gradient-to-br from-orange-400 to-red-500 p-1">
                                <div
                                    className={`w-full h-full rounded-2xl ${isDark ? 'bg-gray-800' : 'bg-gray-100'} flex items-center justify-center ${pageData?.about_youtube_link ? 'cursor-pointer hover:scale-105 transition-transform duration-300' : ''}`}
                                    onClick={() => {
                                        if (pageData?.about_youtube_link) {
                                            window.open(pageData.about_youtube_link, '_blank');
                                        }
                                    }}
                                >
                                    <div className="text-center p-8">
                                        <svg className="w-16 h-16 mx-auto mb-4 text-orange-500" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"/>
                                        </svg>
                                        <p className={`text-lg font-semibold ${isDark ? 'text-gray-300' : 'text-gray-700'}`}>
                                            Watch Our Story
                                        </p>
                                        <p className={`text-sm ${isDark ? 'text-gray-400' : 'text-gray-500'} mt-2`}>
                                            {pageData?.about_youtube_link ? 'Click to watch on YouTube' : 'Discover how we\'re transforming digital content distribution'}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* Services Section */}
            <section className={`py-20 ${isDark ? 'bg-gray-800' : 'bg-gray-50'}`}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center mb-16">
                        <h2 className={`text-4xl lg:text-5xl font-bold mb-6`}>
                            <span className={isDark ? 'text-white' : 'text-gray-900'}>
                                {(pageData?.about_what_we_do_title || settings.about_what_we_do_title || 'What We Do').split(' ').slice(0, -1).join(' ')}
                            </span>{' '}
                            <span style={{ color: '#ff6b35' }}>
                                {(pageData?.about_what_we_do_title || settings.about_what_we_do_title || 'What We Do').split(' ').slice(-1)}
                            </span>
                        </h2>
                        <p className={`text-xl ${isDark ? 'text-gray-300' : 'text-gray-600'} max-w-3xl mx-auto`}>
                            {pageData?.about_what_we_do_description || settings.about_what_we_do_description || 'We provide comprehensive digital content solutions that connect creators with global audiences'}
                        </p>
                    </div>

                    <div className={`grid gap-8 ${pageData?.about_services?.length ? `lg:grid-cols-${Math.min(pageData.about_services.length, 4)}` : 'lg:grid-cols-3'}`}>
                        {pageData?.about_services?.length > 0 ?
                            pageData.about_services.map((service, index) => {
                                const icons = [
                                    "M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z",
                                    "M13 7h-2v4H7v2h4v4h2v-4h4v-2h-4V7zm-1-5C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z",
                                    "M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.94-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z",
                                    "M9 11H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm2-7h-1V2h-2v2H8V2H6v2H5c-1.1 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11z",
                                    "M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z",
                                    "M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm3.5 6L12 10.5 8.5 8 12 5.5 15.5 8zM12 19c-3.87 0-7-3.13-7-7s3.13-7 7-7 7 3.13 7 7-3.13 7-7 7z"
                                ];

                                return (
                                    <div key={index} className={`${isDark ? 'bg-gray-900' : 'bg-white'} p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2`}>
                                        <div className="w-16 h-16 rounded-xl flex items-center justify-center mb-6" style={{ backgroundColor: '#ff6b35' }}>
                                            <svg className="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                <path d={icons[index % icons.length]} />
                                            </svg>
                                        </div>
                                        <h3 className={`text-2xl font-bold ${isDark ? 'text-white' : 'text-gray-900'} mb-4`}>
                                            {service.title}
                                        </h3>
                                        <p className={`${isDark ? 'text-gray-300' : 'text-gray-600'} leading-relaxed`}>
                                            {service.description}
                                        </p>
                                    </div>
                                );
                            })
                        : (
                            // Default services if no repeater data
                            <>
                                <div className={`${isDark ? 'bg-gray-900' : 'bg-white'} p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2`}>
                                    <div className="w-16 h-16 rounded-xl flex items-center justify-center mb-6" style={{ backgroundColor: '#ff6b35' }}>
                                        <svg className="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                                        </svg>
                                    </div>
                                    <h3 className={`text-2xl font-bold ${isDark ? 'text-white' : 'text-gray-900'} mb-4`}>
                                        Content Acquisition
                                    </h3>
                                    <p className={`${isDark ? 'text-gray-300' : 'text-gray-600'} leading-relaxed`}>
                                        We identify and acquire rights to exceptional movies, music, and short films from creators worldwide, building a diverse portfolio of premium content.
                                    </p>
                                </div>

                                <div className={`${isDark ? 'bg-gray-900' : 'bg-white'} p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2`}>
                                    <div className="w-16 h-16 rounded-xl flex items-center justify-center mb-6" style={{ backgroundColor: '#ff6b35' }}>
                                        <svg className="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M13 7h-2v4H7v2h4v4h2v-4h4v-2h-4V7zm-1-5C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                                        </svg>
                                    </div>
                                    <h3 className={`text-2xl font-bold ${isDark ? 'text-white' : 'text-gray-900'} mb-4`}>
                                        Strategic Distribution
                                    </h3>
                                    <p className={`${isDark ? 'text-gray-300' : 'text-gray-600'} leading-relaxed`}>
                                        Our expert team develops and executes strategic YouTube publishing campaigns to maximize reach, engagement, and revenue potential for every piece of content.
                                    </p>
                                </div>

                                <div className={`${isDark ? 'bg-gray-900' : 'bg-white'} p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2`}>
                                    <div className="w-16 h-16 rounded-xl flex items-center justify-center mb-6" style={{ backgroundColor: '#ff6b35' }}>
                                        <svg className="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.94-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
                                        </svg>
                                    </div>
                                    <h3 className={`text-2xl font-bold ${isDark ? 'text-white' : 'text-gray-900'} mb-4`}>
                                        Global Reach
                                    </h3>
                                    <p className={`${isDark ? 'text-gray-300' : 'text-gray-600'} leading-relaxed`}>
                                        We connect content with audiences across different cultures and regions, creating opportunities for cross-cultural appreciation and global success.
                                    </p>
                                </div>
                            </>
                        )}
                    </div>
                </div>
            </section>

            {/* CTA Section */}
            <section className={`py-20 ${isDark ? 'bg-gradient-to-r from-gray-900 to-gray-800' : 'bg-gradient-to-r from-gray-900 to-gray-800'}`}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <h2 className="text-4xl lg:text-5xl font-bold text-white mb-6">
                        {settings.about_cta_title || 'Ready to Work With Us?'}
                    </h2>
                    <p className="text-xl text-gray-300 mb-8 max-w-3xl mx-auto">
                        {settings.about_cta_description || 'Join hundreds of content creators who trust OSR Digital to bring their work to global audiences. Let\'s create something amazing together.'}
                    </p>
                    <div className="flex flex-col sm:flex-row gap-4 justify-center">
                        <button
                            className="px-8 py-4 rounded-lg font-semibold text-white transition-all duration-300 hover:scale-105 hover:shadow-lg text-lg"
                            style={{ backgroundColor: '#ff6b35' }}
                        >
                            {settings.about_cta_primary_button_text || 'Start Partnership'}
                        </button>
                        <button className="px-8 py-4 rounded-lg font-semibold border-2 border-gray-300 text-gray-300 hover:bg-gray-800 transition-all duration-300 hover:scale-105 text-lg">
                            {settings.about_cta_secondary_button_text || 'View Portfolio'}
                        </button>
                    </div>
                </div>
            </section>
        </div>
    );
}

export default About;
