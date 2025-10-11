/**
 * Skeleton Loader Utility
 * Provides functions to show/hide skeleton loaders and create skeleton components
 */

class SkeletonLoader {
    constructor() {
        this.activeLoaders = new Set();
    }

    /**
     * Show skeleton loader
     * @param {string} elementId - ID of the element to show skeleton for
     * @param {string} skeletonType - Type of skeleton to show
     * @param {Object} options - Additional options
     */
    show(elementId, skeletonType = 'default', options = {}) {
        const element = document.getElementById(elementId);
        if (!element) {
            console.warn(`Element with ID '${elementId}' not found`);
            return;
        }

        // Store original content
        if (!element.dataset.originalContent) {
            element.dataset.originalContent = element.innerHTML;
        }

        // Hide original content
        element.style.display = 'none';

        // Create skeleton container
        const skeletonContainer = document.createElement('div');
        skeletonContainer.id = `${elementId}-skeleton`;
        skeletonContainer.className = 'skeleton-container';

        // Generate skeleton content based on type
        skeletonContainer.innerHTML = this.generateSkeleton(skeletonType, options);

        // Insert skeleton after original element
        element.parentNode.insertBefore(skeletonContainer, element.nextSibling);

        // Track active loader
        this.activeLoaders.add(elementId);
    }

    /**
     * Hide skeleton loader
     * @param {string} elementId - ID of the element to hide skeleton for
     */
    hide(elementId) {
        const element = document.getElementById(elementId);
        const skeletonContainer = document.getElementById(`${elementId}-skeleton`);

        if (!element || !skeletonContainer) {
            console.warn(`Skeleton loader for '${elementId}' not found`);
            return;
        }

        // Remove skeleton container
        skeletonContainer.remove();

        // Show original content
        element.style.display = '';

        // Remove from active loaders
        this.activeLoaders.delete(elementId);
    }

    /**
     * Toggle skeleton loader
     * @param {string} elementId - ID of the element to toggle skeleton for
     * @param {boolean} show - Whether to show or hide skeleton
     * @param {string} skeletonType - Type of skeleton to show
     * @param {Object} options - Additional options
     */
    toggle(elementId, show, skeletonType = 'default', options = {}) {
        if (show) {
            this.show(elementId, skeletonType, options);
        } else {
            this.hide(elementId);
        }
    }

    /**
     * Show skeleton for multiple elements
     * @param {Array} elements - Array of element configurations
     */
    showMultiple(elements) {
        elements.forEach(({ id, type = 'default', options = {} }) => {
            this.show(id, type, options);
        });
    }

    /**
     * Hide skeleton for multiple elements
     * @param {Array} elementIds - Array of element IDs
     */
    hideMultiple(elementIds) {
        elementIds.forEach(id => {
            this.hide(id);
        });
    }

    /**
     * Generate skeleton HTML based on type
     * @param {string} type - Type of skeleton
     * @param {Object} options - Additional options
     * @returns {string} HTML string
     */
    generateSkeleton(type, options = {}) {
        const generators = {
            'table': () => this.generateTableSkeleton(options),
            'card': () => this.generateCardSkeleton(options),
            'list': () => this.generateListSkeleton(options),
            'form': () => this.generateFormSkeleton(options),
            'stats': () => this.generateStatsSkeleton(options),
            'navigation': () => this.generateNavigationSkeleton(options),
            'content': () => this.generateContentSkeleton(options),
            'modal': () => this.generateModalSkeleton(options),
            'filepond': () => this.generateFilePondSkeleton(options),
            'quill': () => this.generateQuillSkeleton(options),
            'tabs': () => this.generateTabsSkeleton(options),
            'pagination': () => this.generatePaginationSkeleton(options),
            'default': () => this.generateDefaultSkeleton(options)
        };

        const generator = generators[type] || generators['default'];
        return generator();
    }

