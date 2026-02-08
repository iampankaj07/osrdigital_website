import React from 'react';
import { useTheme } from '../contexts/ThemeContext';
import HeroSlider from '../components/sections/HeroSlider';
import ClientLogos from '../components/sections/ClientLogos';
import DistributionServices from '../components/sections/DistributionServices';
import OurImpact from '../components/sections/OurImpact';
import FeaturedPortfolio from '../components/sections/FeaturedPortfolio';
import MovieTestimonials from '../components/sections/MovieTestimonials';

function Home() {
    const { isDark } = useTheme();

    return (
        <div className={`transition-colors duration-300 ${isDark ? 'bg-gray-900' : 'bg-white'
            }`}>
            {/* Hero Slider Section */}
            <HeroSlider />

            {/* Client Logos Section */}
            <ClientLogos />

            {/* Distribution Services Section */}
            <DistributionServices />

            {/* Global Impact Section */}
            <OurImpact />

            {/* Featured Portfolio Section */}
            <FeaturedPortfolio />

            {/* Testimonials Section */}
            <MovieTestimonials />
        </div>
    );
}

export default Home;
