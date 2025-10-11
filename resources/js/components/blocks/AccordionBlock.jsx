import { useState } from 'react';
import { useTheme } from '../../contexts/ThemeContext';

function AccordionBlock({ data, settings, pageSettings }) {
    const { isDark } = useTheme();
    const [openItems, setOpenItems] = useState(new Set());
    
    const {
        title = 'Frequently Asked Questions',
        subtitle = '',
        items = [],
        padding = 'normal'
    } = data;

    const paddingClasses = {
        'none': 'py-0',
        'small': 'py-8',
        'normal': 'py-16',
        'large': 'py-24'
    };

    const toggleItem = (index) => {
        const newOpenItems = new Set(openItems);
        if (newOpenItems.has(index)) {
            newOpenItems.delete(index);
        } else {
            newOpenItems.add(index);
        }
        setOpenItems(newOpenItems);
    };

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
                
                <div className="max-w-3xl mx-auto space-y-4">
                    {items.map((item, index) => (
                        <div key={index} className={`border rounded-lg ${
                            isDark ? 'border-gray-700' : 'border-gray-200'
                        }`}>
                            <button
                                onClick={() => toggleItem(index)}
                                className={`w-full px-6 py-4 text-left flex justify-between items-center hover:bg-opacity-50 transition-colors ${
                                    isDark ? 'hover:bg-gray-800' : 'hover:bg-gray-50'
                                }`}
                            >
                                <span className={`font-medium ${
                                    isDark ? 'text-white' : 'text-gray-900'
                                }`}>
                                    {item.question}
                                </span>
                                <span className={`text-xl transition-transform ${
                                    openItems.has(index) ? 'rotate-180' : ''
                                } ${isDark ? 'text-gray-400' : 'text-gray-500'}`}>
                                    ▼
                                </span>
                            </button>
                            {openItems.has(index) && (
                                <div className={`px-6 pb-4 ${
                                    isDark ? 'text-gray-300' : 'text-gray-600'
                                }`}>
                                    {item.answer}
                                </div>
                            )}
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}

export default AccordionBlock;
