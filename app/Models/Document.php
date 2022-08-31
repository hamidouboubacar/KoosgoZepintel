<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $appends = ['perio'];

    protected $fillable= [
        'numero',
        'type',
        'reference',
        'date',
        'objet',
        'remise',
        'delai_de_livraison',
        'validite',
        'commentaire',
        'montantttc',
        'montantht',
        'condition',
        'user_id',
        'client_id',
        'etat',
        'tva',
        'parent_id',
        'reste_a_payer',
        'total_versement',
        'periode',
        'suivi_par',
        'contact_personne',
        'frais_installation'
    ];

    public function scopeActifs($query){
        return $query->where('etat', 1)->orderBy('id', 'desc');
    }

    public function client(){
        return $this->belongsTo('App\Models\Client');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }


    public function packagesselections()
    {
        return $this->belongsToMany('App\Models\PackagesSelection');
    }


    public function paiements()
    {
        return $this->hasMany('App\Models\Paiement');
    }

    public function documentPackages()
    {
        return $this->hasMany('App\Models\DocumentPackage');
    }
    public function bonLivraison()
    {
        return $this->hasMany('App\Models\BonLivraison');
    }

    public function getPerioAttribute()
    {
        switch($this->attributes['periode']){
            case 1:
                return 'Janvier';
                break;
            case 2:
                return 'Février';
                break;
            case 3:
                return 'Mars';
                break;
            case 4:
                return 'Avril';
                break;
            case 5:
                return 'Mai';
                break;
                case 6:
                    return 'Juin';
                    break;
                case 7:
                    return 'Juillet';
                    break;
                case 8:
                    return 'Août';
                    break;
                case 9:
                    return 'Septembre';
                    break;
                case 10:
                    return 'Octobre';
                    break;
                    case 11:
                        return 'Novembre';
                        break;
                    case 12:
                        return 'Décembre';
                        break;
            default:
                return 'Erreur au niveau de la période';
        }
        
        
    }

    public function refacturations(){
        return $this->BelongsToMany('App\Models\Refacturation');
    }
}



