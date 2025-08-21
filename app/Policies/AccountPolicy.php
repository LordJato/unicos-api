<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AccountPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Account $account): bool
    {
        return $user->account_id === $account->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Account $account): bool
    {
        return $user->account_id === $account->id;
    }

    public function delete(User $user, Account $account): bool
    {
        return $user->account_id === $account->id;
    }

    public function restore(User $user, Account $account): bool
    {
        return false;
    }
    
    public function forceDelete(User $user, Account $account): bool
    {
        return false;
    }
}
