<?php

namespace App\Http\Controllers;

use App\Models\BonCommande;
use App\Models\BonLivraison;
use App\Models\Client;
use App\Models\Document;
use App\Models\DocumentPackage;
use App\Models\Package;
use App\Models\Paiement;
use App\Models\DocumentProduit;
use App\Models\Entreprise;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use NumberToWords\NumberToWords;
use PDF;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Devis";
        $devis = Document::where('etat', 1)->where('type', 'Devis')->orderBy('id', 'desc')->get();
        return view("document.index", compact("devis", "title"));
    }

    public function create(Request $request){
        $route = isset($request->redirect) ? $request->redirect : route("document.index");
        $date = new Carbon();
        $packages = Package::all();
        $date = $date->format('d-m-Y');
        $client = isset($request->client) ? Client::find($request->client) : null;
        $item = isset($request->parent_id) ? Document::find($request->parent_id) : null;
        $document_type = isset($request->type) ? $request->type : "Devis";
        
        $data = [
            'client'  => $client,
            'clients' => Client::all(),
            'users' => User::all(),
            'packages'  => $packages,
            'date'   => $date,
            'document_type' => $document_type,
            'redirect' => $route,
            'code' => $this->genererCode($client, $document_type),
            'user_id' => Auth::id(),
            'factures' => Document::where('etat', 1)->where('type', 'Facture')->orderBy('id', 'desc')->get()
        ];
        
        if(isset($request->parent_id)) {
            $facture_packages = [];
            $facture_package_qt = [];
            $facture_package_id = [];
            $facture_package_mt = [];
            $facture_package_nom = [];
            $facture_packages_ = DocumentPackage::where("document_id", $request->parent_id)->get();
            foreach($facture_packages_ as $cp) {
                array_push($facture_packages, $cp->package_id);
                $facture_package_qt[$cp->package_id] = $cp->quantite;
                $facture_package_mt[$cp->package_id] = $cp->prix_unitaire;
                $facture_package_id[$cp->package_id] = $cp->id;
                $facture_package_nom[$cp->package_id] = $cp->nom_package;
            }
            $document = Document::find($request->parent_id);
            $data["parent_id"] = $request->parent_id;
            $data["facture_packages"] = $facture_packages;
            $data["facture_package_qt"] = $facture_package_qt;
            $data["facture_package_id"] = $facture_package_id;
            $data["facture_package_mt"] = $facture_package_mt;
            $data["facture_package_nom"] = $facture_package_nom;
            $data["item"] = $document;
            $data["client"] = Client::find($document->client_id);
        }
        
        return view('document.create', $data);
    }

    public function livraison(Document $document){
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
        'facture_packages'  =>$facture_packages,
        'facture_package_qt' => $facture_package_qt,
        'facture_package_mt' => $facture_package_mt,
    ]); 
    }


    public function store (Request $request){
        // dd($request);
        $route = isset($request->redirect) ? $request->redirect : route("document.index");
        $documents = Document::actifs();
        $document = $documents->where('numero', $request->numero)->get();
        if ($document->isEmpty()) {
            $data = $request->validate([
                'numero' => 'required|string',
                'type' => 'nullable|string',
                'reference' => 'nullable',
                'date' => 'nullable',
                'objet' => 'nullable',
                'remise' => 'nullable',
                'delai_de_livraison' => 'nullable',
                'validite' => 'nullable',
                'commentaire' => 'nullable',
                'condition' => 'nullable',
                'user_id' => 'nullable',
                'client_id' => 'nullable',
                'etat' => 'nullable',
                'montantttc' => 'nullable',
                'montantht' => 'nullable',
                'tva' => 'nullable',
                'parent_id' => 'nullable',
                'reste_a_payer'=> 'nullable',
                'periode'=> 'nullable',
                'suivi_par'=> 'nullable',
                'contact_personne'=> 'nullable',
                'frais_installation' => 'nullable',
                'prix_unitaire' => 'nullable',
                'nom_package' => 'nullable',
            ]);

            
            $data['montantttc'] = str_replace(' ', '', $data['montantttc']);
            $data['montantht'] = str_replace(' ', '', $data['montantht']);
            $data['tva'] = str_replace(' ', '', $data['tva']);
            if ($request->user_id) {
                $data['user_id'] = $data['user_id'];
            }else{
                $data['suivi_par'] = $data['suivi_par'];
                $data['contact_personne'] = $data['contact_personne'];
            }

            if ($data['tva']) {
                $data['tva'] = $data['tva'];
            }else{
                $data['tva'] = 0;
            }
            $data['reste_a_payer'] = $data['montantttc'];
            $client = isset($data['client_id']) && !empty($data['client_id']) ? Client::find($data['client_id']) : null;
            $data['numero'] = $this->genererCode($client, $data['type']);
            $document = Document::create($data);
            
            // Recuperer les packages
            $keys = $request->except('_token');
            foreach($keys as $id => $value) {
                if(Str::contains($id, 'package-checkbox-')) {
                    $_id = explode('-', $id)[2];
                    DocumentPackage::create([
                        'nom_package' => $request["package-nom-$_id"],
                        'document_id' => $document->id,
                        'package_id' => $_id,
                        'prix_unitaire' => $request["mt-package-$_id"],
                        'quantite'   => $request["qt-package-$_id"]
                    ]);
                }
            }
            
            // Recuperer les produits
            $keys = $request->except('_token');
            foreach($keys as $id => $value) {
                if(Str::contains($id, 'index-produit-')) {
                    $_id = explode('-', $id)[2];
                    DocumentProduit::create([
                        'document_id' => $document->id,
                        'objet'       => $request["objet-produit-$_id"],
                        'quantite'    => $request["qt-produit-$_id"],
                        'montant'     => $request["mt-produit-$_id"]
                    ]);
                }
            }
            return redirect($route)->with("message","Enregistrement effectué avec succès !");
        }else
        {
            return redirect($route)->with("error","Ce document existe déjà !");
        }
    }


    public function show (Document $document){
        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('fr');
        $montant_en_chiffre = $numberTransformer->toWords($document->montantttc);
        $client = Client::find($document->client_id);
        $facture_packages_ = DocumentPackage::where("document_id", $document->id)->get();
        $facture_produits_ = DocumentProduit::where("document_id", $document->id)->get(); 
        return view('document.show', [
            'client'=> $client,
            'document'=> $document,
            'montant_en_chiffre'=> $montant_en_chiffre,
            'facture_packages_'=> $facture_packages_,
            'facture_produits_' => $facture_produits_,
        ]);
    }

    public function appercu(Document $document){
        $client = Client::find($document->client_id);
        $facture_packages_ = DocumentPackage::where("document_id", $document->id)->get();
        return view('document.appercu', [
            'client'=> $client,
            'document'=> $document,
            'facture_packages_'=> $facture_packages_,

        ]);
    }

    public function livrer(Request $request){
        $data = $request->validate([
            'numero_bl' => 'required|string',
            'document_id' => 'nullable|string',
        ]);
        BonLivraison::create($data);
        return redirect('client/'.$request->client_id)->with("message","Bon de livraison créer avec success !");
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Document $document)
    {
        $redirect = isset($request->redirect) ? $request->redirect : route("document.index");
        $item = $document;
        $document_type = "Devis";
        $title = "Modification";
        $packages = Package::all();
        $clients = Client::all();
        $users = User::all();
        
        $facture_packages = [];
        $facture_package_id = [];
        $facture_package_qt = [];
        $facture_package_mt = [];
        $facture_package_nom = [];
        $facture_packages_ = DocumentPackage::where("document_id", $document->id)->get();
        
        $document_produits = DocumentProduit::where("document_id", $document->id)->get();
        
        $parent_id = $document->parent_id;
        $parent = $document->type == "FactureAvoir" ? Document::find($document->parent_id) : null;
        foreach($facture_packages_ as $cp) {
            array_push($facture_packages, $cp->package_id);
            $facture_package_qt[$cp->package_id] = $cp->quantite;
            $facture_package_mt[$cp->package_id] = $cp->prix_unitaire;
            $facture_package_id[$cp->package_id] = $cp->id;
            $facture_package_nom[$cp->package_id] = $cp->nom_package;
        }
        return view('document.update', compact("item", "document_type", "title", "packages", "clients", "users","facture_packages", "facture_package_qt", "facture_package_mt", "redirect", "parent_id", "parent", "document_produits", "facture_package_id", "facture_package_nom"));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        $route = isset($request->redirect) ? $request->redirect : route("document.index");
        $title = "Facture";
        
        // 1. La validation
        $data = $request->validate([
            'numero' => 'required|string',
            'type' => 'nullable|string',
            'reference' => 'nullable',
            'date' => 'nullable',
            'objet' => 'nullable',
            'remise' => 'nullable',
            'delai_de_livraison' => 'nullable',
            'validite' => 'nullable',
            'commentaire' => 'nullable',
            'condition' => 'nullable',
            'user_id' => 'nullable',
            'client_id' => 'nullable',
            'etat' => 'nullable',
            'montantttc' => 'nullable',
            'montantht' => 'nullable',
            'tva' => 'nullable',
            'parent_id' => 'nullable',
            'periode' => 'nullable',
            'frais_installation' => 'nullable'
        ]);

        // 3. On enregistre les informations du Post
        $data['user_id'] = $data['user_id'];
        $data['montantttc'] = str_replace(' ', '', $data['montantttc']);
        $data['montantht'] = str_replace(' ', '', $data['montantht']);
        $data['tva'] = str_replace(' ', '', $data['tva']);
    if($data['tva']==''){
        $data['tva'] = 0;
    }
        $document->update($data);

        // 4. Supprimer les packages decochés
        $keys = $request->except('_token');
        $facture_packages = DocumentPackage::where('document_id', $document->id)->get();
        foreach($facture_packages as $facture_package) {
            $nonCoche = true;
            foreach($keys as $id => $value) {
                if(Str::contains($id, 'package-checkbox-') && $facture_package->package_id == explode('-', $id)[2]) {
                    $nonCoche = false;
                }
            }
            
            if($nonCoche) $facture_package->delete();
        }
        
        // Supprimer les lignes de produits
        $keys = $request->except('_token');
        $document_produits = DocumentProduit::where('document_id', $document->id)->get();
        foreach($document_produits as $document_produit) {
            $nonCoche = true;
            foreach($keys as $id => $value) {
                if(Str::contains($id, 'update-produit-') && $document_produit->id == explode('-', $id)[2]) {
                    $nonCoche = false;
                } 
            }
            
            if($nonCoche) $document_produit->delete();
        }
        
        // 4. Recuperer les packages et les produits
        $facture_packages = DocumentPackage::where('document_id', $document->id)->get();
        foreach($facture_packages as $facture_package) {
            $_id = $facture_package->package_id;
            $facture_package->quantite = $request["qt-package-$_id"];
            $facture_package->prix_unitaire = $request["mt-package-$_id"];
            $facture_package->nom_package = $request["package-nom-$_id"];
            $facture_package->save();
        }

        $keys = $request->except('_token');
        foreach($keys as $id => $value) {
            if(Str::contains($id, 'package-checkbox-')) {
                $fp = DocumentPackage::where('document_id', $document->id)->where('package_id', explode('-', $id)[2]);
                $_id = explode('-', $id)[2];
                if($fp->exists()) {
                    //
                } else {
                    DocumentPackage::create([
                        'nom_package' => $request["package-nom-$_id"],
                        'document_id' => $document->id,
                        'package_id' => $_id,
                        'quantite'   => $request["qt-package-$_id"],
                        'prix_unitaire'   => $request["mt-package-$_id"]
                    ]);
                }
            } 
        }

        $keys = $request->except('_token');
        foreach($keys as $id => $value) {
            if(Str::contains($id, 'index-produit-')) {
                $_id = explode('-', $id)[2];
                DocumentProduit::create([
                    'document_id' => $document->id,
                    'objet'       => $request["objet-produit-$_id"],
                    'quantite'    => $request["qt-produit-$_id"],
                    'montant'     => $request["mt-produit-$_id"]
                ]);
            }
        }

        $keys = $request->except('_token');
        foreach($keys as $id => $value) {
            if(Str::contains($id, 'update-produit-')) {
                $_id = explode('-', $id)[2];
                $produit = DocumentProduit::find($_id);
                if($produit) $produit->update([
                    'document_id' => $document->id,
                    'objet'       => $request["objet-produit-$_id"],
                    'quantite'    => $request["qt-produit-$_id"],
                    'montant'     => $request["mt-produit-$_id"]
                ]);
            }
        }

        // On retourne vers tous les posts : route("posts.index")
        return redirect($route)->with("message", "Modification effectuée avec succès !");
    }

    public function destroy(Document $document){
        $document->etat=0;
        $document->save();
        return back()->with("message", "Le document avec le numéro '$document->numero' est supprimé avec succès!");
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


    public function exportDevis(Document $document, $sans_signature){
        // dd($sans_signature);
        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('fr');
        $pdf = new Dompdf(array('log_output_file' => ''));
        $client = $document->client;
        $selections = DocumentPackage::where("document_id", $document->id)->get();
        $name = $document->numero;
        $total = $numberTransformer->toWords($document->montantttc);
        $reste_a_payer = $document->reste_a_payer;
        $Today = date('d-M-Y');
        $commercial = $document->user;
        $entreprise = Entreprise::first();
        $facture_produits_ = DocumentProduit::where("document_id", $document->id)->get(); 
        if($document->type == 'Facture'){
            $user = User::where("signataire", 2)->first();
        }else{
            $user = User::where("signataire", 1)->first();
        }
         
        
        $pdf = PDF::loadView('document.export.exportDevis', [
            'selections' => $selections,
            'commercial' => $commercial,
            'document' => $document,
            'total' => $total,
            'date' => $Today,
            'reste_a_payer' => $reste_a_payer,
            'client'  => $client,
            'entreprise'  => $entreprise,
            'sans_signature'  => $sans_signature,
            'facture_produits_'  => $facture_produits_,
            'user'  => $user,
        ]);

        // return $pdf->stream();
        return $pdf->stream($name . '.pdf');
    }


    public function exportBon(Document $document){
          // dd($sans_signature);
          $pdf = new Dompdf(array('log_output_file' => ''));
          $client = $document->client;
          $selections = DocumentPackage::where("document_id", $document->id)->get();
          $name = $document->numero;
          $Today = date('d-M-Y');
          $commercial = $document->user;
          $entreprise = Entreprise::first();
          $facture_produits_ = DocumentProduit::where("document_id", $document->id)->get(); 

  
          $pdf = PDF::loadView('document.export.livraison', [
              'selections' => $selections,
              'commercial' => $commercial,
              'document' => $document,
              'date' => $Today,
              'entreprise' => $entreprise,
              'facture_produits_' => $facture_produits_,
          ]);
  
          // return $pdf->stream();
          return $pdf->stream($name . '.pdf');

    }   
    
    public function exportRecu(Paiement $paiement){
        $document = $paiement->document;
        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('fr');
        $pdf = new Dompdf(array('log_output_file' => ''));
        $client = $document->client;
        $selections = DocumentPackage::where("document_id", $document->id)->get();
        $name = $document->numero;
        $total = $numberTransformer->toWords($document->montantttc);
        $reste_a_payer = $document->reste_a_payer;
        $Today = date('d-M-Y');
        $commercial = $document->user;
        $entreprise = Entreprise::first();
        $facture_produits_ = DocumentProduit::where("document_id", $document->id)->get(); 

          $pdf = PDF::loadView('document.export.recu', [
            'selections' => $selections,
            'commercial' => $commercial,
            'document' => $document,
            'total' => $total,
            'date' => $Today,
            'reste_a_payer' => $reste_a_payer,
            'client'  => $client,
            'entreprise'  => $entreprise,
            'facture_produits_'  => $facture_produits_,
          ]);
          return $pdf->stream($name . '.pdf');

    }

    

    public function facturer(Request $request, Document $document){
        $redirect = isset($request->redirect) ? $request->redirect : "document.index";
        $item = $document;
        $document_type = "Devis";
        $title = "Modification";
        $packages = Package::all();
        $clients = Client::all();
        $facture_packages = [];
        $facture_package_qt = [];
        $facture_package_mt = [];
        $facture_package_nom = [];
        
        $users = User::all();
        $facture_packages_ = DocumentPackage::where("document_id", $document->id)->get();
        foreach($facture_packages_ as $cp) {
            array_push($facture_packages, $cp->package_id);
            $facture_package_qt[$cp->package_id] = $cp->quantite;
            $facture_package_mt[$cp->package_id] = $cp->prix_unitaire;
            $facture_package_nom[$cp->package_id] = $cp->nom_package;
        }
        return view('document.facturer', compact("item", "document_type", "title", "users", "packages", "clients", "facture_packages", "facture_package_qt", "facture_package_mt", "redirect", "document", "facture_package_nom"));
    }


    public function factureration(Request $request, Document $document){
        $documents = Document::actifs();
        $document = $documents->where('numero', $request->numero)->get();
        if ($document->isEmpty()) {
            $data = $request->validate([
                'numero' => 'required|string',
                'type' => 'nullable|string',
                'reference' => 'nullable',
                'date' => 'nullable',
                'objet' => 'nullable',
                'remise' => 'nullable',
                'delai_de_livraison' => 'nullable',
                'validite' => 'nullable',
                'commentaire' => 'nullable',
                'condition' => 'nullable',
                'user_id' => 'nullable',
                'client_id' => 'nullable',
                'etat' => 'nullable',
                'montantttc' => 'nullable',
                'montantht' => 'nullable',
                'tva' => 'nullable',
                'reste_a_payer'=> 'nullable',
                'periode'=> 'nullable',
                'suivi_par'=> 'nullable',
                'contact_personne'=> 'nullable',
                'frais_installation' => 'nullable',
                'prix_unitaire' => 'nullable'
            ]);
            if ($request->user_id) {
                $data['user_id'] = $data['user_id'];
            }else{
                $data['suivi_par'] = $data['suivi_par'];
                $data['contact_personne'] = $data['contact_personne'];
            }
            $data['reste_a_payer'] = $data['montantttc'];
            $client = $request->client_id;
            $data['numero'] = $request->numero;
            $document = Document::create($data);
        
            
            // Recuperer les packages
            $keys = $request->except('_token');
            foreach($keys as $id => $value) {
                if(Str::contains($id, 'package-checkbox-')) {
                    $_id = explode('-', $id)[2];
                    DocumentPackage::create([
                        'nom_package' => $request["package-nom-$_id"],
                        'document_id' => $document->id,
                        'package_id' => $_id,
                        'prix_unitaire' => $request["mt-package-$_id"],
                        'quantite'   => $request["qt-package-$_id"]
                    ]);
                }
            }
            return redirect('client/'.$request->client_id)->with("message","Document ajouté avec succès !");
        }else
        {
            return redirect('client/'.$request->client_id)->with("error","Ce document existe déjà !");
        }

    }

    
    public function paiement(Document $document){
        $date = new Carbon();
     return view('client.paiement', [
         'document' => $document,
         'date'=>$date
     ]);
        
    }

    public function resume(){
        $chiffres_affaire = Document::where('type', 'Facture')->where('etat', 1)->sum('montantttc');
        $montant_recouvrer = Document::where('type', 'Facture')->where('etat', 1)->sum('total_versement');
        $encours = Document::where('type', 'Facture')->where('etat', 1)->sum('reste_a_payer');
        return view('document.resume', [
            'document_devis' => Document::where('type', 'Devis')->where('etat', 1)->orderBy('id', 'desc')->get(),
            'document_factures' => Document::where('type', 'Facture')->where('etat', 1)->orderBy('id', 'desc')->get(),
            'document_impayes' => Document::where('type', 'Facture')->where('reste_a_payer', '>', 0)->where('etat', 1)->orderBy('id', 'desc')->get(),
            'document_livrer' => BonLivraison::where('etat', 1)->orderBy('id', 'desc')->get(),
            'bonCommandes' => BonCommande::where('etat', 1)->orderBy('id', 'desc')->get(),
            'chiffres_affaire'=>$chiffres_affaire,
            'montant_recouvrer'=>$montant_recouvrer,
            'encours'=>$encours,
        ]);
    }


    public function search(Request $request){
       
        if ($request->method() == 'GET') {
            $date_debut = Carbon::today()->startOfMonth();
            $date_fin = Carbon::today()->endOfMonth();
        } else {
        $date_debut = $request->date_debut;
        $date_fin = $request->date_fin;
        $chiffres_affaire = Document::where('type', 'Facture')->where('etat', 1)->whereBetween('date',[$date_debut, $date_fin])->sum('montantttc');
        $montant_recouvrer = Document::where('type', 'Facture')->where('etat', 1)->whereBetween('date',[$date_debut, $date_fin])->sum('total_versement');
        $encours = Document::where('type', 'Facture')->where('etat', 1)->whereBetween('date',[$date_debut, $date_fin])->sum('reste_a_payer');
        }
       
        return view("document.resume",[ 
            'document_devis' => Document::where('type', 'Devis')->whereBetween('date',[$date_debut, $date_fin])->where('etat', 1)->orderBy('id', 'desc')->get(),
            'document_factures' => Document::where('type', 'Facture')->whereBetween('date',[$date_debut, $date_fin])->where('etat', 1)->orderBy('id', 'desc')->get(),
            'document_impayes' => Document::where('type', 'Facture')->whereBetween('date',[$date_debut, $date_fin])->where('reste_a_payer', '>', 0)->where('etat', 1)->orderBy('id', 'desc')->get(),
            'document_livrer' => BonLivraison::where('etat', 1)->whereBetween('created_at',[$date_debut, $date_fin])->orderBy('id', 'desc')->get(),
            'bonCommandes' => BonCommande::where('etat', 1)->whereBetween('date',[$date_debut, $date_fin])->orderBy('id', 'desc')->get(),
            'chiffres_affaire'=>$chiffres_affaire,
            'montant_recouvrer'=>$montant_recouvrer,
            'debut'=>$date_debut,
            'fin'=>$date_fin,
            'encours'=>$encours,
        ]);
    }

    public function rapportJournalier(){
        $date = new Carbon();
        $date = date_format($date,'Y-m-d');
        $documents = Document::where('etat', 1)->where('date', $date)->orderBy('id', 'desc')->get();
        $chiffres_affaire = Document::where('type', 'Facture')->where('date', $date)->where('etat', 1)->sum('montantttc');
        $montant_recouvrer = Document::where('type', 'Facture')->where('date', $date)->where('etat', 1)->sum('total_versement');
        $encours = Document::where('type', 'Facture')->where('date', $date)->where('etat', 1)->sum('reste_a_payer');
        $document_devis =  Document::where('type', 'Devis')->where('date', $date)->where('etat', 1)->orderBy('id', 'desc')->get();
        return view('document.rapportJour', [
            'documents' => $documents,
            'document_devis' => $document_devis,
            'document_factures' => Document::where('type', 'Facture')->where('date', $date)->where('etat', 1)->orderBy('id', 'desc')->get(),
            'chiffres_affaire'=>$chiffres_affaire,
            'montant_recouvrer'=>$montant_recouvrer,
            'encours'=>$encours,
        ]);

    } 
    public function rapportHebdomadaire(){
        $date = new Carbon();
        $weekStartDate = $date->startOfWeek()->format('Y-m-d');
        $weekEndDate = $date->endOfWeek()->format('Y-m-d');
        $documents = Document::where('etat', 1)->whereBetween('date',[$weekStartDate, $weekEndDate])->orderBy('id', 'desc')->get();
        $chiffres_affaire = Document::where('type', 'Facture')->whereBetween('date',[$weekStartDate, $weekEndDate])->where('etat', 1)->sum('montantttc');
        $montant_recouvrer = Document::where('type', 'Facture')->whereBetween('date',[$weekStartDate, $weekEndDate])->where('etat', 1)->sum('total_versement');
        $encours = Document::where('type', 'Facture')->whereBetween('date',[$weekStartDate, $weekEndDate])->where('etat', 1)->sum('reste_a_payer');
        $document_devis =  Document::where('type', 'Devis')->whereBetween('date',[$weekStartDate, $weekEndDate])->where('etat', 1)->orderBy('id', 'desc')->get();
        return view('document.rapportHebdomadaire', [
            'documents' => $documents,
            'document_devis' => $document_devis,
            'document_factures' => Document::where('type', 'Facture')->whereBetween('date',[$weekStartDate, $weekEndDate])->where('etat', 1)->orderBy('id', 'desc')->get(),
            'chiffres_affaire'=>$chiffres_affaire,
            'montant_recouvrer'=>$montant_recouvrer,
            'encours'=>$encours,
        ]);

    }

    public function rapportMensuel(){
        $date = new Carbon(); 
        $monthStartDate = $date->startOfMonth()->format('Y-m-d');
        $monthEndDate = $date->endOfMonth()->format('Y-m-d');
        $documents = Document::where('etat', 1)->whereBetween('date',[$monthStartDate, $monthEndDate])->orderBy('id', 'desc')->get();
        $chiffres_affaire = Document::where('type', 'Facture')->whereBetween('date',[$monthStartDate, $monthEndDate])->where('etat', 1)->sum('montantttc');
        $montant_recouvrer = Document::where('type', 'Facture')->whereBetween('date',[$monthStartDate, $monthEndDate])->where('etat', 1)->sum('total_versement');
        $encours = Document::where('type', 'Facture')->whereBetween('date',[$monthStartDate, $monthEndDate])->where('etat', 1)->sum('reste_a_payer');
        $document_devis =  Document::where('type', 'Devis')->whereBetween('date',[$monthStartDate, $monthEndDate])->where('etat', 1)->orderBy('id', 'desc')->get();
        return view('document.rapportMensuel', [
            'documents' => $documents,
            'document_devis' => $document_devis,
            'document_factures' => Document::where('type', 'Facture')->whereBetween('date',[$monthStartDate, $monthEndDate])->where('etat', 1)->orderBy('id', 'desc')->get(),
            'chiffres_affaire'=>$chiffres_affaire,
            'montant_recouvrer'=>$montant_recouvrer,
            'encours'=>$encours,
        ]);

    }
    
    /**
     * Liste des facture
     * 
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function factures(Request $request) {
        $factures = Document::where("type", "Facture")->get();
        return response()->json($factures);
    }

    /**
     * Update DocumentPackage
     * 
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function update_document_pacakge(Request $request) {
        $dp = DocumentPackage::find($request->id);
        $dp->update([
            'quantite' => $request->quantite,
            'prix_unitaire' => $request->prix_unitaire
        ]);
        return response()->json($dp);
    }
}
