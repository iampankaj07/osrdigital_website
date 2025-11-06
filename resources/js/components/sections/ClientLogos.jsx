import { useState, useEffect } from 'react';
import { useTheme } from '../../contexts/ThemeContext';
import axios from 'axios';

function ClientLogos() {
    const { isDark } = useTheme();
    const [associates, setAssociates] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchAssociates = async () => {
            try {
                const response = await axios.get('/api/associates');
                setAssociates(response.data.data);
            } catch (err) {
                setError(err);
                // Fallback to static data if API fails
                setAssociates([
                    {
                        name: 'OSR Digital',
                        logo: '/images/logo.png',
                        website: 'https://osrdigital.com/'
                    },
                    {
                        name: 'OSR Connect',
                        logo: '/images/associates/osr-connect.png',
                        website: 'https://osrdigital.com/'
                    },
                    {
                        name: 'OSR Reality',
                        logo: '/images/associates/osr-reality.png',
                        website: 'https://osrdigital.com/'
                    },
                    {
                        name: 'OSR Sports',
                        logo: '/images/associates/osr-sports.png',
                        website: 'https://osrdigital.com/'
                    }
                ]);
            } finally {
                setLoading(false);
            }
        };

        fetchAssociates();
    }, []);

    if (loading) {
        return (
            <section className={`py-16 ${isDark ? 'bg-gray-900' : 'bg-gray-50'}`}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center mb-12">
                        <div className={`h-8 w-64 mx-auto mb-4 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                        <div className={`h-4 w-96 mx-auto rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                    </div>

                    <div className="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-8 items-center">
                        {[1, 2, 3, 4, 5, 6].map((i) => (
                            <div key={i} className="flex justify-center">
                                <div className={`h-16 w-32 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                            </div>
                        ))}
                    </div>
                </div>
            </section>
        );
    }

    return (
        <section className={`py-16 ${isDark ? 'bg-gray-900' : 'bg-gray-50'}`}>
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="text-center mb-12">
                    <h2 className={`text-3xl md:text-4xl font-bold mb-4 ${
                        isDark ? 'text-white' : 'text-gray-900'
                    }`}>
                        Our Associates
                    </h2>
                    <p className={`text-lg max-w-3xl mx-auto ${
                        isDark ? 'text-gray-300' : 'text-gray-600'
                    }`}>
                        We work with leading distribution partners and streaming platforms to bring exceptional content to global audiences.
                    </p>
                </div>

                {/* Associates Grid */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    {associates.map((associate, index) => (
                        <div
                            key={index}
                            className={`p-6 rounded-2xl transition-all duration-300 hover-subtle ${
                                isDark
                                    ? 'bg-gray-800 border border-gray-700'
                                    : 'bg-white border border-gray-200'
                            }`}
                        >
                            <div className="flex flex-col items-center text-center">
                                <div className="mb-4">
                                    {associate.logo ? (
                                        <img
                                            src={associate.logo}
                                            alt={associate.name}
                                            className="h-16 w-auto object-contain"
                                            onError={(e) => {
                                                e.target.style.display = 'none';
                                                e.target.nextSibling.style.display = 'flex';
                                            }}
                                        />
                                    ) : null}
                                    <div className={`${associate.logo ? 'hidden' : ''} items-center justify-center h-16 w-24 bg-gradient-to-r from-brand-orange-500 to-red-600 rounded text-white font-bold text-sm`}>
                                        {associate.name.split(' ')[0]}
                                    </div>
                                </div>

                                <h3 className={`text-xl font-bold mb-4 ${
                                    isDark ? 'text-white' : 'text-gray-900'
                                }`}>
                                    {associate.name}
                                </h3>

                                {associate.website && (
                                    <a
                                        href={associate.website}
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className={`inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover-subtle ${
                                            isDark
                                                ? 'bg-gray-700 text-gray-300 hover:bg-gray-600'
                                                : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
                                        }`}
                                    >
                                        Visit
                                        <svg className="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                    </a>
                                )}
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}

export default ClientLogos;
