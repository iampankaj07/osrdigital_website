import React, { useState, useEffect } from 'react';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faArrowUp } from '@fortawesome/free-solid-svg-icons';
import { useTheme } from '../contexts/ThemeContext';
import { useLocation } from 'react-router-dom';

function ScrollToTop() {
    const [isVisible, setIsVisible] = useState(false);
    const { isDark } = useTheme();
    const location = useLocation();

    // Reset scroll invisibly when route changes
    useEffect(() => {
        // Reset scroll immediately and in multiple ways to ensure it works
        window.scrollTo(0, 0);
        document.documentElement.scrollTop = 0;
        document.body.scrollTop = 0;

        // Also use requestAnimationFrame for extra safety
        const scrollReset = requestAnimationFrame(() => {
            window.scrollTo(0, 0);
            document.documentElement.scrollTop = 0;
            document.body.scrollTop = 0;
        });

        return () => cancelAnimationFrame(scrollReset);
    }, [location.pathname]);

    useEffect(() => {
        const toggleVisibility = () => {
            // Show button when page is scrolled down 300px
            if (window.scrollY > 300) {
                setIsVisible(true);
            } else {
                setIsVisible(false);
            }
        };

        window.addEventListener('scroll', toggleVisibility);

        return () => {
            window.removeEventListener('scroll', toggleVisibility);
        };
    }, []);

    const scrollToTop = () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth',
        });
    };

    return (
        <>
            {isVisible && (
                <button
                    onClick={scrollToTop}
                    className={`fixed bottom-8 right-8 z-50 p-4 rounded-full shadow-lg transition-all duration-300 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-offset-2 ${isDark
                        ? 'bg-brand-orange-500 hover:bg-brand-orange-600 text-white focus:ring-brand-orange-500'
                        : 'bg-brand-orange-500 hover:bg-brand-orange-600 text-white focus:ring-brand-orange-500'
                        }`}
                    aria-label="Scroll to top"
                >
                    <FontAwesomeIcon icon={faArrowUp} className="w-5 h-5" />
                </button>
            )}
        </>
    );
}

export default ScrollToTop;

