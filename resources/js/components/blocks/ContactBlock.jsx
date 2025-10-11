import { useTheme } from '../../contexts/ThemeContext';

function ContactBlock({ data, settings, pageSettings }) {
    const { isDark } = useTheme();
    
    const {
        title = 'Contact Us',
        subtitle = 'Get in touch with our team',
        padding = 'normal'
    } = data;

    const paddingClasses = {
        'none': 'py-0',
        'small': 'py-8',
        'normal': 'py-16',
        'large': 'py-24'
    };

    return (
        <section className={`${paddingClasses[padding]} ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="text-center mb-12">
                    <h2 className={`text-3xl sm:text-4xl font-bold mb-4 ${
                        isDark ? 'text-white' : 'text-gray-900'
                    }`}>
                        {title}
                    </h2>
                    {subtitle && (
                        <p className={`text-xl ${
                            isDark ? 'text-gray-300' : 'text-gray-600'
                        }`}>
                            {subtitle}
                        </p>
                    )}
                </div>
                
                <div className="max-w-2xl mx-auto">
                    <form className="space-y-6">
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label className={`block text-sm font-medium mb-2 ${
                                    isDark ? 'text-gray-300' : 'text-gray-700'
                                }`}>
                                    Name
                                </label>
                                <input
                                    type="text"
                                    className={`w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent ${
                                        isDark 
                                            ? 'bg-gray-800 border-gray-600 text-white' 
                                            : 'bg-white border-gray-300 text-gray-900'
                                    }`}
                                />
                            </div>
                            <div>
                                <label className={`block text-sm font-medium mb-2 ${
                                    isDark ? 'text-gray-300' : 'text-gray-700'
                                }`}>
                                    Email
                                </label>
                                <input
                                    type="email"
                                    className={`w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent ${
                                        isDark 
                                            ? 'bg-gray-800 border-gray-600 text-white' 
                                            : 'bg-white border-gray-300 text-gray-900'
                                    }`}
                                />
                            </div>
                        </div>
                        <div>
                            <label className={`block text-sm font-medium mb-2 ${
                                isDark ? 'text-gray-300' : 'text-gray-700'
                            }`}>
                                Message
                            </label>
                            <textarea
                                rows={4}
                                className={`w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent ${
                                    isDark 
                                        ? 'bg-gray-800 border-gray-600 text-white' 
                                        : 'bg-white border-gray-300 text-gray-900'
                                }`}
                            />
                        </div>
                        <button
                            type="submit"
                            className="w-full bg-brand-orange-600 text-white py-3 px-6 rounded-lg hover:bg-brand-orange-700 transition-colors"
                        >
                            Send Message
                        </button>
                    </form>
                </div>
            </div>
        </section>
    );
}

export default ContactBlock;
