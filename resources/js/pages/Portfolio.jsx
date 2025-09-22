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
        return <div className={`min-h-screen ${isDark ? 'bg-gray-900' : 'bg-gray-50'} pt-20`}>
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <div className="text-center mb-16">
                    <h1 className={`text-5xl font-bold ${isDark ? 'text-white' : 'text-gray-900'} mb-8`}>
                        Our Partners
                    </h1>
                    <div className="animate-pulse">
                        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                            {[1, 2, 3, 4, 5, 6].map((i) => (
                                <div
                                    key={i}
                                    className={`${isDark ? 'bg-gray-800' : 'bg-gray-200'} aspect-video rounded-lg`}
                                ></div>
                            ))}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    }

    return (
        <div className={`min-h-screen ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
            {/* Hero Section */}
            <section className={`relative overflow-hidden ${isDark ? 'bg-gradient-to-br from-gray-900 via-gray-800 to-black' : 'bg-gradient-to-br from-white via-orange-50 to-orange-100'}`}>
                {/* Background Pattern */}
                <div className="absolute inset-0 opacity-10">
                    <div className="absolute inset-0 bg-gradient-to-r from-orange-500/20 to-purple-500/20"></div>
                    <div className="absolute top-0 left-0 w-full h-full">
                        {[...Array(50)].map((_, i) => (
                            <div
                                key={i}
                                className={`absolute rounded-full animate-pulse ${isDark ? 'bg-orange-400' : 'bg-orange-300'}`}
                                style={{
                                    width: Math.random() * 4 + 1 + 'px',
                                    height: Math.random() * 4 + 1 + 'px',
                                    top: Math.random() * 100 + '%',
                                    left: Math.random() * 100 + '%',
                                    animationDelay: Math.random() * 5 + 's',
                                }}
                            />
                        ))}
                    </div>
                </div>

                <div className="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32 text-center">
                    <h1 className={`text-5xl md:text-6xl font-bold ${isDark ? 'text-white' : 'text-gray-900'} mb-8`}>Our Portfolio</h1>
                    <p className={`text-xl md:text-2xl ${isDark ? 'text-gray-300' : 'text-gray-600'} max-w-3xl mx-auto leading-relaxed`}>
                        Discover our curated collection of movies, music, and short films that have captivated audiences
                        worldwide through strategic YouTube distribution and innovative content partnerships.
                    </p>
                </div>
            </section>

            {/* Filter Section */}
            <section className={`py-8 ${isDark ? 'bg-black border-b border-gray-800' : 'bg-white border-b border-gray-200'}`}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex flex-wrap justify-center gap-4">
                        <button
                            onClick={() => setFilter('all')}
                            className={`px-6 py-2 rounded-full font-medium transition-colors ${filter === 'all'
                                ? 'text-white'
                                : isDark
                                    ? 'bg-gray-800 text-gray-300 hover:bg-gray-700'
                                    : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                                }`}
                            style={filter === 'all' ? { backgroundColor: '#ff6b35' } : {}}
                        >
                            All Content
                        </button>
                        <button
                            onClick={() => setFilter('movie')}
                            className={`px-6 py-2 rounded-full font-medium transition-colors ${filter === 'movie'
                                ? 'text-white'
                                : isDark
                                    ? 'bg-gray-800 text-gray-300 hover:bg-gray-700'
                                    : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                                }`}
                            style={filter === 'movie' ? { backgroundColor: '#ff6b35' } : {}}
                        >
                            Movies
                        </button>
                        <button
                            onClick={() => setFilter('music')}
                            className={`px-6 py-2 rounded-full font-medium transition-colors ${filter === 'music'
                                ? 'text-white'
                                : isDark
                                    ? 'bg-gray-800 text-gray-300 hover:bg-gray-700'
                                    : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                                }`}
                            style={filter === 'music' ? { backgroundColor: '#ff6b35' } : {}}
                        >
                            Music
                        </button>
                        <button
                            onClick={() => setFilter('short_film')}
                            className={`px-6 py-2 rounded-full font-medium transition-colors ${filter === 'short_film'
                                ? 'text-white'
                                : isDark
                                    ? 'bg-gray-800 text-gray-300 hover:bg-gray-700'
                                    : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                                }`}
                            style={filter === 'short_film' ? { backgroundColor: '#ff6b35' } : {}}
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
                                            <div className="w-16 h-16 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300" style={{ backgroundColor: '#ff6b35' }}>
                                                <svg className="w-6 h-6 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M8 5v14l11-7z" />
                                                </svg>
                                            </div>
                                        </div>

                                        {/* Type Badge */}
                                        <div className="absolute top-4 left-4">
                                            <span className="text-white px-3 py-1 rounded-full text-sm font-medium capitalize" style={{ backgroundColor: '#ff6b35' }}>
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
                                        <h3 className={`text-xl font-semibold transition-colors ${isDark
                                            ? 'text-white'
                                            : 'text-gray-900'
                                            }`}
                                            style={{
                                                '--hover-color': '#ff6b35'
                                            }}
                                            onMouseEnter={(e) => e.target.style.color = '#ff6b35'}
                                            onMouseLeave={(e) => e.target.style.color = isDark ? 'white' : '#111827'}
                                        >
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
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <h2 className={`text-4xl font-bold ${isDark ? 'text-white' : 'text-gray-900'} mb-12`}>Portfolio Impact</h2>
                    <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                        <div className="text-center">
                            <div className="text-4xl mb-4">🎬</div>
                            <div className="text-4xl font-bold mb-2" style={{ color: '#ff6b35' }}>500+</div>
                            <div className={`${isDark ? 'text-gray-400' : 'text-gray-600'}`}>Movies Published</div>
                        </div>
                        <div className="text-center">
                            <div className="text-4xl mb-4">🎵</div>
                            <div className="text-4xl font-bold mb-2" style={{ color: '#ff6b35' }}>2,000+</div>
                            <div className={`${isDark ? 'text-gray-400' : 'text-gray-600'}`}>Songs Released</div>
                        </div>
                        <div className="text-center">
                            <div className="text-4xl mb-4">🎥</div>
                            <div className="text-4xl font-bold mb-2" style={{ color: '#ff6b35' }}>800+</div>
                            <div className={`${isDark ? 'text-gray-400' : 'text-gray-600'}`}>Short Films</div>
                        </div>
                        <div className="text-center">
                            <div className="text-4xl mb-4">👁️</div>
                            <div className="text-4xl font-bold mb-2" style={{ color: '#ff6b35' }}>50M+</div>
                            <div className={`${isDark ? 'text-gray-400' : 'text-gray-600'}`}>Total Views</div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    );
}

export default Portfolio;
