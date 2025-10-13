import { useState, useEffect } from 'react';
import { Swiper, SwiperSlide } from 'swiper/react';
import { Navigation, Pagination, Autoplay, EffectFade } from 'swiper/modules';
import { Link } from 'react-router-dom';
import { useTheme } from '../../contexts/ThemeContext';

// Import Swiper styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/effect-fade';

function HeroSlider() {
    const { isDark } = useTheme();
    const [sliders, setSliders] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [isVisible, setIsVisible] = useState({});

    useEffect(() => {
        const fetchSliders = async () => {
            try {
                setLoading(true);
                setError(null);

                const response = await fetch('/api/hero-sliders');
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                if (data.success) {
                    setSliders(data.data);
                } else {
                    throw new Error(data.message || 'Failed to fetch slider data');
                }
            } catch (err) {
                console.error('Error fetching slider data:', err);
                setError(err.message);
            } finally {
                setLoading(false);
            }
        };

        fetchSliders();
    }, []);

    if (loading) {
        return (
            <section className={`w-full h-screen flex items-center justify-center ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                <div className="text-center">
                    <div className="animate-spin rounded-full h-32 w-32 border-b-2 border-brand-orange-500 mx-auto"></div>
                </div>
            </section>
        );
    }    if (error || !sliders || sliders.length === 0) {
        // Fallback content if API fails or no sliders
        return (
            <section className={`w-full h-screen flex items-center justify-center ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                <div className="container-minimal">
                    <div className="text-center max-w-4xl mx-auto">
                        <div className="mb-8">
                            <div className={`inline-flex items-center px-4 py-2 rounded-full text-sm font-medium ${
                                isDark ? 'bg-gray-800 text-gray-300' : 'bg-gray-100 text-gray-600'
                            }`}>
                                <div className="w-2 h-2 rounded-full bg-gray-400 mr-2"></div>
                                Movie Distribution
                            </div>
                        </div>

                        <div className="mb-12">
                            <h1 className={`text-4xl md:text-6xl lg:text-7xl font-bold mb-8 leading-tight text-minimal-bold ${
                                isDark ? 'text-white' : 'text-gray-900'
                            }`}>
                                Premium Movie Distribution
                            </h1>
                            <p className={`text-xl md:text-2xl mb-10 leading-relaxed text-minimal ${
                                isDark ? 'text-gray-300' : 'text-gray-600'
                            }`}>
                                We acquire and distribute exceptional films to worldwide audiences through cutting-edge digital platforms and traditional distribution channels.
                            </p>
                        </div>

                        <div className="flex flex-col sm:flex-row gap-4 justify-center items-center">
                            <Link
                                to="/contact"
                                className="btn-minimal"
                            >
                                Get Started
                            </Link>
                            <Link
                                to="/portfolio"
                                className="btn-minimal-outline"
                            >
                                View Films
                            </Link>
                        </div>
                    </div>
                </div>
            </section>
        );
    }

    return (
        <section className="w-full h-screen relative overflow-hidden z-0">
            <Swiper
                modules={[Navigation, Pagination, Autoplay, EffectFade]}
                spaceBetween={0}
                slidesPerView={1}
                navigation={sliders.length > 1}
                pagination={{
                    clickable: true,
                    dynamicBullets: false,
                }}
                autoplay={sliders.length > 1 ? {
                    delay: 5000,
                    disableOnInteraction: false,
                } : false}
                effect="fade"
                fadeEffect={{
                    crossFade: true
                }}
                loop={sliders.length > 1}
                className="w-full h-full hero-slider"
            >
                {sliders.map((slider, index) => (
                    <SwiperSlide key={slider.id || index} className="w-full h-screen">
                        <div className="relative w-full h-full min-h-screen">
                            {/* Background Image */}
                            {slider.image ? (
                                <div
                                    className="absolute inset-0 bg-cover bg-center bg-no-repeat w-full h-full"
                                    style={{
                                        backgroundImage: `url(${slider.image.startsWith('http') ? slider.image : `/storage/${slider.image}`})`,
                                        backgroundSize: 'cover',
                                        backgroundPosition: 'center center',
                                        backgroundRepeat: 'no-repeat'
                                    }}
                                />
                            ) : (
                                <div className="absolute inset-0 bg-gradient-to-br from-brand-orange-500 to-brand-orange-700"></div>
                            )}

                            {/* Dark Overlay for better text visibility */}
                            <div className="absolute inset-0 bg-gradient-to-b from-black/40 via-black/60 to-black/80"></div>

                            {/* Content */}
                            <div className="relative z-10 w-full h-full flex items-center justify-center pt-20">
                                <div className="container-minimal">
                                    <div className="text-center max-w-4xl mx-auto text-white">
                                        {/* Subtitle */}
                                        {slider.subtitle && (
                                            <div className="mb-8">
                                                <div className="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-white bg-opacity-90 backdrop-blur-sm text-black">
                                                    <div className="w-2 h-2 rounded-full bg-black mr-2"></div>
                                                    {slider.subtitle}
                                                </div>
                                            </div>
                                        )}

                                        {/* Title */}
                                        <div className="mb-12">
                                            <h1 className="text-4xl md:text-6xl lg:text-7xl font-bold mb-8 leading-tight text-minimal-bold">
                                                {slider.title}
                                            </h1>
                                            {slider.description && (
                                                <div
                                                    className="text-xl md:text-2xl mb-10 leading-relaxed text-minimal opacity-90"
                                                    dangerouslySetInnerHTML={{ __html: slider.description }}
                                                />
                                            )}
                                        </div>

                                        {/* CTA Buttons */}
                                        {(slider.button_text || slider.button_text_secondary) && (
                                            <div className="flex flex-col sm:flex-row gap-4 justify-center items-center">
                                                {slider.button_text && slider.button_url && (
                                                    <Link
                                                        to={slider.button_url}
                                                        className="btn-minimal bg-white text-gray-900 hover:bg-gray-100"
                                                    >
                                                        {slider.button_text}
                                                    </Link>
                                                )}
                                                {slider.button_text_secondary && slider.button_url_secondary && (
                                                    <Link
                                                        to={slider.button_url_secondary}
                                                        className="btn-minimal-outline border-white text-white hover:bg-white hover:text-gray-900"
                                                    >
                                                        {slider.button_text_secondary}
                                                    </Link>
                                                )}
                                            </div>
                                        )}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </SwiperSlide>
                ))}
            </Swiper>
        </section>
    );
}

export default HeroSlider;
