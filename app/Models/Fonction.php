<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fonction extends Model
{
    protected $fillable= ['name','etat'];
    use HasFactory;

    public function users(){
        return $this->hasMany('App\Models\User');
    }

    public function scopeActifs($query){
        return $query->where('etat', 1)->orderBy('id', 'desc');
    }
}
