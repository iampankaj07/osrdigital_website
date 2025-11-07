import React, { useEffect, useRef } from 'react';
import { useTheme } from '../../contexts/ThemeContext';

function GoogleMap() {
    const { isDark } = useTheme();
    const mapContainer = useRef(null);
    const map = useRef(null);

    useEffect(() => {
        // Check if Google Maps API is loaded
        if (!window.google || !window.google.maps) {
            console.warn('Google Maps API not loaded');
            return;
        }

        if (mapContainer.current && !map.current) {
            // Default coordinates (can be customized per location)
            const defaultLocation = {
                lat: 40.7128,
                lng: -74.0060
            };

            // Map styling for dark mode
            const mapStyles = isDark ? [
                { elementType: 'geometry', stylers: [{ color: '#242f3e' }] },
                { elementType: 'labels.text.stroke', stylers: [{ color: '#242f3e' }] },
                { elementType: 'labels.text.fill', stylers: [{ color: '#746855' }] },
                {
                    featureType: 'administrative.locality',
                    elementType: 'labels.text.fill',
                    stylers: [{ color: '#d59563' }]
                },
                {
                    featureType: 'poi',
                    elementType: 'labels.text.fill',
                    stylers: [{ color: '#d59563' }]
                },
                {
                    featureType: 'poi.park',
                    elementType: 'geometry',
                    stylers: [{ color: '#263c3f' }]
                },
                {
                    featureType: 'poi.park',
                    elementType: 'labels.text.fill',
                    stylers: [{ color: '#6f9ba5' }]
                },
                {
                    featureType: 'road',
                    elementType: 'geometry',
                    stylers: [{ color: '#38414e' }]
                },
                {
                    featureType: 'road',
                    elementType: 'geometry.stroke',
                    stylers: [{ color: '#212a37' }]
                },
                {
                    featureType: 'road',
                    elementType: 'labels.text.fill',
                    stylers: [{ color: '#9ca5b3' }]
                },
                {
                    featureType: 'road.highway',
                    elementType: 'geometry',
                    stylers: [{ color: '#746855' }]
                },
                {
                    featureType: 'road.highway',
                    elementType: 'geometry.stroke',
                    stylers: [{ color: '#1f2835' }]
                },
                {
                    featureType: 'road.highway',
                    elementType: 'labels.text.fill',
                    stylers: [{ color: '#f3751ff' }]
                },
                {
                    featureType: 'transit',
                    elementType: 'geometry',
                    stylers: [{ color: '#2f3948' }]
                },
                {
                    featureType: 'transit.station',
                    elementType: 'labels.text.fill',
                    stylers: [{ color: '#d59563' }]
                },
                {
                    featureType: 'water',
                    elementType: 'geometry',
                    stylers: [{ color: '#17263c' }]
                },
                {
                    featureType: 'water',
                    elementType: 'labels.text.fill',
                    stylers: [{ color: '#515c6d' }]
                },
                {
                    featureType: 'water',
                    elementType: 'labels.text.stroke',
                    stylers: [{ color: '#17263c' }]
                }
            ] : [];

            map.current = new window.google.maps.Map(mapContainer.current, {
                zoom: 12,
                center: defaultLocation,
                styles: mapStyles,
                disableDefaultUI: false,
                zoomControl: true,
                mapTypeControl: true,
                scaleControl: true,
                streetViewControl: true,
                rotateControl: true,
                fullscreenControl: true,
            });

            // Add marker
            new window.google.maps.Marker({
                position: defaultLocation,
                map: map.current,
                title: 'Our Location',
                icon: {
                    path: window.google.maps.SymbolPath.CIRCLE,
                    scale: 8,
                    fillColor: '#EA7317',
                    fillOpacity: 1,
                    strokeColor: '#fff',
                    strokeWeight: 2,
                }
            });
        }

        // Cleanup on unmount
        return () => {
            if (map.current) {
                map.current = null;
            }
        };
    }, [isDark]);

    return (
        <div className="w-full h-96 rounded-lg overflow-hidden shadow-lg">
            <div
                ref={mapContainer}
                className="w-full h-full"
            />
        </div>
    );
}

export default GoogleMap;
