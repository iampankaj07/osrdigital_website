import React from 'react';

function MapSection() {
    return (
        <section className="w-full bg-gray-100">
            <div className="w-full" style={{ height: '450px' }}>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3532.452544419239!2d85.32644507618737!3d27.703310476184992!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb19a3efd6608b%3A0x84a682e2d161a5d6!2sOSR%20Digital!5e0!3m2!1sen!2sfi!4v1762545322817!5m2!1sen!2sfi"
                    width="100%"
                    height="100%"
                    style={{ border: 'none', display: 'block' }}
                    allowFullScreen=""
                    loading="lazy"
                    referrerPolicy="no-referrer-when-downgrade"
                    title="OSR Digital Location"
                ></iframe>
            </div>
        </section>
    );
}

export default MapSection;
