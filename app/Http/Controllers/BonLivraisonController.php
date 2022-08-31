<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Document;
use App\Models\DocumentPackage;
use App\Models\Package;
use Illuminate\Http\Request;

class BonLivraisonController extends Controller
{
    //
    public function create(Document $document){
     
    }


    public function show(Document $document){
        dd($document);
        $packages = Package::all();
        $facture_package_qt = [];
        $facture_package_mt = [];
        $facture_packages = [];
        $facture_packages_ = DocumentPackage::where("document_id", $document->id)->get();
        $client = isset($document->client->id) ? Client::find($document->client->id) : null;
        foreach($facture_packages_ as $cp) {
            array_push($facture_packages, $cp->package_id);
            $facture_package_qt[$cp->package_id] = $cp->quantite;
            $facture_package_mt[$cp->package_id] = $cp->prix_unitaire;
        }
    return view('livraison.create', [
        'client'  => $client,
        'document'=>$document,
        'clients' => Client::all(),
        'packages'  => $packages,
        'facture_packages'  => $facture_packages,
        'facture_package_qt'  => $facture_package_qt,
        'facture_package_mt'  => $facture_package_mt
    ]); 
    }

    public function voir(Document $document){
        dd($document);
    }
}
