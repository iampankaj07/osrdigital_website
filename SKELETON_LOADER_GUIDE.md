# Skeleton Loader Implementation Guide

This guide explains how to use the skeleton loader system implemented in the OSR Digital admin panel.

## Overview

The skeleton loader system provides smooth loading states for all content in the admin panel, improving user experience by showing placeholder content while data is being loaded.

## Files Added

- `resources/css/skeleton.css` - Skeleton loader styles
- `resources/js/skeleton-loader.js` - Skeleton loader JavaScript functionality
- Updated `vite.config.js` to include skeleton files
- Updated `resources/views/admin/layout.blade.php` to load skeleton files

## Basic Usage

### 1. Simple Skeleton Loader

```javascript
// Show skeleton loader
showSkeleton('element-id', 'table');

// Hide skeleton loader
hideSkeleton('element-id');
```

### 2. Toggle Skeleton Loader

```javascript
// Show or hide based on condition
toggleSkeleton('element-id', true, 'card');
toggleSkeleton('element-id', false);
```

### 3. Multiple Elements

```javascript
// Show multiple skeleton loaders
SkeletonLoader.showMultiple([
    { id: 'table-1', type: 'table', options: { rows: 5, cols: 4 } },
    { id: 'card-1', type: 'card' },
    { id: 'form-1', type: 'form', options: { fields: 3 } }
]);

// Hide multiple skeleton loaders
SkeletonLoader.hideMultiple(['table-1', 'card-1', 'form-1']);
```

## Available Skeleton Types

### 1. Table Skeleton
```javascript
showSkeleton('table-element', 'table', { rows: 5, cols: 4 });
```

### 2. Card Skeleton
```javascript
showSkeleton('card-element', 'card');
```

### 3. List Skeleton
```javascript
showSkeleton('list-element', 'list', { items: 5 });
```

### 4. Form Skeleton
```javascript
showSkeleton('form-element', 'form', { fields: 4 });
```

### 5. Stats Skeleton
```javascript
showSkeleton('stats-element', 'stats', { cards: 4 });
```

### 6. Navigation Skeleton
```javascript
showSkeleton('nav-element', 'navigation', { items: 6 });
```

### 7. Content Skeleton
```javascript
showSkeleton('content-element', 'content');
```

### 8. Modal Skeleton
```javascript
showSkeleton('modal-element', 'modal');
```

### 9. FilePond Skeleton
```javascript
showSkeleton('filepond-element', 'filepond');
```

### 10. Quill Editor Skeleton
```javascript
showSkeleton('quill-element', 'quill');
```

### 11. Tabs Skeleton
```javascript
showSkeleton('tabs-element', 'tabs', { tabs: 3 });
```

### 12. Pagination Skeleton
```javascript
showSkeleton('pagination-element', 'pagination');
```

## Advanced Usage

### 1. AJAX with Skeleton Loader

```javascript
async function loadData() {
    try {
        showSkeleton('content-area', 'table');
        const response = await fetch('/api/data');
        const data = await response.json();
        // Update content
        updateContent(data);
    } finally {
        hideSkeleton('content-area');
    }
}
```

### 2. Using withSkeleton Method

```javascript
const result = await SkeletonLoader.withSkeleton(
    'content-area',
    'table',
    async () => {
        const response = await fetch('/api/data');
        return await response.json();
    },
    { rows: 5, cols: 4 }
);
```

### 3. Loading Overlay

```javascript
// Show loading overlay
showSkeletonOverlay('Loading data...');

// Hide loading overlay
hideSkeletonOverlay();
```

## Implementation Examples

### 1. Dashboard Stats Cards

```javascript
document.addEventListener('DOMContentLoaded', function() {
    // Show skeleton for stats cards initially
    showSkeleton('stats-cards', 'stats', { cards: 4 });
    
    // Load data and hide skeleton
    loadStatsData().then(() => {
        hideSkeleton('stats-cards');
    });
});
```

### 2. Data Table with Pagination

```javascript
function loadTableData(page = 1) {
    showSkeleton('table-container', 'table', { rows: 10, cols: 5 });
    
    fetch(`/api/table-data?page=${page}`)
        .then(response => response.json())
        .then(data => {
            updateTable(data);
            hideSkeleton('table-container');
        })
        .catch(error => {
            console.error('Error loading data:', error);
            hideSkeleton('table-container');
        });
}
```

### 3. Form Submission

```javascript
function submitForm(formData) {
    showSkeleton('form-container', 'form', { fields: 5 });
    
    fetch('/api/submit-form', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        hideSkeleton('form-container');
        showSuccessMessage('Form submitted successfully!');
    })
    .catch(error => {
        hideSkeleton('form-container');
        showErrorMessage('Error submitting form');
    });
}
```

