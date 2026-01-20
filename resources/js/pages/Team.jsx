import React, { useMemo, useCallback, useState, useEffect, Suspense, lazy } from 'react';
import { useTheme } from '../contexts/ThemeContext';
import { Link } from 'react-router-dom';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faUsers, faRocket, faLightbulb, faHandshake, faChartLine, faGlobe, faEnvelope, faQuoteLeft, faAward, faHeart, faCoffee, faGamepad } from '@fortawesome/free-solid-svg-icons';
import { faLinkedin as faLinkedinBrand, faTwitter as faTwitterBrand } from '@fortawesome/free-brands-svg-icons';
import CompactHero from '../components/sections/CompactHero';
import { getSafeImageUrl, handleAvatarError } from '../utils/imageUtils';

// Team Card Component - Memoized for performance
const TeamCard = React.memo(({ member, isDark }) => {
    const [imageLoaded, setImageLoaded] = useState(false);
    const [imageError, setImageError] = useState(false);

    const handleImageLoad = useCallback(() => {
        setImageLoaded(true);
    }, []);

    const handleImageError = useCallback(() => {
        setImageError(true);
    }, []);

    return (
        <div className={`group p-6 md:p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 ${isDark ? 'bg-gray-800 hover:bg-gray-700' : 'bg-white hover:bg-gray-50'}`}>
            <div className="text-center mb-6">
                {/* Avatar with loading skeleton */}
                <div className="relative w-24 h-24 mx-auto mb-4">
                    {!imageLoaded && !imageError && (
                        <div className={`absolute inset-0 rounded-full ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`} />
                    )}
                    <img
                        src={getSafeImageUrl(member.avatar, member.name, 300, 300)}
                        alt={`${member.name} avatar`}
                        loading="lazy"
                        className={`w-full h-full rounded-full object-cover transition-opacity duration-300 ${imageLoaded ? 'opacity-100' : 'opacity-0'}`}
                        onLoad={handleImageLoad}
                        onError={(e) => {
                            setImageError(true);
                            handleAvatarError(e, member.name, 300);
                        }}
                    />
                    {imageError && (
                        <div className={`absolute inset-0 rounded-full flex items-center justify-center ${isDark ? 'bg-gray-700' : 'bg-gray-200'}`}>
                            <span className={`text-2xl font-bold ${isDark ? 'text-gray-500' : 'text-gray-400'}`}>
                                {member.name.charAt(0).toUpperCase()}
                            </span>
                        </div>
                    )}
                </div>

                <h3 className={`text-xl font-bold mb-2 group-hover:text-brand-orange-600 dark:group-hover:text-brand-orange-400 transition-colors ${isDark ? 'text-white' : 'text-gray-900'}`}>
                    {member.name}
                </h3>
                <div className={`inline-flex items-center px-3 py-1 rounded-full text-sm font-medium mb-2 ${isDark ? 'bg-brand-orange-500/20 text-brand-orange-400' : 'bg-brand-orange-100 text-brand-orange-600'}`}>
                    {member.position || 'Team Member'}
                </div>
                <div className={`text-sm ${isDark ? 'text-gray-400' : 'text-gray-500'}`}>
                    {member.department || 'Department'}
                </div>
            </div>

            {/* Social Links */}
            <div className="flex justify-center space-x-3">
                {member.linkedin && (
                    <a
                        href={member.linkedin}
                        target="_blank"
                        rel="noopener noreferrer"
                        aria-label={`Visit ${member.name}'s LinkedIn`}
                        className={`p-2 rounded-full transition-all duration-300 ${isDark ? 'hover:bg-gray-600 text-gray-400 hover:text-blue-400' : 'hover:bg-gray-200 text-gray-500 hover:text-blue-600'}`}
                    >
                        <FontAwesomeIcon icon={faLinkedinBrand} />
                    </a>
                )}
                {member.twitter && (
                    <a
                        href={member.twitter}
                        target="_blank"
                        rel="noopener noreferrer"
                        aria-label={`Visit ${member.name}'s Twitter`}
                        className={`p-2 rounded-full transition-all duration-300 ${isDark ? 'hover:bg-gray-600 text-gray-400 hover:text-blue-400' : 'hover:bg-gray-200 text-gray-500 hover:text-blue-600'}`}
                    >
                        <FontAwesomeIcon icon={faTwitterBrand} />
                    </a>
                )}
                {member.email && (
                    <a
                        href={`mailto:${member.email}`}
                        aria-label={`Email ${member.name}`}
                        className={`p-2 rounded-full transition-all duration-300 ${isDark ? 'hover:bg-gray-600 text-gray-400 hover:text-brand-orange-400' : 'hover:bg-gray-200 text-gray-500 hover:text-brand-orange-600'}`}
                    >
                        <FontAwesomeIcon icon={faEnvelope} />
                    </a>
                )}
            </div>
        </div>
    );
});

