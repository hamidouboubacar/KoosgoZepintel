<?php

namespace App\Http\Controllers;

use App\Models\Entreprise;
use Illuminate\Http\Request;

class EntrepriseController extends Controller
{
    public function index(){
        $entreprise = Entreprise::first();
        return view("entreprise.show", [
            "entreprise" => $entreprise,
        ]);
    }


    public function edit(Entreprise $entreprise){
        // $this->authorize("update", $entreprise);
        return view('entreprise.update',[
            'entreprise'=>$entreprise
        ]);
    }

    public function updateSave(Entreprise $entreprise,Request $request){
        if($request->file('logo')){
            $entreprise->logo =  $request->file('logo')->store('public');}
            if($request->file('entete')){
            $entreprise->entete =  $request->file('entete')->store('public');}
            if($request->file('pieddepage')){
        $entreprise->pieddepage =  $request->file('pieddepage')->store('public');}
        if($request->file('signature')){
            $entreprise->signature =  $request->file('signature')->store('public');}
        $entreprise->save();
        return redirect('entreprise/')->with("message", "Les informations ont été modifier avec succès");
    }

    public function delete(Entreprise $entreprise){
        $this->authorize("delete", $entreprise);
        $entreprise->etat = 0;
        $entreprise->save();
        return back()->with("message", "Supprimé avec succès");
    }

}
