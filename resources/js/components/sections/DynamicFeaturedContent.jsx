import { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { useTheme } from '../../contexts/ThemeContext';

function DynamicFeaturedContent() {
    const { isDark } = useTheme();
    const [content, setContent] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        // Fetch featured content from API
        fetch('/api/featured-content')
            .then(response => response.json())
            .then(data => {
                setContent(data);
                setLoading(false);
            })
            .catch(error => {
                console.error('Error fetching featured content:', error);
                setLoading(false);
            });
    }, []);

    if (loading) {
        return (
            <section className={`py-20 ${isDark ? 'bg-black' : 'bg-gray-50'}`}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center mb-16">
                        <h2 className={`text-4xl md:text-5xl font-bold ${isDark ? 'text-white' : 'text-gray-900'} mb-6`}>
                            Featured Content
                        </h2>
                        <p className={`text-xl ${isDark ? 'text-gray-400' : 'text-gray-600'} max-w-3xl mx-auto`}>
                            Discover our latest acquisitions and most popular releases across movies, music,
                            and short films.
                        </p>
                    </div>

                    <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                        {[1, 2, 3].map(i => (
                            <div key={i} className="animate-pulse">
                                <div className={`${isDark ? 'bg-gray-800' : 'bg-gray-200'} aspect-video rounded-lg mb-4`}></div>
                                <div className={`h-6 ${isDark ? 'bg-gray-800' : 'bg-gray-200'} rounded mb-2`}></div>
                                <div className={`h-4 ${isDark ? 'bg-gray-800' : 'bg-gray-200'} rounded w-1/2`}></div>
                            </div>
                        ))}
                    </div>
                </div>
            </section>
        );
    }

    return (
        <section className={`py-20 ${isDark ? 'bg-black' : 'bg-gray-50'}`}>
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="text-center mb-16">
                    <h2 className={`text-4xl md:text-5xl font-bold ${isDark ? 'text-white' : 'text-gray-900'} mb-6`}>
                        Featured Content
                    </h2>
                    <p className={`text-xl ${isDark ? 'text-gray-400' : 'text-gray-600'} max-w-3xl mx-auto`}>
                        Discover our latest acquisitions and most popular releases across movies, music,
                        and short films.
                    </p>
                </div>

                <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    {content.map((item, index) => (
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

                                {/* Category Badge */}
                                <div className="absolute top-4 left-4">
                                    <span className="bg-red-600 text-white px-3 py-1 rounded-full text-sm font-medium">
                                        {item.type}
                                    </span>
                                </div>
                            </div>

                            <div className="space-y-2">
                                <h3 className={`text-xl font-semibold ${isDark ? 'text-white group-hover:text-red-400' : 'text-gray-900 group-hover:text-red-600'} transition-colors`}>
                                    {item.title}
                                </h3>
                                <p className={`${isDark ? 'text-gray-400' : 'text-gray-600'}`}>
                                    {item.views}
                                </p>
                            </div>
                        </Link>
                    ))}
                </div>

                <div className="text-center mt-12">
                    <Link
                        to="/portfolio"
                        className="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-lg font-medium transition-colors flex items-center gap-2 mx-auto"
                    >
                        View Full Portfolio
                        <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </Link>
                </div>
            </div>
        </section>
    );
}

export default DynamicFeaturedContent;
