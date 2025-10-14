import React from 'react';
import { Routes, Route } from 'react-router-dom';
import { ThemeProvider, useTheme } from '../contexts/ThemeContext';
import Header from './sections/Header';
import Footer from './sections/Footer';
import Home from '../pages/Home';
import About from '../pages/About';
import Business from '../pages/Business';
import Portfolio from '../pages/Portfolio';
import PortfolioItem from '../pages/PortfolioItem';
import Partners from '../pages/Partners';
import News from '../pages/News';
import NewsPost from '../pages/NewsPost';
import Contact from '../pages/Contact';
import Team from '../pages/Team';
import TeamMember from '../pages/TeamMember';
import DynamicPage from '../pages/DynamicPage';

function AppContent() {
    const { isDark } = useTheme();

    return (
        <div className={`min-h-screen transition-colors duration-300 ${
            isDark ? 'bg-gray-900' : 'bg-white'
        }`}>
            <Header />
            <main>
                <Routes>
                    <Route path="/" element={<Home />} />
                    <Route path="/about" element={<About />} />
                    <Route path="/business" element={<Business />} />
                    <Route path="/portfolio" element={<Portfolio />} />
                    <Route path="/portfolio/:slug" element={<PortfolioItem />} />
                    <Route path="/partners" element={<Partners />} />
                    <Route path="/team" element={<Team />} />
                    <Route path="/team/:slug" element={<TeamMember />} />
                    <Route path="/news" element={<News />} />
                    <Route path="/news/:slug" element={<NewsPost />} />
                    <Route path="/contact" element={<Contact />} />
                    <Route path="/page/:slug" element={<DynamicPage />} />
                </Routes>
            </main>
            <Footer />
        </div>
    );
}

function App() {
    return (
        <ThemeProvider>
            <AppContent />
        </ThemeProvider>
    );
}

export default App;
