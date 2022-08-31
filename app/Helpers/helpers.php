<?php

use App\Models\Client;
use App\Models\Contrat;
use App\Models\ContratPackage;
use App\Models\Document;
use App\Models\DocumentPackage;
use App\Models\OffreService;
use App\Models\Package;
use App\Models\Paiement;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Exists;
use PhpParser\Node\Expr\Cast;

if(!function_exists('load_clients')){
    function load_clients(){
        DB::connection('O_mysql')->table('client')->orderBy('id')->chunk(1000, function($clients){
            $items = $clients->map(function($item){
                return [
                    'id' => $item->id,
                    'name' => utf8_encode($item->commercial),
                    'code_client'=> $item->code,
                    'telephone'=> $item->tel,
                    'adresse'=> $item->adresse,
                    'type'=> $item->type,
                    'user_id'=> $item->auteur,
                    'user_client_id'=> 0,
                    'ifu' => $item->ifu,
                    'rccm'=> $item->rccm,
                    'ville'=> $item->ville,
                    'pays'=> $item->pays,
                    'etat'=> 1,
                    'email'=> $item->email,
                    'longitude'=> '',
                    'latitude' => '',
                    'recurrence'=> 1,
                    'numero_paiement'=>$item->tel,
                    'created_at'=> $item->date_enreg,
                    'numero_paiement'=> '',
                ];
            });
            Client::insert($items->toArray());
        });

    }

    function load_users(){
        DB::connection('O_mysql')->table('utilisateurs')->orderBy('id')->chunk(1000, function($utilisateurs){
            $items = $utilisateurs->map(function($item){
                return [
                    'id' => $item->id,
                    'name'=> utf8_encode($item->nom).' '.utf8_encode($item->prenom),
                    'email' => $item->email,
                    'password'=> $item->motdepasse,
                    'etat'=> 1,
                    'telephone' => $item->tel,
                    'fonction_id'=> $item->fonction,
                    'whoIs'=> 'NetForce',
                    'client_id'=> null,
                ];
            });
            User::insert($items->toArray());
        });

    }

    function load_packages(){
        DB::connection('O_mysql')->table('article')->orderBy('id')->chunk(1000, function($articles){
            $items = $articles->map(function($item){
                return [
                    'id'=> $item->id,
                    'nom'=> utf8_encode($item->designation),
                    'debit_ascendant'=> null, 
                    'debit_descendant'=> null,
                    'montant'=> $item->pvente,
                    'ref'=> $item->ref,
                ];
            });
            Package::insert($items->toArray());
        });

    }

    function load_contrats(){
        DB::connection('O_mysql')->table('contrat')->orderBy('id')->chunk(1000, function($contrats){
            $items = $contrats->map(function($item){
                $clients = DB::connection('O_mysql')->table('client')->get();
                if($clients->where('commercial', $item->client)->first() == null){
                    var_dump($item->client);
                }
                return [
                    'id'=> $item->id,
                    'client_id' => $item->id_client, 
                    'num_contrat' => $item->num_contrat, 
                    'date' => $item->date, 
                    'content' => null, 
                    'avec_signature' => 1, 
                    'avec_entete' => 1, 
                    'date_expiration' => null,
                ];
            });
            dd('bien');
            Contrat::insert($items->toArray());
        });

    }    
    
    function load_contrat_selects(){
        DB::connection('O_mysql')->table('contrat_select')->orderBy('id')->chunk(1000, function($contrat_selects){
            $items = $contrat_selects->map(function($item){
                $contrats = DB::connection('O_mysql')->table('contrat')->get();
                $articles = DB::connection('O_mysql')->table('article')->get();
                return [
                    'id'=> $item->id,
                    'contrat_id' => $contrats->where('num_contrat', $item->num_contrat)->first()->id, 
                    'package_id' => $articles->where('designation', $item->type_service)->first()->id, 
                ];
            });
            ContratPackage::insert($items->toArray());
        });

    }  
    
    function load_paiements(){
        DB::connection('O_mysql')->table('paiement')->orderBy('id')->chunk(1000, function($paiements){
            $items = $paiements->map(function($item){
            $documents = DB::connection('O_mysql')->table('document')->get();
            if($documents->where('numero', $item->facture)->first()->id != null){
                    $document_id = $documents->where('numero', $item->facture)->first()->id;
                    
            }else{
                $document_id = 0;
            }
            
                return [
                    'id'=> $item->id,
                    'date_paiement'=> $item->date,
                    'date'=> $item->date,
                    'montant_payer'=> $item->paiement,
                    'mode_paiement'=> $item->mode,
                    'user_id'=> $item->auteur,
                    'document_id'=>  $document_id,
                    'etat'=> 1,
                    'reste'=> $item->reste,
                    'id_trans'=> null,
                    'numero_paiement'=> null,
                ];
            });
            Paiement::insert($items->toArray());
        });

    }
    
    function load_offres(){
        DB::connection('O_mysql')->table('offre')->orderBy('id')->chunk(1000, function($offres){
            $items = $offres->map(function($item){
                $clients = DB::connection('O_mysql')->table('client')->get();
                return [
                    'id'=> $item->id,
                    'numero_offre'=> $item->num_offre, 
                    'objet'=> $item->objet, 
                    'contenu'=> $item->corps_offre, 
                    'client_id'=> $clients->where('commercial', $item->client)->first()->id, 
                    'etat'=> 1,
                ];
            });
            OffreService::insert($items->toArray());
        });

    }
    
    function load_documents(){
        DB::connection('O_mysql')->table('document')->orderBy('id')->chunk(1000, function($document){
            $items = $document->map(function($item){ 
                if($item->perio != null){
                    if(iconv_strlen($item->perio) > 3){
                        $perio = explode("-",$item->perio)[1];
                    }else{
                        $perio = $item->perio;
                    }

                }else{
                    $perio = null;
                }
                $clients = DB::connection('O_mysql')->table('client')->get();
                if($clients->where('id', intval($item->id_client))->first() != null){
                    var_dump($item->client, 'pas ok');
                }else{
                    var_dump('...................');
                }

                if(intval($item->montantttc) == intval($item->montantht)){
                    $tva = 0;
                }else{
                    $tva = (intval($item->montantht)*18)/100;
                }

                return [
                    'id'=> $item->id,
                    'numero'=> $item->numero,
                    'type'=> $item->type,
                    'reference'=> $item->ref,
                    'date'=> $item->date,
                    'objet'=> $item->titre,
                    'remise'=> $item->total_remise,
                    'delai_de_livraison'=> $item->delais_livraison,
                    'validite'=> $item->validite,
                    'commentaire'=> $item->commentaire,
                    'montantttc'=> intval($item->montantttc),
                    'montantht'=> intval($item->montantht),
                    'condition'=> null,
                    'user_id'=> $item->auteur,
                    'client_id'=> intval($item->id_client),
                    'etat'=> 1,
                    'tva'=> $tva,
                    'parent_id'=> null,
                    'reste_a_payer'=> $item->reste,
                    'total_versement'=> $item->totat_regle,
                    'periode'=> $perio,
                    'suivi_par'=> null,
                    'contact_personne'=> null,
                ];
            });
            // die();
            Document::insert($items->toArray());
        });

    }
    
    function load_document_packages(){
        DB::connection('O_mysql')->table('selections')->orderBy('id')->chunk(1000, function($selections){
            $items = $selections->map(function($item){
            $documents = DB::connection('O_mysql')->table('document')->get();
            $articles = DB::connection('O_mysql')->table('article')->get();
          
            if($articles->where('ref', $item->ref_produit)->first() == null){
            $id = 37;
            }else{
                $id = $articles->where('ref', $item->ref_produit)->first()->id;
            }
                return [
                    'id'=> $item->id,
                    'document_id'=> $documents->where('numero', $item->ref)->first()->id,
                    'package_id'=> $id,
                    'prix_unitaire'=> intval($item->pu),
                    'quantite'=> $item->qte,
                ];
            });
            // die();
            DocumentPackage::insert($items->toArray());
        });

    }

}