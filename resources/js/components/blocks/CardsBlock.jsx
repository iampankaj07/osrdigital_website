import { useTheme } from '../../contexts/ThemeContext';

function CardsBlock({ data, settings, pageSettings }) {
    const { isDark } = useTheme();
    
    const {
        title = 'Cards',
        subtitle = '',
        cards = [],
        columns = 3,
        padding = 'normal'
    } = data;

    const paddingClasses = {
        'none': 'py-0',
        'small': 'py-8',
        'normal': 'py-16',
        'large': 'py-24'
    };

    const columnClasses = {
        1: 'grid-cols-1',
        2: 'grid-cols-1 md:grid-cols-2',
        3: 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3',
        4: 'grid-cols-1 md:grid-cols-2 lg:grid-cols-4'
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
                
                <div className={`grid ${columnClasses[columns]} gap-8`}>
                    {cards.map((card, index) => (
                        <div key={index} className={`p-6 rounded-lg shadow-lg ${
                            isDark ? 'bg-gray-800' : 'bg-white'
                        }`}>
                            {card.image && (
                                <img
                                    src={card.image}
                                    alt={card.title}
                                    className="w-full h-48 object-cover rounded-lg mb-4"
                                />
                            )}
                            <h3 className={`text-xl font-semibold mb-2 ${
                                isDark ? 'text-white' : 'text-gray-900'
                            }`}>
                                {card.title}
                            </h3>
                            <p className={`mb-4 ${
                                isDark ? 'text-gray-300' : 'text-gray-600'
                            }`}>
                                {card.description}
                            </p>
                            {card.button && (
                                <a
                                    href={card.button.url || '#'}
                                    className="inline-flex items-center px-4 py-2 bg-brand-orange-600 text-white rounded-lg hover:bg-brand-orange-700 transition-colors"
                                >
                                    {card.button.text}
                                </a>
                            )}
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}

export default CardsBlock;
