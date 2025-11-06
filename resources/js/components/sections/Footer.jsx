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
        <footer className="bg-white relative overflow-hidden">
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
            {/* Background Gradient */}
            <div className="absolute inset-0 bg-gradient-to-b from-white via-white to-gray-50" />

            <div className="container-minimal relative z-10">
                {/* Top Section with Logo and Description */}
                <div className="py-20 border-b border-gray-200">
                    <div className="grid grid-cols-1 lg:grid-cols-3 gap-12">
                        {/* Logo and Description */}
                        <div className="lg:col-span-2">
                            <div className="mb-6 inline-block">
                                <Logo
                                    type="footer"
                                    height={80}
                                    width="auto"
                                    className=""
                                />
                            </div>
                            <p className="text-base leading-relaxed max-w-md text-gray-600">
                                {companyInfo.description}
                            </p>
                        </div>

                        {/* Quick Stats or Tagline */}
                        <div className="flex flex-col justify-center">
                            <h4 className="text-sm font-semibold mb-4 uppercase tracking-wider text-gray-700">
                                Get in Touch
                            </h4>
                            <p className="text-sm leading-relaxed text-gray-600">
                                Reach out to us for any inquiries or partnerships
                            </p>
                        </div>
                    </div>
                </div>

                {/* Contact Information Section */}
                <div className="py-12 border-b border-gray-200">
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
                        {/* Email */}
                        <div className="group">
                            <div className="flex items-start space-x-4 p-4 rounded-lg transition-all duration-300 hover:bg-gray-100">
                                <div className="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center bg-brand-orange-100 text-brand-orange-600">
                                    <FontAwesomeIcon icon={faEnvelope} className="w-5 h-5" />
                                </div>
                                <div className="flex-1">
                                    <p className="text-xs font-semibold mb-1 uppercase tracking-wide text-gray-500">
                                        Email
                                    </p>
                                    <a
                                        href={`mailto:${contactInfo.email}`}
                                        className="text-sm font-medium transition-colors duration-200 text-gray-900 group-hover:text-brand-orange-600"
                                    >
                                        {contactInfo.email}
                                    </a>
                                </div>
                            </div>
                        </div>

                        {/* Phone */}
                        <div className="group">
                            <div className="flex items-start space-x-4 p-4 rounded-lg transition-all duration-300 hover:bg-gray-100">
                                <div className="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center bg-brand-orange-100 text-brand-orange-600">
                                    <FontAwesomeIcon icon={faPhone} className="w-5 h-5" />
                                </div>
                                <div className="flex-1">
                                    <p className="text-xs font-semibold mb-1 uppercase tracking-wide text-gray-500">
                                        Phone
                                    </p>
                                    <a
                                        href={`tel:${contactInfo.phone}`}
                                        className="text-sm font-medium transition-colors duration-200 text-gray-900 group-hover:text-brand-orange-600"
                                    >
                                        {contactInfo.phone}
                                    </a>
                                </div>
                            </div>
                        </div>

                        {/* Address */}
                        <div className="group">
                            <div className="flex items-start space-x-4 p-4 rounded-lg transition-all duration-300 hover:bg-gray-100">
                                <div className="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center bg-brand-orange-100 text-brand-orange-600">
                                    <FontAwesomeIcon icon={faMapMarkerAlt} className="w-5 h-5" />
                                </div>
                                <div className="flex-1">
                                    <p className="text-xs font-semibold mb-1 uppercase tracking-wide text-gray-500">
                                        Address
                                    </p>
                                    <p className="text-sm font-medium text-gray-900">
                                        {contactInfo.address}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Social Links */}
                <div className="py-12 border-b border-gray-200">
                    <div className="flex items-center justify-between gap-8">
                        <div>
                            <h4 className="text-sm font-semibold mb-2 uppercase tracking-wider text-gray-700">
                                Follow Us
                            </h4>
                            <p className="text-xs text-gray-500">
                                Connect with us on social media
                            </p>
                        </div>
                        <div className="flex items-center gap-3">
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
                                            className="w-10 h-10 rounded-lg flex items-center justify-center transition-all duration-300 bg-gray-100 text-gray-600 hover:bg-brand-orange-600 hover:text-white hover:scale-110"
                                            title={`Follow us on ${platform.charAt(0).toUpperCase() + platform.slice(1)}`}
                                        >
                                            <FontAwesomeIcon
                                                icon={platformIcon}
                                                className="w-4 h-4"
                                            />
                                        </a>
                                    );
                                })
                            ) : (
                                <p className="text-sm text-gray-400">
                                    No social media links
                                </p>
                            )}
                        </div>
                    </div>
                </div>

                {/* Bottom Footer */}
                <div className="py-8">
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {/* Copyright and Credits */}
                        <div className="flex items-center justify-start">
                            <div className="text-center md:text-left">
                                <p className="text-xs text-gray-500">
                                    {copyrightText}
                                </p>
                                <p className="text-xs mt-2 flex items-center gap-1 text-gray-500">
                                    Built with
                                    <FontAwesomeIcon
                                        icon={faHeart}
                                        className="w-3 h-3 text-red-500 animate-pulse"
                                    />
                                    by
                                    <a
                                        href="https://teknologia.studio"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className="font-medium transition-colors duration-200 text-brand-orange-600 hover:text-brand-orange-700"
                                    >
                                        Teknologia.Studio
                                    </a>
                                </p>
                            </div>
                        </div>

                        {/* Legal Links */}
                        {legalLinks && legalLinks.length > 0 && (
                            <div className="flex items-center justify-start md:justify-end">
                                <div className="flex flex-wrap items-center gap-2 md:gap-4">
                                    {legalLinks.map((link, index) => (
                                        <React.Fragment key={index}>
                                            {index > 0 && (
                                                <span className="text-gray-300">•</span>
                                            )}
                                            <a
                                                href={link.url}
                                                className="text-xs transition-colors duration-200 text-gray-500 hover:text-brand-orange-600"
                                            >
                                                {link.text}
                                            </a>
                                        </React.Fragment>
                                    ))}
                                </div>
                            </div>
                        )}
                    </div>
                </div>
            </div>
            {/* End container-minimal */}
            </>
            )}
        </footer>
    );
}

export default Footer;
