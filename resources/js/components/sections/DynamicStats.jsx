import React, { useState, useEffect } from 'react';

function DynamicStats() {
    const [stats, setStats] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        // Fetch stats from API
        fetch('/api/stats')
            .then(response => response.json())
            .then(data => {
                setStats(data);
                setLoading(false);
            })
            .catch(error => {
                console.error('Error fetching stats:', error);
                setLoading(false);
            });
    }, []);

    if (loading) {
        return (
            <section className="py-20 bg-gray-900">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="grid grid-cols-2 lg:grid-cols-4 gap-8">
                        {[1, 2, 3, 4].map(i => (
                            <div key={i} className="text-center">
                                <div className="animate-pulse">
                                    <div className="h-12 w-12 bg-gray-700 rounded mx-auto mb-4"></div>
                                    <div className="h-8 bg-gray-700 rounded mb-2"></div>
                                    <div className="h-4 bg-gray-700 rounded"></div>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </section>
        );
    }

    return (
        <section className="py-20 bg-gray-900">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="grid grid-cols-2 lg:grid-cols-4 gap-8">
                    {stats.map((stat, index) => (
                        <div key={index} className="text-center group">
                            <div className="text-4xl mb-4 group-hover:scale-110 transition-transform duration-300">
                                {stat.icon}
                            </div>
                            <div className="text-4xl md:text-5xl font-bold text-white mb-2 group-hover:text-red-400 transition-colors duration-300">
                                {stat.number}
                            </div>
                            <div className="text-lg text-gray-400">
                                {stat.label}
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}

export default DynamicStats;
