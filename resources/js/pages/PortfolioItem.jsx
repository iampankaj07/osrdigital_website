import React from 'react';
import { useState, useEffect } from 'react';
import { useParams, Link, useNavigate } from 'react-router-dom';
import { useTheme } from '../contexts/ThemeContext';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import {
    faArrowLeft,
    faCalendarAlt,
    faEye,
    faTag,
    faShare,
    faPlay,
    faClock,
    faUser
} from '@fortawesome/free-solid-svg-icons';
import {
    faFacebook,
    faTwitter,
    faLinkedin
} from '@fortawesome/free-brands-svg-icons';

function PortfolioItem() {
    const { slug } = useParams();
    const navigate = useNavigate();
    const { isDark } = useTheme();
    const [item, setItem] = useState(null);
    const [relatedItems, setRelatedItems] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [isImageLoaded, setIsImageLoaded] = useState(false);

    useEffect(() => {
        const fetchPortfolioItem = async () => {
            try {
                setLoading(true);
                setError(null);

                const response = await fetch(`/api/portfolio/${slug}`);
                if (!response.ok) {
                    throw new Error('Portfolio item not found');
                }

                const data = await response.json();
                setItem(data);

                // Update document title
                if (data.title) {
                    document.title = `${data.title} - OSR Digital`;
                }

                // Fetch related items from the same category
                if (data.category_id) {
                    await fetchRelatedItems(data.category_id, data.id);
                }
            } catch (err) {
                setError(err.message);
                console.error('Error fetching portfolio item:', err);
            } finally {
                setLoading(false);
            }
        };

        fetchPortfolioItem();
    }, [slug]);

    const fetchRelatedItems = async (categoryId, currentItemId) => {
        try {
            const response = await fetch(`/api/film-portfolios?category=${categoryId}&per_page=4`);
            if (response.ok) {
                const result = await response.json();
                if (result.success) {
                    // Filter out current item
                    const related = result.data.filter(item => item.id !== currentItemId);
                    setRelatedItems(related.slice(0, 3));
                }
            }
        } catch (err) {
            console.error('Error fetching related items:', err);
        }
    };

    const formatDate = (dateString) => {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    };

    const shareItem = (platform) => {
        const url = window.location.href;
        const text = item.title;

        switch (platform) {
            case 'facebook':
                window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`, '_blank');
                break;
            case 'twitter':
                window.open(`https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(url)}`, '_blank');
                break;
            case 'linkedin':
                window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`, '_blank');
                break;
        }
    };

    const copyToClipboard = () => {
        navigator.clipboard.writeText(window.location.href).then(() => {
            alert('Link copied to clipboard!');
        });
    };

    if (loading) {
        return (
            <div className={`min-h-screen transition-colors duration-300 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                {/* Hero Skeleton */}
                <div className="relative h-96 md:h-[500px] overflow-hidden">
                    <div className={`absolute inset-0 ${isDark ? 'bg-gray-800' : 'bg-gray-200'} animate-pulse`}></div>

                    {/* Navigation Skeleton */}
                    <nav className="relative z-20 p-4">
                        <div className={`h-4 w-24 ${isDark ? 'bg-gray-700' : 'bg-gray-300'} rounded animate-pulse`}></div>
                    </nav>

                    {/* Content Skeleton */}
                    <div className="absolute bottom-0 left-0 right-0 p-8">
                        <div className="container mx-auto">
                            <div className="max-w-4xl">
                                <div className={`h-8 w-32 mb-4 ${isDark ? 'bg-gray-700' : 'bg-gray-300'} rounded animate-pulse`}></div>
                                <div className={`h-12 w-3/4 mb-6 ${isDark ? 'bg-gray-700' : 'bg-gray-300'} rounded animate-pulse`}></div>
                                <div className={`h-6 w-1/2 ${isDark ? 'bg-gray-700' : 'bg-gray-300'} rounded animate-pulse`}></div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Content Skeleton */}
                <div className="container mx-auto px-4 py-12">
                    <div className="max-w-4xl mx-auto">
                        <div className="grid grid-cols-1 lg:grid-cols-3 gap-12">
                            <div className="lg:col-span-2 space-y-6">
                                {[1, 2, 3, 4, 5].map((i) => (
                                    <div key={i} className={`h-4 w-full ${isDark ? 'bg-gray-800' : 'bg-gray-200'} rounded animate-pulse`}></div>
                                ))}
                            </div>
                            <div className="lg:col-span-1">
                                <div className={`h-64 ${isDark ? 'bg-gray-800' : 'bg-gray-200'} rounded-lg animate-pulse`}></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }

    if (error) {
        return (
            <div className={`min-h-screen transition-colors duration-300 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                <div className="container mx-auto px-4 py-20 text-center">
                    <h1 className={`text-4xl font-bold mb-4 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                        Portfolio Item Not Found
                    </h1>
                    <p className={`mb-8 ${isDark ? 'text-gray-400' : 'text-gray-600'}`}>
                        The portfolio item you're looking for doesn't exist.
                    </p>
                    <Link
                        to="/portfolio"
                        className="bg-brand-orange-500 hover:bg-brand-orange-600 text-white px-6 py-3 rounded-lg font-medium transition-colors"
                    >
                        Back to Portfolio
                    </Link>
                </div>
            </div>
        );
    }

    return (
        <article className={`min-h-screen transition-colors duration-300 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
            {/* Hero Section */}
            <header className="relative h-96 md:h-[500px] overflow-hidden">
                {item.image_url ? (
                    <>
                        <img
                            src={item.image_url}
                            alt={item.title}
                            className={`absolute inset-0 w-full h-full object-cover transition-opacity duration-500 ${
                                isImageLoaded ? 'opacity-100' : 'opacity-0'
                            }`}
                            onLoad={() => setIsImageLoaded(true)}
                        />
                        {!isImageLoaded && (
                            <div className={`absolute inset-0 ${isDark ? 'bg-gray-800' : 'bg-gray-200'} animate-pulse`}></div>
                        )}
                    </>
                ) : (
                    <div className="absolute inset-0 bg-gradient-to-br from-brand-orange-500 to-brand-orange-700"></div>
                )}

                {/* Dark overlay */}
                <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/20"></div>

                {/* Navigation */}
                <nav className="relative z-20 p-4">
                    <Link
                        to="/portfolio"
                        className="inline-flex items-center text-white/90 hover:text-white transition-colors duration-200"
                    >
                        <FontAwesomeIcon icon={faArrowLeft} className="w-4 h-4 mr-2" />
                        Back to Portfolio
                    </Link>
                </nav>

                {/* Content */}
                <div className="relative z-10 h-full flex items-end">
                    <div className="container mx-auto px-4 pb-12">
                        <div className="max-w-4xl">
                            {/* Category & Type */}
                            {item.category && (
                                <div className="mb-4">
                                    <span className="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white/20 backdrop-blur-sm text-white border border-white/30">
                                        <FontAwesomeIcon icon={faTag} className="w-3 h-3 mr-2" />
                                        {item.category.name || item.category}
                                    </span>
                                </div>
                            )}

                            {/* Title */}
                            <h1 className="text-2xl md:text-3xl lg:text-4xl font-bold text-white mb-6 leading-tight">
                                {item.title}
                            </h1>

                            {/* Meta Info */}
                            <div className="flex flex-wrap items-center gap-6 text-white bg-black/30 backdrop-blur-sm px-6 py-4 rounded-lg border border-white/20">
                                {item.release_year && (
                                    <div className="flex items-center">
                                        <FontAwesomeIcon icon={faCalendarAlt} className="w-4 h-4 mr-2 text-white/80" />
                                        <span className="text-sm font-medium">{item.release_year}</span>
                                    </div>
                                )}
                                {item.views && (
                                    <div className="flex items-center">
                                        <FontAwesomeIcon icon={faEye} className="w-4 h-4 mr-2 text-white/80" />
                                        <span className="text-sm font-medium">{Number(item.views).toLocaleString()} views</span>
                                    </div>
                                )}
                                {item.type && (
                                    <div className="flex items-center">
                                        <span className="text-sm font-medium">{item.type}</span>
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {/* Main Content */}
            <main className="container mx-auto px-4 py-12">
                <div className="max-w-4xl mx-auto">
                    <div className="grid grid-cols-1 lg:grid-cols-3 gap-12">
                        {/* Main Content */}
                        <div className="lg:col-span-2">
                            {/* Video/Media Section */}
                            {item.video_url && (
                                <div className="relative aspect-video rounded-xl overflow-hidden mb-8 shadow-2xl">
                                    <iframe
                                        src={item.video_url}
                                        title={item.title}
                                        className="w-full h-full"
                                        allowFullScreen
                                    ></iframe>
                                </div>
                            )}

                            {/* Description */}
                            {item.description && (
                                <div className={`text-xl leading-relaxed mb-8 pb-8 border-b ${
                                    isDark ? 'text-gray-300 border-gray-700' : 'text-gray-600 border-gray-200'
                                }`}>
                                    {item.description}
                                </div>
                            )}

                            {/* Extended content if available */}
                            {item.content && (
                                <div
                                    className={`text-lg leading-relaxed mb-8 ${
                                        isDark ? 'text-gray-300' : 'text-gray-700'
                                    }`}
                                    dangerouslySetInnerHTML={{ __html: item.content }}
                                />
                            )}

                            {/* Additional metadata from JSON */}
                            {item.metadata && Object.keys(item.metadata).length > 0 && (
                                <div className={`rounded-lg p-6 mb-8 ${isDark ? 'bg-gray-800' : 'bg-gray-50'}`}>
                                    <h3 className={`text-lg font-semibold mb-4 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                        Production Details
                                    </h3>
                                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                        {Object.entries(item.metadata).map(([key, value]) => (
                                            <div key={key} className="flex justify-between">
                                                <span className={`capitalize font-medium ${isDark ? 'text-gray-400' : 'text-gray-600'}`}>
                                                    {key.replace('_', ' ')}:
                                                </span>
                                                <span className={`${isDark ? 'text-white' : 'text-gray-900'}`}>{value}</span>
                                            </div>
                                        ))}
                                    </div>
                                </div>
                            )}

                            {/* Tags */}
                            {item.tags && item.tags.length > 0 && (
                                <div className={`pt-8 border-t ${isDark ? 'border-gray-700' : 'border-gray-200'}`}>
                                    <h3 className={`text-lg font-semibold mb-4 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                        Tags
                                    </h3>
                                    <div className="flex flex-wrap gap-2">
                                        {item.tags.map((tag, index) => (
                                            <span
                                                key={index}
                                                className={`px-3 py-1 text-sm rounded-full ${
                                                    isDark
                                                        ? 'bg-gray-800 text-gray-300 border border-gray-700'
                                                        : 'bg-gray-100 text-gray-700 border border-gray-200'
                                                }`}
                                            >
                                                #{tag}
                                            </span>
                                        ))}
                                    </div>
                                </div>
                            )}
                        </div>

                        {/* Sidebar */}
                        <aside className="lg:col-span-1">
                            <div className="sticky top-8 space-y-8">
                                {/* Action Buttons */}
                                {item.video_url && (
                                    <div className={`p-6 rounded-lg ${isDark ? 'bg-gray-800' : 'bg-gray-50'}`}>
                                        <button
                                            onClick={() => window.open(item.video_url, '_blank')}
                                            className="w-full bg-brand-orange-500 hover:bg-brand-orange-600 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center justify-center gap-2"
                                        >
                                            <FontAwesomeIcon icon={faPlay} className="w-4 h-4" />
                                            Watch Now
                                        </button>
                                    </div>
                                )}

                                {/* Share */}
                                <div className={`p-6 rounded-lg ${isDark ? 'bg-gray-800' : 'bg-gray-50'}`}>
                                    <h3 className={`text-lg font-semibold mb-4 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                        Share Film
                                    </h3>
                                    <div className="space-y-3">
                                        <button
                                            onClick={() => shareItem('facebook')}
                                            className="w-full flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200"
                                        >
                                            <FontAwesomeIcon icon={faFacebook} className="w-4 h-4 mr-3" />
                                            Share on Facebook
                                        </button>
                                        <button
                                            onClick={() => shareItem('twitter')}
                                            className="w-full flex items-center px-4 py-2 bg-sky-500 text-white rounded-lg hover:bg-sky-600 transition-colors duration-200"
                                        >
                                            <FontAwesomeIcon icon={faTwitter} className="w-4 h-4 mr-3" />
                                            Share on Twitter
                                        </button>
                                        <button
                                            onClick={() => shareItem('linkedin')}
                                            className="w-full flex items-center px-4 py-2 bg-blue-700 text-white rounded-lg hover:bg-blue-800 transition-colors duration-200"
                                        >
                                            <FontAwesomeIcon icon={faLinkedin} className="w-4 h-4 mr-3" />
                                            Share on LinkedIn
                                        </button>
                                        <button
                                            onClick={copyToClipboard}
                                            className={`w-full flex items-center px-4 py-2 rounded-lg transition-colors duration-200 ${
                                                isDark
                                                    ? 'bg-gray-700 text-gray-300 hover:bg-gray-600'
                                                    : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                                            }`}
                                        >
                                            <FontAwesomeIcon icon={faShare} className="w-4 h-4 mr-3" />
                                            Copy Link
                                        </button>
                                    </div>
                                </div>

                                {/* Related Films */}
                                {relatedItems.length > 0 && (
                                    <div className={`p-6 rounded-lg ${isDark ? 'bg-gray-800' : 'bg-gray-50'}`}>
                                        <h3 className={`text-lg font-semibold mb-6 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                            Related Films
                                        </h3>
                                        <div className="space-y-4">
                                            {relatedItems.map((relatedItem) => (
                                                <Link
                                                    key={relatedItem.id}
                                                    to={`/portfolio/${relatedItem.slug}`}
                                                    className="group block"
                                                >
                                                    <div className="flex gap-3">
                                                        {relatedItem.image_url ? (
                                                            <img
                                                                src={relatedItem.image_url}
                                                                alt={relatedItem.title}
                                                                className="w-16 h-16 object-cover rounded-lg flex-shrink-0"
                                                            />
                                                        ) : (
                                                            <div className={`w-16 h-16 rounded-lg flex-shrink-0 flex items-center justify-center ${
                                                                isDark ? 'bg-gray-700' : 'bg-gray-200'
                                                            }`}>
                                                                <FontAwesomeIcon
                                                                    icon={faPlay}
                                                                    className={`w-6 h-6 ${isDark ? 'text-gray-500' : 'text-gray-400'}`}
                                                                />
                                                            </div>
                                                        )}
                                                        <div className="flex-1 min-w-0">
                                                            <p className={`text-sm font-medium transition-colors group-hover:text-brand-orange-600 ${
                                                                isDark ? 'text-white' : 'text-gray-900'
                                                            }`}>
                                                                {relatedItem.title}
                                                            </p>
                                                            <p className={`text-xs mt-1 ${isDark ? 'text-gray-400' : 'text-gray-500'}`}>
                                                                {relatedItem.category?.name || relatedItem.type}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </Link>
                                            ))}
                                        </div>
                                        <div className="mt-6">
                                            <Link
                                                to="/portfolio"
                                                className="inline-flex items-center text-brand-orange-600 hover:text-brand-orange-700 font-medium text-sm transition-colors duration-200"
                                            >
                                                View All Films
                                                <FontAwesomeIcon icon={faArrowLeft} className="w-4 h-4 ml-1 rotate-180" />
                                            </Link>
                                        </div>
                                    </div>
                                )}
                            </div>
                        </aside>
                    </div>
                </div>
            </main>

            {/* Navigation Footer */}
            <footer className={`border-t ${isDark ? 'border-gray-800 bg-gray-900' : 'border-gray-200 bg-gray-50'}`}>
                <div className="container mx-auto px-4 py-8">
                    <div className="flex flex-col md:flex-row justify-between items-center gap-4">
                        <Link
                            to="/portfolio"
                            className={`inline-flex items-center transition-colors duration-200 ${
                                isDark ? 'text-gray-400 hover:text-white' : 'text-gray-600 hover:text-gray-900'
                            }`}
                        >
                            <FontAwesomeIcon icon={faArrowLeft} className="w-4 h-4 mr-2" />
                            Back to Portfolio
                        </Link>
                        <div className={`text-sm ${isDark ? 'text-gray-500' : 'text-gray-500'}`}>
                            Share this film with your network
                        </div>
                    </div>
                </div>
            </footer>
        </article>
    );
}

export default PortfolioItem;
