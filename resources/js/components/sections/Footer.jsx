import React from 'react';
import { useState, useEffect } from 'react';
import Logo from '../Logo';
import { useTheme } from '../../contexts/ThemeContext';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import {
    faEnvelope,
    faPhone,
    faMapMarkerAlt,
    faGlobe,
    faPlay,
    faUsers,
    faNewspaper,
    faHandshake,
    faFilm,
    faTv,
    faGlobeAmericas,
    faShoppingCart,
    faChartLine,
    faShieldAlt,
    faHeart,
    faCopyright,
    faMusic,
    faCircle
} from '@fortawesome/free-solid-svg-icons';
import {
    faYoutube as faYoutubeBrand,
    faTwitter as faTwitterBrand,
    faLinkedin as faLinkedinBrand,
    faInstagram as faInstagramBrand,
    faFacebook as faFacebookBrand,
    faTiktok as faTiktokBrand
} from '@fortawesome/free-brands-svg-icons';

// Icon mapping function
const getIconByName = (iconName) => {
    const iconMap = {
        'faEnvelope': faEnvelope,
        'faPhone': faPhone,
        'faMapMarkerAlt': faMapMarkerAlt,
        'faGlobe': faGlobe,
        'faPlay': faPlay,
        'faUsers': faUsers,
        'faNewspaper': faNewspaper,
        'faHandshake': faHandshake,
        'faFilm': faFilm,
        'faTv': faTv,
        'faGlobeAmericas': faGlobeAmericas,
        'faShoppingCart': faShoppingCart,
        'faChartLine': faChartLine,
        'faShieldAlt': faShieldAlt,
        'faHeart': faHeart,
        'faCopyright': faCopyright,
        'faMusic': faMusic,
        'faCircle': faCircle,
        'faYoutube': faYoutubeBrand,
        'faFacebookBrand': faFacebookBrand,
        'faTwitterBrand': faTwitterBrand,
        'faLinkedinBrand': faLinkedinBrand,
        'faInstagramBrand': faInstagramBrand,
        'faYoutubeBrand': faYoutubeBrand,
        'faTiktokBrand': faTiktokBrand,
    };

    return iconMap[iconName] || faCircle;
};

// Social media icon mapping function
const getSocialIcon = (platform) => {
    const socialIconMap = {
        'youtube': faYoutubeBrand,
        'twitter': faTwitterBrand,
        'linkedin': faLinkedinBrand,
        'instagram': faInstagramBrand,
        'facebook': faFacebookBrand,
        'tiktok': faTiktokBrand,
    };

    return socialIconMap[platform] || faCircle;
};

