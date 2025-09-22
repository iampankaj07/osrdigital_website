import { useState, useEffect } from 'react';
import { useTheme } from '../contexts/ThemeContext';
import { usePartnersSettings } from '../hooks/useSettings';

function Partners() {
    const { isDark } = useTheme();
    const { getSetting, loading: settingsLoading } = usePartnersSettings();
    const [activeCategory, setActiveCategory] = useState(0);

    // Parse Partnership Categories from repeater field
    const getPartnershipCategories = () => {
        try {
            const categoriesData = getSetting('partnership_categories_items', '[]');
            const categories = typeof categoriesData === 'string' ? JSON.parse(categoriesData) : categoriesData;

            // Map to the expected structure and add default icons if needed
            return categories.map((category, index) => ({
                title: category.title || 'Category',
                description: category.description || 'Description not available',
                icon: category.icon || ['film', 'users', 'globe', 'tv'][index] || 'star',
                count: category.count_display || '0+',
                image: category.image || null
            }));
        } catch (error) {
            console.error('Error parsing partnership categories:', error);
            // Fallback to default data
            return [
                { title: 'Studios', description: 'Creative powerhouses that bring stories to life through exceptional production quality.', icon: 'film', count: '25+', image: null },
                { title: 'Creators', description: 'Visionary artists and content creators who shape the future of entertainment.', icon: 'users', count: '150+', image: null },
                { title: 'Distributors', description: 'Strategic partners ensuring content reaches audiences across multiple platforms.', icon: 'globe', count: '40+', image: null },
                { title: 'Platforms', description: 'Digital and traditional platforms that amplify our content worldwide.', icon: 'tv', count: '20+', image: null }
            ];
        }
    };

    const partnershipCategories = getPartnershipCategories();

    // Calculate total partners count
    const getTotalPartnersCount = () => {
        return partnershipCategories.reduce((total, category) => {
            const count = parseInt(category.count.replace(/\D/g, '')) || 0;
            return total + count;
        }, 0);
    };

    if (settingsLoading) {
        return (
            <div className={`min-h-screen ${isDark ? 'bg-gray-900' : 'bg-gray-50'} pt-20`}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                    <div className="text-center mb-16">
                        <h1 className={`text-5xl font-bold ${isDark ? 'text-white' : 'text-gray-900'} mb-8`}>
                            Our Partners
                        </h1>
                        <div className="animate-pulse">
                            <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                                {[1, 2, 3, 4, 5, 6].map((i) => (
                                    <div
                                        key={i}
                                        className={`${isDark ? 'bg-gray-800' : 'bg-gray-200'} aspect-video rounded-lg`}
                                    ></div>
                                ))}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
    // Parse associates from repeater field
    const getAssociates = () => {
        try {
            const associatesData = getSetting('associates_items', '[]');
            const associates = typeof associatesData === 'string' ? JSON.parse(associatesData) : associatesData;

            // Map to ensure consistent structure
            return associates.map(associate => ({
                name: associate.name || 'Company Name',
                logo: associate.logo || '/images/associates/default.png',
                description: associate.description || 'Description not available',
                category: associate.category || 'General',
                website: associate.website || '#'
            }));
        } catch (error) {
            console.error('Error parsing associates data:', error);
            return [
                {
                    name: 'TechCorp Productions',
                    logo: '/images/associates/techcorp.png',
                    description: 'Leading technology solutions for media production',
                    category: 'Technology',
                    website: 'https://techcorp.com'
                },
                {
                    name: 'Creative Studios Alliance',
                    logo: '/images/associates/csa.png',
                    description: 'Network of independent creative studios',
                    category: 'Creative',
                    website: 'https://creativestudios.com'
                },
                {
                    name: 'Global Distribution Network',
                    logo: '/images/associates/gdn.png',
                    description: 'Worldwide content distribution platform',
                    category: 'Distribution',
                    website: 'https://globaldist.com'
                }
            ];
        }
    };

    const associates = getAssociates();

    return (
        <div className={`min-h-screen ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
            {/* Modern Hero Section */}
            <section className={`relative overflow-hidden ${isDark ? 'bg-gradient-to-br from-gray-900 via-gray-800 to-black' : 'bg-gradient-to-br from-white via-orange-50 to-orange-100'}`}>
                {/* Background Pattern */}
                <div className="absolute inset-0 opacity-10">
                    <div className="absolute inset-0 bg-gradient-to-r from-orange-500/20 to-purple-500/20"></div>
                    <div className="absolute top-0 left-0 w-full h-full">
                        {[...Array(50)].map((_, i) => (
                            <div
                                key={i}
                                className={`absolute rounded-full animate-pulse ${isDark ? 'bg-orange-400' : 'bg-orange-300'}`}
                                style={{
                                    width: Math.random() * 4 + 1 + 'px',
                                    height: Math.random() * 4 + 1 + 'px',
                                    top: Math.random() * 100 + '%',
                                    left: Math.random() * 100 + '%',
                                    animationDelay: Math.random() * 5 + 's',
                                }}
                            />
                        ))}
                    </div>
                </div>

                <div className="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
                    <div className="text-center">
                        {/* Badge */}
                        <div className="inline-flex items-center px-4 py-2 rounded-full bg-orange-500/10 border border-orange-500/20 mb-8">
                            <span className="text-orange-500 font-medium text-sm">
                                {getSetting('partners_badge', 'Global Network')}
                            </span>
                        </div>

                        {/* Title */}
                        <h1 className={`text-5xl md:text-6xl lg:text-7xl font-bold mb-8 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                            {getSetting('partners_title', 'Strategic Content Partnership Network')}
                        </h1>

                        {/* Description */}
                        <p className={`text-xl md:text-2xl mb-16 max-w-4xl mx-auto leading-relaxed ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                            {getSetting('partners_description', 'Building bridges between content creators and global audiences through strategic partnerships.')}
                        </p>
                    </div>
                </div>
            </section>

            {/* Interactive Partnership Categories */}
            <section className={`py-20 ${isDark ? 'bg-black' : 'bg-gray-50'}`}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center mb-16">
                        <h2 className={`text-4xl md:text-5xl font-bold mb-6 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                            {getSetting('partnership_categories_title', 'Partnership Ecosystem')}
                        </h2>
                        <p className={`text-xl max-w-4xl mx-auto leading-relaxed ${isDark ? 'text-gray-400' : 'text-gray-600'}`}>
                            {getSetting('partnership_categories_subtitle', 'Our diverse network spans the entire content lifecycle')}
                        </p>
                    </div>

                    {/* Categories Grid */}
                    <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-20">
                        {partnershipCategories.map((category, index) => (
                            <div
                                key={index}
                                className={`group relative overflow-hidden rounded-2xl p-8 cursor-pointer transition-all duration-500 transform hover:scale-105 ${isDark
                                    ? 'bg-gradient-to-br from-gray-800 to-gray-900 hover:from-gray-700 hover:to-gray-800 border border-gray-700'
                                    : 'bg-white hover:bg-gradient-to-br hover:from-white hover:to-orange-50 shadow-lg hover:shadow-2xl border border-gray-100'
                                    }`}
                                onClick={() => setActiveCategory(index)}
                            >
                                {/* Background decoration */}
                                <div className="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-orange-500/10 rounded-full group-hover:scale-150 transition-transform duration-700"></div>

                                {/* Icon */}
                                <div className="text-6xl mb-6 group-hover:scale-110 transition-transform duration-300">
                                    {category.icon}
                                </div>

                                {/* Content */}
                                <h3 className={`text-2xl font-bold mb-4 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                    {category.title}
                                </h3>
                                <p className={`mb-6 leading-relaxed ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                                    {category.description}
                                </p>

                                {/* Count badge */}
                                <div className="flex items-center justify-between">
                                    <div className={`text-3xl font-bold ${isDark ? 'text-orange-400' : 'text-orange-500'}`}>
                                        {category.count}
                                    </div>
                                    <svg
                                        className={`w-6 h-6 group-hover:translate-x-2 transition-transform duration-300 ${isDark ? 'text-gray-400' : 'text-gray-500'}`}
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            {/* Trusted Associates Section */}
            <section className={`py-20 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center mb-16">
                        <h2 className={`text-4xl md:text-5xl font-bold mb-6 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                            {getSetting('associates_title', 'Trusted Associates & Service Partners')}
                        </h2>
                        <p className={`text-xl max-w-3xl mx-auto ${isDark ? 'text-gray-400' : 'text-gray-600'}`}>
                            Specialized partners providing cutting-edge services and technology solutions
                        </p>
                    </div>

                    {/* Associates Grid */}
                    <div className="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        {associates.map((associate, index) => (
                            <div
                                key={index}
                                className={`group relative overflow-hidden rounded-2xl p-6 transition-all duration-500 transform hover:scale-105 ${isDark
                                    ? 'bg-gradient-to-br from-gray-800 to-gray-900 hover:from-gray-700 hover:to-gray-800 border border-gray-700'
                                    : 'bg-white hover:shadow-2xl shadow-lg border border-gray-100'
                                    }`}
                            >
                                {/* Background decoration */}
                                <div className="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-orange-500/10 to-purple-500/10 rounded-full -translate-y-10 translate-x-10 group-hover:scale-150 transition-transform duration-700"></div>

                                {/* Logo */}
                                <div className="relative mb-4">
                                    <img
                                        src={associate.logo}
                                        alt={associate.name}
                                        className="h-16 w-auto object-contain group-hover:scale-110 transition-transform duration-300"
                                        onError={(e) => {
                                            e.target.style.display = 'none';
                                            e.target.nextSibling.style.display = 'flex';
                                        }}
                                    />
                                    {/* Fallback when image fails */}
                                    <div className="hidden h-16 w-16 bg-gradient-to-br from-orange-500 to-purple-500 rounded-xl items-center justify-center text-white font-bold text-lg">
                                        {associate.name.split(' ').map(word => word[0]).join('').slice(0, 2)}
                                    </div>
                                </div>

                                {/* Content */}
                                <div>
                                    <h3 className={`text-lg font-bold mb-2 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                        {associate.name}
                                    </h3>

                                    {/* Category badge */}
                                    <div className="mb-3">
                                        <span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300">
                                            {associate.category}
                                        </span>
                                    </div>

                                    <p className={`text-sm mb-4 line-clamp-3 ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                                        {associate.description}
                                    </p>

                                    {/* Website link */}
                                    {associate.website && (
                                        <a
                                            href={associate.website}
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            className={`inline-flex items-center text-sm font-medium hover:underline transition-colors ${isDark ? 'text-orange-400 hover:text-orange-300' : 'text-orange-500 hover:text-orange-600'
                                                }`}
                                        >
                                            Visit Website
                                            <svg className="ml-1 w-4 h-4 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>
                                    )}
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            {/* Success Metrics */}
            <section className={`py-20 ${isDark ? 'bg-gradient-to-r from-gray-800 to-black' : 'bg-gradient-to-r from-orange-500 to-purple-600'}`}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center mb-16">
                        <h2 className="text-4xl md:text-5xl font-bold text-white mb-6">
                            Partnership Success Stories
                        </h2>
                        <p className="text-xl text-white/90 max-w-3xl mx-auto">
                            Real results from our global content partnership network
                        </p>
                    </div>

                    <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                        <div className="text-center">
                            <div className="text-4xl mb-4">🎬</div>
                            <div className="text-5xl font-bold text-white mb-2">500+</div>
                            <div className="text-white/90 font-medium">Movies Published</div>
                        </div>
                        <div className="text-center">
                            <div className="text-4xl mb-4">🎵</div>
                            <div className="text-5xl font-bold text-white mb-2">2,000+</div>
                            <div className="text-white/90 font-medium">Songs Released</div>
                        </div>
                        <div className="text-center">
                            <div className="text-4xl mb-4">🎥</div>
                            <div className="text-5xl font-bold text-white mb-2">800+</div>
                            <div className="text-white/90 font-medium">Short Films</div>
                        </div>
                        <div className="text-center">
                            <div className="text-4xl mb-4">👁️</div>
                            <div className="text-5xl font-bold text-white mb-2">50M+</div>
                            <div className="text-white/90 font-medium">Total Views</div>
                        </div>
                    </div>
                </div>
            </section>

            {/* Partnership Benefits */}
            <section className={`py-20 ${isDark ? 'bg-black' : 'bg-gray-50'}`}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center mb-16">
                        <h2 className={`text-4xl md:text-5xl font-bold mb-6 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                            Why Choose Our Partnership Network?
                        </h2>
                        <p className={`text-xl max-w-3xl mx-auto ${isDark ? 'text-gray-400' : 'text-gray-600'}`}>
                            Unlock unprecedented growth opportunities with our comprehensive partnership ecosystem
                        </p>
                    </div>

                    <div className="grid lg:grid-cols-3 gap-8">
                        {/* Benefit 1 */}
                        <div className={`group relative overflow-hidden rounded-2xl p-8 transition-all duration-500 ${isDark
                            ? 'bg-gradient-to-br from-gray-800 to-gray-900 hover:from-orange-900/20 hover:to-gray-800 border border-gray-700'
                            : 'bg-white hover:bg-gradient-to-br hover:from-orange-50 hover:to-white shadow-lg hover:shadow-2xl border border-gray-100'
                            }`}>
                            <div className="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-orange-500/20 to-purple-500/20 rounded-full -translate-y-10 translate-x-10 group-hover:scale-150 transition-transform duration-700"></div>

                            <div className="relative">
                                <div className="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                                    <svg className="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064" />
                                    </svg>
                                </div>
                                <h3 className={`text-2xl font-bold mb-4 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                    Global Distribution Network
                                </h3>
                                <p className={`leading-relaxed ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                                    Access our worldwide distribution network spanning 180+ countries with strategic partnerships across major platforms and emerging markets.
                                </p>
                            </div>
                        </div>

                        {/* Benefit 2 */}
                        <div className={`group relative overflow-hidden rounded-2xl p-8 transition-all duration-500 ${isDark
                            ? 'bg-gradient-to-br from-gray-800 to-gray-900 hover:from-purple-900/20 hover:to-gray-800 border border-gray-700'
                            : 'bg-white hover:bg-gradient-to-br hover:from-purple-50 hover:to-white shadow-lg hover:shadow-2xl border border-gray-100'
                            }`}>
                            <div className="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-purple-500/20 to-blue-500/20 rounded-full -translate-y-10 translate-x-10 group-hover:scale-150 transition-transform duration-700"></div>

                            <div className="relative">
                                <div className="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                                    <svg className="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <h3 className={`text-2xl font-bold mb-4 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                    Revenue Optimization
                                </h3>
                                <p className={`leading-relaxed ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                                    Maximize your content monetization with advanced analytics, strategic placement, and our proven revenue optimization algorithms.
                                </p>
                            </div>
                        </div>

                        {/* Benefit 3 */}
                        <div className={`group relative overflow-hidden rounded-2xl p-8 transition-all duration-500 ${isDark
                            ? 'bg-gradient-to-br from-gray-800 to-gray-900 hover:from-blue-900/20 hover:to-gray-800 border border-gray-700'
                            : 'bg-white hover:bg-gradient-to-br hover:from-blue-50 hover:to-white shadow-lg hover:shadow-2xl border border-gray-100'
                            }`}>
                            <div className="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-blue-500/20 to-green-500/20 rounded-full -translate-y-10 translate-x-10 group-hover:scale-150 transition-transform duration-700"></div>

                            <div className="relative">
                                <div className="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                                    <svg className="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <h3 className={`text-2xl font-bold mb-4 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                    Dedicated Support
                                </h3>
                                <p className={`leading-relaxed ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                                    Get 24/7 dedicated support from our expert team, including account management, technical assistance, and strategic guidance.
                                </p>
                            </div>
                        </div>
                    </div>

                    {/* Additional Benefits Row */}
                    <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mt-12">
                        <div className={`flex items-center space-x-4 p-6 rounded-xl ${isDark ? 'bg-gray-800/50' : 'bg-white/50'} backdrop-blur-sm`}>
                            <div className="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                                <svg className="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h4 className={`font-bold ${isDark ? 'text-white' : 'text-gray-900'}`}>Fair Revenue Sharing</h4>
                                <p className={`text-sm ${isDark ? 'text-gray-400' : 'text-gray-600'}`}>Transparent and competitive rates</p>
                            </div>
                        </div>

                        <div className={`flex items-center space-x-4 p-6 rounded-xl ${isDark ? 'bg-gray-800/50' : 'bg-white/50'} backdrop-blur-sm`}>
                            <div className="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center">
                                <svg className="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div>
                                <h4 className={`font-bold ${isDark ? 'text-white' : 'text-gray-900'}`}>Fast Implementation</h4>
                                <p className={`text-sm ${isDark ? 'text-gray-400' : 'text-gray-600'}`}>Quick onboarding process</p>
                            </div>
                        </div>

                        <div className={`flex items-center space-x-4 p-6 rounded-xl ${isDark ? 'bg-gray-800/50' : 'bg-white/50'} backdrop-blur-sm`}>
                            <div className="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center">
                                <svg className="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <div>
                                <h4 className={`font-bold ${isDark ? 'text-white' : 'text-gray-900'}`}>Content Protection</h4>
                                <p className={`text-sm ${isDark ? 'text-gray-400' : 'text-gray-600'}`}>Advanced rights management</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* Enhanced CTA Section */}
            <section className="relative py-24 overflow-hidden bg-gradient-to-br from-orange-500 via-orange-600 to-purple-600">
                {/* Background Pattern */}
                <div className="absolute inset-0 opacity-20">
                    <div className="absolute inset-0">
                        {[...Array(30)].map((_, i) => (
                            <div
                                key={i}
                                className="absolute rounded-full bg-white animate-pulse"
                                style={{
                                    width: Math.random() * 6 + 2 + 'px',
                                    height: Math.random() * 6 + 2 + 'px',
                                    top: Math.random() * 100 + '%',
                                    left: Math.random() * 100 + '%',
                                    animationDelay: Math.random() * 3 + 's',
                                    animationDuration: (Math.random() * 2 + 2) + 's',
                                }}
                            />
                        ))}
                    </div>
                </div>

                <div className="relative max-w-5xl mx-auto text-center px-4 sm:px-6 lg:px-8">
                    <h2 className="text-4xl md:text-6xl font-bold text-white mb-6">
                        Ready to Transform Your Content?
                    </h2>
                    <p className="text-xl md:text-2xl text-white/90 mb-12 max-w-3xl mx-auto leading-relaxed">
                        Join our network of successful partners and unlock the global potential of your content with our comprehensive partnership ecosystem.
                    </p>

                    <div className="flex flex-col sm:flex-row gap-6 justify-center mb-12">
                        <button className="group bg-white text-orange-600 px-10 py-5 rounded-2xl text-lg font-bold transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                            <span className="flex items-center justify-center">
                                Start Partnership
                                <svg className="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </span>
                        </button>
                        <button className="group border-2 border-white text-white px-10 py-5 rounded-2xl text-lg font-bold transition-all duration-300 hover:bg-white hover:text-orange-600">
                            <span className="flex items-center justify-center">
                                Schedule Demo
                                <svg className="ml-2 w-5 h-5 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </span>
                        </button>
                    </div>

                    {/* Trust indicators */}
                    <div className="flex flex-wrap justify-center items-center gap-8 text-white/80">
                        <div className="flex items-center space-x-2">
                            <svg className="w-5 h-5 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd" />
                            </svg>
                            <span className="text-sm font-medium">No Setup Fees</span>
                        </div>
                        <div className="flex items-center space-x-2">
                            <svg className="w-5 h-5 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd" />
                            </svg>
                            <span className="text-sm font-medium">24/7 Support</span>
                        </div>
                        <div className="flex items-center space-x-2">
                            <svg className="w-5 h-5 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd" />
                            </svg>
                            <span className="text-sm font-medium">Fair Revenue Share</span>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    );
}

export default Partners;
