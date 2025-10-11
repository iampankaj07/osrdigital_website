import { useTheme } from '../../contexts/ThemeContext';

function DividerBlock({ data, settings, pageSettings }) {
    const { isDark } = useTheme();
    
    const {
        style = 'line',
        color = 'gray',
        thickness = 'thin',
        padding = 'normal'
    } = data;

    const paddingClasses = {
        'none': 'py-0',
        'small': 'py-8',
        'normal': 'py-16',
        'large': 'py-24'
    };

    const colorClasses = {
        'gray': isDark ? 'border-gray-700' : 'border-gray-200',
        'primary': isDark ? 'border-blue-600' : 'border-blue-300',
        'accent': isDark ? 'border-orange-600' : 'border-orange-300',
        'white': 'border-white',
        'transparent': 'border-transparent'
    };

    const thicknessClasses = {
        'thin': 'border-t',
        'medium': 'border-t-2',
        'thick': 'border-t-4'
    };

    if (style === 'line') {
        return (
            <div className={`${paddingClasses[padding]}`}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className={`${thicknessClasses[thickness]} ${colorClasses[color]}`} />
                </div>
            </div>
        );
    }

    if (style === 'dots') {
        return (
            <div className={`${paddingClasses[padding]}`}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex justify-center">
                        <div className="flex space-x-2">
                            {[...Array(5)].map((_, i) => (
                                <div
                                    key={i}
                                    className={`w-2 h-2 rounded-full ${
                                        color === 'gray' 
                                            ? (isDark ? 'bg-gray-600' : 'bg-gray-400')
                                            : color === 'primary'
                                            ? (isDark ? 'bg-blue-600' : 'bg-blue-400')
                                            : color === 'accent'
                                            ? (isDark ? 'bg-orange-600' : 'bg-orange-400')
                                            : 'bg-white'
                                    }`}
                                />
                            ))}
                        </div>
                    </div>
                </div>
            </div>
        );
    }

    if (style === 'spacer') {
        return (
            <div className={`${paddingClasses[padding]}`} />
        );
    }

    return null;
}

export default DividerBlock;
