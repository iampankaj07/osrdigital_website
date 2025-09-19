import { useState, useEffect } from 'react';
import { Link, useLocation } from 'react-router-dom';
import { useAllSettings } from '../../hooks/useSettings';
import { useTheme } from '../../contexts/ThemeContext';
import Logo from '../Logo';
import ThemeToggle from '../ThemeToggle';

function Header() {
    const location = useLocation();
    const [isScrolled, setIsScrolled] = useState(false);
    const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
    const { getSetting } = useAllSettings();
    const { isDark } = useTheme();

    const isActive = (path) => location.pathname === path;
    const primaryColor = '#ec681b'; // OSR Digital brand orange
    // const companyName = getSetting('company_name', 'OSR Digital');
    const primaryButtonText = getSetting('hero_primary_button_text', 'Partner With Us');

    useEffect(() => {
        const handleScroll = () => {
            setIsScrolled(window.scrollY > 50);
        };

        window.addEventListener('scroll', handleScroll);
        return () => window.removeEventListener('scroll', handleScroll);
    }, []);

    const navItems = [
        { to: '/', label: 'Home' },
        { to: '/about', label: 'About Us' },
        { to: '/business', label: 'Our Business' },
        { to: '/portfolio', label: 'Portfolio' },
        { to: '/partners', label: 'Partners' },
        { to: '/team', label: 'Team' },
        { to: '/news', label: 'News' },
    ];

    return (
        <header className={`fixed top-0 w-full z-50 transition-all duration-300 ${
            isScrolled
                ? 'bg-white/90 backdrop-blur-md border-b border-gray-200/50'
                : 'bg-transparent'
        }`}>
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex justify-between items-center py-4">
                    {/* Logo */}
                    <div className="flex-shrink-0">
                        <Link to="/" className="group flex items-center space-x-3">
                            <div className="w-auto h-10 flex items-center">
                                <Logo
                                    type="seeklogo"
                                    height="40"
                                    width="auto"
                                    className="transition-opacity duration-300 group-hover:opacity-80 max-w-[120px]"
                                />
                            </div>
                            <span className="text-xl lg:text-2xl font-bold group-hover:transition-colors hidden sm:block text-gray-900"
                                  style={{ '--hover-color': primaryColor }}
                                  onMouseEnter={(e) => e.target.style.color = primaryColor}
                                  onMouseLeave={(e) => e.target.style.color = '#111827'}>
                                {/* {companyName} */}
                            </span>
                        </Link>
                    </div>

                    {/* Desktop Navigation */}
                    <nav className="hidden lg:block flex-1 max-w-2xl mx-8">
                        <div className="flex items-center justify-center space-x-1">
                            {navItems.map((item) => (
                                <Link
                                    key={item.to}
                                    to={item.to}
                                    className={`relative px-3 py-2 text-sm font-medium rounded-lg transition-colors whitespace-nowrap ${
                                        isActive(item.to)
                                            ? 'text-gray-900'
                                            : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100'
                                    }`}
                                    style={isActive(item.to) ? {
                                        color: primaryColor,
                                        backgroundColor: `${primaryColor}10`
                                    } : {}}
                                >
                                    {item.label}
                                    {isActive(item.to) && (
                                        <div className="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-1 h-1 rounded-full"
                                             style={{ backgroundColor: primaryColor }}></div>
                                    )}
                                </Link>
                            ))}
                        </div>
                    </nav>

                    {/* Right side items */}
                    <div className="flex items-center space-x-2">
                        {/* Theme Toggle */}
                        <ThemeToggle />

                        {/* CTA Button */}
                        <div className="hidden md:block">
                            <Link
                                to="/contact"
                                className="text-white px-4 lg:px-6 py-2.5 rounded-lg text-sm font-semibold transition-all hover:opacity-90 flex items-center gap-2 whitespace-nowrap"
                                style={{ backgroundColor: primaryColor }}
                            >
                                <span className="hidden lg:inline">{primaryButtonText}</span>
                                <span className="lg:hidden">Contact</span>
                                <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </Link>
                        </div>

                        {/* Mobile menu button */}
                        <div className="lg:hidden">
                            <button
                                onClick={() => setIsMobileMenuOpen(!isMobileMenuOpen)}
                                className="p-2 rounded-lg transition-colors text-gray-600 hover:text-gray-900 hover:bg-gray-100"
                            >
                                <svg className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    {isMobileMenuOpen ? (
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                                    ) : (
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
                                    )}
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {/* Mobile Navigation */}
                {isMobileMenuOpen && (
                    <div className="lg:hidden border-t border-gray-200/50">
                        <div className="px-2 pt-2 pb-3 space-y-1">
                            {navItems.map((item) => (
                                <Link
                                    key={item.to}
                                    to={item.to}
                                    onClick={() => setIsMobileMenuOpen(false)}
                                    className={`block px-3 py-2 rounded-lg text-base font-medium transition-colors ${
                                        isActive(item.to)
                                            ? 'text-gray-900'
                                            : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100'
                                    }`}
                                    style={isActive(item.to) ? {
                                        color: primaryColor,
                                        backgroundColor: `${primaryColor}10`
                                    } : {}}
                                >
                                    {item.label}
                                </Link>
                            ))}
                            <Link
                                to="/contact"
                                onClick={() => setIsMobileMenuOpen(false)}
                                className="block w-full mt-4 text-white px-3 py-2 rounded-lg text-base font-medium text-center transition-all hover:opacity-90"
                                style={{ backgroundColor: primaryColor }}
                            >
                                {primaryButtonText}
                            </Link>
                        </div>
                    </div>
                )}
            </div>
        </header>
    );
}

export default Header;
