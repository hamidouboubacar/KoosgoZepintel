<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentPackage extends Model
{
    use HasFactory;
    
    protected $fillable = [
    'nom_package',
    'document_id', 
    'package_id', 
    'quantite',
    'prix_unitaire',
];


    public function package()
    {
        return $this->belongsTo('App\Models\Package');
    }
}
