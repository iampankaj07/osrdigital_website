<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Filament\Facades\Filament;

class CheckFilamentPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Filament::auth()->user();
        
        if (!$user) {
            return redirect()->route('filament.admin.auth.login');
        }

        // Allow super admin access to everything
        if ($user->hasRole('Super Admin')) {
            return $next($request);
        }

        // Check specific resource permissions
        $route = $request->route();
        $routeName = $route->getName();
        
        if (str_contains($routeName, 'filament.admin.resources')) {
            $permission = $this->getPermissionFromRoute($routeName);
            
            if ($permission && !$user->can($permission)) {
                abort(403, 'You do not have permission to access this resource.');
            }
        }

        return $next($request);
    }

    /**
     * Get permission name from route
     */
    private function getPermissionFromRoute(string $routeName): ?string
    {
        $routeParts = explode('.', $routeName);
        
        if (count($routeParts) < 5) {
            return null;
        }
        
        $resourceName = $routeParts[4]; // Extract resource name
        $action = $routeParts[5] ?? 'view'; // Extract action (index, create, edit, etc.)
        
        // Map actions to permissions
        $actionMap = [
            'index' => 'view',
            'show' => 'view',
            'create' => 'create',
            'edit' => 'edit',
            'delete' => 'delete',
        ];
        
        $permissionAction = $actionMap[$action] ?? 'view';
        
        // Convert resource name to permission format
        $resourceMap = [
            'users' => 'users',
            'roles' => 'roles',
            'permissions' => 'permissions',
            'portfolios' => 'portfolios',
            'news' => 'news',
            'pages' => 'pages',
            'partners' => 'partners',
            'contacts' => 'contacts',
        ];
        
        $resource = $resourceMap[$resourceName] ?? null;
        
        return $resource ? "{$resource}.{$permissionAction}" : null;
    }
}
