import { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { useTheme } from '../contexts/ThemeContext';
import DynamicHero from '../components/sections/DynamicHero';

function About() {
    const { isDark } = useTheme();
    const [isVisible, setIsVisible] = useState(false);
    const [missionVision, setMissionVision] = useState({
        is_active: true,
        mission: {
            title: 'Our Mission',
            description: 'To bridge the gap between content creators and global audiences by acquiring rights to exceptional movies, songs, and short films, and distributing them through strategic YouTube publishing. We believe in the power of storytelling to connect cultures and inspire communities worldwide.',
            icon: 'fas fa-bullseye'
        },
        vision: {
            title: 'Our Vision',
            description: 'To become the premier digital media company that brings diverse, high-quality entertainment content to screens worldwide, fostering cultural exchange and creative appreciation. We envision a world where great content knows no boundaries.',
            icon: 'fas fa-rocket'
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

    const fetchServices = async () => {
        try {
            console.log('Fetching services data...');
            
            // Create AbortController for timeout
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 10000); // 10 second timeout

            const response = await fetch('/api/services', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                signal: controller.signal
            });

            clearTimeout(timeoutId);
            console.log('Services response status:', response.status);

            if (response.ok) {
                const data = await response.json();
                console.log('Services data received:', data);
                setServices(data);
                console.log('Services state updated successfully!');
            } else {
                console.error('Failed to fetch services data:', response.status);
                const errorText = await response.text();
                console.error('Error response:', errorText);
            }
        } catch (error) {
            if (error.name === 'AbortError') {
                console.error('Services request timed out');
            } else {
                console.error('Error fetching services:', error);
            }
        }
    };

    const fetchCoreValues = async () => {
        try {
            console.log('Fetching core values data...');
            
            // Create AbortController for timeout
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 10000); // 10 second timeout

            const response = await fetch('/api/core-values', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                signal: controller.signal
            });

            clearTimeout(timeoutId);
            console.log('Core Values response status:', response.status);

            if (response.ok) {
                const data = await response.json();
                console.log('Core Values data received:', data);
                setCoreValues(data);
                console.log('Core Values state updated successfully!');
            } else {
                console.error('Failed to fetch core values data:', response.status);
                const errorText = await response.text();
                console.error('Error response:', errorText);
            }
        } catch (error) {
            if (error.name === 'AbortError') {
                console.error('Core Values request timed out');
            } else {
                console.error('Error fetching core values:', error);
            }
        }
    };

    const fetchMissionVision = async () => {
        try {
            console.log('Fetching mission & vision data...');
            setIsLoading(true);
            
            // Create AbortController for timeout
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 10000); // 10 second timeout
            
            const response = await fetch('/api/mission-vision', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                signal: controller.signal
            });
            
            clearTimeout(timeoutId);
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);
            
            if (response.ok) {
                const data = await response.json();
                console.log('Mission & Vision data received:', data);
                setMissionVision(data);
                console.log('Mission & Vision state updated successfully!');
            } else {
                console.error('Failed to fetch mission & vision data:', response.status);
                const errorText = await response.text();
                console.error('Error response:', errorText);
            }
        } catch (error) {
            if (error.name === 'AbortError') {
                console.error('Request timed out');
            } else {
                console.error('Error fetching mission & vision:', error);
            }
        } finally {
            setIsLoading(false);
        }
    };

    useEffect(() => {
        setIsVisible(true);
        document.title = 'About OSR Digital - Leading Content Distribution Company';
        
        // Fetch Mission & Vision data
        fetchMissionVision();
        
        // Fetch Core Values data
        fetchCoreValues();
        
        // Fetch Services data
        fetchServices();
    }, []);




    return (
        <div className={`min-h-screen transition-colors duration-300 ${
            isDark ? 'bg-gray-900' : 'bg-white'
        }`}>
            {/* Hero Section */}
            <DynamicHero page="about" />


            {/* Mission & Vision Section */}
            {missionVision.is_active && (
                <section className={`py-20 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                    <div className="container-minimal">
                        
                        {isLoading ? (
                            <div className="text-center py-20">
                                <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-purple-600 mx-auto mb-4"></div>
                                <p className={`text-lg ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>Loading Mission & Vision...</p>
                            </div>
                        ) : (
                            <div className="grid lg:grid-cols-2 gap-16 items-center">
                        {/* Mission */}
                        <div className={`transform transition-all duration-1000 ${
                            isVisible ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-10'
                        }`}>
                            <div className="mb-6">
                                <div className="text-4xl mb-4" style={{color: '#EC681D'}}>
                                    <i className={missionVision.mission.icon}></i>
                                </div>
                                <h2 className={`text-4xl font-bold mb-6 ${
                                    isDark ? 'text-white' : 'text-gray-900'
                                }`}>
                                    {missionVision.mission.title}
                                </h2>
                            </div>
                            <p className={`text-lg leading-relaxed ${
                                isDark ? 'text-gray-300' : 'text-gray-600'
                            }`}>
                                {missionVision.mission.description}
                            </p>
                        </div>

                        {/* Vision */}
                        <div className={`transform transition-all duration-1000 delay-300 ${
                            isVisible ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-10'
                        }`}>
                            <div className="mb-6">
                                <div className="text-4xl mb-4" style={{color: '#EC681D'}}>
                                    <i className={missionVision.vision.icon}></i>
                                </div>
                                <h2 className={`text-4xl font-bold mb-6 ${
                                    isDark ? 'text-white' : 'text-gray-900'
                                }`}>
                                    {missionVision.vision.title}
                                </h2>
                            </div>
                            <p className={`text-lg leading-relaxed ${
                                isDark ? 'text-gray-300' : 'text-gray-600'
                            }`}>
                                {missionVision.vision.description}
                            </p>
                        </div>
                        </div>
                    )}
                    </div>
                </section>
            )}

            {/* Values Section */}
            <section className={`py-20 ${isDark ? 'bg-gray-800' : 'bg-gray-50'}`}>
                <div className="container-minimal">
                    <div className="text-center mb-16">
                        <h2 className={`text-4xl md:text-5xl font-bold mb-6 ${
                            isDark ? 'text-white' : 'text-gray-900'
                        }`}>
                            Our Core Values
                        </h2>
                        <p className={`text-xl ${
                            isDark ? 'text-gray-300' : 'text-gray-600'
                        }`}>
                            The principles that guide everything we do
                        </p>
                    </div>

                    <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                        {coreValues.values.map((value, index) => (
                            <div key={index} className={`transform transition-all duration-1000 delay-${index * 200} ${
                                isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'
                            } text-center p-6 rounded-2xl ${
                                isDark ? 'bg-gray-700/50 hover:bg-gray-700' : 'bg-white hover:bg-gray-50'
                            } transition-all duration-300`}>
                                <div className="text-4xl mb-4" style={{color: '#EC681D'}}>
                                    <i className={value.icon}></i>
                                </div>
                                <h3 className={`text-xl font-bold mb-4 ${
                                    isDark ? 'text-white' : 'text-gray-900'
                                }`}>
                                    {value.title}
                                </h3>
                                <p className={`text-sm leading-relaxed ${
                                    isDark ? 'text-gray-300' : 'text-gray-600'
                                }`}>
                                    {value.description}
                                </p>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            {/* Services Section */}
            <section className={`py-20 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                <div className="container-minimal">
                    <div className="text-center mb-16">
                        <h2 className={`text-4xl md:text-5xl font-bold mb-6 ${
                            isDark ? 'text-white' : 'text-gray-900'
                        }`}>
                            What We Do
                        </h2>
                        <p className={`text-xl ${
                            isDark ? 'text-gray-300' : 'text-gray-600'
                        }`}>
                            Comprehensive solutions for content creators and distributors
                        </p>
                    </div>

                    <div className="grid md:grid-cols-2 gap-8">
                        {services.services.map((service, index) => (
                            <div key={index} className={`transform transition-all duration-1000 delay-${index * 200} ${
                                isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'
                            } p-8 rounded-2xl border ${
                                isDark ? 'bg-gray-800 border-gray-700 hover:border-brand-orange-500/30' : 'bg-gray-50 border-gray-200 hover:border-brand-orange-200'
                            } transition-all duration-300`}>
                                <div className="flex items-start space-x-4">
                                    <div className="text-3xl" style={{color: '#EC681D'}}>
                                        <i className={service.icon}></i>
                                    </div>
                                    <div>
                                        <h3 className={`text-xl font-bold mb-3 ${
                                            isDark ? 'text-white' : 'text-gray-900'
                                        }`}>
                                            {service.title}
                                        </h3>
                                        <p className={`leading-relaxed ${
                                            isDark ? 'text-gray-300' : 'text-gray-600'
                                        }`}>
                                            {service.description}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            {/* CTA Section */}
            <section className={`py-20 ${isDark ? 'bg-gradient-to-r from-gray-800 to-gray-900' : 'bg-gradient-to-r from-gray-100 to-gray-200'}`}>
                <div className="container-minimal">
                    <div className="text-center max-w-4xl mx-auto">
                        <h2 className={`text-4xl md:text-5xl font-bold mb-6 ${
                            isDark ? 'text-white' : 'text-gray-900'
                        }`}>
                            Ready to Share Your Story?
                        </h2>
                        <p className={`text-xl mb-10 ${
                            isDark ? 'text-gray-300' : 'text-gray-600'
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