import { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { useTheme } from '../contexts/ThemeContext';

function Portfolio() {
    const { isDark } = useTheme();
    const [portfolioItems, setPortfolioItems] = useState([]);
    const [loading, setLoading] = useState(true);
    const [filter, setFilter] = useState('all');

    useEffect(() => {
        // Fetch portfolio items from API
        fetch('/api/portfolio')
            .then(response => response.json())
            .then(data => {
                setPortfolioItems(data);
                setLoading(false);
            })
            .catch(error => {
                console.error('Error fetching portfolio:', error);
                setLoading(false);
                // Fallback data
                setPortfolioItems([
                    {
                        id: 1,
                        title: 'Epic Action Thriller',
                        type: 'movie',
                        views: '2.5M views',
                        image: 'https://images.pexels.com/photos/7991579/pexels-photo-7991579.jpeg?auto=compress&cs=tinysrgb&w=800',
                        category: 'Action'
                    },
                    {
                        id: 2,
                        title: 'Indie Music Collection',
                        type: 'music',
                        views: '1.8M views',
                        image: 'https://images.pexels.com/photos/1763075/pexels-photo-1763075.jpeg?auto=compress&cs=tinysrgb&w=800',
                        category: 'Indie'
                    },
                    {
                        id: 3,
                        title: 'Award-Winning Short',
                        type: 'short_film',
                        views: '950K views',
                        image: 'https://images.pexels.com/photos/7991319/pexels-photo-7991319.jpeg?auto=compress&cs=tinysrgb&w=800',
                        category: 'Drama'
                    }
                ]);
            });
    }, []);

    const filteredItems = filter === 'all'
        ? portfolioItems
        : portfolioItems.filter(item => item.type === filter);

    if (loading) {
        return (
            <div className={`min-h-screen ${isDark ? 'bg-gray-900' : 'bg-gray-50'} pt-20`}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                    <div className="text-center mb-16">
                        <h1 className={`text-5xl font-bold ${isDark ? 'text-white' : 'text-gray-900'} mb-8`}>Our Portfolio</h1>
                        <div className="animate-pulse">
                            <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                                {[1, 2, 3, 4, 5, 6].map(i => (
                                    <div key={i} className={`${isDark ? 'bg-gray-800' : 'bg-gray-200'} aspect-video rounded-lg`}></div>
                                ))}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }

    return (
        <div className={`min-h-screen ${isDark ? 'bg-gray-900' : 'bg-gray-50'} pt-20`}>
            {/* Hero Section */}
            <section className={`py-20 ${isDark ? 'bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900' : 'bg-gradient-to-r from-gray-100 via-gray-200 to-gray-100'}`}>
                <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <h1 className={`text-5xl font-bold ${isDark ? 'text-white' : 'text-gray-900'} mb-8`}>Our Portfolio</h1>
                    <p className={`text-xl ${isDark ? 'text-gray-300' : 'text-gray-600'} max-w-3xl mx-auto`}>
                        Discover our curated collection of movies, music, and short films that have captivated
                        audiences worldwide through strategic YouTube distribution.
                    </p>
                </div>
            </section>

            {/* Filter Section */}
            <section className={`py-8 ${isDark ? 'bg-black border-b border-gray-800' : 'bg-white border-b border-gray-200'}`}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex flex-wrap justify-center gap-4">
                        <button
                            onClick={() => setFilter('all')}
                            className={`px-6 py-2 rounded-full font-medium transition-colors ${
                                filter === 'all'
                                    ? 'bg-red-600 text-white'
                                    : isDark
                                        ? 'bg-gray-800 text-gray-300 hover:bg-gray-700'
                                        : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                            }`}
                        >
                            All Content
                        </button>
                        <button
                            onClick={() => setFilter('movie')}
                            className={`px-6 py-2 rounded-full font-medium transition-colors ${
                                filter === 'movie'
                                    ? 'bg-red-600 text-white'
                                    : isDark
                                        ? 'bg-gray-800 text-gray-300 hover:bg-gray-700'
                                        : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                            }`}
                        >
                            Movies
                        </button>
                        <button
                            onClick={() => setFilter('music')}
                            className={`px-6 py-2 rounded-full font-medium transition-colors ${
                                filter === 'music'
                                    ? 'bg-red-600 text-white'
                                    : isDark
                                        ? 'bg-gray-800 text-gray-300 hover:bg-gray-700'
                                        : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                            }`}
                        >
                            Music
                        </button>
                        <button
                            onClick={() => setFilter('short_film')}
                            className={`px-6 py-2 rounded-full font-medium transition-colors ${
                                filter === 'short_film'
                                    ? 'bg-red-600 text-white'
                                    : isDark
                                        ? 'bg-gray-800 text-gray-300 hover:bg-gray-700'
                                        : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                            }`}
                        >
                            Short Films
                        </button>
                    </div>
                </div>
            </section>

            {/* Portfolio Grid */}
            <section className={`py-20 ${isDark ? 'bg-black' : 'bg-white'}`}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    {filteredItems.length === 0 ? (
                        <div className="text-center py-20">
                            <p className={`text-xl ${isDark ? 'text-gray-400' : 'text-gray-600'}`}>No content found for the selected filter.</p>
                        </div>
                    ) : (
                        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                            {filteredItems.map((item) => (
                                <Link
                                    key={item.id}
                                    to={`/portfolio/${item.slug}`}
                                    className="group cursor-pointer block"
                                >
                                    <div className={`relative overflow-hidden rounded-lg ${isDark ? 'bg-gray-800' : 'bg-gray-200'} aspect-video mb-4`}>
                                        <img
                                            src={item.image}
                                            alt={item.title}
                                            className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                        />
                                        <div className="absolute inset-0 bg-black/40 group-hover:bg-black/20 transition-colors duration-300"></div>

                                        {/* Play Button */}
                                        <div className="absolute inset-0 flex items-center justify-center">
                                            <div className="w-16 h-16 bg-red-600 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                                <svg className="w-6 h-6 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M8 5v14l11-7z"/>
                                                </svg>
                                            </div>
                                        </div>

                                        {/* Type Badge */}
                                        <div className="absolute top-4 left-4">
                                            <span className="bg-red-600 text-white px-3 py-1 rounded-full text-sm font-medium capitalize">
                                                {item.type?.replace('_', ' ') || 'Content'}
                                            </span>
                                        </div>

                                        {/* Views Badge */}
                                        <div className="absolute bottom-4 right-4">
                                            <span className="bg-black/75 text-white px-3 py-1 rounded-full text-sm">
                                                {item.views || '0'} views
                                            </span>
                                        </div>
                                    </div>

                                    <div className="space-y-2">
                                        <h3 className={`text-xl font-semibold transition-colors ${
                                            isDark
                                                ? 'text-white group-hover:text-red-400'
                                                : 'text-gray-900 group-hover:text-red-600'
                                        }`}>
                                            {item.title}
                                        </h3>
                                        {item.category && (
                                            <p className={`${isDark ? 'text-gray-400' : 'text-gray-600'}`}>
                                                {item.category}
                                            </p>
                                        )}
                                    </div>
                                </Link>
                            ))}
                        </div>
                    )}
                </div>
            </section>

            {/* Stats Section */}
            <section className={`py-20 ${isDark ? 'bg-gray-900' : 'bg-gray-100'}`}>
                <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <h2 className={`text-4xl font-bold ${isDark ? 'text-white' : 'text-gray-900'} mb-12`}>Portfolio Impact</h2>
                    <div className="grid md:grid-cols-3 gap-8">
                        <div>
                            <div className="text-4xl font-bold text-red-500 mb-2">50M+</div>
                            <div className={`${isDark ? 'text-gray-400' : 'text-gray-600'}`}>Total Views Across Portfolio</div>
                        </div>
                        <div>
                            <div className="text-4xl font-bold text-red-500 mb-2">1,300+</div>
                            <div className={`${isDark ? 'text-gray-400' : 'text-gray-600'}`}>Pieces of Content Published</div>
                        </div>
                        <div>
                            <div className="text-4xl font-bold text-red-500 mb-2">150+</div>
                            <div className={`${isDark ? 'text-gray-400' : 'text-gray-600'}`}>Creator Partnerships</div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    );
}

export default Portfolio;
