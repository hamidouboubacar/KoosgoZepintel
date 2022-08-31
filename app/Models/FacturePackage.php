<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacturePackage extends Model
{
    use HasFactory;
    
    protected $fillable = ['facture_id', 'package_id', 'quantite'];
}
