import React, { useState, useEffect } from "react";

export default function Teams() {
    const [team, setTeam] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        // Later you can fetch from API like /api/team
        // For now, fallback static data:
        setTeam([
            {
                name: "Pankaj Dulal",
                role: "Flutter & Laravel Developer",
                image: "https://via.placeholder.com/150",
                linkedin: "https://linkedin.com/in/...",
                github: "https://github.com/...",
                email: "pankaj.dulal07@gmail.com",
            },
            {
                name: "John Doe",
                role: "UI/UX Designer",
                image: "https://via.placeholder.com/150",
                linkedin: "https://linkedin.com/in/...",
            },
            {
                name: "Jane Smith",
                role: "Backend Engineer",
                image: "https://via.placeholder.com/150",
                github: "https://github.com/...",
            },
            {
                name: "Alex Johnson",
                role: "Project Manager",
                image: "https://via.placeholder.com/150",
                email: "alex.johnson@example.com",
            },
        ]);
        setLoading(false);
    }, []);

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

                    <div className="grid gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                        {team.map((member, i) => (
                            <div
                                key={i}
                                className="bg-gray-800 p-8 rounded-lg hover:bg-gray-700 transition-colors flex flex-col items-center text-center"
                            >
                                {member.image ? (
                                    <img
                                        src={member.image}
                                        alt={member.name}
                                        className="w-28 h-28 mb-4 rounded-full object-cover border-4 border-gray-700"
                                    />
                                ) : (
                                    <div className="w-28 h-28 mb-4 rounded-full bg-gray-600 flex items-center justify-center text-2xl font-bold text-white">
                                        {member.name[0]}
                                    </div>
                                )}

                                <h2 className="text-xl font-semibold text-white">{member.name}</h2>
                                <p className="text-gray-400 mb-4">{member.role}</p>

                                <div className="flex gap-4 text-sm">
                                    {member.linkedin && (
                                        <a
                                            href={member.linkedin}
                                            target="_blank"
                                            className="text-blue-400 hover:underline"
                                        >
                                            LinkedIn
                                        </a>
                                    )}
                                    {member.github && (
                                        <a
                                            href={member.github}
                                            target="_blank"
                                            className="text-gray-300 hover:underline"
                                        >
                                            GitHub
                                        </a>
                                    )}
                                    {member.email && (
                                        <a
                                            href={`mailto:${member.email}`}
                                            className="text-red-400 hover:underline"
                                        >
                                            Email
                                        </a>
                                    )}
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </section>
        </div>
    );
}
