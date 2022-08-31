<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Refacturation extends Model
{
    use HasFactory;

    public function documents(){
        return $this->BelongsToMany('App\Models\Document');
    }
}