### 4. File Upload with FilePond

```javascript
// Show skeleton while FilePond is processing
FilePond.create(document.querySelector('.filepond'), {
    server: {
        process: {
            url: '/upload',
            onload: (response) => {
                hideSkeleton('filepond-container');
                return response;
            },
            onerror: (response) => {
                hideSkeleton('filepond-container');
                throw new Error('Upload failed');
            }
        }
    }
});

// Show skeleton when file is being processed
document.querySelector('.filepond').addEventListener('FilePond:processfile', () => {
    showSkeleton('filepond-container', 'filepond');
});
```

## CSS Classes

### Skeleton Base Classes
- `.skeleton` - Base skeleton animation
- `.skeleton-text` - Text skeleton
- `.skeleton-title` - Title skeleton
- `.skeleton-subtitle` - Subtitle skeleton
- `.skeleton-avatar` - Avatar skeleton
- `.skeleton-image` - Image skeleton
- `.skeleton-button` - Button skeleton
- `.skeleton-card` - Card skeleton
- `.skeleton-table` - Table skeleton
- `.skeleton-form-group` - Form group skeleton

### Skeleton Size Modifiers
- `.skeleton-text.short` - Short text (60% width)
- `.skeleton-text.medium` - Medium text (80% width)
- `.skeleton-text.long` - Long text (100% width)
- `.skeleton-avatar.small` - Small avatar (2rem)
- `.skeleton-avatar.large` - Large avatar (4rem)
- `.skeleton-button.small` - Small button
- `.skeleton-button.large` - Large button

### Skeleton Layout Classes
- `.skeleton-grid` - Grid layout
- `.skeleton-grid.cols-1` - 1 column grid
- `.skeleton-grid.cols-2` - 2 column grid
- `.skeleton-grid.cols-3` - 3 column grid
- `.skeleton-grid.cols-4` - 4 column grid
- `.skeleton-list` - List layout
- `.skeleton-list-item` - List item
- `.skeleton-stats` - Stats layout
- `.skeleton-nav` - Navigation layout

## Best Practices

### 1. Always Hide Skeleton Loaders
Make sure to hide skeleton loaders after content is loaded, even if there's an error.

```javascript
try {
    showSkeleton('content', 'table');
    const data = await loadData();
    updateContent(data);
} catch (error) {
    console.error('Error:', error);
} finally {
    hideSkeleton('content');
}
```

### 2. Use Appropriate Skeleton Types
Choose skeleton types that match your content structure:
- Use `table` for data tables
- Use `card` for card layouts
- Use `form` for forms
- Use `list` for lists
- Use `stats` for statistics cards

### 3. Set Realistic Options
Configure skeleton options to match your actual content:
- Set appropriate number of rows for tables
- Set appropriate number of fields for forms
- Set appropriate number of items for lists

### 4. Handle Loading States
Show skeleton loaders during:
- Initial page load
- AJAX requests
- Form submissions
- File uploads
- Navigation between pages

### 5. Provide Visual Feedback
Combine skeleton loaders with other loading indicators:
- Loading spinners for quick operations
- Progress bars for long operations
- Loading overlays for full-page operations

## Demo

Visit the admin dashboard to see skeleton loaders in action. The dashboard includes a demo section with various skeleton loader examples that you can test.

## Troubleshooting

### Common Issues

1. **Skeleton not showing**: Make sure the element ID exists and the skeleton CSS is loaded
2. **Skeleton not hiding**: Ensure you call `hideSkeleton()` after content is loaded
3. **Animation not working**: Check that the skeleton CSS is properly loaded
4. **Multiple skeletons**: Use unique element IDs for each skeleton loader

### Debug Mode

Enable debug mode to see skeleton loader activity:

```javascript
// Enable debug logging
window.SkeletonLoader.debug = true;
```

This will log all skeleton loader operations to the console.

## Performance Considerations

- Skeleton loaders are lightweight and don't impact performance
- Use appropriate skeleton types to avoid over-engineering
- Hide skeleton loaders promptly to avoid user confusion
- Consider using skeleton loaders for content that takes more than 200ms to load

## Browser Support

The skeleton loader system works in all modern browsers:
- Chrome 60+
- Firefox 55+
- Safari 12+
- Edge 79+

## Conclusion

The skeleton loader system provides a professional and smooth loading experience for the OSR Digital admin panel. Use it consistently across all pages to maintain a cohesive user experience.
