import { useState } from 'react';
import { useTheme } from '../../contexts/ThemeContext';

function TabsBlock({ data, settings, pageSettings }) {
    const { isDark } = useTheme();
    const [activeTab, setActiveTab] = useState(0);
    
    const {
        title = 'Tabs',
        subtitle = '',
        tabs = [],
        padding = 'normal'
    } = data;

    const paddingClasses = {
        'none': 'py-0',
        'small': 'py-8',
        'normal': 'py-16',
        'large': 'py-24'
    };

    if (!tabs || tabs.length === 0) {
        return null;
    }

    return (
        <section className={`${paddingClasses[padding]} ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {(title || subtitle) && (
                    <div className="text-center mb-12">
                        {title && (
                            <h2 className={`text-3xl sm:text-4xl font-bold mb-4 ${
                                isDark ? 'text-white' : 'text-gray-900'
                            }`}>
                                {title}
                            </h2>
                        )}
                        {subtitle && (
                            <p className={`text-xl ${
                                isDark ? 'text-gray-300' : 'text-gray-600'
                            }`}>
                                {subtitle}
                            </p>
                        )}
                    </div>
                )}
                
                <div className="max-w-4xl mx-auto">
                    <div className="border-b border-gray-200 dark:border-gray-700">
                        <nav className="-mb-px flex space-x-8">
                            {tabs.map((tab, index) => (
                                <button
                                    key={index}
                                    onClick={() => setActiveTab(index)}
                                    className={`py-2 px-1 border-b-2 font-medium text-sm transition-colors ${
                                        activeTab === index
                                            ? 'border-orange-500 text-orange-600'
                                            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                                    }`}
                                >
                                    {tab.title}
                                </button>
                            ))}
                        </nav>
                    </div>
                    
                    <div className="mt-8">
                        {tabs[activeTab] && (
                            <div className={`prose max-w-none ${
                                isDark ? 'prose-invert text-gray-300' : 'text-gray-600'
                            }`}>
                                <div dangerouslySetInnerHTML={{ __html: tabs[activeTab].content }} />
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </section>
    );
}

export default TabsBlock;
