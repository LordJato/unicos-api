<?php

namespace App\Providers;

use Exception;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Client\ConnectionException;

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
        try {
            $permissions = Permission::all();
        
            foreach ($permissions as $permission) {
                Gate::define($permission->slug, function ($user) use ($permission) {
                    return $user->hasPermissionTo($permission->slug);
                });
            }
        } catch (ConnectionException $e) {
            // Database connection is not available
            Log::error('Database connection failed: ' . $e->getMessage());
        } catch (Exception $e) {
            // Handle any other unexpected exceptions
            Log::error('Unexpected error: ' . $e->getMessage());
        }
     
    }
} 
