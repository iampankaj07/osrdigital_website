import { useState, useEffect } from 'react';
import { useTheme } from '../contexts/ThemeContext';
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
            <div className={`min-h-screen pt-20 ${isDark ? 'bg-gray-900' : 'bg-gray-50'}`}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                    {/* Header Skeleton */}
                    <div className="text-center mb-16">
                        <div className={`h-12 w-64 mx-auto mb-6 rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                        <div className={`h-6 w-96 mx-auto mb-2 rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                        <div className={`h-6 w-64 mx-auto rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                    </div>

                    {/* Content Skeleton */}
                    <div className="space-y-16">
                        {/* Hero Section Skeleton */}
                        <div className={`h-96 rounded-xl ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>

                        {/* Content Blocks Skeleton */}
                        <div className="grid md:grid-cols-2 gap-12">
                            {[1, 2].map((i) => (
                                <div key={i}>
                                    <div className={`h-8 w-48 mb-4 rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                                    <div className={`h-4 w-full mb-2 rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                                    <div className={`h-4 w-3/4 mb-2 rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                                    <div className={`h-4 w-2/3 rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>
            </div>
        );
    }

    if (error) {
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
            <DynamicContentRenderer
                contentBlocks={pageData.content_blocks || []}
                pageSettings={pageData.settings || {}}
                template={pageData.template || 'portfolio'}
            />
        </div>
    );
}

export default Portfolio;
