/**
 * Quill.js Configuration for OSR Digital News Editor
 * Custom configuration for rich text editing in news articles
 */

// Custom Quill configuration
window.QuillConfig = {
    // Default configuration
    default: {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                [{ 'align': [] }],
                ['link', 'image'],
                ['blockquote', 'code-block'],
                ['clean']
            ],
            keyboard: {
                bindings: {
                    // Custom keyboard shortcuts
                    'bold': {
                        key: 'B',
                        shortKey: true,
                        handler: function(range, context) {
                            this.format('bold', !this.getFormat(range)['bold']);
                        }
                    },
                    'italic': {
                        key: 'I',
                        shortKey: true,
                        handler: function(range, context) {
                            this.format('italic', !this.getFormat(range)['italic']);
                        }
                    }
                }
            }
        },
        placeholder: 'Write your news article content here...',
        formats: [
            'header', 'bold', 'italic', 'underline', 'strike',
            'color', 'background', 'list', 'bullet', 'indent',
            'align', 'link', 'image', 'blockquote', 'code-block'
        ]
    },

    // Initialize Quill editor
    init: function(selector, options = {}) {
        const config = { ...this.default, ...options };
        const quill = new Quill(selector, config);
        
        // Auto-sync with hidden textarea
        const textarea = document.getElementById('content');
        if (textarea) {
            quill.on('text-change', function() {
                textarea.value = quill.root.innerHTML;
            });
        }
        
        return quill;
    },

    // Custom toolbar handlers
    handlers: {
        // Custom image handler for better integration
        image: function() {
            const input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/png, image/jpeg, image/jpg, image/gif');
            input.click();

            input.onchange = function() {
                const file = input.files[0];
                if (file) {
                    // You can add custom image upload logic here
                    // For now, we'll use the default behavior
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const range = this.quill.getSelection();
                        this.quill.insertEmbed(range.index, 'image', e.target.result);
                    }.bind(this);
                    reader.readAsDataURL(file);
                }
            }.bind(this);
        }
    }
};

// Add custom handlers to Quill
if (typeof Quill !== 'undefined') {
    // Only register if not already registered
    if (!Quill.imports['modules/toolbar']) {
        Quill.register('modules/toolbar', Quill.import('modules/toolbar'));
    }
    
    // Override the default image handler
    const toolbar = Quill.import('modules/toolbar');
    if (toolbar && toolbar.DEFAULTS && toolbar.DEFAULTS.handlers) {
        toolbar.DEFAULTS.handlers.image = window.QuillConfig.handlers.image;
    }
}
