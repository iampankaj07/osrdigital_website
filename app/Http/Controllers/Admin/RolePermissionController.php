<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    protected $middleware = ['auth', 'admin'];

    public function index()
    {
        return view('admin.roles.index');
    }

    // Role Management
    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'description' => 'nullable|string|max:500',
            'guard_name' => 'required|string|in:web,api',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'description' => $request->description,
            'guard_name' => $request->guard_name,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Role created successfully',
            'role' => $role
        ]);
    }

    public function updateRole(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
            'description' => 'nullable|string|max:500',
            'guard_name' => 'required|string|in:web,api',
        ]);

        $role->update([
            'name' => $request->name,
            'description' => $request->description,
            'guard_name' => $request->guard_name,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Role updated successfully',
            'role' => $role
        ]);
    }

    public function destroyRole($id)
    {
        $role = Role::findOrFail($id);
        
        // Check if role has users
        if ($role->users()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete role that has assigned users'
            ], 400);
        }

        $role->delete();

        return response()->json([
            'success' => true,
            'message' => 'Role deleted successfully'
        ]);
    }

    // Permission Management
    public function storePermission(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'description' => 'nullable|string|max:500',
            'guard_name' => 'required|string|in:web,api',
        ]);

        $permission = Permission::create([
            'name' => $request->name,
            'description' => $request->description,
            'guard_name' => $request->guard_name,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Permission created successfully',
            'permission' => $permission
        ]);
    }

    public function updatePermission(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $id,
            'description' => 'nullable|string|max:500',
            'guard_name' => 'required|string|in:web,api',
        ]);

        $permission->update([
            'name' => $request->name,
            'description' => $request->description,
            'guard_name' => $request->guard_name,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Permission updated successfully',
            'permission' => $permission
        ]);
    }

    public function destroyPermission($id)
    {
        $permission = Permission::findOrFail($id);
        
        // Check if permission has roles
        if ($permission->roles()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete permission that is assigned to roles'
            ], 400);
        }

        $permission->delete();

        return response()->json([
            'success' => true,
            'message' => 'Permission deleted successfully'
        ]);
    }

    // Role-Permission Assignment
    public function assignPermissionsToRole(Request $request, $roleId)
    {
        $role = Role::findOrFail($roleId);
        
        $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $permissions = Permission::whereIn('id', $request->permissions)->get();
        $role->syncPermissions($permissions);

        return response()->json([
            'success' => true,
            'message' => 'Permissions assigned to role successfully'
        ]);
    }

    // User-Role Assignment
    public function assignRolesToUser(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        
        $request->validate([
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id'
        ]);

        $roles = Role::whereIn('id', $request->roles)->get();
        $user->syncRoles($roles);

        return response()->json([
            'success' => true,
            'message' => 'Roles assigned to user successfully'
        ]);
    }

    // User-Permission Assignment
    public function assignPermissionsToUser(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        
        $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $permissions = Permission::whereIn('id', $request->permissions)->get();
        $user->syncPermissions($permissions);

        return response()->json([
            'success' => true,
            'message' => 'Permissions assigned to user successfully'
        ]);
    }

    // Get role with permissions
    public function getRole($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        return response()->json($role);
    }

    // Get permission with roles
    public function getPermission($id)
    {
        $permission = Permission::with('roles')->findOrFail($id);
        return response()->json($permission);
    }

    // Get user with roles and permissions
    public function getUser($id)
    {
        try {
            \Log::info('Fetching user with ID: ' . $id);
            $user = User::with(['roles', 'permissions'])->findOrFail($id);
            \Log::info('User found: ' . $user->name);
            return response()->json($user);
        } catch (\Exception $e) {
            \Log::error('Error fetching user: ' . $e->getMessage());
            return response()->json(['error' => 'User not found'], 404);
        }
    }

    // Get all permissions
    public function getAllPermissions()
    {
        try {
            $permissions = Permission::all();
            return response()->json($permissions);
        } catch (\Exception $e) {
            \Log::error('Error fetching permissions: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch permissions'], 500);
        }
    }

    // Get all roles
    public function getAllRoles()
    {
        try {
            \Log::info('Fetching all roles');
            $roles = Role::all();
            \Log::info('Found ' . $roles->count() . ' roles');
            return response()->json($roles);
        } catch (\Exception $e) {
            \Log::error('Error fetching roles: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch roles'], 500);
        }
    }

    // Delete user
    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deletion of the current user
        if ($user->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete your own account'
            ], 400);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully'
        ]);
    }
}
