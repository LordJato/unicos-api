<?php

namespace App\Providers;

use Exception;
use App\Models\Permission;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;

class PermissionProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // try {
        //     $permissions = Cache::remember('permissions', 3600, function () {
        //         return Permission::all();
        //     });
    
        //     foreach ($permissions as $permission) {
        //         Gate::define($permission->slug, function ($user) use ($permission) {
        //             return $user->hasPermissionTo($permission->slug);
        //         });
        //     }
        // } catch (Exception $e) {
        //     Log::error('Error loading permissions: ' . $e->getMessage());
        // }
     
    }
} 
