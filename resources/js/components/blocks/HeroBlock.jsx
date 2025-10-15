import { useTheme } from '../../contexts/ThemeContext';
import { useEffect, useState } from 'react';

function HeroBlock({ data, settings, pageSettings }) {
    const { isDark } = useTheme();
    const [isVisible, setIsVisible] = useState(false);
    
    const {
        title = 'Welcome to OSR Digital',
        subtitle = 'Leading digital content distribution company',
        description = 'We help creators and businesses distribute their content across multiple platforms and reach global audiences.',
        primaryButton = { text: 'Get Started', url: '/contact' },
        secondaryButton = { text: 'Learn More', url: '/about' },
        backgroundImage = null,
        backgroundVideo = null,
        overlay = true,
        alignment = 'center',
        height = 'full'
    } = data;

    useEffect(() => {
        setIsVisible(true);
    }, []);

    const heightClasses = {
        'full': 'min-h-screen',
        'large': 'min-h-[80vh]',
        'medium': 'min-h-[60vh]',
        'small': 'min-h-[40vh]'
    };

    const alignmentClasses = {
        'left': 'text-left',
        'center': 'text-center',
        'right': 'text-right'
    };

    return (
        <section className={`relative ${heightClasses[height]} flex items-center justify-center overflow-hidden`}>
            {/* Animated Background */}
            {backgroundVideo ? (
                <video
                    className="absolute inset-0 w-full h-full object-cover"
                    autoPlay
                    muted
                    loop
                    playsInline
                >
                    <source src={backgroundVideo} type="video/mp4" />
                </video>
            ) : backgroundImage ? (
                <div
                    className="absolute inset-0 w-full h-full bg-cover bg-center bg-no-repeat"
                    style={{ backgroundImage: `url(${backgroundImage})` }}
                />
            ) : (
                <div className="absolute inset-0">
                    {/* Animated gradient background */}
                    <div className={`absolute inset-0 ${
                        isDark 
                            ? 'bg-gradient-to-br from-gray-900 via-purple-900 to-indigo-900' 
                            : 'bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-900'
                    }`} />
                    
                    {/* Animated particles */}
                    <div className="absolute inset-0">
                        {[...Array(100)].map((_, i) => (
                            <div
                                key={i}
                                className="absolute w-1 h-1 bg-white/20 rounded-full skeleton-fast"
                                style={{
                                    left: `${Math.random() * 100}%`,
                                    top: `${Math.random() * 100}%`,
                                    animationDelay: `${Math.random() * 3}s`,
                                    animationDuration: `${2 + Math.random() * 3}s`
                                }}
                            />
                        ))}
                    </div>
                    
                    {/* Floating geometric shapes */}
                    <div className="absolute inset-0">
                        {[...Array(20)].map((_, i) => (
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
                </div>
            )}

            {/* Overlay */}
            {overlay && (
                <div className="absolute inset-0 bg-black/40" />
            )}

            {/* Content */}
            <div className={`relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 ${alignmentClasses[alignment]}`}>
                <div className="max-w-5xl mx-auto">
                    <div className={`transform transition-all duration-1000 ${isVisible ? 'translate-y-0 opacity-100' : 'translate-y-10 opacity-0'}`}>
                        {subtitle && (
                            <p className={`text-lg md:text-xl font-medium mb-6 ${
                                isDark ? 'text-orange-400' : 'text-orange-300'
                            } animate-fade-in`}>
                                {subtitle}
                            </p>
                        )}
                        
                        <h1 className={`text-5xl sm:text-6xl lg:text-7xl xl:text-8xl font-black mb-8 leading-tight ${
                            isDark ? 'text-white' : 'text-white'
                        } bg-gradient-to-r from-white via-blue-100 to-purple-200 bg-clip-text text-transparent`}>
                            {title}
                        </h1>
                        
                        {description && (
                            <p className={`text-xl md:text-2xl mb-12 max-w-4xl mx-auto leading-relaxed ${
                                isDark ? 'text-gray-300' : 'text-gray-100'
                            }`}>
                                {description}
                            </p>
                        )}
                    </div>
                    
                    <div className={`flex flex-col sm:flex-row gap-6 justify-center transform transition-all duration-1000 delay-500 ${isVisible ? 'translate-y-0 opacity-100' : 'translate-y-10 opacity-0'}`}>
                        {primaryButton && primaryButton.text && (
                            <a
                                href={primaryButton.url || '#'}
                                className="group relative inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white bg-gradient-to-r from-blue-600 to-purple-600 rounded-full hover:from-blue-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-300 shadow-2xl hover:shadow-blue-500/25"
                            >
                                <span className="relative z-10">{primaryButton.text}</span>
                                <div className="absolute inset-0 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full blur opacity-75 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </a>
                        )}
                        
                        {secondaryButton && secondaryButton.text && (
                            <a
                                href={secondaryButton.url || '#'}
                                className="group inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white border-2 border-white/30 rounded-full hover:border-white/60 hover:bg-white/10 transition-all duration-300 backdrop-blur-sm"
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

            {/* Scroll indicator */}
            <div className="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
                <div className="w-6 h-10 border-2 border-white/30 rounded-full flex justify-center">
                    <div className="w-1 h-3 bg-white/60 rounded-full mt-2 skeleton-fast"></div>
                </div>
            </div>
        </section>
    );
}

export default HeroBlock;
