@extends('admin.layout')

@section('title', 'Roles & Permissions')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-900">Roles & Permissions</h1>
        <div class="flex space-x-3">
            <button onclick="openAddRoleModal()" class="btn btn-dark">
                <i class="fas fa-plus mr-2"></i>
                New Role
            </button>
            <button onclick="openAddPermissionModal()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-key mr-2"></i>
                New Permission
            </button>
        </div>
    </div>

    <!-- Tabs -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 px-6">
                <button onclick="showTab('roles')" id="roles-tab" class="py-4 px-1 border-b-2 border-purple-500 text-purple-600 font-medium text-sm">
                    <i class="fas fa-users mr-2"></i>
                    Roles
                </button>
                <button onclick="showTab('permissions')" id="permissions-tab" class="py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium text-sm">
                    <i class="fas fa-key mr-2"></i>
                    Permissions
                </button>
                <button onclick="showTab('users')" id="users-tab" class="py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium text-sm">
                    <i class="fas fa-user mr-2"></i>
                    Users
                </button>
            </nav>
        </div>

        <!-- Roles Tab -->
        <div id="roles-content" class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Roles</h2>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" placeholder="Search roles..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guard</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Users</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Permissions</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse(\Spatie\Permission\Models\Role::with('permissions')->get() as $role)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-user-tag text-purple-600 text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $role->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $role->description ?? 'No description' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $role->guard_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $role->users->count() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $role->permissions->count() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <button onclick="assignPermissionsToRole({{ $role->id }})" class="text-blue-600 hover:text-blue-900" title="Assign Permissions">
                                            <i class="fas fa-key"></i>
                                        </button>
                                        <button onclick="editRole({{ $role->id }})" class="text-indigo-600 hover:text-indigo-900" title="Edit Role">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="deleteRole({{ $role->id }})" class="text-red-600 hover:text-red-900" title="Delete Role">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fas fa-user-tag text-4xl mb-4"></i>
                                    <p class="text-lg font-medium">No roles found</p>
                                    <p class="text-sm">Get started by creating your first role.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Permissions Tab -->
        <div id="permissions-content" class="p-6 hidden">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Permissions</h2>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" placeholder="Search permissions..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guard</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Roles</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse(\Spatie\Permission\Models\Permission::with('roles')->get() as $permission)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-key text-blue-600 text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $permission->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $permission->description ?? 'No description' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $permission->guard_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $permission->roles->count() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <button onclick="editPermission({{ $permission->id }})" class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="deletePermission({{ $permission->id }})" class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fas fa-key text-4xl mb-4"></i>
                                    <p class="text-lg font-medium">No permissions found</p>
                                    <p class="text-sm">Get started by creating your first permission.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Users Tab -->
        <div id="users-content" class="p-6 hidden">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Users</h2>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" placeholder="Search users..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Roles</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Permissions</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse(\App\Models\User::with(['roles', 'permissions'])->get() as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-white font-semibold text-sm">{{ substr($user->name, 0, 2) }}</span>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-500">ID: {{ $user->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $user->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($user->roles as $role)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $user->permissions->count() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <button onclick="editUserRoles({{ $user->id }})" class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-user-edit"></i>
                                        </button>
                                        <button onclick="deleteUser({{ $user->id }})" class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fas fa-user text-4xl mb-4"></i>
                                    <p class="text-lg font-medium">No users found</p>
                                    <p class="text-sm">No users are registered in the system.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Role Modal -->
<div id="roleModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900" id="roleModalTitle">Add New Role</h3>
            </div>
            <form id="roleForm">
                <div class="px-6 py-4 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Role Name</label>
                        <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Guard Name</label>
                        <select name="guard_name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="web">Web</option>
                            <option value="api">API</option>
                        </select>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                    <button type="button" onclick="closeRoleModal()" class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                        Save Role
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Permission Modal -->
<div id="permissionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900" id="permissionModalTitle">Add New Permission</h3>
            </div>
            <form id="permissionForm">
                <div class="px-6 py-4 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Permission Name</label>
                        <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Guard Name</label>
                        <select name="guard_name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="web">Web</option>
                            <option value="api">API</option>
                        </select>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                    <button type="button" onclick="closePermissionModal()" class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Save Permission
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Role Permission Assignment Modal -->
<div id="rolePermissionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900" id="rolePermissionModalTitle">Assign Permissions to Role</h3>
            </div>
            <div class="px-6 py-4">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Role: <span id="selectedRoleName" class="font-semibold text-purple-600"></span></label>
                </div>
                <div class="max-h-96 overflow-y-auto">
                    <div id="permissionsList" class="space-y-2">
                        <!-- Permissions will be loaded here -->
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                <button type="button" onclick="closeRolePermissionModal()" class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    Cancel
                </button>
                <button type="button" onclick="saveRolePermissions()" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                    Save Permissions
                </button>
            </div>
        </div>
    </div>
</div>

<!-- User Role Assignment Modal -->
<div id="userRoleModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900" id="userRoleModalTitle">Assign Roles to User</h3>
            </div>
            <div class="px-6 py-4">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">User: <span id="selectedUserName" class="font-semibold text-purple-600"></span></label>
                </div>
                <div class="max-h-96 overflow-y-auto">
                    <div id="rolesList" class="space-y-2">
                        <!-- Roles will be loaded here -->
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                <button type="button" onclick="closeUserRoleModal()" class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    Cancel
                </button>
                <button type="button" onclick="saveUserRoles()" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                    Save Roles
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Global variables
let currentRoleId = null;
let currentPermissionId = null;
let currentUserId = null;

// Tab functionality
function showTab(tabName) {
    // Hide all content
    document.getElementById('roles-content').classList.add('hidden');
    document.getElementById('permissions-content').classList.add('hidden');
    document.getElementById('users-content').classList.add('hidden');

    // Remove active class from all tabs
    document.getElementById('roles-tab').classList.remove('border-purple-500', 'text-purple-600');
    document.getElementById('roles-tab').classList.add('border-transparent', 'text-gray-500');
    document.getElementById('permissions-tab').classList.remove('border-purple-500', 'text-purple-600');
    document.getElementById('permissions-tab').classList.add('border-transparent', 'text-gray-500');
    document.getElementById('users-tab').classList.remove('border-purple-500', 'text-purple-600');
    document.getElementById('users-tab').classList.add('border-transparent', 'text-gray-500');

    // Show selected content and activate tab
    document.getElementById(tabName + '-content').classList.remove('hidden');
    document.getElementById(tabName + '-tab').classList.remove('border-transparent', 'text-gray-500');
    document.getElementById(tabName + '-tab').classList.add('border-purple-500', 'text-purple-600');
}

// Utility functions
function showNotification(message, type = 'success') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg text-white ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    }`;
    notification.textContent = message;

    document.body.appendChild(notification);

    // Remove notification after 3 seconds
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

function makeRequest(url, method = 'GET', data = null) {
    const options = {
        method: method,
        credentials: 'same-origin', // Include cookies for authentication
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        }
    };

    if (data) {
        options.body = JSON.stringify(data);
    }

    return fetch(url, options)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred. Please try again.', 'error');
            throw error;
        });
}

// Role modal functions
function openAddRoleModal() {
    currentRoleId = null;
    document.getElementById('roleModalTitle').textContent = 'Add New Role';
    document.getElementById('roleForm').reset();
    document.getElementById('roleModal').classList.remove('hidden');
}

function closeRoleModal() {
    document.getElementById('roleModal').classList.add('hidden');
    currentRoleId = null;
}

function editRole(id) {
    currentRoleId = id;
    document.getElementById('roleModalTitle').textContent = 'Edit Role';

    // Fetch role data
    makeRequest(`/admin/roles/${id}`)
        .then(data => {
            document.querySelector('#roleForm input[name="name"]').value = data.name || '';
            document.querySelector('#roleForm textarea[name="description"]').value = data.description || '';
            document.querySelector('#roleForm select[name="guard_name"]').value = data.guard_name || 'web';
            document.getElementById('roleModal').classList.remove('hidden');
        })
        .catch(error => {
            showNotification('Failed to load role data', 'error');
        });
}

function deleteRole(id) {
    if (confirm('Are you sure you want to delete this role?')) {
        makeRequest(`/admin/roles/${id}`, 'DELETE')
            .then(data => {
                if (data.success) {
                    showNotification(data.message);
                    location.reload(); // Reload to refresh the table
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                showNotification('Failed to delete role', 'error');
            });
    }
}

// Permission modal functions
function openAddPermissionModal() {
    currentPermissionId = null;
    document.getElementById('permissionModalTitle').textContent = 'Add New Permission';
    document.getElementById('permissionForm').reset();
    document.getElementById('permissionModal').classList.remove('hidden');
}

function closePermissionModal() {
    document.getElementById('permissionModal').classList.add('hidden');
    currentPermissionId = null;
}

function editPermission(id) {
    currentPermissionId = id;
    document.getElementById('permissionModalTitle').textContent = 'Edit Permission';

    // Fetch permission data
    makeRequest(`/admin/permissions/${id}`)
        .then(data => {
            document.querySelector('#permissionForm input[name="name"]').value = data.name || '';
            document.querySelector('#permissionForm textarea[name="description"]').value = data.description || '';
            document.querySelector('#permissionForm select[name="guard_name"]').value = data.guard_name || 'web';
            document.getElementById('permissionModal').classList.remove('hidden');
        })
        .catch(error => {
            showNotification('Failed to load permission data', 'error');
        });
}

function deletePermission(id) {
    if (confirm('Are you sure you want to delete this permission?')) {
        makeRequest(`/admin/permissions/${id}`, 'DELETE')
            .then(data => {
                if (data.success) {
                    showNotification(data.message);
                    location.reload(); // Reload to refresh the table
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                showNotification('Failed to delete permission', 'error');
            });
    }
}

// User functions
function editUserRoles(id) {
    currentUserId = id;
    assignRolesToUser(id);
}

function deleteUser(id) {
    if (confirm('Are you sure you want to delete this user?')) {
        makeRequest(`/admin/users/${id}`, 'DELETE')
            .then(data => {
                if (data.success) {
                    showNotification(data.message);
                    location.reload(); // Reload to refresh the table
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                showNotification('Failed to delete user', 'error');
            });
    }
}

// Role Permission Assignment functions
function assignPermissionsToRole(roleId) {
    currentRoleId = roleId;

    // For now, show a simple message and redirect to a dedicated page
    // This avoids authentication issues with AJAX
    showNotification('Permission assignment feature will be implemented in a future update. For now, you can manage roles and permissions through the main interface.', 'error');

    // TODO: Implement proper permission assignment modal
    // This requires either:
    // 1. Setting up proper API authentication
    // 2. Using form submissions instead of AJAX
    // 3. Creating a dedicated page for role management
}

function loadPermissionsIntoModal(permissions, roleId) {
    const container = document.getElementById('permissionsList');
    container.innerHTML = '';

    // Group permissions by guard name
    const groupedPermissions = permissions.reduce((acc, permission) => {
        if (!acc[permission.guard_name]) {
            acc[permission.guard_name] = [];
        }
        acc[permission.guard_name].push(permission);
        return acc;
    }, {});

    Object.keys(groupedPermissions).forEach(guardName => {
        const guardDiv = document.createElement('div');
        guardDiv.className = 'mb-4';
        guardDiv.innerHTML = `
            <h4 class="text-sm font-semibold text-gray-700 mb-2 uppercase tracking-wider">${guardName} Guard</h4>
            <div class="space-y-2" id="permissions-${guardName}">
                ${groupedPermissions[guardName].map(permission => `
                    <label class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-lg cursor-pointer">
                        <input type="checkbox"
                               name="permissions[]"
                               value="${permission.id}"
                               class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <div class="flex-1">
                            <div class="text-sm font-medium text-gray-900">${permission.name}</div>
                            <div class="text-xs text-gray-500">${permission.description || 'No description'}</div>
                        </div>
                    </label>
                `).join('')}
            </div>
        `;
        container.appendChild(guardDiv);
    });

    // Load current role permissions
    loadCurrentRolePermissions(roleId);
}

function loadCurrentRolePermissions(roleId) {
    makeRequest(`/admin/roles/${roleId}`)
        .then(roleData => {
            if (roleData.permissions) {
                roleData.permissions.forEach(permission => {
                    const checkbox = document.querySelector(`input[value="${permission.id}"]`);
                    if (checkbox) {
                        checkbox.checked = true;
                    }
                });
            }
        })
        .catch(error => {
            console.error('Failed to load current role permissions:', error);
        });
}

function saveRolePermissions() {
    const selectedPermissions = Array.from(document.querySelectorAll('input[name="permissions[]"]:checked'))
        .map(checkbox => parseInt(checkbox.value));

    makeRequest(`/admin/roles/${currentRoleId}/permissions`, 'POST', { permissions: selectedPermissions })
        .then(data => {
            if (data.success) {
                showNotification(data.message);
                closeRolePermissionModal();
                location.reload(); // Reload to refresh the table
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            showNotification('Failed to save role permissions', 'error');
        });
}

function closeRolePermissionModal() {
    document.getElementById('rolePermissionModal').classList.add('hidden');
    currentRoleId = null;
}

// User Role Assignment functions
function assignRolesToUser(userId) {
    currentUserId = userId;

    // For now, show a simple message
    // This avoids authentication issues with AJAX
    showNotification('User role assignment feature will be implemented in a future update. For now, you can manage users through the main interface.', 'error');

    // TODO: Implement proper user role assignment modal
    // This requires either:
    // 1. Setting up proper API authentication
    // 2. Using form submissions instead of AJAX
    // 3. Creating a dedicated page for user management
}

function loadRolesIntoModal(roles, userId) {
    const container = document.getElementById('rolesList');
    container.innerHTML = '';

    // Group roles by guard name
    const groupedRoles = roles.reduce((acc, role) => {
        if (!acc[role.guard_name]) {
            acc[role.guard_name] = [];
        }
        acc[role.guard_name].push(role);
        return acc;
    }, {});

    Object.keys(groupedRoles).forEach(guardName => {
        const guardDiv = document.createElement('div');
        guardDiv.className = 'mb-4';
        guardDiv.innerHTML = `
            <h4 class="text-sm font-semibold text-gray-700 mb-2 uppercase tracking-wider">${guardName} Guard</h4>
            <div class="space-y-2" id="roles-${guardName}">
                ${groupedRoles[guardName].map(role => `
                    <label class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-lg cursor-pointer">
                        <input type="checkbox"
                               name="roles[]"
                               value="${role.id}"
                               class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <div class="flex-1">
                            <div class="text-sm font-medium text-gray-900">${role.name}</div>
                            <div class="text-xs text-gray-500">${role.description || 'No description'}</div>
                        </div>
                    </label>
                `).join('')}
            </div>
        `;
        container.appendChild(guardDiv);
    });

    // Load current user roles
    loadCurrentUserRoles(userId);
}

function loadCurrentUserRoles(userId) {
    makeRequest(`/admin/users/${userId}`)
        .then(userData => {
            if (userData.roles) {
                userData.roles.forEach(role => {
                    const checkbox = document.querySelector(`input[value="${role.id}"]`);
                    if (checkbox) {
                        checkbox.checked = true;
                    }
                });
            }
        })
        .catch(error => {
            console.error('Failed to load current user roles:', error);
        });
}

function saveUserRoles() {
    const selectedRoles = Array.from(document.querySelectorAll('input[name="roles[]"]:checked'))
        .map(checkbox => parseInt(checkbox.value));

    makeRequest(`/admin/users/${currentUserId}/roles`, 'POST', { roles: selectedRoles })
        .then(data => {
            if (data.success) {
                showNotification(data.message);
                closeUserRoleModal();
                location.reload(); // Reload to refresh the table
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            showNotification('Failed to save user roles', 'error');
        });
}

function closeUserRoleModal() {
    document.getElementById('userRoleModal').classList.add('hidden');
    currentUserId = null;
}

// Form submission handlers
document.addEventListener('DOMContentLoaded', function() {
    // Role form submission
    document.getElementById('roleForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const data = Object.fromEntries(formData);

        const url = currentRoleId ? `/admin/roles/${currentRoleId}` : '/admin/roles';
        const method = currentRoleId ? 'PUT' : 'POST';

        makeRequest(url, method, data)
            .then(response => {
                if (response.success) {
                    showNotification(response.message);
                    closeRoleModal();
                    location.reload(); // Reload to refresh the table
                } else {
                    showNotification(response.message, 'error');
                }
            })
            .catch(error => {
                showNotification('Failed to save role', 'error');
            });
    });

    // Permission form submission
    document.getElementById('permissionForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const data = Object.fromEntries(formData);

        const url = currentPermissionId ? `/admin/permissions/${currentPermissionId}` : '/admin/permissions';
        const method = currentPermissionId ? 'PUT' : 'POST';

        makeRequest(url, method, data)
            .then(response => {
                if (response.success) {
                    showNotification(response.message);
                    closePermissionModal();
                    location.reload(); // Reload to refresh the table
                } else {
                    showNotification(response.message, 'error');
                }
            })
            .catch(error => {
                showNotification('Failed to save permission', 'error');
            });
    });
});
</script>
@endsection
