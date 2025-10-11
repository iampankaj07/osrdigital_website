import { useTheme } from '../../contexts/ThemeContext';

function TextBlock({ data, settings, pageSettings }) {
    const { isDark } = useTheme();
    
    const {
        title = '',
        content = '',
        alignment = 'left',
        maxWidth = 'full',
        padding = 'normal',
        backgroundColor = 'transparent'
    } = data;

    const alignmentClasses = {
        'left': 'text-left',
        'center': 'text-center',
        'right': 'text-right'
    };

    const maxWidthClasses = {
        'full': 'max-w-full',
        '7xl': 'max-w-7xl',
        '6xl': 'max-w-6xl',
        '5xl': 'max-w-5xl',
        '4xl': 'max-w-4xl',
        '3xl': 'max-w-3xl',
        '2xl': 'max-w-2xl',
        'xl': 'max-w-xl',
        'lg': 'max-w-lg'
    };

    const paddingClasses = {
        'none': 'py-0',
        'small': 'py-8',
        'normal': 'py-16',
        'large': 'py-24',
        'xlarge': 'py-32'
    };

    const backgroundClasses = {
        'transparent': '',
        'white': isDark ? 'bg-gray-800' : 'bg-white',
        'gray': isDark ? 'bg-gray-900' : 'bg-gray-50',
        'primary': isDark ? 'bg-gray-800' : 'bg-blue-50'
    };

    return (
        <section className={`${paddingClasses[padding]} ${backgroundClasses[backgroundColor]}`}>
            <div className={`max-w-7xl mx-auto px-4 sm:px-6 lg:px-8`}>
                <div className={`mx-auto ${maxWidthClasses[maxWidth]} ${alignmentClasses[alignment]}`}>
                    {title && (
                        <h2 className={`text-3xl sm:text-4xl font-bold mb-6 ${
                            isDark ? 'text-white' : 'text-gray-900'
                        }`}>
                            {title}
                        </h2>
                    )}
                    
                    {content && (
                        <div 
                            className={`prose prose-lg max-w-none ${
                                isDark 
                                    ? 'prose-invert text-gray-300' 
                                    : 'text-gray-600'
                            }`}
                            dangerouslySetInnerHTML={{ __html: content }}
                        />
                    )}
                </div>
            </div>
        </section>
    );
}

export default TextBlock;
