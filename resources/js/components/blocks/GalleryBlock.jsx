import { useTheme } from '../../contexts/ThemeContext';

function GalleryBlock({ data, settings, pageSettings }) {
    const { isDark } = useTheme();
    
    const {
        images = [],
        columns = 3,
        gap = 'normal',
        padding = 'normal'
    } = data;

    const paddingClasses = {
        'none': 'py-0',
        'small': 'py-8',
        'normal': 'py-16',
        'large': 'py-24'
    };

    const gapClasses = {
        'none': 'gap-0',
        'small': 'gap-2',
        'normal': 'gap-4',
        'large': 'gap-8'
    };

    const columnClasses = {
        1: 'grid-cols-1',
        2: 'grid-cols-1 md:grid-cols-2',
        3: 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3',
        4: 'grid-cols-1 md:grid-cols-2 lg:grid-cols-4',
        5: 'grid-cols-1 md:grid-cols-2 lg:grid-cols-5',
        6: 'grid-cols-1 md:grid-cols-2 lg:grid-cols-6'
    };

    if (!images || images.length === 0) {
        return null;
    }

    return (
        <section className={`${paddingClasses[padding]}`}>
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className={`grid ${columnClasses[columns]} ${gapClasses[gap]}`}>
                    {images.map((image, index) => (
                        <div key={index} className="relative group">
                            <img
                                src={image.url || image}
                                alt={image.alt || `Gallery image ${index + 1}`}
                                className="w-full h-64 object-cover rounded-lg transition-transform group-hover:scale-105"
                            />
                            {image.caption && (
                                <div className="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white p-2 rounded-b-lg">
                                    <p className="text-sm">{image.caption}</p>
                                </div>
                            )}
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}

export default GalleryBlock;
