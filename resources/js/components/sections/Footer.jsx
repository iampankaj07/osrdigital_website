
import Logo from '../Logo';
import { useTheme } from '../../contexts/ThemeContext';

function Footer() {
    const { isDark } = useTheme();

    return (
        <footer className={`border-t transition-colors duration-300 ${
            isDark
                ? 'bg-black border-gray-800'
                : 'bg-gray-50 border-gray-200'
        }`}>
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div className="grid md:grid-cols-4 gap-8">
                    {/* Company Info */}
                    <div className="md:col-span-2">
                        <div className="flex items-center space-x-3 mb-4">
                            <Logo
                                type="footer"
                                height="48"
                                width="auto"
                                className="opacity-90 max-w-[120px]"
                            />
                        </div>
                        <p className={`mb-6 max-w-md ${isDark ? 'text-gray-400' : 'text-gray-600'}`}>
                            Bringing stories to screens worldwide through strategic content acquisition and
                            YouTube publishing.
                        </p>
                        <div className="space-y-2">
                            <div className={`flex items-center gap-3 ${isDark ? 'text-gray-400' : 'text-gray-600'}`}>
                                <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                hello@osrdigital.com
                            </div>
                            <div className={`flex items-center gap-3 ${isDark ? 'text-gray-400' : 'text-gray-600'}`}>
                                <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                +1 (555) 123-4567
                            </div>
                            <div className={`flex items-center gap-3 ${isDark ? 'text-gray-400' : 'text-gray-600'}`}>
                                <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Los Angeles, CA
                            </div>
                        </div>
                    </div>

                    {/* Quick Links */}
                    <div>
                        <h4 className={`font-semibold mb-4 ${isDark ? 'text-white' : 'text-gray-900'}`}>Quick Links</h4>
                        <ul className="space-y-2">
                            <li><a href="#about" className={`hover:transition-colors ${isDark ? 'text-gray-400 hover:text-white' : 'text-gray-600 hover:text-gray-900'}`}>About Us</a></li>
                            <li><a href="#business" className={`hover:transition-colors ${isDark ? 'text-gray-400 hover:text-white' : 'text-gray-600 hover:text-gray-900'}`}>Our Business</a></li>
                            <li><a href="#portfolio" className={`hover:transition-colors ${isDark ? 'text-gray-400 hover:text-white' : 'text-gray-600 hover:text-gray-900'}`}>Portfolio</a></li>
                            <li><a href="#partners" className={`hover:transition-colors ${isDark ? 'text-gray-400 hover:text-white' : 'text-gray-600 hover:text-gray-900'}`}>Partners</a></li>
                        </ul>
                    </div>

                    {/* Services */}
                    <div>
                        <h4 className={`font-semibold mb-4 ${isDark ? 'text-white' : 'text-gray-900'}`}>Services</h4>
                        <ul className={`space-y-2 ${isDark ? 'text-gray-400' : 'text-gray-600'}`}>
                            <li>Movie Rights Acquisition</li>
                            <li>Music Publishing</li>
                            <li>Short Film Distribution</li>
                            <li>Content Strategy</li>
                        </ul>
                    </div>
                </div>

                <div className={`border-t mt-12 pt-8 text-center ${isDark ? 'border-gray-800' : 'border-gray-300'}`}>
                    <p className={`${isDark ? 'text-gray-400' : 'text-gray-600'}`}>
                        © 2025 OSR Digital. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
    );
}

export default Footer;
