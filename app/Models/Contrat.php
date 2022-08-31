<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Carbon\Carbon;

class Contrat extends Model
{
    use HasFactory;
    
    protected $fillable = [
    'client_id', 
    'num_contrat', 
    'date', 
    'content', 
    'avec_signature', 
    'avec_entete', 
    'date_expiration'
];

    public function getStatExpiration() {
        $now = Carbon::now();
        $date = new Carbon($this->date_expiration);

        if($now > $date) return "<span class='badge badge-danger'>Expiré</span>";
        elseif($now->diffInDays($date) <= 45) return "<span class='badge badge-warning'>Presque Expiré</span>";
        else return "<span class='badge badge-success'>Valide</span>";
    }
}
