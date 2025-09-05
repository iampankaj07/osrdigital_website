<?php

namespace App\Traits;

use Filament\Facades\Filament;

trait HasResourcePermissions
{
    /**
     * Check if the current user can view any records
     */
    public static function canViewAny(): bool
    {
        $user = Filament::auth()->user();

        if (!$user) {
            return false;
        }

        if ($user->hasRole('Super Admin')) {
            return true;
        }

        $permission = static::getViewPermission();
        return $user->can($permission);
    }

    /**
     * Check if the current user can create records
     */
    public static function canCreate(): bool
    {
        $user = Filament::auth()->user();

        if (!$user) {
            return false;
        }

        if ($user->hasRole('Super Admin')) {
            return true;
        }

        $permission = static::getCreatePermission();
        return $user->can($permission);
    }

    /**
     * Check if the current user can edit a specific record
     */
    public static function canEdit($record): bool
    {
        $user = Filament::auth()->user();

        if (!$user) {
            return false;
        }

        if ($user->hasRole('Super Admin')) {
            return true;
        }

        $permission = static::getEditPermission();
        return $user->can($permission);
    }

    /**
     * Check if the current user can delete a specific record
     */
    public static function canDelete($record): bool
    {
        $user = Filament::auth()->user();

        if (!$user) {
            return false;
        }

        if ($user->hasRole('Super Admin')) {
            return true;
        }

        $permission = static::getDeletePermission();
        return $user->can($permission);
    }

    /**
     * Get the base permission name for this resource
     */
    protected static function getResourcePermissionName(): string
    {
        // This should be overridden in each resource
        $className = class_basename(static::class);
        $resourceName = str_replace('Resource', '', $className);
        return strtolower($resourceName);
    }

    /**
     * Get view permission name
     */
    protected static function getViewPermission(): string
    {
        return static::getResourcePermissionName() . '.view';
    }

    /**
     * Get create permission name
     */
    protected static function getCreatePermission(): string
    {
        return static::getResourcePermissionName() . '.create';
    }

    /**
     * Get edit permission name
     */
    protected static function getEditPermission(): string
    {
        return static::getResourcePermissionName() . '.edit';
    }

    /**
     * Get delete permission name
     */
    protected static function getDeletePermission(): string
    {
        return static::getResourcePermissionName() . '.delete';
    }
}
