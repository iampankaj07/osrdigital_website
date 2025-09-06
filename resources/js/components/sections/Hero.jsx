import React from 'react';
import { Link } from 'react-router-dom';

function Hero() {
    return (
        <section className="relative h-[100vh] flex items-center justify-center overflow-hidden pt-24">
            {/* Simple Background */}
            <div className="absolute inset-0 bg-gray-900">
                <div className="absolute inset-0 bg-black/30"></div>
            </div>

            {/* Content */}
            <div className="relative z-10 text-center px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto">
                <div className="mb-6">
                    <div className="inline-flex items-center px-4 py-2 bg-[#ec681b]/20 border border-[#ec681b]/30 rounded-full text-[#ec681b] text-sm font-medium mb-6">
                        <span className="w-2 h-2 bg-[#ec681b] rounded-full mr-2"></span>
                        Digital Media Excellence
                    </div>
                </div>

                <h1 className="text-4xl md:text-6xl lg:text-7xl font-bold text-white mb-6 leading-tight">
                    Bringing Stories to{' '}
                    <span className="text-[#ec681b]">
                        Global Screens
                    </span>
                </h1>

                <p className="text-lg md:text-xl text-gray-300 mb-8 max-w-3xl mx-auto leading-relaxed">
                    OSR Digital specializes in acquiring exceptional entertainment content and
                    strategically distributing it to worldwide audiences through cutting-edge digital platforms.
                </p>

                <div className="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
                    <Link
                        to="/contact"
                        className="bg-[#ec681b] hover:bg-[#d55a15] text-white px-8 py-3 rounded-lg text-base font-semibold transition-colors flex items-center gap-2"
                    >
                        <span>Partner With Us</span>
                        <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </Link>

                    <Link
                        to="/portfolio"
                        className="border border-gray-300 text-white hover:bg-gray-800 px-8 py-3 rounded-lg text-base font-semibold transition-colors flex items-center gap-2"
                    >
                        <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Explore Portfolio</span>
                    </Link>
                </div>

                {/* Stats Preview */}
                <div className="grid grid-cols-2 lg:grid-cols-4 gap-6 text-center">
                    <div className="group">
                        <div className="text-2xl md:text-3xl font-bold text-white group-hover:text-[#ec681b] transition-colors">500+</div>
                        <div className="text-xs text-gray-400">Movies Published</div>
                    </div>
                    <div className="group">
                        <div className="text-2xl md:text-3xl font-bold text-white group-hover:text-[#ec681b] transition-colors">2K+</div>
                        <div className="text-xs text-gray-400">Songs Released</div>
                    </div>
                    <div className="group">
                        <div className="text-2xl md:text-3xl font-bold text-white group-hover:text-[#ec681b] transition-colors">800+</div>
                        <div className="text-xs text-gray-400">Short Films</div>
                    </div>
                    <div className="group">
                        <div className="text-2xl md:text-3xl font-bold text-white group-hover:text-[#ec681b] transition-colors">50M+</div>
                        <div className="text-xs text-gray-400">Total Views</div>
                    </div>
                </div>
            </div>

            {/* Scroll Indicator */}
            <div className="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
                <div className="w-6 h-10 border-2 border-white/30 rounded-full flex justify-center">
                    <div className="w-1 h-3 bg-white rounded-full mt-2 animate-pulse"></div>
                </div>
            </div>
        </section>
    );
}

export default Hero;
