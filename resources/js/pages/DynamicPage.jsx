import React from 'react';
import { useState, useEffect } from 'react';
import { useParams } from 'react-router-dom';
import { useTheme } from '../contexts/ThemeContext';
import DynamicContentRenderer from '../components/DynamicContentRenderer';

function DynamicPage() {
    const { slug } = useParams();
    const { isDark } = useTheme();
    const [pageData, setPageData] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchPageData = async () => {
            try {
                setLoading(true);
                setError(null);
                
                const response = await fetch(`/api/dynamic-page/${slug}`);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                setPageData(data);
                
                // Update document title and meta tags
                if (data.meta_title) {
                    document.title = data.meta_title.includes('OSR Digital') ? data.meta_title : `${data.meta_title} - OSR Digital`;
                } else if (data.title) {
                    document.title = `${data.title} - OSR Digital`;
                }

                if (data.meta_description) {
                    let metaDescription = document.querySelector('meta[name="description"]');
                    if (metaDescription) {
                        metaDescription.setAttribute('content', data.meta_description);
                    } else {
                        metaDescription = document.createElement('meta');
                        metaDescription.name = 'description';
                        metaDescription.content = data.meta_description;
                        document.getElementsByTagName('head')[0].appendChild(metaDescription);
                    }
                }
            } catch (err) {
                console.error('Error fetching page data:', err);
                setError(err.message);
            } finally {
                setLoading(false);
            }
        };

        if (slug) {
            fetchPageData();
        }
    }, [slug]);

    if (loading) {
        return (
            <div className="min-h-screen flex items-center justify-center">
                <div className="animate-spin rounded-full h-32 w-32 border-b-2 border-orange-500"></div>
            </div>
        );
    }

    if (error) {
        return (
            <div className="min-h-screen flex items-center justify-center">
                <div className="text-center">
                    <h2 className="text-2xl font-bold text-red-600 mb-4">Error Loading Page</h2>
                    <p className="text-gray-600">{error}</p>
                </div>
            </div>
        );
    }

    if (!pageData) {
        return (
            <div className="min-h-screen flex items-center justify-center">
                <div className="text-center">
                    <h2 className="text-2xl font-bold text-gray-600 mb-4">Page Not Found</h2>
                    <p className="text-gray-500">The page you're looking for doesn't exist.</p>
                </div>
            </div>
        );
    }

    return (
        <div className={`min-h-screen transition-colors duration-300 ${
            isDark ? 'bg-gray-900' : 'bg-white'
        }`}>
            <DynamicContentRenderer 
                contentBlocks={pageData.content_blocks || []}
                pageSettings={pageData.settings || {}}
                template={pageData.template || 'default'}
            />
        </div>
    );
}

export default DynamicPage;
