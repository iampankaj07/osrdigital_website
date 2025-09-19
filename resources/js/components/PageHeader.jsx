import { useTheme } from '../contexts/ThemeContext';

function PageHeader({ badge, title, description }) {
    const { isDark } = useTheme();

    return (
        <section className={`relative pt-24 pb-16 overflow-hidden ${isDark ? 'bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900' : 'bg-gradient-to-br from-gray-50 via-white to-gray-100'}`}>
            <div className="absolute inset-0 bg-gradient-to-r from-orange-500/10 to-red-500/10"></div>
            <div className="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                {badge && (
                    <div className="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium mb-6" style={{ backgroundColor: '#ff6b35', color: 'white' }}>
                        {badge}
                    </div>
                )}

                <h1 className={`text-4xl lg:text-5xl font-bold mb-6`}>
                    <span className={isDark ? 'text-white' : 'text-gray-900'}>
                        {title?.split(' ').slice(0, -2).join(' ')}
                    </span>{' '}
                    {title?.split(' ').length > 2 && (
                        <span style={{ color: '#ff6b35' }}>
                            {title.split(' ').slice(-2).join(' ')}
                        </span>
                    )}
                </h1>

                {description && (
                    <p className={`text-xl ${isDark ? 'text-gray-300' : 'text-gray-600'} max-w-3xl mx-auto leading-relaxed`}>
                        {description}
                    </p>
                )}
            </div>
        </section>
    );
}

export default PageHeader;
