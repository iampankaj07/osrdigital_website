
import { Link } from 'react-router-dom';
import { useState, useEffect, useRef } from 'react';
import { useAllSettings } from '../../hooks/useSettings';
import { useTheme } from '../../contexts/ThemeContext';

function Hero() {
    const { getSetting, loading, error } = useAllSettings();
    const { isDark } = useTheme();
    const [mousePosition, setMousePosition] = useState({ x: 0, y: 0 });
    const heroRef = useRef(null);

    useEffect(() => {
        const handleMouseMove = (e) => {
            if (heroRef.current) {
                const rect = heroRef.current.getBoundingClientRect();
                setMousePosition({
                    x: e.clientX - rect.left,
                    y: e.clientY - rect.top
                });
            }
        };

        const heroElement = heroRef.current;
        if (heroElement) {
            heroElement.addEventListener('mousemove', handleMouseMove);
            return () => heroElement.removeEventListener('mousemove', handleMouseMove);
        }
    }, []);

    // Show loading skeleton while settings are being fetched
    if (loading) {
        return (
            <section className="relative h-[100vh] flex items-center justify-center overflow-hidden pt-24 bg-white">
                <div className="relative z-10 text-center px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto">
                    <div className="animate-pulse">
                        <div className="h-8 rounded-full w-48 mx-auto mb-6 bg-gray-300"></div>
                        <div className="h-16 rounded-lg mb-6 bg-gray-300"></div>
                        <div className="h-6 rounded-lg mb-8 max-w-3xl mx-auto bg-gray-300"></div>
                        <div className="flex gap-4 justify-center mb-8">
                            <div className="h-12 rounded-lg w-32 bg-gray-300"></div>
                            <div className="h-12 rounded-lg w-32 bg-gray-300"></div>
                        </div>
                        <div className="grid grid-cols-2 lg:grid-cols-4 gap-6">
                            {[1, 2, 3, 4].map(i => (
                                <div key={i} className="h-16 rounded-lg bg-gray-300"></div>
                            ))}
                        </div>
                    </div>
                </div>
            </section>
        );
    }

    return (
        <section
            ref={heroRef}
            className="relative h-[100vh] flex items-center justify-center overflow-hidden pt-24 bg-white"
        >
            {/* Content */}
            <div className="relative z-20 text-center px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto">
                {/* Clean Container without backdrop blur */}
                <div className="relative p-4">
                    <div className="relative">
                    <div className="mb-6">
                        <div className="inline-flex items-center px-4 py-2 rounded-full text-[#ff6b35] text-sm font-medium mb-6"
                             style={{
                                 backgroundColor: isDark ? 'rgba(255, 107, 53, 0.15)' : 'rgba(255, 107, 53, 0.1)',
                                 color: '#ff6b35'
                             }}>
                            <span className="w-2 h-2 rounded-full mr-2"
                                  style={{ backgroundColor: '#ff6b35' }}></span>
                            {getSetting('hero_badge_text', 'Digital Media Excellence')}
                        </div>
                    </div>

                <h1 className={`text-4xl md:text-6xl lg:text-7xl font-bold mb-6 leading-tight ${
                    isDark ? 'text-white' : 'text-gray-900'
                }`}>
                    {getSetting('hero_main_title', 'Bringing Stories to')}{' '}
                    <span style={{ color: '#ff6b35' }}>
                        {getSetting('hero_highlighted_title', 'Global Screens')}
                    </span>
                </h1>

                <p className={`text-lg md:text-xl mb-8 max-w-3xl mx-auto leading-relaxed ${
                    isDark ? 'text-gray-300' : 'text-gray-600'
                }`}>
                    {getSetting('hero_description', 'OSR Digital specializes in acquiring exceptional entertainment content and strategically distributing it to worldwide audiences through cutting-edge digital platforms.')}
                </p>

                <div className="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
                    <Link
                        to="/contact"
                        className="hover:opacity-90 text-white px-8 py-3 rounded-lg text-base font-semibold transition-all flex items-center gap-2"
                        style={{ backgroundColor: '#ff6b35' }}
                    >
                        <span>{getSetting('hero_primary_button_text', 'Partner With Us')}</span>
                        <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </Link>

                    <Link
                        to="/portfolio"
                        className={`px-8 py-3 rounded-lg text-base font-semibold transition-all flex items-center gap-2 ${
                            isDark
                                ? 'text-gray-300 hover:text-white hover:bg-white/5'
                                : 'text-gray-600 hover:text-gray-900 hover:bg-black/5'
                        }`}
                    >
                        <svg className={`w-4 h-4 ${isDark ? 'text-white' : 'text-gray-700'}`} fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{getSetting('hero_secondary_button_text', 'Explore Portfolio')}</span>
                    </Link>
                </div>
                    </div>
                </div>
            </div>

            {/* Scroll Indicator */}
            <div className="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce z-20">
                <div className={`w-6 h-10 rounded-full flex justify-center ${
                    isDark ? 'bg-white/10' : 'bg-black/10'
                }`}>
                    <div className={`w-1 h-3 rounded-full mt-2 animate-pulse ${
                        isDark ? 'bg-white/60' : 'bg-black/60'
                    }`}></div>
                </div>
            </div>
        </section>
    );
}

export default Hero;
