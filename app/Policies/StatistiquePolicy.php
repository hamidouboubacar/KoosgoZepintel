<?php

namespace App\Policies;

use App\Models\Statistique;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StatistiquePolicy
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
        return $user->permissions->where("code", "voir_les_statistiques")->first() != null ? true: false || $user->fonction->name == 'Administrateur' || $user->fonction->name == 'Directrice commerciale' || $user->fonction->name == 'Responsable de vente' || $user->fonction->name == 'Comptable';

    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Statistique  $statistique
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Statistique $statistique)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Statistique  $statistique
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Statistique $statistique)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Statistique  $statistique
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Statistique $statistique)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Statistique  $statistique
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Statistique $statistique)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Statistique  $statistique
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Statistique $statistique)
    {
        //
    }
}
