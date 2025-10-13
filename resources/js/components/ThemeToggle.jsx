import { useTheme } from '../contexts/ThemeContext';

function ThemeToggle({ isOverHero = false }) {
    const { theme, toggleTheme, isDark } = useTheme();

    // Different styles based on context
    const buttonClasses = isOverHero
        ? "p-2 rounded-lg transition-colors duration-200 hover:bg-white/10"
        : `p-2 rounded-lg transition-colors duration-200 ${isDark ? 'hover:bg-white/5' : 'hover:bg-gray-100'}`;

    const iconClasses = isOverHero
        ? "w-5 h-5 text-white/80 hover:text-white transition-colors"
        : isDark
            ? "w-5 h-5 text-gray-300 hover:text-white transition-colors"
            : "w-5 h-5 text-gray-600 hover:text-gray-800 transition-colors";

    return (
        <button
            onClick={toggleTheme}
            className={buttonClasses}
            title={`Switch to ${isDark ? 'light' : 'dark'} mode`}
            aria-label={`Switch to ${isDark ? 'light' : 'dark'} mode`}
        >
            {isDark ? (
                // Sun icon for switching to light mode
                <svg
                    className={iconClasses}
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        strokeWidth={2}
                        d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"
                    />
                </svg>
            ) : (
                // Moon icon for switching to dark mode
                <svg
                    className={iconClasses}
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        strokeWidth={2}
                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"
                    />
                </svg>
            )}
        </button>
    );
}

export default ThemeToggle;
