import React from 'react';
import { Routes, Route } from 'react-router-dom';
import Header from './sections/Header';
import Footer from './sections/Footer';
import Home from '../pages/Home';
import About from '../pages/About';
import Business from '../pages/Business';
import Portfolio from '../pages/Portfolio';
import PortfolioItem from '../pages/PortfolioItem';
import Partners from '../pages/Partners';
import News from '../pages/News';
import Contact from '../pages/Contact';
import Team from '../pages/Team';
import Teams from '../pages/Team';

function App() {
    return (
        <div className="min-h-screen bg-gray-900">
            <Header />
            <main>
                <Routes>
                    <Route path="/" element={<Home />} />
                    <Route path="/about" element={<About />} />
                    <Route path="/business" element={<Business />} />
                    <Route path="/portfolio" element={<Portfolio />} />
                    <Route path="/portfolio/:slug" element={<PortfolioItem />} />
                    <Route path="/partners" element={<Partners />} />
                    <Route path="/teams" element={<Teams />} />
                    <Route path="/news" element={<News />} />
                    <Route path="/contact" element={<Contact />} />
                </Routes>
            </main>
            <Footer />
        </div>
    );
}

export default App;
