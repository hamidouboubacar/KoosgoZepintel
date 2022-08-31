<?php

namespace App\Http\Controllers;

use App\Models\BonCommande;
use App\Models\Client;
use Illuminate\Http\Request;

class BonCommandeController extends Controller
{
    //
    public function index(){
        $bonCommandes = BonCommande::Actifs()->get();
        $clients = Client::all()->where('etat',1);
        return view('bonCommande.index',[
            'bonCommandes'=>$bonCommandes,
            'clients'=>$clients,
        ]);
    }

    public function store(Request $request){
        $bonCommandes = BonCommande::Actifs()->get();
        $data = $request->validate([
            'numero' => 'nullable',
            'client_id' => 'nullable|string',
            'code_client' => 'nullable',
            'reference' => 'nullable',
            'echeance' => 'nullable',
            'date' => 'nullable',
            'fichier' => 'nullable',
           
        ]);
        if($request->hasFile('fichier')){
            $destionation_path = 'public/bcc';
            $document = $request->fichier;
            $data['fichier']  = $document->getClientOriginalName();
            $document_name = $document->getClientOriginalName();
            $document->storeAs($destionation_path,$document_name);
        }
        $data['type'] = 'BC';
        BonCommande::create($data);
        return view('bonCommande.index',[
            'bonCommandes'=>$bonCommandes,
            'clients'=>Client::all()->where('etat', 1),
        ]);
    }

    
    public function show(BonCommande $bonCommande){
        return view('bonCommande.show',[
            'bonCommande'=>$bonCommande,
        ]);
    }

    public function delete(BonCommande $bonCommande){
        $bonCommande->etat=0;
        $bonCommande->save();
        return back()->with("message", "Le bon de commande est supprimé avec succès!");
    }
}
