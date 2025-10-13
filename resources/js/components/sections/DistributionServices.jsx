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
                        <div className={`h-10 w-80 mx-auto mb-6 rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                        <div className={`h-6 w-96 mx-auto mb-2 rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                        <div className={`h-6 w-64 mx-auto rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                    </div>

                    {/* Services Grid Skeleton */}
                    <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                        {[1, 2, 3, 4, 5, 6].map((i) => (
                            <div key={i} className={`p-8 rounded-xl border ${isDark ? 'bg-gray-800 border-gray-700' : 'bg-gray-50 border-gray-200'}`}>
                                <div className="flex items-start space-x-4">
                                    <div className={`w-12 h-12 rounded-lg ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse flex-shrink-0`}></div>
                                    <div className="flex-1">
                                        <div className={`h-6 w-32 mb-3 rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                                        <div className={`h-4 w-full mb-2 rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
                                        <div className={`h-4 w-3/4 rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'} animate-pulse`}></div>
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
                    <h2 className={`text-3xl md:text-4xl font-bold mb-6 text-minimal-bold ${
                        isDark ? 'text-white' : 'text-gray-900'
                    }`}>
                        Our Distribution Services
                    </h2>
                    <p className={`text-lg max-w-3xl mx-auto text-minimal ${
                        isDark ? 'text-gray-300' : 'text-gray-600'
                    }`}>
                        We provide comprehensive movie distribution services across all platforms and markets,
                        ensuring your content reaches the right audience at the right time.
                    </p>
                </div>

                {/* Services Grid */}
                {services.length > 0 ? (
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        {services.map((service, index) => (
                            <Link
                                key={service.id || index}
                                to={service.link}
                                className={`group p-6 rounded-xl transition-all duration-200 hover-subtle ${
                                    isDark
                                        ? 'card-minimal-dark hover:border-brand-orange-500/30'
                                        : 'card-minimal hover:border-brand-orange-200'
                                }`}
                            >
                                <div className="flex items-start gap-4">
                                    <div className={`p-3 rounded-lg ${
                                        isDark
                                            ? 'bg-brand-orange-500/10 text-brand-orange-400'
                                            : 'bg-brand-orange-100 text-brand-orange-600'
                                    }`}>
                                        {renderIcon(service)}
                                    </div>

                                    <div className="flex-1">
                                        <h3 className={`text-lg font-semibold mb-3 text-minimal-bold ${
                                            isDark ? 'text-white' : 'text-gray-900'
                                        }`}>
                                            {service.title}
                                        </h3>

                                        <p className={`text-sm text-minimal mb-4 ${
                                            isDark ? 'text-gray-300' : 'text-gray-600'
                                        }`}>
                                            {service.description}
                                        </p>

                                    </div>
                                </div>
                            </Link>
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
