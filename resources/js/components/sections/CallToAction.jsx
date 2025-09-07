
import { Link } from 'react-router-dom';
import { useAllSettings } from '../../hooks/useSettings';
import { useTheme } from '../../contexts/ThemeContext';

function CallToAction() {
    const { getSetting, loading, error } = useAllSettings();
    const { isDark } = useTheme();

    // Show loading skeleton while settings are being fetched
    if (loading) {
        return (
            <section className={`py-32 ${isDark ? 'bg-gray-800' : 'bg-gray-100'}`}>
                <div className="max-w-6xl mx-auto text-center px-4 sm:px-6 lg:px-8">
                    <div className="animate-pulse">
                        <div className={`h-8 rounded-full w-48 mx-auto mb-8 ${isDark ? 'bg-gray-700' : 'bg-gray-300'}`}></div>
                        <div className={`h-16 rounded-lg mb-8 ${isDark ? 'bg-gray-700' : 'bg-gray-300'}`}></div>
                        <div className={`h-6 rounded-lg mb-12 max-w-4xl mx-auto ${isDark ? 'bg-gray-700' : 'bg-gray-300'}`}></div>
                        <div className="flex gap-6 justify-center mb-16">
                            <div className={`h-12 rounded-lg w-32 ${isDark ? 'bg-gray-700' : 'bg-gray-300'}`}></div>
                            <div className={`h-12 rounded-lg w-32 ${isDark ? 'bg-gray-700' : 'bg-gray-300'}`}></div>
                        </div>
                        <div className="grid md:grid-cols-3 gap-8">
                            {[1, 2, 3].map(i => (
                                <div key={i} className={`h-32 rounded-2xl ${isDark ? 'bg-gray-700' : 'bg-gray-300'}`}></div>
                            ))}
                        </div>
                    </div>
                </div>
            </section>
        );
    }

    const primaryColor = getSetting('brand_primary_color', '#ec681b');

    // CTA Features from settings
    const features = [
        {
            title: getSetting('cta_feature_1_title', 'Fast Partnership'),
            description: getSetting('cta_feature_1_description', 'Quick approval process for quality content creators and studios.'),
            icon: (
                <svg className="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            )
        },
        {
            title: getSetting('cta_feature_2_title', 'Global Reach'),
            description: getSetting('cta_feature_2_description', 'Access to worldwide audiences through strategic distribution.'),
            icon: (
                <svg className="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            )
        },
        {
            title: getSetting('cta_feature_3_title', 'Fair Revenue'),
            description: getSetting('cta_feature_3_description', 'Transparent revenue sharing with competitive rates for creators.'),
            icon: (
                <svg className="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                </svg>
            )
        }
    ];

    return (
        <section className={`py-32 ${isDark ? 'bg-gray-800' : 'bg-gray-100'}`}>
            <div className="max-w-6xl mx-auto text-center px-4 sm:px-6 lg:px-8">
                <div className="mb-8">
                    <div className={`inline-flex items-center px-4 py-2 rounded-full text-sm font-medium mb-6 ${
                        isDark ? 'bg-gray-700/50 border-gray-600' : 'bg-white/50 border-gray-300'
                    }`}
                         style={{
                             color: primaryColor,
                             border: '1px solid'
                         }}>
                        <span className="w-2 h-2 rounded-full mr-2"
                              style={{ backgroundColor: primaryColor }}></span>
                        {getSetting('cta_badge_text', 'Let\'s Create Together')}
                    </div>
                </div>

                <h2 className={`text-5xl md:text-6xl lg:text-7xl font-bold ${isDark ? 'text-white' : 'text-gray-900'} mb-8 leading-tight`}>
                    {getSetting('cta_main_title', 'Ready to Share Your')}{' '}
                    <span style={{ color: primaryColor }}>
                        {getSetting('cta_highlighted_title', 'Story?')}
                    </span>
                </h2>

                <p className={`text-xl md:text-2xl ${isDark ? 'text-gray-300' : 'text-gray-600'} mb-12 max-w-4xl mx-auto leading-relaxed`}>
                    {getSetting('cta_description', 'Join our network of visionary creators and studios. Let\'s bring your exceptional content to audiences worldwide through strategic digital distribution.')}
                </p>

                <div className="flex flex-col sm:flex-row gap-6 justify-center items-center mb-16">
                    <Link
                        to="/contact"
                        className="text-white px-10 py-4 rounded-lg text-lg font-bold transition-all flex items-center gap-3 hover:opacity-90"
                        style={{ backgroundColor: primaryColor }}
                    >
                        <span>{getSetting('cta_primary_button_text', 'Start Partnership')}</span>
                        <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </Link>

                    <Link
                        to="/portfolio"
                        className={`border-2 ${isDark ? 'border-gray-400 text-white hover:bg-gray-700' : 'border-gray-600 text-gray-900 hover:bg-gray-50'} px-10 py-4 rounded-lg text-lg font-semibold transition-colors flex items-center gap-3`}
                    >
                        <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        <span>{getSetting('cta_secondary_button_text', 'View Our Work')}</span>
                    </Link>
                </div>

                {/* Contact Features */}
                <div className="grid md:grid-cols-3 gap-8 text-left">
                    {features.map((feature, index) => (
                        <div key={index} className={`${isDark ? 'bg-gray-700 hover:bg-gray-600' : 'bg-white hover:bg-gray-50'} rounded-2xl p-6 transition-colors shadow-lg`}>
                            <div className="w-12 h-12 rounded-xl flex items-center justify-center mb-4"
                                 style={{ backgroundColor: primaryColor }}>
                                {feature.icon}
                            </div>
                            <h3 className={`text-xl font-semibold ${isDark ? 'text-white' : 'text-gray-900'} mb-2`}>
                                {feature.title}
                            </h3>
                            <p className={`${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                                {feature.description}
                            </p>
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}

export default CallToAction;
