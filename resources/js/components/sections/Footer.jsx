import React from 'react';
import { useState, useEffect } from 'react';
import Logo from '../Logo';
import GoogleMap from './GoogleMap';
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
        <footer className={`${isDark ? 'bg-gray-900' : 'bg-white'} relative overflow-hidden transition-colors duration-300`}>
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
            {/* Google Map Section */}
            <div className={`${isDark ? 'bg-gray-800' : 'bg-gray-50'}`}>
                <div className="container-minimal py-16">
                    <div className="mb-8 text-center">
                        <h2 className={`text-3xl font-bold ${isDark ? 'text-white' : 'text-gray-900'} mb-2`}>Find Us On The Map</h2>
                        <p className={isDark ? 'text-gray-400' : 'text-gray-600'}>Visit our office or get in touch with us</p>
                    </div>
                    <div className="w-full rounded-lg overflow-hidden shadow-md" style={{ height: '450px' }}>
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3532.452544419239!2d85.32644507618737!3d27.703310476184992!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb19a3efd6608b%3A0x84a682e2d161a5d6!2sOSR%20Digital!5e0!3m2!1sen!2sfi!4v1762545322817!5m2!1sen!2sfi"
                            width="100%"
                            height="100%"
                            style={{ border: 'none', display: 'block' }}
                            allowFullScreen=""
                            loading="lazy"
                            referrerPolicy="no-referrer-when-downgrade"
                            title="OSR Digital Location"
                        ></iframe>
                    </div>
                </div>
            </div>

            <div className="container-minimal relative z-10">
                {/* Top Section with Logo and Description */}
                <div className={`py-20 border-b ${isDark ? 'border-gray-700' : 'border-gray-200'}`}>
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
                            <p className={`text-base leading-relaxed max-w-md ${isDark ? 'text-gray-400' : 'text-gray-600'}`}>
                                {companyInfo.description}
                            </p>
                        </div>

                        {/* Quick Stats or Tagline */}
                        <div className="flex flex-col justify-center">
                            <h4 className={`text-sm font-semibold mb-4 uppercase tracking-wider ${isDark ? 'text-gray-300' : 'text-gray-700'}`}>
                                Get in Touch
                            </h4>
                            <p className={`text-sm leading-relaxed ${isDark ? 'text-gray-400' : 'text-gray-600'}`}>
                                Reach out to us for any inquiries or partnerships
                            </p>
                        </div>
                    </div>
                </div>

                {/* Contact Information Section */}
                <div className={`py-12 border-b ${isDark ? 'border-gray-700' : 'border-gray-200'}`}>
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
                        {/* Email */}
                        <div className="group">
                            <div className={`flex items-start space-x-4 p-4 rounded-lg transition-all duration-300 ${isDark ? 'hover:bg-gray-800' : 'hover:bg-gray-100'}`}>
                                <div className="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center bg-brand-orange-100 text-brand-orange-600">
                                    <FontAwesomeIcon icon={faEnvelope} className="w-5 h-5" />
                                </div>
                                <div className="flex-1">
                                    <p className={`text-xs font-semibold mb-1 uppercase tracking-wide ${isDark ? 'text-gray-400' : 'text-gray-500'}`}>
                                        Email
                                    </p>
                                    <a
                                        href={`mailto:${contactInfo.email}`}
                                        className={`text-sm font-medium transition-colors duration-200 ${isDark ? 'text-gray-300 group-hover:text-brand-orange-400' : 'text-gray-900 group-hover:text-brand-orange-600'}`}
                                    >
                                        {contactInfo.email}
                                    </a>
                                </div>
                            </div>
                        </div>

                        {/* Phone */}
                        <div className="group">
                            <div className={`flex items-start space-x-4 p-4 rounded-lg transition-all duration-300 ${isDark ? 'hover:bg-gray-800' : 'hover:bg-gray-100'}`}>
                                <div className="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center bg-brand-orange-100 text-brand-orange-600">
                                    <FontAwesomeIcon icon={faPhone} className="w-5 h-5" />
                                </div>
                                <div className="flex-1">
                                    <p className={`text-xs font-semibold mb-1 uppercase tracking-wide ${isDark ? 'text-gray-400' : 'text-gray-500'}`}>
                                        Phone
                                    </p>
                                    <a
                                        href={`tel:${contactInfo.phone}`}
                                        className={`text-sm font-medium transition-colors duration-200 ${isDark ? 'text-gray-300 group-hover:text-brand-orange-400' : 'text-gray-900 group-hover:text-brand-orange-600'}`}
                                    >
                                        {contactInfo.phone}
                                    </a>
                                </div>
                            </div>
                        </div>

                        {/* Address */}
                        <div className="group">
                            <div className={`flex items-start space-x-4 p-4 rounded-lg transition-all duration-300 ${isDark ? 'hover:bg-gray-800' : 'hover:bg-gray-100'}`}>
                                <div className="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center bg-brand-orange-100 text-brand-orange-600">
                                    <FontAwesomeIcon icon={faMapMarkerAlt} className="w-5 h-5" />
                                </div>
                                <div className="flex-1">
                                    <p className={`text-xs font-semibold mb-1 uppercase tracking-wide ${isDark ? 'text-gray-400' : 'text-gray-500'}`}>
                                        Address
                                    </p>
                                    <p className={`text-sm font-medium ${isDark ? 'text-gray-300' : 'text-gray-900'}`}>
                                        {contactInfo.address}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Social Links */}
                <div className={`py-12 border-b ${isDark ? 'border-gray-700' : 'border-gray-200'}`}>
                    <div className="flex items-center justify-between gap-8">
                        <div>
                            <h4 className={`text-sm font-semibold mb-2 uppercase tracking-wider ${isDark ? 'text-gray-300' : 'text-gray-700'}`}>
                                Follow Us
                            </h4>
                            <p className={`text-xs ${isDark ? 'text-gray-400' : 'text-gray-500'}`}>
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
                                            className={`w-10 h-10 rounded-lg flex items-center justify-center transition-all duration-300 ${isDark ? 'bg-gray-800 text-gray-400 hover:bg-brand-orange-600 hover:text-white' : 'bg-gray-100 text-gray-600 hover:bg-brand-orange-600 hover:text-white'} hover:scale-110`}
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
                                <p className={`text-sm ${isDark ? 'text-gray-500' : 'text-gray-400'}`}>
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
                                <p className={`text-xs ${isDark ? 'text-gray-400' : 'text-gray-500'}`}>
                                    {copyrightText}
                                </p>
                                <p className={`text-xs mt-2 flex items-center gap-1 ${isDark ? 'text-gray-400' : 'text-gray-500'}`}>
                                   Designed by
                                    <a
                                        href="https://teknologia.studio"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className={`font-medium transition-colors duration-200 ${isDark ? 'text-brand-orange-400 hover:text-brand-orange-300' : 'text-brand-orange-600 hover:text-brand-orange-700'}`}
                                    >
                                    <img
                                        src="/images/TEKNOLOGIA.png"
                                        alt="Teknologia Studio"
                                        className="h-3 w-auto inline-block"
                                    />
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
                                                <span className={isDark ? 'text-gray-600' : 'text-gray-300'}>•</span>
                                            )}
                                            <a
                                                href={link.url}
                                                className={`text-xs transition-colors duration-200 ${isDark ? 'text-gray-400 hover:text-brand-orange-400' : 'text-gray-500 hover:text-brand-orange-600'}`}
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
