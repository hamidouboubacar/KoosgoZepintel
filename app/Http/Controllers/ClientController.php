<?php

namespace App\Http\Controllers;

use App\Models\BonCommande;
use App\Models\BonLivraison;
use App\Models\Client;
use App\Models\Document;
use App\Models\DocumentPackage;
use App\Models\Facture;
use App\Models\Paiement;
use App\Models\User;
use App\Models\Fonction;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use NumberToWords\NumberToWords;
use PDF;
use App\Mail\ClientUser;
use App\Models\Entreprise;
use Hash;
use App\Models\NumeroPaiement;

class ClientController extends Controller
{
    public function index(){
        $this->authorize("viewAny", "App\Models\Client");
        $user_id = Auth::id();
        $clients = Client::actifs()->get();
        return view("client.index",[ 'clients'=> $clients, 'user_id'=> $user_id]);
    }
    
    public function add(Request $request) {
        if($request->type == 'Client'){
            $countClient = Client::where('type', 'Client')->count() + 1;
            $code_client = 'CL'.$countClient;
        }
        $clients = Client::actifs();
        $client = $clients->where('name', $request->name)->get();
        if ($client->isEmpty()) {
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
            $data['type'] = "Client";
            $client = Client::create($data);
            
            if(isset($data['email'])) {
                $email = $data['email'];
                $password = Str::random(8);
                User::create([
                    'name' => $data['name'], 
                    'email' => $email, 
                    'password' => Hash::make($password), 
                    'token' => Str::random(80), 
                    'client_id' => $client->id,
                    'fonction_id' => Fonction::where('name', 'Client')->first()->id
                ]);
                Mail::to($email)->send(new ClientUser($email, $password));
            }
            
            return response()->json([
                'data' => "<option value='$client->'>$client->name</option>",
                'result' => true
            ]);
        }else
        {
            return response()->json(['result' => false]);
        }
    }

    public function store(Request $request)
    {
        $this->authorize("create", "App\Models\Client");
        if($request->type == 'Client'){
            $countClient = Client::where('type', 'Client')->count() + 1;
            $code_client = 'CL'.$countClient;
        }
        $clients = Client::actifs();
        $client = $clients->where('name', $request->name)->get();
        if ($client->isEmpty()) {
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
                'latitude' => 'nullable',
                'longitude' => 'nullable',
                'longitude' => 'nullable',
                'recurrence' => 'nullable',
                'numero_paiement' => 'nullable',
            ]);
            $data['code_client'] = $code_client;
            $data['name'] =  strtoupper($data['name']);
            $data['type'] = "Client";
            if(isset($data['recurrence'])){
                $data['recurrence'] = 1;
            }else{
                $data['recurrence'] = 0;
            }
            $client = Client::create($data);

            if(isset($data['email'])) {
                $email = $data['email'];
                $password = Str::random(8);
                User::create([
                    'name' => $data['name'], 
                    'email' => $email, 
                    'password' => Hash::make($password), 
                    'token' => Str::random(80), 
                    'client_id' => $client->id,
                    'fonction_id' => Fonction::where('name', 'Client')->first()->id
                ]);
                Mail::to($email)->send(new ClientUser($email, $password));
            }

