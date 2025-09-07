# Dynamic Content Management System

This system allows you to manage all frontend content dynamically through the admin panel without touching any code.

## Overview

All the content on your website is now manageable through the admin panel. Content is organized into different groups for easy management:

- **Hero Section** - Main landing page content
- **Statistics** - Company performance metrics
- **Call to Action** - Partnership invitation content
- **Branding** - Colors, company name, logos
- **Contact** - Contact information
- **SEO** - Meta titles and descriptions

## How to Access

1. **Admin Panel**: Visit `http://your-domain/panel/settings`
2. **Login**: Use your admin credentials
3. **Navigate**: Go to "Settings" in the sidebar

## Content Groups

### Hero Section (`hero` group)
- `hero_badge_text` - Badge text (e.g., "Digital Media Excellence")
- `hero_main_title` - Main title (e.g., "Bringing Stories to")
- `hero_highlighted_title` - Highlighted part (e.g., "Global Screens")
- `hero_description` - Description paragraph
- `hero_primary_button_text` - Primary button text
- `hero_secondary_button_text` - Secondary button text

### Statistics (`stats` group)
- `stats_movies_count` - Number of movies (e.g., "500+")
- `stats_movies_label` - Movies label (e.g., "Movies Published")
- `stats_songs_count` - Number of songs (e.g., "2,000+")
- `stats_songs_label` - Songs label (e.g., "Songs Released")
- `stats_films_count` - Number of short films (e.g., "800+")
- `stats_films_label` - Films label (e.g., "Short Films")
- `stats_views_count` - Total views (e.g., "50M+")
- `stats_views_label` - Views label (e.g., "Total Views")
- `stats_section_title` - Section title (e.g., "Our")
- `stats_section_highlighted_title` - Highlighted title (e.g., "Impact")
- `stats_section_description` - Section description

### Call to Action (`cta` group)
- `cta_badge_text` - CTA badge text
- `cta_main_title` - CTA main title
- `cta_highlighted_title` - CTA highlighted title
- `cta_description` - CTA description
- `cta_primary_button_text` - Primary CTA button
- `cta_secondary_button_text` - Secondary CTA button
- `cta_feature_1_title` - First feature title
- `cta_feature_1_description` - First feature description
- `cta_feature_2_title` - Second feature title
- `cta_feature_2_description` - Second feature description
- `cta_feature_3_title` - Third feature title
- `cta_feature_3_description` - Third feature description

### Branding (`branding` group)
- `brand_primary_color` - Primary color (hex code, e.g., "#ec681b")
- `company_name` - Company name

### Contact (`contact` group)
- `contact_email` - Main contact email
- `contact_phone` - Main contact phone

### SEO (`seo` group)
- `site_title` - Website title for SEO
- `site_description` - Website meta description

## How to Edit Content

1. **Navigate to Settings**: In the admin panel, click on "Settings"
2. **Find Content**: Use the filters to find content by group (Hero, Stats, CTA, etc.)
3. **Edit Setting**: Click the edit button next to any setting
4. **Update Value**: Change the content in the "Value" field
5. **Save**: Click "Save" to apply changes

## Content Types

- **Text**: Simple text content
- **Textarea**: Longer text content (descriptions, paragraphs)
- **Color**: Color picker for brand colors
- **Email**: Email addresses
- **Boolean**: True/false values

## API Endpoints

The system also provides API endpoints for developers:

- `GET /api/settings` - All settings grouped
- `GET /api/settings/flat` - All settings as flat key-value pairs
- `GET /api/settings/group/{group}` - Settings by specific group
- `GET /api/settings/{key}` - Individual setting by key

## Technical Implementation

### Frontend (React)
The React components use the `useSettings` hook to fetch dynamic content:

```jsx
import { useSettings } from '../../hooks/useSettings';

function MyComponent() {
    const { getSetting, loading, error } = useSettings();
    
    return (
        <h1>{getSetting('hero_main_title', 'Default Title')}</h1>
    );
}
```

### Backend (Laravel)
Settings are managed through:
- **Model**: `App\Models\Setting`
- **Controller**: `App\Http\Controllers\Api\SettingsController`
- **Filament Resource**: `App\Filament\Resources\SettingResource`

## Benefits

1. **No Code Changes**: Update content without touching code
2. **Real-time Updates**: Changes appear immediately after saving
3. **Version Control**: All changes are tracked in the database
4. **Multi-user**: Multiple admin users can manage content
5. **Type Safety**: Different content types ensure proper data format
6. **Organized**: Content grouped logically for easy management
7. **Cache Optimized**: Settings are cached for performance

## Support

For technical support or feature requests, contact your development team.
