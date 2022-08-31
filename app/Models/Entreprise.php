<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    use HasFactory;

    protected $fillable= [
        'name',
        'signature',
        'telephone',
        'adresse',
        'fax',
        'rib',
        'ifu',
        'rccm',
        'ville',
        'pays',
        'bic',
        'email',
        'etat',
        'tva',
        'entete',
        'pieddepage',
        'logo',
        'bic',
        'compte',
        'banque',
        'web',
        'activite',
        'forme_juridique',
    ];

    public function scopeActif($query){
        return $query->where('etat', 1)->orderBy('id', 'desc')->get();
    }
}
