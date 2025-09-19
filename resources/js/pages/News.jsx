import { useState, useEffect } from 'react';
import { useTheme } from '../contexts/ThemeContext';
import PageHeader from '../components/PageHeader';

function News() {
    const [articles, setArticles] = useState([]);
    const [loading, setLoading] = useState(true);
    const [selectedCategory, setSelectedCategory] = useState('all');
    const { isDark } = useTheme();

    useEffect(() => {
        // Fetch news from API
        fetch('/api/news')
            .then(response => response.json())
            .then(data => {
                setArticles(data);
                setLoading(false);
            })
            .catch(error => {
                console.error('Error fetching news:', error);
                setLoading(false);
                // Fallback data
                setArticles([
                    {
                        id: 1,
                        title: 'OSR Digital Media Expands Global Distribution Network',
                        excerpt: 'We are excited to announce the expansion of our YouTube distribution network to over 100 countries, bringing diverse content to audiences worldwide.',
                        content: 'Complete article content...',
                        category: 'company',
                        image: 'https://via.placeholder.com/600x400/ef4444/ffffff?text=OSR+News',
                        published_at: '2024-01-15',
                        author: 'OSR Team'
                    },
                    {
                        id: 2,
                        title: 'New Partnership with Independent Film Studios',
                        excerpt: 'We have partnered with several independent film studios to distribute their content across our global YouTube network.',
                        content: 'Complete article content...',
                        category: 'partnership',
                        image: 'https://via.placeholder.com/600x400/3b82f6/ffffff?text=Partnership',
                        published_at: '2024-01-10',
                        author: 'Business Development'
                    },
                    {
                        id: 3,
                        title: 'Industry Trends: The Future of Digital Content Distribution',
                        excerpt: 'Exploring the latest trends in digital content distribution and how they impact creators and distributors in 2024.',
                        content: 'Complete article content...',
                        category: 'industry',
                        image: 'https://via.placeholder.com/600x400/10b981/ffffff?text=Trends',
                        published_at: '2024-01-05',
                        author: 'Industry Analysis'
                    }
                ]);
            });
    }, []);

    const categories = [
        { id: 'all', name: 'All News' },
        { id: 'company', name: 'Company News' },
        { id: 'partnership', name: 'Partnerships' },
        { id: 'industry', name: 'Industry' },
        { id: 'content', name: 'Content' }
    ];

    const filteredArticles = selectedCategory === 'all'
        ? articles
        : articles.filter(article => article.category === selectedCategory);

    if (loading) {
        return (
            <div className="min-h-screen bg-gray-900 pt-20">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                    <div className="text-center mb-16">
                        <h1 className="text-5xl font-bold text-white mb-8">Latest News</h1>
                        <div className="animate-pulse">
                            <div className="grid lg:grid-cols-3 gap-8">
                                {[1, 2, 3, 4, 5, 6].map(i => (
                                    <div key={i} className="bg-gray-800 h-64 rounded-lg"></div>
                                ))}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }

    return (
        <div className={`min-h-screen ${isDark ? 'bg-gray-900' : 'bg-gray-50'}`}>
            <PageHeader
                badge="Stay Updated"
                title="Latest Industry News"
                description="Stay updated with the latest developments in digital content distribution, industry trends, and company announcements from OSR Digital Media."
            />

            {/* News Categories */}
            <section className={`py-10 ${isDark ? 'bg-black' : 'bg-white'}`}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex flex-wrap justify-center gap-4 mb-12">
                        {categories.map((category) => (
                            <button
                                key={category.id}
                                onClick={() => setSelectedCategory(category.id)}
                                className={`px-6 py-3 rounded-full text-sm font-medium transition-colors ${
                                    selectedCategory === category.id
                                        ? 'bg-red-600 text-white'
                                        : isDark ? 'bg-gray-800 text-gray-300 hover:bg-gray-700' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                                }`}
                            >
                                {category.name}
                            </button>
                        ))}
                    </div>
                </div>
            </section>

            {/* Featured Article */}
            {filteredArticles.length > 0 && (
                <section className={`py-10 ${isDark ? 'bg-black' : 'bg-white'}`}>
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className={`${isDark ? 'bg-gray-800' : 'bg-gray-100'} rounded-lg overflow-hidden mb-16`}>
                            <div className="lg:flex">
                                <div className="lg:w-1/2">
                                    <img
                                        src={filteredArticles[0].image}
                                        alt={filteredArticles[0].title}
                                        className="w-full h-64 lg:h-full object-cover"
                                    />
                                </div>
                                <div className="lg:w-1/2 p-8">
                                    <div className="flex items-center mb-4">
                                        <span className="text-red-400 text-sm font-medium uppercase tracking-wider">
                                            {filteredArticles[0].category}
                                        </span>
                                        <span className={`${isDark ? 'text-gray-400' : 'text-gray-600'} text-sm ml-4`}>
                                            {new Date(filteredArticles[0].published_at).toLocaleDateString()}
                                        </span>
                                    </div>
                                    <h2 className={`text-3xl font-bold ${isDark ? 'text-white' : 'text-gray-900'} mb-4`}>
                                        {filteredArticles[0].title}
                                    </h2>
                                    <p className={`${isDark ? 'text-gray-300' : 'text-gray-600'} text-lg mb-6`}>
                                        {filteredArticles[0].excerpt}
                                    </p>
                                    <div className="flex items-center justify-between">
                                        <span className={`${isDark ? 'text-gray-400' : 'text-gray-600'} text-sm`}>
                                            By {filteredArticles[0].author}
                                        </span>
                                        <button className="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg transition-colors">
                                            Read More
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            )}

            {/* Articles Grid */}
            <section className={`py-20 ${isDark ? 'bg-black' : 'bg-white'}`}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    {filteredArticles.length > 1 ? (
                        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                            {filteredArticles.slice(1).map((article) => (
                                <article key={article.id} className={`${isDark ? 'bg-gray-800 hover:bg-gray-700' : 'bg-gray-100 hover:bg-gray-50'} rounded-lg overflow-hidden transition-colors group shadow-md`}>
                                    <img
                                        src={article.image}
                                        alt={article.title}
                                        className="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                                    />
                                    <div className="p-6">
                                        <div className="flex items-center mb-3">
                                            <span className="text-red-400 text-xs font-medium uppercase tracking-wider">
                                                {article.category}
                                            </span>
                                            <span className={`${isDark ? 'text-gray-500' : 'text-gray-600'} text-xs ml-3`}>
                                                {new Date(article.published_at).toLocaleDateString()}
                                            </span>
                                        </div>
                                        <h3 className={`text-xl font-semibold ${isDark ? 'text-white' : 'text-gray-900'} mb-3 group-hover:text-red-400 transition-colors`}>
                                            {article.title}
                                        </h3>
                                        <p className={`${isDark ? 'text-gray-300' : 'text-gray-600'} text-sm mb-4 line-clamp-3`}>
                                            {article.excerpt}
                                        </p>
                                        <div className="flex items-center justify-between">
                                            <span className={`${isDark ? 'text-gray-400' : 'text-gray-600'} text-xs`}>
                                                By {article.author}
                                            </span>
                                            <button className="text-red-400 hover:text-red-300 text-sm font-medium">
                                                Read More →
                                            </button>
                                        </div>
                                    </div>
                                </article>
                            ))}
                        </div>
                    ) : filteredArticles.length === 0 ? (
                        <div className="text-center py-20">
                            <h3 className={`text-2xl font-semibold ${isDark ? 'text-white' : 'text-gray-900'} mb-4`}>No articles found</h3>
                            <p className={`${isDark ? 'text-gray-400' : 'text-gray-600'}`}>No articles available in this category.</p>
                        </div>
                    ) : null}
                </div>
            </section>

            {/* Newsletter Signup */}
            <section className="py-20 bg-gray-900">
                <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <h2 className="text-4xl font-bold text-white mb-6">Stay Informed</h2>
                    <p className="text-xl text-gray-400 mb-8 max-w-2xl mx-auto">
                        Subscribe to our newsletter and never miss important updates about the digital content industry.
                    </p>
                    <div className="max-w-md mx-auto">
                        <div className="flex">
                            <input
                                type="email"
                                placeholder="Enter your email"
                                className="flex-1 bg-gray-800 text-white px-4 py-3 rounded-l-lg border border-gray-700 focus:outline-none focus:border-red-600"
                            />
                            <button className="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-r-lg transition-colors">
                                Subscribe
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            {/* Industry Insights */}
            <section className="py-20 bg-black">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center mb-16">
                        <h2 className="text-4xl font-bold text-white mb-6">Industry Insights</h2>
                        <p className="text-xl text-gray-400 max-w-3xl mx-auto">
                            Expert analysis and trends shaping the future of digital content distribution
                        </p>
                    </div>

                    <div className="grid lg:grid-cols-2 gap-8">
                        <div className="bg-gray-800 p-8 rounded-lg">
                            <div className="text-4xl mb-4">📈</div>
                            <h3 className="text-2xl font-bold text-white mb-4">Market Trends</h3>
                            <p className="text-gray-300 mb-6">
                                The digital content distribution market is evolving rapidly with new technologies
                                and changing audience behaviors driving innovation.
                            </p>
                            <ul className="space-y-2 text-gray-300">
                                <li>• Global streaming revenue up 20% year-over-year</li>
                                <li>• Mobile consumption continues to dominate</li>
                                <li>• Creator economy reaches $104B globally</li>
                            </ul>
                        </div>

                        <div className="bg-gray-800 p-8 rounded-lg">
                            <div className="text-4xl mb-4">🚀</div>
                            <h3 className="text-2xl font-bold text-white mb-4">Future Outlook</h3>
                            <p className="text-gray-300 mb-6">
                                Looking ahead, we see significant opportunities in emerging markets and
                                new content formats that will shape the industry.
                            </p>
                            <ul className="space-y-2 text-gray-300">
                                <li>• AI-powered content recommendations</li>
                                <li>• Interactive and immersive content growth</li>
                                <li>• Blockchain technology adoption</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    );
}

export default News;
