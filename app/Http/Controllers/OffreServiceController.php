<?php

namespace App\Http\Controllers;

use App\Models\OffreService;
use App\Models\Client;
use Illuminate\Http\Request;
use Mail;
use PDF;
use App\Mail\OffreServiceMail;
use App\Models\Entreprise;

class OffreServiceController extends Controller
{
    private function genererNumeroOffre() 
    {
        $i = 1;
        $num = "OS".date('Y').$i.'NFG';
        while(OffreService::where('numero_offre', '=', $num)->exists()) {
            $i++;
            $num = "OS".date('Y').$i.'NFG';
        }
        
        return $num;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize("viewAny", "App\Models\OffreService");
        $title = "Offres et Services";
        $numero_offre = $this->genererNumeroOffre();
        $offreServices = OffreService::where('etat', 1)->orderBy('id', 'desc')->get();
        $clients = Client::where('etat', 1)->orderBy('name')->get();
        return view("offre_services.index", compact("offreServices", "title", "numero_offre", "clients"));
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
        $this->authorize("create", "App\Models\OffreService");
        OffreService::create($request->all());
        return back()->with("message", "Enregistrement effectué avec succès !");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OffreService  $offreService
     * @return \Illuminate\Http\Response
     */
    public function show(OffreService $offreService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OffreService  $offreService
     * @return \Illuminate\Http\Response
     */
    public function edit(OffreService $offreService)
    {
        $this->authorize("update", $offreService);
        $item = $offreService;
        $clients = Client::all();
        return view("offre_services.modals.edit", compact("item", "clients"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OffreService  $offreService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OffreService $offreService)
    {
        $this->authorize("update", $offreService);

        $offreService->update($request->all());
        
        return back()->with("message", "Modification effectuée avec succès !");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OffreService  $offreService
     * @return \Illuminate\Http\Response
     */
    public function destroy(OffreService $offreService)
    {
        $this->authorize("delete", $offreService);
        $offreService->etat = 0;
        $offreService->save();
        return back()->with("message", "Suppression effectuée avec succès!");
    }
    
    /**
     * Envoyer les offres et services par mail
     *
     * @param  \App\Models\OffreService  $offreService
     * @return \Illuminate\Http\Response
     */
    public function mail(OffreService $offreService)
    {
        if($offreService->client->email) {
            Mail::to($offreService->client->email)->send(new OffreServiceMail($offreService));
            return back()->with("message", "Mail envoyé avec succès!");
        } else {
            return back()->with("error", "Le client n'a pas d'adresse email définie!");
        }
    }
    
    /**
     * Telecharger les offres et services
     *
     * @param  \App\Models\OffreService  $offreService
     * @return \Illuminate\Http\Response
     */
    public function download(OffreService $offreService)
    {
        
        $entreprise = Entreprise::first();
        $pdf = PDF::loadView('offre_services.mail',[
            'entreprise'  => $entreprise,
            'offreService'  => $offreService,
          ]);
        return $pdf->stream('offre_service.pdf');
    }
}
