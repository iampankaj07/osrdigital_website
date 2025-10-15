import React from 'react';
import { useState, useEffect } from 'react';
import { useTheme } from '../contexts/ThemeContext';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faEnvelope, faPhone, faMapMarkerAlt, faPaperPlane, faCheckCircle, faExclamationCircle } from '@fortawesome/free-solid-svg-icons';

function Contact() {
    const { isDark } = useTheme();
    const [isVisible, setIsVisible] = useState(false);
    const [formData, setFormData] = useState({
        name: '',
        email: '',
        company: '',
        phone: '',
        subject: '',
        message: '',
        inquiryType: 'general'
    });
    const [isSubmitting, setIsSubmitting] = useState(false);
    const [submitStatus, setSubmitStatus] = useState(null);
    const [contactData, setContactData] = useState(null);

    useEffect(() => {
        setIsVisible(true);
        document.title = "Contact Us - OSR Digital";
        let metaDescription = document.querySelector('meta[name="description"]');
        if (!metaDescription) {
            metaDescription = document.createElement('meta');
            metaDescription.name = 'description';
            document.getElementsByTagName('head')[0].appendChild(metaDescription);
        }
        metaDescription.content = "Get in touch with OSR Digital. Contact our team for content distribution, partnership opportunities, and media inquiries.";
    }, []);

    useEffect(() => {
        const fetchContactData = async () => {
            try {
                const response = await fetch('/api/contact-page');
                const data = await response.json();
                if (data.success) {
                    setContactData(data.data);
                }
            } catch (error) {
                console.error('Error fetching contact data:', error);
            }
        };

        fetchContactData();
    }, []);

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({
            ...prev,
            [name]: value
        }));
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setIsSubmitting(true);
        setSubmitStatus(null);

        try {
            // Simulate API call
            // Removed artificial delay for faster response

            // Reset form
            setFormData({
                name: '',
                email: '',
                company: '',
                phone: '',
                subject: '',
                message: '',
                inquiryType: 'general'
            });

            setSubmitStatus({ type: 'success', message: 'Message sent successfully! We\'ll get back to you soon.' });
        } catch (error) {
            setSubmitStatus({ type: 'error', message: 'There was an error sending your message. Please try again.' });
        } finally {
            setIsSubmitting(false);
        }
    };

    return (
        <div className={`min-h-screen transition-colors duration-300 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
            {/* Hero Section - Same as Portfolio */}
            <section className={`py-20 pt-32 ${isDark ? 'bg-gray-900' : 'bg-gray-50'}`}>
                <div className="container-minimal">
                    <div className="text-center max-w-4xl mx-auto">
                        <div className={`transition-all duration-1000 ${isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'}`}>
                            {/* Badge/Subtitle */}
                            <div className="mb-6">
                                <div className={`inline-flex items-center px-4 py-2 rounded-full text-sm font-medium ${
                                    isDark ? 'bg-gray-800 text-gray-300' : 'bg-gray-100 text-gray-600'
                                }`}>
                                    <div className="w-2 h-2 rounded-full bg-brand-orange-500 mr-2"></div>
                                    {contactData?.hero?.subtitle || 'Get In Touch'}
                                </div>
                            </div>

                            {/* Main Title */}
                            <div className="mb-8">
                                <h1 className={`text-3xl md:text-4xl lg:text-5xl font-bold mb-4 leading-tight ${
                                    isDark ? 'text-white' : 'text-gray-900'
                                }`}>
                                    {contactData?.hero?.title || 'Contact Us'}
                                </h1>
                                <div className={`text-lg md:text-xl leading-relaxed max-w-3xl mx-auto ${
                                    isDark ? 'text-gray-300' : 'text-gray-600'
                                }`}>
                                    {contactData?.hero?.description || 'Get in touch with our team. We\'d love to hear from you and discuss how we can help.'}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* Contact Form Section - Full Width */}
            <section id="contact-form" className={`py-16 md:py-24 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                <div className="container-minimal">
                    <div className="max-w-4xl mx-auto">
                        <div className="text-center mb-16">
                            <h2 className={`text-4xl font-extrabold mb-4 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                {contactData?.form?.title || 'Send us a Message'}
                            </h2>
                            <p className={`text-xl ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                                {contactData?.form?.description || 'Fill out the form below and we\'ll get back to you within 24 hours'}
                            </p>
                        </div>

                        <div className={`p-8 rounded-2xl ${isDark ? 'bg-gray-800' : 'bg-white border border-gray-200'}`}>
                            <form onSubmit={handleSubmit} className="space-y-6">
                                <div className="grid md:grid-cols-2 gap-6">
                                    <div>
                                        <label className={`block text-sm font-medium mb-2 ${isDark ? 'text-gray-300' : 'text-gray-700'}`}>
                                            Full Name *
                                        </label>
                                        <input
                                            type="text"
                                            name="name"
                                            value={formData.name}
                                            onChange={handleInputChange}
                                            required
                                            className={`w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-brand-orange-500 ${
                                                isDark
                                                    ? 'bg-gray-700 border-gray-600 text-white'
                                                    : 'bg-white border-gray-300 text-gray-900'
                                            }`}
                                            placeholder="Your full name"
                                        />
                                    </div>
                                    <div>
                                        <label className={`block text-sm font-medium mb-2 ${isDark ? 'text-gray-300' : 'text-gray-700'}`}>
                                            Email Address *
                                        </label>
                                        <input
                                            type="email"
                                            name="email"
                                            value={formData.email}
                                            onChange={handleInputChange}
                                            required
                                            className={`w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-brand-orange-500 ${
                                                isDark
                                                    ? 'bg-gray-700 border-gray-600 text-white'
                                                    : 'bg-white border-gray-300 text-gray-900'
                                            }`}
                                            placeholder="your@email.com"
                                        />
                                    </div>
                                </div>

                                <div className="grid md:grid-cols-2 gap-6">
                                    <div>
                                        <label className={`block text-sm font-medium mb-2 ${isDark ? 'text-gray-300' : 'text-gray-700'}`}>
                                            Company
                                        </label>
                                        <input
                                            type="text"
                                            name="company"
                                            value={formData.company}
                                            onChange={handleInputChange}
                                            className={`w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-brand-orange-500 ${
                                                isDark
                                                    ? 'bg-gray-700 border-gray-600 text-white'
                                                    : 'bg-white border-gray-300 text-gray-900'
                                            }`}
                                            placeholder="Your company name"
                                        />
                                    </div>
                                    <div>
                                        <label className={`block text-sm font-medium mb-2 ${isDark ? 'text-gray-300' : 'text-gray-700'}`}>
                                            Phone Number
                                        </label>
                                        <input
                                            type="tel"
                                            name="phone"
                                            value={formData.phone}
                                            onChange={handleInputChange}
                                            className={`w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-brand-orange-500 ${
                                                isDark
                                                    ? 'bg-gray-700 border-gray-600 text-white'
                                                    : 'bg-white border-gray-300 text-gray-900'
                                            }`}
                                            placeholder="+1 (555) 123-4567"
                                        />
                                    </div>
                                </div>

                                <div>
                                    <label className={`block text-sm font-medium mb-2 ${isDark ? 'text-gray-300' : 'text-gray-700'}`}>
                                        Inquiry Type *
                                    </label>
                                    <select
                                        name="inquiryType"
                                        value={formData.inquiryType}
                                        onChange={handleInputChange}
                                        required
                                        className={`w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-brand-orange-500 ${
                                            isDark
                                                ? 'bg-gray-700 border-gray-600 text-white'
                                                : 'bg-white border-gray-300 text-gray-900'
                                        }`}
                                    >
                                        <option value="general">General Inquiry</option>
                                        <option value="partnership">Partnership Opportunity</option>
                                        <option value="distribution">Content Distribution</option>
                                        <option value="licensing">Content Licensing</option>
                                        <option value="support">Technical Support</option>
                                        <option value="press">Press & Media</option>
                                    </select>
                                </div>

                                <div>
                                    <label className={`block text-sm font-medium mb-2 ${isDark ? 'text-gray-300' : 'text-gray-700'}`}>
                                        Subject *
                                    </label>
                                    <input
                                        type="text"
                                        name="subject"
                                        value={formData.subject}
                                        onChange={handleInputChange}
                                        required
                                        className={`w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-brand-orange-500 ${
                                            isDark
                                                ? 'bg-gray-700 border-gray-600 text-white'
                                                : 'bg-white border-gray-300 text-gray-900'
                                        }`}
                                        placeholder="What's this about?"
                                    />
                                </div>

                                <div>
                                    <label className={`block text-sm font-medium mb-2 ${isDark ? 'text-gray-300' : 'text-gray-700'}`}>
                                        Message *
                                    </label>
                                    <textarea
                                        name="message"
                                        value={formData.message}
                                        onChange={handleInputChange}
                                        required
                                        rows="6"
                                        className={`w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-brand-orange-500 resize-none ${
                                            isDark
                                                ? 'bg-gray-700 border-gray-600 text-white'
                                                : 'bg-white border-gray-300 text-gray-900'
                                        }`}
                                        placeholder="Tell us more about your inquiry..."
                                    />
                                </div>

                                {submitStatus && (
                                    <div className={`p-4 rounded-lg flex items-center ${
                                        submitStatus.type === 'success'
                                            ? 'bg-green-100 text-green-800 border border-green-200'
                                            : 'bg-red-100 text-red-800 border border-red-200'
                                    }`}>
                                        <FontAwesomeIcon
                                            icon={submitStatus.type === 'success' ? faCheckCircle : faExclamationCircle}
                                            className="mr-2"
                                        />
                                        {submitStatus.message}
                                    </div>
                                )}

                                <button
                                    type="submit"
                                    disabled={isSubmitting}
                                    className={`w-full bg-brand-orange-500 hover:bg-brand-orange-600 text-white font-semibold py-3 px-6 rounded-lg transition-colors flex items-center justify-center ${
                                        isSubmitting ? 'opacity-50 cursor-not-allowed' : ''
                                    }`}
                                >
                                    {isSubmitting ? (
                                        <>
                                            <div className="animate-spin rounded-full h-5 w-5 border-b-2 border-white mr-2"></div>
                                            Sending...
                                        </>
                                    ) : (
                                        <>
                                            <FontAwesomeIcon icon={faPaperPlane} className="mr-2" />
                                            Send Message
                                        </>
                                    )}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    );
}

export default Contact;
