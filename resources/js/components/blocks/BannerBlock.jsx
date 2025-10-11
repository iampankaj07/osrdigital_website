import { useTheme } from '../../contexts/ThemeContext';

function BannerBlock({ data, settings, pageSettings }) {
    const { isDark } = useTheme();
    
    const {
        title = 'Important Notice',
        description = 'This is an important banner message.',
        backgroundColor = 'primary',
        textColor = 'white',
        alignment = 'center',
        padding = 'normal',
        dismissible = false
    } = data;

    const paddingClasses = {
        'none': 'py-0',
        'small': 'py-4',
        'normal': 'py-6',
        'large': 'py-8'
    };

    const backgroundClasses = {
        'primary': isDark ? 'bg-blue-600' : 'bg-blue-600',
        'secondary': isDark ? 'bg-gray-600' : 'bg-gray-600',
        'accent': isDark ? 'bg-brand-orange-600' : 'bg-brand-orange-600',
        'success': isDark ? 'bg-green-600' : 'bg-green-600',
        'warning': isDark ? 'bg-yellow-600' : 'bg-yellow-600',
        'error': isDark ? 'bg-red-600' : 'bg-red-600'
    };

    const textColorClasses = {
        'white': 'text-white',
        'black': 'text-black',
        'gray': 'text-gray-600'
    };

    const alignmentClasses = {
        'left': 'text-left',
        'center': 'text-center',
        'right': 'text-right'
    };

    return (
        <div className={`${paddingClasses[padding]} ${backgroundClasses[backgroundColor]}`}>
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className={`${alignmentClasses[alignment]}`}>
                    <div className="flex items-center justify-between">
                        <div className="flex-1">
                            <h3 className={`text-lg font-semibold ${textColorClasses[textColor]}`}>
                                {title}
                            </h3>
                            {description && (
                                <p className={`mt-1 ${textColorClasses[textColor]}`}>
                                    {description}
                                </p>
                            )}
                        </div>
                        {dismissible && (
                            <button
                                className={`ml-4 ${textColorClasses[textColor]} hover:opacity-75`}
                                onClick={() => {
                                    // Handle dismiss
                                    console.log('Banner dismissed');
                                }}
                            >
                                <span className="sr-only">Dismiss</span>
                                <svg className="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fillRule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clipRule="evenodd" />
                                </svg>
                            </button>
                        )}
                    </div>
                </div>
            </div>
        </div>
    );
}

export default BannerBlock;
