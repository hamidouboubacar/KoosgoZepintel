<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;
    
    protected $fillable = ['type', 'reference', 'numero', 'date', 'tva', "user_id", "client_id", 'periode', 'montantttc', 'montantht'];
}
