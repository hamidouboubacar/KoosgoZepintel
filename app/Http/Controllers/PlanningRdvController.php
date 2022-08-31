<?php

namespace App\Http\Controllers;

use App\Models\PlanningRdv;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanningRdvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Planning des Rendez-vous";
        
        $user = Auth::user();
        $est_commercial = $user->fonction->name == "Commercial" ? true : false;
        if($est_commercial) {
            $plannings = PlanningRdv::join('users', 'users.id', '=', 'planning_rdvs.commercial_id')
                ->join('clients', 'clients.id', '=', 'planning_rdvs.client_id')
                ->where('users.id', Auth::id())
                ->select('planning_rdvs.id', 'planning_rdvs.date', 'users.name', 'clients.name as name1')
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $plannings = PlanningRdv::join('users', 'users.id', '=', 'planning_rdvs.commercial_id')
                ->join('clients', 'clients.id', '=', 'planning_rdvs.client_id')
                ->select('planning_rdvs.id', 'planning_rdvs.date', 'users.name', 'clients.name as name1')
                ->orderBy('id', 'desc')
                ->get();
        }
            
        $commercials = User::join('fonctions', 'users.fonction_id', '=', 'fonctions.id')
            ->where('fonctions.name', 'LIKE', 'Commercial%')
            ->select('users.id', 'users.name', 'users.telephone', 'users.email')
            ->orderBy('id', 'desc')
            ->get();
        $clients = Client::actifs()->get();
        return view("commercials.planning_rdv", compact("plannings", "title", "clients", "commercials", "user", "est_commercial"));
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
        // 1. La validation
        $this->validate($request, [
            "date" => 'bail|required|string',
            "commercial_id" => 'bail|required|integer',
            "client_id" => 'bail|required|integer'
        ]);

        // 3. On enregistre les informations du Post
        PlanningRdv::create([
            "date" => $request->date,
            "commercial_id" => $request->commercial_id,
            "client_id" => $request->client_id,
        ]);

        // 4. On retourne vers tous les posts : route("posts.index")
        return back()->with("message", "Enregistrement effectué avec succès !");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PlanningRdv  $planningRdv
     * @return \Illuminate\Http\Response
     */
    public function show(PlanningRdv $planningRdv)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PlanningRdv  $planningRdv
     * @return \Illuminate\Http\Response
     */
    public function edit(PlanningRdv $planningRdv)
    {
        $item = $planningRdv;
        $commercials = User::join('fonctions', 'users.fonction_id', '=', 'fonctions.id')
            ->where('fonctions.name', 'LIKE', 'Commercial%')
            ->select('users.id', 'users.name', 'users.telephone', 'users.email')
            ->get();
        $clients = Client::all();
        $user = Auth::user();
        $est_commercial = $user->fonction->name == "Commercial" ? true : false;
        return view("commercials.modals.edit_planning_rdv", compact("item", "commercials", "clients", "user", "est_commercial"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PlanningRdv  $planningRdv
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PlanningRdv $planningRdv)
    {
        // 1. La validation
        $this->validate($request, [
            "date" => 'bail|required|string',
            "commercial_id" => 'bail|required|integer',
            "client_id" => 'bail|required|integer'
        ]);

        // 3. On enregistre les informations du Post
        $planningRdv->update([
            "date" => $request->date,
            "commercial_id" => $request->commercial_id,
            "client_id" => $request->client_id,
        ]);

        // 4. On retourne vers tous les posts : route("posts.index")
        return back()->with("message", "Modification effectuée avec succès !");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PlanningRdv  $planningRdv
     * @return \Illuminate\Http\Response
     */
    public function destroy(PlanningRdv $planningRdv)
    {
        $planningRdv->delete();
        return back()->with("message", "Suppression effectuée avec succès!");
    }
}
