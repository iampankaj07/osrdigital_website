
import Logo from '../Logo';
import { useTheme } from '../../contexts/ThemeContext';

function Footer() {
    const { isDark } = useTheme();
    const primaryColor = '#ff6b35'; // OSR Digital brand orange

    // Static footer data
    const companyInfo = {
        name: 'OSR Digital',
        description: 'Bringing stories to screens worldwide through strategic content acquisition and YouTube publishing.'
    };

    const contactInfo = {
        email: 'hello@osrdigital.com',
        phone: '+1 (555) 123-4567',
        address: 'Los Angeles, CA'
    };

    const quickLinks = [
        { text: 'Home', url: '/' },
        { text: 'About', url: '/about' },
        { text: 'Portfolio', url: '/portfolio' },
        { text: 'Partners', url: '/partners' },
        { text: 'News', url: '/news' },
        { text: 'Contact', url: '/contact' }
    ];

    const services = [
        'Content Acquisition',
        'YouTube Publishing',
        'Digital Distribution',
        'Rights Management',
        'Content Strategy'
    ];

    const copyrightText = '© 2025 OSR Digital. All rights reserved.';

    return (
        <footer className={`relative overflow-hidden ${
            isDark
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
                            <h3 className={`text-2xl font-bold transition-colors ${
                                isDark ? 'text-white' : 'text-gray-900'
                            }`}>{companyInfo.name}</h3>
                        </div>
                        <p className={`mb-8 text-lg leading-relaxed ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                            {companyInfo.description}
                        </p>

                        {/* Contact Cards */}
                        <div className="grid sm:grid-cols-1 gap-4">
                            <div className={`p-4 rounded-lg transition-all duration-300 hover:scale-105 ${
                                isDark
                                    ? 'bg-gray-800/50 hover:bg-gray-700/50 border border-gray-700/50'
                                    : 'bg-white/70 hover:bg-white/90 border border-gray-200/50'
                            }`}
                            style={{
                                backdropFilter: 'blur(8px)',
                                WebkitBackdropFilter: 'blur(8px)',
                            }}>
                                <div className="flex items-center gap-4">
                                    <div className="w-12 h-12 rounded-lg flex items-center justify-center" style={{ backgroundColor: primaryColor }}>
                                        <svg className="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p className={`font-semibold ${isDark ? 'text-white' : 'text-gray-900'}`}>Email Us</p>
                                        <p className={`${isDark ? 'text-gray-300' : 'text-gray-600'} hover:text-orange-500 transition-colors cursor-pointer`}>
                                            {contactInfo.email}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {/* Social Media */}
                        <div className="mt-8">
                            <p className={`text-sm font-semibold mb-4 ${isDark ? 'text-white' : 'text-gray-900'}`}>Follow Us</p>
                            <div className="flex space-x-4">
                                {['youtube', 'twitter', 'linkedin', 'instagram'].map((platform) => (
                                    <a
                                        key={platform}
                                        href="#"
                                        className={`w-10 h-10 rounded-lg flex items-center justify-center transition-all duration-300 hover:scale-110 ${
                                            isDark
                                                ? 'bg-gray-800 hover:bg-gray-700 text-gray-400 hover:text-white'
                                                : 'bg-gray-200 hover:bg-gray-300 text-gray-600 hover:text-gray-900'
                                        }`}
                                        style={{
                                            backdropFilter: 'blur(8px)',
                                            WebkitBackdropFilter: 'blur(8px)',
                                        }}
                                        onMouseEnter={(e) => e.target.style.backgroundColor = primaryColor}
                                        onMouseLeave={(e) => e.target.style.backgroundColor = isDark ? '#1f2937' : '#e5e7eb'}
                                    >
                                        <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                        </svg>
                                    </a>
                                ))}
                            </div>
                        </div>
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
                            <h4 className={`font-bold text-lg mb-6 ${isDark ? 'text-white' : 'text-gray-900'}`}>Contact</h4>
                            <div className="space-y-4">
                                <div className={`flex items-start gap-3 ${isDark ? 'text-gray-400' : 'text-gray-600'}`}>
                                    <svg className="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style={{ color: primaryColor }}>
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <div>
                                        <p className="font-medium">{contactInfo.phone}</p>
                                        <p className="text-sm opacity-75">Mon-Fri, 9:00 AM - 6:00 PM</p>
                                    </div>
                                </div>
                                <div className={`flex items-center gap-3 ${isDark ? 'text-gray-400' : 'text-gray-600'}`}>
                                    <svg className="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style={{ color: primaryColor }}>
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {contactInfo.address}
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
                    <div className="flex items-center space-x-6 text-sm">
                        <a href="#" className={`transition-colors ${isDark ? 'text-gray-400 hover:text-white' : 'text-gray-600 hover:text-gray-900'}`}>
                            Privacy Policy
                        </a>
                        <a href="#" className={`transition-colors ${isDark ? 'text-gray-400 hover:text-white' : 'text-gray-600 hover:text-gray-900'}`}>
                            Terms of Service
                        </a>
                        <a href="#" className={`transition-colors ${isDark ? 'text-gray-400 hover:text-white' : 'text-gray-600 hover:text-gray-900'}`}>
                            Cookie Policy
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    );
}

export default Footer;
