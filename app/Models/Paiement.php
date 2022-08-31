<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable= [
        'date_paiement',
        'date',
        'montant_payer',
        'mode_paiement',
        'user_id',
        'document_id',
        'etat',
        'reste',
        'id_trans'
    ];


    public function scopeActifs($query){
        return $query->where('etat', 1)->orderBy('id', 'desc');
    }
    public function document(){
        return $this->belongsTo('App\Models\Document');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
