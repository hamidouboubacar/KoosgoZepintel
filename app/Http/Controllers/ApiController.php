<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Document;
use App\Models\Paiement;
use App\Models\PaiementEncours;
use App\Models\Client;

class ApiController extends Controller
{
    /**
     * Authentification
     * 
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function login(Request $request) {
        $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);
        $email = $request->email;
        $password = $request->password;

        if(Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = User::where('email', $email)->first();
            return response()->json([
                'success' => true,
                'api_token' => $user->api_token,
                'user_id' => $user->id,
                'client_id' => $user->client_id
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }
    
    /**
     * Liste des factures
     * 
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function factures(Request $request) {
        //Authentification
        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password]))
            return response()->json(['message' => 'Pas Authentifie']);

        $user = Auth::user();
        $factures = Document::join('clients', 'clients.id', '=', 'documents.client_id')
            ->where("documents.type", "Facture")
            ->where("documents.client_id", $user->client_id)
            ->where("documents.etat", 1)
            ->select([
                'documents.id',
                'documents.numero',
                'documents.reference',
                'documents.date',
                'documents.numero',
                'documents.objet',
                'documents.remise',
                'documents.validite',
                'documents.commentaire',
                'documents.montantttc',
                'documents.montantht',
                'documents.condition',
                'documents.user_id',
                'documents.client_id',
                'documents.tva',
                'documents.reste_a_payer',
                'documents.total_versement',
                'documents.periode',
                'documents.suivi_par',
                'documents.contact_personne',
                'clients.name as client',
                'clients.numero_paiement'
            ])->get();
        return response()->json($factures);
        // return response()->json($user);
    }
    
    /**
     * Liste des paiements
     * 
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function paiements(Request $request) {
        $paiements = Paiement::join('documents', 'paiements.document_id', '=', 'documents.id')
            ->where('documents.client_id', $request->client_id)
            ->select([
                'documents.id',
                'documents.numero',
                'documents.reference',
                'documents.date',
                'documents.numero','objet',
                'documents.remise',
                'documents.validite',
                'documents.commentaire',
                'documents.montantttc',
                'documents.montantht',
                'documents.condition',
                'documents.user_id',
                'documents.client_id',
                'documents.tva',
                'documents.reste_a_payer',
                'documents.total_versement',
                'documents.periode',
                'documents.suivi_par',
                'documents.contact_personne',
                'paiements.date_paiement',
                'paiements.date',
                'paiements.montant_payer',
                'paiements.mode_paiement',
                'paiements.user_id',
                'paiements.document_id',
                'paiements.reste'
            ])->get();
            
        return response()->json($paiements);
    }
    
    /**
     * Liste des impayés
     * 
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function impayes(Request $request) {
        $documents = Document::where('client_id', $request->client_id)
            ->whereNull('total_versement')
            ->get();
            
        return response()->json($documents);
    }

    /**
     * Enregistrer un Paiement
     * 
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function paiement(Request $request) {
        // Valider les donnees de la requete
        $data = $request->validate([
            'email' => 'required',
            'password' => 'required',
            'telephone' => 'required',
            'montant' => 'required',
            'id_trans' => 'required'
        ]);
        
        //Authentification
        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password]))
            return response()->json(['message' => /*'Pas Authentifie'*/$data]);

        // Trouver paiement en cours
        $paiement_encours = PaiementEncours::whereRaw("REPLACE(`numero_paiement`, ' ', '') LIKE ?", "%$request->telephone%")
            ->where('etat', 1);

        // Trouver le client par son numero de paiement
        $client = Client::whereRaw("REPLACE(`numero_paiement`, ' ', '') LIKE ?", "%$request->telephone%")
            ->where('etat', 1);

        // Verifier paiement en cours
        if($paiement_encours->exists()) {
            $facture = $paiement_encours->latest('id')->first()->document;
            $this->paiement_facture($facture, $request->montant);
            PaiementEncours::whereRaw("REPLACE(`numero_paiement`, ' ', '') LIKE ?", "%$request->telephone%")
            ->where('etat', 1)->update(['etat' => 0]);
        } elseif($client->exists()) {
            $client = $client->first();
            // Trouver le document facture du client
            $factures = Document::where('client_id', $client->id)->where('type', 'Facture')->where('reste_a_payer', '>', '0')->where('etat', 1)->orderBy('created_at');
            if($factures->exists()) {
                $facture = $factures->first();
                $this->paiement_facture($facture, $request->montant);
            }
        } else $facture = null;

        // Enregistrer la ligne de paiement
        $paiement = Paiement::create([
            'montant_payer' => $request->montant,
            'numero_paiement' => $request->telephone,
            'reste' => isset($facture) && isset($facture->reste_a_payer) ? $facture->reste_a_payer : null,
            'mode_paiement' => 'Orange Money',
            'id_trans' => $request->id_trans,
            'user_id' => Auth::id(),
            'document_id' => isset($facture) && isset($facture->id) ? $facture->id : 1
        ]);
            
        return response()->json([
            'client' => $client ?? null,
            'factures' => $factures ?? null,
            'facture' => $facture ?? null,
            'paiement' => $paiement ?? null
        ]);
    }

    /**
     * Enregistrer un Paiement en cours
     * 
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function paiement_encours(Request $request) {
        $data = $request->validate([
            'document_id' => 'required',
            'numero_paiement' => 'nullable'
        ]);

        $paiement_encours = PaiementEncours::create($data);

        return response()->json($paiement_encours);
    }
    
    /**
     * Enregistrer le paiement d'une facture
     * 
     * @param $fature
     * @param int $montant
     * @return void
     */
    private function paiement_facture($facture, $montant) {
        if($facture->total_versement == null ) $facture->total_versement = (int)$montant;
        else $facture->total_versement = (int)$facture->total_versement + (int)$montant;
        $facture->reste_a_payer = (int)$facture->reste_a_payer - (int)$montant;

        if($facture->total_versement > $facture->montantttc) $facture->total_versement = $facture->montantttc;
        if($facture->reste_a_payer < 0) $facture->reste_a_payer = 0;
        
        $facture->save();
    }
}
