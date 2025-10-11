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
                    <div className="text-center py-16">
                        <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-purple-600 mx-auto mb-4"></div>
                        <p className={`text-lg ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>Loading services...</p>
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

                                        <div className={`flex items-center text-sm font-medium transition-colors duration-200 ${
                                            isDark 
                                                ? 'text-brand-orange-400 group-hover:text-brand-orange-300' 
                                                : 'text-brand-orange-600 group-hover:text-brand-orange-700'
                                        }`}>
                                            <span>Learn More</span>
                                            <svg className="w-3 h-3 ml-1 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                                            </svg>
                                        </div>
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
