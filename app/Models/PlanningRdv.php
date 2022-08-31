<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanningRdv extends Model
{
    use HasFactory;
    
    protected $fillable = ['date', 'commercial_id', 'client_id'];
}
