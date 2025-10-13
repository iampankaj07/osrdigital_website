import { Link } from 'react-router-dom';
import { useState, useEffect } from 'react';
import { useTheme } from '../../contexts/ThemeContext';

function DynamicHero({ page = 'home' }) {
    const { isDark } = useTheme();
    const [isVisible, setIsVisible] = useState(false);
    const [heroData, setHeroData] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchHeroData = async () => {
            try {
                setLoading(true);
                setError(null);

                const response = await fetch(`/api/hero-sections/page/${page}`);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                if (data.success) {
                    setHeroData(data.data);
                } else {
                    throw new Error(data.message || 'Failed to fetch hero data');
                }
            } catch (err) {
                console.error('Error fetching hero data:', err);
                setError(err.message);
            } finally {
                setLoading(false);
            }
        };

        fetchHeroData();
        setIsVisible(true);
    }, [page]);

    if (loading) {
        return (
            <section className={`min-h-screen flex items-center justify-center pt-16 md:pt-20 lg:pt-24 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                <div className="container-minimal">
                    <div className="text-center max-w-4xl mx-auto">
                        {/* Skeleton Subtitle */}
                        <div className="mb-8">
                            <div className={`h-6 w-48 mx-auto rounded-full ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                        </div>

                        {/* Skeleton Title */}
                        <div className="mb-12">
                            <div className={`h-16 w-full mb-6 rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                            <div className={`h-12 w-3/4 mx-auto mb-8 rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                            <div className={`h-6 w-full mb-2 rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                            <div className={`h-6 w-2/3 mx-auto rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                        </div>

                        {/* Skeleton Buttons */}
                        <div className="flex flex-col sm:flex-row gap-4 justify-center items-center">
                            <div className={`h-12 w-32 rounded-lg ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                            <div className={`h-12 w-36 rounded-lg ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                        </div>
                    </div>
                </div>
            </section>
        );
    }

    if (error || !heroData) {
        // Fallback content if API fails
        return (
            <section className={`min-h-screen flex items-center justify-center pt-16 md:pt-20 lg:pt-24 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                <div className="container-minimal">
                    <div className="text-center max-w-4xl mx-auto">
                        <div className={`transition-all duration-1000 ${isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'}`}>
                            {/* Badge */}
                            <div className="mb-8">
                                <div className={`inline-flex items-center px-4 py-2 rounded-full text-sm font-medium ${
                                    isDark ? 'bg-gray-800 text-gray-300' : 'bg-gray-100 text-gray-600'
                                }`}>
                                    <div className="w-2 h-2 rounded-full bg-gray-400 mr-2"></div>
                                    {page.charAt(0).toUpperCase() + page.slice(1)}
                                </div>
                            </div>

                            {/* Main Content */}
                            <div className="mb-12">
                                <h1 className={`text-4xl md:text-6xl lg:text-7xl font-bold mb-8 leading-tight text-minimal-bold ${
                                    isDark ? 'text-white' : 'text-gray-900'
                                }`}>
                                    Welcome to {page.charAt(0).toUpperCase() + page.slice(1)}
                                </h1>
                                <p className={`text-xl md:text-2xl mb-10 leading-relaxed text-minimal ${
                                    isDark ? 'text-gray-300' : 'text-gray-600'
                                }`}>
                                    Discover more about our services and offerings.
                                </p>
                            </div>

                            {/* CTA Buttons */}
                            <div className="flex flex-col sm:flex-row gap-4 justify-center items-center">
                                <Link
                                    to="/contact"
                                    className="btn-minimal"
                                >
                                    Get Started
                                </Link>
                                <Link
                                    to="/about"
                                    className="btn-minimal-outline"
                                >
                                    Learn More
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        );
    }

    return (
        <section className={`min-h-screen flex items-center justify-center pt-16 md:pt-20 lg:pt-24 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
            <div className="container-minimal">
                <div className="text-center max-w-4xl mx-auto">
                    <div className={`transition-all duration-1000 ${isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'}`}>
                        {/* Badge */}
                        {heroData.subtitle && (
                            <div className="mb-8">
                                <div className={`inline-flex items-center px-4 py-2 rounded-full text-sm font-medium ${
                                    isDark ? 'bg-gray-800 text-gray-300' : 'bg-gray-100 text-gray-600'
                                }`}>
                                    <div className="w-2 h-2 rounded-full bg-gray-400 mr-2"></div>
                                    {heroData.subtitle}
                                </div>
                            </div>
                        )}

                        {/* Main Content */}
                        <div className="mb-12">
                            <h1 className={`text-4xl md:text-6xl lg:text-7xl font-bold mb-8 leading-tight text-minimal-bold ${
                                isDark ? 'text-white' : 'text-gray-900'
                            }`}>
                                {heroData.title}
                            </h1>
                            <div className={`text-xl md:text-2xl mb-10 leading-relaxed text-minimal ${
                                isDark ? 'text-gray-300' : 'text-gray-600'
                            }`} dangerouslySetInnerHTML={{ __html: heroData.content }} />
                        </div>

                        {/* CTA Buttons */}
                        {(heroData.shouldShowButton || heroData.shouldShowSecondaryButton) && (
                            <div className="flex flex-col sm:flex-row gap-4 justify-center items-center">
                                {heroData.shouldShowButton && (
                                    <Link
                                        to={heroData.button_link}
                                        className="btn-minimal"
                                    >
                                        {heroData.button_text}
                                    </Link>
                                )}
                                {heroData.shouldShowSecondaryButton && (
                                    <Link
                                        to={heroData.button_link_secondary}
                                        className="btn-minimal-outline"
                                    >
                                        {heroData.button_text_secondary}
                                    </Link>
                                )}
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </section>
    );
}

export default DynamicHero;
