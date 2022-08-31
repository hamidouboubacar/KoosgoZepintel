<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonLivraison extends Model
{
    use HasFactory;

    protected $fillable= [
        'numero_bl',
        'document_id',
        'etat',
    ];

    public function document(){
        return $this->belongsTo('App\Models\Document');
    }
}
