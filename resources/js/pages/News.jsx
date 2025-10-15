import React from 'react';
import { useState, useEffect } from 'react';
import { useTheme } from '../contexts/ThemeContext';
import { Link } from 'react-router-dom';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faNewspaper, faCalendarAlt, faUser, faArrowRight, faFilter, faSearch, faRocket, faChartLine, faGlobe, faLightbulb, faExternalLinkAlt, faChevronLeft, faChevronRight, faAngleDoubleLeft, faAngleDoubleRight, faSpinner } from '@fortawesome/free-solid-svg-icons';
import CompactHero from '../components/sections/CompactHero';

function News() {
    const { isDark } = useTheme();
    const [isVisible, setIsVisible] = useState(false);
    const [selectedCategory, setSelectedCategory] = useState('all');
    const [currentPage, setCurrentPage] = useState(1);
    const [newsArticles, setNewsArticles] = useState([]);
    const [featuredArticle, setFeaturedArticle] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const articlesPerPage = 6;

    // Fetch news data from API
    const fetchNewsData = async () => {
        try {
            setLoading(true);
            setError(null);

            // Fetch all news articles with proper headers
            const response = await fetch('/api/news', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();

            if (data.success) {
                setNewsArticles(data.data);

                // Find featured article
                const featured = data.data.find(article => article.featured);
                setFeaturedArticle(featured);
            } else {
                setError(data.message || 'Failed to load news articles');
            }
        } catch (err) {
            console.error('Error fetching news:', err);
            setError('Failed to load news articles');
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        setIsVisible(true);
        document.title = "News & Updates - OSR Digital";
        let metaDescription = document.querySelector('meta[name="description"]');
        if (!metaDescription) {
            metaDescription = document.createElement('meta');
            metaDescription.name = 'description';
            document.getElementsByTagName('head')[0].appendChild(metaDescription);
        }
        metaDescription.content = "Stay updated with the latest news, industry insights, and company announcements from OSR Digital. Discover trends in digital content distribution and media innovation.";

        fetchNewsData();
    }, []);

    // News articles are now fetched from API - no hardcoded fallback data

    // Dynamic categories from API data
    const categories = [
        { id: 'all', name: 'All News', icon: faNewspaper, slug: 'all' },
        ...newsArticles.reduce((acc, article) => {
            if (article.category && !acc.find(cat => cat.slug === article.category.slug)) {
                acc.push({
                    id: article.category.id,
                    name: article.category.name,
                    slug: article.category.slug,
                    icon: faRocket // Default icon, you can customize based on category
                });
            }
            return acc;
        }, [])
    ];

    const filteredArticles = selectedCategory === 'all'
        ? newsArticles
        : newsArticles.filter(article =>
            article.category?.slug === selectedCategory ||
            article.category_id === selectedCategory ||
            article.category?.id === selectedCategory
        );

    // Reset to page 1 when category changes
    useEffect(() => {
        setCurrentPage(1);
    }, [selectedCategory]);

    // Calculate pagination
    const totalPages = Math.ceil(filteredArticles.length / articlesPerPage);
    const startIndex = (currentPage - 1) * articlesPerPage;
    const endIndex = startIndex + articlesPerPage;
    const currentArticles = filteredArticles.slice(startIndex, endIndex);

    // Use featured article from state, fallback to first article if no featured
    const displayFeaturedArticle = featuredArticle || currentArticles[0];
    const otherArticles = currentArticles.filter(article => article.id !== displayFeaturedArticle?.id);


    return (
        <div className={`min-h-screen transition-colors duration-300 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
            {/* Hero Section */}
            <CompactHero
                page="news"
                title="Latest News"
                subtitle="Industry Updates"
                description="Stay updated with the latest news, insights, and announcements from OSR Digital and the entertainment industry."
            />

            {/* Category Filter */}
            <section className={`py-8 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                <div className="container-minimal">
                    <div className="flex flex-wrap justify-center gap-4">
                        {categories.map((category) => (
                            <button
                                key={category.id}
                                onClick={() => setSelectedCategory(category.slug || category.id)}
                                className={`flex items-center px-6 py-3 rounded-full text-sm font-medium transition-all duration-200 ${
                                    selectedCategory === (category.slug || category.id)
                                        ? 'bg-brand-orange-500 text-white shadow-lg'
                                        : isDark
                                            ? 'bg-gray-700 text-gray-300 hover:bg-gray-600'
                                            : 'bg-white text-gray-700 hover:bg-gray-100'
                                }`}
                            >
                                <FontAwesomeIcon icon={category.icon} className="mr-2" />
                                {category.name}
                            </button>
                        ))}
                    </div>
                </div>
            </section>

            {/* Loading State */}
            {loading && (
                <section className={`py-16 md:py-24 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                    <div className="container-minimal">
                        {/* Featured Article Skeleton */}
                        <div className="mb-16">
                            <div className={`h-8 w-48 mb-6 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                            <div className={`h-96 rounded-lg mb-6 ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                            <div className={`h-8 w-3/4 mb-4 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                            <div className={`h-6 w-full mb-2 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                            <div className={`h-6 w-2/3 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                        </div>

                        {/* Articles Grid Skeleton */}
                        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                            {[1, 2, 3, 4, 5, 6].map((i) => (
                                <div key={i} className={`rounded-lg overflow-hidden ${isDark ? 'bg-gray-800' : 'bg-white'} shadow-sm border ${isDark ? 'border-gray-700' : 'border-gray-200'}`}>
                                    <div className={`h-48 ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                    <div className="p-6">
                                        <div className={`h-4 w-20 mb-3 rounded-full ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                        <div className={`h-6 w-full mb-3 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                        <div className={`h-4 w-full mb-2 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                        <div className={`h-4 w-3/4 mb-4 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                        <div className={`h-4 w-24 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </section>
            )}

            {/* Error State */}
            {error && (
                <section className={`py-16 md:py-24 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                    <div className="container-minimal">
                        <div className="text-center">
                            <div className={`text-6xl mb-4 ${isDark ? 'text-gray-600' : 'text-gray-400'}`}>
                                <FontAwesomeIcon icon={faNewspaper} />
                            </div>
                            <h3 className={`text-2xl font-semibold mb-4 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                Unable to load news
                            </h3>
                            <p className={`${isDark ? 'text-gray-400' : 'text-gray-600'} mb-6`}>
                                {error}
                            </p>
                            <button
                                onClick={fetchNewsData}
                                className="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition-colors"
                            >
                                Try Again
                            </button>
                        </div>
                    </div>
                </section>
            )}

            {/* Featured Article */}
            {!loading && !error && displayFeaturedArticle && (
                <section className={`py-16 md:py-24 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                    <div className="container-minimal">
                        <div className="mb-8">
                            <h2 className={`text-3xl font-bold mb-4 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                Featured Article
                            </h2>
                        </div>

                        <div className={`rounded-2xl overflow-hidden shadow-2xl ${
                            isDark ? 'bg-gray-800' : 'bg-white'
                        }`}>
                            <div className="lg:flex">
                                <div className="lg:w-1/2">
                                    <img
                                        src={featuredArticle.featured_image_url || ''}
                                        alt={featuredArticle.title}
                                        className="w-full h-64 lg:h-full object-cover"
                                    />
                                </div>
                                <div className="lg:w-1/2 p-8 lg:p-12">
                                    <div className="flex items-center mb-4">
                                        <span className={`inline-flex items-center px-3 py-1 rounded-full text-xs font-medium ${
                                            isDark ? 'bg-brand-orange-500/20 text-brand-orange-400' : 'bg-brand-orange-100 text-brand-orange-600'
                                        }`}>
                                            {featuredArticle.category?.name || 'Uncategorized'}
                                        </span>
                                        <span className={`text-sm ml-4 ${isDark ? 'text-gray-400' : 'text-gray-600'}`}>
                                            <FontAwesomeIcon icon={faCalendarAlt} className="mr-1" />
                                            {new Date(featuredArticle.published_at).toLocaleDateString()}
                                        </span>
                                    </div>

                                    <Link to={`/news/${featuredArticle.slug}`}>
                                        <h3 className={`text-3xl lg:text-4xl font-bold mb-4 hover:text-brand-orange-600 transition-colors cursor-pointer ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                            {featuredArticle.title}
                                        </h3>
                                    </Link>

                                    <p className={`text-lg mb-6 ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                                        {featuredArticle.excerpt}
                                    </p>

                                    <div className="flex items-center justify-between">
                                        <div className="flex items-center space-x-4">
                                            <span className={`text-sm ${isDark ? 'text-gray-400' : 'text-gray-600'}`}>
                                        <FontAwesomeIcon icon={faUser} className="mr-1" />
                                        {featuredArticle.author_name}
                                            </span>
                                            <span className={`text-sm ${isDark ? 'text-gray-400' : 'text-gray-600'}`}>
                                                {Math.ceil(featuredArticle.content?.split(' ').length / 200) || 5} min read
                                            </span>
                                        </div>
                                        <Link
                                            to={`/news/${featuredArticle.slug}`}
                                            className={`flex items-center px-6 py-3 rounded-lg font-medium transition-all duration-200 ${
                                                isDark
                                                    ? 'bg-brand-orange-500 text-white hover:bg-brand-orange-600'
                                                    : 'bg-brand-orange-500 text-white hover:bg-brand-orange-600'
                                            }`}
                                        >
                                            Read More
                                            <FontAwesomeIcon icon={faArrowRight} className="ml-2" />
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            )}

            {/* Articles Grid */}
            {!loading && !error && (
            <section className={`py-16 md:py-24 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                <div className="container-minimal">
                    <div className="mb-12">
                        <h2 className={`text-3xl font-bold mb-4 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                            Latest News
                        </h2>
                        <p className={`text-lg ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                            Stay updated with the latest developments in digital content distribution
                        </p>
                    </div>

                    {otherArticles.length > 0 ? (
                        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                            {otherArticles.map((article) => (
                                <article key={article.id} className={`rounded-xl overflow-hidden shadow-lg transition-all duration-300 hover:shadow-xl ${
                                    isDark ? 'bg-gray-700 hover:bg-gray-600' : 'bg-white hover:bg-gray-50'
                                }`}>
                                    <div className="relative">
                                        <img
                                            src={article.featured_image_url || ''}
                                            alt={article.title}
                                            className="w-full h-48 object-cover"
                                        />
                                        <div className="absolute top-4 left-4">
                                            <span className={`inline-flex items-center px-3 py-1 rounded-full text-xs font-medium ${
                                                isDark ? 'bg-brand-orange-500/20 text-brand-orange-400' : 'bg-brand-orange-100 text-brand-orange-600'
                                            }`}>
                                                {article.category?.name || 'Uncategorized'}
                                            </span>
                                        </div>
                                    </div>

                                    <div className="p-6">
                                        <div className="flex items-center mb-3 text-sm text-gray-500">
                                            <FontAwesomeIcon icon={faCalendarAlt} className="mr-1" />
                                            {new Date(article.published_at).toLocaleDateString()}
                                            <span className="mx-2">•</span>
                                            <FontAwesomeIcon icon={faUser} className="mr-1" />
                                            {article.author_name}
                                        </div>

                                        <Link to={`/news/${article.slug}`}>
                                            <h3 className={`text-xl font-bold mb-3 hover:text-brand-orange-600 transition-colors cursor-pointer ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                                {article.title}
                                            </h3>
                                        </Link>

                                        <p className={`text-sm mb-4 ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                                            {article.excerpt}
                                        </p>

                                        <div className="flex items-center justify-between">
                                            <span className={`text-sm ${isDark ? 'text-gray-400' : 'text-gray-500'}`}>
                                                {Math.ceil(article.content?.split(' ').length / 200) || 5} min read
                                            </span>
                                            <Link
                                                to={`/news/${article.slug}`}
                                                className={`flex items-center text-sm font-medium transition-colors ${
                                                    isDark ? 'text-brand-orange-400 hover:text-brand-orange-300' : 'text-brand-orange-600 hover:text-brand-orange-700'
                                                }`}
                                            >
                                                Read More
                                                <FontAwesomeIcon icon={faArrowRight} className="ml-1" />
                                            </Link>
                                        </div>
                                    </div>
                                </article>
                            ))}
                        </div>
                    ) : (
                        <div className="text-center py-20">
                            <div className={`text-6xl mb-4 ${isDark ? 'text-gray-600' : 'text-gray-400'}`}>
                                <FontAwesomeIcon icon={faNewspaper} />
                            </div>
                            <h3 className={`text-2xl font-semibold mb-4 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                No articles found
                            </h3>
                            <p className={`${isDark ? 'text-gray-400' : 'text-gray-600'}`}>
                                No articles available in this category.
                            </p>
                        </div>
                    )}
                </div>
            </section>
            )}

            {/* Pagination */}
            {totalPages > 1 && (
                <section className={`py-8 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                    <div className="container-minimal">
                        <div className="flex flex-col sm:flex-row items-center justify-between gap-4">
                            {/* Page Info */}
                            <div className={`text-sm ${isDark ? 'text-gray-400' : 'text-gray-600'}`}>
                                Showing {startIndex + 1}-{Math.min(endIndex, filteredArticles.length)} of {filteredArticles.length} articles
                            </div>

                            {/* Pagination Controls */}
                            <div className="flex items-center gap-2">
                                {/* First Page */}
                                <button
                                    onClick={() => setCurrentPage(1)}
                                    disabled={currentPage === 1}
                                    className={`p-2 rounded-lg transition-colors ${
                                        currentPage === 1
                                            ? isDark ? 'bg-gray-700 text-gray-500 cursor-not-allowed' : 'bg-gray-200 text-gray-400 cursor-not-allowed'
                                            : isDark ? 'bg-gray-700 text-gray-300 hover:bg-gray-600' : 'bg-white text-gray-700 hover:bg-gray-100'
                                    }`}
                                >
                                    <FontAwesomeIcon icon={faAngleDoubleLeft} />
                                </button>

                                {/* Previous Page */}
                                <button
                                    onClick={() => setCurrentPage(currentPage - 1)}
                                    disabled={currentPage === 1}
                                    className={`p-2 rounded-lg transition-colors ${
                                        currentPage === 1
                                            ? isDark ? 'bg-gray-700 text-gray-500 cursor-not-allowed' : 'bg-gray-200 text-gray-400 cursor-not-allowed'
                                            : isDark ? 'bg-gray-700 text-gray-300 hover:bg-gray-600' : 'bg-white text-gray-700 hover:bg-gray-100'
                                    }`}
                                >
                                    <FontAwesomeIcon icon={faChevronLeft} />
                                </button>

                                {/* Page Numbers */}
                                <div className="flex items-center gap-1">
                                    {Array.from({ length: Math.min(5, totalPages) }, (_, i) => {
                                        let pageNumber;
                                        if (totalPages <= 5) {
                                            pageNumber = i + 1;
                                        } else if (currentPage <= 3) {
                                            pageNumber = i + 1;
                                        } else if (currentPage >= totalPages - 2) {
                                            pageNumber = totalPages - 4 + i;
                                        } else {
                                            pageNumber = currentPage - 2 + i;
                                        }

                                        return (
                                            <button
                                                key={pageNumber}
                                                onClick={() => setCurrentPage(pageNumber)}
                                                className={`px-3 py-2 rounded-lg text-sm font-medium transition-colors ${
                                                    currentPage === pageNumber
                                                        ? 'bg-brand-orange-500 text-white'
                                                        : isDark
                                                            ? 'bg-gray-700 text-gray-300 hover:bg-gray-600'
                                                            : 'bg-white text-gray-700 hover:bg-gray-100'
                                                }`}
                                            >
                                                {pageNumber}
                                            </button>
                                        );
                                    })}
                                </div>

                                {/* Next Page */}
                                <button
                                    onClick={() => setCurrentPage(currentPage + 1)}
                                    disabled={currentPage === totalPages}
                                    className={`p-2 rounded-lg transition-colors ${
                                        currentPage === totalPages
                                            ? isDark ? 'bg-gray-700 text-gray-500 cursor-not-allowed' : 'bg-gray-200 text-gray-400 cursor-not-allowed'
                                            : isDark ? 'bg-gray-700 text-gray-300 hover:bg-gray-600' : 'bg-white text-gray-700 hover:bg-gray-100'
                                    }`}
                                >
                                    <FontAwesomeIcon icon={faChevronRight} />
                                </button>

                                {/* Last Page */}
                                <button
                                    onClick={() => setCurrentPage(totalPages)}
                                    disabled={currentPage === totalPages}
                                    className={`p-2 rounded-lg transition-colors ${
                                        currentPage === totalPages
                                            ? isDark ? 'bg-gray-700 text-gray-500 cursor-not-allowed' : 'bg-gray-200 text-gray-400 cursor-not-allowed'
                                            : isDark ? 'bg-gray-700 text-gray-300 hover:bg-gray-600' : 'bg-white text-gray-700 hover:bg-gray-100'
                                    }`}
                                >
                                    <FontAwesomeIcon icon={faAngleDoubleRight} />
                                </button>
                            </div>
                        </div>
                    </div>
                </section>
            )}

        </div>
    );
}

export default News;
