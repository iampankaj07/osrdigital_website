import { useState, useEffect } from 'react';
import {
    FilmIcon,
    MusicalNoteIcon,
    VideoCameraIcon,
    EyeIcon
} from '@heroicons/react/24/outline';
import { useAllSettings } from '../../hooks/useSettings';
import { useTheme } from '../../contexts/ThemeContext';

function DynamicStats() {
    const [loading, setLoading] = useState(true);
    const { settings, loading: settingsLoading, getSetting } = useAllSettings();
    const { isDark } = useTheme();

    // Create stats array using dynamic settings
    const stats = [
        {
            number: getSetting('stats_movies_count', '500+'),
            label: getSetting('stats_movies_label', 'Movies Published'),
            icon: FilmIcon,
        },
        {
            number: getSetting('stats_songs_count', '2,000+'),
            label: getSetting('stats_songs_label', 'Songs Released'),
            icon: MusicalNoteIcon,
        },
        {
            number: getSetting('stats_films_count', '800+'),
            label: getSetting('stats_films_label', 'Short Films'),
            icon: VideoCameraIcon,
        },
        {
            number: getSetting('stats_views_count', '50M+'),
            label: getSetting('stats_views_label', 'Total Views'),
            icon: EyeIcon,
        }
    ];

    useEffect(() => {
        // Simulate loading
        const timer = setTimeout(() => {
            setLoading(false);
        }, 500);

        return () => clearTimeout(timer);
    }, []);

    if (loading || settingsLoading) {
        return (
            <section className={`py-24 ${
                isDark
                    ? 'bg-gradient-to-b from-gray-900 to-black'
                    : 'bg-gradient-to-b from-gray-50 to-white'
            }`}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center mb-16">
                        <div className="animate-pulse">
                            <div className="h-12 bg-gray-700/50 rounded-lg mb-6 max-w-md mx-auto"></div>
                            <div className="h-6 bg-gray-700/50 rounded-lg max-w-3xl mx-auto"></div>
                        </div>
                    </div>
                    <div className="grid grid-cols-2 lg:grid-cols-4 gap-8">
                        {[1, 2, 3, 4].map(i => (
                            <div key={i} className="text-center">
                                <div className="animate-pulse">
                                    <div className="h-16 w-16 bg-gray-700/50 rounded-2xl mx-auto mb-6"></div>
                                    <div className="h-8 bg-gray-700/50 rounded-lg mb-3"></div>
                                    <div className="h-4 bg-gray-700/50 rounded"></div>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </section>
        );
    }

    const primaryColor = '#ec681b'; // OSR Digital brand orange

    return (
        <section className={`py-24 ${isDark ? 'bg-gray-900' : 'bg-gray-50'}`}>
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="text-center mb-16">
                    <h2 className={`text-4xl md:text-5xl font-bold mb-6 ${
                        isDark ? 'text-white' : 'text-gray-900'
                    }`}>
                        {getSetting('stats_section_title', 'Our')}{' '}
                        <span style={{ color: primaryColor }}>
                            {getSetting('stats_section_highlighted_title', 'Impact')}
                        </span>
                    </h2>
                    <p className={`text-xl max-w-3xl mx-auto ${
                        isDark ? 'text-gray-400' : 'text-gray-600'
                    }`}>
                        {getSetting('stats_section_description', 'Numbers that speak to our commitment to bringing quality content to global audiences')}
                    </p>
                </div>

                <div className="grid grid-cols-2 lg:grid-cols-4 gap-8">
                    {stats.map((stat, index) => {
                        const IconComponent = stat.icon;
                        return (
                            <div key={index} className="group text-center">
                                <div className="relative mb-6">
                                    {/* Icon Container */}
                                    <div
                                        className={`w-20 h-20 mx-auto rounded-2xl flex items-center justify-center transition-colors duration-300 shadow-lg hover-primary-bg ${
                                            isDark ? 'bg-gray-800' : 'bg-white border border-gray-200'
                                        }`}
                                        style={{
                                            '--primary-color': primaryColor
                                        }}
                                    >
                                        <IconComponent className={`w-10 h-10 ${
                                            isDark ? 'text-white' : 'text-gray-700'
                                        }`} />
                                    </div>
                                </div>

                                {/* Number */}
                                <div
                                    className={`text-4xl md:text-5xl lg:text-6xl font-bold mb-3 transition-colors duration-300 group-hover-primary-text ${
                                        isDark ? 'text-white' : 'text-gray-900'
                                    }`}
                                    style={{
                                        '--primary-color': primaryColor
                                    }}
                                >
                                    {stat.number}
                                </div>

                                {/* Label */}
                                <div className={`text-lg font-medium ${
                                    isDark ? 'text-gray-400' : 'text-gray-600'
                                }`}>
                                    {stat.label}
                                </div>

                                {/* Progress Line */}
                                <div className={`mt-4 h-1 rounded-full overflow-hidden ${
                                    isDark ? 'bg-gray-800' : 'bg-gray-200'
                                }`}>
                                    <div
                                        className="h-full rounded-full transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"
                                        style={{ backgroundColor: primaryColor }}
                                    ></div>
                                </div>
                            </div>
                        );
                    })}
                </div>
            </div>

            {/* Add custom CSS for hover effects */}
            <style jsx>{`
                .hover-primary-bg:hover {
                    background-color: var(--primary-color) !important;
                }
                .group:hover .group-hover-primary-text {
                    color: var(--primary-color) !important;
                }
            `}</style>
        </section>
    );
}

export default DynamicStats;
