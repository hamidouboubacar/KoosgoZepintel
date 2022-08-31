<?php

namespace App\Http\Controllers;

use App\Models\PlanningTache;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanningTacheController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Planning des tâches";
        
        $user = Auth::user();
        $est_commercial = $user->fonction->name == "Commercial" ? true : false;
        if($est_commercial) {
            $plannings = PlanningTache::join('users', 'users.id', '=', 'planning_taches.commercial_id')
                ->select('planning_taches.id', 'planning_taches.date', 'planning_taches.tache', 'planning_taches.resultat_attendu', 'users.name')
                ->where('users.id', Auth::id())
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $plannings = PlanningTache::join('users', 'users.id', '=', 'planning_taches.commercial_id')
                ->select('planning_taches.id', 'planning_taches.date', 'planning_taches.tache', 'planning_taches.resultat_attendu', 'users.name')
                ->orderBy('id', 'desc')
                ->get();
        }
        
        $commercials = User::join('fonctions', 'users.fonction_id', '=', 'fonctions.id')
            ->where('fonctions.name', 'LIKE', 'Commercial%')
            ->select('users.id', 'users.name', 'users.telephone', 'users.email')
            ->orderBy('id', 'desc')
            ->get();
        return view("commercials.planning_tache", compact("plannings", "title", "commercials", "user", "est_commercial"));
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
            // "date" => 'bail|required|string',
            "commercial_id" => 'bail|required|integer',
            "tache" => 'bail|required|string',
            "resultat_attendu" => 'bail|required|string',
        ]);

        // 3. On enregistre les informations du Post
        PlanningTache::create([
            "date" => $request->date,
            "commercial_id" => $request->commercial_id,
            "tache" => $request->tache,
            "resultat_attendu" => $request->resultat_attendu,
        ]);

        // 4. On retourne vers tous les posts : route("posts.index")
        return back()->with("message", "Enregistrement effectué avec succès !");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PlanningTache  $planningTache
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = "Détail Planning de la tâche";
        $item = PlanningTache::find($id);
        $commercials = User::join('fonctions', 'users.fonction_id', '=', 'fonctions.id')
            ->where('fonctions.name', 'LIKE', 'Commercial%')
            ->select('users.id', 'users.name', 'users.telephone', 'users.email')
            ->get();
        return view("commercials.show", compact("item", "commercials", "title"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PlanningTache  $planningTache
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $this->authorize("update", $planningTache);
        $item = PlanningTache::find($id);
        $commercials = User::join('fonctions', 'users.fonction_id', '=', 'fonctions.id')
            ->where('fonctions.name', 'LIKE', 'Commercial%')
            ->select('users.id', 'users.name', 'users.telephone', 'users.email')
            ->get();
            $user = Auth::user();
            $est_commercial = $user->fonction->name == "Commercial" ? true : false;
        return view("commercials.modals.edit_planning_tache", compact("item", "commercials", "user", "est_commercial"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PlanningTache  $planningTache
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $planningTache = PlanningTache::find($id);
        // $this->authorize("update", $planningTache);
        $planningTache->update($request->all());
        return back()->with("message", "Modification effectuée avec succès");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PlanningTache  $planningTache
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $planningTache = PlanningTache::find($id);
        $planningTache->delete();
        return back()->with("message", "Suppression effectuée avec succès!");
    }
}
