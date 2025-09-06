import React from 'react';
import { Link } from 'react-router-dom';

function CallToAction() {
    return (
        <section className="py-32 bg-gray-800">
            <div className="max-w-6xl mx-auto text-center px-4 sm:px-6 lg:px-8">
                <div className="mb-8">
                    <div className="inline-flex items-center px-4 py-2 bg-[#ec681b]/20 border border-[#ec681b]/30 rounded-full text-[#ec681b] text-sm font-medium mb-6">
                        <span className="w-2 h-2 bg-[#ec681b] rounded-full mr-2"></span>
                        Let's Create Together
                    </div>
                </div>

                <h2 className="text-5xl md:text-6xl lg:text-7xl font-bold text-white mb-8 leading-tight">
                    Ready to Share Your{' '}
                    <span className="text-[#ec681b]">
                        Story?
                    </span>
                </h2>

                <p className="text-xl md:text-2xl text-gray-300 mb-12 max-w-4xl mx-auto leading-relaxed">
                    Join our network of visionary creators and studios. Let's bring your exceptional 
                    content to audiences worldwide through strategic digital distribution.
                </p>

                <div className="flex flex-col sm:flex-row gap-6 justify-center items-center mb-16">
                    <Link 
                        to="/contact"
                        className="bg-[#ec681b] hover:bg-[#d55a15] text-white px-10 py-4 rounded-lg text-lg font-bold transition-colors flex items-center gap-3"
                    >
                        <span>Start Partnership</span>
                        <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </Link>

                    <Link 
                        to="/portfolio"
                        className="border-2 border-gray-400 text-white hover:bg-gray-700 px-10 py-4 rounded-lg text-lg font-semibold transition-colors flex items-center gap-3"
                    >
                        <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        <span>View Our Work</span>
                    </Link>
                </div>

                {/* Contact Features */}
                <div className="grid md:grid-cols-3 gap-8 text-left">
                    <div className="bg-gray-700 rounded-2xl p-6 hover:bg-gray-600 transition-colors">
                        <div className="w-12 h-12 bg-[#ec681b] rounded-xl flex items-center justify-center mb-4">
                            <svg className="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 className="text-xl font-semibold text-white mb-2">Fast Partnership</h3>
                        <p className="text-gray-300">Quick approval process for quality content creators and studios.</p>
                    </div>

                    <div className="bg-gray-700 rounded-2xl p-6 hover:bg-gray-600 transition-colors">
                        <div className="w-12 h-12 bg-[#ec681b] rounded-xl flex items-center justify-center mb-4">
                            <svg className="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 className="text-xl font-semibold text-white mb-2">Global Reach</h3>
                        <p className="text-gray-300">Access to worldwide audiences through strategic distribution.</p>
                    </div>

                    <div className="bg-gray-700 rounded-2xl p-6 hover:bg-gray-600 transition-colors">
                        <div className="w-12 h-12 bg-[#ec681b] rounded-xl flex items-center justify-center mb-4">
                            <svg className="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                            </svg>
                        </div>
                        <h3 className="text-xl font-semibold text-white mb-2">Fair Revenue</h3>
                        <p className="text-gray-300">Transparent revenue sharing with competitive rates for creators.</p>
                    </div>
                </div>
            </div>
        </section>
    );
}

export default CallToAction;