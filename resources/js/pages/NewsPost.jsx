import React, { useState, useEffect } from "react";
import { useParams, useNavigate, Link } from "react-router-dom";
import { useTheme } from "../contexts/ThemeContext";
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import {
    faCalendarAlt,
    faUser,
    faClock,
    faShare,
    faArrowLeft,
    faTag,
    faBookOpen,
    faChartLine,
    faExternalLinkAlt,
    faChevronRight,
    faChevronLeft,
    faSpinner,
    faExclamationTriangle,
    faEnvelope
} from '@fortawesome/free-solid-svg-icons';
import {
    faFacebook,
    faTwitter,
    faLinkedin
} from '@fortawesome/free-brands-svg-icons';

function NewsPost() {
    const { slug } = useParams();
    const navigate = useNavigate();
    const { isDark } = useTheme();

    const [post, setPost] = useState(null);
    const [relatedPosts, setRelatedPosts] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [isImageLoaded, setIsImageLoaded] = useState(false);

    useEffect(() => {
        const fetchPost = async () => {
            try {
                setLoading(true);
                setError(null);

                const response = await fetch(`/api/news/${slug}`);
                if (!response.ok) {
                    if (response.status === 404) {
                        throw new Error('Article not found');
                    }
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                if (data.success) {
                    setPost(data.data);

                    // Update page title and meta description
                    document.title = `${data.data.title} - OSR Digital News`;
                    let metaDescription = document.querySelector('meta[name="description"]');
                    if (!metaDescription) {
                        metaDescription = document.createElement('meta');
                        metaDescription.name = 'description';
                        document.getElementsByTagName('head')[0].appendChild(metaDescription);
                    }
                    metaDescription.content = data.data.excerpt || `Read ${data.data.title} on OSR Digital News`;

                    // Fetch related posts
                    fetchRelatedPosts(data.data.category_id);
                } else {
                    throw new Error(data.message || 'Failed to fetch article');
                }
            } catch (err) {
                console.error('Error fetching news post:', err);
                setError(err.message);
                if (err.message === 'Article not found') {
                    // Redirect to news page after showing error briefly
                    setTimeout(() => navigate('/news'), 2000);
                }
            } finally {
                setLoading(false);
            }
        };

        if (slug) {
            fetchPost();
        }

        // Cleanup on unmount
        return () => {
            document.title = 'OSR Digital - Business Strategy & Digital Solutions';
        };
    }, [slug, navigate]);

    const fetchRelatedPosts = async (categoryId) => {
        try {
            const response = await fetch(`/api/news?category=${categoryId}&per_page=4`);
            if (response.ok) {
                const data = await response.json();
                if (data.success) {
                    // Filter out current post
                    const related = data.data.filter(item => item.slug !== slug);
                    setRelatedPosts(related.slice(0, 3));
                }
            }
        } catch (err) {
            console.error('Error fetching related posts:', err);
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

    const getReadingTime = (content) => {
        const wordsPerMinute = 200;
        const words = content?.replace(/<[^>]*>/g, '').split(' ').length || 0;
        const minutes = Math.ceil(words / wordsPerMinute);
        return minutes;
    };

    const shareArticle = (platform) => {
        const url = encodeURIComponent(window.location.href);
        const title = encodeURIComponent(post?.title || '');
        const text = encodeURIComponent(post?.excerpt || '');

        let shareUrl = '';
        switch (platform) {
            case 'facebook':
                shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                break;
            case 'twitter':
                shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
                break;
            case 'linkedin':
                shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`;
                break;
            default:
                return;
        }

        window.open(shareUrl, '_blank', 'width=600,height=400');
    };

    const copyToClipboard = async () => {
        try {
            await navigator.clipboard.writeText(window.location.href);
            // You might want to show a toast notification here
        } catch (err) {
            console.error('Failed to copy URL:', err);
        }
    };

    if (loading) {
        return (
            <div className={`min-h-screen ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                    {/* Header Skeleton */}
                    <div className="relative h-96 overflow-hidden">
                        <div className={`absolute inset-0 ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                        <div className="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div className="relative z-10 h-full flex items-end">
                            <div className="container mx-auto px-4 pb-12">
                                <div className="max-w-4xl">
                                    <div className={`h-4 w-32 mb-4 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                    <div className={`h-12 w-3/4 mb-4 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                    <div className={`h-6 w-1/2 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Content Skeleton */}
                    <div className="container mx-auto px-4 py-12">
                        <div className="max-w-4xl mx-auto">
                            <div className="grid grid-cols-1 lg:grid-cols-3 gap-12">
                                <div className="lg:col-span-2">
                                    {[1, 2, 3, 4, 5].map((i) => (
                                        <div key={i} className="mb-4">
                                            <div className={`h-4 w-full mb-2 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                            <div className={`h-4 w-5/6 mb-2 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                            <div className={`h-4 w-4/6 mb-4 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                        </div>
                                    ))}
                                </div>
                                <div className="lg:col-span-1">
                                    <div className={`h-64 w-full rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        );
    }

    if (error) {
        return (
            <div className={`min-h-screen flex items-center justify-center ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                    <div className="text-center">
                        <h1 className={`text-4xl font-bold mb-4 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                            {error === 'Article not found' ? '404' : 'Error'}
                        </h1>
                        <p className={`text-xl mb-8 ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                            {error === 'Article not found' ? 'Article not found' : 'Something went wrong'}
                        </p>
                        <Link
                            to="/news"
                            className="btn-minimal"
                        >
                            <FontAwesomeIcon icon={faArrowLeft} className="w-4 h-4 mr-2" />
                            Back to News
                        </Link>
                    </div>
                </div>
        );
    }

    if (!post) {
        return null;
    }

    return (
        <article className={`min-h-screen ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                {/* Hero Section */}
                <header className="relative h-96 md:h-[500px] overflow-hidden">
                    {post.featured_image_url ? (
                        <>
                            <img
                                src={post.featured_image_url}
                                alt={post.title}
                                className={`absolute inset-0 w-full h-full object-cover transition-opacity duration-500 ${
                                    isImageLoaded ? 'opacity-100' : 'opacity-0'
                                }`}
                                onLoad={() => setIsImageLoaded(true)}
                            />
                            {!isImageLoaded && (
                                <div className={`absolute inset-0 ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
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
                            to="/news"
                            className="inline-flex items-center text-white/90 hover:text-white transition-colors duration-200"
                        >
                            <FontAwesomeIcon icon={faArrowLeft} className="w-4 h-4 mr-2" />
                            Back to News
                        </Link>
                    </nav>

                    {/* Content */}
                    <div className="relative z-10 h-full flex items-end">
                        <div className="container mx-auto px-4 pb-12">
                            <div className="max-w-4xl">
                                {/* Category */}
                                {post.category && (
                                    <div className="mb-4">
                                        <span className="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white/20 backdrop-blur-sm text-white border border-white/30">
                                            <FontAwesomeIcon icon={faTag} className="w-3 h-3 mr-2" />
                                            {post.category.name}
                                        </span>
                                    </div>
                                )}

                                {/* Title */}
                                <h1 className="text-2xl md:text-3xl lg:text-4xl font-bold text-white mb-6 leading-tight">
                                    {post.title}
                                </h1>

                                {/* Meta Info */}
                                <div className="flex flex-wrap items-center gap-6 text-white bg-black/30 backdrop-blur-sm px-6 py-4 rounded-lg border border-white/20">
                                    {post.author_name && (
                                        <div className="flex items-center">
                                            <FontAwesomeIcon icon={faUser} className="w-4 h-4 mr-2 text-white/80" />
                                            <span className="text-sm font-medium">{post.author_name}</span>
                                        </div>
                                    )}
                                    <div className="flex items-center">
                                        <FontAwesomeIcon icon={faCalendarAlt} className="w-4 h-4 mr-2 text-white/80" />
                                        <time className="text-sm font-medium">{formatDate(post.published_at)}</time>
                                    </div>
                                    <div className="flex items-center">
                                        <FontAwesomeIcon icon={faClock} className="w-4 h-4 mr-2 text-white/80" />
                                        <span className="text-sm font-medium">{getReadingTime(post.content)} min read</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                {/* Main Content */}
                <main className="container mx-auto px-4 py-12">
                    <div className="max-w-4xl mx-auto">
                        <div className="grid grid-cols-1 lg:grid-cols-3 gap-12">
                            {/* Article Content */}
                            <div className="lg:col-span-2">
                                {/* Excerpt */}
                                {post.excerpt && (
                                    <div className={`text-xl leading-relaxed mb-8 pb-8 border-b ${
                                        isDark ? 'text-gray-300 border-gray-700' : 'text-gray-600 border-gray-200'
                                    }`}>
                                        {post.excerpt}
                                    </div>
                                )}

                                {/* Content */}
                                <div
                                    className={`news-content text-lg leading-relaxed ${
                                        isDark ? 'text-gray-300' : 'text-gray-700'
                                    }`}
                                    dangerouslySetInnerHTML={{ __html: post.content }}
                                />

                                {/* Tags */}
                                {post.tags && post.tags.length > 0 && (
                                    <div className="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700">
                                        <h3 className={`text-lg font-semibold mb-4 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                            Tags
                                        </h3>
                                        <div className="flex flex-wrap gap-2">
                                            {post.tags.map((tag, index) => (
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
                                    {/* Share */}
                                    <div className={`p-6 rounded-lg ${isDark ? 'bg-gray-800' : 'bg-gray-50'}`}>
                                        <h3 className={`text-lg font-semibold mb-4 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                            Share Article
                                        </h3>
                                        <div className="space-y-3">
                                            <button
                                                onClick={() => shareArticle('facebook')}
                                                className="w-full flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200"
                                            >
                                                <FontAwesomeIcon icon={faFacebook} className="w-4 h-4 mr-3" />
                                                Share on Facebook
                                            </button>
                                            <button
                                                onClick={() => shareArticle('twitter')}
                                                className="w-full flex items-center px-4 py-2 bg-sky-500 text-white rounded-lg hover:bg-sky-600 transition-colors duration-200"
                                            >
                                                <FontAwesomeIcon icon={faTwitter} className="w-4 h-4 mr-3" />
                                                Share on Twitter
                                            </button>
                                            <button
                                                onClick={() => shareArticle('linkedin')}
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

                                    {/* Related Posts */}
                                    {relatedPosts.length > 0 && (
                                        <div className={`p-6 rounded-lg ${isDark ? 'bg-gray-800' : 'bg-gray-50'}`}>
                                            <h3 className={`text-lg font-semibold mb-6 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                                Related Articles
                                            </h3>
                                            <div className="space-y-4">
                                                {relatedPosts.map((relatedPost) => (
                                                    <Link
                                                        key={relatedPost.id}
                                                        to={`/news/${relatedPost.slug}`}
                                                        className="group block"
                                                    >
                                                        <div className="flex gap-3">
                                                            {relatedPost.featured_image_url ? (
                                                                <img
                                                                    src={relatedPost.featured_image_url}
                                                                    alt={relatedPost.title}
                                                                    className="w-16 h-16 object-cover rounded-lg flex-shrink-0"
                                                                />
                                                            ) : (
                                                                <div className="w-16 h-16 bg-gradient-to-br from-brand-orange-500 to-brand-orange-700 rounded-lg flex-shrink-0"></div>
                                                            )}
                                                            <div className="flex-grow min-w-0">
                                                                <h4 className={`text-sm font-medium line-clamp-2 group-hover:text-brand-orange-600 transition-colors duration-200 ${
                                                                    isDark ? 'text-gray-300' : 'text-gray-700'
                                                                }`}>
                                                                    {relatedPost.title}
                                                                </h4>
                                                                <p className={`text-xs mt-1 ${isDark ? 'text-gray-400' : 'text-gray-500'}`}>
                                                                    {formatDate(relatedPost.published_at)}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </Link>
                                                ))}
                                            </div>
                                            <div className="mt-6">
                                                <Link
                                                    to="/news"
                                                    className="inline-flex items-center text-brand-orange-600 hover:text-brand-orange-700 font-medium text-sm transition-colors duration-200"
                                                >
                                                    View All Articles
                                                    <FontAwesomeIcon icon={faChevronRight} className="w-4 h-4 ml-1" />
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
                                to="/news"
                                className={`inline-flex items-center text-sm font-medium transition-colors duration-200 ${
                                    isDark
                                        ? 'text-gray-400 hover:text-white'
                                        : 'text-gray-600 hover:text-gray-900'
                                }`}
                            >
                                <FontAwesomeIcon icon={faChevronLeft} className="w-4 h-4 mr-2" />
                                Back to All Articles
                            </Link>

                            <div className="text-center">
                                <p className={`text-sm ${isDark ? 'text-gray-400' : 'text-gray-600'}`}>
                                    Published on {formatDate(post.published_at)}
                                </p>
                            </div>

                            <button
                                onClick={() => window.scrollTo({ top: 0, behavior: 'smooth' })}
                                className={`inline-flex items-center text-sm font-medium transition-colors duration-200 ${
                                    isDark
                                        ? 'text-gray-400 hover:text-white'
                                        : 'text-gray-600 hover:text-gray-900'
                                }`}
                            >
                                Back to Top
                                <FontAwesomeIcon icon={faChevronRight} className="w-4 h-4 ml-2 rotate-[-90deg]" />
                            </button>
                        </div>
                    </div>
                </footer>
            </article>
    );
}

export default NewsPost;
