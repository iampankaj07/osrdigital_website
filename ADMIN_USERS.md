# Admin User Management

This document provides information about admin user management in the OSR application.

## Pre-configured Admin Users

The following admin users are created by default with **Super Admin** privileges:

### Primary Admin
- **Email:** `admin@osr.com`
- **Password:** `admin123456`
- **Role:** Super Admin
- **Permissions:** Full system access

### Secondary Admin
- **Email:** `admin@osrdigital.com`
- **Password:** `admin123456`
- **Role:** Super Admin
- **Permissions:** Full system access

### System Administrator
- **Email:** `system@osr.com`
- **Password:** `system123456`
- **Role:** Super Admin
- **Permissions:** Full system access

## Available Roles

### Super Admin
- Full access to all features and settings
- Can manage users, roles, and permissions
- System maintenance capabilities
- All CRUD operations on all modules

### Admin
- Administrative access to most features
- Can manage content and users
- Limited system settings access

### Editor
- Can edit content but not manage users or system settings
- Content management permissions only

### Viewer
- Read-only access to the admin panel
- Can view but not modify content

## Creating New Admin Users

### Using Artisan Command

```bash
# Interactive mode
php artisan admin:create-user

# With options
php artisan admin:create-user --name="John Doe" --email="john@example.com" --password="secure123" --role="superadmin"
```

### Available Options:
- `--name`: Name of the admin user
- `--email`: Email of the admin user
- `--password`: Password for the admin user
- `--role`: Role to assign (superadmin, admin, editor, viewer)

### Using Seeder

```bash
# Run the admin user seeder
php artisan db:seed --class=AdminUserSeeder

# Run all seeders
php artisan db:seed
```

## Permissions

The Super Admin role includes the following permission categories:

### Dashboard
- `view-dashboard`

### Settings
- `view-settings`, `create-settings`, `edit-settings`, `delete-settings`

### Navigation
- `view-navigation`, `create-navigation`, `edit-navigation`, `delete-navigation`

### Content Management
- `view-home-page`, `edit-home-page`
- `view-business`, `edit-business`
- `view-contact`, `edit-contact`

### User Management
- `view-users`, `create-users`, `edit-users`, `delete-users`

### Role & Permission Management
- `view-roles`, `create-roles`, `edit-roles`, `delete-roles`
- `view-permissions`, `create-permissions`, `edit-permissions`, `delete-permissions`
- `assign-roles`, `assign-permissions`

### Module Management
- News: `view-news`, `create-news`, `edit-news`, `delete-news`, `publish-news`
- Film Portfolios: `view-film-portfolios`, `create-film-portfolios`, `edit-film-portfolios`, `delete-film-portfolios`
- Team Members: `view-team-members`, `create-team-members`, `edit-team-members`, `delete-team-members`
- Testimonials: `view-testimonials`, `create-testimonials`, `edit-testimonials`, `delete-testimonials`
- Associates: `view-associates`, `create-associates`, `edit-associates`, `delete-associates`
- Trusted Partners: `view-trusted-partners`, `create-trusted-partners`, `edit-trusted-partners`, `delete-trusted-partners`

### System Permissions
- `view-logs`, `clear-cache`, `backup-database`, `restore-database`, `system-maintenance`

### File Management
- `upload-files`, `delete-files`, `manage-media`

## Security Notes

1. **Change Default Passwords**: Always change the default passwords after initial setup
2. **Strong Passwords**: Use strong, unique passwords for all admin accounts
3. **Regular Updates**: Regularly review and update user permissions
4. **Audit Logs**: Monitor admin user activities through system logs
5. **Role Principle**: Assign the minimum required permissions for each user

## Troubleshooting

### Permission Issues
If a user cannot access certain features:
1. Check if the user has the correct role assigned
2. Verify the role has the required permissions
3. Clear permission cache: `php artisan permission:cache-reset`

### User Creation Issues
If user creation fails:
1. Ensure all required fields are provided
2. Check email uniqueness
3. Verify password meets minimum requirements (6+ characters)
4. Ensure roles exist in the database

### Login Issues
If admin users cannot login:
1. Verify email and password are correct
2. Check if email is verified
3. Ensure user account is active
4. Check for any middleware restrictions
