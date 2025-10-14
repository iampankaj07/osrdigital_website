import React, { useState } from 'react';

function Logo({ type = 'seeklogo', className = '', width = 'auto', height = '40' }) {
    const [imageError, setImageError] = useState(false);

    // Get site logo from window.siteSettings or fallback to static logo
    const siteLogo = window.siteSettings?.site_logo;
    const logoUrl = siteLogo || '/images/logo.png';

    const handleImageError = () => {
        setImageError(true);
    };

    // Convert height to number for calculations
    const heightNum = typeof height === 'string' ? parseInt(height) : height;
    const widthNum = width === 'auto' ? heightNum * 2.5 : (typeof width === 'string' ? parseInt(width) : width);

    if (imageError) {
        return (
            <div
                className={`bg-gradient-to-r from-brand-orange-500 to-red-600 rounded flex items-center justify-center ${className}`}
                style={{
                    width: widthNum,
                    height: heightNum,
                    minWidth: '80px',
                    minHeight: '32px'
                }}
            >
                <span className="text-white font-bold text-sm">OSR</span>
            </div>
        );
    }

    return (
        <img
            src={logoUrl}
            alt="OSR Digital Logo"
            className={`object-contain ${className}`}
            style={{
                width: widthNum,
                height: heightNum,
                maxHeight: heightNum,
                maxWidth: widthNum,
                minWidth: '80px',
                minHeight: '32px'
            }}
            onError={handleImageError}
        />
    );
}

export default Logo;
