<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackagesSelection extends Model
{
    use HasFactory;

    protected $fillable= [
        'numero_document',
        'reference_packages',
        'libelle_package',
        'prix_unitaire',
        'total',
        'document_id',
        'client_id',
        'etat'
    ];

    public function scopeActifs($query){
        return $query->where('etat', 1)->orderBy('id', 'desc');
    }

    public function client(){
        return $this->belongsTo('App\Models\Client');
    }


    public function document(){
        return $this->belongsTo('App\Models\Document');
    }
}
