import { useTheme } from '../../contexts/ThemeContext';

function TestimonialsBlock({ data, settings, pageSettings }) {
    const { isDark } = useTheme();
    
    const {
        title = 'What Our Clients Say',
        subtitle = '',
        testimonials = [],
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
        3: 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3'
    };

    return (
        <section className={`${paddingClasses[padding]} ${isDark ? 'bg-gray-900' : 'bg-gray-50'}`}>
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
                    {testimonials.map((testimonial, index) => (
                        <div key={index} className={`p-6 rounded-lg ${
                            isDark ? 'bg-gray-800' : 'bg-white'
                        } shadow-lg`}>
                            <p className={`text-lg mb-4 ${
                                isDark ? 'text-gray-300' : 'text-gray-600'
                            }`}>
                                "{testimonial.content}"
                            </p>
                            <div className="flex items-center">
                                {testimonial.avatar && (
                                    <img
                                        src={testimonial.avatar}
                                        alt={testimonial.name}
                                        className="w-12 h-12 rounded-full mr-4"
                                    />
                                )}
                                <div>
                                    <div className={`font-semibold ${
                                        isDark ? 'text-white' : 'text-gray-900'
                                    }`}>
                                        {testimonial.name}
                                    </div>
                                    <div className={`text-sm ${
                                        isDark ? 'text-gray-400' : 'text-gray-500'
                                    }`}>
                                        {testimonial.position}
                                    </div>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}

export default TestimonialsBlock;