            return back()->with("message","Client ajouté avec succès !");
        }else
        {
            return back()->with("error","Ce client existe déjà !");
        }
    }

    public function show(Client $client){
        $documents = Document::where('client_id', $client->id)->where('etat', 1)->orderBy('id', 'desc')->get();
        $chiffres_affaire = Document::where('client_id', $client->id)->where('type', 'Facture')->where('etat', 1)->sum('montantttc');
        $montant_recouvrer = Document::where('client_id', $client->id)->where('type', 'Facture')->where('etat', 1)->sum('total_versement');
        $encours = Document::where('client_id', $client->id)->where('type', 'Facture')->where('etat', 1)->sum('reste_a_payer');
        
        return view('client.show', [
            'client' => $client,
            'documents' => $documents,
            'document_devis' => Document::where('client_id', $client->id)->where('type', 'Devis')->where('etat', 1)->orderBy('id', 'desc')->get(),
            'document_avoirs' => Document::where('client_id', $client->id)->where('type', 'FactureAvoir')->where('etat', 1)->orderBy('id', 'desc')->get(),
            'document_factures' => Document::where('client_id', $client->id)->where('type', 'Facture')->where('etat', 1)->orderBy('id', 'desc')->get(),
            'document_impayes' => Document::where('client_id', $client->id)->where('type', 'Facture')->where('reste_a_payer', '>', 0)->where('etat', 1)->orderBy('id', 'desc')->get(),
            'document_livrer' => BonLivraison::where('etat', 1)->orderBy('id', 'desc')->get(),
            'bonCommandes' => BonCommande::where('client_id', $client->id)->where('etat', 1)->orderBy('id', 'desc')->get(),
            'chiffres_affaire'=>$chiffres_affaire,
            'montant_recouvrer'=>$montant_recouvrer,
            'encours'=>$encours,

        ]);
    }


    public function edit(Client $client){
        $this->authorize("update", $client);
        return response()->json($client);
    }

    public function update(Client $client){
        $this->authorize("update", $client);

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
        $client->update($data);
        return back()->with("message", "Modifié avec succès");

    }

    public function delete(Client $client){
        $this->authorize("delete", $client);
        $client->etat=0;
        $client->save();
        return back()->with("message", "Le client '$client->name' est supprimé avec succès!");
    }

    public function mailDocument(Request $request){
        // dd($request);
        $data = $request->validate([
            'document_id' => 'required|string',
            'email' => 'nullable|string',
            'emailcc' => 'nullable',
            'objet' => 'nullable',
            'contenu' => 'nullable',
        ]);
        $mails = [];
        if($data['emailcc']){
            $mails = explode(", ", $data['emailcc']);
            array_push($mails, $data['email']);
        }else{
            array_push($mails, $data['email']);
        }

        $document = Document::find($request->document_id);
        foreach($mails as $mail){
            Mail::send('client.email', ['data'=>$data], function($message) use ($document, $mail) {
                $message->to($mail)
                ->subject($document->type.' NETFORCE-GROUP');
              });
        }
              return back()->with("message","Mail envoyé avec succès !");
    }

    public function mailBonLivraison(Request $request){
        $data = $request->validate([
            'document_id' => 'required|string',
            'email' => 'nullable|string',
            'emailcc' => 'nullable',
            'objet' => 'nullable',
            'contenu' => 'nullable',
        ]);
         $mails = [];
        if($data['emailcc']){
            $mails = explode(", ", $data['emailcc']);
            array_push($mails, $data['email']);
        }else{
            array_push($mails, $data['email']);
        }
        $document = Document::find($request->document_id);
        $bon = $document->bonLivraison;
        foreach($mails as $mail){
        Mail::send('client.emailbon', ['data'=>$data, 'bon'=>$bon], function($message) use ($mail) {
            $message->to($mail)
                ->subject('BON DE LIVRAISON NETFORCE-GROUP');
              });
            }
              return back()->with("message","Mail envoyé avec succès !");
    }

    public function telechargerDocument(Document $document){
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
          $sans_signature= 1;
        $entreprise = Entreprise::first();
  
  
          $pdf = PDF::loadView('document.export.exportDevis', [
              'selections' => $selections,
              'commercial' => $commercial,
              'document' => $document,
              'total' => $total,
              'date' => $Today,
              'entreprise' => $entreprise,
              'reste_a_payer' => $reste_a_payer,
              'client'  => $client,
              'sans_signature'  => $sans_signature,
          ]);
          return $pdf->download($name . '.pdf');
    }

    public function telechargerBon(Document $document){
                $pdf = new Dompdf(array('log_output_file' => ''));
                $client = $document->client;
                $selections = DocumentPackage::where("document_id", $document->id)->get();
                $name = $document->numero;
                $Today = date('d-M-Y');
                $dateP = $document->periode;
                $date_explosee = explode("-", $dateP);
                $annee = $date_explosee[0];
                $mois = $date_explosee[1];
                $jour = $date_explosee[2];
                $commercial = $document->user;
                $pdf = PDF::loadView('document.export.livraison', [
                    'selections' => $selections,
                    'commercial' => $commercial,
                    'document' => $document,
                    'date' => $Today,
                    'mois' => $mois,
                    'annee' => $annee,
                ]);
                return $pdf->download($name . '.pdf');
    }

    public function telechargerPaiement(Paiement $paiement){
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
        $dateP = $document->periode;
        // changer date par periode
        $date_explosee = explode("-", $dateP);
        $annee = $date_explosee[0];
        $mois = $date_explosee[1];
        $jour = $date_explosee[2];
        $commercial = $document->user;
          $pdf = PDF::loadView('document.export.recu', [
            'selections' => $selections,
            'commercial' => $commercial,
            'document' => $document,
            'total' => $total,
            'date' => $Today,
            'mois' => $mois,
            'annee' => $annee,
            'reste_a_payer' => $reste_a_payer,
            'client'  => $client,
          ]);
          return $pdf->download($name . '.pdf');
    }

    public function add_numero_paiement(Request $request) {
        $data = $request->validate([
            'telephone' => 'required',
            'client_id' => 'required'
        ]);

        $numero = NumeroPaiement::create($data);

        return response()->json($numero);
    }

    public function liste_numero_paiement(Request $request) {
        $data = $request->validate([
            'client_id' => 'required'
        ]);

        $numeros = NumeroPaiement::where("client_id", $data["client_id"])->get();

        return response()->json($numeros);
    }

    public function change_numero_paiement(Request $request) {
        $data = $request->validate([
            'id' => 'required',
            'telephone' => 'required'
        ]);

        $numero = NumeroPaiement::find($data["id"]);
        $numero->update([
            "telephone" => $data["telephone"]
        ]);

        return response()->json($numero);
    }

    public function delete_numero_paiement(Request $request) {
        $data = $request->validate([
            'id' => 'required'
        ]);

        $numero = NumeroPaiement::find($data["id"]);
        $numero->delete();

        return response()->json();
    }

    public function password_change() {
        return view('client.password_change');
    }

}
