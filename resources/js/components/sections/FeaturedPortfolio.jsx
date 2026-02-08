import React, { useMemo, useCallback, useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { useTheme } from '../../contexts/ThemeContext';

// Movie Card Component - Memoized for performance
const MovieCard = React.memo(({ movie, isDark, isExternalLink, linkUrl }) => {
    const [imageLoaded, setImageLoaded] = useState(false);
    const [imageError, setImageError] = useState(false);

    const handleImageLoad = useCallback(() => {
        setImageLoaded(true);
    }, []);

    const handleImageError = useCallback(() => {
        setImageError(true);
    }, []);

    const CardContent = () => (
        <div className={`block group rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 ${isDark ? 'bg-gray-800' : 'bg-white'}`}>
            {/* Movie Poster */}
            <div className="relative overflow-hidden movie-poster bg-gradient-to-br from-gray-300 to-gray-400 dark:from-gray-700 dark:to-gray-800">
                {!imageError && movie.image_url && (
                    <>
                        {!imageLoaded && (
                            <div className="absolute inset-0 bg-gray-300 dark:bg-gray-700 animate-pulse" />
                        )}
                        <img
                            src={movie.image_url}
                            alt={movie.title}
                            loading="lazy"
                            className={`w-full h-80 object-cover group-hover:scale-110 transition-transform duration-500 ${imageLoaded ? 'opacity-100' : 'opacity-0'
                                }`}
                            onLoad={handleImageLoad}
                            onError={handleImageError}
                        />
                    </>
                )}

                {imageError || !movie.image_url && (
                    <div className={`flex absolute inset-0 items-center justify-center ${isDark ? 'bg-gray-700' : 'bg-gray-200'}`}>
                        <div className={`text-center ${isDark ? 'text-gray-400' : 'text-gray-500'}`}>
                            <svg className="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m-9 0h10m-10 0a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2M9 12h6m-6 4h6" />
                            </svg>
                            <p className="text-sm">{movie.title}</p>
                        </div>
                    </div>
                )}

                {/* Overlay */}
                <div className="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                    <span className="bg-brand-orange-500 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform translate-y-4 group-hover:translate-y-0 pointer-events-none">
                        {isExternalLink ? 'Visit Link' : 'View Details'}
                    </span>
                </div>

                {/* Rating Badge */}
                {movie.rating && (
                    <div className="absolute top-4 right-4 bg-brand-orange-500 text-white px-3 py-1 rounded-full text-sm font-semibold shadow-lg">
                        {movie.rating}/10
                    </div>
                )}
            </div>

            {/* Movie Info */}
            <div className="p-6">
                <div className="flex items-center justify-between mb-2">
                    <span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium text-white" style={{ backgroundColor: movie.category?.color || '#6B7280' }}>
                        {movie.category?.name || 'Uncategorized'}
                    </span>
                    <span className="text-gray-500 dark:text-gray-400 text-sm">{movie.year || 'N/A'}</span>
                </div>

                <div className="mb-2">
                    <span className="text-brand-orange-500 font-semibold text-sm uppercase tracking-wide">
                        {movie.genre || 'Drama'}
                    </span>
                </div>

                <h3 className={`text-lg font-bold mb-3 group-hover:text-brand-orange-600 dark:group-hover:text-brand-orange-400 transition-colors duration-300 line-clamp-2 ${isDark ? 'text-white' : 'text-gray-900'
                    }`}>
                    {movie.title}
                </h3>

                <p className={`mb-4 line-clamp-2 text-sm ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                    {movie.description || 'No description available'}
                </p>

                <div className="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                    <span>{movie.duration ? `${movie.duration}` : ''}</span>
                    {movie.rating && (
                        <div className="flex items-center">
                            <svg className="w-3.5 h-3.5 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <span>{movie.rating}/10</span>
                        </div>
                    )}
                </div>
            </div>
        </div>
    );

    return isExternalLink ? (
        <a
            href={linkUrl}
            target="_blank"
            rel="noopener noreferrer"
            className="block"
            aria-label={`Visit ${movie.title}`}
        >
            <CardContent />
        </a>
    ) : (
        <Link
            to={linkUrl}
            className="block"
            aria-label={`View details for ${movie.title}`}
        >
            <CardContent />
        </Link>
    );
});

MovieCard.displayName = 'MovieCard';

function FeaturedPortfolio() {
    const { isDark } = useTheme();
    const [movies, setMovies] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchMovies = async () => {
            try {
                setLoading(true);
                const response = await fetch('/api/film-portfolios?limit=999');
                const data = await response.json();

                if (data.success) {
                    setMovies(data.data);
                } else {
                    setError('Failed to load movies');
                }
            } catch (err) {
                setError('Failed to load movies');
                console.error('Error fetching movies:', err);
            } finally {
                setLoading(false);
            }
        };

        fetchMovies();
    }, []);

    // Show only first 6 movies
    const featuredMovies = useMemo(() => {
        return movies.slice(0, 6);
    }, [movies]);

    if (loading) {
        return (
            <section className={`py-20 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                <div className="container-minimal">
                    <div className="text-center mb-16">
                        <div className={`h-12 w-64 mx-auto mb-6 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                        <div className={`h-6 w-96 mx-auto rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                    </div>

                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        {[1, 2, 3, 4, 5, 6].map((i) => (
                            <div key={i} className={`rounded-2xl overflow-hidden ${isDark ? 'bg-gray-800' : 'bg-gray-50'}`}>
                                <div className={`w-full h-80 rounded-t-2xl ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                <div className="p-6">
                                    <div className={`h-6 w-20 mb-3 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                    <div className={`h-6 w-3/4 mb-3 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                    <div className={`h-4 w-full mb-2 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                    <div className={`h-4 w-2/3 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </section>
        );
    }

    if (error || movies.length === 0) {
        return (
            <section className={`py-20 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                <div className="container-minimal">
                    <div className="text-center">
                        <i className="fas fa-video text-4xl mb-4" style={{ color: '#EC681D' }}></i>
                        <p className={`text-lg ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                            {error || 'No movies available at the moment'}
                        </p>
                    </div>
                </div>
            </section>
        );
    }

    return (
        <section className={`py-20 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
            <div className="container-minimal">
                {/* Header */}
                <div className="text-center mb-16">
                    <h2 className={`text-4xl md:text-5xl font-bold mb-6 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                        Featured Films & Content
                    </h2>
                    <p className={`text-xl max-w-3xl mx-auto ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                        Explore our curated selection of exceptional movies, music, and short films from talented creators worldwide
                    </p>
                </div>

                {/* Movies Grid - 6 Featured */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                    {featuredMovies.map((movie, index) => (
                        <div
                            key={movie.id || index}
                            className="transform transition-all duration-1000"
                            style={{ transitionDelay: `${index * 100}ms` }}
                        >
                            <MovieCard
                                movie={movie}
                                isDark={isDark}
                                isExternalLink={movie.external_link && movie.external_link !== ''}
                                linkUrl={movie.external_link && movie.external_link !== '' ? movie.external_link : `/portfolio/${movie.id}`}
                            />
                        </div>
                    ))}
                </div>

                {/* View All Button */}
                <div className="text-center">
                    <Link
                        to="/portfolio"
                        className={`inline-flex items-center px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-300 group ${isDark
                                ? 'bg-gradient-to-r from-brand-orange-600 to-brand-orange-500 hover:from-brand-orange-500 hover:to-brand-orange-400 text-white'
                                : 'bg-gradient-to-r from-brand-orange-500 to-brand-orange-600 hover:from-brand-orange-600 hover:to-brand-orange-700 text-white'
                            } shadow-lg hover:shadow-2xl hover:-translate-y-1`}
                    >
                        <span>View All Films</span>
                        <svg className="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </Link>
                </div>

                {/* Film Count */}
                <div className="text-center mt-8">
                    <p className={`text-sm ${isDark ? 'text-gray-400' : 'text-gray-500'}`}>
                        Showing 6 of {movies.length} films
                    </p>
                </div>
            </div>
        </section>
    );
}

export default FeaturedPortfolio;
