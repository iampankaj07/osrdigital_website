import { useState, useEffect } from 'react';
import { Link, useLocation } from 'react-router-dom';
import { useTheme } from '../../contexts/ThemeContext';
import Logo from '../Logo';
import ThemeToggle from '../ThemeToggle';

function Header() {
    const location = useLocation();
    const [isScrolled, setIsScrolled] = useState(false);
    const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
    const { isDark } = useTheme();

    const isActive = (path) => location.pathname === path;
    const isHomePage = location.pathname === '/';

    useEffect(() => {
        const handleScroll = () => {
            setIsScrolled(window.scrollY > 20);
        };

        window.addEventListener('scroll', handleScroll);
        return () => window.removeEventListener('scroll', handleScroll);
    }, []);

    const navItems = [
        { to: '/', label: 'Home' },
        { to: '/about', label: 'About' },
        { to: '/partners', label: 'Partners' },
        { to: '/team', label: 'Team' },
        { to: '/news', label: 'News' },
    ];

    return (
        <header className={`fixed top-0 w-full z-50 transition-all duration-300 ${
            isScrolled || !isHomePage
                ? `${isDark ? 'bg-gray-900/95 border-b border-gray-800' : 'bg-white/95 border-b border-gray-200'} backdrop-blur-md`
                : 'bg-black/10 backdrop-blur-sm'
        }`}>
            <div className="container-minimal">
                <div className="flex justify-between items-center py-6">
                    {/* Logo */}
                    <div className="flex-shrink-0">
                        <Link to="/" className="flex items-center hover-subtle">
                            <Logo
                                type="seeklogo"
                                height="48"
                                width="auto"
                                className="transition-all duration-200"
                            />
                        </Link>
                    </div>

                    {/* Desktop Navigation */}
                    <nav className="hidden lg:block">
                        <div className="flex items-center space-x-10">
                            {navItems.map((item) => (
                                <Link
                                    key={item.to}
                                    to={item.to}
                                    className={`text-base font-medium transition-colors duration-200 hover-subtle ${
                                        isScrolled || !isHomePage
                                            ? isActive(item.to)
                                                ? `${isDark ? 'text-white' : 'text-gray-900'}`
                                                : `${isDark ? 'text-gray-400 hover:text-white' : 'text-gray-600 hover:text-gray-900'}`
                                            : isActive(item.to)
                                                ? 'text-white'
                                                : 'text-white/80 hover:text-white'
                                    }`}
                                >
                                    {item.label}
                                </Link>
                            ))}
                        </div>
                    </nav>

                    {/* Right side items */}
                    <div className="flex items-center space-x-4">
                        {/* Theme Toggle */}
                        <ThemeToggle isOverHero={!isScrolled && isHomePage} />

                        {/* CTA Button */}
                        <div className="hidden md:block">
                            <Link
                                to="/contact"
                                className={`text-base px-6 py-3 rounded-lg font-medium transition-all duration-200 ${
                                    isScrolled || !isHomePage
                                        ? 'btn-minimal'
                                        : 'bg-white text-gray-900 hover:bg-gray-100'
                                }`}
                            >
                                Contact
                            </Link>
                        </div>

                        {/* Mobile menu button */}
                        <div className="lg:hidden">
                            <button
                                onClick={() => setIsMobileMenuOpen(!isMobileMenuOpen)}
                                className={`p-2 rounded-lg transition-colors duration-200 ${
                                    isScrolled || !isHomePage
                                        ? isDark
                                            ? 'text-gray-400 hover:text-white hover:bg-gray-800'
                                            : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100'
                                        : 'text-white hover:text-white hover:bg-white/10'
                                }`}
                            >
                                <svg className="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                    <div className={`lg:hidden border-t ${isDark ? 'border-gray-800' : 'border-gray-200'}`}>
                        <div className="py-6 space-y-3">
                            {navItems.map((item) => (
                                <Link
                                    key={item.to}
                                    to={item.to}
                                    onClick={() => setIsMobileMenuOpen(false)}
                                    className={`block px-4 py-4 text-lg font-medium transition-colors duration-200 ${
                                        isActive(item.to)
                                            ? `${isDark ? 'text-white' : 'text-gray-900'}`
                                            : `${isDark ? 'text-gray-400 hover:text-white' : 'text-gray-600 hover:text-gray-900'}`
                                    }`}
                                >
                                    {item.label}
                                </Link>
                            ))}
                            <div className="pt-6 px-4">
                                <Link
                                    to="/contact"
                                    onClick={() => setIsMobileMenuOpen(false)}
                                    className="btn-minimal w-full text-center text-lg py-4"
                                >
                                    Contact
                                </Link>
                            </div>
                        </div>
                    </div>
                )}
            </div>
        </header>
    );
}

export default Header;
