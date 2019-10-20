<?php
namespace App\Http\Traits;

use App\Permission;
use App\Role;


trait PoliceTrait {

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
    public function view(User $user)
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
    public function update(User $user)
    {
        // if ($user->can('edit form claim')) {
        //     return true;
        // }
        return $user->id == $this->dataModel->created_user;
    }

    /**
     * Determine whether the user can delete the claim.
     *
     * @param  \App\User  $user
     * @param  \App\Claim  $claim
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->id == $this->dataModel->created_user;
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
        
    }
}
