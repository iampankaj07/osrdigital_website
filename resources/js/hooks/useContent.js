import { useState, useEffect, useCallback } from 'react';

/**
 * Unified content management hook
 * Provides all site content through a single API call
 */
export function useContent() {
    const [content, setContent] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    const fetchContent = useCallback(async () => {
        try {
            setLoading(true);
            setError(null);
            
            const response = await fetch('/api/content');
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            setContent(data);
        } catch (err) {
            console.error('Error fetching content:', err);
            setError(err.message);
        } finally {
            setLoading(false);
        }
    }, []);

    useEffect(() => {
        fetchContent();
    }, [fetchContent]);

    const getContent = useCallback((key, defaultValue = null) => {
        if (!content) return defaultValue;
        
        // Try content blocks first
        if (content.content_blocks) {
            for (const group of Object.values(content.content_blocks)) {
                const block = group.find(item => item.key === key);
                if (block) return block.content;
            }
        }
        
        // Try site config
        if (content.site_config && content.site_config[key] !== undefined) {
            return content.site_config[key];
        }
        
        return defaultValue;
    }, [content]);

    const getContentGroup = useCallback((groupName, defaultValue = []) => {
        if (!content?.content_blocks?.[groupName]) return defaultValue;
        return content.content_blocks[groupName];
    }, [content]);

    const getPage = useCallback((slug) => {
        if (!content?.pages) return null;
        return content.pages.find(page => page.slug === slug) || null;
    }, [content]);

    const refreshContent = useCallback(() => {
        fetchContent();
    }, [fetchContent]);

    return {
        content,
        loading,
        error,
        getContent,
        getContentGroup,
        getPage,
        refreshContent,
    };
}

/**
 * Hook for specific content types
 */
export function usePageContent(slug) {
    const { content, loading, error, getPage } = useContent();
    const [pageData, setPageData] = useState(null);

    useEffect(() => {
        if (content && slug) {
            const page = getPage(slug);
            setPageData(page);
        }
    }, [content, slug, getPage]);

    return {
        pageData,
        loading,
        error,
    };
}

/**
 * Hook for content blocks by group
 */
export function useContentGroup(groupName, defaultValue = []) {
    const { content, loading, error, getContentGroup } = useContent();
    const [groupContent, setGroupContent] = useState(defaultValue);

    useEffect(() => {
        if (content) {
            const group = getContentGroup(groupName, defaultValue);
            setGroupContent(group);
        }
    }, [content, groupName, defaultValue, getContentGroup]);

    return {
        content: groupContent,
        loading,
        error,
    };
}

/**
 * Hook for specific content by key
 */
export function useContentByKey(key, defaultValue = null) {
    const { content, loading, error, getContent } = useContent();
    const [value, setValue] = useState(defaultValue);

    useEffect(() => {
        if (content) {
            const contentValue = getContent(key, defaultValue);
            setValue(contentValue);
        }
    }, [content, key, defaultValue, getContent]);

    return {
        value,
        loading,
        error,
    };
}

/**
 * Legacy hook for backward compatibility
 */
export function useAllSettings() {
    const { content, loading, error, getContent } = useContent();
    const [settings, setSettings] = useState({});

    useEffect(() => {
        if (content) {
            const settingsData = {
                ...content.site_config,
                ...content.content_blocks,
            };
            setSettings(settingsData);
        }
    }, [content]);

    const getSetting = useCallback((key, defaultValue = null) => {
        return settings[key] || defaultValue;
    }, [settings]);

    return {
        settings,
        loading,
        error,
        getSetting,
    };
}

/**
 * Hook for business settings (legacy compatibility)
 */
export function useBusinessSettings() {
    const { content, loading, error, getContent } = useContent();

    const getSetting = useCallback((key, defaultValue = null) => {
        if (!content) return defaultValue;
        
        // Try content blocks first
        if (content.content_blocks) {
            for (const group of Object.values(content.content_blocks)) {
                const block = group.find(item => item.key === key);
                if (block) return block.content;
            }
        }
        
        // Try site config
        if (content.site_config && content.site_config[key] !== undefined) {
            return content.site_config[key];
        }
        
        return defaultValue;
    }, [content]);

    return {
        getSetting,
        loading,
        error,
    };
}
