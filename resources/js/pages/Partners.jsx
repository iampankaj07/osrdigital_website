import React from 'react';
import { useState, useEffect } from 'react';
import { useTheme } from '../contexts/ThemeContext';
import { Link } from 'react-router-dom';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faHandshake, faRocket, faGlobe, faUsers, faChartLine, faAward, faShieldAlt, faLightbulb, faStar, faExternalLinkAlt } from '@fortawesome/free-solid-svg-icons';
import CompactHero from '../components/sections/CompactHero';
import { getSafeImageUrl, handleImageError } from '../utils/imageUtils';

function Partners() {
    const { isDark } = useTheme();
    const [isVisible, setIsVisible] = useState(false);
    const [partners, setPartners] = useState([]);
    const [benefits, setBenefits] = useState([]);
    const [isLoading, setIsLoading] = useState(true);

    useEffect(() => {
        setIsVisible(true);
        document.title = "Our Partners - OSR Digital";
        let metaDescription = document.querySelector('meta[name="description"]');
        if (!metaDescription) {
            metaDescription = document.createElement('meta');
            metaDescription.name = 'description';
            document.getElementsByTagName('head')[0].appendChild(metaDescription);
        }
        metaDescription.content = "Discover our network of trusted partners and collaborators who help us bring exceptional content to global audiences. Join our partnership program today.";

        // Fetch partners and benefits data
        fetchPartners();
        fetchBenefits();
    }, []);

    const fetchPartners = async () => {
        try {
            const response = await fetch('/api/trusted-partners');
            if (response.ok) {
                const data = await response.json();
                setPartners(data.partners || []);
            } else {
                console.error('Failed to fetch partners');
                setPartners([]);
            }
        } catch (error) {
            console.error('Error fetching partners:', error);
            setPartners([]);
        } finally {
            setIsLoading(false);
        }
    };

    const fetchBenefits = async () => {
        try {
            const response = await fetch('/api/partnership-benefits');
            if (response.ok) {
                const data = await response.json();
                setBenefits(data.benefits || []);
            } else {
                console.error('Failed to fetch benefits');
                // Fallback to static data
                setBenefits([
                    {
                        title: "Global Reach",
                        description: "Access to 200+ countries and territories worldwide through our extensive partner network.",
                        icon: "fas fa-globe"
                    },
                    {
                        title: "Revenue Growth",
                        description: "Proven track record of increasing content revenue by 300% on average for our partners.",
                        icon: "fas fa-chart-line"
                    },
                    {
                        title: "Secure Distribution",
                        description: "Advanced rights management and security protocols to protect your intellectual property.",
                        icon: "fas fa-shield-alt"
                    },
                    {
                        title: "Strategic Insights",
                        description: "Data-driven recommendations and market insights to optimize your content strategy.",
                        icon: "fas fa-lightbulb"
                    },
                    {
                        title: "Dedicated Support",
                        description: "24/7 dedicated account management and technical support for all partners.",
                        icon: "fas fa-users"
                    },
                    {
                        title: "Quality Assurance",
                        description: "Rigorous quality control processes to ensure your content meets platform standards.",
                        icon: "fas fa-award"
                    }
                ]);
            }
        } catch (error) {
            console.error('Error fetching benefits:', error);
            // Fallback to static data
            setBenefits([
                {
                    title: "Global Reach",
                    description: "Access to 200+ countries and territories worldwide through our extensive partner network.",
                    icon: "fas fa-globe"
                }
            ]);
        }
    };


    return (
        <div className={`min-h-screen transition-colors duration-300 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
            {/* Hero Section */}
            <CompactHero
                page="partners"
                title="Our Partners"
                subtitle="Strategic Partnerships"
                description="Discover our network of trusted partners and collaborators who help us bring exceptional content to global audiences."
            />

            {/* Partners Grid Section */}
            <section className={`py-16 md:py-24 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                <div className="container-minimal">
                    <div className="text-center max-w-3xl mx-auto mb-16">
                        <h2 className={`text-4xl font-extrabold mb-4 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                            Our Trusted Partners
                        </h2>
                        <p className={`text-xl ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                            Industry leaders who trust us to deliver their content to global audiences
                        </p>
                    </div>

                    {isLoading ? (
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            {[1, 2, 3, 4, 5, 6].map((i) => (
                                <div key={i} className={`p-8 rounded-lg shadow-lg ${isDark ? 'bg-gray-700' : 'bg-white'}`}>
                                    <div className="text-center mb-6">
                                        <div className={`h-16 w-32 mx-auto mb-4 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                        <div className={`h-6 w-24 mx-auto mb-2 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                        <div className={`h-4 w-32 mx-auto rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                    </div>
                                    <div className="space-y-3">
                                        <div className={`h-4 w-full rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                        <div className={`h-4 w-3/4 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                        <div className={`h-4 w-1/2 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                    </div>
                                    <div className="flex justify-center mt-6">
                                        <div className={`h-10 w-24 rounded-lg ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    ) : (
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            {partners.map((partner, index) => (
                                <div key={index} className={`p-8 rounded-lg shadow-lg transition-all duration-300 hover:shadow-xl ${
                                    isDark ? 'bg-gray-700 hover:bg-gray-600' : 'bg-white hover:bg-gray-50'
                                }`}>
                                    <div className="text-center mb-6">
                                        <img
                                            src={getSafeImageUrl(partner.logo, partner.name, 200, 100)}
                                            alt={`${partner.name} logo`}
                                            className="h-16 mx-auto mb-4 object-contain"
                                            onError={(e) => handleImageError(e, partner.name, 200, 100)}
                                        />
                                        <h3 className={`text-2xl font-bold mb-2 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                            {partner.name}
                                        </h3>
                                        {partner.description && (
                                            <p className={`text-sm ${isDark ? 'text-gray-300' : 'text-gray-600'} mb-3`}>
                                                {partner.description}
                                            </p>
                                        )}
                                        {partner.website_url && (
                                            <a
                                                href={partner.website_url}
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                className={`inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${
                                                    isDark ? 'bg-brand-orange-500/20 text-brand-orange-400' : 'bg-brand-orange-100 text-brand-orange-600'
                                                } hover:opacity-80 transition-opacity`}
                                            >
                                                <FontAwesomeIcon icon={faExternalLinkAlt} className="mr-1" />
                                                Visit
                                            </a>
                                        )}
                                    </div>
                                </div>
                            ))}
                        </div>
                    )}
                </div>
            </section>


            {/* Partnership Benefits Section */}
            <section className={`py-16 md:py-24 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                <div className="container-minimal">
                    <div className="text-center max-w-3xl mx-auto mb-16">
                        <h2 className={`text-4xl font-extrabold mb-4 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                            Partnership Benefits
                        </h2>
                        <p className={`text-xl ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                            Why leading companies choose to partner with OSR Digital
                        </p>
                    </div>

                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        {benefits.map((benefit, index) => (
                            <div key={index} className={`p-6 rounded-lg shadow-lg text-center ${
                                isDark ? 'bg-gray-700' : 'bg-white'
                            }`}>
                                <div className={`text-4xl mb-4`} style={{color: '#EC681D'}}>
                                    <i className={benefit.icon}></i>
                                </div>
                                <h3 className={`text-xl font-semibold mb-3 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                    {benefit.title}
                                </h3>
                                <p className={`${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                                    {benefit.description}
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
                            Ready to Join Our Network?
                        </h2>
                        <p className={`text-xl mb-10 ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                            Become part of our global partnership network and unlock new opportunities for content distribution and growth.
                        </p>
                        <div className="flex flex-col sm:flex-row gap-4 justify-center items-center">
                            <Link to="/contact" className="btn-minimal">
                                Start Partnership
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

export default Partners;
