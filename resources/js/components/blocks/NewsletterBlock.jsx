import { useTheme } from '../../contexts/ThemeContext';

function NewsletterBlock({ data, settings, pageSettings }) {
    const { isDark } = useTheme();
    
    const {
        title = 'Subscribe to our Newsletter',
        subtitle = 'Get the latest updates and news delivered to your inbox',
        padding = 'normal',
        backgroundColor = 'primary'
    } = data;

    const paddingClasses = {
        'none': 'py-0',
        'small': 'py-8',
        'normal': 'py-16',
        'large': 'py-24'
    };

    const backgroundClasses = {
        'primary': isDark ? 'bg-gray-800' : 'bg-blue-600',
        'secondary': isDark ? 'bg-gray-900' : 'bg-gray-800',
        'accent': isDark ? 'bg-brand-orange-900' : 'bg-brand-orange-600',
        'white': isDark ? 'bg-gray-800' : 'bg-white',
        'transparent': ''
    };

    const textColorClasses = {
        'primary': 'text-white',
        'secondary': 'text-white',
        'accent': 'text-white',
        'white': isDark ? 'text-white' : 'text-gray-900',
        'transparent': isDark ? 'text-white' : 'text-gray-900'
    };

    return (
        <section className={`${paddingClasses[padding]} ${backgroundClasses[backgroundColor]}`}>
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="max-w-2xl mx-auto text-center">
                    <h2 className={`text-3xl sm:text-4xl font-bold mb-4 ${textColorClasses[backgroundColor]}`}>
                        {title}
                    </h2>
                    {subtitle && (
                        <p className={`text-xl mb-8 ${
                            backgroundColor === 'white' 
                                ? (isDark ? 'text-gray-300' : 'text-gray-600')
                                : 'text-gray-100'
                        }`}>
                            {subtitle}
                        </p>
                    )}
                    
                    <form className="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
                        <input
                            type="email"
                            placeholder="Enter your email"
                            className={`flex-1 px-4 py-3 rounded-lg border-0 focus:ring-2 focus:ring-orange-500 focus:outline-none ${
                                backgroundColor === 'white'
                                    ? 'text-gray-900 placeholder-gray-500'
                                    : 'text-gray-900 placeholder-gray-500'
                            }`}
                        />
                        <button
                            type="submit"
                            className={`px-6 py-3 rounded-lg font-medium transition-colors ${
                                backgroundColor === 'white'
                                    ? 'bg-brand-orange-600 text-white hover:bg-brand-orange-700'
                                    : 'bg-white text-gray-900 hover:bg-gray-100'
                            }`}
                        >
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>
        </section>
    );
}

export default NewsletterBlock;
