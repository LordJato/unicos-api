<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

trait TenantAccount {
    public static function bootTenantAccount(){

        $currentUser = currentUser();

        if(Auth::check() && !$currentUser->hasRolesTo('super-admin')){
            
            static::creating(function ($model) use ($currentUser){
                $model->account_id = $currentUser->account_id;
            });

            static::addGlobalScope('account_id', function(Builder $builder) use ($currentUser){
                return $builder->where('account_id', $currentUser->account_id);
            });
        }
    }
}