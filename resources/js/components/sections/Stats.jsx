

import { useTheme } from '../../contexts/ThemeContext';

function Stats() {
    const { isDark } = useTheme();
    const stats = [
        {
            number: '500+',
            label: 'Movies Published',
            icon: '🎬'
        },
        {
            number: '2,000+',
            label: 'Songs Released',
            icon: '🎵'
        },
        {
            number: '800+',
            label: 'Short Films',
            icon: '🎥'
        },
        {
            number: '50M+',
            label: 'Total Views',
            icon: '👁️'
        }
    ];

    return (
        <section className={`py-20 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="grid grid-cols-2 lg:grid-cols-4 gap-8">
                    {stats.map((stat, index) => (
                        <div key={index} className="text-center">
                            <div className="text-4xl mb-4">{stat.icon}</div>
                            <div className={`text-4xl md:text-5xl font-bold ${isDark ? 'text-white' : 'text-gray-900'} mb-2`}>
                                {stat.number}
                            </div>
                            <div className={`text-lg ${isDark ? 'text-gray-400' : 'text-gray-600'}`}>
                                {stat.label}
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}

export default Stats;
