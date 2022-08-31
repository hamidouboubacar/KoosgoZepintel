<?php

namespace App\Policies;

use App\Models\Contrat;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContratPolicy
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
        return $user->permissions->where("code", "voir_la_gestion_des_contrats")->first() != null ? true: false || $user->fonction->name == 'Administrateur' || $user->fonction->name == 'Directrice commerciale' || $user->fonction->name == 'Commercial' || $user->fonction->name == 'Responsable de vente' || $user->fonction->name == 'Comptable';

    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Contrat  $contrat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Contrat $contrat)
    {
        $resp = $user->permissions->where("code", "voir_un_contrat")->first() != null ? true: false || $resp = $user->fonction->name == 'Administrateur' || $resp = $user->fonction->name == 'Directrice commerciale' || $resp = $user->fonction->name == 'Commercial' || $resp = $user->fonction->name == 'Responsable de vente' || $resp = $user->fonction->name == 'Comptable';
        return $resp || $contrat->id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->permissions->where("code", "creer_un_contrat")->first() != null ? true: false || $user->fonction->name == 'Administrateur' || $user->fonction->name == 'Directrice commerciale' || $user->fonction->name == 'Commercial' || $user->fonction->name == 'Responsable de vente' || $user->fonction->name == 'Comptable';

    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Contrat  $contrat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Contrat $contrat)
    {
        $resp = $user->permissions->where("code", "modifier_un_contrat")->first() != null ? true: false || $resp = $user->fonction->name == 'Administrateur' || $resp = $user->fonction->name == 'Directrice commerciale' || $resp = $user->fonction->name == 'Commercial' || $resp = $user->fonction->name == 'Responsable de vente' || $resp = $user->fonction->name == 'Comptable';
        return $resp || $contrat->id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Contrat  $contrat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Contrat $contrat)
    {
        return $user->permissions->where("code", "supprimer_un_contrat")->first() != null ? true: false || $user->fonction->name == 'Administrateur' || $user->fonction->name == 'Directrice commerciale' || $user->fonction->name == 'Commercial' || $user->fonction->name == 'Responsable de vente' || $user->fonction->name == 'Comptable';

    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Contrat  $contrat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Contrat $contrat)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Contrat  $contrat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Contrat $contrat)
    {
        //
    }
}
