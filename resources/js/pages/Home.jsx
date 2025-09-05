import React from 'react';
import Hero from '../components/sections/Hero';
import DynamicStats from '../components/sections/DynamicStats';
import DynamicFeaturedContent from '../components/sections/DynamicFeaturedContent';
import CallToAction from '../components/sections/CallToAction';

function Home() {
    return (
        <>
            <Hero />
            <DynamicStats />
            <DynamicFeaturedContent />
            <CallToAction />
        </>
    );
}

export default Home;
