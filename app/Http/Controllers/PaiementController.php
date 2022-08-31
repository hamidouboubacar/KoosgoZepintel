<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Document;
use App\Models\Paiement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PaiementController extends Controller
{
    //

    public function index(){
        // $this->authorize("viewAny", "App\Models\Client");
        $paiements = Paiement::actifs()->get();
        return view("paiement.index",[ 'paiements'=> $paiements]);
    }

    public function search(Request $request){
       
        if ($request->method() == 'GET') {
            $date_debut = Carbon::today()->startOfMonth();
            $date_fin = Carbon::today()->endOfMonth();
            $paiements = Paiement::actifs()->get();
        } else {
            
            $date_debut = $request->date_debut;
            $date_fin = $request->date_fin;
            $paiements = Paiement::whereBetween('date_paiement',[$date_debut, $date_fin])->get();
        }
       
        return view("paiement.index",[ 
            'paiements'=> $paiements,
            'debut'=>$date_debut,
            'fin'=>$date_fin,
        ]);
    }

    public function searchReglement(Request $request){
       
        if ($request->method() == 'GET') {
            $date_debut = Carbon::today()->startOfMonth();
            $date_fin = Carbon::today()->endOfMonth();
            $paiements = Paiement::actifs()->get();
        } else {
            
            $date_debut = $request->date_debut;
            $date_fin = $request->date_fin;
            $paiements = Paiement::whereBetween('date_paiement',[$date_debut, $date_fin])->get();
        }
       
        return view("paiement.index",[ 'paiements'=> $paiements]);
    }

    public function store(Request $request){
        $document = Document::find($request->document_id);
        $prospect = $document->client;
       
        $data = $request->validate([
            'numero' => 'required|string',
            'client_id' => 'nullable',
            'montant_payer' => 'nullable|string',
            'date_paiement' => 'nullable',
            'mode_paiement' => 'nullable',
            'document_id' => 'nullable',
            'reste' => 'nullable',
        ]);
        
        $document->total_versement = intval($document->total_versement)+$data['montant_payer'];
        $document->reste_a_payer = $document->reste_a_payer-$data['montant_payer'];
        $document->update();
        $data['reste'] = $document->reste_a_payer;   
        $data['user_id'] = Auth::id();
        Paiement::create($data);
        if($prospect->type =='Prospect'){
            $countClient = Client::where('type', 'Client')->count() + 1;
            $code_client = 'CL'.$countClient;
            $prospect->code_client = $code_client;
            $prospect->type = 'Client';
            $prospect->update();
            
        }
        return redirect('client/'.$document->client_id)->with("message","Paiement effectué avec succès !");
        
    }

    public function paiementsClient(Client $client){
        $documents = $client->documents;
        return view("paiement.paiementClient",[ 'documents'=> $documents, 'client'  =>$client]);
    }


    public function delete(Paiement $paiement){
        $paiement->etat=0;
        $paiement->save();
        return back()->with("message", "Le paiement est supprimé avec succès!");
    }


    public function reglement(){
        $paiements = Paiement::Actifs()->get();
        return view("paiement.reglement",[ 'paiements'=> $paiements]);
    }

    public function mailPaiement(Request $request){
        
        $data = $request->validate([
            'document_id' => 'required|string',
            'paiement_id' => 'required|string',
            'email' => 'nullable|string',
            'emailcc' => 'nullable',
            'objet' => 'nullable',
            'contenu' => 'nullable',
        ]);
        $document = Document::find($request->document_id);
        $paiement = Paiement::find($request->paiement_id);
        Mail::send('client.emailpaiement', ['data'=>$data, 'paiement'=>$paiement], function($message) use ($data, $document) {
                $message->to($data['email'])
                ->subject('PAIEMENT NETFORCE-GROUP');
              });

              return back()->with("message","Mail envoyé avec succès !");
    }
}
