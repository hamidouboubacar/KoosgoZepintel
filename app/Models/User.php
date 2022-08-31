<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'etat',
        'telephone',
        'fonction_id',
        'whoIs',
        'signataire',
        'client_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
        'api_token'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

     public function fonction(){
        return $this->belongsTo('App\Models\Fonction');
    }


    public function scopeActifs($query){
        return $query->where('etat', 1)->orderBy('id', 'desc');
    }

    public function role(){
        return $this->hasOne("App\Models\Role");
    }

    public function permissions()
    {
        return $this->belongsToMany('App\Models\Role');
    }

    public function clients(){
        return $this->belongsToMany('App\Models\Client');
    }

    public function documents()
    {
        return $this->belongsToMany('App\Models\Document');
    }

    public function paiements()
    {
        return $this->belongsToMany('App\Models\Paiement');
    }
}
