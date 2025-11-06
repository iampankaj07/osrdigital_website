import{j as e}from"./icons-BNKDixbA.js";import{c as h,r as o,L as l,N as y}from"./router-yBCHRFxk.js";import{u}from"./app-DDmhUdcp.js";import"./vendor-Bzgz95E1.js";/* empty css            */const w=()=>{const{slug:n}=h(),[a,m]=o.useState(null),[x,g]=o.useState(!0),[p,d]=o.useState(null),{isDark:t}=u();return o.useEffect(()=>{if(a){document.title=a.meta_title||a.title;const c=document.querySelector('meta[name="description"]');if(c)c.setAttribute("content",a.meta_description||a.excerpt||"");else{const s=document.createElement("meta");s.name="description",s.content=a.meta_description||a.excerpt||"",document.head.appendChild(s)}const r=document.querySelector('meta[property="og:title"]');if(r)r.setAttribute("content",a.title);else{const s=document.createElement("meta");s.setAttribute("property","og:title"),s.content=a.title,document.head.appendChild(s)}const i=document.querySelector('meta[property="og:description"]');if(i)i.setAttribute("content",a.excerpt||"");else{const s=document.createElement("meta");s.setAttribute("property","og:description"),s.content=a.excerpt||"",document.head.appendChild(s)}}},[a]),o.useEffect(()=>{n&&(async()=>{g(!0),d(null);try{let r;switch(n){case"privacy-policy":r=await fetch("/privacy-policy");break;case"terms-of-service":r=await fetch("/terms-of-service");break;case"cookies-policy":r=await fetch("/cookies-policy");break;default:r=await fetch(`/legal/${n}`)}if(!r.ok)throw new Error(`HTTP error! status: ${r.status}`);const i=await r.json();m(i.page)}catch(r){console.error("Error fetching legal page:",r),d(r.message)}finally{g(!1)}})()},[n]),x?e.jsx("div",{className:"min-h-screen flex items-center justify-center",children:e.jsxs("div",{className:"text-center",children:[e.jsx("div",{className:"animate-spin rounded-full h-12 w-12 border-b-2 border-brand-orange-500 mx-auto mb-4"}),e.jsx("p",{className:`text-lg ${t?"text-white":"text-gray-600"}`,children:"Loading..."})]})}):p?e.jsx("div",{className:"min-h-screen flex items-center justify-center",children:e.jsx("div",{className:"text-center max-w-md mx-auto px-4",children:e.jsxs("div",{className:"mb-6",children:[e.jsx("i",{className:"fas fa-exclamation-circle text-red-500 text-6xl mb-4"}),e.jsx("h1",{className:`text-3xl font-bold mb-4 ${t?"text-white":"text-gray-900"}`,children:"Page Not Found"}),e.jsx("p",{className:`text-lg mb-6 ${t?"text-gray-300":"text-gray-600"}`,children:"The legal page you're looking for doesn't exist or isn't available."}),e.jsxs(l,{to:"/",className:"inline-block bg-brand-orange-500 hover:bg-brand-orange-600 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200",children:[e.jsx("i",{className:"fas fa-home mr-2"}),"Return Home"]})]})})}):a?e.jsxs("div",{className:`min-h-screen ${t?"bg-gray-900":"bg-gray-50"}`,children:[e.jsx("section",{className:`py-16 md:py-24 ${t?"bg-gray-800":"bg-white"}`,children:e.jsx("div",{className:"max-w-4xl mx-auto px-4 sm:px-6 lg:px-8",children:e.jsxs("div",{className:"text-center mb-8",children:[e.jsx("h1",{className:`text-4xl md:text-5xl font-bold mb-6 ${t?"text-white":"text-gray-900"}`,children:a.title}),a.excerpt&&e.jsx("p",{className:`text-xl leading-relaxed ${t?"text-gray-300":"text-gray-600"}`,children:a.excerpt}),a.last_updated_at&&e.jsx("div",{className:`mt-6 pt-6 border-t ${t?"border-gray-700":"border-gray-200"}`,children:e.jsxs("p",{className:`text-sm ${t?"text-gray-400":"text-gray-500"}`,children:[e.jsx("i",{className:"fas fa-calendar-alt mr-2"}),"Last updated: ",a.last_updated_at]})})]})})}),e.jsx("section",{className:`py-16 ${t?"bg-gray-900":"bg-gray-50"}`,children:e.jsx("div",{className:"max-w-4xl mx-auto px-4 sm:px-6 lg:px-8",children:e.jsx("div",{className:`rounded-xl p-8 md:p-12 shadow-lg ${t?"bg-gray-800 text-gray-300":"bg-white text-gray-700"}`,children:e.jsx("div",{className:"prose prose-lg max-w-none legal-content",dangerouslySetInnerHTML:{__html:a.content},style:{lineHeight:"1.8",fontSize:"1.1rem"}})})})}),e.jsx("section",{className:`py-16 ${t?"bg-gray-800":"bg-white"}`,children:e.jsx("div",{className:"max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center",children:e.jsxs("div",{className:`p-8 rounded-xl ${t?"bg-gray-700":"bg-gray-50"}`,children:[e.jsx("h3",{className:`text-2xl font-bold mb-4 ${t?"text-white":"text-gray-900"}`,children:"Questions About This Policy?"}),e.jsx("p",{className:`text-lg mb-6 ${t?"text-gray-300":"text-gray-600"}`,children:"If you have any questions or concerns about this policy, please don't hesitate to contact us."}),e.jsxs(l,{to:"/contact",className:"inline-block bg-brand-orange-500 hover:bg-brand-orange-600 text-white font-medium py-3 px-8 rounded-lg transition-colors duration-200",children:[e.jsx("i",{className:"fas fa-envelope mr-2"}),"Contact Us"]})]})})}),e.jsx("section",{className:`py-8 border-t ${t?"bg-gray-900 border-gray-700":"bg-gray-50 border-gray-200"}`,children:e.jsx("div",{className:"max-w-4xl mx-auto px-4 sm:px-6 lg:px-8",children:e.jsxs("div",{className:"flex flex-wrap justify-center gap-4",children:[e.jsx(l,{to:"/privacy-policy",className:`px-4 py-2 rounded-lg transition-colors duration-200 ${n==="privacy-policy"?"bg-brand-orange-500 text-white":t?"bg-gray-800 text-gray-300 hover:bg-gray-700":"bg-white text-gray-700 hover:bg-gray-100"}`,children:"Privacy Policy"}),e.jsx(l,{to:"/terms-of-service",className:`px-4 py-2 rounded-lg transition-colors duration-200 ${n==="terms-of-service"?"bg-brand-orange-500 text-white":t?"bg-gray-800 text-gray-300 hover:bg-gray-700":"bg-white text-gray-700 hover:bg-gray-100"}`,children:"Terms of Service"}),e.jsx(l,{to:"/cookies-policy",className:`px-4 py-2 rounded-lg transition-colors duration-200 ${n==="cookies-policy"?"bg-brand-orange-500 text-white":t?"bg-gray-800 text-gray-300 hover:bg-gray-700":"bg-white text-gray-700 hover:bg-gray-100"}`,children:"Cookies Policy"})]})})}),e.jsx("style",{jsx:!0,children:`
                .legal-content h1,
                .legal-content h2,
                .legal-content h3,
                .legal-content h4,
                .legal-content h5,
                .legal-content h6 {
                    color: ${t?"#ffffff":"#1f2937"};
                    font-weight: 600;
                    margin-top: 2rem;
                    margin-bottom: 1rem;
                }

                .legal-content h1 { font-size: 2.25rem; }
                .legal-content h2 { font-size: 1.875rem; }
                .legal-content h3 { font-size: 1.5rem; }
                .legal-content h4 { font-size: 1.25rem; }
                .legal-content h5 { font-size: 1.125rem; }
                .legal-content h6 { font-size: 1rem; }

                .legal-content p {
                    margin-bottom: 1.5rem;
                    line-height: 1.8;
                }

                .legal-content ul,
                .legal-content ol {
                    margin: 1.5rem 0;
                    padding-left: 2rem;
                }

                .legal-content li {
                    margin-bottom: 0.75rem;
                    line-height: 1.7;
                }

                .legal-content strong {
                    font-weight: 600;
                    color: ${t?"#f9fafb":"#111827"};
                }

                .legal-content a {
                    color: #ea580c;
                    text-decoration: underline;
                    transition: color 0.2s;
                }

                .legal-content a:hover {
                    color: #c2410c;
                }

                .legal-content blockquote {
                    border-left: 4px solid #ea580c;
                    padding-left: 1.5rem;
                    margin: 1.5rem 0;
                    font-style: italic;
                    background: ${t?"#374151":"#f9fafb"};
                    padding: 1rem 1.5rem;
                    border-radius: 0.5rem;
                }
            `})]}):e.jsx(y,{to:"/404",replace:!0})};export{w as default};
