<?php

namespace App\Policies;

use App\Models\Fonction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FonctionPolicy
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
        return $user->permissions->where("code", "voir_la_gestion_des_fonctions")->first() != null ? true: false || $user->fonction->name == 'Administrateur';

    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fonction  $fonction
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Fonction $fonction)
    {
        $resp = $user->permissions->where("code", "voir_une_fonction")->first() != null ? true: false || $resp = $user->fonction->name == 'Administrateur';
        return $resp || $fonction->id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->permissions->where("code", "creer_une_fonction")->first() != null ? true: false || $user->fonction->name == 'Administrateur';

    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fonction  $fonction
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Fonction $fonction)
    {
        $resp = $user->permissions->where("code", "modifier_une_fonction")->first() != null ? true: false|| $resp = $user->fonction->name == 'Administrateur';
        return $resp || $fonction->id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fonction  $fonction
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Fonction $fonction)
    {
        return $user->permissions->where("code", "supprimer_une_fonction")->first() != null ? true: false || $user->fonction->name == 'Administrateur';

    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fonction  $fonction
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Fonction $fonction)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fonction  $fonction
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Fonction $fonction)
    {
        //
    }
}
