import { Link } from 'react-router-dom';
import { useTheme } from '../../contexts/ThemeContext';

function Breadcrumbs({ items }) {
    const { isDark } = useTheme();

    if (!items || items.length === 0) {
        return null;
    }

    return (
        <nav className="flex" aria-label="Breadcrumb">
            <ol className="inline-flex items-center space-x-1 md:space-x-3">
                {items.map((item, index) => (
                    <li key={index} className="inline-flex items-center">
                        {index > 0 && (
                            <svg
                                className={`w-6 h-6 ${isDark ? 'text-gray-400' : 'text-gray-400'}`}
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    fillRule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clipRule="evenodd"
                                />
                            </svg>
                        )}
                        {item.href ? (
                            <Link
                                to={item.href}
                                className={`inline-flex items-center text-sm font-medium transition-colors duration-200 ${
                                    isDark
                                        ? 'text-gray-400 hover:text-brand-orange-400'
                                        : 'text-gray-500 hover:text-brand-orange-600'
                                }`}
                            >
                                {item.icon && (
                                    <i className={`${item.icon} mr-2`}></i>
                                )}
                                {item.label}
                            </Link>
                        ) : (
                            <span
                                className={`inline-flex items-center text-sm font-medium ${
                                    isDark ? 'text-gray-300' : 'text-gray-700'
                                }`}
                            >
                                {item.icon && (
                                    <i className={`${item.icon} mr-2`}></i>
                                )}
                                {item.label}
                            </span>
                        )}
                    </li>
                ))}
            </ol>
        </nav>
    );
}

export default Breadcrumbs;
