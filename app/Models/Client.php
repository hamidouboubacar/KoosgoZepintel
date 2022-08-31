<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Stmt\Return_;

class Client extends Model
{
    use HasFactory;

    protected $fillable= [
        'name',
        'code_client',
        'telephone',
        'adresse',
        'type',
        'user_id',
        'ifu',
        'rccm',
        'ville',
        'pays',
        'etat',
        'email',
        'longitude',
        'latitude',
        'recurrence',
        'numero_paiement'
    ];
    protected $table = "clients";



    public function scopeActifs($query){
        return $query->where('etat', 1)->where('type', 'Client')->orderBy('id', 'desc');
    }

    public function scopeActifsProspects($query){
        return $query->where('etat', 1)->where('type', 'Prospect')->orderBy('id', 'desc');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function documents()
    {
        return $this->hasMany('App\Models\Document');
    }

     public function bonCommandes()
    {
        return $this->hasMany('App\Models\BonCommande');
    }

    public function packagesselections()
    {
        return $this->belongsToMany('App\Models\PackagesSelection');
    }

}
