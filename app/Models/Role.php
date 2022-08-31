<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ["name", "code", "description", "etat"];

    public function scopeActifs($query){
        return $query->where('etat', 1)->orderBy('id', 'desc')->get();
    }

    public function permissions(){
        return $this->belongsToMany('App\Models\Permission');
    }
    public function users(){
        return $this->belongsToMany("App\Models\User");
    }
}
