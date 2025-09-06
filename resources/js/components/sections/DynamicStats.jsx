import React, { useState, useEffect } from 'react';
import { 
    FilmIcon, 
    MusicalNoteIcon, 
    VideoCameraIcon, 
    EyeIcon 
} from '@heroicons/react/24/outline';

function DynamicStats() {
    const [loading, setLoading] = useState(true);

    // Static stats with Heroicons
    const stats = [
        {
            number: '500+',
            label: 'Movies Published',
            icon: FilmIcon,
        },
        {
            number: '2,000+',
            label: 'Songs Released',
            icon: MusicalNoteIcon,
        },
        {
            number: '800+',
            label: 'Short Films',
            icon: VideoCameraIcon,
        },
        {
            number: '50M+',
            label: 'Total Views',
            icon: EyeIcon,
        }
    ];

    useEffect(() => {
        // Simulate loading
        const timer = setTimeout(() => {
            setLoading(false);
        }, 500);
        
        return () => clearTimeout(timer);
    }, []);

    if (loading) {
        return (
            <section className="py-24 bg-gradient-to-b from-gray-900 to-black">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="grid grid-cols-2 lg:grid-cols-4 gap-8">
                        {[1, 2, 3, 4].map(i => (
                            <div key={i} className="text-center">
                                <div className="animate-pulse">
                                    <div className="h-16 w-16 bg-gray-700/50 rounded-2xl mx-auto mb-6"></div>
                                    <div className="h-8 bg-gray-700/50 rounded-lg mb-3"></div>
                                    <div className="h-4 bg-gray-700/50 rounded"></div>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </section>
        );
    }

    return (
        <section className="py-24 bg-gray-900">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="text-center mb-16">
                    <h2 className="text-4xl md:text-5xl font-bold text-white mb-6">
                        Our <span className="text-[#ec681b]">Impact</span>
                    </h2>
                    <p className="text-xl text-gray-400 max-w-3xl mx-auto">
                        Numbers that speak to our commitment to bringing quality content to global audiences
                    </p>
                </div>

                <div className="grid grid-cols-2 lg:grid-cols-4 gap-8">
                    {stats.map((stat, index) => {
                        const IconComponent = stat.icon;
                        return (
                            <div key={index} className="group text-center">
                                <div className="relative mb-6">
                                    {/* Icon Container */}
                                    <div className="w-20 h-20 mx-auto bg-gray-800 hover:bg-[#ec681b] rounded-2xl flex items-center justify-center transition-colors duration-300 shadow-lg">
                                        <IconComponent className="w-10 h-10 text-white" />
                                    </div>
                                </div>

                                {/* Number */}
                                <div className="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-3 group-hover:text-[#ec681b] transition-colors duration-300">
                                    {stat.number}
                                </div>

                                {/* Label */}
                                <div className="text-lg font-medium text-gray-400">
                                    {stat.label}
                                </div>

                                {/* Progress Line */}
                                <div className="mt-4 h-1 bg-gray-800 rounded-full overflow-hidden">
                                    <div className="h-full bg-[#ec681b] rounded-full transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
                                </div>
                            </div>
                        );
                    })}
                </div>
            </div>
        </section>
    );
}

export default DynamicStats;
