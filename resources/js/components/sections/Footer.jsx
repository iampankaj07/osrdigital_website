
import { useState, useEffect } from 'react';
import Logo from '../Logo';
import { useTheme } from '../../contexts/ThemeContext';
import { EnvelopeIcon, PhoneIcon, MapPinIcon } from "@heroicons/react/24/outline";
function Footer() {
    const { isDark } = useTheme();
    const primaryColor = '#ff6b35'; // OSR Digital brand orange

    // Dynamic footer data
    const [footerData, setFooterData] = useState(null);
    const [loading, setLoading] = useState(true);

    // Default/fallback data
    const defaultData = {
        company: {
            name: 'OSR Digital',
            description: 'Bringing stories to screens worldwide through strategic content acquisition and YouTube publishing.'
        },
        contact: {
            email: 'hello@osrdigital.com',
            phone: '+1 (555) 123-4567',
            address: 'Los Angeles, CA'
        },
        quick_links: [
            { text: 'Home', url: '/' },
            { text: 'About', url: '/about' },
            { text: 'Portfolio', url: '/portfolio' },
            { text: 'Partners', url: '/partners' },
            { text: 'News', url: '/news' },
            { text: 'Contact', url: '/contact' }
        ],
        services: [
            'Content Acquisition',
            'YouTube Publishing',
            'Digital Distribution',
            'Rights Management',
            'Content Strategy'
        ],
        social_links: {
            youtube: 'https://youtube.com/@osrdigital',
            twitter: 'https://twitter.com/osrdigital',
            linkedin: 'https://linkedin.com/company/osrdigital',
            instagram: 'https://instagram.com/osrdigital'
        },
        legal_links: [
            { text: 'Privacy Policy', url: '/privacy' },
            { text: 'Terms of Service', url: '/terms' },
            { text: 'Cookie Policy', url: '/cookies' }
        ],
        copyright_text: '© 2025 OSR Digital. All rights reserved.'
    };

    useEffect(() => {
        const fetchFooterData = async () => {
            try {
                const response = await fetch('/api/footer');
                if (response.ok) {
                    const result = await response.json();
                    if (result.success) {
                        setFooterData(result.data);
                    } else {
                        setFooterData(defaultData);
                    }
                } else {
                    setFooterData(defaultData);
                }
            } catch (error) {
                console.error('Failed to fetch footer data:', error);
                setFooterData(defaultData);
            } finally {
                setLoading(false);
            }
        };

        fetchFooterData();
    }, []);

    // Use fetched data or fallback to default
    const data = footerData || defaultData;
    const companyInfo = data.company;
    const contactInfo = data.contact;
    const quickLinks = data.quick_links;
    const services = data.services;
    const socialLinks = data.social_links;
    const legalLinks = data.legal_links;
    const copyrightText = data.copyright_text;

    if (loading) {
        return (
            <footer className={`relative overflow-hidden ${isDark
                ? 'bg-gradient-to-br from-gray-900 via-black to-gray-900'
                : 'bg-gradient-to-br from-gray-100 via-white to-gray-200'
                }`}>
                <div className="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                    <div className="animate-pulse">
                        <div className="grid lg:grid-cols-12 gap-12 mb-12">
                            <div className="lg:col-span-5">
                                <div className="h-8 bg-gray-300 rounded mb-4"></div>
                                <div className="h-16 bg-gray-300 rounded mb-6"></div>
                                <div className="h-20 bg-gray-300 rounded"></div>
                            </div>
                            <div className="lg:col-span-7 grid md:grid-cols-3 gap-8">
                                <div className="h-32 bg-gray-300 rounded"></div>
                                <div className="h-32 bg-gray-300 rounded"></div>
                                <div className="h-32 bg-gray-300 rounded"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        );
    }

    return (
        <footer className={`relative overflow-hidden ${isDark
            ? 'bg-gradient-to-br from-gray-900 via-black to-gray-900'
            : 'bg-gradient-to-br from-gray-100 via-white to-gray-200'
            }`}>
            {/* Background decoration */}
            <div className="absolute inset-0 opacity-5">
                <div className="absolute top-0 left-0 w-72 h-72 bg-gradient-to-br from-orange-500 to-red-500 rounded-full -translate-x-32 -translate-y-32"></div>
                <div className="absolute bottom-0 right-0 w-96 h-96 bg-gradient-to-tl from-orange-400 to-red-400 rounded-full translate-x-48 translate-y-48"></div>
            </div>

            <div className="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                {/* Main content */}
                <div className="grid lg:grid-cols-12 gap-12 mb-12">
                    {/* Company Info - Larger section */}
                    <div className="lg:col-span-5">
                        <div className="flex items-center space-x-3 mb-6">
                            <Logo
                                type="footer"
                                height={52}
                                width="auto"
                                className="opacity-90 max-w-[140px]"
                            />

                        </div>

                        <p className={`mb-8 text-sm leading-relaxed ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                            {companyInfo.description}
                        </p>

                        {/* Social Media */}
                        {socialLinks && Object.keys(socialLinks).length > 0 && (
                            <div className="mt-8">
                                <p className={`text-sm font-semibold mb-4 ${isDark ? 'text-white' : 'text-gray-900'}`}>Follow Us</p>
                                <div className="flex space-x-4">
                                    {Object.entries(socialLinks).map(([platform, url]) => {
                                        if (!url) return null;

                                        // Platform-specific icons
                                        const getIcon = (platform) => {
                                            switch (platform.toLowerCase()) {
                                                case 'facebook':
                                                    return (
                                                        <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M22 12a10 10 0 1 0-11.5 9.9v-7h-2v-3h2v-2.3c0-2 1.2-3.1 3-3.1.9 0 1.8.2 1.8.2v2h-1c-1 0-1.3.6-1.3 1.2V12h2.2l-.4 3h-1.8v7A10 10 0 0 0 22 12" />
                                                        </svg>
                                                    );
                                                case 'tiktok':
                                                    return (
                                                        <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M12.5 2h3.1c.1 1.1.5 2.1 1.2 2.9.8.8 1.8 1.2 2.9 1.3v3.1c-1.8 0-3.4-.6-4.8-1.6v7.5c0 2.9-2.3 5.2-5.2 5.2S4.5 18.1 4.5 15.2c0-2.8 2.2-5.1 5-5.2v3.2c-1 .1-1.8 1-1.8 2s.8 2 1.8 2c1 0 1.8-.8 1.8-1.8V2z" />
                                                        </svg>
                                                    );
                                                case 'youtube':
                                                    return (
                                                        <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M23.498 6.186c-.278-1.038-1.086-1.856-2.132-2.136C19.505 3.546 12 3.546 12 3.546s-7.505 0-9.366.504C1.588 4.33.78 5.148.502 6.186 0 8.07 0 12 0 12s0 3.93.502 5.814c.278 1.038 1.086 1.856 2.132 2.136C4.495 20.454 12 20.454 12 20.454s7.505 0 9.366-.504c1.046-.28 1.854-1.098 2.132-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                                                        </svg>
                                                    );
                                                case 'twitter':
                                                    return (
                                                        <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                                                        </svg>
                                                    );
                                                case 'linkedin':
                                                    return (
                                                        <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                                        </svg>
                                                    );
                                                case 'instagram':
                                                    return (
                                                        <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                                        </svg>
                                                    );
                                                default:
                                                    return (
                                                        <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                                                        </svg>
                                                    );
                                            }
                                        };

                                        return (
                                            <a
                                                key={platform}
                                                href={url}
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                className={`w-10 h-10 rounded-lg flex items-center justify-center transition-all duration-300 hover:scale-110 ${isDark
                                                    ? 'bg-gray-800 hover:bg-gray-700 text-gray-400 hover:text-white'
                                                    : 'bg-gray-200 hover:bg-gray-300 text-gray-600 hover:text-gray-900'
                                                    }`}
                                                style={{
                                                    backdropFilter: 'blur(8px)',
                                                    WebkitBackdropFilter: 'blur(8px)',
                                                }}
                                                onMouseEnter={(e) => e.target.closest('a').style.backgroundColor = primaryColor}
                                                onMouseLeave={(e) => e.target.closest('a').style.backgroundColor = isDark ? '#1f2937' : '#e5e7eb'}
                                            >
                                                {getIcon(platform)}
                                            </a>
                                        );
                                    })}
                                </div>
                            </div>
                        )}
                    </div>

                    {/* Navigation Links */}
                    <div className="lg:col-span-7 grid md:grid-cols-3 gap-8">
                        {/* Quick Links */}
                        <div>
                            <h4 className={`font-bold text-lg mb-6 ${isDark ? 'text-white' : 'text-gray-900'}`}>Navigate</h4>
                            <ul className="space-y-3">
                                {quickLinks.map((link, index) => (
                                    <li key={index}>
                                        <a
                                            href={link.url}
                                            className={`flex items-center gap-2 transition-all duration-300 hover:translate-x-2 ${isDark ? 'text-gray-400 hover:text-white' : 'text-gray-600 hover:text-gray-900'}`}
                                            onMouseEnter={(e) => e.target.style.color = primaryColor}
                                            onMouseLeave={(e) => e.target.style.color = isDark ? '#9ca3af' : '#4b5563'}
                                        >
                                            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                                            </svg>
                                            {link.text}
                                        </a>
                                    </li>
                                ))}
                            </ul>
                        </div>

                        {/* Services */}
                        <div>
                            <h4 className={`font-bold text-lg mb-6 ${isDark ? 'text-white' : 'text-gray-900'}`}>Services</h4>
                            <ul className="space-y-3">
                                {services.map((service, index) => (
                                    <li key={index} className={`flex items-center gap-2 ${isDark ? 'text-gray-400' : 'text-gray-600'}`}>
                                        <div className="w-2 h-2 rounded-full" style={{ backgroundColor: primaryColor }}></div>
                                        {service}
                                    </li>
                                ))}
                            </ul>
                        </div>

                        {/* Contact Info */}
                        <div>
                            <h4
                                className={`font-bold text-lg mb-6 ${isDark ? "text-white" : "text-gray-900"
                                    }`}
                            >
                                Contact
                            </h4>

                            <div className="space-y-5">
                                {/* Email */}
                                <div
                                    className={`flex items-start gap-3 ${isDark ? "text-gray-400" : "text-gray-600"
                                        }`}
                                >
                                    <EnvelopeIcon
                                        className="w-5 h-5 mt-0.5 flex-shrink-0"
                                        style={{ color: primaryColor }}
                                    />
                                    <p className="font-medium">{contactInfo.email}</p>
                                </div>

                                {/* Phone */}
                                <div
                                    className={`flex items-start gap-3 ${isDark ? "text-gray-400" : "text-gray-600"
                                        }`}
                                >
                                    <PhoneIcon
                                        className="w-5 h-5 mt-0.5 flex-shrink-0"
                                        style={{ color: primaryColor }}
                                    />
                                    <div>
                                        <p className="font-medium">{contactInfo.phone}</p>
                                        <p className="text-sm opacity-75">Mon–Fri, 9:00 AM – 6:00 PM</p>
                                    </div>
                                </div>

                                {/* Address */}
                                <div
                                    className={`flex items-start gap-3 ${isDark ? "text-gray-400" : "text-gray-600"
                                        }`}
                                >
                                    <MapPinIcon
                                        className="w-5 h-5 mt-0.5 flex-shrink-0"
                                        style={{ color: primaryColor }}
                                    />
                                    <p className="text-sm">{contactInfo.address}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Bottom Section */}
                <div className={`border-t pt-8 flex flex-col md:flex-row justify-between items-center gap-4 ${isDark ? 'border-gray-700' : 'border-gray-300'}`}>
                    <p className={`text-sm ${isDark ? 'text-gray-400' : 'text-gray-600'}`}>
                        {copyrightText}
                    </p>
                    {legalLinks && legalLinks.length > 0 && (
                        <div className="flex items-center space-x-6 text-sm">
                            {legalLinks.map((link, index) => (
                                <a
                                    key={index}
                                    href={link.url}
                                    className={`transition-colors ${isDark ? 'text-gray-400 hover:text-white' : 'text-gray-600 hover:text-gray-900'}`}
                                >
                                    {link.text}
                                </a>
                            ))}
                        </div>
                    )}
                    {(!legalLinks || legalLinks.length === 0) && (
                        <div className="flex items-center space-x-6 text-sm">
                            <a href="/privacy" className={`transition-colors ${isDark ? 'text-gray-400 hover:text-white' : 'text-gray-600 hover:text-gray-900'}`}>
                                Privacy Policy
                            </a>
                            <a href="/terms" className={`transition-colors ${isDark ? 'text-gray-400 hover:text-white' : 'text-gray-600 hover:text-gray-900'}`}>
                                Terms of Service
                            </a>
                            <a href="/cookies" className={`transition-colors ${isDark ? 'text-gray-400 hover:text-white' : 'text-gray-600 hover:text-gray-900'}`}>
                                Cookie Policy
                            </a>
                        </div>
                    )}
                </div>
            </div>
        </footer>
    );
}

export default Footer;
