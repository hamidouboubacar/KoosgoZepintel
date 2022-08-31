<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    
    protected $fillable = [
    'nom', 
    'debit_ascendant', 
    'debit_descendant', 
    'montant'
];
}
