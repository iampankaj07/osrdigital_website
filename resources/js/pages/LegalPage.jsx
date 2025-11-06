import React, { useState, useEffect } from 'react';
import { useParams, useLocation, Navigate, Link } from 'react-router-dom';
import { useTheme } from '../contexts/ThemeContext';
import CompactHero from '../components/sections/CompactHero';

const LegalPage = () => {
    const { slug } = useParams();
    const location = useLocation();
    const [page, setPage] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const { isDark } = useTheme();

    // Determine the page type from URL path if slug is not available
    const pageType = React.useMemo(() => {
        if (slug) {
            return slug;
        }
        // Extract page type from pathname
        const path = location.pathname.replace('/', '');
        return path || null;
    }, [slug, location.pathname]);

    // Update document head for SEO
    useEffect(() => {
        if (page) {
            // Update document title
            document.title = page.meta_title || page.title;

            // Update meta description
            const metaDescription = document.querySelector('meta[name="description"]');
            if (metaDescription) {
                metaDescription.setAttribute('content', page.meta_description || page.excerpt || '');
            } else {
                const newMeta = document.createElement('meta');
                newMeta.name = 'description';
                newMeta.content = page.meta_description || page.excerpt || '';
                document.head.appendChild(newMeta);
            }

            // Update Open Graph tags
            const ogTitle = document.querySelector('meta[property="og:title"]');
            if (ogTitle) {
                ogTitle.setAttribute('content', page.title);
            } else {
                const newOgTitle = document.createElement('meta');
                newOgTitle.setAttribute('property', 'og:title');
                newOgTitle.content = page.title;
                document.head.appendChild(newOgTitle);
            }

            const ogDescription = document.querySelector('meta[property="og:description"]');
            if (ogDescription) {
                ogDescription.setAttribute('content', page.excerpt || '');
            } else {
                const newOgDescription = document.createElement('meta');
                newOgDescription.setAttribute('property', 'og:description');
                newOgDescription.content = page.excerpt || '';
                document.head.appendChild(newOgDescription);
            }
        }
    }, [page]);

    useEffect(() => {
        const fetchPage = async () => {
            setLoading(true);
            setError(null);

            try {
                let response;

                // Map common slugs to specific endpoints
                switch (pageType) {
                    case 'privacy-policy':
                        response = await fetch('/privacy-policy', {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        break;
                    case 'terms-of-service':
                        response = await fetch('/terms-of-service', {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        break;
                    case 'cookies-policy':
                        response = await fetch('/cookies-policy', {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        break;
                    default:
                        if (pageType) {
                            response = await fetch(`/legal/${pageType}`, {
                                headers: {
                                    'Accept': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            });
                        } else {
                            throw new Error('Page type not found');
                        }
                }

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                setPage(data.page);
            } catch (err) {
                console.error('Error fetching legal page:', err);
                setError(err.message);
            } finally {
                setLoading(false);
            }
        };

        if (pageType) {
            fetchPage();
        } else {
            setLoading(false);
            setError('Page type not found');
        }
    }, [pageType, location.pathname]);

    if (loading) {
        return (
            <div className={`min-h-screen ${isDark ? 'bg-gray-900' : 'bg-gray-50'}`}>
                <CompactHero
                    page={pageType || 'legal'}
                    title="Loading..."
                />
                <section className={`py-16 ${isDark ? 'bg-gray-900' : 'bg-gray-50'}`}>
                    <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className={`rounded-xl p-8 md:p-12 shadow-lg ${
                            isDark
                                ? 'bg-gray-800'
                                : 'bg-white'
                        }`}>
                            <div className="space-y-4">
                                <div className={`h-6 w-3/4 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                <div className={`h-4 w-full rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                <div className={`h-4 w-full rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                <div className={`h-4 w-5/6 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                <div className={`h-4 w-full rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                <div className={`h-4 w-4/5 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                <div className={`h-4 w-full rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                <div className={`h-4 w-3/4 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        );
    }

    if (error) {
        return (
            <div className="min-h-screen flex items-center justify-center">
                <div className="text-center max-w-md mx-auto px-4">
                    <div className="mb-6">
                        <i className="fas fa-exclamation-circle text-red-500 text-6xl mb-4"></i>
                        <h1 className={`text-3xl font-bold mb-4 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                            Page Not Found
                        </h1>
                        <p className={`text-lg mb-6 ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                            The legal page you're looking for doesn't exist or isn't available.
                        </p>
                        <Link
                            to="/"
                            className="inline-block bg-brand-orange-500 hover:bg-brand-orange-600 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200"
                        >
                            <i className="fas fa-home mr-2"></i>
                            Return Home
                        </Link>
                    </div>
                </div>
            </div>
        );
    }

    if (!page) {
        return <Navigate to="/404" replace />;
    }

    return (
        <div className={`min-h-screen ${isDark ? 'bg-gray-900' : 'bg-gray-50'}`}>
            {/* Hero Section */}
            <CompactHero
                page={pageType || 'legal'}
                title={page.title}
                description={page.excerpt}
            />
            
      

            {/* Content Section */}
            <section className={`${isDark ? 'bg-gray-900' : 'bg-gray-50'}`}>
                <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className={`rounded-xl p-8 md:p-12 shadow-lg ${
                        isDark
                            ? 'bg-gray-800 text-gray-300'
                            : 'bg-white text-gray-700'
                    }`}>
                        <div
                            className="prose prose-lg max-w-none legal-content"
                            dangerouslySetInnerHTML={{ __html: page.content }}
                            style={{
                                lineHeight: '1.8',
                                fontSize: '1.1rem'
                            }}
                        />
                    </div>
                </div>
            </section>

            {/* Contact Section */}
            <section className={`${isDark ? 'bg-gray-800' : 'bg-white'}`}>
                <div className=" mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <div className={`p-8 rounded-xl ${isDark ? 'bg-gray-700' : 'bg-gray-50'}`}>
                        <h3 className={`text-2xl font-bold mb-4 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                            Questions About This Policy?
                        </h3>
                        <p className={`text-lg mb-6 ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                            If you have any questions or concerns about this policy, please don't hesitate to contact us.
                        </p>
                        <Link
                            to="/contact"
                            className="inline-block bg-brand-orange-500 hover:bg-brand-orange-600 text-white font-medium py-3 px-8 rounded-lg transition-colors duration-200"
                        >
                            <i className="fas fa-envelope mr-2"></i>
                            Contact Us
                        </Link>
                    </div>
                </div>
            </section>

            {/* Navigation Section */}
            <section className={`py-8 border-t ${isDark ? 'bg-gray-900 border-gray-700' : 'bg-gray-50 border-gray-200'}`}>
                <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex flex-wrap justify-center gap-4">
                        <Link
                            to="/privacy-policy"
                            className={`px-4 py-2 rounded-lg transition-colors duration-200 ${
                                pageType === 'privacy-policy'
                                    ? 'bg-brand-orange-500 text-white'
                                    : isDark
                                        ? 'bg-gray-800 text-gray-300 hover:bg-gray-700'
                                        : 'bg-white text-gray-700 hover:bg-gray-100'
                            }`}
                        >
                            Privacy Policy
                        </Link>
                        <Link
                            to="/terms-of-service"
                            className={`px-4 py-2 rounded-lg transition-colors duration-200 ${
                                pageType === 'terms-of-service'
                                    ? 'bg-brand-orange-500 text-white'
                                    : isDark
                                        ? 'bg-gray-800 text-gray-300 hover:bg-gray-700'
                                        : 'bg-white text-gray-700 hover:bg-gray-100'
                            }`}
                        >
                            Terms of Service
                        </Link>
                        <Link
                            to="/cookies-policy"
                            className={`px-4 py-2 rounded-lg transition-colors duration-200 ${
                                pageType === 'cookies-policy'
                                    ? 'bg-brand-orange-500 text-white'
                                    : isDark
                                        ? 'bg-gray-800 text-gray-300 hover:bg-gray-700'
                                        : 'bg-white text-gray-700 hover:bg-gray-100'
                            }`}
                        >
                            Cookies Policy
                        </Link>
                    </div>
                </div>
            </section>

            <style jsx>{`
                .legal-content h1,
                .legal-content h2,
                .legal-content h3,
                .legal-content h4,
                .legal-content h5,
                .legal-content h6 {
                    color: ${isDark ? '#ffffff' : '#1f2937'};
                    font-weight: 600;
                    margin-top: 2rem;
                    margin-bottom: 1rem;
                }

                .legal-content h1 { font-size: 2.25rem; }
                .legal-content h2 { font-size: 1.875rem; }
                .legal-content h3 { font-size: 1.5rem; }
                .legal-content h4 { font-size: 1.25rem; }
                .legal-content h5 { font-size: 1.125rem; }
                .legal-content h6 { font-size: 1rem; }

                .legal-content p {
                    margin-bottom: 1.5rem;
                    line-height: 1.8;
                }

                .legal-content ul,
                .legal-content ol {
                    margin: 1.5rem 0;
                    padding-left: 2rem;
                }

                .legal-content li {
                    margin-bottom: 0.75rem;
                    line-height: 1.7;
                }

                .legal-content strong {
                    font-weight: 600;
                    color: ${isDark ? '#f9fafb' : '#111827'};
                }

                .legal-content a {
                    color: #ea580c;
                    text-decoration: underline;
                    transition: color 0.2s;
                }

                .legal-content a:hover {
                    color: #c2410c;
                }

                .legal-content blockquote {
                    border-left: 4px solid #ea580c;
                    padding-left: 1.5rem;
                    margin: 1.5rem 0;
                    font-style: italic;
                    background: ${isDark ? '#374151' : '#f9fafb'};
                    padding: 1rem 1.5rem;
                    border-radius: 0.5rem;
                }
            `}</style>
        </div>
    );
};

export default LegalPage;
