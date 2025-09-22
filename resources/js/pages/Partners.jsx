import { useState, useEffect, useMemo } from 'react';
import { useTheme } from '../contexts/ThemeContext';
import { Link } from 'react-router-dom';
import { usePartnersSettings } from '../hooks/useSettings';

const Skeleton = ({ className }) => (
    <div className={`animate-pulse bg-gray-300 dark:bg-gray-700 rounded ${className}`} />
);

function Partners() {
    const { isDark } = useTheme();
    const { getSetting, loading: settingsLoading } = usePartnersSettings();
    const [activeCategory, setActiveCategory] = useState(0);

    // Parse categories
    const partnershipCategories = useMemo(() => {
        try {
            const data = getSetting('partnership_categories_items', '[]');
            const categories = typeof data === 'string' ? JSON.parse(data) : data;
            return categories.map((c, i) => ({
                title: c.title || 'Category',
                description: c.description || 'Description not available',
                icon: c.icon || ['🎬', '👥', '🌍', '📺'][i] || '⭐',
                count: c.count_display || '0+',
                image: c.image || null,
            }));
        } catch {
            return [];
        }
    }, [getSetting]);

    // Parse associates
    const associates = useMemo(() => {
        try {
            const data = getSetting('associates_items', '[]');
            const parsed = typeof data === 'string' ? JSON.parse(data) : data;
            return parsed.map(a => ({
                name: a.name || 'Company Name',
                logo: a.logo || '/images/associates/default.png',
                description: a.description || 'Description not available',
                category: a.category || 'General',
                website: a.website || '#',
            }));
        } catch {
            return [];
        }
    }, [getSetting]);

    if (settingsLoading) {
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
        <div className={`min-h-screen ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
            {/* Hero Section */}
            <section className={`relative overflow-hidden ${isDark ? 'bg-gradient-to-br from-gray-900 via-gray-800 to-black' : 'bg-gradient-to-br from-white via-orange-50 to-orange-100'}`}>
                <div className="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32 text-center">
                    <h1 className={`text-5xl md:text-6xl font-bold ${isDark ? 'text-white' : 'text-gray-900'} mb-8`}>Our Partners</h1>
                    <p className={`text-xl md:text-2xl ${isDark ? 'text-gray-300' : 'text-gray-600'} max-w-3xl mx-auto leading-relaxed`}>
                        Explore our network of creative studios, content creators, distributors, and platforms driving impactful collaborations worldwide.
                    </p>
                </div>
            </section>

            {/* Categories Section */}
            <section className={`py-16 ${isDark ? 'bg-black' : 'bg-white'}`}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    {partnershipCategories.map((category, idx) => (
                        <div key={idx} className={`p-8 rounded-2xl border ${isDark ? 'border-gray-700 bg-gray-800' : 'border-gray-200 bg-gray-50'}`}>
                            <div className="text-4xl mb-4">{category.icon}</div>
                            <h3 className={`text-2xl font-bold mb-2 ${isDark ? 'text-white' : 'text-gray-900'}`}>{category.title}</h3>
                            <p className={`${isDark ? 'text-gray-400' : 'text-gray-600'} mb-4`}>{category.description}</p>
                            <span className={`text-sm font-medium px-3 py-1 rounded-full ${isDark ? 'bg-gray-700 text-white' : 'bg-gray-200 text-gray-800'}`}>{category.count}</span>
                        </div>
                    ))}
                </div>
            </section>

            {/* Associates Section */}
            <section className={`py-20 ${isDark ? 'bg-gray-900' : 'bg-gray-100'}`}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    {associates.map((assoc) => (
                        <Link key={assoc.name} to={assoc.website} className="group block">
                            <div className={`p-6 rounded-2xl border ${isDark ? 'border-gray-700 bg-gray-800' : 'border-gray-200 bg-white'} hover:shadow-lg transition-shadow`}>
                                <img src={assoc.logo} alt={assoc.name} className="w-full h-24 object-contain mb-4" />
                                <h3 className={`text-xl font-semibold mb-2 ${isDark ? 'text-white' : 'text-gray-900'}`}>{assoc.name}</h3>
                                <p className={`${isDark ? 'text-gray-400' : 'text-gray-600'} text-sm`}>{assoc.category}</p>
                            </div>
                        </Link>
                    ))}
                </div>
            </section>
        </div>
    );
}

export default Partners;
