<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Document;
use App\Models\DocumentPackage;
use App\Models\Refacturation;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class RefacturationController extends Controller
{
    //

    public function index(){
        $this->authorize("viewAny", "App\Models\Refacturation");
        $documents = [];
        $refacturations = DB::table('refacturations')->orderBy('id', 'desc')->get();
        $clients = Client::where('etat', 1)->where('recurrence',1)->get();

        foreach ($clients as $client) {
            $document = Document::where('client_id', $client->id)->where('etat', 1)->where('type', 'Facture')->orderBy('id', 'desc')->first();
            array_push($documents, $document);
           
        }
        return view('refacturation.index', [
            'refacturations'=>$refacturations,
            'documents'=>$documents
        ]);
    }

    public function store(Request $request){
        $date = new Carbon();
        $date = $date->format('d-m-Y');
        $this->authorize("create", "App\Models\Refacturation");

        $data = $request->validate([
            'clients' => 'required',
            'date' => 'required',
            'periode' => 'required',
        ]);
        $refacturation = Refacturation::create();
        foreach ($data['clients'] as $client) {
            $clientCode = Client::find($client);
            $type = 'Facture';
            $lastDocument = Document::where('client_id', $client)->where('type', 'Facture')->orderBy('id', 'desc')->first();
            $document = Document::create([
                'numero' => $this->genererCode($clientCode, $type),
                'type'       =>  $type,
                'reference'    => $lastDocument->numero,
                'date'     => $date,
                'objet' => $lastDocument->objet,
                'validite'       =>  $lastDocument->validite,
                'commentaire'    => $lastDocument->commentaire,
                'montantttc'     => $lastDocument->montantttc,
                'montantht' => $lastDocument->montantht,
                'condition'       =>  $lastDocument->condition,
                'user_id'    => Auth()->user()->id,
                'client_id'     => $lastDocument->client_id,
                'etat' => 3,
                'tva'       => $lastDocument->tva,
                'reste_a_payer'    => $lastDocument->montantttc,
                'total_versement'     => 0,
                'periode' => $data['periode'],
                'suivi_par'       =>  $lastDocument->suivi_par,
                'contact_personne'    => $lastDocument->contact_personne,
            ]);
            $packages = DocumentPackage::where('document_id', $lastDocument->id)->get();
            foreach ($packages as $package) {
                $documentPackage = DocumentPackage::create([
                    'nom_package' => $package->nom_package,
                    'document_id' => $document->id,
                    'package_id'       =>  $package->package_id,
                    'quantite'    => $package->quantite,
                    'prix_unitaire' => $package->prix_unitaire
                ]);
            }
            for($i=0; $i<count($data['clients']); $i++){
                $document->refacturations()->sync($refacturation, [
                    "refacturation_id" => $refacturation->id,
                    'document_id' => $document->id,
                ]);
            }
        } 
        return back()->with("message","Refacturation effectuée avec succès !");
    }

    private function genererCode($client, $type) {
        $total_type = Document::where('type', $type)->count() + 1;
        if(isset($client) && $client != null)
            $total_client = Document::where('type', $type)->where('client_id', $client->id)->count() + 1;
        else $total_client = $total_type;
        
        if($total_type < 10) $prefix = '000';
        elseif($total_type < 100) $prefix = '00';
        elseif($total_type < 1000) $prefix = '0';
        else $prefix = '';
        
        if($type == 'Facture') $fp ='F';
        elseif($type == 'FactureAvoir') $fp = 'FA';
        else $fp ='FP';
        $name = isset($client) && $client != null && isset($client->name) ? str_replace(" ", "", $client->name) : 'client';
        
        $now = \Carbon\Carbon::now();
        $code = "$fp$prefix$total_type/$now->year/$now->month/$now->day/$name/$total_client";
        
        return $code;
    }

    public function show(Refacturation $refacturation){
        return view('refacturation.show', [
            'documents'=> $refacturation->documents,
            'id'=> $refacturation->id,
        ]);
    }

    public function mailGroupe(Request $request){
        $data = $request->validate([
            'refacturation_id' => 'nullable',
            'objet' => 'nullable',
            'contenu' => 'nullable',
        ]);
        $refacturation = Refacturation::find($data['refacturation_id']);
        $documents = $refacturation->documents;
        foreach($documents as $document){
            Mail::send('refacturation.email', ['data'=>$data, 'document_id'=>$document->id], function($message) use ($document) {
                $message->to($document->client->email)
                ->subject($document->type.' NETFORCE-GROUP');
              });
        }
              return back()->with("message","E-mails envoyés avec succès !");

    }
    public function delete(Refacturation $refacturation, Document $document){
        $refacturation->documents()->detach($document->id);
        $document->etat=0;
        $document->save();
        return back()->with("message", "La facture est supprimée avec succès!");
    }

    public function validation(Refacturation $refacturation){
        $documents =  $refacturation->documents;
        foreach ($documents as $document) {
            $document->etat = 1;
            $document->update();
        }
        return back()->with("message","Validation effectuées avec succès !");

    }
}
