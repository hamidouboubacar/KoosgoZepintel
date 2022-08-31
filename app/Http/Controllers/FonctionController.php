<?php

namespace App\Http\Controllers;

use App\Models\Fonction;
use Illuminate\Http\Request;

class FonctionController extends Controller
{
    //

    public function index(){
        $this->authorize("viewAny", "App\Models\Fonction");
        $fonctions = Fonction::actifs()->get();
        return view("fonction.index",[ 'fonctions'=> $fonctions,]);
    }


    public function store(Request $request){
        $this->authorize("create", "App\Models\Fonction");
        $fonctions = Fonction::actifs();
        $fonction = $fonctions->where('name', $request->name)->get();
        if ($fonction->isEmpty()) {
            $request->validate([
                "name"=>"required",
            ]);

            Fonction::create([
                 "name"=>$request->name,
             ]);

            return back()->with("message","La fonction ajoutée avec succès !");
        }else
        {
            return back()->with("error","Cette fonction existe déjà !");
        }

    }
    public function edit(Fonction $fonction){
        $this->authorize("update", $fonction);
        return response()->json($fonction);
    }

    public function update(Fonction $fonction){
        $this->authorize("update", $fonction);
        $data = request()->validate([
            'name' => 'required|string',
        ]);
        $fonction->update($data);
        return back()->with("message", "Modifié avec succès");

    }

    public function delete(Fonction $fonction){
        $this->authorize("delete", $fonction);
        $fonction->etat=0;
        $fonction->save();
        return back()->with("message", "La fonction '$fonction->name' est supprimée avec succès!");
    }
}
