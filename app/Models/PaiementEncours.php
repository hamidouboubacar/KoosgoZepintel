<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaiementEncours extends Model
{
    use HasFactory;

    protected $fillable = ['document_id', 'numero_paiement', 'etat'];

    public function document() {
        return $this->belongsTo('App\Models\Document');
    }

    public function off() {
        $this->etat = 0;
        $this->save();
    }
}
