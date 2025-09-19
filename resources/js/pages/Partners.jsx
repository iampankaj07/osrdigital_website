import { useState, useEffect } from 'react';
import { useTheme } from '../contexts/ThemeContext';
import PageHeader from '../components/PageHeader';

function Partners() {
    const { isDark } = useTheme();
    const [partners, setPartners] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        // Fetch partners from API
        fetch('/api/partners')
            .then(response => response.json())
            .then(data => {
                setPartners(data);
                setLoading(false);
            })
            .catch(error => {
                console.error('Error fetching partners:', error);
                setLoading(false);
                // Fallback data
                setPartners([
                    {
                        id: 1,
                        name: 'Independent Films Studio',
                        type: 'studio',
                        description: 'Award-winning independent film studio specializing in narrative storytelling and documentary production.',
                        logo: 'https://via.placeholder.com/200x100/ef4444/ffffff?text=IFS'
                    },
                    {
                        id: 2,
                        name: 'Global Music Network',
                        type: 'distributor',
                        description: 'International music distribution network connecting artists with global audiences across multiple platforms.',
                        logo: 'https://via.placeholder.com/200x100/3b82f6/ffffff?text=GMN'
                    },
                    {
                        id: 3,
                        name: 'Creative Collective',
                        type: 'creator',
                        description: 'Collective of emerging filmmakers and content creators pushing the boundaries of digital storytelling.',
                        logo: 'https://via.placeholder.com/200x100/10b981/ffffff?text=CC'
                    }
                ]);
            });
    }, []);

    const partnersByType = partners.reduce((acc, partner) => {
        if (!acc[partner.type]) {
            acc[partner.type] = [];
        }
        acc[partner.type].push(partner);
        return acc;
    }, {});

    if (loading) {
        return (
            <div className="min-h-screen bg-gray-900 pt-20">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                    <div className="text-center mb-16">
                        <h1 className="text-5xl font-bold text-white mb-8">Our Partners</h1>
                        <div className="animate-pulse">
                            <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                                {[1, 2, 3, 4, 5, 6].map(i => (
                                    <div key={i} className="bg-gray-800 h-48 rounded-lg"></div>
                                ))}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
    const associates = [
        {
            name: "OSR Digital",
            tagline: "Entertaining the Nation",
            logo: "https://osr-image-link/osr-digital.png",
            buttonText: "Visit Youtube",
            link: "https://youtube.com/osrdigital",
        },
        {
            name: "OSR Connect",
            tagline: "",
            logo: "https://osr-image-link/osr-connect.png",
            buttonText: "Visit Site",
            link: "https://osrconnect.com",
        },
        {
            name: "OSR Reality",
            tagline: "",
            logo: "https://osr-image-link/osr-reality.png",
            buttonText: "Visit Youtube",
            link: "https://youtube.com/osrreality",
        },
        {
            name: "OSR Sports",
            tagline: "",
            logo: "https://osr-image-link/osr-sports.png",
            buttonText: "Visit Youtube",
            link: "https://youtube.com/osrsports",
        },
    ];

    return (
        <div className={`min-h-screen ${isDark ? 'bg-gray-900' : 'bg-gray-50'}`}>
            <PageHeader
                badge="Our Network"
                title="Strategic Content Partners"
                description="We collaborate with exceptional creators, studios, and distributors worldwide to bring diverse, high-quality content to global audiences through strategic partnerships."
            />

            {/* Partnership Types */}
            <section className={`py-20 ${isDark ? 'bg-black' : 'bg-white'}`}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center mb-16">
                        <h2 className={`text-4xl font-bold ${isDark ? 'text-white' : 'text-gray-900'} mb-6`}>Partnership Categories</h2>
                        <p className={`text-xl ${isDark ? 'text-gray-400' : 'text-gray-600'} max-w-3xl mx-auto`}>
                            We work with different types of partners to create a comprehensive content ecosystem
                        </p>
                    </div>

                    <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mb-20">
                        <div className={`text-center ${isDark ? 'bg-gray-800' : 'bg-gray-100'} p-6 rounded-lg`}>
                            <div className="text-4xl mb-4">🎬</div>
                            <h3 className={`text-xl font-semibold ${isDark ? 'text-white' : 'text-gray-900'} mb-2`}>Studios</h3>
                            <p className={`${isDark ? 'text-gray-300' : 'text-gray-600'}`}>Production companies and film studios creating original content</p>
                        </div>

                        <div className={`text-center ${isDark ? 'bg-gray-800' : 'bg-gray-100'} p-6 rounded-lg`}>
                            <div className="text-4xl mb-4">🎨</div>
                            <h3 className={`text-xl font-semibold ${isDark ? 'text-white' : 'text-gray-900'} mb-2`}>Creators</h3>
                            <p className={`${isDark ? 'text-gray-300' : 'text-gray-600'}`}>Independent filmmakers, musicians, and content creators</p>
                        </div>

                        <div className={`text-center ${isDark ? 'bg-gray-800' : 'bg-gray-100'} p-6 rounded-lg`}>
                            <div className="text-4xl mb-4">📡</div>
                            <h3 className={`text-xl font-semibold ${isDark ? 'text-white' : 'text-gray-900'} mb-2`}>Distributors</h3>
                            <p className={`${isDark ? 'text-gray-300' : 'text-gray-600'}`}>Distribution networks and platform aggregators</p>
                        </div>

                        <div className={`text-center ${isDark ? 'bg-gray-800' : 'bg-gray-100'} p-6 rounded-lg`}>
                            <div className="text-4xl mb-4">📱</div>
                            <h3 className={`text-xl font-semibold ${isDark ? 'text-white' : 'text-gray-900'} mb-2`}>Platforms</h3>
                            <p className={`${isDark ? 'text-gray-300' : 'text-gray-600'}`}>Streaming platforms and digital media companies</p>
                        </div>
                    </div>
                    {/* Associates Section */}
                    <section className="py-20 bg-gray-50">
                        <div className="max-w-7xl mx-auto px-4 text-center">
                            {/* Heading */}
                            <h2 className="text-4xl font-bold text-gray-800 mb-12">
                                Our Associates
                            </h2>

                            {/* Grid */}
                            <div className="grid gap-8 sm:grid-cols-2 md:grid-cols-4">
                                {associates.map((associate, index) => (
                                    <div
                                        key={index}
                                        className="bg-white shadow-sm rounded-lg p-8 flex flex-col items-center justify-center hover:shadow-md transition"
                                    >
                                        <img
                                            src={associate.logo}
                                            alt={associate.name}
                                            className="h-20 mb-4 object-contain"
                                        />
                                        <h3 className="text-xl font-semibold text-gray-800">
                                            {associate.name}
                                        </h3>
                                        {associate.tagline && (
                                            <p className="text-gray-500 text-sm mb-4">{associate.tagline}</p>
                                        )}
                                        <a
                                            href={associate.link}
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            className="mt-auto inline-block px-6 py-2 border border-orange-500 text-orange-500 rounded-md hover:bg-orange-500 hover:text-white transition-colors"
                                        >
                                            {associate.buttonText}
                                        </a>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </section>
                    {/* Partner Listings */}
                    {Object.entries(partnersByType).map(([type, typePartners]) => (
                        <div key={type} className="mb-16">
                            <h3 className={`text-3xl font-bold ${isDark ? 'text-white' : 'text-gray-900'} mb-8 capitalize`}>
                                {type === 'creator' ? 'Content Creators' :
                                    type === 'studio' ? 'Production Studios' :
                                        type === 'distributor' ? 'Distribution Partners' :
                                            type === 'platform' ? 'Platform Partners' : type}
                            </h3>

                            <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                                {typePartners.map((partner) => (
                                    <div key={partner.id} className={`${isDark ? 'bg-gray-800 hover:bg-gray-700' : 'bg-white hover:bg-gray-50'} rounded-lg p-6 transition-colors shadow-md`}>
                                        <div className="flex items-center mb-4">
                                            <img
                                                src={partner.logo}
                                                alt={partner.name}
                                                className={`w-16 h-16 rounded-lg mr-4 ${isDark ? 'bg-gray-600' : 'bg-gray-200'}`}
                                            />
                                            <div>
                                                <h4 className={`text-xl font-semibold ${isDark ? 'text-white' : 'text-gray-900'}`}>{partner.name}</h4>
                                                <span className="text-sm capitalize" style={{ color: '#ec681b' }}>{partner.type}</span>
                                            </div>
                                        </div>
                                        <p className={`${isDark ? 'text-gray-300' : 'text-gray-600'}`}>{partner.description}</p>
                                    </div>
                                ))}
                            </div>
                        </div>
                    ))}
                </div>
            </section>

            {/* Partnership Benefits */}
            <section className={`py-20 ${isDark ? 'bg-gray-900' : 'bg-gray-100'}`}>
                <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center mb-16">
                        <h2 className={`text-4xl font-bold ${isDark ? 'text-white' : 'text-gray-900'} mb-6`}>Why Partner With Us?</h2>
                        <p className={`text-xl ${isDark ? 'text-gray-400' : 'text-gray-600'}`}>
                            Join our network and unlock the potential of your content
                        </p>
                    </div>

                    <div className="grid md:grid-cols-2 gap-8">
                        <div className="space-y-6">
                            <div className="flex items-start space-x-4">
                                <div className="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center" style={{ backgroundColor: '#ec681b' }}>
                                    <svg className="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 className={`text-lg font-semibold ${isDark ? 'text-white' : 'text-gray-900'} mb-2`}>Global Distribution</h3>
                                    <p className={`${isDark ? 'text-gray-300' : 'text-gray-600'}`}>Access to worldwide audiences through our strategic YouTube network</p>
                                </div>
                            </div>

                            <div className="flex items-start space-x-4">
                                <div className="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center" style={{ backgroundColor: '#ec681b' }}>
                                    <svg className="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 className={`text-lg font-semibold ${isDark ? 'text-white' : 'text-gray-900'} mb-2`}>Revenue Optimization</h3>
                                    <p className={`${isDark ? 'text-gray-300' : 'text-gray-600'}`}>Maximize monetization through expert optimization and strategic placement</p>
                                </div>
                            </div>

                            <div className="flex items-start space-x-4">
                                <div className="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center" style={{ backgroundColor: '#ec681b' }}>
                                    <svg className="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 className={`text-lg font-semibold ${isDark ? 'text-white' : 'text-gray-900'} mb-2`}>Marketing Support</h3>
                                    <p className={`${isDark ? 'text-gray-300' : 'text-gray-600'}`}>Comprehensive promotional campaigns and social media marketing</p>
                                </div>
                            </div>
                        </div>

                        <div className="space-y-6">
                            <div className="flex items-start space-x-4">
                                <div className="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center" style={{ backgroundColor: '#ec681b' }}>
                                    <svg className="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 className={`text-lg font-semibold ${isDark ? 'text-white' : 'text-gray-900'} mb-2`}>Analytics & Insights</h3>
                                    <p className={`${isDark ? 'text-gray-300' : 'text-gray-600'}`}>Detailed performance analytics and actionable insights for growth</p>
                                </div>
                            </div>

                            <div className="flex items-start space-x-4">
                                <div className="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center" style={{ backgroundColor: '#ec681b' }}>
                                    <svg className="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 className={`text-lg font-semibold ${isDark ? 'text-white' : 'text-gray-900'} mb-2`}>Fair Partnerships</h3>
                                    <p className={`${isDark ? 'text-gray-300' : 'text-gray-600'}`}>Transparent agreements that protect creator rights and ensure fair compensation</p>
                                </div>
                            </div>

                            <div className="flex items-start space-x-4">
                                <div className="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center" style={{ backgroundColor: '#ec681b' }}>
                                    <svg className="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 className={`text-lg font-semibold ${isDark ? 'text-white' : 'text-gray-900'} mb-2`}>Ongoing Support</h3>
                                    <p className={`${isDark ? 'text-gray-300' : 'text-gray-600'}`}>Dedicated support team to help partners succeed and grow their audience</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* CTA Section */}
            <section
                className="py-20"
                style={{
                    background: 'linear-gradient(to right, #d35a15, #ec681b, #d35a15)'
                }}
            >
                <div className="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
                    <h2 className="text-4xl font-bold text-white mb-6">Ready to Partner With Us?</h2>
                    <p className="text-xl text-orange-100 mb-8 max-w-2xl mx-auto">
                        Join our network of successful partners and unlock the global potential of your content.
                    </p>
                    <button
                        className="bg-white px-8 py-4 rounded-lg text-lg font-semibold transition-colors"
                        style={{ color: '#ec681b' }}
                        onMouseEnter={(e) => e.target.style.backgroundColor = '#f3f4f6'}
                        onMouseLeave={(e) => e.target.style.backgroundColor = 'white'}
                    >
                        Become a Partner
                    </button>
                </div>
            </section>
        </div>
    );
}

export default Partners;