    /**
     * Generate table skeleton
     */
    generateTableSkeleton(options = {}) {
        const rows = options.rows || 5;
        const cols = options.cols || 4;
        
        let tableHTML = '<table class="skeleton-table w-full">';
        
        // Header
        tableHTML += '<thead><tr>';
        for (let i = 0; i < cols; i++) {
            tableHTML += '<th><div class="skeleton-text short"></div></th>';
        }
        tableHTML += '</tr></thead>';
        
        // Body
        tableHTML += '<tbody>';
        for (let i = 0; i < rows; i++) {
            tableHTML += '<tr>';
            for (let j = 0; j < cols; j++) {
                tableHTML += '<td><div class="skeleton-text medium"></div></td>';
            }
            tableHTML += '</tr>';
        }
        tableHTML += '</tbody></table>';
        
        return tableHTML;
    }

    /**
     * Generate card skeleton
     */
    generateCardSkeleton(options = {}) {
        return `
            <div class="skeleton-card">
                <div class="skeleton-title"></div>
                <div class="skeleton-text long"></div>
                <div class="skeleton-text medium"></div>
                <div class="skeleton-text short"></div>
                <div class="flex justify-between items-center mt-4">
                    <div class="skeleton-button"></div>
                    <div class="skeleton-badge"></div>
                </div>
            </div>
        `;
    }

    /**
     * Generate list skeleton
     */
    generateListSkeleton(options = {}) {
        const items = options.items || 5;
        let listHTML = '<div class="skeleton-list">';
        
        for (let i = 0; i < items; i++) {
            listHTML += `
                <div class="skeleton-list-item">
                    <div class="skeleton-avatar"></div>
                    <div class="skeleton-content">
                        <div class="skeleton-text long"></div>
                        <div class="skeleton-text medium"></div>
                    </div>
                </div>
            `;
        }
        
        listHTML += '</div>';
        return listHTML;
    }

    /**
     * Generate form skeleton
     */
    generateFormSkeleton(options = {}) {
        const fields = options.fields || 5;
        let formHTML = '<div class="space-y-6">';
        
        for (let i = 0; i < fields; i++) {
            formHTML += `
                <div class="skeleton-form-group">
                    <div class="skeleton-text short"></div>
                    <div class="skeleton-input"></div>
                </div>
            `;
        }
        
        formHTML += `
            <div class="flex justify-end space-x-3">
                <div class="skeleton-button"></div>
                <div class="skeleton-button"></div>
            </div>
        </div>`;
        
        return formHTML;
    }

    /**
     * Generate stats skeleton
     */
    generateStatsSkeleton(options = {}) {
        const cards = options.cards || 4;
        let statsHTML = '<div class="skeleton-stats">';
        
        for (let i = 0; i < cards; i++) {
            statsHTML += `
                <div class="skeleton-stat-card">
                    <div class="skeleton-text short"></div>
                    <div class="skeleton-title"></div>
                    <div class="skeleton-progress">
                        <div class="skeleton-progress-bar"></div>
                    </div>
                </div>
            `;
        }
        
        statsHTML += '</div>';
        return statsHTML;
    }

    /**
     * Generate navigation skeleton
     */
    generateNavigationSkeleton(options = {}) {
        const items = options.items || 6;
        let navHTML = '<div class="skeleton-nav">';
        
        for (let i = 0; i < items; i++) {
            navHTML += `
                <div class="skeleton-nav-item">
                    <div class="skeleton-text short"></div>
                </div>
            `;
        }
        
        navHTML += '</div>';
        return navHTML;
    }

    /**
     * Generate content skeleton
     */
    generateContentSkeleton(options = {}) {
        return `
            <div class="skeleton-content">
                <div class="skeleton-title"></div>
                <div class="skeleton-text long"></div>
                <div class="skeleton-text long"></div>
                <div class="skeleton-text medium"></div>
                <div class="skeleton-image"></div>
                <div class="skeleton-text long"></div>
                <div class="skeleton-text short"></div>
            </div>
        `;
    }

    /**
     * Generate modal skeleton
     */
    generateModalSkeleton(options = {}) {
        return `
            <div class="skeleton-modal">
                <div class="skeleton-title"></div>
                <div class="skeleton-form-group">
                    <div class="skeleton-text short"></div>
                    <div class="skeleton-input"></div>
                </div>
                <div class="skeleton-form-group">
                    <div class="skeleton-text short"></div>
                    <div class="skeleton-textarea"></div>
                </div>
                <div class="flex justify-end space-x-3">
                    <div class="skeleton-button"></div>
                    <div class="skeleton-button"></div>
                </div>
            </div>
        `;
    }

