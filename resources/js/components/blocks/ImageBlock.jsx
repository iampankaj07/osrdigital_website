import { useTheme } from '../../contexts/ThemeContext';

function ImageBlock({ data, settings, pageSettings }) {
    const { isDark } = useTheme();
    
    const {
        image = '',
        alt = '',
        caption = '',
        alignment = 'center',
        maxWidth = 'full',
        padding = 'normal',
        borderRadius = 'none'
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
        'large': 'py-24'
    };

    const borderRadiusClasses = {
        'none': 'rounded-none',
        'small': 'rounded-lg',
        'medium': 'rounded-xl',
        'large': 'rounded-2xl',
        'full': 'rounded-full'
    };

    if (!image) {
        return null;
    }

    return (
        <section className={`${paddingClasses[padding]}`}>
            <div className={`max-w-7xl mx-auto px-4 sm:px-6 lg:px-8`}>
                <div className={`mx-auto ${maxWidthClasses[maxWidth]} ${alignmentClasses[alignment]}`}>
                    <div className="relative">
                        <img
                            src={image}
                            alt={alt}
                            className={`w-full h-auto ${borderRadiusClasses[borderRadius]}`}
                        />
                        {caption && (
                            <p className={`mt-4 text-sm ${
                                isDark ? 'text-gray-400' : 'text-gray-600'
                            }`}>
                                {caption}
                            </p>
                        )}
                    </div>
                </div>
            </div>
        </section>
    );
}

export default ImageBlock;
