import { useState, useEffect } from 'react';
import { useTheme } from '../../contexts/ThemeContext';

function OurImpact({ content, title, subtitle }) {
    const { isDark } = useTheme();
    const [stats, setStats] = useState([]);
    const [sectionTitle, setSectionTitle] = useState("Our Impact");
    const [sectionSubtitle, setSectionSubtitle] = useState("Numbers that speak to our commitment to bringing quality content to global audiences");
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchGlobalImpact = async () => {
            try {
                setLoading(true);
                const response = await fetch('/api/global-impact');
                const data = await response.json();

                if (data.success) {
                    setStats(data.data.stats || []);
                    setSectionTitle(data.data.title || "Our Impact");
                    setSectionSubtitle(data.data.subtitle || "Numbers that speak to our commitment to bringing quality content to global audiences");
                } else {
                    setError('Failed to load global impact data');
                    // Use fallback data
                    setStats([
                        { number: '500+', label: 'Movies Published' },
                        { number: '2,000+', label: 'Songs Released' },
                        { number: '800+', label: 'Short Films' },
                        { number: '50M+', label: 'Total Views' }
                    ]);
                }
            } catch (err) {
                setError('Failed to load global impact data');
                console.error('Error fetching global impact:', err);
                // Use fallback data
                setStats([
                    { number: '500+', label: 'Movies Published' },
                    { number: '2,000+', label: 'Songs Released' },
                    { number: '800+', label: 'Short Films' },
                    { number: '50M+', label: 'Total Views' }
                ]);
            } finally {
                setLoading(false);
            }
        };

        // Use props if provided, otherwise fetch from API
        if (content && content.stats) {
            setStats(content.stats);
            setSectionTitle(title || "Our Impact");
            setSectionSubtitle(subtitle || "Numbers that speak to our commitment to bringing quality content to global audiences");
            setLoading(false);
        } else {
            fetchGlobalImpact();
        }
    }, [content, title, subtitle]);

    if (loading) {
        return (
            <section className={`py-24 ${isDark ? 'bg-gray-900' : 'bg-gray-50'}`}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center mb-16">
                        <div className={`h-12 w-64 mx-auto mb-6 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                        <div className={`h-6 w-96 mx-auto rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                    </div>
                    <div className="grid grid-cols-2 lg:grid-cols-4 gap-8">
                        {[1, 2, 3, 4].map((i) => (
                            <div key={i} className="text-center">
                                <div className={`h-16 w-16 mx-auto mb-4 rounded-full ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                <div className={`h-12 w-24 mx-auto mb-2 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                <div className={`h-6 w-32 mx-auto rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                            </div>
                        ))}
                    </div>
                </div>
            </section>
        );
    }

    if (error) {
        return (
            <section className={`py-24 ${isDark ? 'bg-gray-900' : 'bg-gray-50'}`}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center">
                        <i className="fas fa-exclamation-triangle text-4xl text-red-500 mb-4"></i>
                        <p className={`text-lg ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>{error}</p>
                    </div>
                </div>
            </section>
        );
    }

    const primaryColor = '#ff6b35'; // OSR Digital brand orange

    return (
        <section className={`py-24 ${isDark ? 'bg-gray-900' : 'bg-gray-50'}`}>
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="text-center mb-16">
                    <h2 className={`text-4xl md:text-5xl font-bold mb-6 ${isDark ? 'text-white' : 'text-gray-900'
                        }`}>
                        {sectionTitle.split(' ').slice(0, -1).join(' ')}{' '}
                        <span style={{ color: primaryColor }}>
                            {sectionTitle.split(' ').slice(-1)}
                        </span>
                    </h2>
                    <p className={`text-xl max-w-3xl mx-auto ${isDark ? 'text-gray-400' : 'text-gray-600'
                        }`}>
                        {sectionSubtitle}
                    </p>
                </div>

                <div className="grid grid-cols-2 lg:grid-cols-4 gap-8">
                    {stats.map((stat, index) => (
                        <div
                            key={index}
                            className={`group transform transition-all duration-1000 hover:-translate-y-2`}
                            style={{ transitionDelay: `${index * 100}ms` }}
                        >
                            <div className={`h-full p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 ${isDark
                                    ? 'bg-gradient-to-br from-gray-800 to-gray-900 hover:from-gray-700 hover:to-gray-800'
                                    : 'bg-gradient-to-br from-white to-gray-50 hover:to-white border border-gray-100'
                                }`}>
                                {/* Icon (if available) */}
                                {stat.icon && (
                                    <div className="mb-6 flex justify-center">
                                        <div className={`p-4 rounded-xl ${isDark
                                                ? 'bg-brand-orange-500/20 text-brand-orange-400'
                                                : 'bg-brand-orange-100 text-brand-orange-600'
                                            } group-hover:scale-125 transition-transform duration-300`}>
                                            <i className={`${stat.icon} text-4xl`}></i>
                                        </div>
                                    </div>
                                )}

                                {/* Number */}
                                <div
                                    className="text-4xl lg:text-5xl font-bold mb-4 text-center group-hover:scale-105 transition-transform duration-300"
                                    style={{ color: primaryColor }}
                                >
                                    {stat.number}
                                </div>

                                {/* Label */}
                                <p className={`text-center text-lg font-semibold ${isDark ? 'text-gray-300 group-hover:text-brand-orange-400' : 'text-gray-600 group-hover:text-brand-orange-600'
                                    } transition-colors duration-300`}>
                                    {stat.label}
                                </p>

                                {/* Decorative line */}
                                <div className="w-12 h-1 bg-brand-orange-500 rounded-full mx-auto mt-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}

export default OurImpact;
