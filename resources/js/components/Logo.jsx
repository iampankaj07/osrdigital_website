import { useState, useEffect } from 'react';

function Logo({ type = 'seeklogo', className = '', width = 'auto', height = '40' }) {
    const [logoUrl, setLogoUrl] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const fetchLogo = async () => {
            try {
                const response = await fetch(`/api/logo/${type}`);
                if (response.ok) {
                    const data = await response.json();
                    setLogoUrl(data.url);
                }
            } catch (error) {
                console.error('Failed to fetch logo:', error);
            } finally {
                setLoading(false);
            }
        };

        fetchLogo();
    }, [type]);

    if (loading) {
        return (
            <div
                className={`bg-gray-700 animate-pulse rounded ${className}`}
                style={{ width: width === 'auto' ? '120px' : width, height }}
            />
        );
    }

    if (!logoUrl) {
        return (
            <div
                className={`bg-gradient-to-r from-orange-500 to-red-600 rounded flex items-center justify-center ${className}`}
                style={{ width: width === 'auto' ? '40px' : width, height }}
            >
                <span className="text-white font-bold text-lg">OSR</span>
            </div>
        );
    }

    return (
        <img
            src={logoUrl}
            alt="OSR Digital Logo"
            className={`object-contain ${className}`}
            style={{ width, height, maxHeight: height }}
            onError={() => setLogoUrl(null)}
        />
    );
}

export default Logo;
