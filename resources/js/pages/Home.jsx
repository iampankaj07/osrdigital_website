import Hero from '../components/sections/Hero';
import DynamicStats from '../components/sections/DynamicStats';
import DynamicFeaturedContent from '../components/sections/DynamicFeaturedContent';
import CallToAction from '../components/sections/CallToAction';

function Home() {
    return (
        <div className="min-h-screen">
            <Hero />
            <DynamicStats />
            <DynamicFeaturedContent />
            <CallToAction />
        </div>
    );
}

export default Home;
