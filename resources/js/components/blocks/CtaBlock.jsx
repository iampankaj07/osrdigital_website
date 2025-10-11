import { useTheme } from '../../contexts/ThemeContext';
import { useEffect, useState, useRef } from 'react';

function CtaBlock({ data, settings, pageSettings }) {
    const { isDark } = useTheme();
    const [isVisible, setIsVisible] = useState(false);
    const sectionRef = useRef(null);
    
    const {
        title = 'Ready to get started?',
        description = 'Join thousands of satisfied customers who trust our platform.',
        primaryButton = { text: 'Get Started', url: '/contact' },
        secondaryButton = { text: 'Learn More', url: '/about' },
        alignment = 'center',
        backgroundColor = 'primary',
        padding = 'large'
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

    const alignmentClasses = {
        'left': 'text-left',
        'center': 'text-center',
        'right': 'text-right'
    };

    const paddingClasses = {
        'small': 'py-20',
        'normal': 'py-24',
        'large': 'py-32',
        'xlarge': 'py-40'
    };

    const backgroundClasses = {
        'primary': isDark ? 'bg-gradient-to-br from-gray-900 to-gray-800' : 'bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-900',
        'secondary': isDark ? 'bg-gradient-to-br from-gray-800 to-gray-900' : 'bg-gradient-to-br from-gray-800 to-gray-900',
        'accent': isDark ? 'bg-gradient-to-br from-brand-orange-900 to-red-900' : 'bg-gradient-to-br from-brand-orange-600 to-red-600',
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
                {/* Gradient overlay */}
                <div className="absolute inset-0 bg-gradient-to-r from-transparent via-white/5 to-transparent transform -skew-y-1"></div>
                
                {/* Floating particles */}
                {[...Array(30)].map((_, i) => (
                    <div
                        key={i}
                        className="absolute w-1 h-1 bg-white/20 rounded-full animate-pulse"
                        style={{
                            left: `${Math.random() * 100}%`,
                            top: `${Math.random() * 100}%`,
                            animationDelay: `${Math.random() * 3}s`,
                            animationDuration: `${2 + Math.random() * 2}s`
                        }}
                    />
                ))}
                
                {/* Geometric shapes */}
                {[...Array(15)].map((_, i) => (
                    <div
                        key={i}
                        className="absolute w-2 h-2 border border-white/10 rotate-45 animate-spin"
                        style={{
                            left: `${Math.random() * 100}%`,
                            top: `${Math.random() * 100}%`,
                            animationDelay: `${Math.random() * 5}s`,
                            animationDuration: `${10 + Math.random() * 10}s`
                        }}
                    />
                ))}
            </div>

            <div className="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className={`max-w-5xl mx-auto ${alignmentClasses[alignment]}`}>
                    <div className={`transform transition-all duration-1000 ${isVisible ? 'translate-y-0 opacity-100' : 'translate-y-10 opacity-0'}`}>
                        <h2 className={`text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-black mb-8 ${textColorClasses[backgroundColor]} bg-gradient-to-r from-white via-blue-100 to-purple-200 bg-clip-text text-transparent leading-tight`}>
                            {title}
                        </h2>
                        
                        {description && (
                            <p className={`text-xl md:text-2xl mb-12 max-w-4xl mx-auto leading-relaxed ${
                                backgroundColor === 'white' 
                                    ? (isDark ? 'text-gray-300' : 'text-gray-600')
                                    : 'text-gray-100'
                            }`}>
                                {description}
                            </p>
                        )}
                    </div>
                    
                    <div className={`flex flex-col sm:flex-row gap-6 justify-center transform transition-all duration-1000 delay-500 ${isVisible ? 'translate-y-0 opacity-100' : 'translate-y-10 opacity-0'}`}>
                        {primaryButton && primaryButton.text && (
                            <a
                                href={primaryButton.url || '#'}
                                className="group relative inline-flex items-center justify-center px-10 py-5 text-lg font-semibold text-white bg-gradient-to-r from-blue-600 to-purple-600 rounded-full hover:from-blue-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-300 shadow-2xl hover:shadow-blue-500/25"
                            >
                                <span className="relative z-10">{primaryButton.text}</span>
                                <div className="absolute inset-0 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full blur opacity-75 group-hover:opacity-100 transition-opacity duration-300"></div>
                                
                                {/* Animated border */}
                                <div className="absolute inset-0 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300 animate-pulse"></div>
                            </a>
                        )}
                        
                        {secondaryButton && secondaryButton.text && (
                            <a
                                href={secondaryButton.url || '#'}
                                className="group inline-flex items-center justify-center px-10 py-5 text-lg font-semibold text-white border-2 border-white/30 rounded-full hover:border-white/60 hover:bg-white/10 transition-all duration-300 backdrop-blur-sm"
                            >
                                {secondaryButton.text}
                                <svg className="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        )}
                    </div>
                </div>
            </div>

            {/* Decorative elements */}
            <div className="absolute top-1/4 left-1/4 w-32 h-32 bg-blue-500/10 rounded-full blur-3xl"></div>
            <div className="absolute bottom-1/4 right-1/4 w-40 h-40 bg-purple-500/10 rounded-full blur-3xl"></div>
        </section>
    );
}

export default CtaBlock;
