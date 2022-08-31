<?php

namespace App\Policies;

use App\Models\Entreprise;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EntreprisePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->permissions->where("code", "voir_netforce")->first() != null ? true: false || $user->fonction->name == 'Administrateur';

    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Entreprise  $entreprise
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Entreprise $entreprise)
    {
        $resp = $user->permissions->where("code", "voir_entreprise")->first() != null ? true: false || $resp = $user->fonction->name == 'Administrateur';
        return $resp || $entreprise->id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;

    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Entreprise  $entreprise
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Entreprise $entreprise)
    {
        $resp = $user->permissions->where("code", "modifier_netforce")->first() != null ? true: false|| $resp = $user->fonction->name == 'Administrateur';
        return $resp || $entreprise->id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Entreprise  $entreprise
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Entreprise $entreprise)
    {
        return true;

    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Entreprise  $entreprise
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Entreprise $entreprise)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Entreprise  $entreprise
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Entreprise $entreprise)
    {
        //
    }
}
