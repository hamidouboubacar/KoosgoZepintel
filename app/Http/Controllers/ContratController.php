<?php

namespace App\Http\Controllers;

use App\Models\Contrat;
use App\Models\ContratContent;
use App\Models\ContratPackage;
use App\Models\Client;
use App\Models\Entreprise;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Dompdf\Dompdf;
use PDF;

class ContratController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize("viewAny", "App\Models\Contrat");
        $title = "Contrat";
        $contrats = Contrat::join('clients', 'contrats.client_id', '=', 'clients.id')->select(
            'contrats.id',
            'contrats.num_contrat',
            'contrats.date',
            'clients.name',
            'contrats.date_expiration'
        )->orderBy('id', 'desc')->get();
        $clients = Client::latest()->get();
        $packages = Package::latest()->get();
        $num_contrat = $this->genererNumeroContrat();
        return view("contrats.index", compact("contrats", "title", "clients", "packages", "num_contrat"));
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
        $this->authorize("create", "App\Models\Contrat");
        // 1. La validation
        $this->validate($request, [
            "client_id" => 'required|integer',
            "date" => 'bail|required|date',
        ]);

        // 2. On enregistre les informations du Post
        $date = date("Y-m-d", strtotime($request->date));
        $dt = new Carbon($date);
        $contrat = Contrat::create([
            "client_id"       => $request->client_id,
            "num_contrat"     => $this->genererNumeroContrat(),
            "date"            => $date,
            "date_expiration" => $dt->addYear()
        ]);
        
        // 3. Recuperer les packages
        $keys = $request->except('_token');
        foreach($keys as $id => $value) {
            if(Str::contains($id, 'package_')) {
                ContratPackage::create([
                    'contrat_id' => $contrat->id,
                    'package_id' => explode('_', $id)[1]
                ]);
            }
        }

        
        $contrat->content = $this->getContent($request, $contrat)->render();
        $contrat->save();

        // 4. On retourne vers tous les posts : route("posts.index")
        return back()->with("message", "Enregistrement effectué avec succès !");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contrat  $contrat
     * @return \Illuminate\Http\Response
     */
    public function show(Contrat $contrat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contrat  $contrat
     * @return \Illuminate\Http\Response
     */
    public function edit(Contrat $contrat)
    {
        $this->authorize("update", $contrat);
        $item = $contrat;
        $clients = Client::latest()->get();
        $packages = Package::latest()->get();
        $contrat_packages = [];
        $contrat_packages_ = ContratPackage::where("contrat_id", $contrat->id)->get();
        foreach($contrat_packages_ as $cp) array_push($contrat_packages, $cp->package_id);
        $num_contrat = $contrat->num_contrat;
        return view("contrats.modals.edit", compact("item", "clients", "packages", "num_contrat", "contrat_packages"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contrat  $contrat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contrat $contrat)
    {
        $this->authorize("update", $contrat);
        // 1. La validation
        $this->validate($request, [
            "client_id" => 'required|integer',
            // "num_contrat" => 'required|string',
            "date" => 'bail|required|date',
        ]);

        // 2. On enregistre les informations du Post
        $contrat->update([
            "client_id" => $request->client_id,
            "num_contrat" => $request->num_contrat,
            "date" => date("Y-m-d", strtotime($request->date)),
        ]);
        
        // 3. Recuperer les packages
        $keys = $request->except('_token');
        foreach($keys as $id => $value) {
            if(Str::contains($id, 'package_') && !ContratPackage::where('contrat_id', $contrat->id)->where('package_id', explode('_', $id)[1])->exists()) {
                ContratPackage::create([
                    'contrat_id' => $contrat->id,
                    'package_id' => explode('_', $id)[1]
                ]);
            }
        }
        
        // 4. Supprimer les packages decochés
        $contrat_packages = ContratPackage::where('contrat_id', $contrat->id)->get();
        foreach($contrat_packages as $contrat_package) {
            $nonCoche = true;
            foreach($keys as $id => $value) {
                if(Str::contains($id, 'package_') && $contrat_package->package_id == explode('_', $id)[1]) {
                    $nonCoche = false;
                }
            }
            
            if($nonCoche) $contrat_package->delete();
        }
        
        return back()->with("message", "Modification effectuée avec succès !");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contrat  $contrat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contrat $contrat)
    {
        $this->authorize("delete", $contrat);
        $contrat->delete();
        return back()->with("message", "Suppression effectuée avec succès!");
    }
    
    /**
     * Generer un numero de contrat unique
     *
     * @return Integer
     */
    private function genererNumeroContrat() 
    {
        $i = 1;
        $num = "CA".date('Y').$i.'NFG';
        while(Contrat::where('num_contrat', '=', $num)->exists()) {
            $i++;
            $num = "CA".date('Y').$i.'NFG';
        }
        
        return $num;
    }
    
    /**
     * Editer un contrat
     * 
     * @return \Illuminate\Http\Response
     */
     
     public function edit_contrat_content(Request $request, Contrat $contrat) {
        $client = Client::find($contrat->client_id);
        $num_contrat = $contrat->num_contrat;
        $contrat_packages = ContratPackage::where('contrat_id', $contrat->id)->get();
        $somme_contrat_package = 0;
        foreach($contrat_packages as $contrat_package) {
            $package_item = Package::find($contrat_package->package_id);
            $somme_contrat_package += $package_item->montant;
        }
        $packages_fournis = "";
        $date_contrat = (new Carbon($contrat->date))->translatedFormat('d F Y');
        $date_jour = Carbon::now()->translatedFormat('d F Y');
        $avecSignature = $request->signature == "avec" ? true : false;
        $avecEntete = $request->entete == "avec" ? true : false;
        foreach($contrat_packages as $contrat_package) {
            $package = Package::find($contrat_package->package_id);
            $packages_fournis .= "$package->nom $package->debit_ascendant Mbps, ";
        }
        // dd(compact('client', 'num_contrat', 'somme_contrat_package', 'date_contrat', 'date_jour', 'packages_fournis', 'contrat'));
        return view('contrats.edit_contrat_content', compact('client', 'num_contrat', 'somme_contrat_package', 'date_contrat', 'date_jour', 'packages_fournis', 'contrat'));
     }
     
     /**
     * Editer un contrat
     * 
     * @return \Illuminate\Http\Response
     */
     
    public function store_contrat_content(Request $request, Contrat $contrat) {
        $contrat->update($request->all());
        return redirect(route('contrats.edit_contrat_content', $contrat));
    }
    
    /**
     * Apercu d'un contrat édité
     * 
     * @return \Illuminate\Http\Response
     */
    public function apercu(Request $request, Contrat $contrat) {
        $client = Client::find($contrat->client_id);
        $num_contrat = $contrat->num_contrat;
        $contrat_packages = ContratPackage::where('contrat_id', $contrat->id)->get();
        $somme_contrat_package = 0;
        foreach($contrat_packages as $contrat_package) {
            $package_item = Package::find($contrat_package->package_id);
            $somme_contrat_package += $package_item->montant;
        }
        $packages_fournis = "";
        $date_contrat = (new Carbon($contrat->date))->translatedFormat('d F Y');
        $date_jour = Carbon::now()->translatedFormat('d F Y');
        $avecSignature = $request->signature == "1" ? true : false;
        $avecEntete = $request->entete == "1" ? true : false;
        foreach($contrat_packages as $contrat_package) {
            $package = Package::find($contrat_package->package_id);
            $packages_fournis .= "$package->nom $package->debit_ascendant Mbps, ";
        }
        
        return view('contrats.apercu_contrat', compact('client', 'num_contrat', 'somme_contrat_package', 'date_contrat', 'packages_fournis', 'contrat'));
    }
    
    /**
     * Télécharger le contrat
     * 
     * @return \Illuminate\Http\Response
     */
    public function download(Request $request, Contrat $contrat) {
        // $content = isset($request->content) ? $request->content : "";
        $content = $contrat->content ?? "";
        $date_contrat = (new Carbon($contrat->date))->translatedFormat('d F Y');
        $date_jour = Carbon::now()->translatedFormat('d F Y');
        $entreprise = Entreprise::first();
        $pdf = PDF::loadView('contrats.apercu_contrat', compact('content', 'entreprise', 'contrat', 'date_contrat', 'date_jour'));
        return $pdf->stream('contrat.pdf');
    }
    
    /**
     * Contenu html du contrat
     * 
     * @param App\Models\Contrat
     * @return view
     */
    public function getContent(Request $request, Contrat $contrat) {
        $client = Client::find($contrat->client_id);
        $num_contrat = $contrat->num_contrat;
        $contrat_packages = ContratPackage::where('contrat_id', $contrat->id)->get();
        $somme_contrat_package = 0;
        foreach($contrat_packages as $contrat_package) {
            $package_item = Package::find($contrat_package->package_id);
            $somme_contrat_package += $package_item->montant;
        }
        $packages_fournis = "";
        $date_contrat = Carbon::now()->translatedFormat('d F Y');
        $avecSignature = $request->signature == "1" ? true : false;
        $avecEntete = $request->entete == "1" ? true : false;
        foreach($contrat_packages as $contrat_package) {
            $package = Package::find($contrat_package->package_id);
            $packages_fournis .= ", $package->nom $package->debit_ascendant Mbps";
        }

        $client_name = $client->name;
        $contrat_id = $contrat->id;
        
        // dd(compact('client', 'num_contrat', 'somme_contrat_package', 'date_contrat', 'packages_fournis', 'contrat', 'client_name', 'contrat_id'));
        return view('contrats.edit_contrat', compact('client', 'num_contrat', 'somme_contrat_package', 'date_contrat', 'packages_fournis', 'contrat'));
    }
    
    /**
     * Renouveller le contrat
     * 
     * @return \Illuminate\Http\Response
     */
    public function renouveller(Request $request, Contrat $contrat) {
        
        $date = $contrat->date;
        if(isset($contrat->date_expiration))
            $dt = new Carbon($contrat->date_expiration);
        elseif(isset($contrat->date))
            $dt = new Carbon($contrat->date_expiration);
        else {
            $dt = Carbon::now();
            $date = $dt;
            // $contrat->date = $dt;
        }
        
        // $contrat->date_expiration = $dt->addYear();
        // $contrat->save();
        $contrat_dupliquer = Contrat::create([
            "client_id"       => $contrat->client_id,
            "num_contrat"     => $this->genererNumeroContrat(),
            "date"            => $date,
            "date_expiration" => $dt->addYear(),
            "content"         => $contrat->content
        ]);
        $contrat_packages = ContratPackage::where("contrat_id", $contrat->id)->get();
        foreach($contrat_packages as $contrat_package) {
            ContratPackage::create([
                'contrat_id' => $contrat_dupliquer->id,
                'package_id' => $contrat_package->package_id
            ]);
        }
        
        // return back()->with("message", "Contrat renouvellé avec succès");
        return redirect(route('contrats.edit_contrat_content', $contrat_dupliquer));
    }
    
    /**
     * Télécharger un contrat au format word
     *
     */
    public function createWordDocx(Request $request, Contrat $contrat)
    {
        $client = Client::find($contrat->client_id);
        $num_contrat = $contrat->num_contrat;
        $contrat_packages = ContratPackage::where('contrat_id', $contrat->id)->get();
        $somme_contrat_package = 0;
        foreach($contrat_packages as $contrat_package) {
            $package_item = Package::find($contrat_package->package_id);
            $somme_contrat_package += $package_item->montant;
        }
        $packages_fournis = "";
        $date_contrat = Carbon::now()->translatedFormat('d F Y');
        $avecSignature = $request->signature == "avec" ? true : false;
        $avecEntete = $request->entete == "avec" ? true : false;
        foreach($contrat_packages as $contrat_package) {
            $package = Package::find($contrat_package->package_id);
            $packages_fournis .= "$package->nom $package->debit_ascendant Mbps, ";
        }
        
        if(isset($request->typeFichier) && $request->typeFichier == 'pdf') {
            return view('contrats.export', compact("client", "num_contrat", "somme_contrat_package", "packages_fournis", "date_contrat", "avecSignature", "avecEntete"));
        }
            
        \PhpOffice\PhpWord\Settings::setZipClass(\PhpOffice\PhpWord\Settings::PCLZIP);
        
        $wordTest = new \PhpOffice\PhpWord\PhpWord();
    
        $newSection = $wordTest->addSection(array('breakType' => 'continuous', 'colsNum' => 2));
        if($avecEntete) {
            $header = $newSection->createHeader();
            $header->addImage("assets/images/netforce/netforceN.png", ['width' => 500]);
        }
    
        $titre = "CONTRAT D'ABONNEMENT INTERNET";
        $newSection->addText($titre, array('name' => 'Times New Roman', 'size' => 16, 'color' => 'red', 'bold' => true));
        $newSection->addBreakText(2);
        
        $newSection->addText($contrat->num_contrat, array('name' => 'Times New Roman', 'size' => 15, 'color' => 'black', 'bold' => true));
        
        $content = "CONDITIONS PARTICULIERES \r\nINTERVENU \r\nENTRE:";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 12, 'color' => 'black', 'bold' => true));
        
        $content = "La Société Groupe NetForce à responsabilité limitée (SARL), avec un captal d’Un million (1.000.000) de francs CFA ayant son siège social à Ouagadougou, 01 BP 248 Ouagadougou 01, Tél (+226) 74266200 immatriculé au registre de commerce et du crédit immobilier sous le numéro RCCM-BF OUA 2019 B 3987, représentée par BOUDA Y. Barkwendé, 
        ci-après nommé : Groupe NetForce. 
        ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black'));
        
        $content = "Et";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black'));
        
        $newSection->addText($client->name, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black'));
        
        $content = "IL A ETE CONVENU ET ARRETE CE QUI SUIT : ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black', 'bold' => true));
        
        $content = "Préambule : ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 12, 'color' => 'black', 'bold' => true, 'underline' => 'single'));
        
        $content = "Le présent contrat est régi par les conditions générales ci-après ainsi que par les conditions particulières ci dessus.";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 12, 'color' => 'black'));
        
        $content = "CONDITIONS GENERALES ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 15, 'color' => 'black', 'bold' => true, 'underline' => 'single'));
        
        $content = "ARTICLE 1 : OBJET DU CONTRAT ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 15, 'color' => 'black', 'bold' => true, 'underline' => 'single'));
        
        $content = "Les présentes dispositions régissent les conditions d’offre de service fourni par le fournisseur. Le service objet du présent contrat consiste en la fourniture d’une connectivité internet, " . $packages_fournis;
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black'));
        
        $content = "ARTICLE 2 : PRIX ET MODALITES DE REGLEMENT";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 15, 'color' => 'black', 'bold' => true, 'underline' => 'single'));
        
        $content = "Les montants du présent contrat est de $somme_contrat_package francs CFA par mois. Avec des frais d’installation de 100000 francs CFA. ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black'));
        $content = "Les redevances mensuelles feront l’objet d’une facture mensuelle adressée au client par mail et ou physiquement. Les redevances sont en prépayées et sont dues au plus tard 10 jours à partir de la date de présentation de la facture. Les paiements seront effectués par orange money au +226 64 19 79 79, chèque ou par virement bancaire au bénéfice du fournisseur.";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black'));
        
        $content = "ARTICLE 3 : DUREE DU CONTRAT";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 15, 'color' => 'black', 'bold' => true, 'underline' => 'single'));
        
        $content = "L'abonnement prend effet lorsque le service est installé et en service chez le client. L'abonnement est souscrit pour une période minimale d’une année. Il est renouvelable par tacite reconduction pour une durée indéterminée sauf instruction contraire de l’une ou l’autre partie par écrit au moins trois (3) mois avant l’expiration de la période initiale d’un (01) ans. ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        
        $content = "ARTICLE 4 : MODIFICATIONS";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 15, 'color' => 'black', 'bold' => true, 'underline' => 'single'));
        
        $content = "Le fournisseur s’engage à informer l’abonné, un mois à l’avance, de toute modification portant sur le contenu des prestations fournies, de leur durée et de leur prix. En cas d’acceptation de ces modifications par le client, les nouvelles dispositions s’appliqueront à la date du changement effectif. En cas de non acceptation de ces modifications, l’abonné aura la faculté de résilier son abonnement. Il devra procéder à cette résiliation par courrier, dans le mois précédant la date du changement effectif. ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        
        $content = "ARTICLE 5 : RESILIATION ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 15, 'color' => 'black', 'bold' => true, 'underline' => 'single'));
        
        $content = "5.1 Résiliation normale par l’abonné";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black', 'bold' => true));
        
        $content = "Le client peut, au terme de l’année contractuel, le résilier. La résiliation prend effet si elle est reçue au moins trois (03) mois avant la fin du présent contrat. Si le client, avant le terme du présent, met fin ou résilie son contrat, il restera redevable de tous les frais restants dus, jusqu’à l’échéance du contrat plus profiter du service Internet (Indisponibilité totale du service pendant au moins 15 jours) sans préjudice de tous dommages et intérêts. En cas de reconduction pour une période indéterminée, il peut être dénoncé à tout moment par l’une ou l’autre partie, sous réserve du respect du préavis de trois (3) mois notifié par écrit. 
        ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        
        $content = "5.2 Résiliation par le fournisseur ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black', 'bold' => true));
        
        $content = "Tout manquement de l’abonné aux conditions du présent contrat est de nature à entrainer la résiliation immédiate de l’abonnement sans préjudice de tous dommages et intérêts. En cas de retard dans les paiements et faute de régularisation dans les délais prévue par la lettre de mise en demeure adressée par le fournisseur, l’abonnement sera immédiatement résiliable de plein droit par le fournisseur. Dans tous les cas, les sommes dont l’abonné est redevable à la date de la résiliation restent dues par ce dernier. En cas d’impayés, les frais y afférents ainsi que ceux nécessaires à leur recouvrement, sont également à la charge de l’abonné 
        ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        
        $content = "5.3 Résiliation automatique en cas d’impossibilité technique de raccordement";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black', 'bold' => true));
        
        $content = "Dans certains cas, la fourniture du service peut s’avérer techniquement impossible. Si une telle situation est constatée, le présent contrat deviendra 
        automatiquement caduc. Le fournisseur en informera l’abonné par courrier ou par téléphone et lui signalera ultérieurement toute évolution du réseau ou des conditions techniques qui permettrait d’envisager à nouveau le raccordement. 
        ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        
        $content = "ARTICLE 8 : OBLIGATIONS DES PARTIES";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 15, 'color' => 'black', 'bold' => true, 'underline' => 'single'));
        
        $content = "8.1 OBLIGATIONS DU CLIENT ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black', 'bold' => true));
        
        $content = "8.1.1 PROPRIETE ET PROTECTION DE L’EQUIPEMENT";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black', 'bold' => true));
        
        $content = "L’équipement fourni aux termes des présentes demeure la propriété du fournisseur, toutefois, le client en a l’entière responsabilité. Il doit protéger l’équipement du fournisseur contre la détérioration, l’altération ou les dommages et n’autoriser personne, sauf un représentant du fournisseur, à effectuer des travaux ou une quelconque manipulation sur cet équipement. Le client devra rembourser au fournisseur le coût intégral de la réparation ou du remplacement de l’équipement perdu, volé, endommagé, non retourné à l’échéance, hypothéqué, vendu, loué, cédé ou transféré, en totalité ou en partie. ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        
        $content = "8.1.2 USAGE CONFORME";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black', 'bold' => true));
        
        $content = "Le présent contrat n’exonère pas le client de sa responsabilité civile et pénale dans le cadre des droits liés à l’utilisation de logiciels informatiques. L’abonné est responsable des informations qu’il fait transiter par le réseau du fournisseur, en diffusion ou en lecture, même s’il n’en est pas le créateur.";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        $content = "Le client est responsable de sa propre sécurité informatique. L’abonnement et les éléments de reconnaissance, fournis par le fournisseur, sont personnels et ne peuvent en aucun cas être transférés à un tiers sous peine de résiliation immédiate selon les dispositions de l’article 7alinéas 2 des présentes. 
        ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        $content = "Il est expressément convenu que l’abonné qui cède son contrat en violation de l’interdiction ci-dessus, reste tenu du règlement du prix de l’abonnement et de l’intégralité des consommations liées à la formule de fourniture souscrite. 
        ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        $content = "Restent également à la charge de l’abonné, sans que puisse être recherchée la responsabilité du fournisseur, les conséquences dommageables de ses fautes ou négligences ainsi que de celles des personnes ou des choses dont il a la garde. ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        
        $content = "8.1.3 INTERDICTIONS";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black', 'bold' => true));
        
        $content = "Il est formellement interdit au client, sous peine de résiliation de son abonnement et sans préjudice de tous dommages et intérêts et poursuites, d’introduire dans le réseau des perturbations de toute nature. Dans ce cas, le client sera tenu pour responsable de ces perturbations tant à l’égard du fournisseur qu’à l’égard des tiers. 
        ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        
        $content = "8.2 OBLIGATION DU FOURNISSEUR";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black', 'bold' => true));
        
        $content = "Le fournisseur est responsable de la qualité de la connexion depuis le nœud d’accès jusqu’au point d’entrée du réseau, propriété du fournisseur, côté client. 
        ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        $content = "Le fournisseur ne saurait être tenu responsable des pannes, coupures de lignes, mauvaise configuration de matériel, des équipements, etc., qui ne sont pas sous ou qu’elle n’a pas fourni, et notamment des liaisons de tous types assurés par d’autres prestataires.";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        $content = "Le fournisseur ne garantit pas les taux de transfert et les temps de réponse des informations circulant dans le réseau Internet.";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        $content = "L’accès au réseau sera en principe assuré en permanence, sous réserve de contraintes et aléas indépendants de la volonté du fournisseur, affectant la continuité et la qualité du service, et ne pouvant être raisonnablement surmontés ou évités malgré les précautions prises lors de la conception, de la construction, de l’entretien et de l’exploitation de la plateforme de connexion ou du réseau. ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        $content = "Les contraintes et aléas peuvent être soit inhérents aux matériels ou aux logiciels compte tenu des connaissances acquises en la matière et des technologies utilisables, soit extérieurs dans le cas d’actions de tiers volontaires ou accidentelles, d’incendie, d’explosion, d’accident de toute nature. Ces cas ne sont pas limitatifs et ne sont pas nécessairement constitutifs de cas de force majeure au sens strict entendu par la jurisprudence.";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        $content = "Les interruptions programmées du service, pour effectuer des travaux de toute nature nécessaires à l’entretien ou à l’évolution de l’offre feront l’objet d’un avis à l’abonné et ne donneront lieu à aucune indemnisation. Les travaux programmables à l’avance (entretien, extension, etc.) seront effectués dans toute la mesure du possible, en dehors des plages de grande utilisation.";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        $content = "En cas d’interruption du service, le fournisseur prendra immédiatement les dispositions nécessaires pour assurer sa remise en service dans les meilleurs délais.";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        $content = "Le fournisseur est responsable des outils logiciels mis à la disposition de ses abonnés lors de la souscription du contrat et nécessaire à la connexion et à l’échange de données entre le site du client et la plateforme informatique du fournisseur.";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        $content = "Tout différend, difficulté ou contestation relatif à l’exécution ou l’interprétation du présent contrat sera réglé amiablement. En l’absence d’accord amiable le différend, difficulté ou contestation sera régi par le tribunal du commerce du Burkina Faso.";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        $content = "Les présentes conditions sont rédigées en langue française";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        
        $content = "ARTICLE 10 : ELECTION DE DOMICILE";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 15, 'color' => 'black', 'bold' => true, 'underline' => 'single'));
        
        $content = "Pour tout ce qui n’est pas précisé au contrat, les parties s’en remettent aux dispositions légales et réglementaires en vigueur au Burkina Faso.";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        
        $content = "Les parties déclarent avoir pris connaissance des dispositions légales, règlementaires et conventionnelles en matière de télécom et en acceptent l’application dans le cadre du présent contrat.";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black'));   
        
        $content = "Le contrat est établit en deux (02) exemplaires originaux, dont un exemplaire est remis à chaque partie.";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        
        $content = "EN FOI DE QUOI, LES PARTIES ONT SIGNE LES PRESENTES";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black', 'bold' => true)); 
        
        $content = "Date d'activation le 02 Déc. 2021";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        
        Carbon::setLocale('fr');
        $content = "Fait à Ouagadougou, le " . $date_contrat;
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        
        if(isset($request->signature) && $request->signature == 'avec') {
            $content = "Le Fournisseur";
            $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black', 'bold' => true, 'underline' => 'single'));
            $newSection->addImage('assets/images/netforce/signature.png', ['width' => 125]);
            
            $content = "Le Client";
            $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black', 'bold' => true, 'underline' => 'single'));
        }
        
        
        if(isset($request->typeFichier) && $request->typeFichier == 'pdf') {
            $objectWriter = \PhpOffice\PhpWord\IOFactory::createWriter($wordTest, 'Word2007');
            $objectWriter->save(storage_path('CONTRAT-'.$contrat->num_contrat.'.docx'));
            
            $domPdfPath = realpath(PHPWORD_BASE_DIR . '/../vendor/dompdf/dompdf');
            \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
            \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');
            
            $phpWord = \PhpOffice\PhpWord\IOFactory::load(storage_path('CONTRAT-'.$contrat->num_contrat.'.docx')); 
            $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord , 'PDF');
            $xmlWriter->save(storage_path('CONTRAT-'.$contrat->num_contrat.'.pdf'));  
            
            return response()->download(storage_path('CONTRAT-'.$contrat->num_contrat.'.pdf'));
        } else {
            $objectWriter = \PhpOffice\PhpWord\IOFactory::createWriter($wordTest, 'Word2007');
            try {
                $objectWriter->save(storage_path('CONTRAT-'.$contrat->num_contrat.'.docx'));
            } catch (Exception $e) {
            }
        
            return response()->download(storage_path('CONTRAT-'.$contrat->num_contrat.'.docx'));
        }
    }
}
