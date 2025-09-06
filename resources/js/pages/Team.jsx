import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';

function Team() {
    const [teams, setTeams] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchTeams = async () => {
            try {
                const response = await fetch('/api/teams');
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
            <div className="min-h-screen bg-gray-900 pt-20 flex items-center justify-center">
                <p className="text-gray-400">Loading team...</p>
            </div>
        );
    }

    return (
        <div className="min-h-screen bg-gray-900 pt-20">
            {/* Hero Section */}
            <section className="py-20 bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900">
                <div className="max-w-4xl mx-auto px-4 text-center">
                    <h1 className="text-5xl font-bold text-white mb-8">Meet Our Team</h1>
                    <p className="text-xl text-gray-300 max-w-3xl mx-auto">
                        Our diverse team of developers, designers, and strategists work together
                        to deliver creative and impactful solutions.
                    </p>
                </div>
            </section>

            {/* Team Grid */}
            <section className="py-20 bg-black">
                <div className="max-w-7xl mx-auto px-4">
                    <div className="text-center mb-16">
                        <h2 className="text-4xl font-bold text-white mb-6">Our People</h2>
                        <p className="text-xl text-gray-400 max-w-3xl mx-auto">
                            The brains, creativity, and passion that power OSR Digital
                        </p>
                    </div>

                    {error && (
                        <div className="text-center mb-8">
                            <p className="text-yellow-400 mb-2">Note: Using sample data due to API error</p>
                            <p className="text-red-400 text-sm">{error}</p>
                        </div>
                    )}

                    <div className="grid gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                        {teams.map((member, i) => (
                            <Link
                                key={member.id || i}
                                to={`/team/${member.slug}`}
                                className="bg-gray-800 p-8 rounded-lg hover:bg-gray-700 transition-colors flex flex-col items-center text-center group"
                            >
                                {member.image ? (
                                    <img
                                        src={`/storage/${member.image}`}
                                        alt={member.name}
                                        className="w-28 h-28 mb-4 rounded-full object-cover border-4 border-gray-700 group-hover:border-gray-600 transition-colors"
                                    />
                                ) : (
                                    <div className="w-28 h-28 mb-4 rounded-full bg-gray-600 flex items-center justify-center text-2xl font-bold text-white border-4 border-gray-700 group-hover:border-gray-600 transition-colors">
                                        {member.name.split(' ').map(n => n[0]).join('').toUpperCase()}
                                    </div>
                                )}

                                <h2 className="text-xl font-semibold text-white group-hover:text-gray-200 transition-colors">
                                    {member.name}
                                </h2>
                                <p className="text-gray-400 mb-4 group-hover:text-gray-300 transition-colors">
                                    {member.position}
                                </p>

                                <div className="flex gap-4 text-sm">
                                    {getSocialLink(member, 'linkedin') && (
                                        <a
                                            href={getSocialLink(member, 'linkedin')}
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            className="text-blue-400 hover:underline"
                                            onClick={(e) => e.stopPropagation()}
                                        >
                                            LinkedIn
                                        </a>
                                    )}
                                    {getSocialLink(member, 'github') && (
                                        <a
                                            href={getSocialLink(member, 'github')}
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            className="text-gray-300 hover:underline"
                                            onClick={(e) => e.stopPropagation()}
                                        >
                                            GitHub
                                        </a>
                                    )}
                                    {member.email && (
                                        <a
                                            href={`mailto:${member.email}`}
                                            className="text-red-400 hover:underline"
                                            onClick={(e) => e.stopPropagation()}
                                        >
                                            Email
                                        </a>
                                    )}
                                </div>
                            </Link>
                        ))}
                    </div>

                    {teams.length === 0 && !loading && (
                        <div className="text-center py-12">
                            <h3 className="text-lg font-medium text-gray-400 mb-2">No team members found</h3>
                            <p className="text-sm text-gray-500">Our team information will be available soon.</p>
                        </div>
                    )}
                </div>
            </section>
        </div>
    );
}

export default Team;
