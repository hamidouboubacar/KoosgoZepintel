<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentProduit extends Model
{
    use HasFactory;
    
    protected $fillable = ['document_id', 'objet', 'quantite', 'montant'];
}