    /**
     * Generate FilePond skeleton
     */
    generateFilePondSkeleton(options = {}) {
        return `
            <div class="skeleton-filepond">
                <div class="skeleton-text medium"></div>
            </div>
        `;
    }

    /**
     * Generate Quill editor skeleton
     */
    generateQuillSkeleton(options = {}) {
        return '<div class="skeleton-quill"></div>';
    }

    /**
     * Generate tabs skeleton
     */
    generateTabsSkeleton(options = {}) {
        const tabs = options.tabs || 3;
        let tabsHTML = '<div class="skeleton-tabs">';
        
        for (let i = 0; i < tabs; i++) {
            tabsHTML += `
                <div class="skeleton-tab">
                    <div class="skeleton-text short"></div>
                </div>
            `;
        }
        
        tabsHTML += '</div>';
        return tabsHTML;
    }

    /**
     * Generate pagination skeleton
     */
    generatePaginationSkeleton(options = {}) {
        return `
            <div class="skeleton-pagination">
                <div class="skeleton-button"></div>
                <div class="skeleton-button"></div>
                <div class="skeleton-button"></div>
                <div class="skeleton-button"></div>
                <div class="skeleton-button"></div>
            </div>
        `;
    }

    /**
     * Generate default skeleton
     */
    generateDefaultSkeleton(options = {}) {
        return `
            <div class="space-y-4">
                <div class="skeleton-text long"></div>
                <div class="skeleton-text medium"></div>
                <div class="skeleton-text short"></div>
            </div>
        `;
    }

    /**
     * Show loading overlay
     * @param {string} message - Loading message
     */
    showOverlay(message = 'Loading...') {
        const overlay = document.createElement('div');
        overlay.id = 'skeleton-overlay';
        overlay.className = 'skeleton-overlay';
        overlay.innerHTML = `
            <div class="skeleton-card">
                <div class="text-center">
                    <div class="skeleton-spinner mx-auto mb-4"></div>
                    <div class="skeleton-text medium mx-auto"></div>
                </div>
            </div>
        `;
        
        document.body.appendChild(overlay);
    }

    /**
     * Hide loading overlay
     */
    hideOverlay() {
        const overlay = document.getElementById('skeleton-overlay');
        if (overlay) {
            overlay.remove();
        }
    }

    /**
     * Show skeleton for AJAX requests
     * @param {string} elementId - Element ID to show skeleton for
     * @param {string} skeletonType - Type of skeleton
     * @param {Function} ajaxFunction - AJAX function to execute
     * @param {Object} options - Additional options
     */
    async withSkeleton(elementId, skeletonType, ajaxFunction, options = {}) {
        try {
            this.show(elementId, skeletonType, options);
            const result = await ajaxFunction();
            return result;
        } finally {
            this.hide(elementId);
        }
    }

    /**
     * Get all active loaders
     * @returns {Array} Array of active loader IDs
     */
    getActiveLoaders() {
        return Array.from(this.activeLoaders);
    }

    /**
     * Clear all active loaders
     */
    clearAll() {
        this.activeLoaders.forEach(id => {
            this.hide(id);
        });
        this.activeLoaders.clear();
    }
}

// Create global instance
window.SkeletonLoader = new SkeletonLoader();

// Utility functions for common use cases
window.showSkeleton = (elementId, type = 'default', options = {}) => {
    window.SkeletonLoader.show(elementId, type, options);
};

window.hideSkeleton = (elementId) => {
    window.SkeletonLoader.hide(elementId);
};

window.toggleSkeleton = (elementId, show, type = 'default', options = {}) => {
    window.SkeletonLoader.toggle(elementId, show, type, options);
};

window.showSkeletonOverlay = (message) => {
    window.SkeletonLoader.showOverlay(message);
};

window.hideSkeletonOverlay = () => {
    window.SkeletonLoader.hideOverlay();
};

// Auto-hide skeleton loaders on page load
document.addEventListener('DOMContentLoaded', function() {
    // Hide any skeleton loaders that might be showing
    setTimeout(() => {
        window.SkeletonLoader.clearAll();
    }, 1000);
});

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = SkeletonLoader;
}
