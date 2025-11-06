import React, { Suspense, lazy } from 'react';
import { Routes, Route } from 'react-router-dom';
import { ThemeProvider, useTheme } from '../contexts/ThemeContext';
import Header from './sections/Header';
import Footer from './sections/Footer';
import ScrollToTop from './ScrollToTop';

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

// Loading component with skeleton - wrapped to access theme
const PageLoaderWrapper = () => {
    const { isDark } = useTheme();
    return (
        <div className={`min-h-screen ${isDark ? 'bg-gray-900' : 'bg-gray-50'}`}>
            <div className="py-20 pt-32">
                <div className="container-minimal">
                    <div className="text-center max-w-4xl mx-auto mb-16">
                        <div className={`h-10 w-2/3 mx-auto mb-6 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                        <div className={`h-5 w-1/2 mx-auto rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                    </div>
                    <div className="max-w-4xl mx-auto px-4">
                        <div className={`rounded-xl p-8 md:p-12 shadow-lg ${isDark ? 'bg-gray-800' : 'bg-white'}`}>
                            <div className="space-y-4">
                                <div className={`h-6 w-3/4 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                <div className={`h-4 w-full rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                <div className={`h-4 w-full rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                <div className={`h-4 w-5/6 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                <div className={`h-4 w-full rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                                <div className={`h-4 w-4/5 rounded ${isDark ? 'skeleton-wave-dark' : 'skeleton-wave'} skeleton-fast`}></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

function AppContent() {
    const { isDark } = useTheme();

    return (
        <div className={`min-h-screen transition-colors duration-300 ${
            isDark ? 'bg-gray-900' : 'bg-white'
        }`}>
            <Header />
            <main>
                <Suspense fallback={<PageLoaderWrapper />}>
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
            <ScrollToTop />
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
