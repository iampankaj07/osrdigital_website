import { useTheme } from '../contexts/ThemeContext';
import Hero from '../components/sections/Hero';
import ClientLogos from '../components/sections/ClientLogos';
import DistributionServices from '../components/sections/DistributionServices';
import MovieStats from '../components/sections/MovieStats';
import MoviePortfolio from '../components/sections/MoviePortfolio';
import MovieTestimonials from '../components/sections/MovieTestimonials';

function Home() {
    const { isDark } = useTheme();

    return (
        <div className={`min-h-screen transition-colors duration-300 ${
            isDark ? 'bg-gray-900' : 'bg-white'
        }`}>
            {/* Hero Section with Carousel */}
            <Hero />
            
            {/* Client Logos Section */}
            <ClientLogos />
            
            {/* Distribution Services Section */}
            <DistributionServices />
            
            {/* Statistics Section */}
            <MovieStats />
            
            {/* Movie Portfolio Section */}
            <MoviePortfolio />
            
            {/* Testimonials Section */}
            <MovieTestimonials />
        </div>
    );
}

export default Home;
