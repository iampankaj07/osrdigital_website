<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RefreshPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh permissions system and clean up invalid references';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Refreshing permissions system...');

        // Clear permission cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $this->info('✓ Cleared permission cache');

        // Clean up invalid role-permission relationships
        $this->cleanupInvalidRolePermissions();
        $this->info('✓ Cleaned up invalid role-permission relationships');

        // Clean up invalid user-permission relationships
        $this->cleanupInvalidUserPermissions();
        $this->info('✓ Cleaned up invalid user-permission relationships');

        // Clean up invalid user-role relationships
        $this->cleanupInvalidUserRoles();
        $this->info('✓ Cleaned up invalid user-role relationships');

        // Refresh permission counts
        $this->refreshPermissionCounts();
        $this->info('✓ Refreshed permission counts');

        $this->info('Permissions system refreshed successfully!');
    }

    private function cleanupInvalidRolePermissions()
    {
        // Get all role-permission relationships where permission doesn't exist
        $invalidRelations = DB::table('role_has_permissions')
            ->leftJoin('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
            ->whereNull('permissions.id')
            ->select('role_has_permissions.role_id', 'role_has_permissions.permission_id')
            ->get();

        if ($invalidRelations->count() > 0) {
            $this->warn("Found {$invalidRelations->count()} invalid role-permission relationships");
            
            foreach ($invalidRelations as $relation) {
                DB::table('role_has_permissions')
                    ->where('role_id', $relation->role_id)
                    ->where('permission_id', $relation->permission_id)
                    ->delete();
            }
        }
    }

    private function cleanupInvalidUserPermissions()
    {
        // Get all user-permission relationships where permission doesn't exist
        $invalidRelations = DB::table('model_has_permissions')
            ->leftJoin('permissions', 'model_has_permissions.permission_id', '=', 'permissions.id')
            ->whereNull('permissions.id')
            ->select('model_has_permissions.model_id', 'model_has_permissions.permission_id')
            ->get();

        if ($invalidRelations->count() > 0) {
            $this->warn("Found {$invalidRelations->count()} invalid user-permission relationships");
            
            foreach ($invalidRelations as $relation) {
                DB::table('model_has_permissions')
                    ->where('model_id', $relation->model_id)
                    ->where('permission_id', $relation->permission_id)
                    ->delete();
            }
        }
    }

    private function cleanupInvalidUserRoles()
    {
        // Get all user-role relationships where role doesn't exist
        $invalidRelations = DB::table('model_has_roles')
            ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->whereNull('roles.id')
            ->select('model_has_roles.model_id', 'model_has_roles.role_id')
            ->get();

        if ($invalidRelations->count() > 0) {
            $this->warn("Found {$invalidRelations->count()} invalid user-role relationships");
            
            foreach ($invalidRelations as $relation) {
                DB::table('model_has_roles')
                    ->where('model_id', $relation->model_id)
                    ->where('role_id', $relation->role_id)
                    ->delete();
            }
        }
    }

    private function refreshPermissionCounts()
    {
        // This will be handled by the withCount() method in the Livewire components
        // But we can also refresh the cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
