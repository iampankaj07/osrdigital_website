import React, { Suspense, lazy } from 'react';
import { Routes, Route } from 'react-router-dom';
import { ThemeProvider, useTheme } from '../contexts/ThemeContext';
import Header from './sections/Header';
import Footer from './sections/Footer';

// Lazy load page components
const Home = lazy(() => import('../pages/Home'));
const About = lazy(() => import('../pages/About'));
const Portfolio = lazy(() => import('../pages/Portfolio'));
const PortfolioItem = lazy(() => import('../pages/PortfolioItem'));
const Partners = lazy(() => import('../pages/Partners'));
const News = lazy(() => import('../pages/News'));
const NewsPost = lazy(() => import('../pages/NewsPost'));
const Contact = lazy(() => import('../pages/Contact'));
const Team = lazy(() => import('../pages/Team'));
const TeamMember = lazy(() => import('../pages/TeamMember'));
const DynamicPage = lazy(() => import('../pages/DynamicPage'));
const LegalPage = lazy(() => import('../pages/LegalPage'));

// Loading component
const PageLoader = () => (
    <div className="min-h-screen flex items-center justify-center">
        <div className="animate-spin rounded-full h-32 w-32 border-b-2 border-brand-orange-500"></div>
    </div>
);

function AppContent() {
    const { isDark } = useTheme();

    return (
        <div className={`min-h-screen transition-colors duration-300 ${
            isDark ? 'bg-gray-900' : 'bg-white'
        }`}>
            <Header />
            <main>
                <Suspense fallback={<PageLoader />}>
                    <Routes>
                        <Route path="/" element={<Home />} />
                        <Route path="/about" element={<About />} />
                        <Route path="/portfolio" element={<Portfolio />} />
                        <Route path="/portfolio/:slug" element={<PortfolioItem />} />
                        <Route path="/partners" element={<Partners />} />
                        <Route path="/team" element={<Team />} />
                        <Route path="/team/:slug" element={<TeamMember />} />
                        <Route path="/news" element={<News />} />
                        <Route path="/news/:slug" element={<NewsPost />} />
                        <Route path="/contact" element={<Contact />} />
                        <Route path="/page/:slug" element={<DynamicPage />} />
                        <Route path="/privacy-policy" element={<LegalPage />} />
                        <Route path="/terms-of-service" element={<LegalPage />} />
                        <Route path="/cookies-policy" element={<LegalPage />} />
                        <Route path="/legal/:slug" element={<LegalPage />} />
                    </Routes>
                </Suspense>
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
