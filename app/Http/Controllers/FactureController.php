<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\FactureType;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use App\Models\FacturePackage;
use Illuminate\Support\Str;
use App\Utils\Download;

class FactureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Facture";
        $factures = Document::where('etat', 1)->where('type', 'Facture')->orderBy('id', 'desc')->get();
        return view("factures.index", compact("factures", "title"));
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function avoir()
    {
        $title = "Facture d'avoir";
        $factures = Document::where('etat', 1)->where('type', 'FactureAvoir')->orderBy('id', 'desc')->get();
        return view("factures.avoir", compact("factures", "title"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Créer une facture";
        $packages = Package::all();
        $facture_types = FactureType::all();
        $clients = Client::all();
        $factures = Document::where('etat', 1)->where('type', 'Facture')->orderBy('id', 'desc')->get();
        return view("factures.create", compact("title", "packages", "facture_types", "clients", "factures"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $title = "Facture";
        $factures = Facture::latest()->get();
        
        // 1. La validation
        $this->validate($request, [
            "type" => 'bail|required|string|max:255',
            "reference" => 'bail|required|string|max:255',
            "numero" => 'bail|required|string|max:255',
            "date" => 'bail|required|string|max:255',
            "tva" => 'nullable',
            "user_id" => 'nullable',
            "client_id" => 'bail|required|integer',
            "periode" => 'bail|required|string|max:255',
            "type" => 'bail|required|string|max:255',
            "montantttc" => 'bail|required|integer',
            "montantht" => 'bail|required|integer',
        ]);

        // 3. On enregistre les informations du Post
        $facture = Facture::create([
            "type" => $request->type,
            "reference" => $request->reference,
            "numero" => $request->numero,
            "date" => $request->date,
            "tva" => $request->tva,
            "user_id" => Auth::id(),
            "client_id" => $request->client_id,
            "periode" => $request->periode,
            "montantttc" => $request->montantttc,
            "montantht" => $request->montantht,
        ]);
        
        // 3. Recuperer les packages
        $keys = $request->except('_token');
        foreach($keys as $id => $value) {
            if(Str::contains($id, 'package-checkbox-')) {
                $_id = explode('-', $id)[2];
                FacturePackage::create([
                    'facture_id' => $facture->id,
                    'package_id' => $_id,
                    'quantite'   => $request["qt-package-$_id"]
                ]);
            }
        }

        // 4. On retourne vers tous les posts : route("posts.index")
        return redirect(route('factures.index'))->with("message", "Enregistrement effectué avec succès !");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function show(Facture $facture)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function edit(Facture $facture)
    {
        $item = $facture;
        $title = "Modifier une facture";
        $packages = Package::all();
        $facture_types = FactureType::all();
        $clients = Client::all();
        $facture_packages = [];
        $facture_package_qt = [];
        $facture_packages_ = FacturePackage::where("facture_id", $facture->id)->get();
        foreach($facture_packages_ as $cp) {
            array_push($facture_packages, $cp->package_id);
            $facture_package_qt[$cp->package_id] = $cp->quantite;
        }
        return view('factures.update', compact("item", "title", "packages", "facture_types", "clients", "facture_packages", "facture_package_qt"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Facture $facture)
    {
        $title = "Facture";
        $factures = Facture::latest()->get();
        
        // 1. La validation
        $this->validate($request, [
            "type" => 'bail|required|string|max:255',
            "reference" => 'bail|required|string|max:255',
            "numero" => 'bail|required|string|max:255',
            "date" => 'bail|required|string|max:255',
            // "tva" => 'bail|required|string|max:255',
            // "user_id" => 'bail|required|integer',
            "client_id" => 'bail|required|integer',
            "periode" => 'bail|required|string|max:255',
            "type" => 'bail|required|string|max:255',
            // "montantttc" => 'bail|required|integer',
            // "montantht" => 'bail|required|integer',
        ]);

        // 3. On enregistre les informations du Post
        $facture->update([
            "type" => $request->type,
            "reference" => $request->reference,
            "numero" => $request->numero,
            "date" => $request->date,
            "tva" => $request->tva,
            // "user_id" => Auth::id(),
            "client_id" => $request->client_id,
            "periode" => $request->periode,
            "montantttc" => $request->montantttc,
            "montantht" => $request->montantht,
        ]);
        
        // 3. Recuperer les packages
        $keys = $request->except('_token');
        foreach($keys as $id => $value) {
            if(Str::contains($id, 'package-checkbox-')) {
                $fp = FacturePackage::where('facture_id', $facture->id)->where('package_id', explode('-', $id)[2]);
                $_id = explode('-', $id)[2];
                if($fp->exists()) {
                    $fp = $fp->first();
                    $fp->update([
                        'quantite'   => $request["qt-package-$_id"]
                    ]);
                } else {
                    FacturePackage::create([
                        'facture_id' => $facture->id,
                        'package_id' => $_id,
                        'quantite'   => $request["qt-package-$_id"]
                    ]);
                }
            }
        }
        
        // 4. Supprimer les packages decochés
        $facture_packages = FacturePackage::where('facture_id', $facture->id)->get();
        foreach($facture_packages as $facture_package) {
            $nonCoche = true;
            foreach($keys as $id => $value) {
                if(Str::contains($id, 'package-checkbox-') && $facture_package->package_id == explode('-', $id)[2]) {
                    $nonCoche = false;
                }
            }
            
            if($nonCoche) $facture_package->delete();
        }

        // 5. On retourne vers tous les posts : route("posts.index")
        return redirect(route('factures.index'))->with("message", "Modification effectuée avec succès !");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function destroy(Facture $facture)
    {
        $facture->delete();
        return back()->with("message", "Suppression effectuée avec succès!");
    }
    
    /**
     * Telecharger une facture
     *
     * @param  \App\Models\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function download(Facture $facture)
    {
        return Download::facture($facture);
    }
}
