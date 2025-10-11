import { useTheme } from '../../contexts/ThemeContext';

function VideoBlock({ data, settings, pageSettings }) {
    const { isDark } = useTheme();
    
    const {
        videoUrl = '',
        title = '',
        description = '',
        alignment = 'center',
        maxWidth = 'full',
        padding = 'normal'
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

    if (!videoUrl) {
        return null;
    }

    return (
        <section className={`${paddingClasses[padding]}`}>
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className={`mx-auto ${maxWidthClasses[maxWidth]} ${alignmentClasses[alignment]}`}>
                    {(title || description) && (
                        <div className="mb-8">
                            {title && (
                                <h2 className={`text-3xl sm:text-4xl font-bold mb-4 ${
                                    isDark ? 'text-white' : 'text-gray-900'
                                }`}>
                                    {title}
                                </h2>
                            )}
                            {description && (
                                <p className={`text-xl ${
                                    isDark ? 'text-gray-300' : 'text-gray-600'
                                }`}>
                                    {description}
                                </p>
                            )}
                        </div>
                    )}
                    
                    <div className="relative w-full" style={{ paddingBottom: '56.25%' }}>
                        <iframe
                            className="absolute inset-0 w-full h-full rounded-lg"
                            src={videoUrl}
                            title={title || 'Video'}
                            frameBorder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowFullScreen
                        />
                    </div>
                </div>
            </div>
        </section>
    );
}

export default VideoBlock;
