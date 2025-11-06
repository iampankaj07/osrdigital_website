import React from 'react';
import { useState, useEffect } from 'react';
import { useTheme } from '../../contexts/ThemeContext';
import Breadcrumbs from '../common/Breadcrumbs';

function CompactHero({ page = 'page', title, subtitle, description, breadcrumbs }) {
    const { isDark } = useTheme();
    const [isVisible, setIsVisible] = useState(false);

    useEffect(() => {
        setIsVisible(true);
    }, []);

    // Use props or fallback data
    const displayTitle = title || `${page.charAt(0).toUpperCase() + page.slice(1)}`;
    const displaySubtitle = subtitle;
    const displayDescription = description;

    return (
        <section className={`py-20 pt-32 ${isDark ? 'bg-gray-900' : 'bg-gray-50'}`}>
            <div className="container-minimal">
                <div className="text-center max-w-4xl mx-auto">
                    <div className={`transition-all duration-1000 ${isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'}`}>
                        {/* Breadcrumbs */}
                        {breadcrumbs && (
                            <div className="mb-8 flex justify-center">
                                <Breadcrumbs items={breadcrumbs} />
                            </div>
                        )}

                        {/* Badge/Subtitle */}
                        {displaySubtitle && (
                            <div className="mb-6">
                                <div className={`inline-flex items-center px-4 py-2 rounded-full text-sm font-medium ${
                                    isDark ? 'bg-gray-800 text-gray-300' : 'bg-gray-100 text-gray-600'
                                }`}>
                                    <div className="w-2 h-2 rounded-full bg-brand-orange-500 mr-2"></div>
                                    {displaySubtitle}
                                </div>
                            </div>
                        )}

                        {/* Main Title */}
                        <div className="mb-8">
                            <h1 className={`text-3xl md:text-4xl lg:text-5xl font-bold mb-4 leading-tight ${
                                isDark ? 'text-white' : 'text-gray-900'
                            }`}>
                                {displayTitle}
                            </h1>
                            {displayDescription && (
                                <div className={`text-lg md:text-xl leading-relaxed max-w-3xl mx-auto ${
                                    isDark ? 'text-gray-300' : 'text-gray-600'
                                }`}
                                dangerouslySetInnerHTML={{ __html: displayDescription }}
                                />
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}

export default CompactHero;
