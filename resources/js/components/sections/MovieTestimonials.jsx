import { useState, useEffect } from 'react';
import { useTheme } from '../../contexts/ThemeContext';
import { getSafeImageUrl } from '../../utils/imageUtils';
import { Swiper, SwiperSlide } from 'swiper/react';
import { Autoplay, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';

function MovieTestimonials() {
    const { isDark } = useTheme();
    const [testimonials, setTestimonials] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchTestimonials = async () => {
            try {
                setLoading(true);
                setError(null);

                const response = await fetch('/api/testimonials/featured?limit=8');

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                if (data.success && data.data && data.data.length > 0) {
                    setTestimonials(data.data);
                } else {
                    setError('No testimonials available');
                    setTestimonials([]);
                }
            } catch (err) {
                setError(`Failed to load testimonials: ${err.message}`);
                setTestimonials([]);
            } finally {
                setLoading(false);
            }
        };

        fetchTestimonials();
    }, []);

    if (loading) {
        return (
            <section className={`section-minimal ${isDark ? 'bg-gray-900' : 'bg-gray-50'}`}>
                <div className="container-minimal">
                    <div className="text-center mb-16">
                        <div className={`h-10 w-80 mx-auto mb-6 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                        <div className={`h-6 w-96 mx-auto rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                    </div>

                    <div className={`p-12 rounded-xl ${isDark ? 'bg-gray-800' : 'bg-white'}`}>
                        <div className="flex items-start space-x-8">
                            <div className={`w-20 h-20 rounded-full ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast flex-shrink-0`}></div>
                            <div className="flex-1">
                                <div className={`h-6 w-3/4 mb-4 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                <div className={`h-4 w-full mb-3 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                <div className={`h-4 w-5/6 mb-3 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                <div className={`h-4 w-4/5 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        );
    }

    if (error) {
        return (
            <section className={`section-minimal ${isDark ? 'bg-gray-900' : 'bg-gray-50'}`}>
                <div className="container-minimal">
                    <div className="text-center mb-16">
                        <h2 className={`text-3xl md:text-4xl font-bold mb-6 text-minimal-bold ${
                            isDark ? 'text-white' : 'text-gray-900'
                        }`}>
                            What Our Partners Say
                        </h2>
                        <p className={`text-lg max-w-3xl mx-auto text-minimal ${
                            isDark ? 'text-gray-300' : 'text-gray-600'
                        }`}>
                            {error}
                        </p>
                    </div>
                </div>
            </section>
        );
    }

    return (
        <section className={`section-minimal ${isDark ? 'bg-gray-900' : 'bg-gray-50'}`}>
            <div className="container-minimal">
                {/* Header */}
                <div className="text-center mb-16">
                    <h2 className={`text-3xl md:text-4xl font-bold mb-6 text-minimal-bold ${
                        isDark ? 'text-white' : 'text-gray-900'
                    }`}>
                        What Our Partners Say
                    </h2>
                    <p className={`text-lg max-w-3xl mx-auto text-minimal ${
                        isDark ? 'text-gray-300' : 'text-gray-600'
                    }`}>
                        Hear from filmmakers, producers, and industry professionals who have
                        experienced the OSR Digital difference.
                    </p>
                </div>

                {/* Testimonials Swiper */}
                <div className={`relative px-0 md:px-12`}>
                    <Swiper
                        modules={[Autoplay, Pagination]}
                        slidesPerView={1}
                        pagination={{
                            clickable: true,
                            bulletClass: `swiper-bullet ${isDark ? 'bg-gray-600' : 'bg-gray-400'}`,
                            bulletActiveClass: `swiper-bullet-active ${isDark ? 'bg-brand-orange-500' : 'bg-brand-orange-600'}`,
                        }}
                        autoplay={{
                            delay: 5000,
                            disableOnInteraction: false,
                        }}
                        loop={true}
                        speed={800}
                        className="w-full"
                    >
                        {testimonials.map((testimonial) => (
                            <SwiperSlide key={testimonial.id}>
                                <div className="flex justify-center px-4">
                                    <div
                                        className={`p-8 md:p-12 rounded-2xl transition-all duration-200  w-full ${
                                            isDark
                                                ? 'bg-gray-800/50'
                                                : 'bg-white'
                                        }`}
                                    >
                                        {/* Quote Icon */}
                                        <div className="mb-6 text-center">
                                            <svg className={`w-10 h-10 mx-auto ${
                                                isDark ? 'text-brand-orange-400' : 'text-brand-orange-600'
                                            }`} fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h4v10h-10z"/>
                                            </svg>
                                        </div>

                                        {/* Testimonial Content */}
                                        <blockquote className={`text-lg leading-relaxed mb-8 text-minimal text-center ${
                                            isDark ? 'text-gray-200' : 'text-gray-700'
                                        }`}>
                                            "{testimonial.content}"
                                        </blockquote>

                                        {/* Project Badge */}
                                        {testimonial.project && (
                                            <div className="mb-6 text-center">
                                                <span className={`inline-flex items-center px-4 py-2 rounded-full text-sm font-medium ${
                                                    isDark
                                                        ? 'bg-brand-orange-500/20 text-brand-orange-300'
                                                        : 'bg-brand-orange-100 text-brand-orange-700'
                                                }`}>
                                                    {testimonial.project}
                                                </span>
                                            </div>
                                        )}

                                        {/* Author Info */}
                                        <div className="flex flex-col items-center">
                                            <div className="flex-shrink-0 mb-4">
                                                {testimonial.avatar_url && getSafeImageUrl(testimonial.avatar_url) ? (
                                                    <img
                                                        src={getSafeImageUrl(testimonial.avatar_url, testimonial.name, 64, 64)}
                                                        alt={testimonial.name}
                                                        className="w-16 h-16 rounded-full object-cover border-2 border-brand-orange-500/30"
                                                    />
                                                ) : (
                                                    <div className={`w-16 h-16 rounded-full flex items-center justify-center font-bold text-lg text-white border-2 ${
                                                        isDark ? 'bg-brand-orange-500 border-brand-orange-400' : 'bg-brand-orange-600 border-brand-orange-300'
                                                    }`}>
                                                        {testimonial.name?.charAt(0) || 'A'}
                                                    </div>
                                                )}
                                            </div>
                                            <div className="text-center">
                                                <h4 className={`text-lg font-semibold mb-1 text-minimal-bold ${
                                                    isDark ? 'text-white' : 'text-gray-900'
                                                }`}>
                                                    {testimonial.name}
                                                </h4>
                                                <p className={`text-sm font-medium ${
                                                    isDark ? 'text-brand-orange-400' : 'text-brand-orange-600'
                                                }`}>
                                                    {testimonial.role}
                                                </p>
                                                <p className={`text-sm text-minimal ${
                                                    isDark ? 'text-gray-400' : 'text-gray-600'
                                                }`}>
                                                    {testimonial.company}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </SwiperSlide>
                        ))}
                    </Swiper>

                    {/* Custom Pagination Styling */}
                    <style>{`
                        .swiper-pagination {
                            position: relative;
                            margin-top: 2rem;
                            bottom: auto;
                        }
                        .swiper-pagination-bullet {
                            width: 10px;
                            height: 10px;
                            margin: 0 6px;
                            opacity: 1;
                            transition: all 0.3s ease;
                        }
                        .swiper-pagination-bullet:hover {
                            transform: scale(1.3);
                        }
                        .swiper-pagination-bullet-active {
                            transform: scale(1.2);
                        }
                    `}</style>
                </div>


            </div>
        </section>
    );
}

export default MovieTestimonials;
