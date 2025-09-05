# Role and Permission Management System

This project uses Spatie Laravel Permission package with custom Filament resources to manage user roles and permissions.

## Overview

The system implements a Role-Based Access Control (RBAC) with the following hierarchy:

1. **Super Admin** - Full access to everything (bypasses all permission checks)
2. **Admin** - Can manage users, roles, permissions, and all content
3. **Editor** - Can view, create, and edit content but cannot delete or manage users/roles
4. **Viewer** - Read-only access to most content

## Architecture

### Models
- `User` - Enhanced with `HasRoles` trait from Spatie package
- `Role` - Spatie's role model
- `Permission` - Spatie's permission model

### Resources
- `UserResource` - Manage users with role assignment
- `RoleResource` - Manage roles and assign permissions
- `PermissionResource` - Manage individual permissions

### Middleware
- `CheckFilamentPermissions` - Enforces permission-based access control for Filament routes

### Traits
- `HasResourcePermissions` - Provides authorization methods for resources

## Available Roles and Permissions

### Roles
- **Super Admin**: Complete system access
- **Admin**: Full management capabilities
- **Editor**: Content creation and editing
- **Viewer**: Read-only access

### Permission Categories
Each category has four permission levels: view, create, edit, delete

1. **User Management**: user.view, user.create, user.edit, user.delete
2. **Role Management**: role.view, role.create, role.edit, role.delete
3. **Permission Management**: permission.view, permission.create, permission.edit, permission.delete
4. **Portfolio Management**: portfolio.view, portfolio.create, portfolio.edit, portfolio.delete
5. **News Management**: news.view, news.create, news.edit, news.delete
6. **Page Management**: page.view, page.create, page.edit, page.delete
7. **Partner Management**: partner.view, partner.create, partner.edit, partner.delete
8. **Contact Management**: contact.view, contact.create, contact.edit, contact.delete

## Usage

### Default Admin User
- **Email**: admin@osrdigital.com
- **Password**: password
- **Role**: Super Admin

### Adding New Resources
When creating new Filament resources that need permission control:

1. Add the `HasResourcePermissions` trait to your resource
2. Implement the `getResourcePermissionName()` method
3. Add the corresponding permissions to your seeder

```php
class YourResource extends Resource
{
    use HasResourcePermissions;
    
    protected static function getResourcePermissionName(): string
    {
        return 'your-resource';
    }
}
```

### Seeding Permissions
Run the role and permission seeder:
```bash
php artisan db:seed --class=RolePermissionSeeder
```

### Navigation Groups
Resources are organized into navigation groups:
- **User Management**: Users, Roles, Permissions
- **Content Management**: Portfolio, News, Pages, etc.
- **System**: Configuration and settings

## Middleware Configuration

The `CheckFilamentPermissions` middleware is automatically applied to all authenticated Filament routes and:
- Maps route patterns to required permissions
- Allows Super Admins to bypass all checks
- Returns 403 Forbidden for unauthorized access

## Database Tables

The following tables are created by the Spatie package:
- `roles` - Stores role definitions
- `permissions` - Stores permission definitions
- `model_has_permissions` - User-specific permissions
- `model_has_roles` - User role assignments
- `role_has_permissions` - Role permission mappings

## Security Notes

1. Super Admin role bypasses all permission checks
2. Permissions are checked at both resource and route levels
3. All CRUD operations are permission-controlled
4. Navigation items respect user permissions

## Troubleshooting

### Common Issues
1. **Access Denied**: Check if user has required role/permissions
2. **Navigation Missing**: Verify user permissions for resource access
3. **Resource Not Found**: Ensure resource is properly registered and permissions exist

### Debug Commands
```bash
# Check user roles and permissions
php artisan tinker
$user = User::find(1);
$user->getRoleNames();
$user->getPermissionNames();

# List all roles and permissions
Role::with('permissions')->get();
Permission::all();
```

## Extending the System

To add new permission categories:
1. Add permissions to `RolePermissionSeeder`
2. Update middleware route mapping if needed
3. Create corresponding Filament resources with permission trait
4. Re-run the seeder to apply changes
