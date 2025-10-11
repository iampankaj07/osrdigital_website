import React, { useState, useEffect, useRef } from 'react';
import { getSafeImageUrl, getContextualImage, isPlaceholderImage, preloadImage } from '../../utils/imageUtils';

/**
 * DynamicImage Component
 * Handles image loading with fallbacks, lazy loading, and responsive behavior
 */
const DynamicImage = ({
    src,
    alt = '',
    className = '',
    context = 'default',
    width,
    height,
    fallbackText = 'Image',
    lazy = true,
    preload = false,
    onLoad,
    onError,
    placeholder = true,
    ...props
}) => {
    const [imageSrc, setImageSrc] = useState(null);
    const [isLoading, setIsLoading] = useState(true);
    const [hasError, setHasError] = useState(false);
    const [isInView, setIsInView] = useState(!lazy);
    const imgRef = useRef(null);
    const observerRef = useRef(null);

    // Generate image URL based on context
    const generateImageUrl = () => {
        if (!src) {
            return getContextualImage(null, context, { width, height, text: fallbackText });
        }

        if (isPlaceholderImage(src)) {
            return src;
        }

        return getSafeImageUrl(src, fallbackText, width, height);
    };

    // Handle image loading
    const handleImageLoad = () => {
        setIsLoading(false);
        setHasError(false);
        onLoad && onLoad();
    };

    // Handle image error
    const handleImageError = () => {
        setIsLoading(false);
        setHasError(true);
        setImageSrc(getContextualImage(null, context, { width, height, text: fallbackText }));
        onError && onError();
    };

    // Set up intersection observer for lazy loading
    useEffect(() => {
        if (!lazy || !imgRef.current) return;

        observerRef.current = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        setIsInView(true);
                        observerRef.current?.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.1 }
        );

        observerRef.current.observe(imgRef.current);

        return () => {
            observerRef.current?.disconnect();
        };
    }, [lazy]);

    // Load image when in view
    useEffect(() => {
        if (!isInView) return;

        const loadImage = async () => {
            try {
                const url = generateImageUrl();
                setImageSrc(url);

                if (preload) {
                    await preloadImage(url);
                }
            } catch (error) {
                console.error('Error loading image:', error);
                handleImageError();
            }
        };

        loadImage();
    }, [isInView, src, context, width, height, fallbackText]);

    // Cleanup
    useEffect(() => {
        return () => {
            observerRef.current?.disconnect();
        };
    }, []);

    return (
        <div
            ref={imgRef}
            className={`relative overflow-hidden ${className}`}
            style={{ width, height }}
            {...props}
        >
            {isLoading && placeholder && (
                <div className="absolute inset-0 bg-gray-200 animate-pulse flex items-center justify-center">
                    <div className="text-gray-400 text-sm">Loading...</div>
                </div>
            )}
            
            {imageSrc && (
                <img
                    src={imageSrc}
                    alt={alt}
                    className={`w-full h-full object-cover transition-opacity duration-300 ${
                        isLoading ? 'opacity-0' : 'opacity-100'
                    }`}
                    onLoad={handleImageLoad}
                    onError={handleImageError}
                    loading={lazy ? 'lazy' : 'eager'}
                />
            )}
            
            {hasError && (
                <div className="absolute inset-0 bg-gray-100 flex items-center justify-center">
                    <div className="text-gray-400 text-center">
                        <div className="text-2xl mb-2">📷</div>
                        <div className="text-sm">{fallbackText}</div>
                    </div>
                </div>
            )}
        </div>
    );
};

/**
 * ResponsiveImage Component
 * Handles responsive images with different sizes for different breakpoints
 */
export const ResponsiveImage = ({
    src,
    alt = '',
    className = '',
    sizes = {
        sm: 400,
        md: 600,
        lg: 800,
        xl: 1200
    },
    fallbackText = 'Image',
    ...props
}) => {
    const [currentSize, setCurrentSize] = useState('lg');
    const [imageSrc, setImageSrc] = useState(null);

    useEffect(() => {
        const handleResize = () => {
            const width = window.innerWidth;
            if (width < 640) setCurrentSize('sm');
            else if (width < 768) setCurrentSize('sm');
            else if (width < 1024) setCurrentSize('md');
            else if (width < 1280) setCurrentSize('lg');
            else setCurrentSize('xl');
        };

        handleResize();
        window.addEventListener('resize', handleResize);
        return () => window.removeEventListener('resize', handleResize);
    }, []);

    useEffect(() => {
        const size = sizes[currentSize] || sizes.lg;
        setImageSrc(getSafeImageUrl(src, fallbackText, size, size));
    }, [src, currentSize, sizes, fallbackText]);

    return (
        <DynamicImage
            src={imageSrc}
            alt={alt}
            className={className}
            width={sizes[currentSize]}
            height={sizes[currentSize]}
            fallbackText={fallbackText}
            {...props}
        />
    );
};

/**
 * AvatarImage Component
 * Specialized component for user avatars
 */
export const AvatarImage = ({
    src,
    alt = 'Avatar',
    size = 40,
    className = '',
    ...props
}) => {
    return (
        <DynamicImage
            src={src}
            alt={alt}
            context="avatar"
            width={size}
            height={size}
            fallbackText={alt.charAt(0).toUpperCase()}
            className={`rounded-full ${className}`}
            {...props}
        />
    );
};

/**
 * CardImage Component
 * Specialized component for card images
 */
export const CardImage = ({
    src,
    alt = 'Card Image',
    className = '',
    ...props
}) => {
    return (
        <DynamicImage
            src={src}
            alt={alt}
            context="card"
            width={400}
            height={300}
            fallbackText="Card Image"
            className={`rounded-lg ${className}`}
            {...props}
        />
    );
};

/**
 * HeroImage Component
 * Specialized component for hero/banner images
 */
export const HeroImage = ({
    src,
    alt = 'Hero Image',
    className = '',
    ...props
}) => {
    return (
        <DynamicImage
            src={src}
            alt={alt}
            context="hero"
            width={1200}
            height={600}
            fallbackText="Hero Image"
            className={`w-full h-full ${className}`}
            {...props}
        />
    );
};

export default DynamicImage;
export { ResponsiveImage, AvatarImage, CardImage, HeroImage };
