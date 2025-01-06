<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

trait TenantCompany {
    public static function bootTenantCompany(){

        $currentUser = getCurrentUser();

        if(Auth::check() && !$currentUser->hasRolesTo('super-admin')){
            
            static::creating(function ($model) use ($currentUser){
                $model->company_id = $currentUser->company_id;
            });

            static::addGlobalScope('company_id', function(Builder $builder) use ($currentUser){
                return $builder->where('company_id', $currentUser->company_id);
            });
        }
    }
}