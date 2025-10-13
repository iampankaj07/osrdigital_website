import React, { createContext, useContext, useEffect, useState } from 'react';

const ThemeContext = createContext();

export function ThemeProvider({ children }) {
    const [theme, setTheme] = useState('light'); // Start with light mode as default
    const [isInitialized, setIsInitialized] = useState(false);

    useEffect(() => {
        // Initialize theme from localStorage, backend settings, or system preference
        const initializeTheme = async () => {
            const savedTheme = localStorage.getItem('theme');

            if (savedTheme) {
                setTheme(savedTheme);
                setIsInitialized(true);
                return;
            }

            try {
                // Fetch default theme from backend settings
                const response = await fetch('/api/settings/flat');
                const settings = await response.json();

                const defaultTheme = settings.default_theme || 'light';
                const darkModeEnabled = settings.dark_mode_enabled !== false;

                if (!darkModeEnabled) {
                    setTheme('light');
                } else if (defaultTheme === 'auto') {
                    // Use system preference
                    const systemPrefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                    setTheme(systemPrefersDark ? 'dark' : 'light');
                } else {
                    setTheme(defaultTheme);
                }
            } catch (error) {
                console.warn('Failed to fetch theme settings, using system preference');
                // Fallback to system preference
                const systemPrefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                setTheme(systemPrefersDark ? 'dark' : 'light');
            }

            setIsInitialized(true);
        };

        initializeTheme();
    }, []);

    useEffect(() => {
        // Only apply theme changes after initialization
        if (!isInitialized) return;

        // Apply theme to document
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        // Save to localStorage
        localStorage.setItem('theme', theme);
    }, [theme, isInitialized]);

    const toggleTheme = () => {
        setTheme(prevTheme => prevTheme === 'dark' ? 'light' : 'dark');
    };

    return (
        <ThemeContext.Provider value={{ theme, toggleTheme, isDark: theme === 'dark', isInitialized }}>
            {children}
        </ThemeContext.Provider>
    );
}

export function useTheme() {
    const context = useContext(ThemeContext);
    if (!context) {
        throw new Error('useTheme must be used within a ThemeProvider');
    }
    return context;
}
