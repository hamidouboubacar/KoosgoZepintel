<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Fonction;
use App\Models\Paiement;
use DB;

class CommercialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Commercial";
        $commercials = User::join('fonctions', 'users.fonction_id', '=', 'fonctions.id')
            ->where('fonctions.name', 'LIKE', 'Commercial%')
            ->where('users.etat', '1')
            ->select('users.id', 'users.name', 'users.telephone', 'users.email')
            ->orderBy('id', 'desc')
            ->get();
        $fonction = Fonction::where('name', 'Commerciale')->first();
        $type_create = true;
        return view("commercials.index", compact("commercials", "title", "fonction", "type_create"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize("create", "App\Models\Commercial");
        
        // 1. La validation
        $this->validate($request, [
            "name" => 'bail|required|string|max:255',
            "email" => 'bail|required|string|max:255',
        ]);
        
        try {
            $fonction = Fonction::where('fonctions.name', 'LIKE', 'Commercial%')->first();
            User::create([
                "name" => $request->name,
                "telephone" => $request->telephone,
                "email" => $request->email,
                "fonction_id" => $fonction->id,
                "password" => Hash::make($request->password)
            ]);
            
            $message = "Enregistrement effectué avec succès !";
        } catch(QueryException $e) {
            $message = "L'adresse email doit être unique";
        } catch(Exception $e) {
            $message = "Echec de l'enregistrement";
        }
        
        
        return back()->with("message", $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commercial  $commercial
     * @return \Illuminate\Http\Response
     */
    public function show(User $commercial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Commercial  $commercial
     * @return \Illuminate\Http\Response
     */
    public function edit(User $commercial)
    {
        $this->authorize("update", $commercial);
        $item = $commercial;
        return view("commercials.modals.edit", compact("item"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commercial  $commercial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $commercial)
    {
        $this->authorize("update", $commercial);
        $commercial->update($request->all());
        return back()->with("message", "Modification effectuée avec succès");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commercial  $commercial
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $commercial)
    {
        $this->authorize("delete", $commercial);
        $commercial->etat = 0;
        $commercial->save();
        return back()->with("message", "Suppression effectuée avec succès!");
    }
    
    public function statistiques() {
        $title = "Statistiques de la force de vente";
        
        /**
         * Clients
         */
        $clients = User::join('fonctions', 'users.fonction_id', '=', 'fonctions.id')
            ->join('clients', 'users.id', '=', 'clients.user_id')
            ->where('fonctions.name', 'LIKE', 'Commercial%')
            ->where('clients.type', 'Client')
            ->where('users.etat', '1')
            ->select('users.name as name', DB::raw('count(*) as total'))
            ->groupBy('name')
            ->pluck('total', 'name')
            ->all();

        /**
         * Prospects
         */
        $prospects = User::join('fonctions', 'users.fonction_id', '=', 'fonctions.id')
            ->join('clients', 'users.id', '=', 'clients.user_id')
            ->where('fonctions.name', 'LIKE', 'Commercial%')
            ->where('clients.type', 'Prospect')
            ->where('users.etat', '1')
            ->select('users.name as name', DB::raw('count(*) as total'))
            ->groupBy('name')
            ->pluck('total', 'name')
            ->all();

        /**
         * Prospects contactés
         */
        $prospects_contactes = User::join('fonctions', 'users.fonction_id', '=', 'fonctions.id')
            ->join('planning_rdvs', 'planning_rdvs.commercial_id', '=', 'users.id')
            ->join('clients', 'planning_rdvs.client_id', '=', 'clients.id')
            ->where('fonctions.name', 'LIKE', 'Commercial%')
            ->where('clients.type', 'Prospect')
            ->where('users.etat', '1')
            ->select('users.name as name', DB::raw('count(*) as total'))
            ->groupBy('name')
            ->pluck('total', 'name')
            ->all();

        /**
         * Clients contactés
         */
        $clients_contactes = User::join('fonctions', 'users.fonction_id', '=', 'fonctions.id')
            ->join('planning_rdvs', 'planning_rdvs.commercial_id', '=', 'users.id')
            ->join('clients', 'planning_rdvs.client_id', '=', 'clients.id')
            ->where('fonctions.name', 'LIKE', 'Commercial%')
            ->where('clients.type', 'Prospect')
            ->where('users.etat', '1')
            ->select('users.name as name', DB::raw('count(*) as total'))
            ->groupBy('name')
            ->pluck('total', 'name')
            ->all();

        /**
         * Facture proformat par commerciaux
         */
        $factureproformat = User::join('fonctions', 'users.fonction_id', '=', 'fonctions.id')
            ->join('documents', 'documents.user_id', '=', 'users.id')
            ->where('fonctions.name', 'LIKE', 'Commercial%')
            ->where('documents.type', 'Devis')
            ->where('users.etat', '1')
            ->select('users.name as name', DB::raw('count(*) as total'))
            ->groupBy('name')
            ->pluck('total', 'name')
            ->all();

        /**
         * Facture par commerciaux
         */
        $facture = User::join('fonctions', 'users.fonction_id', '=', 'fonctions.id')
            ->join('documents', 'documents.user_id', '=', 'users.id')
            ->where('fonctions.name', 'LIKE', 'Commercial%')
            ->where('documents.type', 'Facture')
            ->where('users.etat', '1')
            ->select('users.name as name', DB::raw('count(*) as total'))
            ->groupBy('name')
            ->pluck('total', 'name')
            ->all();

        $data = [
            "clients" => [
                "labels" => array_keys($clients),
                "data" => array_values($clients)
            ],
            "prospects" => [
                "labels" => array_keys($prospects),
                "data" => array_values($prospects)
            ],
            "prospects_contactes" => [
                "labels" => array_keys($prospects_contactes),
                "data" => array_values($prospects_contactes)
            ],
            "clients_contactes" => [
                "labels" => array_keys($clients_contactes),
                "data" => array_values($clients_contactes)
            ],
            "factureproformats" => [
                "labels" => array_keys($factureproformat),
                "data" => array_values($factureproformat)
            ],
            "factures" => [
                "labels" => array_keys($facture),
                "data" => array_values($facture)
            ]
        ];

        return view('commercials.statistiques', compact('title', 'data'));
    }
}
