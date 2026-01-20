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

function MoviePortfolio() {
    const { isDark } = useTheme();
    const [activeFilter, setActiveFilter] = useState('all');
    const [movies, setMovies] = useState([]);
    const [categories, setCategories] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const gridRef = React.useRef(null);


    useEffect(() => {
        const fetchData = async () => {
            try {
                setLoading(true);
                const [categoriesResponse, filmsResponse] = await Promise.all([
                    fetch('/api/film-categories'),
                    fetch('/api/film-portfolios?limit=999')
                ]);

                const categoriesData = await categoriesResponse.json();
                const filmsData = await filmsResponse.json();

                if (categoriesData.success && filmsData.success) {
                    const allCategories = [
                        { id: 'all', name: 'All Films', slug: 'all', color: '#6B7280' },
                        ...categoriesData.data
                    ];
                    setCategories(allCategories);
                    setMovies(filmsData.data);
                } else {
                    setError('Failed to load portfolio data');
                }
            } catch (err) {
                setError('Failed to load portfolio data');
                console.error('Error fetching portfolio data:', err);
            } finally {
                setLoading(false);
            }
        };

        fetchData();
    }, []);

    // Memoized filter handler
    const handleFilterChange = useCallback((filterId) => {
        setActiveFilter(filterId.toString());
    }, []);

    // Memoized filtered movies
    const filteredMovies = useMemo(() => {
        return movies.filter(movie => {
            if (activeFilter === 'all') return true;
            return movie.category_id === parseInt(activeFilter);
        });
    }, [movies, activeFilter]);

    // Scroll to grid when filter changes
    useEffect(() => {
        if (gridRef.current) {
            const gridTop = gridRef.current.offsetTop - 80;
            window.scrollTo({
                top: gridTop,
                behavior: 'smooth'
            });
        }
    }, [activeFilter]);

    if (loading) {
        return (
            <section className={`py-20 ${isDark ? 'bg-gray-900' : 'bg-gray-50'}`}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center mb-16">
                        <div className={`h-12 w-64 mx-auto mb-6 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-ultra-fast`}></div>
                        <div className={`h-6 w-96 mx-auto mb-8 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-ultra-fast`}></div>
                        <div className="flex flex-wrap justify-center gap-4">
                            {[1, 2, 3, 4].map((i) => (
                                <div key={i} className={`h-12 w-24 rounded-full ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-ultra-fast`}></div>
                            ))}
                        </div>
                    </div>
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        {[1, 2, 3, 4, 5, 6].map((i) => (
                            <div key={i} className="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                                <div className={`h-48 ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-ultra-fast`}></div>
                                <div className="p-4">
                                    <div className={`h-6 w-3/4 mb-2 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-ultra-fast`}></div>
                                    <div className={`h-4 w-full mb-2 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-ultra-fast`}></div>
                                    <div className={`h-4 w-2/3 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-ultra-fast`}></div>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </section>
        );
    }

    if (error) {
        return (
            <section className={`py-20 ${isDark ? 'bg-gray-900' : 'bg-gray-50'}`}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center">
                        <i className="fas fa-exclamation-triangle text-4xl text-red-500 mb-4"></i>
                        <p className={`text-lg ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>{error}</p>
                    </div>
                </div>
            </section>
        );
    }

    return (
        <section className={`py-20 ${isDark ? 'bg-gray-900' : 'bg-gray-50'}`}>
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {/* Header */}
                <div className="text-center mb-16">
                    <h2 className={`text-4xl md:text-5xl font-bold mb-6 ${isDark ? 'text-white' : 'text-gray-900'
                        }`}>
                        Our Film Portfolio
                    </h2>
                    <p className={`text-xl max-w-3xl mx-auto mb-8 ${isDark ? 'text-gray-300' : 'text-gray-600'
                        }`}>
                        Discover our curated collection of exceptional films, documentaries, and series
                        that have captivated audiences worldwide.
                    </p>

                    {/* Filter Buttons */}
                    <div className="flex flex-wrap justify-center gap-3" role="group" aria-label="Filter films by category">
                        {categories.map((category) => (
                            <button
                                key={category.id}
                                onClick={() => handleFilterChange(category.id)}
                                onKeyDown={(e) => {
                                    if (e.key === 'Enter' || e.key === ' ') {
                                        handleFilterChange(category.id);
                                    }
                                }}
                                aria-pressed={activeFilter === category.id.toString()}
                                aria-label={`Filter by ${category.name}`}
                                className={`px-5 py-2.5 rounded-full font-medium transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-brand-orange-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 ${activeFilter === category.id.toString()
                                    ? 'bg-brand-orange-500 text-white shadow-lg scale-105'
                                    : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-brand-orange-50 dark:hover:bg-brand-orange-900/20 hover:text-brand-orange-600 dark:hover:text-brand-orange-400 border-2'
                                    }`}
                                style={activeFilter !== category.id.toString() ? { borderColor: category.color } : {}}
                            >
                                {category.name}
                            </button>
                        ))}
                    </div>

                    {/* Film Count Display */}
                    <div className={`mt-6 text-center text-sm font-medium ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                        Showing {filteredMovies.length} of {movies.length} film{movies.length !== 1 ? 's' : ''}
                    </div>
                </div>

                {/* Movies Grid */}
                {filteredMovies.length > 0 ? (
                    <div ref={gridRef} className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                        {filteredMovies.map((movie) => {
                            const linkUrl = movie.link || `/portfolio/${movie.slug}`;
                            const isExternalLink = movie.link && (movie.link.startsWith('http://') || movie.link.startsWith('https://'));

                            return (
                                <MovieCard
                                    key={movie.id}
                                    movie={movie}
                                    isDark={isDark}
                                    isExternalLink={isExternalLink}
                                    linkUrl={linkUrl}
                                />
                            );
                        })}
                    </div>
                ) : (
                    <div className={`text-center py-16 ${isDark ? 'bg-gray-800/50' : 'bg-gray-50'} rounded-xl mb-12`}>
                        <svg className="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m-9 0h10m-10 0a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2M9 12h6m-6 4h6" />
                        </svg>
                        <p className={`text-lg font-medium ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                            No films found in this category
                        </p>
                        <p className={`text-sm mt-2 ${isDark ? 'text-gray-400' : 'text-gray-500'}`}>
                            Try selecting a different category or viewing all films
                        </p>
                    </div>
                )}

                {/* CTA Section */}
                {filteredMovies.length > 0 && activeFilter !== 'all' && (
                    <div className="text-center">
                        <div className={`inline-block p-8 rounded-xl ${isDark ? 'bg-gray-800' : 'bg-gray-50'}`}>
                            <p className={`text-lg font-semibold mb-4 ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                                Showing {filteredMovies.length} film{filteredMovies.length !== 1 ? 's' : ''}
                            </p>
                            <button
                                onClick={() => setActiveFilter('all')}
                                className="inline-flex items-center px-8 py-4 bg-brand-orange-500 hover:bg-brand-orange-600 text-white font-semibold rounded-lg transition-all duration-300 hover:shadow-lg hover:-translate-y-1"
                            >
                                <span>View All Films</span>
                                <svg className="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </button>
                        </div>
                    </div>
                )}
            </div>
        </section>
    );
}

export default MoviePortfolio;
