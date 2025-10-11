import { useTheme } from '../../contexts/ThemeContext';
import { useEffect, useState, useRef } from 'react';

function StatsBlock({ data, settings, pageSettings }) {
    const { isDark } = useTheme();
    const [isVisible, setIsVisible] = useState(false);
    const [animatedStats, setAnimatedStats] = useState([]);
    const sectionRef = useRef(null);
    
    const {
        title = 'Our Impact',
        subtitle = '',
        stats = [],
        columns = 4,
        padding = 'normal',
        backgroundColor = 'primary'
    } = data;

    useEffect(() => {
        const observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) {
                    setIsVisible(true);
                    animateNumbers();
                }
            },
            { threshold: 0.1 }
        );

        if (sectionRef.current) {
            observer.observe(sectionRef.current);
        }

        return () => observer.disconnect();
    }, []);

    const animateNumbers = () => {
        const duration = 2000; // 2 seconds
        const steps = 60;
        const stepDuration = duration / steps;

        stats.forEach((stat, index) => {
            const numericValue = parseInt(stat.number.replace(/[^\d]/g, ''));
            const suffix = stat.number.replace(/[\d]/g, '');
            
            for (let step = 0; step <= steps; step++) {
                setTimeout(() => {
                    const currentValue = Math.floor((numericValue * step) / steps);
                    setAnimatedStats(prev => {
                        const newStats = [...prev];
                        newStats[index] = {
                            ...stat,
                            animatedNumber: currentValue + suffix
                        };
                        return newStats;
                    });
                }, step * stepDuration);
            }
        });
    };

    const paddingClasses = {
        'none': 'py-0',
        'small': 'py-16',
        'normal': 'py-20',
        'large': 'py-32'
    };

    const columnClasses = {
        1: 'grid-cols-1',
        2: 'grid-cols-1 md:grid-cols-2',
        3: 'grid-cols-1 md:grid-cols-3',
        4: 'grid-cols-1 md:grid-cols-2 lg:grid-cols-4',
        5: 'grid-cols-1 md:grid-cols-3 lg:grid-cols-5',
        6: 'grid-cols-1 md:grid-cols-3 lg:grid-cols-6'
    };

    const backgroundClasses = {
        'primary': isDark ? 'bg-gradient-to-br from-gray-900 to-gray-800' : 'bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-900',
        'secondary': isDark ? 'bg-gradient-to-br from-gray-800 to-gray-900' : 'bg-gradient-to-br from-gray-800 to-gray-900',
        'accent': isDark ? 'bg-gradient-to-br from-orange-900 to-red-900' : 'bg-gradient-to-br from-orange-600 to-red-600',
        'white': isDark ? 'bg-gray-800' : 'bg-white',
        'transparent': ''
    };

    const textColorClasses = {
        'primary': 'text-white',
        'secondary': 'text-white',
        'accent': 'text-white',
        'white': isDark ? 'text-white' : 'text-gray-900',
        'transparent': isDark ? 'text-white' : 'text-gray-900'
    };

    return (
        <section ref={sectionRef} className={`relative ${paddingClasses[padding]} ${backgroundClasses[backgroundColor]} overflow-hidden`}>
            {/* Animated background elements */}
            <div className="absolute inset-0">
                <div className="absolute inset-0 bg-gradient-to-r from-transparent via-white/5 to-transparent transform -skew-y-1"></div>
                {[...Array(20)].map((_, i) => (
                    <div
                        key={i}
                        className="absolute w-2 h-2 bg-white/10 rounded-full animate-pulse"
                        style={{
                            left: `${Math.random() * 100}%`,
                            top: `${Math.random() * 100}%`,
                            animationDelay: `${Math.random() * 3}s`,
                            animationDuration: `${2 + Math.random() * 2}s`
                        }}
                    />
                ))}
            </div>

            <div className="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {(title || subtitle) && (
                    <div className={`text-center mb-16 transform transition-all duration-1000 ${isVisible ? 'translate-y-0 opacity-100' : 'translate-y-10 opacity-0'}`}>
                        {title && (
                            <h2 className={`text-4xl sm:text-5xl lg:text-6xl font-black mb-6 ${textColorClasses[backgroundColor]} bg-gradient-to-r from-white via-blue-100 to-purple-200 bg-clip-text text-transparent`}>
                                {title}
                            </h2>
                        )}
                        {subtitle && (
                            <p className={`text-xl md:text-2xl ${
                                backgroundColor === 'white' 
                                    ? (isDark ? 'text-gray-300' : 'text-gray-600')
                                    : 'text-gray-100'
                            }`}>
                                {subtitle}
                            </p>
                        )}
                    </div>
                )}
                
                <div className={`grid ${columnClasses[columns]} gap-8 lg:gap-12`}>
                    {stats.map((stat, index) => (
                        <div 
                            key={index} 
                            className={`group relative text-center transform transition-all duration-1000 delay-${index * 200} ${
                                isVisible ? 'translate-y-0 opacity-100' : 'translate-y-10 opacity-0'
                            }`}
                        >
                            {/* Card background */}
                            <div className="relative p-8 rounded-2xl bg-white/10 backdrop-blur-sm border border-white/20 hover:bg-white/20 transition-all duration-300 group-hover:scale-105 group-hover:shadow-2xl group-hover:shadow-blue-500/25">
                                {/* Glow effect */}
                                <div className="absolute inset-0 rounded-2xl bg-gradient-to-r from-blue-500/20 to-purple-500/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                
                                {/* Number */}
                                <div className={`relative text-5xl sm:text-6xl lg:text-7xl font-black mb-4 ${textColorClasses[backgroundColor]} bg-gradient-to-r from-white via-blue-100 to-purple-200 bg-clip-text text-transparent`}>
                                    {animatedStats[index]?.animatedNumber || stat.number}
                                </div>
                                
                                {/* Label */}
                                <div className={`text-lg md:text-xl font-semibold ${
                                    backgroundColor === 'white' 
                                        ? (isDark ? 'text-gray-300' : 'text-gray-600')
                                        : 'text-gray-100'
                                }`}>
                                    {stat.label}
                                </div>

                                {/* Decorative line */}
                                <div className="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-16 h-1 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}

export default StatsBlock;
