import React from 'react';
import { useState, useEffect } from 'react';
import { useParams, Link, useNavigate } from 'react-router-dom';

function PortfolioItem() {
    const { slug } = useParams();
    const navigate = useNavigate();
    const [item, setItem] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        fetch(`/api/portfolio/${slug}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Portfolio item not found');
                }
                return response.json();
            })
            .then(data => {
                setItem(data);
                setLoading(false);
            })
            .catch(error => {
                setError(error.message);
                setLoading(false);
            });
    }, [slug]);

    if (loading) {
        return (
            <div className="min-h-screen bg-gray-900 pt-20">
                <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                    {/* Header Skeleton */}
                    <div className="mb-8">
                        <div className="h-4 w-32 bg-gray-700 rounded mb-4 animate-pulse"></div>
                        <div className="h-12 w-3/4 bg-gray-700 rounded mb-6 animate-pulse"></div>
                    </div>

                    <div className="grid md:grid-cols-2 gap-12">
                        {/* Image Skeleton */}
                        <div className="h-96 bg-gray-700 rounded-lg animate-pulse"></div>

                        {/* Content Skeleton */}
                        <div className="space-y-6">
                            <div>
                                <div className="h-6 w-20 bg-gray-700 rounded mb-2 animate-pulse"></div>
                                <div className="h-4 w-32 bg-gray-700 rounded animate-pulse"></div>
                            </div>

                            <div>
                                <div className="h-6 w-24 bg-gray-700 rounded mb-2 animate-pulse"></div>
                                <div className="h-4 w-28 bg-gray-700 rounded animate-pulse"></div>
                            </div>

                            <div>
                                <div className="h-6 w-28 bg-gray-700 rounded mb-2 animate-pulse"></div>
                                <div className="h-4 w-full bg-gray-700 rounded mb-2 animate-pulse"></div>
                                <div className="h-4 w-3/4 bg-gray-700 rounded mb-2 animate-pulse"></div>
                                <div className="h-4 w-1/2 bg-gray-700 rounded animate-pulse"></div>
                            </div>

                            <div className="flex space-x-4 pt-6">
                                <div className="h-12 w-32 bg-gray-700 rounded-lg animate-pulse"></div>
                                <div className="h-12 w-24 bg-gray-700 rounded-lg animate-pulse"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }

    if (error) {
        return (
            <div className="min-h-screen bg-gray-900 pt-20">
                <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
                    <h1 className="text-4xl font-bold text-white mb-4">Portfolio Item Not Found</h1>
                    <p className="text-gray-400 mb-8">The portfolio item you're looking for doesn't exist.</p>
                    <Link
                        to="/portfolio"
                        className="text-white px-6 py-3 rounded-lg font-medium transition-colors"
                        style={{ backgroundColor: '#ff6b35' }}
                        onMouseEnter={(e) => e.target.style.backgroundColor = '#d35a15'}
                        onMouseLeave={(e) => e.target.style.backgroundColor = '#ff6b35'}
                    >
                        Back to Portfolio
                    </Link>
                </div>
            </div>
        );
    }

    return (
        <div className="min-h-screen bg-gray-900 pt-20">
            {/* Breadcrumb */}
            <div className="bg-gray-800 py-4">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <nav className="flex" aria-label="Breadcrumb">
                        <ol className="flex items-center space-x-4">
                            <li>
                                <Link to="/" className="text-gray-400 hover:text-white transition-colors">
                                    Home
                                </Link>
                            </li>
                            <li>
                                <svg className="flex-shrink-0 h-5 w-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fillRule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clipRule="evenodd" />
                                </svg>
                            </li>
                            <li>
                                <Link to="/portfolio" className="text-gray-400 hover:text-white transition-colors">
                                    Portfolio
                                </Link>
                            </li>
                            <li>
                                <svg className="flex-shrink-0 h-5 w-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fillRule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clipRule="evenodd" />
                                </svg>
                            </li>
                            <li>
                                <span className="text-gray-300">{item.title}</span>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>

            {/* Content */}
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div className="grid lg:grid-cols-2 gap-12">
                    {/* Media */}
                    <div>
                        <div className="relative aspect-video bg-gray-800 rounded-lg overflow-hidden mb-6">
                            {item.video_url ? (
                                <iframe
                                    src={item.video_url}
                                    title={item.title}
                                    className="w-full h-full"
                                    allowFullScreen
                                ></iframe>
                            ) : (
                                <img
                                    src={item.image_url}
                                    alt={item.title}
                                    className="w-full h-full object-cover"
                                />
                            )}
                        </div>

                        {/* Additional metadata from JSON */}
                        {item.metadata && (
                            <div className="bg-gray-800 rounded-lg p-6">
                                <h3 className="text-lg font-semibold text-white mb-4">Additional Information</h3>
                                <div className="grid grid-cols-2 gap-4 text-sm">
                                    {Object.entries(item.metadata).map(([key, value]) => (
                                        <div key={key}>
                                            <span className="text-gray-400 capitalize">{key.replace('_', ' ')}:</span>
                                            <span className="text-white ml-2">{value}</span>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        )}
                    </div>

                    {/* Details */}
                    <div>
                        <div className="mb-6">
                            <div className="flex items-center gap-4 mb-4">
                                <span className="text-white px-3 py-1 rounded-full text-sm font-medium" style={{ backgroundColor: '#ff6b35' }}>
                                    {item.type}
                                </span>
                                <span className="text-gray-400">
                                    {Number(item.views).toLocaleString()} views
                                </span>
                            </div>

                            <h1 className="text-4xl font-bold text-white mb-4">{item.title}</h1>

                            <p className="text-gray-300 text-lg leading-relaxed mb-6">
                                {item.description}
                            </p>

                            {item.category && (
                                <div className="mb-6">
                                    <span className="text-gray-400">Category: </span>
                                    <span className="text-white">{item.category}</span>
                                </div>
                            )}
                        </div>

                        {/* Action Buttons */}
                        <div className="space-y-4">
                            {item.video_url && (
                                <button
                                    onClick={() => window.open(item.video_url, '_blank')}
                                    className="w-full text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center justify-center gap-2"
                                    style={{ backgroundColor: '#ff6b35' }}
                                    onMouseEnter={(e) => e.target.style.backgroundColor = '#d35a15'}
                                    onMouseLeave={(e) => e.target.style.backgroundColor = '#ff6b35'}
                                >
                                    <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                    Watch Now
                                </button>
                            )}

                            <button
                                onClick={() => window.history.back()}
                                className="w-full bg-gray-700 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-medium transition-colors"
                            >
                                Back to Portfolio
                            </button>
                        </div>

                        {/* Share */}
                        <div className="mt-8 pt-8 border-t border-gray-700">
                            <h3 className="text-lg font-semibold text-white mb-4">Share</h3>
                            <div className="flex space-x-4">
                                <button
                                    onClick={() => {
                                        if (navigator.share) {
                                            navigator.share({
                                                title: item.title,
                                                text: item.description,
                                                url: window.location.href
                                            });
                                        } else {
                                            navigator.clipboard.writeText(window.location.href);
                                            alert('Link copied to clipboard!');
                                        }
                                    }}
                                    className="bg-gray-700 hover:bg-gray-600 p-3 rounded-lg transition-colors"
                                >
                                    <svg className="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z" />
                                    </svg>
                                </button>
                                <button
                                    onClick={() => window.open(`https://twitter.com/intent/tweet?text=${encodeURIComponent(item.title)}&url=${encodeURIComponent(window.location.href)}`, '_blank')}
                                    className="bg-blue-600 hover:bg-blue-700 p-3 rounded-lg transition-colors"
                                >
                                    <svg className="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default PortfolioItem;
