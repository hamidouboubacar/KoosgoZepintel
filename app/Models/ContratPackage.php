<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContratPackage extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'contrat_id', 
        'package_id'
    ];
}
