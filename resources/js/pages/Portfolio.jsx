import { useState, useEffect } from 'react';
import { useTheme } from '../contexts/ThemeContext';
import CompactHero from '../components/sections/CompactHero';
import MoviePortfolio from '../components/sections/MoviePortfolio';
import OurImpact from '../components/sections/OurImpact';
import DynamicContentRenderer from '../components/DynamicContentRenderer';

function Portfolio() {
    const { isDark } = useTheme();
    const [pageData, setPageData] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchPortfolioData = async () => {
            try {
                setLoading(true);
                setError(null);

                const response = await fetch('/api/dynamic-page/portfolio');
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                setPageData(data);

                // Update document title and meta tags
                if (data.meta_title) {
                    document.title = data.meta_title.includes('OSR Digital') ? data.meta_title : `${data.meta_title} - OSR Digital`;
                } else if (data.title) {
                    document.title = `${data.title} - OSR Digital`;
                }

                if (data.meta_description) {
                    let metaDescription = document.querySelector('meta[name="description"]');
                    if (metaDescription) {
                        metaDescription.setAttribute('content', data.meta_description);
                    } else {
                        metaDescription = document.createElement('meta');
                        metaDescription.name = 'description';
                        metaDescription.content = data.meta_description;
                        document.getElementsByTagName('head')[0].appendChild(metaDescription);
                    }
                }
            } catch (err) {
                console.error('Error fetching portfolio data:', err);
                setError(err.message);
            } finally {
                setLoading(false);
            }
        };

        fetchPortfolioData();
    }, []);

    if (loading) {
        return (
            <div className={`min-h-screen transition-colors duration-300 ${
                isDark ? 'bg-gray-900' : 'bg-white'
            }`}>
                {/* Compact Hero Skeleton */}
                <section className={`py-20 pt-32 ${isDark ? 'bg-gray-900' : 'bg-gray-50'}`}>
                    <div className="container-minimal">
                        <div className="text-center max-w-4xl mx-auto">
                            <div className="mb-8">
                                <div className={`h-5 w-48 mx-auto rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                            </div>
                            <div className="mb-6">
                                <div className={`h-12 w-3/4 mx-auto mb-4 rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                            </div>
                            <div className="mb-8">
                                <div className={`h-6 w-full mb-2 rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                                <div className={`h-6 w-2/3 mx-auto rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                            </div>
                        </div>
                    </div>
                </section>

                {/* Portfolio Grid Skeleton */}
                <section className={`py-20 ${isDark ? 'bg-gray-900' : 'bg-gray-50'}`}>
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="text-center mb-16">
                            <div className={`h-10 w-64 mx-auto mb-6 rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                            <div className={`h-6 w-96 mx-auto mb-8 rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                            <div className="flex flex-wrap justify-center gap-4">
                                {[1, 2, 3, 4].map((i) => (
                                    <div key={i} className={`h-12 w-24 rounded-full ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                                ))}
                            </div>
                        </div>
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            {[1, 2, 3, 4, 5, 6].map((i) => (
                                <div key={i} className="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                                    <div className={`h-48 ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                                    <div className="p-4">
                                        <div className={`h-6 w-3/4 mb-2 rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                                        <div className={`h-4 w-full mb-2 rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                                        <div className={`h-4 w-2/3 rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </section>

                {/* Stats Skeleton */}
                <section className={`py-20 ${isDark ? 'bg-gray-800' : 'bg-gray-100'}`}>
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="text-center mb-16">
                            <div className={`h-10 w-80 mx-auto mb-6 rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                            <div className={`h-6 w-96 mx-auto rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                        </div>
                        <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                            {[1, 2, 3, 4].map((i) => (
                                <div key={i} className={`text-center p-8 rounded-xl ${isDark ? 'bg-gray-900' : 'bg-white'} shadow-lg`}>
                                    <div className={`w-12 h-12 mx-auto mb-4 rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                                    <div className={`h-8 w-16 mx-auto mb-2 rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                                    <div className={`h-5 w-24 mx-auto rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                                </div>
                            ))}
                        </div>
                    </div>
                </section>
            </div>
        );
    }    if (error) {
        return (
            <div className="min-h-screen flex items-center justify-center">
                <div className="text-center">
                    <h2 className="text-2xl font-bold text-red-600 mb-4">Error Loading Content</h2>
                    <p className="text-gray-600">{error}</p>
                </div>
            </div>
        );
    }

    if (!pageData) {
        return (
            <div className="min-h-screen flex items-center justify-center">
                <div className="text-center">
                    <h2 className="text-2xl font-bold text-gray-600 mb-4">Page Not Found</h2>
                    <p className="text-gray-500">The portfolio page content is not available.</p>
                </div>
            </div>
        );
    }

    return (
        <div className={`min-h-screen transition-colors duration-300 ${
            isDark ? 'bg-gray-900' : 'bg-white'
        }`}>
            {/* Compact Hero Section */}
            <CompactHero
                page="portfolio"
                title="Our Portfolio"
                subtitle="Content Showcase"
                description="Explore our diverse collection of movies, documentaries, short films, and series that we've successfully distributed to global audiences."
                breadcrumbs={[
                    { label: 'Home', href: '/', icon: 'fas fa-home' },
                    { label: 'Portfolio' }
                ]}
            />

            {/* Movie Portfolio Section */}
            <MoviePortfolio />

            {/* Global Impact Section */}
            <OurImpact />

            {/* Call to Action Section */}
            <section className={`py-20 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <div className="p-12 rounded-2xl bg-gradient-to-r from-brand-orange-500 to-brand-orange-600">
                        <h2 className="text-3xl md:text-4xl font-bold text-white mb-6">
                            Ready to Distribute Your Content?
                        </h2>
                        <p className="text-xl text-white/90 mb-8 leading-relaxed">
                            Join our portfolio of successful content creators and reach global audiences through our proven distribution network.
                        </p>
                        <div className="flex flex-col sm:flex-row gap-4 justify-center">
                            <a
                                href="/contact"
                                className="inline-flex items-center px-8 py-4 bg-white text-brand-orange-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors duration-200"
                            >
                                <i className="fas fa-envelope mr-2"></i>
                                Get Started Today
                            </a>
                            <a
                                href="/about"
                                className="inline-flex items-center px-8 py-4 border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-brand-orange-600 transition-colors duration-200"
                            >
                                <i className="fas fa-info-circle mr-2"></i>
                                Learn More
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            {/* Dynamic Content Renderer for additional CMS content */}
            {pageData && pageData.content_blocks && pageData.content_blocks.length > 0 && (
                <DynamicContentRenderer
                    contentBlocks={pageData.content_blocks}
                    pageSettings={pageData.settings || {}}
                    template={pageData.template || 'portfolio'}
                />
            )}
        </div>
    );
}

export default Portfolio;
