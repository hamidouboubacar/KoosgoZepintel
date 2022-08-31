<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanningTache extends Model
{
    use HasFactory;
    
    protected $fillable = ['date', 'commercial_id', 'tache', 'resultat_attendu'];

    /**
     * Listes des taches
     * 
     * @return App\Models\Tache
     */
    public function taches() {
        return $this->hasMany(Tache::class);
    }
}
