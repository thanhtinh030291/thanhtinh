<?php

namespace App\Policies;

use App\User;
use App\Claim;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Http\Traits\PoliceTrait;

class ClaimPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any claims.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the claim.
     *
     * @param  \App\User  $user
     * @param  \App\Claim  $claim
     * @return mixed
     */
    public function view(User $user, Claim $claim)
    {
        return true;
    }

    /**
     * Determine whether the user can create claims.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the claim.
     *
     * @param  \App\User  $user
     * @param  \App\Claim  $claim
     * @return mixed
     */
    public function update(User $user, Claim $claim)
    {
        if ($user->can('edit form claim')) {
            return true;
        }
        return $user->id === $claim->created_user;
    }

    /**
     * Determine whether the user can delete the claim.
     *
     * @param  \App\User  $user
     * @param  \App\Claim  $claim
     * @return mixed
     */
    public function delete(User $user, Claim $claim)
    {
        if ($user->can('delete form claim')) {
            return true;
        }
        return $user->id === $claim->created_user;
    }

    /**
     * Determine whether the user can restore the claim.
     *
     * @param  \App\User  $user
     * @param  \App\Claim  $claim
     * @return mixed
     */
    public function restore(User $user, Claim $claim)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the claim.
     *
     * @param  \App\User  $user
     * @param  \App\Claim  $claim
     * @return mixed
     */
    public function forceDelete(User $user, Claim $claim)
    {
        //
    }
}
