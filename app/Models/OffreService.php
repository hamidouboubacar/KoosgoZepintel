<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;

class OffreService extends Model
{
    use HasFactory;

    protected $fillable = [
    'numero_offre', 
    'objet', 
    'contenu', 
    'client_id', 
    'etat'
];
    
    public function client() {
        return $this->belongsTo(Client::class);
    }
}
