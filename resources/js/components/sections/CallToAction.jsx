import React from 'react';

function CallToAction() {
    return (
        <section className="py-20 bg-gradient-to-r from-red-900 via-red-800 to-red-900">
            <div className="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
                <h2 className="text-4xl md:text-5xl font-bold text-white mb-6">
                    Ready to Share Your Story?
                </h2>
                <p className="text-xl text-red-100 mb-8 max-w-2xl mx-auto">
                    Join our network of creators and studios. Let's bring your content to audiences
                    worldwide.
                </p>
                <button className="bg-white text-red-800 hover:bg-gray-100 px-8 py-4 rounded-lg text-lg font-semibold transition-colors flex items-center gap-2 mx-auto">
                    Start Partnership
                    <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </button>
            </div>
        </section>
    );
}

export default CallToAction;
