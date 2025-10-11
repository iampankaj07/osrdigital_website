/**
 * Enhanced Image Utilities for Dynamic Image Handling
 * Handles image URLs, placeholders, and responsive images
 */

/**
 * Check if URL is a placeholder
 * @param {string} url - URL to check
 * @returns {boolean} - True if placeholder
 */
export const isPlaceholderImage = (url) => {
    if (!url) return true;
    
    const placeholderDomains = [
        'via.placeholder.com',
        'ui-avatars.com',
        'picsum.photos',
        'placeholder.com',
        'placehold.co',
        'via.placeholder.com',
    ];

    return placeholderDomains.some(domain => url.includes(domain));
};

/**
 * Get placeholder image URL
 * @param {string} text - Text for placeholder
 * @param {number} width - Image width
 * @param {number} height - Image height
 * @param {string} bgColor - Background color (hex)
 * @param {string} textColor - Text color (hex)
 * @returns {string} - Placeholder URL
 */
export const getPlaceholderImage = (text = 'Image', width = 400, height = 300, bgColor = '6366f1', textColor = 'ffffff') => {
    return `https://via.placeholder.com/${width}x${height}/${bgColor}/${textColor}?text=${encodeURIComponent(text)}`;
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

/**
 * Get responsive image URLs for different screen sizes
 * @param {string} baseUrl - Base image URL
 * @param {Object} sizes - Object with breakpoint sizes
 * @returns {Object} - Object with responsive URLs
 */
export const getResponsiveImageUrls = (baseUrl, sizes = {
    sm: 400,
    md: 600,
    lg: 800,
    xl: 1200
}) => {
    const urls = {};
    
    Object.entries(sizes).forEach(([breakpoint, size]) => {
        if (isPlaceholderImage(baseUrl)) {
            urls[breakpoint] = getPlaceholderImage('Image', size, size);
        } else {
            urls[breakpoint] = baseUrl;
        }
    });
    
    return urls;
};

/**
 * Get contextual image based on context
 * @param {string} url - Image URL
 * @param {string} context - Context (avatar, thumbnail, hero, card, logo, banner)
 * @param {Object} options - Additional options
 * @returns {string} - Contextual image URL
 */
export const getContextualImage = (url, context = 'default', options = {}) => {
    const contextConfigs = {
        avatar: { width: 100, height: 100, text: 'Avatar' },
        thumbnail: { width: 300, height: 200, text: 'Thumbnail' },
        hero: { width: 1200, height: 600, text: 'Hero Image' },
        card: { width: 400, height: 300, text: 'Card Image' },
        logo: { width: 200, height: 100, text: 'Logo' },
        banner: { width: 800, height: 400, text: 'Banner' },
        default: { width: 400, height: 300, text: 'Image' }
    };

    const config = contextConfigs[context] || contextConfigs.default;
    const width = options.width || config.width;
    const height = options.height || config.height;
    const text = options.text || config.text;

    return getSafeImageUrl(url, text, width, height);
};

/**
 * Preload image for better performance
 * @param {string} url - Image URL to preload
 * @returns {Promise} - Promise that resolves when image is loaded
 */
export const preloadImage = (url) => {
    return new Promise((resolve, reject) => {
        const img = new Image();
        img.onload = () => resolve(img);
        img.onerror = () => reject(new Error(`Failed to load image: ${url}`));
        img.src = url;
    });
};

/**
 * Preload multiple images
 * @param {string[]} urls - Array of image URLs
 * @returns {Promise} - Promise that resolves when all images are loaded
 */
export const preloadImages = (urls) => {
    return Promise.all(urls.map(url => preloadImage(url)));
};

/**
 * Get image dimensions from URL
 * @param {string} url - Image URL
 * @returns {Promise<Object>} - Promise with width and height
 */
export const getImageDimensions = (url) => {
    return new Promise((resolve, reject) => {
        const img = new Image();
        img.onload = () => resolve({ width: img.naturalWidth, height: img.naturalHeight });
        img.onerror = () => reject(new Error(`Failed to load image: ${url}`));
        img.src = url;
    });
};

/**
 * Create a lazy loading image element
 * @param {string} src - Image source
 * @param {string} alt - Alt text
 * @param {Object} options - Additional options
 * @returns {HTMLElement} - Image element with lazy loading
 */
export const createLazyImage = (src, alt = '', options = {}) => {
    const img = document.createElement('img');
    img.src = getPlaceholderImage('Loading...', options.width || 400, options.height || 300);
    img.alt = alt;
    img.loading = 'lazy';
    img.className = options.className || '';
    
    // Use Intersection Observer for lazy loading
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                img.src = getSafeImageUrl(src, alt, options.width || 400, options.height || 300);
                observer.unobserve(img);
            }
        });
    });
    
    observer.observe(img);
    
    return img;
};

/**
 * Convert file to data URL
 * @param {File} file - File object
 * @returns {Promise<string>} - Data URL
 */
export const fileToDataUrl = (file) => {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = () => resolve(reader.result);
        reader.onerror = () => reject(new Error('Failed to read file'));
        reader.readAsDataURL(file);
    });
};

/**
 * Resize image file
 * @param {File} file - Image file
 * @param {number} maxWidth - Maximum width
 * @param {number} maxHeight - Maximum height
 * @param {number} quality - Image quality (0-1)
 * @returns {Promise<File>} - Resized file
 */
export const resizeImageFile = (file, maxWidth = 800, maxHeight = 600, quality = 0.8) => {
    return new Promise((resolve, reject) => {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        const img = new Image();
        
        img.onload = () => {
            // Calculate new dimensions
            let { width, height } = img;
            
            if (width > height) {
                if (width > maxWidth) {
                    height = (height * maxWidth) / width;
                    width = maxWidth;
                }
            } else {
                if (height > maxHeight) {
                    width = (width * maxHeight) / height;
                    height = maxHeight;
                }
            }
            
            canvas.width = width;
            canvas.height = height;
            
            // Draw and compress
            ctx.drawImage(img, 0, 0, width, height);
            canvas.toBlob((blob) => {
                const resizedFile = new File([blob], file.name, {
                    type: file.type,
                    lastModified: Date.now()
                });
                resolve(resizedFile);
            }, file.type, quality);
        };
        
        img.onerror = () => reject(new Error('Failed to load image'));
        img.src = URL.createObjectURL(file);
    });
};

/**
 * Validate image file
 * @param {File} file - File to validate
 * @param {Object} options - Validation options
 * @returns {Object} - Validation result
 */
export const validateImageFile = (file, options = {}) => {
    const {
        maxSize = 2 * 1024 * 1024, // 2MB
        allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
        maxWidth = 4000,
        maxHeight = 4000
    } = options;
    
    const errors = [];
    
    // Check file size
    if (file.size > maxSize) {
        errors.push(`File size must be less than ${Math.round(maxSize / 1024 / 1024)}MB`);
    }
    
    // Check file type
    if (!allowedTypes.includes(file.type)) {
        errors.push(`File type must be one of: ${allowedTypes.join(', ')}`);
    }
    
    return {
        isValid: errors.length === 0,
        errors
    };
};

// Export all functions as default object
export default {
    isPlaceholderImage,
    getPlaceholderImage,
    getSafeImageUrl,
    getResponsiveImageUrls,
    getContextualImage,
    preloadImage,
    preloadImages,
    getImageDimensions,
    createLazyImage,
    fileToDataUrl,
    resizeImageFile,
    validateImageFile
};