TeamCard.displayName = 'TeamCard';

// Values Card Component - Memoized
const ValueCard = React.memo(({ value, isDark }) => (
    <div className={`p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 text-center ${isDark ? 'bg-gray-800 hover:bg-gray-700' : 'bg-gray-50 hover:bg-white'}`}>
        <div className="text-4xl mb-4 text-brand-orange-500">
            <i className={value.icon}></i>
        </div>
        <h3 className={`text-lg font-semibold mb-3 ${isDark ? 'text-white' : 'text-gray-900'}`}>
            {value.title}
        </h3>
        <p className={`text-sm line-clamp-3 ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
            {value.description}
        </p>
    </div>
));

ValueCard.displayName = 'ValueCard';

// Culture Card Component - Memoized
const CultureCard = React.memo(({ item, isDark }) => (
    <div className={`p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 text-center group ${isDark ? 'bg-gray-800 hover:bg-gray-700' : 'bg-white hover:bg-gray-50'}`}>
        <div className={`text-4xl mb-4 group-hover:scale-110 transition-transform duration-300 ${isDark ? 'text-brand-orange-400' : 'text-brand-orange-600'}`}>
            <FontAwesomeIcon icon={item.icon} />
        </div>
        <h3 className={`text-lg font-semibold mb-3 group-hover:text-brand-orange-600 dark:group-hover:text-brand-orange-400 transition-colors ${isDark ? 'text-white' : 'text-gray-900'}`}>
            {item.title}
        </h3>
        <p className={`text-sm line-clamp-3 ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
            {item.description}
        </p>
    </div>
));

CultureCard.displayName = 'CultureCard';

function Team() {
    const { isDark } = useTheme();
    const [teamMembers, setTeamMembers] = useState([]);
    const [values, setValues] = useState([]);
    const [isLoading, setIsLoading] = useState(true);
    const [error, setError] = useState(null);

    // Fetch team members data
    const fetchTeamMembers = useCallback(async () => {
        try {
            const response = await fetch('/api/team-members');
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            const data = await response.json();
            setTeamMembers(data.teamMembers || []);
        } catch (error) {
            console.error('Failed to load team members:', error);
            setError('Unable to load team members. Please try again later.');
            setTeamMembers([]);
        }
    }, []);

    // Fetch team values data
    const fetchTeamValues = useCallback(async () => {
        try {
            const response = await fetch('/api/team-values');
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            const data = await response.json();
            setValues(data.values || []);
        } catch (error) {
            console.error('Failed to load team values:', error);
            setValues([]);
        }
    }, []);

    useEffect(() => {
        document.title = "Our Team - OSR Digital";
        let metaDescription = document.querySelector('meta[name="description"]');
        if (!metaDescription) {
            metaDescription = document.createElement('meta');
            metaDescription.name = 'description';
            document.getElementsByTagName('head')[0].appendChild(metaDescription);
        }
        metaDescription.content = "Meet the talented team behind OSR Digital. Our diverse group of professionals is dedicated to bringing exceptional content to global audiences through innovative distribution strategies.";

        // Fetch data
        const fetchData = async () => {
            setIsLoading(true);
            await Promise.all([fetchTeamMembers(), fetchTeamValues()]);
            setIsLoading(false);
        };

        fetchData();
    }, [fetchTeamMembers, fetchTeamValues]);



    const culture = [
        {
            icon: faCoffee,
            title: "Flexible Work",
            description: "Remote-first culture with flexible hours and work-life balance"
        },
        {
            icon: faHeart,
            title: "Wellness Focus",
            description: "Comprehensive health benefits and mental wellness support"
        },
        {
            icon: faGamepad,
            title: "Fun Environment",
            description: "Regular team events, game nights, and creative challenges"
        },
        {
            icon: faAward,
            title: "Growth Opportunities",
            description: "Continuous learning, skill development, and career advancement"
        }
    ];

    return (
        <div className={`min-h-screen transition-colors duration-300 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
            {/* Hero Section */}
            <CompactHero
                page="team"
                title="Our Team"
                subtitle="Meet the Experts"
                description="Get to know the talented individuals who make OSR Digital a leader in content distribution and digital media."
            />

            {/* Team Members Section */}
            <section className={`py-16 md:py-24 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                <div className="container-minimal">
                    <div className="text-center max-w-3xl mx-auto mb-16">
                        <h2 className={`text-4xl font-extrabold mb-4 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                            Our Leadership Team
                        </h2>
                        <p className={`text-xl ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                            Experienced professionals leading the future of content distribution
                        </p>
                    </div>

                    {isLoading ? (
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            {[1, 2, 3, 4, 5, 6].map((i) => (
                                <div key={i} className={`p-8 rounded-lg shadow-lg ${isDark ? 'bg-gray-700' : 'bg-white'}`}>
                                    <div className="text-center mb-6">
                                        <div className={`w-24 h-24 rounded-full mx-auto mb-4 ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                        <div className={`h-6 w-32 mx-auto mb-2 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                        <div className={`h-4 w-40 mx-auto mb-2 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                        <div className={`h-4 w-24 mx-auto rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                    </div>
                                    <div className="space-y-3">
                                        <div className={`h-4 w-full rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                        <div className={`h-4 w-3/4 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                    </div>
                                    <div className="flex justify-center space-x-4 mt-6">
                                        <div className={`w-8 h-8 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                        <div className={`w-8 h-8 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                        <div className={`w-8 h-8 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    ) : teamMembers.length === 0 ? (
                        <div className={`p-12 rounded-xl text-center ${isDark ? 'bg-gray-800/50' : 'bg-gray-50'}`}>
                            <p className={`text-lg font-semibold ${isDark ? 'text-gray-400' : 'text-gray-600'}`}>No team members found</p>
                            <p className={`text-sm mt-2 ${isDark ? 'text-gray-500' : 'text-gray-500'}`}>Please add team members in the admin panel</p>
                        </div>
                    ) : (
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            {teamMembers.map((member) => (
                                <TeamCard key={member.id} member={member} isDark={isDark} />
                            ))}
                        </div>
                    )}
                </div>
            </section>

            {/* Company Values Section */}
            <section className={`py-16 md:py-24 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                <div className="container-minimal">
                    <div className="text-center max-w-3xl mx-auto mb-16">
                        <h2 className={`text-4xl font-extrabold mb-4 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                            Our Values
                        </h2>
                        <p className={`text-xl ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                            The principles that guide everything we do
                        </p>
                    </div>

                    {isLoading ? (
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                            {[1, 2, 3, 4].map((i) => (
                                <div key={i} className={`p-6 rounded-lg shadow-lg text-center ${isDark ? 'bg-gray-800' : 'bg-gray-50'}`}>
                                    <div className={`w-12 h-12 mx-auto mb-4 rounded-full ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                    <div className={`h-6 w-24 mx-auto mb-3 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                    <div className={`h-4 w-full mb-2 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                    <div className={`h-4 w-3/4 mx-auto rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                </div>
                            ))}
                        </div>
                    ) : values.length === 0 ? (
                        <div className={`p-12 rounded-xl text-center ${isDark ? 'bg-gray-800/50' : 'bg-gray-50'}`}>
                            <p className={`text-lg font-semibold ${isDark ? 'text-gray-400' : 'text-gray-600'}`}>No team values found</p>
                            <p className={`text-sm mt-2 ${isDark ? 'text-gray-500' : 'text-gray-500'}`}>Please add team values in the admin panel</p>
                        </div>
                    ) : (
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                            {values.map((value) => (
                                <ValueCard key={value.id} value={value} isDark={isDark} />
                            ))}
                        </div>
                    )}
                </div>
            </section>

            {/* Company Culture Section */}
            <section className={`py-16 md:py-24 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                <div className="container-minimal">
                    <div className="text-center max-w-3xl mx-auto mb-16">
                        <h2 className={`text-4xl font-extrabold mb-4 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                            Our Culture
                        </h2>
                        <p className={`text-xl ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                            What makes working at OSR Digital special
                        </p>
                    </div>

                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        {culture.map((item, index) => (
                            <CultureCard key={index} item={item} isDark={isDark} />
                        ))}
                    </div>
                </div>
            </section>

            {/* CTA removed as per design request */}
        </div>
    );
}

export default Team;
