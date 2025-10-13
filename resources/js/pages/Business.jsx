import { useState, useEffect } from 'react';
import { useTheme } from '../contexts/ThemeContext';
import CompactHero from '../components/sections/CompactHero';

function Business() {
    const { isDark } = useTheme();
    const [businessData, setBusinessData] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchBusinessData = async () => {
            try {
                setLoading(true);
                setError(null);

                const response = await fetch('/api/business-page');
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const result = await response.json();

                if (result.success && result.data) {
                    setBusinessData(result.data);

                    // Update document title and meta tags
                    if (result.data.meta_title) {
                        document.title = result.data.meta_title.includes('OSR Digital') ? result.data.meta_title : `${result.data.meta_title} - OSR Digital`;
                    } else if (result.data.title) {
                        document.title = `${result.data.title} - OSR Digital`;
                    }

                    if (result.data.meta_description) {
                        let metaDescription = document.querySelector('meta[name="description"]');
                        if (metaDescription) {
                            metaDescription.setAttribute('content', result.data.meta_description);
                        } else {
                            metaDescription = document.createElement('meta');
                            metaDescription.name = 'description';
                            metaDescription.content = result.data.meta_description;
                            document.getElementsByTagName('head')[0].appendChild(metaDescription);
                        }
                    }
                } else {
                    setError(result.message || 'Failed to load business page data');
                }
            } catch (err) {
                console.error('Error fetching business data:', err);
                setError(err.message);
            } finally {
                setLoading(false);
            }
        };

        fetchBusinessData();
    }, []);

    if (loading) {
        return (
            <div className="min-h-screen flex items-center justify-center">
                <div className="animate-spin rounded-full h-32 w-32 border-b-2 border-orange-500"></div>
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

    if (!businessData) {
        return (
            <div className="min-h-screen flex items-center justify-center">
                <div className="text-center">
                    <h2 className="text-2xl font-bold text-gray-600 mb-4">Page Not Found</h2>
                    <p className="text-gray-500">The business page content is not available.</p>
                </div>
            </div>
        );
    }

    return (
        <div className={`min-h-screen transition-colors duration-300 ${
            isDark ? 'bg-gray-900' : 'bg-white'
        }`}>
            {/* Hero Section */}
            <CompactHero
                page="business"
                title={businessData.title}
                subtitle={businessData.subtitle}
                description={businessData.description}
                breadcrumbs={[
                    { label: 'Home', href: '/', icon: 'fas fa-home' },
                    { label: 'Business Solutions' }
                ]}
            />

            {/* Call to Action Section */}
            {businessData.call_to_action && businessData.call_to_action.text && (
                <section className={`py-16 ${isDark ? 'bg-gray-800' : 'bg-white'}`}>
                    <div className="max-w-4xl mx-auto px-4 text-center">
                        <div className="space-y-4 sm:space-y-0 sm:space-x-4 sm:flex sm:justify-center">
                            <a
                                href={businessData.call_to_action.url || '/contact'}
                                className="inline-block bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 px-8 rounded-lg transition-colors"
                            >
                                {businessData.call_to_action.text}
                            </a>
                        </div>
                    </div>
                </section>
            )}

            {/* Content Sections */}
            {businessData.content_sections && businessData.content_sections.length > 0 && (
                <section className={`py-20 ${isDark ? 'bg-gray-800' : 'bg-gray-50'}`}>
                    <div className="max-w-7xl mx-auto px-4 space-y-16">
                        {businessData.content_sections.map((section, index) => (
                            <div key={section.id || index} className={`${
                                index % 2 === 0 ? 'lg:flex-row' : 'lg:flex-row-reverse'
                            } flex flex-col lg:flex lg:items-center lg:gap-12`}>
                                <div className="lg:flex-1">
                                    <h2 className={`text-3xl font-bold mb-6 ${
                                        isDark ? 'text-white' : 'text-gray-900'
                                    }`}>
                                        {section.title}
                                    </h2>
                                    <div className={`prose prose-lg ${
                                        isDark ? 'prose-invert' : ''
                                    } max-w-none`}>
                                        <p className="text-lg leading-relaxed">
                                            {section.content}
                                        </p>
                                    </div>
                                </div>
                                {section.image && (
                                    <div className="lg:flex-1 mt-8 lg:mt-0">
                                        <img
                                            src={`/storage/${section.image}`}
                                            alt={section.title}
                                            className="w-full rounded-lg shadow-lg"
                                        />
                                    </div>
                                )}
                            </div>
                        ))}
                    </div>
                </section>
            )}

            {/* Features Section */}
            {businessData.features && businessData.features.length > 0 && (
                <section className={`py-20 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                    <div className="max-w-7xl mx-auto px-4">
                        <div className="text-center mb-16">
                            <h2 className={`text-4xl font-bold mb-4 ${
                                isDark ? 'text-white' : 'text-gray-900'
                            }`}>
                                Our Services
                            </h2>
                            <p className={`text-xl ${
                                isDark ? 'text-gray-300' : 'text-gray-600'
                            }`}>
                                What we offer to help your business grow
                            </p>
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            {businessData.features.map((feature, index) => (
                                <div key={feature.id || index} className={`p-6 rounded-lg ${
                                    isDark ? 'bg-gray-800' : 'bg-gray-50'
                                } hover:shadow-lg transition-shadow`}>
                                    {feature.icon && (
                                        <div className="text-3xl text-orange-500 mb-4">
                                            <i className={feature.icon}></i>
                                        </div>
                                    )}
                                    <h3 className={`text-xl font-semibold mb-3 ${
                                        isDark ? 'text-white' : 'text-gray-900'
                                    }`}>
                                        {feature.title}
                                    </h3>
                                    <p className={`${
                                        isDark ? 'text-gray-300' : 'text-gray-600'
                                    }`}>
                                        {feature.description}
                                    </p>
                                </div>
                            ))}
                        </div>
                    </div>
                </section>
            )}

            {/* Statistics Section */}
            {businessData.statistics && businessData.statistics.length > 0 && (
                <section className={`py-20 ${isDark ? 'bg-gray-800' : 'bg-gray-100'}`}>
                    <div className="max-w-7xl mx-auto px-4">
                        <div className="text-center mb-16">
                            <h2 className={`text-4xl font-bold mb-4 ${
                                isDark ? 'text-white' : 'text-gray-900'
                            }`}>
                                Our Impact
                            </h2>
                            <p className={`text-xl ${
                                isDark ? 'text-gray-300' : 'text-gray-600'
                            }`}>
                                Numbers that speak for themselves
                            </p>
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                            {businessData.statistics.map((stat, index) => (
                                <div key={stat.id || index} className="text-center">
                                    {stat.icon && (
                                        <div className="text-4xl text-orange-500 mb-4">
                                            <i className={stat.icon}></i>
                                        </div>
                                    )}
                                    <div className={`text-4xl font-bold mb-2 ${
                                        isDark ? 'text-white' : 'text-gray-900'
                                    }`}>
                                        {stat.value}{stat.suffix}
                                    </div>
                                    <div className={`text-lg ${
                                        isDark ? 'text-gray-300' : 'text-gray-600'
                                    }`}>
                                        {stat.label}
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </section>
            )}
        </div>
    );
}

export default Business;
