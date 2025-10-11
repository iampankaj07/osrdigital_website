import { useTheme } from '../../contexts/ThemeContext';
import { useEffect, useState, useRef } from 'react';

function FeaturesBlock({ data, settings, pageSettings }) {
    const { isDark } = useTheme();
    const [isVisible, setIsVisible] = useState(false);
    const [hoveredIndex, setHoveredIndex] = useState(null);
    const sectionRef = useRef(null);
    
    const {
        title = 'Features',
        subtitle = '',
        features = [],
        columns = 3,
        padding = 'normal'
    } = data;

    useEffect(() => {
        const observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) {
                    setIsVisible(true);
                }
            },
            { threshold: 0.1 }
        );

        if (sectionRef.current) {
            observer.observe(sectionRef.current);
        }

        return () => observer.disconnect();
    }, []);

    const paddingClasses = {
        'none': 'py-0',
        'small': 'py-16',
        'normal': 'py-20',
        'large': 'py-32'
    };

    const columnClasses = {
        1: 'grid-cols-1',
        2: 'grid-cols-1 md:grid-cols-2',
        3: 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3',
        4: 'grid-cols-1 md:grid-cols-2 lg:grid-cols-4'
    };

    return (
        <section ref={sectionRef} className={`relative ${paddingClasses[padding]} ${isDark ? 'bg-gray-900' : 'bg-white'} overflow-hidden`}>
            {/* Background decoration */}
            <div className="absolute inset-0">
                <div className="absolute inset-0 bg-gradient-to-br from-blue-50/50 via-transparent to-purple-50/50"></div>
                <div className="absolute top-0 left-1/4 w-96 h-96 bg-blue-500/5 rounded-full blur-3xl"></div>
                <div className="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-500/5 rounded-full blur-3xl"></div>
            </div>

            <div className="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {(title || subtitle) && (
                    <div className={`text-center mb-16 transform transition-all duration-1000 ${isVisible ? 'translate-y-0 opacity-100' : 'translate-y-10 opacity-0'}`}>
                        {title && (
                            <h2 className={`text-4xl sm:text-5xl lg:text-6xl font-black mb-6 ${
                                isDark ? 'text-white' : 'text-gray-900'
                            } bg-gradient-to-r from-gray-900 via-blue-900 to-purple-900 bg-clip-text text-transparent`}>
                                {title}
                            </h2>
                        )}
                        {subtitle && (
                            <p className={`text-xl md:text-2xl max-w-3xl mx-auto ${
                                isDark ? 'text-gray-300' : 'text-gray-600'
                            }`}>
                                {subtitle}
                            </p>
                        )}
                    </div>
                )}
                
                <div className={`grid ${columnClasses[columns]} gap-8 lg:gap-12`}>
                    {features.map((feature, index) => (
                        <div 
                            key={index} 
                            className={`group relative transform transition-all duration-1000 delay-${index * 200} ${
                                isVisible ? 'translate-y-0 opacity-100' : 'translate-y-10 opacity-0'
                            }`}
                            onMouseEnter={() => setHoveredIndex(index)}
                            onMouseLeave={() => setHoveredIndex(null)}
                        >
                            {/* Feature card */}
                            <div className={`relative h-full p-8 rounded-3xl transition-all duration-500 ${
                                isDark 
                                    ? 'bg-gray-800/50 backdrop-blur-sm border border-gray-700/50 hover:bg-gray-800/80' 
                                    : 'bg-white/80 backdrop-blur-sm border border-gray-200/50 hover:bg-white/90'
                            } hover:shadow-2xl hover:shadow-blue-500/10 group-hover:scale-105`}>
                                
                                {/* Glow effect */}
                                <div className={`absolute inset-0 rounded-3xl bg-gradient-to-br from-blue-500/10 to-purple-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500`}></div>
                                
                                {/* Icon container */}
                                {feature.icon && (
                                    <div className={`relative inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-6 transition-all duration-500 ${
                                        isDark 
                                            ? 'bg-gradient-to-br from-blue-600 to-purple-600 group-hover:from-blue-500 group-hover:to-purple-500' 
                                            : 'bg-gradient-to-br from-blue-100 to-purple-100 group-hover:from-blue-200 group-hover:to-purple-200'
                                    } group-hover:scale-110 group-hover:rotate-3`}>
                                        <span className="text-3xl group-hover:scale-110 transition-transform duration-300">
                                            {feature.icon}
                                        </span>
                                        
                                        {/* Icon glow */}
                                        <div className="absolute inset-0 rounded-2xl bg-gradient-to-br from-blue-500/20 to-purple-500/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    </div>
                                )}
                                
                                {/* Content */}
                                <div className="relative">
                                    <h3 className={`text-2xl font-bold mb-4 transition-colors duration-300 ${
                                        isDark ? 'text-white group-hover:text-blue-300' : 'text-gray-900 group-hover:text-blue-600'
                                    }`}>
                                        {feature.title}
                                    </h3>
                                    <p className={`text-lg leading-relaxed transition-colors duration-300 ${
                                        isDark ? 'text-gray-300 group-hover:text-gray-200' : 'text-gray-600 group-hover:text-gray-700'
                                    }`}>
                                        {feature.description}
                                    </p>
                                </div>

                                {/* Decorative elements */}
                                <div className="absolute top-4 right-4 w-2 h-2 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <div className="absolute bottom-4 left-4 w-1 h-1 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 delay-100"></div>
                                
                                {/* Hover line */}
                                <div className="absolute bottom-0 left-0 w-0 h-1 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full group-hover:w-full transition-all duration-500"></div>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}

export default FeaturesBlock;
