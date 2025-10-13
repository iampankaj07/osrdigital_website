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

    // News articles are now fetched from API
    const hardcodedNewsArticles = [
        {
            id: 1,
            title: "OSR Digital Expands Global Distribution Network to 50+ Countries",
            excerpt: "We're excited to announce the expansion of our YouTube distribution network, bringing exceptional content to audiences across 50+ countries worldwide.",
            content: "Complete article content...",
            category: "company",
            image: "https://via.placeholder.com/600x400/EC681D/FFFFFF?text=Global+Expansion",
            published_at: "2024-01-15",
            author: "OSR Team",
            readTime: "5 min read",
            featured: true
        },
        {
            id: 2,
            title: "New Partnership with Major Streaming Platforms",
            excerpt: "Strategic partnerships with leading streaming platforms to enhance content distribution and reach new audiences globally.",
            content: "Complete article content...",
            category: "partnership",
            image: "https://via.placeholder.com/600x400/3B82F6/FFFFFF?text=Partnerships",
            published_at: "2024-01-12",
            author: "Business Development",
            readTime: "4 min read",
            featured: false
        },
        {
            id: 3,
            title: "Industry Trends: The Future of Digital Content Distribution",
            excerpt: "Exploring emerging trends in digital content distribution and how they're shaping the future of media consumption.",
            content: "Complete article content...",
            category: "industry",
            image: "https://via.placeholder.com/600x400/10B981/FFFFFF?text=Industry+Trends",
            published_at: "2024-01-10",
            author: "Industry Analysis",
            readTime: "7 min read",
            featured: false
        },
        {
            id: 4,
            title: "Creator Economy Reaches $104 Billion Globally",
            excerpt: "New research shows the creator economy continues to grow rapidly, with significant opportunities for content creators and distributors.",
            content: "Complete article content...",
            category: "industry",
            image: "https://via.placeholder.com/600x400/8B5CF6/FFFFFF?text=Creator+Economy",
            published_at: "2024-01-08",
            author: "Research Team",
            readTime: "6 min read",
            featured: false
        },
        {
            id: 5,
            title: "OSR Digital Launches New Content Strategy Services",
            excerpt: "Introducing comprehensive content strategy services to help creators maximize their reach and engagement across platforms.",
            content: "Complete article content...",
            category: "company",
            image: "https://via.placeholder.com/600x400/F59E0B/FFFFFF?text=New+Services",
            published_at: "2024-01-05",
            author: "Product Team",
            readTime: "3 min read",
            featured: false
        },
        {
            id: 6,
            title: "AI-Powered Content Recommendations Drive 40% More Engagement",
            excerpt: "Our latest AI implementation has resulted in significantly higher engagement rates across all content categories.",
            content: "Complete article content...",
            category: "technology",
            image: "https://via.placeholder.com/600x400/EF4444/FFFFFF?text=AI+Technology",
            published_at: "2024-01-03",
            author: "Tech Team",
            readTime: "5 min read",
            featured: false
        },
        {
            id: 7,
            title: "Mobile Content Consumption Surges 35% in Q4 2023",
            excerpt: "Latest data shows mobile devices now account for 78% of all digital content consumption, driving new distribution strategies.",
            content: "Complete article content...",
            category: "industry",
            image: "https://via.placeholder.com/600x400/06B6D4/FFFFFF?text=Mobile+Growth",
            published_at: "2024-01-01",
            author: "Analytics Team",
            readTime: "4 min read",
            featured: false
        },
        {
            id: 8,
            title: "OSR Digital Partners with Independent Film Festivals",
            excerpt: "New partnerships with major film festivals to discover and distribute award-winning independent content globally.",
            content: "Complete article content...",
            category: "partnership",
            image: "https://via.placeholder.com/600x400/84CC16/FFFFFF?text=Film+Festivals",
            published_at: "2023-12-28",
            author: "Partnership Team",
            readTime: "6 min read",
            featured: false
        },
        {
            id: 9,
            title: "Blockchain Technology Revolutionizes Content Rights Management",
            excerpt: "Innovative blockchain solutions are transforming how content rights are tracked and managed across distribution networks.",
            content: "Complete article content...",
            category: "technology",
            image: "https://via.placeholder.com/600x400/8B5CF6/FFFFFF?text=Blockchain",
            published_at: "2023-12-25",
            author: "Tech Innovation",
            readTime: "8 min read",
            featured: false
        },
        {
            id: 10,
            title: "OSR Digital Wins 'Best Content Distributor' Award 2023",
            excerpt: "We're honored to receive the prestigious 'Best Content Distributor' award for our innovative approach to global content distribution.",
            content: "Complete article content...",
            category: "company",
            image: "https://via.placeholder.com/600x400/F59E0B/FFFFFF?text=Award+2023",
            published_at: "2023-12-22",
            author: "OSR Team",
            readTime: "3 min read",
            featured: false
        },
        {
            id: 11,
            title: "Short-Form Content Drives 60% of Platform Engagement",
            excerpt: "Analysis reveals short-form content continues to dominate user engagement, with significant implications for content strategy.",
            content: "Complete article content...",
            category: "industry",
            image: "https://via.placeholder.com/600x400/EC4899/FFFFFF?text=Short+Form",
            published_at: "2023-12-20",
            author: "Content Strategy",
            readTime: "5 min read",
            featured: false
        },
        {
            id: 12,
            title: "New AI Tools Enhance Content Localization Process",
            excerpt: "Advanced AI-powered tools are making content localization faster and more accurate across multiple languages and cultures.",
            content: "Complete article content...",
            category: "technology",
            image: "https://via.placeholder.com/600x400/10B981/FFFFFF?text=AI+Localization",
            published_at: "2023-12-18",
            author: "AI Research",
            readTime: "7 min read",
            featured: false
        },
        {
            id: 13,
            title: "OSR Digital Expands into Asian Markets",
            excerpt: "Strategic expansion into key Asian markets brings our content distribution network to over 1 billion potential viewers.",
            content: "Complete article content...",
            category: "company",
            image: "https://via.placeholder.com/600x400/DC2626/FFFFFF?text=Asia+Expansion",
            published_at: "2023-12-15",
            author: "Global Expansion",
            readTime: "6 min read",
            featured: false
        },
        {
            id: 14,
            title: "Interactive Content Shows 200% Higher Engagement Rates",
            excerpt: "New research demonstrates that interactive content formats significantly outperform traditional passive content in user engagement.",
            content: "Complete article content...",
            category: "industry",
            image: "https://via.placeholder.com/600x400/7C3AED/FFFFFF?text=Interactive",
            published_at: "2023-12-12",
            author: "Engagement Research",
            readTime: "5 min read",
            featured: false
        },
        {
            id: 15,
            title: "OSR Digital Launches Creator Education Program",
            excerpt: "New educational initiative helps content creators understand distribution strategies and maximize their global reach.",
            content: "Complete article content...",
            category: "company",
            image: "https://via.placeholder.com/600x400/059669/FFFFFF?text=Education",
            published_at: "2023-12-10",
            author: "Education Team",
            readTime: "4 min read",
            featured: false
        }
    ];

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
                breadcrumbs={[
                    { label: 'Home', href: '/', icon: 'fas fa-home' },
                    { label: 'News' }
                ]}
            />

            {/* Category Filter */}
            <section className={`py-8 ${isDark ? 'bg-gray-800' : 'bg-gray-50'}`}>
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
                <section className={`py-16 md:py-24 ${isDark ? 'bg-gray-800' : 'bg-gray-50'}`}>
                    <div className="container-minimal">
                        {/* Featured Article Skeleton */}
                        <div className="mb-16">
                            <div className={`h-8 w-48 mb-6 rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                            <div className={`h-96 rounded-lg mb-6 ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                            <div className={`h-8 w-3/4 mb-4 rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                            <div className={`h-6 w-full mb-2 rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                            <div className={`h-6 w-2/3 rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                        </div>

                        {/* Articles Grid Skeleton */}
                        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                            {[1, 2, 3, 4, 5, 6].map((i) => (
                                <div key={i} className={`rounded-lg overflow-hidden ${isDark ? 'bg-gray-800' : 'bg-white'} shadow-sm border ${isDark ? 'border-gray-700' : 'border-gray-200'}`}>
                                    <div className={`h-48 ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                                    <div className="p-6">
                                        <div className={`h-4 w-20 mb-3 rounded-full ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                                        <div className={`h-6 w-full mb-3 rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                                        <div className={`h-4 w-full mb-2 rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                                        <div className={`h-4 w-3/4 mb-4 rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                                        <div className={`h-4 w-24 rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </section>
            )}

            {/* Error State */}
            {error && (
                <section className={`py-16 md:py-24 ${isDark ? 'bg-gray-800' : 'bg-gray-50'}`}>
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
                                        src={featuredArticle.featured_image ? `/storage/${featuredArticle.featured_image}` : 'https://via.placeholder.com/800x400/EC681D/FFFFFF?text=Featured+Article'}
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

                                    <h3 className={`text-3xl lg:text-4xl font-bold mb-4 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                        {featuredArticle.title}
                                    </h3>

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
                                        <button className={`flex items-center px-6 py-3 rounded-lg font-medium transition-all duration-200 ${
                                            isDark
                                                ? 'bg-brand-orange-500 text-white hover:bg-brand-orange-600'
                                                : 'bg-brand-orange-500 text-white hover:bg-brand-orange-600'
                                        }`}>
                                            Read More
                                            <FontAwesomeIcon icon={faArrowRight} className="ml-2" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            )}

            {/* Articles Grid */}
            {!loading && !error && (
            <section className={`py-16 md:py-24 ${isDark ? 'bg-gray-800' : 'bg-gray-50'}`}>
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
                                            src={article.featured_image ? `/storage/${article.featured_image}` : 'https://via.placeholder.com/400x300/EC681D/FFFFFF?text=News+Article'}
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

                                        <h3 className={`text-xl font-bold mb-3 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                            {article.title}
                                        </h3>

                                        <p className={`text-sm mb-4 ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                                            {article.excerpt}
                                        </p>

                                        <div className="flex items-center justify-between">
                                            <span className={`text-sm ${isDark ? 'text-gray-400' : 'text-gray-500'}`}>
                                                {Math.ceil(article.content?.split(' ').length / 200) || 5} min read
                                            </span>
                                            <button className={`flex items-center text-sm font-medium transition-colors ${
                                                isDark ? 'text-brand-orange-400 hover:text-brand-orange-300' : 'text-brand-orange-600 hover:text-brand-orange-700'
                                            }`}>
                                                Read More
                                                <FontAwesomeIcon icon={faArrowRight} className="ml-1" />
                                            </button>
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
                <section className={`py-8 ${isDark ? 'bg-gray-800' : 'bg-gray-50'}`}>
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
