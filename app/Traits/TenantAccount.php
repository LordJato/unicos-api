<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

trait TenantAccount {
    public static function bootTenantAccount(){

        $auth = Auth::guard('api');

        $user = $auth->user();

        if($user instanceof User && $auth->check() && !$user->hasRolesTo('super-admin')){
            
            static::creating(function ($model) use ($user){
                $model->account_id = $user->account_id;
            });

            static::addGlobalScope('account_id', function(Builder $builder) use ($user){
                return $builder->where('account_id', $user->account_id);
            });
        }
    }
}