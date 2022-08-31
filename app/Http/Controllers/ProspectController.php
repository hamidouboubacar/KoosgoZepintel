<?php

namespace App\Http\Controllers;

use App\Models\BonLivraison;
use App\Models\Client;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProspectController extends Controller
{
    public function index(){
        $user_id = Auth::id();
        $prospects = Client::actifsProspects()->get();
        return view("prospect.index",[ 'prospects'=> $prospects, 'user_id'=> $user_id]);
    }

    public function store(Request $request)
    {
        if ($request->type == 'Prospect'){
            $countProspect = Client::where('type', 'Prospect')->count() + 1;
            $code_client = 'PRT'.$countProspect;
        }
        $prospects = Client::actifsProspects();
        $prospect = $prospects->where('name', $request->name)->get();
        if ($prospect->isEmpty()) {
            $data = $request->validate([
                'name' => 'required|string',
                'email' => 'nullable|string',
                'code_client' => 'nullable',
                'type' => 'nullable',
                'ifu' => 'nullable',
                'rccm' => 'nullable',
                'telephone' => 'nullable',
                'adresse' => 'nullable',
                'pays' => 'nullable',
                'ville' => 'nullable',
                'user_id' => 'nullable',
                'numero_paiement' => 'nullable',
            ]);
            $data['code_client'] = $code_client;
            $data['type'] = "Prospect";
            Client::create($data);
            return back()->with("message","prospect ajouté avec succès !");
        }else
        {
            return back()->with("error","Ce prospect existe déjà !");
        }
    }


    public function edit(Client $prospect){
        return response()->json($prospect);
    }

    public function update(Client $prospect){

        $data = request()->validate([
            'name' => 'required|string',
            'email' => 'nullable|string',
            'ifu' => 'nullable',
            'rccm' => 'nullable',
            'telephone' => 'nullable',
            'adresse' => 'nullable',
            'pays' => 'nullable',
            'ville' => 'nullable',
            'numero_paiement' => 'nullable',
        ]);
        $prospect->update($data);
        return back()->with("message", "Modifié avec succès");

    }

    public function delete(Client $prospect){
        $prospect->etat=0;
        $prospect->save();
        return back()->with("message", "Le prospect '$prospect->name' est supprimé avec succès!");
    }

    public function show(Client $prospect){
        $documents = Document::where('client_id', $prospect->id)->where('type', 'Prospect')->where('etat', 1)->orderBy('id', 'desc')->get();
        return view('prospect.show', [
            'client' => $prospect,
            'documents' => $documents,
            'document_devis' => Document::where('client_id', $prospect->id)->where('type', 'Devis')->where('etat', 1)->orderBy('id', 'desc')->get(),
            'document_factures' => Document::where('client_id', $prospect->id)->where('type', 'Facture')->where('etat', 1)->orderBy('id', 'desc')->get(),
            'document_impayes' => Document::where('client_id', $prospect->id)->where('type', 'Facture')->where('reste_a_payer', '>', 0)->where('etat', 1)->orderBy('id', 'desc')->get(),
            'document_livrer' => BonLivraison::where('etat', 1)->orderBy('id', 'desc')->get()
        ]);
    }
}
