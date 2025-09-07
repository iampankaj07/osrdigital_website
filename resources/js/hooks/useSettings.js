import { useState, useEffect } from 'react';

// Custom hook for fetching settings
export const useSettings = (group = null) => {
    const [settings, setSettings] = useState({});
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchSettings = async () => {
            try {
                setLoading(true);
                setError(null);

                let url = '/api/settings';
                if (group) {
                    url += `/group/${group}`;
                } else {
                    url += '/flat';
                }

                const response = await fetch(url);

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const result = await response.json();

                if (result.success) {
                    setSettings(result.data);
                } else {
                    throw new Error(result.message || 'Failed to fetch settings');
                }
            } catch (err) {
                console.error('Error fetching settings:', err);
                setError(err.message);
                // Set fallback settings to prevent component errors
                setSettings({});
            } finally {
                setLoading(false);
            }
        };

        fetchSettings();
    }, [group]);

    // Helper function to get a setting value with fallback
    const getSetting = (key, fallback = '') => {
        return settings[key] || fallback;
    };

    // Helper function to get settings by prefix
    const getSettingsByPrefix = (prefix) => {
        return Object.keys(settings)
            .filter(key => key.startsWith(prefix))
            .reduce((result, key) => {
                result[key] = settings[key];
                return result;
            }, {});
    };

    return {
        settings,
        loading,
        error,
        getSetting,
        getSettingsByPrefix,
        refetch: () => {
            setLoading(true);
            // Re-trigger the useEffect
            setSettings({});
        }
    };
};

// Hook specifically for hero section settings
export const useHeroSettings = () => {
    return useSettings('hero');
};

// Hook specifically for stats section settings
export const useStatsSettings = () => {
    return useSettings('stats');
};

// Hook specifically for CTA section settings
export const useCTASettings = () => {
    return useSettings('cta');
};

// Hook specifically for branding settings
export const useBrandingSettings = () => {
    return useSettings('branding');
};

// Hook for all public settings (flat structure)
export const useAllSettings = () => {
    return useSettings();
};
