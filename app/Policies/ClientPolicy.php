<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
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
        return true;

    }

    public function viewDocument(User $user){
        return $user->fonction->name == 'Administrateur' || $user->fonction->name == 'Directrice commerciale' || $user->fonction->name == 'Responsable de vente' || $user->fonction->name == 'Comptable' || $user->fonction->name == 'Commercial';
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Client $client)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->permissions->where("code", "creer_un_client")->first() != null ? true: false || $user->fonction->name == 'Administrateur' || $user->fonction->name == 'Directrice commerciale' || $user->fonction->name == 'Responsable de vente' || $user->fonction->name == 'Comptable' || $user->fonction->name == 'Commercial';


    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Client $client)
    {
        $resp = $user->permissions->where("code", "modifier_un_client")->first() != null ? true: false || $resp = $user->fonction->name == 'Administrateur' || $resp = $user->fonction->name == 'Directrice commerciale' || $resp = $user->fonction->name == 'Responsable de vente' || $resp = $user->fonction->name == 'Comptable'|| $user->fonction->name == 'Commercial';
        return $resp || $client->id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Client $client)
    {
        return $user->permissions->where("code", "supprimer_un_client")->first() != null ? true: false || $user->fonction->name == 'Administrateur' || $user->fonction->name == 'Directrice commerciale' || $user->fonction->name == 'Responsable de vente' || $user->fonction->name == 'Comptable' || $user->fonction->name == 'Commercial';

    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Client $client)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Client $client)
    {
        //
    }
}
