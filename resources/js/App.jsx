import { lazy, Suspense } from 'react';
import { Navigate, Route, Routes } from 'react-router-dom';
import Layout from './components/layout/Layout';
import Home from './pages/Home';

const About = lazy(() => import('./pages/About'));
const Blog = lazy(() => import('./pages/Blog'));
const BlogDetail = lazy(() => import('./pages/BlogDetail'));
const Contact = lazy(() => import('./pages/Contact'));
const Faq = lazy(() => import('./pages/Faq'));
const NotFound = lazy(() => import('./pages/NotFound'));
const Portfolio = lazy(() => import('./pages/Portfolio'));
const Pricing = lazy(() => import('./pages/Pricing'));
const ProjectDetail = lazy(() => import('./pages/ProjectDetail'));
const ServiceDetail = lazy(() => import('./pages/ServiceDetail'));
const Services = lazy(() => import('./pages/Services'));
const Team = lazy(() => import('./pages/Team'));

/*
 | Paths mirror the named Laravel routes in routes/web.php one-to-one, so a
 | hard refresh, the sitemap, and admin-managed SEO/redirects all line up.
 */
export default function App() {
    return (
        <Suspense fallback={<div className="min-h-screen bg-background" />}>
            <Routes>
                <Route element={<Layout />}>
                    <Route index element={<Home />} />
                    <Route path="about" element={<About />} />
                    <Route path="service" element={<Services />} />
                    <Route path="services/:slug" element={<ServiceDetail />} />
                    <Route path="service-details" element={<Navigate to="/service" replace />} />
                    <Route path="blog" element={<Blog />} />
                    <Route path="blog-details/:slug" element={<BlogDetail />} />
                    <Route path="project" element={<Portfolio />} />
                    <Route path="project-details" element={<ProjectDetail />} />
                    <Route path="pricing" element={<Pricing />} />
                    <Route path="faq" element={<Faq />} />
                    <Route path="team" element={<Team />} />
                    <Route path="team-details" element={<Team />} />
                    <Route path="contact" element={<Contact />} />
                    <Route path="*" element={<NotFound />} />
                </Route>
            </Routes>
        </Suspense>
    );
}
