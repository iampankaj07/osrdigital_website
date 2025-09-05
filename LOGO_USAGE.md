# Logo Usage Guide

## Available Logo Types

The Web Configuration page now supports multiple logo upload fields for different contexts:

### 1. Light Mode Logo (`logo_light`)
- **Purpose**: Main logo for light backgrounds/themes
- **Usage**: `<x-logo type="light" />`
- **Helper**: `SettingsHelper::getLogo('light')`

### 2. Dark Mode Logo (`logo_dark`)
- **Purpose**: Main logo for dark backgrounds/themes  
- **Usage**: `<x-logo type="dark" />`
- **Helper**: `SettingsHelper::getLogo('dark')`

### 3. Admin Panel Logo (`logo_admin`)
- **Purpose**: Logo displayed in admin panel header
- **Usage**: `<x-logo type="admin" />`
- **Helper**: `SettingsHelper::getAdminLogo()`

### 4. Mobile Logo (`logo_mobile`)
- **Purpose**: Optimized logo for mobile devices
- **Usage**: `<x-logo type="mobile" />`
- **Helper**: `SettingsHelper::getMobileLogo()`

### 5. Footer Logo (`logo_footer`)
- **Purpose**: Logo for website footer sections
- **Usage**: `<x-logo type="footer" />`
- **Helper**: `SettingsHelper::getFooterLogo()`

### 6. Email Logo (`logo_email`)
- **Purpose**: Logo for email templates and newsletters
- **Usage**: `<x-logo type="email" />`
- **Helper**: `SettingsHelper::getEmailLogo()`

### 7. Favicon (`favicon`)
- **Purpose**: Browser tab icon (16x16 or 32x32)
- **Usage**: Automatically loaded in page head
- **Helper**: `SettingsHelper::getFavicon()`

## Auto Logo Selection

Use `<x-logo type="auto" />` for automatic light/dark mode switching based on theme.

## Fallback Behavior

If a specific logo type isn't uploaded, the system will fallback to:
1. Light mode logo
2. Dark mode logo  
3. Site title text

## Configuration

All logos can be uploaded via: **Admin Panel > System > Web Configuration**
