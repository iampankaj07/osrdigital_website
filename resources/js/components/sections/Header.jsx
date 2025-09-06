import React from 'react';
import { Link, useLocation } from 'react-router-dom';

function Header() {
    const location = useLocation();

    const isActive = (path) => location.pathname === path;

    return (
        <header className="fixed top-0 w-full bg-black/95 backdrop-blur-sm z-50 border-b border-gray-800">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex justify-between items-center py-4">
                    {/* Logo */}
                    <div className="flex-shrink-0">
                        <Link to="/" className="text-2xl font-bold text-white hover:text-red-400 transition-colors">
                            OSR Digital
                        </Link>
                    </div>

                    {/* Navigation */}
                    <nav className="hidden md:block">
                        <div className="ml-10 flex items-baseline space-x-8">
                            <Link
                                to="/about"
                                className={`px-3 py-2 text-sm font-medium transition-colors ${isActive('/about')
                                    ? 'text-red-400 border-b-2 border-red-400'
                                    : 'text-gray-300 hover:text-white'
                                    }`}
                            >
                                About Us
                            </Link>
                            <Link
                                to="/business"
                                className={`px-3 py-2 text-sm font-medium transition-colors ${isActive('/business')
                                    ? 'text-red-400 border-b-2 border-red-400'
                                    : 'text-gray-300 hover:text-white'
                                    }`}
                            >
                                Our Business
                            </Link>
                            <Link
                                to="/portfolio"
                                className={`px-3 py-2 text-sm font-medium transition-colors ${isActive('/portfolio')
                                    ? 'text-red-400 border-b-2 border-red-400'
                                    : 'text-gray-300 hover:text-white'
                                    }`}
                            >
                                Portfolio
                            </Link>
                            <Link
                                to="/partners"
                                className={`px-3 py-2 text-sm font-medium transition-colors ${isActive('/partners')
                                    ? 'text-red-400 border-b-2 border-red-400'
                                    : 'text-gray-300 hover:text-white'
                                    }`}
                            >
                                Partners
                            </Link>
                            <Link
                                to="/teams"
                                className={`px-3 py-2 text-sm font-medium transition-colors ${isActive('/teams')
                                    ? 'text-red-400 border-b-2 border-red-400'
                                    : 'text-gray-300 hover:text-white'
                                    }`}
                            >
                                Our Team
                            </Link>
                            <Link
                                to="/news"
                                className={`px-3 py-2 text-sm font-medium transition-colors ${isActive('/news')
                                    ? 'text-red-400 border-b-2 border-red-400'
                                    : 'text-gray-300 hover:text-white'
                                    }`}
                            >
                                News
                            </Link>
                        </div>
                    </nav>

                    {/* CTA Button */}
                    <div className="hidden md:block">
                        <Link
                            to="/contact"
                            className="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition-colors"
                        >
                            Partner With Us
                        </Link>
                    </div>

                    {/* Mobile menu button */}
                    <div className="md:hidden">
                        <button className="text-gray-300 hover:text-white">
                            <svg className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </header>
    );
}

export default Header;
