import { useState, useEffect } from 'react';
import { useTheme } from '../contexts/ThemeContext';
import { Link } from 'react-router-dom';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faEnvelope, faPhone, faMapMarkerAlt, faClock, faUser, faMessage, faPaperPlane, faHeadset, faGlobe, faBuilding, faChevronRight, faCheckCircle, faExclamationCircle } from '@fortawesome/free-solid-svg-icons';
import { faLinkedin, faTwitter, faInstagram, faYoutube } from '@fortawesome/free-brands-svg-icons';

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

    useEffect(() => {
        setIsVisible(true);
        document.title = "Contact Us - OSR Digital";
        let metaDescription = document.querySelector('meta[name="description"]');
        if (!metaDescription) {
            metaDescription = document.createElement('meta');
            metaDescription.name = 'description';
            document.getElementsByTagName('head')[0].appendChild(metaDescription);
        }
        metaDescription.content = "Get in touch with OSR Digital. Contact our team for content distribution, partnership opportunities, and media inquiries. We're here to help bring your content to global audiences.";
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
            await new Promise(resolve => setTimeout(resolve, 2000));
            
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
            
            setSubmitStatus('success');
        } catch (error) {
            setSubmitStatus('error');
        } finally {
            setIsSubmitting(false);
        }
    };

    const contactInfo = [
        {
            icon: faEnvelope,
            title: "Email Us",
            details: "hello@osrdigital.com",
            description: "Send us an email anytime",
            action: "mailto:hello@osrdigital.com"
        },
        {
            icon: faPhone,
            title: "Call Us",
            details: "+1 (555) 123-4567",
            description: "Mon-Fri 9AM-6PM PST",
            action: "tel:+15551234567"
        },
        {
            icon: faMapMarkerAlt,
            title: "Visit Us",
            details: "Los Angeles, CA",
            description: "Schedule a meeting",
            action: "#"
        },
        {
            icon: faClock,
            title: "Response Time",
            details: "Within 24 hours",
            description: "We'll get back to you quickly",
            action: "#"
        }
    ];

    const inquiryTypes = [
        { value: 'general', label: 'General Inquiry' },
        { value: 'partnership', label: 'Partnership Opportunity' },
        { value: 'content', label: 'Content Distribution' },
        { value: 'media', label: 'Media Inquiry' },
        { value: 'support', label: 'Technical Support' },
        { value: 'careers', label: 'Career Opportunities' }
    ];

    const offices = [
        {
            city: "Los Angeles",
            country: "United States",
            address: "1234 Sunset Boulevard, Suite 100",
            cityState: "Los Angeles, CA 90028",
            phone: "+1 (555) 123-4567",
            email: "la@osrdigital.com",
            hours: "Mon-Fri: 9AM-6PM PST"
        },
        {
            city: "New York",
            country: "United States", 
            address: "567 Broadway, Floor 15",
            cityState: "New York, NY 10012",
            phone: "+1 (555) 987-6543",
            email: "ny@osrdigital.com",
            hours: "Mon-Fri: 9AM-6PM EST"
        },
        {
            city: "London",
            country: "United Kingdom",
            address: "89 Piccadilly, Office 200",
            cityState: "London W1J 0LL",
            phone: "+44 20 7123 4567",
            email: "london@osrdigital.com",
            hours: "Mon-Fri: 9AM-6PM GMT"
        }
    ];

    const socialLinks = [
        { platform: 'LinkedIn', icon: faLinkedin, url: 'https://linkedin.com/company/osrdigital' },
        { platform: 'Twitter', icon: faTwitter, url: 'https://twitter.com/osrdigital' },
        { platform: 'Instagram', icon: faInstagram, url: 'https://instagram.com/osrdigital' },
        { platform: 'YouTube', icon: faYoutube, url: 'https://youtube.com/@osrdigital' }
    ];

    return (
        <div className={`min-h-screen transition-colors duration-300 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
            {/* Hero Section */}
            <section className={`min-h-screen flex items-center justify-center pt-16 md:pt-20 lg:pt-24 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                <div className="container-minimal">
                    <div className="text-center max-w-4xl mx-auto">
                        <div className={`transition-all duration-1000 ${isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'}`}>
                            {/* Badge */}
                            <div className="mb-8">
                                <div className={`inline-flex items-center px-4 py-2 rounded-full text-sm font-medium ${
                                    isDark ? 'bg-gray-800 text-gray-300' : 'bg-gray-100 text-gray-600'
                                }`}>
                                    <div className="w-2 h-2 rounded-full bg-gray-400 mr-2"></div>
                                    Get In Touch
                                </div>
                            </div>

                            {/* Main Content */}
                            <div className="mb-12">
                                <h1 className={`text-4xl md:text-6xl lg:text-7xl font-bold mb-8 leading-tight text-minimal-bold ${
                                    isDark ? 'text-white' : 'text-gray-900'
                                }`}>
                                    Let's
                                    <span className={`block bg-gradient-to-r from-brand-orange-500 to-red-600 bg-clip-text text-transparent`}>
                                        Connect
                                    </span>
                                </h1>
                                <p className={`text-xl md:text-2xl mb-10 leading-relaxed text-minimal ${
                                    isDark ? 'text-gray-300' : 'text-gray-600'
                                }`}>
                                    Ready to bring your content to global audiences? Get in touch with our team and let's discuss how we can help you achieve your distribution goals.
                                </p>
                            </div>

                            {/* CTA Buttons */}
                            <div className="flex flex-col sm:flex-row gap-4 justify-center items-center">
                                <a
                                    href="#contact-form"
                                    className="btn-minimal"
                                >
                                    Send Message
                                </a>
                                <a
                                    href="tel:+15551234567"
                                    className="btn-minimal-outline"
                                >
                                    Call Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* Contact Information Cards */}
            <section className={`py-16 md:py-24 ${isDark ? 'bg-gray-800' : 'bg-gray-50'}`}>
                <div className="container-minimal">
                    <div className="text-center mb-16">
                        <h2 className={`text-4xl font-extrabold mb-4 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                            Get In Touch
                        </h2>
                        <p className={`text-xl ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                            Choose the best way to reach us
                        </p>
                    </div>

                    <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                        {contactInfo.map((info, index) => (
                            <a
                                key={index}
                                href={info.action}
                                className={`p-8 rounded-xl text-center transition-all duration-300 hover:shadow-lg ${
                                    isDark ? 'bg-gray-700 hover:bg-gray-600' : 'bg-white hover:bg-gray-50'
                                }`}
                            >
                                <div className={`text-4xl mb-4 ${isDark ? 'text-brand-orange-400' : 'text-brand-orange-600'}`}>
                                    <FontAwesomeIcon icon={info.icon} />
                                </div>
                                <h3 className={`text-xl font-semibold mb-2 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                    {info.title}
                                </h3>
                                <p className={`text-lg font-medium mb-2 ${isDark ? 'text-brand-orange-400' : 'text-brand-orange-600'}`}>
                                    {info.details}
                                </p>
                                <p className={`text-sm ${isDark ? 'text-gray-400' : 'text-gray-600'}`}>
                                    {info.description}
                                </p>
                            </a>
                        ))}
                    </div>
                </div>
            </section>

            {/* Contact Form Section */}
            <section id="contact-form" className={`py-16 md:py-24 ${isDark ? 'bg-gray-900' : 'bg-white'}`}>
                <div className="container-minimal">
                    <div className="max-w-4xl mx-auto">
                        <div className="text-center mb-16">
                            <h2 className={`text-4xl font-extrabold mb-4 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                Send us a Message
                            </h2>
                            <p className={`text-xl ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                                Fill out the form below and we'll get back to you within 24 hours
                            </p>
                        </div>

                        <div className="grid lg:grid-cols-2 gap-12">
                            {/* Contact Form */}
                            <div className={`p-8 rounded-2xl ${isDark ? 'bg-gray-800' : 'bg-gray-50'}`}>
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
                                            {inquiryTypes.map((type) => (
                                                <option key={type.value} value={type.value}>
                                                    {type.label}
                                                </option>
                                            ))}
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
                                            rows={6}
                                            className={`w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-brand-orange-500 resize-none ${
                                                isDark 
                                                    ? 'bg-gray-700 border-gray-600 text-white' 
                                                    : 'bg-white border-gray-300 text-gray-900'
                                            }`}
                                            placeholder="Tell us more about your project or inquiry..."
                                        />
                                    </div>

                                    {submitStatus === 'success' && (
                                        <div className="flex items-center p-4 bg-green-100 text-green-700 rounded-lg">
                                            <FontAwesomeIcon icon={faCheckCircle} className="mr-2" />
                                            Message sent successfully! We'll get back to you soon.
                                        </div>
                                    )}

                                    {submitStatus === 'error' && (
                                        <div className="flex items-center p-4 bg-red-100 text-red-700 rounded-lg">
                                            <FontAwesomeIcon icon={faExclamationCircle} className="mr-2" />
                                            There was an error sending your message. Please try again.
                                        </div>
                                    )}

                                    <button
                                        type="submit"
                                        disabled={isSubmitting}
                                        className={`w-full py-4 px-6 rounded-lg font-semibold text-white transition-all duration-200 flex items-center justify-center ${
                                            isSubmitting
                                                ? 'bg-gray-400 cursor-not-allowed'
                                                : 'bg-brand-orange-500 hover:bg-brand-orange-600'
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

                            {/* Contact Information */}
                            <div className="space-y-8">
                                <div className={`p-8 rounded-2xl ${isDark ? 'bg-gray-800' : 'bg-gray-50'}`}>
                                    <h3 className={`text-2xl font-bold mb-6 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                        Why Choose OSR Digital?
                                    </h3>
                                    <div className="space-y-4">
                                        <div className="flex items-start">
                                            <div className={`w-8 h-8 rounded-full flex items-center justify-center mr-4 ${
                                                isDark ? 'bg-brand-orange-500/20' : 'bg-brand-orange-100'
                                            }`}>
                                                <FontAwesomeIcon icon={faGlobe} className={`text-sm ${isDark ? 'text-brand-orange-400' : 'text-brand-orange-600'}`} />
                                            </div>
                                            <div>
                                                <h4 className={`font-semibold ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                                    Global Reach
                                                </h4>
                                                <p className={`text-sm ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                                                    Distribute content to 200+ countries worldwide
                                                </p>
                                            </div>
                                        </div>
                                        <div className="flex items-start">
                                            <div className={`w-8 h-8 rounded-full flex items-center justify-center mr-4 ${
                                                isDark ? 'bg-brand-orange-500/20' : 'bg-brand-orange-100'
                                            }`}>
                                                <FontAwesomeIcon icon={faHeadset} className={`text-sm ${isDark ? 'text-brand-orange-400' : 'text-brand-orange-600'}`} />
                                            </div>
                                            <div>
                                                <h4 className={`font-semibold ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                                    Expert Support
                                                </h4>
                                                <p className={`text-sm ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                                                    Dedicated team to help you succeed
                                                </p>
                                            </div>
                                        </div>
                                        <div className="flex items-start">
                                            <div className={`w-8 h-8 rounded-full flex items-center justify-center mr-4 ${
                                                isDark ? 'bg-brand-orange-500/20' : 'bg-brand-orange-100'
                                            }`}>
                                                <FontAwesomeIcon icon={faBuilding} className={`text-sm ${isDark ? 'text-brand-orange-400' : 'text-brand-orange-600'}`} />
                                            </div>
                                            <div>
                                                <h4 className={`font-semibold ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                                    Industry Experience
                                                </h4>
                                                <p className={`text-sm ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                                                    Years of expertise in content distribution
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div className={`p-8 rounded-2xl ${isDark ? 'bg-gray-800' : 'bg-gray-50'}`}>
                                    <h3 className={`text-2xl font-bold mb-6 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                        Follow Us
                                    </h3>
                                    <div className="flex space-x-4">
                                        {socialLinks.map((social, index) => (
                                            <a
                                                key={index}
                                                href={social.url}
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                className={`w-12 h-12 rounded-full flex items-center justify-center transition-colors ${
                                                    isDark 
                                                        ? 'bg-gray-700 text-gray-300 hover:bg-brand-orange-500 hover:text-white' 
                                                        : 'bg-gray-200 text-gray-600 hover:bg-brand-orange-500 hover:text-white'
                                                }`}
                                            >
                                                <FontAwesomeIcon icon={social.icon} />
                                            </a>
                                        ))}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* Office Locations */}
            <section className={`py-16 md:py-24 ${isDark ? 'bg-gray-800' : 'bg-gray-50'}`}>
                <div className="container-minimal">
                    <div className="text-center mb-16">
                        <h2 className={`text-4xl font-extrabold mb-4 ${isDark ? 'text-white' : 'text-gray-900'}`}>
                            Our Offices
                        </h2>
                        <p className={`text-xl ${isDark ? 'text-gray-300' : 'text-gray-600'}`}>
                            Visit us at any of our global locations
                        </p>
                    </div>

                    <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                        {offices.map((office, index) => (
                            <div key={index} className={`p-8 rounded-2xl ${isDark ? 'bg-gray-700' : 'bg-white'}`}>
                                <div className="flex items-center mb-6">
                                    <div className={`w-12 h-12 rounded-full flex items-center justify-center mr-4 ${
                                        isDark ? 'bg-brand-orange-500/20' : 'bg-brand-orange-100'
                                    }`}>
                                        <FontAwesomeIcon icon={faMapMarkerAlt} className={`text-xl ${isDark ? 'text-brand-orange-400' : 'text-brand-orange-600'}`} />
                                    </div>
                                    <div>
                                        <h3 className={`text-xl font-bold ${isDark ? 'text-white' : 'text-gray-900'}`}>
                                            {office.city}
                                        </h3>
                                        <p className={`text-sm ${isDark ? 'text-gray-400' : 'text-gray-600'}`}>
                                            {office.country}
                                        </p>
                                    </div>
                                </div>

                                <div className="space-y-3">
                                    <div className="flex items-start">
                                        <FontAwesomeIcon icon={faMapMarkerAlt} className={`w-4 h-4 mt-1 mr-3 ${isDark ? 'text-gray-400' : 'text-gray-600'}`} />
                                        <div>
                                            <p className={`text-sm ${isDark ? 'text-gray-300' : 'text-gray-700'}`}>
                                                {office.address}
                                            </p>
                                            <p className={`text-sm ${isDark ? 'text-gray-400' : 'text-gray-600'}`}>
                                                {office.cityState}
                                            </p>
                                        </div>
                                    </div>
                                    <div className="flex items-center">
                                        <FontAwesomeIcon icon={faPhone} className={`w-4 h-4 mr-3 ${isDark ? 'text-gray-400' : 'text-gray-600'}`} />
                                        <a href={`tel:${office.phone}`} className={`text-sm hover:text-brand-orange-500 ${isDark ? 'text-gray-300' : 'text-gray-700'}`}>
                                            {office.phone}
                                        </a>
                                    </div>
                                    <div className="flex items-center">
                                        <FontAwesomeIcon icon={faEnvelope} className={`w-4 h-4 mr-3 ${isDark ? 'text-gray-400' : 'text-gray-600'}`} />
                                        <a href={`mailto:${office.email}`} className={`text-sm hover:text-brand-orange-500 ${isDark ? 'text-gray-300' : 'text-gray-700'}`}>
                                            {office.email}
                                        </a>
                                    </div>
                                    <div className="flex items-center">
                                        <FontAwesomeIcon icon={faClock} className={`w-4 h-4 mr-3 ${isDark ? 'text-gray-400' : 'text-gray-600'}`} />
                                        <p className={`text-sm ${isDark ? 'text-gray-300' : 'text-gray-700'}`}>
                                            {office.hours}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            {/* CTA Section */}
            <section className={`py-16 md:py-24 bg-gradient-to-br ${isDark ? 'from-gray-900 to-gray-800' : 'from-brand-orange-500 to-red-600'}`}>
                <div className="container-minimal text-center max-w-4xl mx-auto">
                    <h2 className={`text-4xl font-extrabold mb-6 ${isDark ? 'text-white' : 'text-white'}`}>
                        Ready to Get Started?
                    </h2>
                    <p className={`text-xl mb-10 ${isDark ? 'text-gray-300' : 'text-brand-orange-100'}`}>
                        Join hundreds of content creators and distributors who trust OSR Digital to bring their content to global audiences.
                    </p>
                    <div className="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <a href="#contact-form" className="btn-minimal">
                            Start Your Journey
                        </a>
                        <Link to="/about" className="btn-minimal-outline">
                            Learn More About Us
                        </Link>
                    </div>
                </div>
            </section>
        </div>
    );
}

export default Contact;