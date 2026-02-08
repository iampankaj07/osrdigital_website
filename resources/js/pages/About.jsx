import React, { useCallback, useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { useTheme } from '../contexts/ThemeContext';
import CompactHero from '../components/sections/CompactHero';

// Mission/Vision Card Component - Memoized
const MissionVisionCard = React.memo(({ data, isDark, isVisible, delay = 0 }) => {
    if (!data) return null;

    return (
        <div
            className={`transform transition-all duration-1000 ${isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'}`}
            style={{ transitionDelay: `${delay}ms` }}
        >
            <div className={`h-full p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 group ${isDark ? 'bg-gradient-to-br from-gray-800 to-gray-900 hover:from-gray-700 hover:to-gray-800' : 'bg-gradient-to-br from-white to-gray-50 hover:to-white'}`}>
                <div className="mb-6">

                    <h2 className={`text-3xl font-bold mb-4 group-hover:text-brand-orange-600 dark:group-hover:text-brand-orange-400 transition-colors ${isDark ? 'text-white' : 'text-gray-900'
                        }`}>
                        {data.title}
                    </h2>
                    <div className="w-12 h-1 bg-brand-orange-500 rounded-full"></div>
                </div>
                <p className={`text-base leading-relaxed mb-6 ${isDark ? 'text-gray-300' : 'text-gray-700'
                    }`}>
                    {data.description}
                </p>
                {data.details && Array.isArray(data.details) && (
                    <ul className="space-y-3">
                        {data.details.map((detail, idx) => (
                            <li key={idx} className={`flex items-start space-x-3 ${isDark ? 'text-gray-300' : 'text-gray-700'}`}>
                                <span className="text-brand-orange-500 font-bold mt-0.5 text-lg">✓</span>
                                <span className="text-sm leading-relaxed">{detail}</span>
                            </li>
                        ))}
                    </ul>
                )}
            </div>
        </div>
    );
});

MissionVisionCard.displayName = 'MissionVisionCard';

// Values Card Component - Memoized
const ValueCard = React.memo(({ value, isDark, isVisible, delay }) => {
    if (!value) return null;

    return (
        <div className={`transform transition-all duration-1000 ${isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'
            }`} style={{ transitionDelay: `${delay}ms` }}>
            <div className={`p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 group h-full hover:-translate-y-1 ${isDark ? 'bg-gray-800 hover:bg-gray-700' : 'bg-gray-50 hover:bg-white'
                }`}>
                <div className="text-4xl mb-4 text-brand-orange-500 group-hover:scale-110 transition-transform duration-300">
                    <i className={value.icon}></i>
                </div>
                <h3 className={`text-xl font-semibold mb-3 group-hover:text-brand-orange-600 dark:group-hover:text-brand-orange-400 transition-colors ${isDark ? 'text-white' : 'text-gray-900'
                    }`}>
                    {value.title}
                </h3>
                <p className={`text-sm line-clamp-3 ${isDark ? 'text-gray-300' : 'text-gray-600'
                    }`}>
                    {value.description}
                </p>
            </div>
        </div>
    );
});

ValueCard.displayName = 'ValueCard';

// Services Card Component - Memoized
const ServiceCard = React.memo(({ service, isDark, isVisible, delay }) => {
    if (!service) return null;

    return (
        <div className={`transform transition-all duration-1000 ${isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'
            }`} style={{ transitionDelay: `${delay}ms` }}>
            <div className={`p-6 md:p-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 group h-full hover:-translate-y-1 ${isDark ? 'bg-gray-800 hover:bg-gray-700' : 'bg-white hover:bg-gray-50'
                }`}>
                <div className="text-5xl mb-4 text-brand-orange-500 group-hover:scale-110 transition-transform duration-300">
                    <i className={service.icon}></i>
                </div>
                <h3 className={`text-xl font-semibold mb-3 group-hover:text-brand-orange-600 dark:group-hover:text-brand-orange-400 transition-colors ${isDark ? 'text-white' : 'text-gray-900'
                    }`}>
                    {service.title}
                </h3>
                <p className={`text-sm line-clamp-3 ${isDark ? 'text-gray-300' : 'text-gray-600'
                    }`}>
                    {service.description}
                </p>
            </div>
        </div>
    );
});

ServiceCard.displayName = 'ServiceCard';

function About() {
    const { isDark } = useTheme();
    const [isVisible, setIsVisible] = useState(false);
    const [missionVision, setMissionVision] = useState({
        is_active: true,
        mission: {
            title: 'Our Mission',
            description: 'To bridge the gap between content creators and global audiences by acquiring rights to exceptional movies, songs, and short films, and distributing them through strategic YouTube publishing. We believe in the power of storytelling to connect cultures and inspire communities worldwide. Our mission extends to empowering independent creators by providing them with the platform, resources, and expertise needed to reach audiences they never thought possible. We are committed to fair partnerships, transparent monetization, and sustainable growth for all stakeholders in our ecosystem.',
            details: [
                'Connect exceptional creators with global audiences',
                'Provide fair and transparent partnership models',
                'Enable sustainable growth for independent artists',
                'Deliver high-quality content distribution strategies'
            ],
            icon: 'fas fa-bullseye'
        },
        vision: {
            title: 'Our Vision',
            description: 'To become the premier digital media company that brings diverse, high-quality entertainment content to screens worldwide, fostering cultural exchange and creative appreciation. We envision a world where great content knows no boundaries. By 2030, we aspire to be the trusted gateway for underrepresented creators and cultural content, revolutionizing how independent artists monetize and distribute their work globally. We aim to build a sustainable ecosystem where creativity is valued, innovation thrives, and communities are enriched through authentic, diverse storytelling.',
            details: [
                'The go-to platform for independent creators worldwide',
                'A bridge between diverse cultures and global audiences',
                'A model for ethical, sustainable content distribution',
                'A catalyst for creative innovation and cultural appreciation'
            ],
            icon: 'fas fa-rocket'
        },
        impact: {
            title: 'Our Impact',
            description: 'We measure success not just by numbers, but by the real difference we make. Every partnership strengthens the creative economy. Every view represents a connection between artist and audience. Every dollar earned supports creators pursuing their passion.',
            details: [
                'Creators empowered to reach global markets',
                'Communities enriched through quality content',
                'Cross-cultural understanding promoted',
                'Fair compensation for creative talent'
            ],
            icon: 'fas fa-heart'
        }
    });
    const [coreValues, setCoreValues] = useState({
        is_active: true,
        values: [
            {
                title: 'Innovation',
                description: 'We constantly explore new technologies and platforms to maximize content reach and engagement.',
                icon: 'fas fa-lightbulb'
            },
            {
                title: 'Quality',
                description: 'We maintain the highest standards in content curation and distribution strategies.',
                icon: 'fas fa-star'
            },
            {
                title: 'Partnership',
                description: 'We build lasting relationships with creators, platforms, and audiences worldwide.',
                icon: 'fas fa-handshake'
            },
            {
                title: 'Impact',
                description: 'We measure success by the positive impact our content has on global audiences.',
                icon: 'fas fa-chart-line'
            }
        ]
    });
    const [services, setServices] = useState({
        is_active: true,
        services: [
            {
                title: 'Content Acquisition',
                description: 'Strategic identification and acquisition of exceptional movies, music, and short films from creators worldwide.',
                icon: 'fas fa-bullseye'
            },
            {
                title: 'YouTube Publishing',
                description: 'Expert execution of strategic YouTube publishing campaigns to maximize reach and engagement.',
                icon: 'fas fa-play-circle'
            },
            {
                title: 'Global Distribution',
                description: 'Worldwide content distribution across multiple platforms and cultural markets.',
                icon: 'fas fa-globe'
            },
            {
                title: 'Creator Support',
                description: 'Comprehensive support for content creators throughout the entire distribution process.',
                icon: 'fas fa-palette'
            }
        ]
    });
    const [isLoading, setIsLoading] = useState(true);

    // Memoized fetch functions with useCallback
    const fetchServices = useCallback(async () => {
        try {
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 10000);

            const response = await fetch('/api/services', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                signal: controller.signal
            });

            clearTimeout(timeoutId);

            if (response.ok) {
                const data = await response.json();
                setServices(data);
            }
        } catch (error) {
            console.error('Failed to fetch services:', error);
        }
    }, []);

    const fetchCoreValues = useCallback(async () => {
        try {
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 10000);

            const response = await fetch('/api/core-values', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                signal: controller.signal
            });

            clearTimeout(timeoutId);

            if (response.ok) {
                const data = await response.json();
                setCoreValues(data);
            }
        } catch (error) {
            console.error('Failed to fetch core values:', error);
        }
    }, []);

    const fetchMissionVision = useCallback(async () => {
        try {
            setIsLoading(true);
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 10000);

            const response = await fetch('/api/mission-vision', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                signal: controller.signal
            });

            clearTimeout(timeoutId);

            if (response.ok) {
                const data = await response.json();
                // Merge API data with defaults to preserve impact field
                setMissionVision(prev => ({
                    ...prev,
                    ...data,
                    // Ensure impact always exists with default if not provided by API
                    impact: data.impact || prev.impact
                }));
            }
        } catch (error) {
            console.error('Failed to fetch mission & vision:', error);
        } finally {
            setIsLoading(false);
        }
    }, []);

    useEffect(() => {
        setIsVisible(true);
        document.title = 'About OSR Digital - Leading Content Distribution Company';

        // Fetch data
        fetchMissionVision();
        fetchCoreValues();
        fetchServices();
    }, [fetchMissionVision, fetchCoreValues, fetchServices]);




    return (
        <div className={`min-h-screen transition-colors duration-300 ${isDark ? 'bg-gray-900' : 'bg-white'
            }`}>
            {/* Hero Section */}
            <CompactHero
                page="about"
                title="About OSR Digital"
                subtitle="Movie Distribution Excellence"
                description="Learn more about our mission, vision, and the team behind OSR Digital's success in global content distribution."
            />


            {/* Mission & Vision Section */}
            {missionVision.is_active && (
                <section className={`py-20 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                    <div className="container-minimal">

                        {isLoading ? (
                            <div className="grid lg:grid-cols-3 gap-16">
                                {[1, 2, 3].map((i) => (
                                    <div key={i}>
                                        <div className="mb-6">
                                            <div className={`w-12 h-12 mb-4 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                            <div className={`h-10 w-48 mb-6 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                        </div>
                                        <div className="space-y-4">
                                            <div className={`h-4 w-full rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                            <div className={`h-4 w-4/5 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                            <div className={`h-4 w-3/4 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                        </div>
                                        <div className="mt-6 space-y-3">
                                            {[1, 2, 3, 4].map((j) => (
                                                <div key={j} className="flex items-center space-x-3">
                                                    <div className={`w-5 h-5 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast flex-shrink-0`}></div>
                                                    <div className={`h-3 w-full rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                                </div>
                                            ))}
                                        </div>
                                    </div>
                                ))}
                            </div>
                        ) : (
                            <div className="grid lg:grid-cols-3 gap-12">
                                <div className="group">
                                    {missionVision.mission && (
                                        <MissionVisionCard
                                            data={missionVision.mission}
                                            isDark={isDark}
                                            isVisible={isVisible}
                                            delay={0}
                                        />
                                    )}
                                </div>
                                <div className="group">
                                    {missionVision.vision && (
                                        <MissionVisionCard
                                            data={missionVision.vision}
                                            isDark={isDark}
                                            isVisible={isVisible}
                                            delay={150}
                                        />
                                    )}
                                </div>
                                <div className="group">
                                    {missionVision.impact && (
                                        <MissionVisionCard
                                            data={missionVision.impact}
                                            isDark={isDark}
                                            isVisible={isVisible}
                                            delay={300}
                                        />
                                    )}
                                </div>
                            </div>
                        )}
                    </div>
                </section>
            )}

            {/* Values Section */}
            <section className={`py-20 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                <div className="container-minimal">
                    <div className="text-center mb-16">
                        <h2 className={`text-4xl md:text-5xl font-bold mb-6 ${isDark ? 'text-white' : 'text-gray-900'
                            }`}>
                            Our Core Values
                        </h2>
                        <p className={`text-xl ${isDark ? 'text-gray-300' : 'text-gray-600'
                            }`}>
                            The principles that guide everything we do
                        </p>
                    </div>

                    <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                        {coreValues.values && coreValues.values.map((value, index) => (
                            <ValueCard
                                key={value.id || index}
                                value={value}
                                isDark={isDark}
                                isVisible={isVisible}
                                delay={index * 150}
                            />
                        ))}
                    </div>
                </div>
            </section>

            {/* Services Section */}
            <section className={`py-20 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                <div className="container-minimal">
                    <div className="text-center mb-16">
                        <h2 className={`text-4xl md:text-5xl font-bold mb-6 ${isDark ? 'text-white' : 'text-gray-900'
                            }`}>
                            What We Do
                        </h2>
                        <p className={`text-xl ${isDark ? 'text-gray-300' : 'text-gray-600'
                            }`}>
                            Comprehensive solutions for content creators and distributors
                        </p>
                    </div>

                    {isLoading ? (
                        <div className="grid md:grid-cols-2 gap-8">
                            {[1, 2, 3, 4].map((i) => (
                                <div key={i} className={`p-8 rounded-2xl border ${isDark ? 'bg-gray-800 border-gray-700' : 'bg-gray-50 border-gray-200'}`}>
                                    <div className="flex items-start space-x-4">
                                        <div className={`w-12 h-12 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast flex-shrink-0`}></div>
                                        <div className="flex-1">
                                            <div className={`h-6 w-32 mb-4 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                            <div className={`h-4 w-full mb-2 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                            <div className={`h-4 w-3/4 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    ) : (
                        <div className="grid md:grid-cols-2 gap-8">
                            {services.services && services.services.map((service, index) => (
                                <ServiceCard
                                    key={service.id || index}
                                    service={service}
                                    isDark={isDark}
                                    isVisible={isVisible}
                                    delay={index * 150}
                                />
                            ))}
                        </div>
                    )}
                </div>
            </section>

            {/* CTA Section */}
            <section className={`py-20 ${isDark ? 'bg-gradient-to-r from-gray-800 to-gray-900' : 'bg-gradient-to-r from-gray-100 to-gray-200'}`}>
                <div className="container-minimal">
                    <div className="text-center max-w-4xl mx-auto">
                        <h2 className={`text-4xl md:text-5xl font-bold mb-6 ${isDark ? 'text-white' : 'text-gray-900'
                            }`}>
                            Ready to Share Your Story?
                        </h2>
                        <p className={`text-xl mb-10 ${isDark ? 'text-gray-300' : 'text-gray-600'
                            }`}>
                            Join our network of creators and let us help you reach global audiences with your exceptional content.
                        </p>
                        <div className="flex flex-col sm:flex-row gap-4 justify-center">
                            <Link
                                to="/contact"
                                className="btn-minimal text-lg px-8 py-4"
                            >
                                Start Your Journey
                            </Link>
                            <Link
                                to="/partners"
                                className="btn-minimal-outline text-lg px-8 py-4"
                            >
                                View Our Partners
                            </Link>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    );
}

export default About;
