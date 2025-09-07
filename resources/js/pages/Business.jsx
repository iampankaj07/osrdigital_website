

import { useTheme } from '../contexts/ThemeContext';

function Business() {
    const { isDark } = useTheme();

    return (
        <div className={`min-h-screen ${isDark ? 'bg-gray-900' : 'bg-gray-50'} pt-20`}>
            {/* Hero Section */}
            <section className={`py-20 ${isDark ? 'bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900' : 'bg-gradient-to-r from-gray-100 via-gray-200 to-gray-100'}`}>
                <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <h1 className={`text-5xl font-bold ${isDark ? 'text-white' : 'text-gray-900'} mb-8`}>Our Business Model</h1>
                    <p className={`text-xl ${isDark ? 'text-gray-300' : 'text-gray-600'} max-w-3xl mx-auto`}>
                        OSR Digital operates at the intersection of content creation and digital distribution,
                        providing comprehensive solutions for content monetization and audience growth.
                    </p>
                </div>
            </section>

            {/* Services Section */}
            <section className={`py-20 ${isDark ? 'bg-black' : 'bg-white'}`}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center mb-16">
                        <h2 className={`text-4xl font-bold ${isDark ? 'text-white' : 'text-gray-900'} mb-6`}>What We Do</h2>
                        <p className={`text-xl ${isDark ? 'text-gray-400' : 'text-gray-600'} max-w-3xl mx-auto`}>
                            Our comprehensive suite of services covers every aspect of digital content distribution
                        </p>
                    </div>

                    <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div className={`${isDark ? 'bg-gray-800 hover:bg-gray-700' : 'bg-gray-50 hover:bg-gray-100'} p-8 rounded-lg transition-colors shadow-lg`}>
                            <div className="text-4xl mb-4">🎬</div>
                            <h3 className={`text-2xl font-semibold ${isDark ? 'text-white' : 'text-gray-900'} mb-4`}>Rights Acquisition</h3>
                            <p className={`${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                                We identify and acquire distribution rights to exceptional movies, music, and short films
                                from creators worldwide, ensuring fair compensation and global reach.
                            </p>
                        </div>

                        <div className={`${isDark ? 'bg-gray-800 hover:bg-gray-700' : 'bg-gray-50 hover:bg-gray-100'} p-8 rounded-lg transition-colors shadow-lg`}>
                            <div className="text-4xl mb-4">📺</div>
                            <h3 className={`text-2xl font-semibold ${isDark ? 'text-white' : 'text-gray-900'} mb-4`}>YouTube Publishing</h3>
                            <p className={`${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                                Strategic publishing on YouTube with optimized metadata, thumbnails, and scheduling
                                to maximize viewership and engagement across different time zones and audiences.
                            </p>
                        </div>

                        <div className="bg-gray-800 p-8 rounded-lg hover:bg-gray-700 transition-colors">
                            <div className="text-4xl mb-4">📊</div>
                            <h3 className="text-2xl font-semibold text-white mb-4">Analytics & Optimization</h3>
                            <p className="text-gray-300">
                                Comprehensive analytics tracking and performance optimization to ensure maximum
                                revenue generation and audience growth for all distributed content.
                            </p>
                        </div>

                        <div className="bg-gray-800 p-8 rounded-lg hover:bg-gray-700 transition-colors">
                            <div className="text-4xl mb-4">🎵</div>
                            <h3 className="text-2xl font-semibold text-white mb-4">Music Distribution</h3>
                            <p className="text-gray-300">
                                Specialized music publishing services including playlist placement,
                                social media promotion, and cross-platform distribution strategies.
                            </p>
                        </div>

                        <div className="bg-gray-800 p-8 rounded-lg hover:bg-gray-700 transition-colors">
                            <div className="text-4xl mb-4">🤝</div>
                            <h3 className="text-2xl font-semibold text-white mb-4">Creator Partnerships</h3>
                            <p className="text-gray-300">
                                Long-term partnerships with content creators, providing ongoing support,
                                marketing assistance, and revenue optimization strategies.
                            </p>
                        </div>

                        <div className="bg-gray-800 p-8 rounded-lg hover:bg-gray-700 transition-colors">
                            <div className="text-4xl mb-4">🌍</div>
                            <h3 className="text-2xl font-semibold text-white mb-4">Global Reach</h3>
                            <p className="text-gray-300">
                                Leveraging our network and expertise to distribute content to global audiences,
                                breaking geographical barriers and cultural boundaries.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            {/* Process Section */}
            <section className="py-20 bg-gray-900">
                <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center mb-16">
                        <h2 className="text-4xl font-bold text-white mb-6">Our Process</h2>
                        <p className="text-xl text-gray-400">
                            From discovery to distribution, we handle every step of the content journey
                        </p>
                    </div>

                    <div className="space-y-8">
                        <div className="flex items-start space-x-6">
                            <div className="flex-shrink-0 w-12 h-12 bg-red-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                1
                            </div>
                            <div>
                                <h3 className="text-xl font-semibold text-white mb-2">Content Discovery & Evaluation</h3>
                                <p className="text-gray-300">
                                    Our team actively scouts for exceptional content across various platforms and networks,
                                    evaluating potential based on quality, audience appeal, and market viability.
                                </p>
                            </div>
                        </div>

                        <div className="flex items-start space-x-6">
                            <div className="flex-shrink-0 w-12 h-12 bg-red-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                2
                            </div>
                            <div>
                                <h3 className="text-xl font-semibold text-white mb-2">Rights Negotiation & Acquisition</h3>
                                <p className="text-gray-300">
                                    We work directly with creators, studios, and rights holders to negotiate fair and
                                    beneficial distribution agreements that protect creator interests while maximizing reach.
                                </p>
                            </div>
                        </div>

                        <div className="flex items-start space-x-6">
                            <div className="flex-shrink-0 w-12 h-12 bg-red-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                3
                            </div>
                            <div>
                                <h3 className="text-xl font-semibold text-white mb-2">Content Optimization & Strategy</h3>
                                <p className="text-gray-300">
                                    Each piece of content undergoes strategic optimization including metadata enhancement,
                                    thumbnail design, and audience targeting to ensure maximum engagement.
                                </p>
                            </div>
                        </div>

                        <div className="flex items-start space-x-6">
                            <div className="flex-shrink-0 w-12 h-12 bg-red-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                4
                            </div>
                            <div>
                                <h3 className="text-xl font-semibold text-white mb-2">Publication & Promotion</h3>
                                <p className="text-gray-300">
                                    Strategic publishing across our network of channels with coordinated promotional
                                    campaigns across social media platforms and industry networks.
                                </p>
                            </div>
                        </div>

                        <div className="flex items-start space-x-6">
                            <div className="flex-shrink-0 w-12 h-12 bg-red-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                5
                            </div>
                            <div>
                                <h3 className="text-xl font-semibold text-white mb-2">Performance Monitoring & Revenue Sharing</h3>
                                <p className="text-gray-300">
                                    Continuous monitoring of performance metrics with transparent reporting and
                                    fair revenue sharing based on predetermined agreements.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    );
}

export default Business;
