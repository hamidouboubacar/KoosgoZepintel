<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonCommande extends Model
{
    use HasFactory;

    protected $fillable= [
        'type',
        'numero',
        'etat',
        'reference',
        'echeance',
        'date',
        'fichier',
        'client_id',
    ];

    public function scopeActifs($query){
        return $query->where('etat', 1)->orderBy('id', 'desc');
    }

    public function client(){
        return $this->belongsTo('App\Models\Client');
    }
}