function Footer() {
    const { isDark } = useTheme();

    // Empty initial state - will be populated from API
    const [footerData, setFooterData] = useState({
        company: { name: '', description: '' },
        contact: { email: '', phone: '', address: '' },
        quick_links: [],
        services: [],
        social_links: {},
        legal_links: [],
        copyright_text: ''
    });
    const [isLoading, setIsLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchFooterData = async () => {
            try {
                const response = await fetch('/api/footer');
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const result = await response.json();
                if (result.success && result.data) {
                    setFooterData(result.data);
                    setError(null);
                } else {
                    throw new Error('Invalid response format');
                }
            } catch (error) {
                console.error('Failed to fetch footer data:', error);
                setError('Unable to load footer data. Please check admin panel.');
                setFooterData({
                    company: { name: '', description: '' },
                    contact: { email: '', phone: '', address: '' },
                    quick_links: [],
                    services: [],
                    social_links: {},
                    legal_links: [],
                    copyright_text: ''
                });
            } finally {
                setIsLoading(false);
            }
        };

        fetchFooterData();
    }, []);

    const data = footerData;
    const companyInfo = data.company;
    const contactInfo = data.contact;
    const quickLinks = data.quick_links;
    const services = data.services;
    const socialLinks = data.social_links;
    const legalLinks = data.legal_links;
    const copyrightText = data.copyright_text;

    return (
        <footer className={`${isDark ? 'bg-gray-900' : 'bg-white'} relative overflow-hidden`}>
            {/* Show error if data failed to load */}
            {error && (
                <div className={`py-4 px-6 ${isDark ? 'bg-red-900/20 text-red-400' : 'bg-red-50 text-red-600'}`}>
                    <div className="container-minimal text-center">
                        <p className="text-sm font-medium">{error}</p>
                    </div>
                </div>
            )}

            {/* Show loading or empty state */}
            {isLoading && (
                <div className="container-minimal py-16 text-center">
                    <p className={isDark ? 'text-gray-400' : 'text-gray-500'}>Loading footer...</p>
                </div>
            )}

            {/* Only show footer content if data loaded and no error */}
            {!isLoading && !error && !footerData.company.name && (
                <div className="container-minimal py-16 text-center">
                    <p className={`${isDark ? 'text-red-400' : 'text-red-600'} font-medium`}>
                        No footer data available
                    </p>
                    <p className={`text-sm ${isDark ? 'text-gray-400' : 'text-gray-500'}`}>
                        Please add footer settings in the admin panel
                    </p>
                </div>
            )}

            {/* Normal footer content - only show if data loaded */}
            {!isLoading && footerData.company.name && (
            <>
            {/* Background Pattern */}
            <div className="absolute inset-0 opacity-5">
                <div className="absolute inset-0" style={{
                    backgroundImage: `url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")`,
                }} />
            </div>

            <div className="container-minimal relative z-10">
                {/* Main content */}
                <div className="grid lg:grid-cols-4 gap-12 py-16">
                    {/* Company Info */}
                    <div className="lg:col-span-2">
                        <div className="mb-6">
                            <Logo
                                type="footer"
                                height={48}
                                width="auto"
                                className="mb-4"
                            />
                        </div>
                        <p className={`text-minimal mb-8 ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                            {companyInfo.description}
                        </p>

                        {/* Contact Info with Icons */}
                        <div className="space-y-4">
                            <div className="flex items-center space-x-3">
                                <div className={`w-8 h-8 rounded-lg flex items-center justify-center ${
                                    isDark
                                        ? 'bg-brand-orange-500/20 text-brand-orange-400'
                                        : 'bg-brand-orange-100 text-brand-orange-600'
                                }`}>
                                    <FontAwesomeIcon icon={faEnvelope} className="w-4 h-4" />
                                </div>
                                <div>
                                    <p className={`text-sm font-medium ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                        Email
                                    </p>
                                    <a
                                        href={`mailto:${contactInfo.email}`}
                                        className={`text-sm transition-colors duration-200 hover-subtle ${
                                            isDark ? 'text-gray-400 hover:text-brand-orange-400' : 'text-gray-600 hover:text-brand-orange-600'
                                        }`}
                                    >
                                        {contactInfo.email}
                                    </a>
                                </div>
                            </div>

                            <div className="flex items-center space-x-3">
                                <div className={`w-8 h-8 rounded-lg flex items-center justify-center ${
                                    isDark
                                        ? 'bg-brand-orange-500/20 text-brand-orange-400'
                                        : 'bg-brand-orange-100 text-brand-orange-600'
                                }`}>
                                    <FontAwesomeIcon icon={faPhone} className="w-4 h-4" />
                                </div>
                                <div>
                                    <p className={`text-sm font-medium ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                        Phone
                                    </p>
                                    <a
                                        href={`tel:${contactInfo.phone}`}
                                        className={`text-sm transition-colors duration-200 hover-subtle ${
                                            isDark ? 'text-gray-400 hover:text-brand-orange-400' : 'text-gray-600 hover:text-brand-orange-600'
                                        }`}
                                    >
                                        {contactInfo.phone}
                                    </a>
                                </div>
                            </div>

                            <div className="flex items-center space-x-3">
                                <div className={`w-8 h-8 rounded-lg flex items-center justify-center ${
                                    isDark
                                        ? 'bg-brand-orange-500/20 text-brand-orange-400'
                                        : 'bg-brand-orange-100 text-brand-orange-600'
                                }`}>
                                    <FontAwesomeIcon icon={faMapMarkerAlt} className="w-4 h-4" />
                                </div>
                                <div>
                                    <p className={`text-sm font-medium ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                        Address
                                    </p>
                                    <p className={`text-sm ${isDark ? 'text-gray-400' : 'text-gray-600'}`}>
                                        {contactInfo.address}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Quick Links */}
                    <div>
                        <h4 className={`font-semibold text-lg mb-6 flex items-center ${isDark ? 'text-white' : 'text-gray-900'}`}>
                            <FontAwesomeIcon icon={faGlobe} className="w-5 h-5 mr-2 text-brand-orange-500" />
                            Quick Links
                        </h4>
                        <ul className="space-y-3">
                            {quickLinks.map((link, index) => (
                                <li key={index}>
                                    <a
                                        href={link.url}
                                        className={`flex items-center space-x-3 text-sm transition-colors duration-200 hover-subtle group ${
                                            isDark
                                                ? 'text-gray-400 hover:text-white'
                                                : 'text-gray-600 hover:text-gray-900'
                                        }`}
                                    >
                                        <FontAwesomeIcon
                                            icon={link.icon}
                                            className={`w-4 h-4 transition-colors duration-200 ${
                                                isDark
                                                    ? 'text-gray-500 group-hover:text-brand-orange-400'
                                                    : 'text-gray-400 group-hover:text-brand-orange-600'
                                            }`}
                                        />
                                        <span>{link.text}</span>
                                    </a>
                                </li>
                            ))}
                        </ul>
                    </div>

                    {/* Services */}
                    <div>
                        <h4 className={`font-semibold text-lg mb-6 flex items-center ${isDark ? 'text-white' : 'text-gray-900'}`}>
                            <FontAwesomeIcon icon={faFilm} className="w-5 h-5 mr-2 text-brand-orange-500" />
                            Services
                        </h4>
                        <ul className="space-y-3">
                            {services.map((service, index) => {
                                // Handle both object format {text, icon} and string format
                                const serviceText = typeof service === 'string' ? service : service.text;
                                const serviceIcon = typeof service === 'string' ? 'faCircle' : service.icon;

                                return (
                                    <li key={index} className={`flex items-center space-x-3 text-sm ${
                                        isDark
                                            ? 'text-gray-400'
                                            : 'text-gray-600'
                                    }`}>
                                        <FontAwesomeIcon
                                            icon={getIconByName(serviceIcon)}
                                            className={`w-4 h-4 ${
                                                isDark ? 'text-brand-orange-400' : 'text-brand-orange-600'
                                            }`}
                                        />
                                        <span>{serviceText}</span>
                                    </li>
                                );
                            })}
                        </ul>
                    </div>
                </div>

                {/* Social Links */}
                <div className={`py-8 border-t ${isDark ? 'border-gray-800' : 'border-gray-200'}`}>
                    <div className="flex flex-col md:flex-row items-center justify-between gap-6">
                        <h4 className={`font-semibold text-lg flex items-center ${isDark ? 'text-white' : 'text-gray-900'}`}>
                            <FontAwesomeIcon icon={faHeart} className="w-5 h-5 mr-2 text-brand-orange-500" />
                            Follow Us
                        </h4>
                        <div className="flex flex-wrap items-center gap-4">
                            {Object.entries(socialLinks).length > 0 ? (
                                Object.entries(socialLinks).map(([platform, data]) => {
                                    // Handle both data structures: {url, icon} or just URL string
                                    const url = typeof data === 'string' ? data : data?.url;
                                    const icon = typeof data === 'object' ? data?.icon : null;

                                    if (!url) return null;

                                    // Get the appropriate icon for the platform
                                    const platformIcon = icon ? getIconByName(icon) : getSocialIcon(platform);

                                    return (
                                        <a
                                            key={platform}
                                            href={url}
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            className={`w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300 hover-subtle group ${
                                                isDark
                                                    ? 'bg-gray-800 text-gray-400 hover:text-white hover:bg-brand-orange-500/20 hover:border-brand-orange-500/30 border border-gray-700'
                                                    : 'bg-white text-gray-600 hover:text-gray-900 hover:bg-brand-orange-50 hover:border-brand-orange-200 border border-gray-200'
                                            }`}
                                            title={`Follow us on ${platform.charAt(0).toUpperCase() + platform.slice(1)}`}
                                        >
                                            <FontAwesomeIcon
                                                icon={platformIcon}
                                                className="w-5 h-5 transition-transform duration-200 group-hover:scale-110"
                                            />
                                        </a>
                                    );
                                })
                            ) : (
                                <p className={`text-sm ${isDark ? 'text-gray-400' : 'text-gray-500'}`}>
                                    No social media links available
                                </p>
                            )}
                        </div>
                    </div>
                </div>

                {/* Bottom Section */}
                <div className={`py-8 border-t ${isDark ? 'border-gray-800' : 'border-gray-200'} flex flex-col md:flex-row justify-between items-center gap-4 min-h-[80px]`}>
                    <div className="flex items-center space-x-2">
                        <p className={`text-sm ${isDark ? 'text-gray-400' : 'text-gray-500'}`}>
                            {copyrightText}
                        </p>

                        <span className={`text-sm ${isDark ? 'text-gray-400' : 'text-gray-500'}`}>
                            Built with
                        </span>
                        <FontAwesomeIcon
                            icon={faHeart}
                            className="w-4 h-4 text-red-500 skeleton-fast"
                        />
                        <span className={`text-sm ${isDark ? 'text-gray-400' : 'text-gray-500'}`}>
                            by
                        </span>
                        <a
                            href="https://teknologia.studio"
                            target="_blank"
                            rel="noopener noreferrer"
                            className={`text-sm font-medium transition-colors duration-200 ${
                                isDark
                                    ? 'text-brand-orange-400 hover:text-brand-orange-300'
                                    : 'text-brand-orange-600 hover:text-brand-orange-700'
                            }`}
                        >
                            Teknologia.Studio
                        </a>
                    </div>

                    {legalLinks && legalLinks.length > 0 && (
                        <div className="flex flex-wrap items-center justify-center md:justify-end gap-4 text-sm">
                            {legalLinks.map((link, index) => (
                                <a
                                    key={index}
                                    href={link.url}
                                    className={`flex items-center space-x-2 transition-colors duration-200 hover-subtle ${
                                        isDark
                                            ? 'text-gray-400 hover:text-brand-orange-400'
                                            : 'text-gray-500 hover:text-brand-orange-600'
                                    }`}
                                >

                                    <span>{link.text}</span>
                                </a>
                            ))}
                        </div>
                    )}
                </div>
                {/* End container-minimal */}
            </div>
            {/* End normal footer content conditional */}
            </>
            )}
        </footer>
    );
}

export default Footer;
