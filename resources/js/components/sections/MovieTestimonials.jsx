import { useState, useEffect } from 'react';
import { useTheme } from '../../contexts/ThemeContext';
import { getSafeImageUrl } from '../../utils/imageUtils';

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

                console.log('Fetching testimonials from API...');
                const response = await fetch('/api/testimonials/featured?limit=4');

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                console.log('API Response:', data);

                if (data.success && data.data && data.data.length > 0) {
                    console.log('Using API data:', data.data.length, 'testimonials');
                    setTestimonials(data.data);
                } else {
                    console.log('API returned no data');
                    setError('No testimonials available');
                    setTestimonials([]);
                }
            } catch (err) {
                console.error('Error fetching testimonials:', err);
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

                    <div className="grid md:grid-cols-2 gap-8">
                        {[1, 2, 3, 4].map((i) => (
                            <div key={i} className={`p-8 rounded-xl ${isDark ? 'bg-gray-800' : 'bg-white'} border ${isDark ? 'border-gray-700' : 'border-gray-200'}`}>
                                <div className="flex items-start space-x-4">
                                    <div className={`w-16 h-16 rounded-full ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast flex-shrink-0`}></div>
                                    <div className="flex-1">
                                        <div className={`h-5 w-32 mb-2 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                        <div className={`h-4 w-24 mb-4 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                        <div className={`h-4 w-full mb-2 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                        <div className={`h-4 w-3/4 mb-2 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                        <div className={`h-4 w-2/3 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                    </div>
                                </div>
                            </div>
                        ))}
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

                {/* Testimonials Grid */}
                <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {testimonials.map((testimonial, index) => (
                        <div
                            key={testimonial.id}
                            className={`p-6 rounded-xl transition-all duration-200 hover-subtle ${
                                isDark
                                    ? 'card-minimal-dark hover:border-brand-orange-500/30'
                                    : 'card-minimal hover:border-brand-orange-200'
                            }`}
                        >
                            {/* Quote Icon */}
                            <div className="mb-4">
                                <svg className={`w-8 h-8 ${
                                    isDark ? 'text-brand-orange-400' : 'text-brand-orange-600'
                                }`} fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h4v10h-10z"/>
                                </svg>
                            </div>

                            {/* Testimonial Content */}
                            <blockquote className={`text-base leading-relaxed mb-6 text-minimal ${
                                isDark ? 'text-gray-300' : 'text-gray-700'
                            }`}>
                                "{testimonial.content}"
                            </blockquote>

                            {/* Project Badge */}
                            {testimonial.project && (
                                <div className="mb-4">
                                    <span className={`inline-flex items-center px-3 py-1 rounded-full text-xs font-medium ${
                                        isDark
                                            ? 'bg-brand-orange-500/20 text-brand-orange-400'
                                            : 'bg-brand-orange-100 text-brand-orange-600'
                                    }`}>
                                        {testimonial.project}
                                    </span>
                                </div>
                            )}

                            {/* Author Info */}
                            <div className="flex items-center">
                                <div className="flex-shrink-0 mr-4">
                                    <img
                                        src={getSafeImageUrl(testimonial.avatar_url, testimonial.name, 64, 64)}
                                        alt={testimonial.name}
                                        className="w-12 h-12 rounded-full object-cover"
                                    />
                                </div>
                                <div className="flex-1">
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
                    ))}
                </div>

                {/* CTA Section */}
                <div className="text-center mt-16">
                    <div className={`inline-block px-8 py-4 rounded-lg ${
                        isDark
                            ? 'bg-brand-orange-500/10 border border-brand-orange-500/30'
                            : 'bg-brand-orange-50 border border-brand-orange-200'
                    }`}>
                        <p className={`text-lg font-semibold ${
                            isDark ? 'text-brand-orange-400' : 'text-brand-orange-600'
                        }`}>
                            Ready to share your story with the world?
                        </p>
                    </div>
                </div>
            </div>
        </section>
    );
}

export default MovieTestimonials;
