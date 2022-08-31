<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tache;

class TacheController extends Controller
{
    /**
     * Ajouter une tache
     * 
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function store(Request $request) {
        $tache = Tache::create($request->all());
        return response()->json(["tache" => $tache]);
    }

    /**
     * Changer Etat
     * 
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function changeStat(Request $request) {
        $tache = Tache::find($request->id);
        $tache->update(["etat" => $request->etat]);
        return response()->json(["tache" => $tache]);
    }
    
    /**
     * SUppimer Tache
     * 
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function supprimer(Request $request) {
        $tache = Tache::find($request->id);
        $tache->delete();
        return response()->json([]);
    }
}
