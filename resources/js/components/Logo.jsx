import { useState } from 'react';

function Logo({ type = 'seeklogo', className = '', width = 'auto', height = '40' }) {
    const [imageError, setImageError] = useState(false);

    // Use static logo file for better cloud deployment reliability
    const logoUrl = '/images/logo.png';

    const handleImageError = () => {
        setImageError(true);
    };

    if (imageError) {
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
            onError={handleImageError}
        />
    );
}

export default Logo;
