
import { useState, useEffect } from 'react';
import { useTheme } from '../contexts/ThemeContext';
import { useBusinessSettings } from '../hooks/useSettings';

function Business() {
    const { isDark } = useTheme();
    const { getSetting, loading: settingsLoading } = useBusinessSettings();
    const [activeProcessStep, setActiveProcessStep] = useState(0);

    // Show loading skeleton while settings are being fetched
    if (settingsLoading) {
        return (
            <div className={`min-h-screen ${isDark ? 'bg-gray-900' : 'bg-gray-50'} pt-20`}>
                <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center py-20">
                    <div className="animate-pulse">
                        <div className={`h-12 rounded-lg mb-8 ${isDark ? 'bg-gray-700' : 'bg-gray-300'}`}></div>
                        <div className={`h-6 rounded-lg mb-8 max-w-3xl mx-auto ${isDark ? 'bg-gray-700' : 'bg-gray-300'}`}></div>
                    </div>
                </div>
            </div>
        );
    }

    // Parse What We Do items from settings
    const getWhatWeDoItems = () => {
        try {
            const itemsData = getSetting('business_what_we_do_items', '[]');
            return typeof itemsData === 'string' ? JSON.parse(itemsData) : itemsData;
        } catch (error) {
            console.error('Error parsing What We Do items:', error);
            return [];
        }
    };

    // Parse Process items from settings
    const getProcessItems = () => {
        try {
            const itemsData = getSetting('business_process_items', '[]');
            return typeof itemsData === 'string' ? JSON.parse(itemsData) : itemsData;
        } catch (error) {
            console.error('Error parsing Process items:', error);
            return [];
        }
    };

    const whatWeDoItems = getWhatWeDoItems();
    const processItems = getProcessItems();

    return (
        <div className={`min-h-screen ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
            {/* Modern Hero Section */}
            <section className={`relative overflow-hidden ${isDark ? 'bg-gradient-to-br from-gray-900 via-gray-800 to-black' : 'bg-gradient-to-br from-white via-orange-50 to-orange-100'}`}>
                {/* Background Pattern */}
                <div className="absolute inset-0 opacity-10">
                    <div className="absolute inset-0 bg-gradient-to-r from-orange-500/20 to-purple-500/20"></div>
                    <div className="absolute top-0 left-0 w-full h-full">
                        {[...Array(50)].map((_, i) => (
                            <div
                                key={i}
                                className={`absolute rounded-full animate-pulse ${isDark ? 'bg-orange-400' : 'bg-orange-300'}`}
                                style={{
                                    width: Math.random() * 4 + 1 + 'px',
                                    height: Math.random() * 4 + 1 + 'px',
                                    top: Math.random() * 100 + '%',
                                    left: Math.random() * 100 + '%',
                                    animationDelay: Math.random() * 5 + 's',
                                }}
                            />
                        ))}
                    </div>
                </div>

                <div className="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
                    <div className="text-center">
                        {/* Badge */}
                        <div className="inline-flex items-center px-4 py-2 rounded-full bg-gradient-to-r from-orange-500/10 to-red-500/10 border border-orange-500/20 mb-8">
                            <span className={`font-medium text-sm ${isDark ? 'text-orange-400' : 'text-orange-600'}`} style={{ color: isDark ? 'rgba(255, 107, 53, 0.8)' : 'rgb(255, 107, 53)' }}>
                                {getSetting('business_badge', 'Our Business')}
                            </span>
                        </div>

                        {/* Title */}
                        <h1 className={`text-5xl md:text-6xl lg:text-7xl font-bold mb-8 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                            {getSetting('business_page_title', 'Our Business Model')}
                        </h1>

                        {/* Description */}
                        <p className={`text-xl md:text-2xl mb-16 max-w-4xl mx-auto leading-relaxed ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                            {getSetting('business_page_description', 'OSR Digital operates at the intersection of content creation and digital distribution, providing comprehensive solutions for content monetization and audience growth.')}
                        </p>
                    </div>
                </div>
            </section>

            {/* Enhanced What We Do Section */}
            <section className={`py-20 ${isDark ? 'bg-black' : 'bg-gray-50'}`}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center mb-16">
                        <h2 className={`text-4xl md:text-5xl font-bold mb-6 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                            {getSetting('business_what_we_do_title', 'What We Do')}
                        </h2>
                        <p className={`text-xl max-w-4xl mx-auto leading-relaxed ${isDark ? 'text-gray-400' : 'text-gray-600'}`}>
                            {getSetting('business_what_we_do_subtitle', 'Our comprehensive suite of services covers every aspect of digital content distribution')}
                        </p>
                    </div>

                    <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                        {whatWeDoItems.map((item, index) => (
                            <div
                                key={index}
                                className={`group relative overflow-hidden rounded-2xl p-8 transition-all duration-500 transform hover:scale-105 ${
                                    isDark
                                        ? 'bg-gradient-to-br from-gray-800 to-gray-900 hover:from-gray-700 hover:to-gray-800 border border-gray-700'
                                        : 'bg-white hover:bg-gradient-to-br hover:from-white hover:to-blue-50 shadow-lg hover:shadow-2xl border border-gray-100'
                                }`}
                            >
                                {/* Background decoration */}
                                <div className="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-blue-500/10 to-purple-500/10 rounded-full -translate-y-12 translate-x-12 group-hover:scale-150 transition-transform duration-700"></div>

                                {/* Icon */}
                                <div className="relative mb-6">
                                    <div className="w-16 h-16 rounded-2xl flex items-center justify-center text-white text-2xl group-hover:scale-110 transition-transform duration-300" style={{ background: 'linear-gradient(135deg, rgb(255, 107, 53), rgb(255, 87, 34))' }}>
                                        {item.icon}
                                    </div>
                                </div>

                                {/* Content */}
                                <h3 className={`text-2xl font-bold mb-4 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                    {item.title}
                                </h3>
                                <p className={`leading-relaxed ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                                    {item.description}
                                </p>

                                {/* Hover arrow */}
                                <div className={`mt-6 opacity-0 group-hover:opacity-100 transition-opacity duration-300`}>
                                    <svg
                                        className="w-6 h-6"
                                        style={{ color: 'rgb(255, 107, 53)' }}
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            {/* Interactive Process Section */}
            <section className={`py-20 ${isDark ? 'bg-gradient-to-br from-gray-900 to-black' : 'bg-white'}`}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center mb-16">
                        <h2 className={`text-4xl md:text-5xl font-bold mb-6 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                            {getSetting('business_process_title', 'Our Process')}
                        </h2>
                        <p className={`text-xl max-w-3xl mx-auto ${isDark ? 'text-gray-400' : 'text-gray-600'}`}>
                            {getSetting('business_process_subtitle', 'From discovery to distribution, we handle every step of the content journey')}
                        </p>
                    </div>

                    <div className="grid lg:grid-cols-2 gap-16 items-center">
                        {/* Process Steps */}
                        <div className="space-y-6">
                            {processItems.map((item, index) => (
                                <div
                                    key={index}
                                    className={`group cursor-pointer transition-all duration-300 ${
                                        activeProcessStep === index
                                            ? `${isDark ? 'bg-gray-800' : 'bg-blue-50'} rounded-2xl p-6 shadow-lg`
                                            : 'p-6'
                                    }`}
                                    onClick={() => setActiveProcessStep(index)}
                                >
                                    <div className="flex items-start space-x-6">
                                        <div className={`flex-shrink-0 w-16 h-16 rounded-2xl flex items-center justify-center text-white font-bold text-xl transition-all duration-300 ${
                                            activeProcessStep === index
                                                ? 'scale-110'
                                                : 'bg-gradient-to-br from-gray-400 to-gray-500'
                                        }`}
                                        style={activeProcessStep === index ? { background: 'linear-gradient(135deg, rgb(255, 107, 53), rgb(255, 87, 34))' } : {}}>
                                            {item.step}
                                        </div>
                                        <div className="flex-1">
                                            <h3 className={`text-xl font-bold mb-3 transition-colors duration-300 ${
                                                isDark ? 'text-white' : 'text-gray-900'
                                            }`}
                                            style={activeProcessStep === index ? { color: 'rgb(255, 107, 53)' } : {}}>
                                                {item.title}
                                            </h3>
                                            <p className={`leading-relaxed transition-colors duration-300 ${
                                                isDark ? 'text-gray-300' : 'text-gray-600'
                                            } ${activeProcessStep === index ? (isDark ? 'text-gray-200' : 'text-gray-700') : ''}`}>
                                                {item.description}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>

                        {/* Visual Representation */}
                        <div className="relative">
                            <div className={`relative rounded-3xl p-12 overflow-hidden ${
                                isDark ? 'bg-gradient-to-br from-gray-800 to-gray-900' : 'bg-gradient-to-br from-blue-50 to-purple-50'
                            }`}>
                                {/* Background decoration */}
                                <div className="absolute inset-0 opacity-10">
                                    {[...Array(20)].map((_, i) => (
                                        <div
                                            key={i}
                                            className={`absolute rounded-full ${isDark ? 'bg-blue-400' : 'bg-blue-300'} animate-pulse`}
                                            style={{
                                                width: Math.random() * 6 + 2 + 'px',
                                                height: Math.random() * 6 + 2 + 'px',
                                                top: Math.random() * 100 + '%',
                                                left: Math.random() * 100 + '%',
                                                animationDelay: Math.random() * 3 + 's',
                                            }}
                                        />
                                    ))}
                                </div>

                                {/* Active step visualization */}
                                <div className="relative text-center">
                                    <div className="mb-8">
                                        <div className="w-32 h-32 mx-auto rounded-full flex items-center justify-center text-white text-4xl font-bold shadow-2xl" style={{ background: 'linear-gradient(135deg, rgb(255, 107, 53), rgb(255, 87, 34))' }}>
                                            {processItems[activeProcessStep]?.step || '1'}
                                        </div>
                                    </div>
                                    <h3 className={`text-2xl font-bold mb-4 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                        {processItems[activeProcessStep]?.title || 'Select a step'}
                                    </h3>
                                    <p className={`text-lg ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                                        {processItems[activeProcessStep]?.description || 'Click on a process step to see details'}
                                    </p>
                                </div>

                                {/* Progress indicator */}
                                <div className="mt-8">
                                    <div className={`w-full h-2 rounded-full ${isDark ? 'bg-gray-700' : 'bg-gray-200'}`}>
                                        <div
                                            className="h-2 rounded-full transition-all duration-500"
                                            style={{
                                                width: `${((activeProcessStep + 1) / processItems.length) * 100}%`,
                                                background: 'linear-gradient(90deg, rgb(255, 107, 53), rgb(255, 87, 34))'
                                            }}
                                        ></div>
                                    </div>
                                    <div className="flex justify-between mt-2 text-xs">
                                        <span className={isDark ? 'text-gray-400' : 'text-gray-500'}>Step {activeProcessStep + 1}</span>
                                        <span className={isDark ? 'text-gray-400' : 'text-gray-500'}>{processItems.length} Total Steps</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* New Values/Mission Section */}
            <section className={`py-20 ${isDark ? 'bg-black' : 'bg-gray-50'}`}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center mb-16">
                        <h2 className={`text-4xl md:text-5xl font-bold mb-6 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                            {getSetting('business_values_title', 'Our Core Values')}
                        </h2>
                        <p className={`text-xl max-w-3xl mx-auto ${isDark ? 'text-gray-400' : 'text-gray-600'}`}>
                            {getSetting('business_values_subtitle', 'The principles that guide everything we do')}
                        </p>
                    </div>

                    <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div className={`text-center p-8 rounded-2xl ${isDark ? 'bg-gray-800' : 'bg-white'} shadow-lg hover:shadow-2xl transition-shadow duration-300`}>
                            <div className="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6" style={{ background: 'linear-gradient(135deg, rgb(255, 107, 53), rgb(255, 87, 34))' }}>
                                <svg className="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 className={`text-xl font-bold mb-4 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                {getSetting('business_value_1_title', 'Transparency')}
                            </h3>
                            <p className={`${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                                {getSetting('business_value_1_description', 'Open communication and honest reporting in all our partnerships')}
                            </p>
                        </div>

                        <div className={`text-center p-8 rounded-2xl ${isDark ? 'bg-gray-800' : 'bg-white'} shadow-lg hover:shadow-2xl transition-shadow duration-300`}>
                            <div className="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6" style={{ background: 'linear-gradient(135deg, rgb(255, 107, 53), rgb(255, 87, 34))' }}>
                                <svg className="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <h3 className={`text-xl font-bold mb-4 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                {getSetting('business_value_2_title', 'Innovation')}
                            </h3>
                            <p className={`${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                                {getSetting('business_value_2_description', 'Constantly evolving our technology and strategies for better results')}
                            </p>
                        </div>

                        <div className={`text-center p-8 rounded-2xl ${isDark ? 'bg-gray-800' : 'bg-white'} shadow-lg hover:shadow-2xl transition-shadow duration-300`}>
                            <div className="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6" style={{ background: 'linear-gradient(135deg, rgb(255, 107, 53), rgb(255, 87, 34))' }}>
                                <svg className="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <h3 className={`text-xl font-bold mb-4 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                {getSetting('business_value_3_title', 'Partnership')}
                            </h3>
                            <p className={`${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                                {getSetting('business_value_3_description', 'Building long-term relationships based on mutual success')}
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            {/* Enhanced CTA Section */}
            <section className="relative py-24 overflow-hidden" style={{ background: 'linear-gradient(135deg, rgb(255, 107, 53), rgb(255, 87, 34), rgb(255, 107, 53))' }}>
                {/* Background Pattern */}
                <div className="absolute inset-0 opacity-20">
                    <div className="absolute inset-0">
                        {[...Array(30)].map((_, i) => (
                            <div
                                key={i}
                                className="absolute rounded-full bg-white animate-pulse"
                                style={{
                                    width: Math.random() * 6 + 2 + 'px',
                                    height: Math.random() * 6 + 2 + 'px',
                                    top: Math.random() * 100 + '%',
                                    left: Math.random() * 100 + '%',
                                    animationDelay: Math.random() * 3 + 's',
                                    animationDuration: (Math.random() * 2 + 2) + 's',
                                }}
                            />
                        ))}
                    </div>
                </div>

                <div className="relative max-w-5xl mx-auto text-center px-4 sm:px-6 lg:px-8">
                    <h2 className="text-4xl md:text-6xl font-bold text-white mb-6">
                        {getSetting('business_cta_title', 'Ready to Transform Your Content Business?')}
                    </h2>
                    <p className="text-xl md:text-2xl text-white/90 mb-12 max-w-3xl mx-auto leading-relaxed">
                        {getSetting('business_cta_description', 'Join our ecosystem and unlock the full potential of your content with our comprehensive business solutions.')}
                    </p>

                    <div className="flex flex-col sm:flex-row gap-6 justify-center mb-12">
                        <button className="group bg-white px-10 py-5 rounded-2xl text-lg font-bold transition-all duration-300 transform hover:scale-105 hover:shadow-2xl" style={{ color: 'rgb(255, 107, 53)' }}>
                            <span className="flex items-center justify-center">
                                {getSetting('business_cta_button_1', 'Start Your Journey')}
                                <svg className="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </span>
                        </button>
                        <button className="group border-2 border-white text-white px-10 py-5 rounded-2xl text-lg font-bold transition-all duration-300 hover:bg-white" style={{ '--hover-color': 'rgb(255, 107, 53)' }} onMouseEnter={(e) => e.target.style.color = 'rgb(255, 107, 53)'} onMouseLeave={(e) => e.target.style.color = 'white'}>
                            <span className="flex items-center justify-center">
                                {getSetting('business_cta_button_2', 'Schedule Consultation')}
                                <svg className="ml-2 w-5 h-5 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </span>
                        </button>
                    </div>

                    {/* Trust indicators */}
                    <div className="flex flex-wrap justify-center items-center gap-8 text-white/80">
                        <div className="flex items-center space-x-2">
                            <svg className="w-5 h-5 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd" />
                            </svg>
                            <span className="text-sm font-medium">{getSetting('business_trust_1', 'Free Consultation')}</span>
                        </div>
                        <div className="flex items-center space-x-2">
                            <svg className="w-5 h-5 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd" />
                            </svg>
                            <span className="text-sm font-medium">{getSetting('business_trust_2', 'No Hidden Fees')}</span>
                        </div>
                        <div className="flex items-center space-x-2">
                            <svg className="w-5 h-5 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd" />
                            </svg>
                            <span className="text-sm font-medium">{getSetting('business_trust_3', 'Dedicated Support')}</span>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    );
}

export default Business;
