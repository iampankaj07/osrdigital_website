import { useState, useEffect } from 'react';
import { useTheme } from '../contexts/ThemeContext';
import { Link } from 'react-router-dom';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faUsers, faRocket, faLightbulb, faHandshake, faChartLine, faGlobe, faEnvelope, faQuoteLeft, faAward, faHeart, faCoffee, faGamepad } from '@fortawesome/free-solid-svg-icons';
import { faLinkedin as faLinkedinBrand, faTwitter as faTwitterBrand } from '@fortawesome/free-brands-svg-icons';
import DynamicHero from '../components/sections/DynamicHero';
import { getSafeImageUrl, handleAvatarError } from '../utils/imageUtils';

function Team() {
    const { isDark } = useTheme();
    const [isVisible, setIsVisible] = useState(false);
    const [teamMembers, setTeamMembers] = useState([]);
    const [values, setValues] = useState([]);
    const [isLoading, setIsLoading] = useState(true);

    // Fetch team members data
    const fetchTeamMembers = async () => {
        try {
            console.log('Fetching team members...');
            const response = await fetch('/api/team-members');
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const data = await response.json();
            console.log('Team members data:', data);
            setTeamMembers(data.teamMembers || []);
        } catch (error) {
            console.error('Error fetching team members:', error);
            // Fallback to static data
            setTeamMembers([
                {
                    name: "Sarah Chen",
                    position: "CEO & Founder",
                    department: "Leadership",
                    avatar: "https://via.placeholder.com/300x300/EC681D/FFFFFF?text=SC",
                    linkedin: "https://linkedin.com/in/sarahchen",
                    twitter: "https://twitter.com/sarahchen",
                    email: "sarah@osrdigital.com"
                },
                {
                    name: "Michael Rodriguez",
                    position: "CTO",
                    department: "Technology",
                    avatar: "https://via.placeholder.com/300x300/EC681D/FFFFFF?text=MR",
                    linkedin: "https://linkedin.com/in/michaelrodriguez",
                    twitter: "https://twitter.com/michaelrod",
                    email: "michael@osrdigital.com"
                },
                {
                    name: "Emma Thompson",
                    position: "Head of Content Strategy",
                    department: "Content",
                    avatar: "https://via.placeholder.com/300x300/EC681D/FFFFFF?text=ET",
                    linkedin: "https://linkedin.com/in/emmathompson",
                    twitter: "https://twitter.com/emmathompson",
                    email: "emma@osrdigital.com"
                },
                {
                    name: "David Park",
                    position: "Head of Partnerships",
                    department: "Business Development",
                    avatar: "https://via.placeholder.com/300x300/EC681D/FFFFFF?text=DP",
                    linkedin: "https://linkedin.com/in/davidpark",
                    twitter: "https://twitter.com/davidpark",
                    email: "david@osrdigital.com"
                },
                {
                    name: "Lisa Wang",
                    position: "Head of Marketing",
                    department: "Marketing",
                    avatar: "https://via.placeholder.com/300x300/EC681D/FFFFFF?text=LW",
                    linkedin: "https://linkedin.com/in/lisawang",
                    twitter: "https://twitter.com/lisawang",
                    email: "lisa@osrdigital.com"
                },
                {
                    name: "James Wilson",
                    position: "Head of Operations",
                    department: "Operations",
                    avatar: "https://via.placeholder.com/300x300/EC681D/FFFFFF?text=JW",
                    linkedin: "https://linkedin.com/in/jameswilson",
                    twitter: "https://twitter.com/jameswilson",
                    email: "james@osrdigital.com"
                }
            ]);
        }
    };

    // Fetch team values data
    const fetchTeamValues = async () => {
        try {
            console.log('Fetching team values...');
            const response = await fetch('/api/team-values');
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const data = await response.json();
            console.log('Team values data:', data);
            setValues(data.values || []);
        } catch (error) {
            console.error('Error fetching team values:', error);
            // Fallback to static data
            setValues([
                {
                    title: "Innovation",
                    description: "We constantly push boundaries and explore new technologies to stay ahead in the rapidly evolving digital landscape.",
                    icon: "fas fa-lightbulb"
                },
                {
                    title: "Collaboration",
                    description: "We believe in the power of teamwork and foster an environment where every voice is heard and valued.",
                    icon: "fas fa-handshake"
                },
                {
                    title: "Excellence",
                    description: "We strive for the highest standards in everything we do, from content curation to client service.",
                    icon: "fas fa-chart-line"
                },
                {
                    title: "Global Impact",
                    description: "We're committed to making content accessible worldwide and celebrating diverse voices and cultures.",
                    icon: "fas fa-globe"
                }
            ]);
        }
    };

    useEffect(() => {
        setIsVisible(true);
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
    }, []);



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
            <DynamicHero page="team" />

            {/* Team Members Section */}
            <section className={`py-16 md:py-24 ${isDark ? 'bg-gray-800' : 'bg-gray-50'}`}>
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
                        <div className="text-center py-12">
                            <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-purple-600 mx-auto mb-4"></div>
                            <p className={`text-lg ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>Loading team members...</p>
                        </div>
                    ) : (
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            {teamMembers.map((member, index) => (
                            <div key={index} className={`p-8 rounded-lg shadow-lg transition-all duration-300 hover:shadow-xl ${
                                isDark ? 'bg-gray-700 hover:bg-gray-600' : 'bg-white hover:bg-gray-50'
                            }`}>
                                <div className="text-center mb-6">
                                    <img 
                                        src={getSafeImageUrl(member.avatar, member.name, 300, 300)} 
                                        alt={`${member.name} avatar`}
                                        className="w-24 h-24 rounded-full mx-auto mb-4 object-cover"
                                        onError={(e) => handleAvatarError(e, member.name, 300)}
                                    />
                                    <h3 className={`text-2xl font-bold mb-2 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                        {member.name}
                                    </h3>
                                    <div className={`inline-flex items-center px-3 py-1 rounded-full text-sm font-medium mb-2 ${
                                        isDark ? 'bg-brand-orange-500/20 text-brand-orange-400' : 'bg-brand-orange-100 text-brand-orange-600'
                                    }`}>
                                        {member.position}
                                    </div>
                                    <div className={`text-sm ${isDark ? 'text-gray-400' : 'text-gray-500'}`}>
                                        {member.department}
                                    </div>
                                </div>

                                <div className="flex justify-center space-x-4">
                                    <a 
                                        href={member.linkedin} 
                                        target="_blank" 
                                        rel="noopener noreferrer"
                                        className={`p-2 rounded-full transition-colors ${
                                            isDark ? 'hover:bg-gray-600 text-gray-400 hover:text-blue-400' : 'hover:bg-gray-200 text-gray-500 hover:text-blue-600'
                                        }`}
                                    >
                                        <FontAwesomeIcon icon={faLinkedinBrand} />
                                    </a>
                                    <a 
                                        href={member.twitter} 
                                        target="_blank" 
                                        rel="noopener noreferrer"
                                        className={`p-2 rounded-full transition-colors ${
                                            isDark ? 'hover:bg-gray-600 text-gray-400 hover:text-blue-400' : 'hover:bg-gray-200 text-gray-500 hover:text-blue-600'
                                        }`}
                                    >
                                        <FontAwesomeIcon icon={faTwitterBrand} />
                                    </a>
                                    <a 
                                        href={`mailto:${member.email}`}
                                        className={`p-2 rounded-full transition-colors ${
                                            isDark ? 'hover:bg-gray-600 text-gray-400 hover:text-brand-orange-400' : 'hover:bg-gray-200 text-gray-500 hover:text-brand-orange-600'
                                        }`}
                                    >
                                        <FontAwesomeIcon icon={faEnvelope} />
                                    </a>
                                </div>
                            </div>
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
                        <div className="text-center py-12">
                            <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-purple-600 mx-auto mb-4"></div>
                            <p className={`text-lg ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>Loading team values...</p>
                        </div>
                    ) : (
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                            {values.map((value, index) => (
                                <div key={index} className={`p-6 rounded-lg shadow-lg text-center ${
                                    isDark ? 'bg-gray-800' : 'bg-gray-50'
                                }`}>
                                    <div className="text-4xl mb-4" style={{color: '#EC681D'}}>
                                        <i className={value.icon}></i>
                                    </div>
                                    <h3 className={`text-xl font-semibold mb-3 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                        {value.title}
                                    </h3>
                                    <p className={`${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                                        {value.description}
                                    </p>
                                </div>
                            ))}
                        </div>
                    )}
                </div>
            </section>

            {/* Company Culture Section */}
            <section className={`py-16 md:py-24 ${isDark ? 'bg-gray-800' : 'bg-gray-50'}`}>
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
                            <div key={index} className={`p-6 rounded-lg shadow-lg text-center ${
                                isDark ? 'bg-gray-700' : 'bg-white'
                            }`}>
                                <div className={`text-4xl mb-4 ${isDark ? 'text-brand-orange-400' : 'text-brand-orange-600'}`}>
                                    <FontAwesomeIcon icon={item.icon} />
                                </div>
                                <h3 className={`text-xl font-semibold mb-3 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                    {item.title}
                                </h3>
                                <p className={`${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                                    {item.description}
                                </p>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            {/* CTA Section */}
            <section className={`py-16 md:py-24 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                <div className="container-minimal text-center max-w-4xl mx-auto">
                    <div className={`p-12 rounded-2xl ${
                        isDark ? 'bg-gradient-to-br from-gray-800 to-gray-700' : 'bg-gradient-to-br from-gray-50 to-gray-100'
                    }`}>
                        <h2 className={`text-4xl font-extrabold mb-6 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                            Ready to Join Our Team?
                        </h2>
                        <p className={`text-xl mb-10 ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                            We're always looking for talented individuals who share our passion for content distribution and global impact.
                        </p>
                        <div className="flex flex-col sm:flex-row gap-4 justify-center items-center">
                            <Link to="/contact" className="btn-minimal">
                                View Open Positions
                            </Link>
                            <Link to="/about" className="btn-minimal-outline">
                                Learn More About Us
                            </Link>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    );
}

export default Team;