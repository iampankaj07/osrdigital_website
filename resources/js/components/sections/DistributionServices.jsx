import React from 'react';
import { Link } from 'react-router-dom';
import { useTheme } from '../../contexts/ThemeContext';
import { useState, useEffect } from 'react';

function DistributionServices() {
    const { isDark } = useTheme();
    const [services, setServices] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchServices = async () => {
            try {
                setLoading(true);
                const response = await fetch('/api/distribution-services');
                const data = await response.json();

                if (data.success) {
                    setServices(data.data);
                } else {
                    setError('Failed to load services');
                }
            } catch (err) {
                setError('Failed to load services');
                console.error('Error fetching distribution services:', err);
            } finally {
                setLoading(false);
            }
        };

        fetchServices();
    }, []);

    const renderIcon = (service) => {
        switch (service.icon_type) {
            case 'svg':
                return <div dangerouslySetInnerHTML={{ __html: service.icon_data }} />;
            case 'font-awesome':
                return <i className={service.icon_data}></i>;
            case 'image':
                return <img src={service.icon_data} alt={service.title} className="w-6 h-6 object-contain" />;
            default:
                return <i className="fas fa-box"></i>;
        }
    };

    if (loading) {
        return (
            <section className={`section-minimal ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                <div className="container-minimal">
                    {/* Header Skeleton */}
                    <div className="text-center mb-16">
                        <div className={`h-10 w-80 mx-auto mb-6 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                        <div className={`h-6 w-96 mx-auto mb-2 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                        <div className={`h-6 w-64 mx-auto rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                    </div>

                    {/* Services Grid Skeleton */}
                    <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                        {[1, 2, 3, 4, 5, 6].map((i) => (
                            <div key={i} className={`p-8 rounded-xl border ${isDark ? 'bg-gray-800 border-gray-700' : 'bg-gray-50 border-gray-200'}`}>
                                <div className="flex items-start space-x-4">
                                    <div className={`w-12 h-12 rounded-lg ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast flex-shrink-0`}></div>
                                    <div className="flex-1">
                                        <div className={`h-6 w-32 mb-3 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                        <div className={`h-4 w-full mb-2 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                        <div className={`h-4 w-3/4 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
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
            <section className={`section-minimal ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                <div className="container-minimal">
                    <div className="text-center py-16">
                        <i className="fas fa-exclamation-triangle text-4xl text-red-500 mb-4"></i>
                        <p className={`text-lg ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>{error}</p>
                    </div>
                </div>
            </section>
        );
    }

    return (
        <section className={`section-minimal ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
            <div className="container-minimal">
                {/* Header */}
                <div className="text-center mb-16">
                    <h2 className={`text-3xl md:text-4xl font-bold mb-6 text-minimal-bold ${isDark ? 'text-white' : 'text-gray-900'
                        }`}>
                        Our Distribution Services
                    </h2>
                    <p className={`text-lg max-w-3xl mx-auto text-minimal ${isDark ? 'text-gray-300' : 'text-gray-600'
                        }`}>
                        We provide comprehensive movie distribution services across all platforms and markets,
                        ensuring your content reaches the right audience at the right time.
                    </p>
                </div>

                {/* Services Grid */}
                {services.length > 0 ? (
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        {services.map((service, index) => (
                            <div
                                key={service.id || index}
                                className={`group transform transition-all duration-1000 hover:-translate-y-2`}
                                style={{ transitionDelay: `${index * 100}ms` }}
                            >
                                <div className={`h-full p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 ${isDark
                                        ? 'bg-gradient-to-br from-gray-800 to-gray-900 hover:from-gray-700 hover:to-gray-800'
                                        : 'bg-gradient-to-br from-white to-gray-50 hover:to-white border border-gray-100'
                                    }`}>
                                    <div className="flex items-start gap-4 mb-4">
                                        <div className={`p-4 rounded-xl ${isDark
                                                ? 'bg-brand-orange-500/20 text-brand-orange-400'
                                                : 'bg-brand-orange-100 text-brand-orange-600'
                                            } group-hover:scale-110 transition-transform duration-300`}>
                                            <div className="text-3xl">
                                                {renderIcon(service)}
                                            </div>
                                        </div>
                                        <div className="w-12 h-1 bg-brand-orange-500 rounded-full mt-6 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    </div>

                                    <h3 className={`text-xl font-bold mb-3 group-hover:text-brand-orange-600 dark:group-hover:text-brand-orange-400 transition-colors ${isDark ? 'text-white' : 'text-gray-900'
                                        }`}>
                                        {service.title}
                                    </h3>

                                    <p className={`text-sm leading-relaxed ${isDark ? 'text-gray-300' : 'text-gray-600'
                                        }`}>
                                        {service.description}
                                    </p>
                                </div>
                            </div>
                        ))}
                    </div>
                ) : (
                    <div className="text-center py-16">
                        <i className="fas fa-box-open text-4xl text-gray-400 mb-4"></i>
                        <p className={`text-lg ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>No services available at the moment.</p>
                    </div>
                )}

                {/* CTA Section */}
                <div className="text-center mt-16">
                    <Link
                        to="/contact"
                        className="btn-minimal"
                    >
                        Start Your Distribution Journey
                    </Link>
                </div>
            </div>
        </section>
    );
}

export default DistributionServices;
