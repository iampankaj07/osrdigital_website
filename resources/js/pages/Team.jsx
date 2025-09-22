import { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { useAllSettings } from '../hooks/useSettings';
import { useTheme } from '../contexts/ThemeContext';
import PageHeader from '../components/PageHeader';

function Team() {
    const [teams, setTeams] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const { isDark } = useTheme();

    const primaryColor = '#ff6b35'; // OSR Digital brand orange

    useEffect(() => {
        const fetchTeams = async () => {
            try {
                const response = await fetch('/api/team');
                if (!response.ok) {
                    throw new Error('Failed to fetch team data');
                }
                const result = await response.json();
                setTeams(result.data || result);
            } catch (err) {
                setError(err.message);
                // Fallback to static data if API fails
                setTeams([
                    {
                        id: 1,
                        name: "Pankaj Dulal",
                        position: "Flutter & Laravel Developer",
                        image: null,
                        email: "pankaj.dulal07@gmail.com",
                        social_links: [
                            { platform: "linkedin", url: "https://linkedin.com/in/..." },
                            { platform: "github", url: "https://github.com/..." }
                        ],
                        slug: "pankaj-dulal"
                    },
                    {
                        id: 2,
                        name: "John Doe",
                        position: "UI/UX Designer",
                        image: null,
                        social_links: [
                            { platform: "linkedin", url: "https://linkedin.com/in/..." }
                        ],
                        slug: "john-doe"
                    },
                    {
                        id: 3,
                        name: "Jane Smith",
                        position: "Backend Engineer",
                        image: null,
                        social_links: [
                            { platform: "github", url: "https://github.com/..." }
                        ],
                        slug: "jane-smith"
                    },
                    {
                        id: 4,
                        name: "Alex Johnson",
                        position: "Project Manager",
                        image: null,
                        email: "alex.johnson@example.com",
                        social_links: [],
                        slug: "alex-johnson"
                    }
                ]);
            } finally {
                setLoading(false);
            }
        };

        fetchTeams();
    }, []);

    // Helper function to get social link URL by platform
    const getSocialLink = (member, platform) => {
        if (!member.social_links) return null;
        const link = member.social_links.find(social => social.platform === platform);
        return link ? link.url : null;
    };

    if (loading) {
        return (
            <div className={`min-h-screen ${isDark ? 'bg-gray-900' : 'bg-gray-50'} pt-20`}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                    <div className="text-center mb-16">
                        <h1 className={`text-5xl font-bold ${isDark ? 'text-white' : 'text-gray-900'} mb-8`}>
                            Our Teams
                        </h1>
                        <div className="animate-pulse">
                            <div className="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                                {[1, 2, 3, 4, 5, 6].map((i) => (
                                    <div
                                        key={i}
                                        className={`flex flex-col items-center ${isDark ? 'bg-gray-800' : 'bg-gray-200'} rounded-lg p-6`}
                                    >
                                        {/* Avatar Skeleton */}
                                        <div className="w-24 h-24 rounded-full mb-4" style={{ backgroundColor: isDark ? '#2d2d2d' : '#e5e5e5' }}></div>
                                        {/* Name Skeleton */}
                                        <div className={`h-5 w-32 mb-2 rounded ${isDark ? 'bg-gray-700' : 'bg-gray-300'}`}></div>
                                        {/* Position Skeleton */}
                                        <div className={`h-4 w-20 rounded ${isDark ? 'bg-gray-600' : 'bg-gray-300'}`}></div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }

    return (
        <div className={`min-h-screen ${isDark ? 'bg-gray-900' : 'bg-gray-50'}`}>
            <PageHeader
                badge="Meet Our Experts"
                title="The Team Behind Our Success"
                description="Our diverse team of developers, designers, and strategists work together to deliver exceptional entertainment content and strategic distribution solutions."
            />

            {/* Team Grid */}
            <section className={`py-20 ${isDark ? 'bg-gray-800' : 'bg-gray-100'}`}>
                <div className="max-w-7xl mx-auto px-4">
                    {error && (
                        <div className="text-center mb-8">
                            <div className={`${isDark ? 'bg-yellow-900/20 border-yellow-700' : 'bg-yellow-100 border-yellow-400'} border rounded-lg p-4 max-w-md mx-auto`}>
                                <p className={`${isDark ? 'text-yellow-400' : 'text-yellow-800'} mb-2`}>Using sample data</p>
                                <p className={`${isDark ? 'text-yellow-300' : 'text-yellow-700'} text-sm`}>{error}</p>
                            </div>
                        </div>
                    )}

                    <div className="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        {teams.map((member, i) => (
                            <Link
                                key={member.id || i}
                                to={`/team/${member.slug}`}
                                className={`group ${isDark ? 'bg-gray-700 hover:bg-gray-600' : 'bg-white hover:bg-gray-50'} rounded-2xl p-6 transition-all duration-300 flex flex-col items-center text-center shadow-lg hover:shadow-xl`}
                            >
                                {member.image ? (
                                    <img
                                        src={member.image}
                                        alt={member.name}
                                        className={`w-24 h-24 mb-4 rounded-full object-cover border-4 ${isDark ? 'border-gray-600 group-hover:border-gray-500' : 'border-gray-200 group-hover:border-gray-300'} transition-colors`}
                                    />
                                ) : (
                                    <div
                                        className={`w-24 h-24 mb-4 rounded-full flex items-center justify-center text-xl font-bold text-white border-4 ${isDark ? 'border-gray-600 group-hover:border-gray-500' : 'border-gray-200 group-hover:border-gray-300'} transition-all duration-300`}
                                        style={{
                                            backgroundColor: primaryColor,
                                        }}
                                        onMouseEnter={(e) => e.target.style.backgroundColor = `${primaryColor}dd`}
                                        onMouseLeave={(e) => e.target.style.backgroundColor = primaryColor}
                                    >
                                        {member.name.split(' ').map(n => n[0]).join('').toUpperCase()}
                                    </div>
                                )}

                                <h2 className={`text-xl font-semibold ${isDark ? 'text-white group-hover:text-gray-100' : 'text-gray-900 group-hover:text-gray-700'} transition-colors mb-1`}>
                                    {member.name}
                                </h2>
                                <p
                                    className="font-medium mb-4 transition-colors"
                                    style={{ color: primaryColor }}
                                >
                                    {member.position}
                                </p>

                                <div className="flex gap-4 text-sm mt-auto">
                                    {getSocialLink(member, 'linkedin') && (
                                        <a
                                            href={getSocialLink(member, 'linkedin')}
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            className="text-blue-400 hover:text-blue-300 transition-colors"
                                            onClick={(e) => e.stopPropagation()}
                                        >
                                            <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                            </svg>
                                        </a>
                                    )}
                                    {getSocialLink(member, 'github') && (
                                        <a
                                            href={getSocialLink(member, 'github')}
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            className="text-gray-300 hover:text-white transition-colors"
                                            onClick={(e) => e.stopPropagation()}
                                        >
                                            <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                                            </svg>
                                        </a>
                                    )}
                                    {member.email && (
                                        <a
                                            href={`mailto:${member.email}`}
                                            className="transition-colors"
                                            style={{
                                                color: primaryColor,
                                            }}
                                            onMouseEnter={(e) => e.target.style.color = `${primaryColor}dd`}
                                            onMouseLeave={(e) => e.target.style.color = primaryColor}
                                            onClick={(e) => e.stopPropagation()}
                                        >
                                            <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                                            </svg>
                                        </a>
                                    )}
                                </div>
                            </Link>
                        ))}
                    </div>

                    {teams.length === 0 && !loading && (
                        <div className="text-center py-12">
                            <div className="max-w-md mx-auto">
                                <svg className="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <h3 className="text-lg font-medium text-gray-300 mb-2">No team members found</h3>
                                <p className="text-sm text-gray-400">Our team information will be available soon.</p>
                            </div>
                        </div>
                    )}
                </div>
            </section>
        </div>
    );
}

export default Team;
