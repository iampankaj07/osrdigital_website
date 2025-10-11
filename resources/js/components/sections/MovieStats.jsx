import { useState, useEffect } from 'react';
import { useTheme } from '../../contexts/ThemeContext';

function MovieStats() {
    const { isDark } = useTheme();
    const [isVisible, setIsVisible] = useState(false);

    const stats = [
        {
            number: "500+",
            label: "Films Distributed",
            description: "Successfully distributed across global markets"
        },
        {
            number: "50M+",
            label: "Global Viewers",
            description: "Reached audiences worldwide"
        },
        {
            number: "150+",
            label: "Countries",
            description: "Active distribution territories"
        },
        {
            number: "25+",
            label: "Streaming Platforms",
            description: "Partner platforms worldwide"
        }
    ];

    // Intersection Observer for animation
    useEffect(() => {
        const observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) {
                    setIsVisible(true);
                }
            },
            { threshold: 0.1 }
        );

        const element = document.getElementById('movie-stats');
        if (element) {
            observer.observe(element);
        }

        return () => {
            if (element) {
                observer.unobserve(element);
            }
        };
    }, []);

    return (
        <section 
            id="movie-stats"
            className={`section-minimal ${isDark ? 'bg-gray-900' : 'bg-gray-50'}`}
        >
            <div className="container-minimal">
                {/* Header */}
                <div className="text-center mb-16">
                    <h2 className={`text-3xl md:text-4xl font-bold mb-6 text-minimal-bold ${
                        isDark ? 'text-white' : 'text-gray-900'
                    }`}>
                        Our Global Impact
                    </h2>
                    <p className={`text-lg max-w-3xl mx-auto text-minimal ${
                        isDark ? 'text-gray-300' : 'text-gray-600'
                    }`}>
                        Numbers that speak to our success in bringing exceptional content 
                        to audiences around the world.
                    </p>
                </div>

                {/* Stats Grid */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    {stats.map((stat, index) => (
                        <div
                            key={index}
                            className={`text-center p-6 rounded-xl transition-all duration-200 hover-subtle ${
                                isDark 
                                    ? 'card-minimal-dark hover:border-brand-orange-500/30' 
                                    : 'card-minimal hover:border-brand-orange-200'
                            }`}
                        >
                            <div 
                                className={`text-4xl md:text-5xl font-bold mb-4 transition-all duration-1000 ${
                                    isVisible ? 'animate-fade-in-up' : 'opacity-0'
                                } ${
                                    isDark ? 'text-brand-orange-400' : 'text-brand-orange-600'
                                }`}
                                style={{
                                    animationDelay: `${index * 200}ms`,
                                    animationFillMode: 'forwards'
                                }}
                            >
                                {isVisible ? stat.number : '0'}
                            </div>
                            
                            <h3 className={`text-lg font-semibold mb-2 text-minimal-bold ${
                                isDark ? 'text-white' : 'text-gray-900'
                            }`}>
                                {stat.label}
                            </h3>
                            
                            <p className={`text-sm text-minimal ${
                                isDark ? 'text-gray-300' : 'text-gray-600'
                            }`}>
                                {stat.description}
                            </p>
                        </div>
                    ))}
                </div>

                {/* Additional Info */}
                <div className="mt-16">
                    <div className={`max-w-4xl mx-auto p-8 rounded-xl ${
                        isDark 
                            ? 'bg-gray-800 border border-gray-700' 
                            : 'bg-white border border-gray-200'
                    }`}>
                        <h3 className={`text-xl font-bold mb-4 text-center ${
                            isDark ? 'text-white' : 'text-gray-900'
                        }`}>
                            Trusted by Industry Leaders
                        </h3>
                        <p className={`text-center text-minimal ${
                            isDark ? 'text-gray-300' : 'text-gray-600'
                        }`}>
                            We've built lasting partnerships with major studios, independent filmmakers, 
                            and streaming platforms worldwide, establishing ourselves as a premier 
                            distribution company in the entertainment industry.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    );
}

export default MovieStats;
