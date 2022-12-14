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
        return back()->with("message", "Enregistrement effectu?? avec succ??s !");
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
        
        // 4. Supprimer les packages decoch??s
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
        
        return back()->with("message", "Modification effectu??e avec succ??s !");
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
        return back()->with("message", "Suppression effectu??e avec succ??s!");
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
     * Apercu d'un contrat ??dit??
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
     * T??l??charger le contrat
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
        
        // return back()->with("message", "Contrat renouvell?? avec succ??s");
        return redirect(route('contrats.edit_contrat_content', $contrat_dupliquer));
    }
    
    /**
     * T??l??charger un contrat au format word
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
        
        $content = "La Soci??t?? Groupe NetForce ?? responsabilit?? limit??e (SARL), avec un captal d???Un million (1.000.000) de francs CFA ayant son si??ge social ?? Ouagadougou, 01 BP 248 Ouagadougou 01, T??l (+226) 74266200 immatricul?? au registre de commerce et du cr??dit immobilier sous le num??ro RCCM-BF OUA 2019 B 3987, repr??sent??e par BOUDA Y. Barkwend??, 
        ci-apr??s nomm?? : Groupe NetForce. 
        ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black'));
        
        $content = "Et";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black'));
        
        $newSection->addText($client->name, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black'));
        
        $content = "IL A ETE CONVENU ET ARRETE CE QUI SUIT : ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black', 'bold' => true));
        
        $content = "Pr??ambule : ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 12, 'color' => 'black', 'bold' => true, 'underline' => 'single'));
        
        $content = "Le pr??sent contrat est r??gi par les conditions g??n??rales ci-apr??s ainsi que par les conditions particuli??res ci dessus.";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 12, 'color' => 'black'));
        
        $content = "CONDITIONS GENERALES ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 15, 'color' => 'black', 'bold' => true, 'underline' => 'single'));
        
        $content = "ARTICLE 1 : OBJET DU CONTRAT ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 15, 'color' => 'black', 'bold' => true, 'underline' => 'single'));
        
        $content = "Les pr??sentes dispositions r??gissent les conditions d???offre de service fourni par le fournisseur. Le service objet du pr??sent contrat consiste en la fourniture d???une connectivit?? internet, " . $packages_fournis;
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black'));
        
        $content = "ARTICLE 2 : PRIX ET MODALITES DE REGLEMENT";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 15, 'color' => 'black', 'bold' => true, 'underline' => 'single'));
        
        $content = "Les montants du pr??sent contrat est de $somme_contrat_package francs CFA par mois. Avec des frais d???installation de 100000 francs CFA. ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black'));
        $content = "Les redevances mensuelles feront l???objet d???une facture mensuelle adress??e au client par mail et ou physiquement. Les redevances sont en pr??pay??es et sont dues au plus tard 10 jours ?? partir de la date de pr??sentation de la facture. Les paiements seront effectu??s par orange money au +226 64 19 79 79, ch??que ou par virement bancaire au b??n??fice du fournisseur.";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black'));
        
        $content = "ARTICLE 3 : DUREE DU CONTRAT";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 15, 'color' => 'black', 'bold' => true, 'underline' => 'single'));
        
        $content = "L'abonnement prend effet lorsque le service est install?? et en service chez le client. L'abonnement est souscrit pour une p??riode minimale d???une ann??e. Il est renouvelable par tacite reconduction pour une dur??e ind??termin??e sauf instruction contraire de l???une ou l???autre partie par ??crit au moins trois (3) mois avant l???expiration de la p??riode initiale d???un (01) ans. ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        
        $content = "ARTICLE 4 : MODIFICATIONS";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 15, 'color' => 'black', 'bold' => true, 'underline' => 'single'));
        
        $content = "Le fournisseur s???engage ?? informer l???abonn??, un mois ?? l???avance, de toute modification portant sur le contenu des prestations fournies, de leur dur??e et de leur prix. En cas d???acceptation de ces modifications par le client, les nouvelles dispositions s???appliqueront ?? la date du changement effectif. En cas de non acceptation de ces modifications, l???abonn?? aura la facult?? de r??silier son abonnement. Il devra proc??der ?? cette r??siliation par courrier, dans le mois pr??c??dant la date du changement effectif. ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        
        $content = "ARTICLE 5 : RESILIATION ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 15, 'color' => 'black', 'bold' => true, 'underline' => 'single'));
        
        $content = "5.1 R??siliation normale par l???abonn??";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black', 'bold' => true));
        
        $content = "Le client peut, au terme de l???ann??e contractuel, le r??silier. La r??siliation prend effet si elle est re??ue au moins trois (03) mois avant la fin du pr??sent contrat. Si le client, avant le terme du pr??sent, met fin ou r??silie son contrat, il restera redevable de tous les frais restants dus, jusqu????? l?????ch??ance du contrat plus profiter du service Internet (Indisponibilit?? totale du service pendant au moins 15 jours) sans pr??judice de tous dommages et int??r??ts. En cas de reconduction pour une p??riode ind??termin??e, il peut ??tre d??nonc?? ?? tout moment par l???une ou l???autre partie, sous r??serve du respect du pr??avis de trois (3) mois notifi?? par ??crit. 
        ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        
        $content = "5.2 R??siliation par le fournisseur ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black', 'bold' => true));
        
        $content = "Tout manquement de l???abonn?? aux conditions du pr??sent contrat est de nature ?? entrainer la r??siliation imm??diate de l???abonnement sans pr??judice de tous dommages et int??r??ts. En cas de retard dans les paiements et faute de r??gularisation dans les d??lais pr??vue par la lettre de mise en demeure adress??e par le fournisseur, l???abonnement sera imm??diatement r??siliable de plein droit par le fournisseur. Dans tous les cas, les sommes dont l???abonn?? est redevable ?? la date de la r??siliation restent dues par ce dernier. En cas d???impay??s, les frais y aff??rents ainsi que ceux n??cessaires ?? leur recouvrement, sont ??galement ?? la charge de l???abonn?? 
        ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        
        $content = "5.3 R??siliation automatique en cas d???impossibilit?? technique de raccordement";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black', 'bold' => true));
        
        $content = "Dans certains cas, la fourniture du service peut s???av??rer techniquement impossible. Si une telle situation est constat??e, le pr??sent contrat deviendra 
        automatiquement caduc. Le fournisseur en informera l???abonn?? par courrier ou par t??l??phone et lui signalera ult??rieurement toute ??volution du r??seau ou des conditions techniques qui permettrait d???envisager ?? nouveau le raccordement. 
        ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        
        $content = "ARTICLE 8 : OBLIGATIONS DES PARTIES";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 15, 'color' => 'black', 'bold' => true, 'underline' => 'single'));
        
        $content = "8.1 OBLIGATIONS DU CLIENT ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black', 'bold' => true));
        
        $content = "8.1.1 PROPRIETE ET PROTECTION DE L???EQUIPEMENT";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black', 'bold' => true));
        
        $content = "L?????quipement fourni aux termes des pr??sentes demeure la propri??t?? du fournisseur, toutefois, le client en a l???enti??re responsabilit??. Il doit prot??ger l?????quipement du fournisseur contre la d??t??rioration, l???alt??ration ou les dommages et n???autoriser personne, sauf un repr??sentant du fournisseur, ?? effectuer des travaux ou une quelconque manipulation sur cet ??quipement. Le client devra rembourser au fournisseur le co??t int??gral de la r??paration ou du remplacement de l?????quipement perdu, vol??, endommag??, non retourn?? ?? l?????ch??ance, hypoth??qu??, vendu, lou??, c??d?? ou transf??r??, en totalit?? ou en partie. ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        
        $content = "8.1.2 USAGE CONFORME";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black', 'bold' => true));
        
        $content = "Le pr??sent contrat n???exon??re pas le client de sa responsabilit?? civile et p??nale dans le cadre des droits li??s ?? l???utilisation de logiciels informatiques. L???abonn?? est responsable des informations qu???il fait transiter par le r??seau du fournisseur, en diffusion ou en lecture, m??me s???il n???en est pas le cr??ateur.";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        $content = "Le client est responsable de sa propre s??curit?? informatique. L???abonnement et les ??l??ments de reconnaissance, fournis par le fournisseur, sont personnels et ne peuvent en aucun cas ??tre transf??r??s ?? un tiers sous peine de r??siliation imm??diate selon les dispositions de l???article 7alin??as 2 des pr??sentes. 
        ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        $content = "Il est express??ment convenu que l???abonn?? qui c??de son contrat en violation de l???interdiction ci-dessus, reste tenu du r??glement du prix de l???abonnement et de l???int??gralit?? des consommations li??es ?? la formule de fourniture souscrite. 
        ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        $content = "Restent ??galement ?? la charge de l???abonn??, sans que puisse ??tre recherch??e la responsabilit?? du fournisseur, les cons??quences dommageables de ses fautes ou n??gligences ainsi que de celles des personnes ou des choses dont il a la garde. ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        
        $content = "8.1.3 INTERDICTIONS";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black', 'bold' => true));
        
        $content = "Il est formellement interdit au client, sous peine de r??siliation de son abonnement et sans pr??judice de tous dommages et int??r??ts et poursuites, d???introduire dans le r??seau des perturbations de toute nature. Dans ce cas, le client sera tenu pour responsable de ces perturbations tant ?? l?????gard du fournisseur qu????? l?????gard des tiers. 
        ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        
        $content = "8.2 OBLIGATION DU FOURNISSEUR";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black', 'bold' => true));
        
        $content = "Le fournisseur est responsable de la qualit?? de la connexion depuis le n??ud d???acc??s jusqu???au point d???entr??e du r??seau, propri??t?? du fournisseur, c??t?? client. 
        ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        $content = "Le fournisseur ne saurait ??tre tenu responsable des pannes, coupures de lignes, mauvaise configuration de mat??riel, des ??quipements, etc., qui ne sont pas sous ou qu???elle n???a pas fourni, et notamment des liaisons de tous types assur??s par d???autres prestataires.";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        $content = "Le fournisseur ne garantit pas les taux de transfert et les temps de r??ponse des informations circulant dans le r??seau Internet.";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        $content = "L???acc??s au r??seau sera en principe assur?? en permanence, sous r??serve de contraintes et al??as ind??pendants de la volont?? du fournisseur, affectant la continuit?? et la qualit?? du service, et ne pouvant ??tre raisonnablement surmont??s ou ??vit??s malgr?? les pr??cautions prises lors de la conception, de la construction, de l???entretien et de l???exploitation de la plateforme de connexion ou du r??seau. ";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        $content = "Les contraintes et al??as peuvent ??tre soit inh??rents aux mat??riels ou aux logiciels compte tenu des connaissances acquises en la mati??re et des technologies utilisables, soit ext??rieurs dans le cas d???actions de tiers volontaires ou accidentelles, d???incendie, d???explosion, d???accident de toute nature. Ces cas ne sont pas limitatifs et ne sont pas n??cessairement constitutifs de cas de force majeure au sens strict entendu par la jurisprudence.";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        $content = "Les interruptions programm??es du service, pour effectuer des travaux de toute nature n??cessaires ?? l???entretien ou ?? l?????volution de l???offre feront l???objet d???un avis ?? l???abonn?? et ne donneront lieu ?? aucune indemnisation. Les travaux programmables ?? l???avance (entretien, extension, etc.) seront effectu??s dans toute la mesure du possible, en dehors des plages de grande utilisation.";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        $content = "En cas d???interruption du service, le fournisseur prendra imm??diatement les dispositions n??cessaires pour assurer sa remise en service dans les meilleurs d??lais.";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        $content = "Le fournisseur est responsable des outils logiciels mis ?? la disposition de ses abonn??s lors de la souscription du contrat et n??cessaire ?? la connexion et ?? l?????change de donn??es entre le site du client et la plateforme informatique du fournisseur.";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        $content = "Tout diff??rend, difficult?? ou contestation relatif ?? l???ex??cution ou l???interpr??tation du pr??sent contrat sera r??gl?? amiablement. En l???absence d???accord amiable le diff??rend, difficult?? ou contestation sera r??gi par le tribunal du commerce du Burkina Faso.";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        $content = "Les pr??sentes conditions sont r??dig??es en langue fran??aise";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        
        $content = "ARTICLE 10 : ELECTION DE DOMICILE";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 15, 'color' => 'black', 'bold' => true, 'underline' => 'single'));
        
        $content = "Pour tout ce qui n???est pas pr??cis?? au contrat, les parties s???en remettent aux dispositions l??gales et r??glementaires en vigueur au Burkina Faso.";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        
        $content = "Les parties d??clarent avoir pris connaissance des dispositions l??gales, r??glementaires et conventionnelles en mati??re de t??l??com et en acceptent l???application dans le cadre du pr??sent contrat.";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black'));   
        
        $content = "Le contrat est ??tablit en deux (02) exemplaires originaux, dont un exemplaire est remis ?? chaque partie.";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        
        $content = "EN FOI DE QUOI, LES PARTIES ONT SIGNE LES PRESENTES";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black', 'bold' => true)); 
        
        $content = "Date d'activation le 02 D??c. 2021";
        $newSection->addText($content, array('name' => 'Times New Roman', 'size' => 11, 'color' => 'black')); 
        
        Carbon::setLocale('fr');
        $content = "Fait ?? Ouagadougou, le " . $date_contrat;
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
