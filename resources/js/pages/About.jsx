

import { useTheme } from '../contexts/ThemeContext';

function About() {
    const { isDark } = useTheme();

    return (
        <div className={`min-h-screen ${isDark ? 'bg-gray-900' : 'bg-gray-50'} pt-20`}>
            <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <h1 className={`text-5xl font-bold ${isDark ? 'text-white' : 'text-gray-900'} mb-8`}>About OSR Digital</h1>

                <div className="prose prose-lg max-w-none">
                    <p className={`text-xl ${isDark ? 'text-gray-300' : 'text-gray-600'} mb-8`}>
                        OSR Digital is a leading content acquisition and distribution company specializing in
                        bringing exceptional entertainment to global audiences through strategic YouTube publishing.
                    </p>

                    <div className="grid md:grid-cols-2 gap-12 mb-12">
                        <div>
                            <h2 className={`text-3xl font-bold ${isDark ? 'text-white' : 'text-gray-900'} mb-4`}>Our Mission</h2>
                            <p className={`${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                                To bridge the gap between content creators and global audiences by acquiring rights
                                to exceptional movies, songs, and short films, and distributing them through
                                strategic YouTube publishing.
                            </p>
                        </div>

                        <div>
                            <h2 className={`text-3xl font-bold ${isDark ? 'text-white' : 'text-gray-900'} mb-4`}>Our Vision</h2>
                            <p className={`${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                                To become the premier digital media company that brings diverse, high-quality
                                entertainment content to screens worldwide, fostering cultural exchange and
                                creative appreciation.
                            </p>
                        </div>
                    </div>

                    <h2 className={`text-3xl font-bold ${isDark ? 'text-white' : 'text-gray-900'} mb-6`}>What We Do</h2>
                    <div className="grid md:grid-cols-3 gap-8">
                        <div className={`${isDark ? 'bg-gray-800' : 'bg-white'} p-6 rounded-lg shadow-lg`}>
                            <h3 className={`text-xl font-semibold ${isDark ? 'text-white' : 'text-gray-900'} mb-3`}>Content Acquisition</h3>
                            <p className={`${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                                We identify and acquire rights to exceptional movies, music, and short films
                                from creators worldwide.
                            </p>
                        </div>

                        <div className={`${isDark ? 'bg-gray-800' : 'bg-white'} p-6 rounded-lg shadow-lg`}>
                            <h3 className={`text-xl font-semibold ${isDark ? 'text-white' : 'text-gray-900'} mb-3`}>Strategic Distribution</h3>
                            <p className={`${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                                Our expert team develops and executes strategic YouTube publishing campaigns
                                to maximize reach and engagement.
                            </p>
                        </div>

                        <div className={`${isDark ? 'bg-gray-800' : 'bg-white'} p-6 rounded-lg shadow-lg`}>
                            <h3 className={`text-xl font-semibold ${isDark ? 'text-white' : 'text-gray-900'} mb-3`}>Global Reach</h3>
                            <p className={`${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                                We connect content with audiences across different cultures and regions,
                                creating opportunities for cross-cultural appreciation.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default About;
