/**
 * Utility functions for handling images and fallbacks
 */

/**
 * Get initials from a name
 * @param {string} name - The name to extract initials from
 * @returns {string} - The initials (max 2 characters)
 */
export const getInitials = (name) => {
    if (!name) return '??';
    
    const words = name.trim().split(' ');
    let initials = '';
    
    for (const word of words) {
        if (word.length > 0) {
            initials += word[0].toUpperCase();
        }
    }
    
    return initials.substring(0, 2);
};

/**
 * Generate a placeholder image URL
 * @param {string} text - Text to display on placeholder
 * @param {number} width - Image width
 * @param {number} height - Image height
 * @param {string} bgColor - Background color (hex without #)
 * @param {string} textColor - Text color (hex without #)
 * @returns {string} - Placeholder image URL
 */
export const getPlaceholderImage = (text, width = 400, height = 300, bgColor = 'EC681D', textColor = 'FFFFFF') => {
    const encodedText = encodeURIComponent(text);
    return `https://via.placeholder.com/${width}x${height}/${bgColor}/${textColor}?text=${encodedText}`;
};

/**
 * Generate a placeholder avatar URL
 * @param {string} name - Name to generate avatar for
 * @param {number} size - Avatar size
 * @returns {string} - Placeholder avatar URL
 */
export const getPlaceholderAvatar = (name, size = 64) => {
    const initials = getInitials(name);
    return `https://ui-avatars.com/api/?name=${encodeURIComponent(initials)}&background=ec681b&color=fff&size=${size}`;
};

/**
 * Handle image load error by replacing with placeholder
 * @param {Event} event - The error event
 * @param {string} fallbackText - Text for placeholder
 * @param {number} width - Image width
 * @param {number} height - Image height
 */
export const handleImageError = (event, fallbackText = 'Image', width = 400, height = 300) => {
    const img = event.target;
    img.src = getPlaceholderImage(fallbackText, width, height);
    img.alt = `Placeholder for ${fallbackText}`;
};

/**
 * Handle avatar load error by replacing with placeholder
 * @param {Event} event - The error event
 * @param {string} name - Name for avatar placeholder
 * @param {number} size - Avatar size
 */
export const handleAvatarError = (event, name = 'User', size = 64) => {
    const img = event.target;
    img.src = getPlaceholderAvatar(name, size);
    img.alt = `Avatar for ${name}`;
};

/**
 * Check if an image URL is a placeholder
 * @param {string} url - Image URL to check
 * @returns {boolean} - True if it's a placeholder
 */
export const isPlaceholderImage = (url) => {
    return url && (
        url.includes('via.placeholder.com') ||
        url.includes('ui-avatars.com') ||
        url.includes('placeholder')
    );
};

/**
 * Get a safe image URL with fallback
 * @param {string} url - Original image URL
 * @param {string} fallbackText - Text for fallback placeholder
 * @param {number} width - Image width
 * @param {number} height - Image height
 * @returns {string} - Safe image URL
 */
export const getSafeImageUrl = (url, fallbackText = 'Image', width = 400, height = 300) => {
    if (!url || url.trim() === '') {
        return getPlaceholderImage(fallbackText, width, height);
    }
    
    // If it's already a placeholder, return as is
    if (isPlaceholderImage(url)) {
        return url;
    }
    
    return url;
};

