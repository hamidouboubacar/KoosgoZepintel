<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paiement;
use App\Models\Package;
use App\Models\Document;
use Carbon\Carbon;
use App\Models\Client;
use App\Models\DocumentPackage;
use App\Models\DocumentProduit;
use DB;

class StatistiqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Statistique";
        $data = [];

        /**
         * Chiffre d'affaire
         */
        $chiffre_affaires = Document::whereBetween('date', [\Carbon\Carbon::now()->startOfYear(), \Carbon\Carbon::now()->endOfYear()])
            ->where('type', 'Facture')
            ->select(DB::raw('MONTH(date) month'), DB::raw('sum(documents.montantht) as total'))
            ->groupBy('month')
            ->pluck('total', 'month')
            ->all();
        $year = \Carbon\Carbon::now()->translatedFormat('Y');
        $chiffre_affaires_data = [];
        for($i = 1; $i <= 12; $i++) array_push($chiffre_affaires_data, $chiffre_affaires[$i] ?? 0);
        $data['chiffre_affaires']['labels'] = ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Dec'];
        $data['chiffre_affaires']['data'] = $chiffre_affaires_data;
        
        /**
         * Répartition du type de package vendu
         */
        $packages = DocumentPackage::whereBetween('date', [\Carbon\Carbon::now()->startOfYear(), \Carbon\Carbon::now()->endOfYear()])
            ->join('packages', 'packages.id', '=', 'document_packages.package_id')
            ->join('documents', 'documents.id', '=', 'document_packages.document_id')
            ->where('ref', 'LIKE', 'SER%')
            ->where('documents.type', 'Facture')
            ->whereNotIn('ref', ['SER23', 'SER36', 'ServRout'])
            ->select('packages.nom as nom', DB::raw('count(document_packages.package_id) as total'))
            ->groupBy('packages.nom')
            ->pluck('total', 'nom')
            ->all();
        $packages_repartition_data = [];
        for($i = 1; $i <= Package::all()->count(); $i++) array_push($packages_repartition_data, $packages[$i] ?? 0);
        $data['packages']['labels'] = array_keys($packages);
        $data['packages']['data'] = array_values($packages);

        /**
         * Chiffre d'affaire par package
         */
        $chiffre_affaire_packages = Package::whereBetween('date', [\Carbon\Carbon::now()->startOfYear(), \Carbon\Carbon::now()->endOfYear()])
            ->join('document_packages', 'packages.id', '=', 'document_packages.package_id')
            ->join('documents', 'documents.id', '=', 'document_packages.document_id')
            ->where('ref', 'LIKE', 'SER%')
            ->where('documents.type', 'Facture')
            ->whereNotIn('ref', ['SER23', 'SER36', 'ServRout'])
            ->select('packages.nom as nom', DB::raw('sum(document_packages.prix_unitaire) as total'))
            ->groupBy('packages.nom')
            ->pluck('total', 'nom')
            ->all();
        $packages_ca_data = [];
        for($i = 1; $i <= Package::all()->count(); $i++) array_push($packages_ca_data, $chiffre_affaire_packages[$i] ?? 0);
        $data['chiffre_affaire_packages']['labels'] = array_keys($chiffre_affaire_packages);
        $data['chiffre_affaire_packages']['data'] = array_values($chiffre_affaire_packages);
        
        /**
         * Montant recouvré
         */
        $paiements = Document::whereBetween('date', [\Carbon\Carbon::now()->startOfYear(), \Carbon\Carbon::now()->endOfYear()])
            ->select(DB::raw('MONTH(date) month'), DB::raw('sum(documents.total_versement) as total'))
            ->groupBy('month')
            ->pluck('total', 'month')
            ->all();
        $year = \Carbon\Carbon::now()->translatedFormat('Y');
        $paiements_data = [];
        for($i = 1; $i <= 12; $i++) array_push($paiements_data, $paiements[$i] ?? 0);
        $data['paiements']['labels'] = ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Dec'];
        $data['paiements']['data'] = $paiements_data;
        
        /**
         * Créance client
         */
        $creances = Document::whereBetween('date', [\Carbon\Carbon::now()->startOfYear(), \Carbon\Carbon::now()->endOfYear()])
            ->where('type', 'Facture')
            ->select(DB::raw('MONTH(date) month'), DB::raw('sum(documents.reste_a_payer) as total'))
            ->groupBy('month')
            ->pluck('total', 'month')
            ->all();
        $year = \Carbon\Carbon::now()->translatedFormat('Y');
        $creances_data = [];
        for($i = 1; $i <= 12; $i++) array_push($creances_data, $creances[$i] ?? 0);
        $data['creance_clients']['labels'] = ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Dec'];
        $data['creance_clients']['data'] = $creances_data;

        /**
         * Document Package / MRC (Monthly Recurrente Charge)
         */
        $document_packages = Document::whereBetween('date', [\Carbon\Carbon::now()->startOfYear(), \Carbon\Carbon::now()->endOfYear()])
            ->join('document_packages', 'documents.id', '=', 'document_packages.document_id')
            ->join('packages', 'packages.id', '=', 'document_packages.package_id')
            ->where('ref', 'LIKE', 'SER%')
            ->where('documents.type', 'Facture')
            ->whereNotIn('ref', ['SER23', 'SER36', 'ServRout'])
            ->select(DB::raw('MONTH(documents.date) month'), DB::raw('sum(document_packages.prix_unitaire) as total'))
            ->groupBy('month')
            ->pluck('total', 'month')
            ->all();
        $document_packages_data = [];
        for($i = 1; $i <= 12; $i++) array_push($document_packages_data, $document_packages[$i] ?? 0);
        $data['document_packages']['labels'] = ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Dec'];
        $data['document_packages']['data'] = $document_packages_data;

        /**
         * Frais d'installation / NRC (Non Recurrente Charge)
         */
        // $nrc = Document::whereBetween('date', [\Carbon\Carbon::now()->startOfYear(), \Carbon\Carbon::now()->endOfYear()])
        //     ->select(DB::raw('MONTH(date) month'), DB::raw('sum(documents.frais_installation) as total'))
        //     ->groupBy('month')
        //     ->pluck('total', 'month')
        //     ->all();
        $nrc = Document::whereBetween('date', [\Carbon\Carbon::now()->startOfYear(), \Carbon\Carbon::now()->endOfYear()])
            ->join('document_packages', 'documents.id', '=', 'document_packages.document_id')
            ->join('packages', 'packages.id', '=', 'document_packages.package_id')
            ->where('ref', 'SER23')
            ->where('documents.type', 'Facture')
            ->select(DB::raw('MONTH(documents.date) month'), DB::raw('sum(document_packages.prix_unitaire) as total'))
            ->groupBy('month')
            ->pluck('total', 'month')
            ->all();
        $nrc_data = [];
        for($i = 1; $i <= 12; $i++) array_push($nrc_data, $nrc[$i] ?? 0);
        $data['nrc']['labels'] = ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Dec'];
        $data['nrc']['data'] = $nrc_data;
        
        /**
         * Document Produit
         */
        // $document_produits = Document::whereBetween('date', [\Carbon\Carbon::now()->startOfYear(), \Carbon\Carbon::now()->endOfYear()])
        //     ->join('document_produits', 'documents.id', '=', 'document_produits.document_id')
        //     ->select(DB::raw('MONTH(documents.date) month'), DB::raw('sum(document_produits.montant) as total'))
        //     ->groupBy('month')
        //     ->pluck('total', 'month')
        //     ->all();
        $document_produits = Document::whereBetween('date', [\Carbon\Carbon::now()->startOfYear(), \Carbon\Carbon::now()->endOfYear()])
            ->join('document_packages', 'documents.id', '=', 'document_packages.document_id')
            ->join('packages', 'packages.id', '=', 'document_packages.package_id')
            ->where('ref', 'NOT LIKE', 'SER%')
            ->where('documents.type', 'Facture')
            ->where('ref', '!=', 'ServRout')
            ->select(DB::raw('MONTH(documents.date) month'), DB::raw('sum(document_packages.prix_unitaire) as total'))
            ->groupBy('month')
            ->pluck('total', 'month')
            ->all();
        $document_produits_data = [];
        for($i = 1; $i <= 12; $i++) array_push($document_produits_data, $document_produits[$i] ?? 0);
        $data['document_produits']['labels'] = ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Dec'];
        $data['document_produits']['data'] = $document_produits_data;

        return view("statistiques.index", compact("title", "data", "year"));
    }


    public function statistiqueTVA(){
       
        $tva = Document::where('type', 'Facture')->where('etat', 1)->sum('tva');
        $nbrFacTva = Document::where('type', 'Facture')->where('etat', 1)->where('tva', '>', 0)->count();
        $statistiques = Document::where('type', 'Facture')->where('etat', 1)->where('tva', '>', 0)->get();
        
        // $sql1="SELECT MONTH(date) AS mois,montantht AS montantht,montantttc AS montantttc FROM document WHERE type='Facture' AND YEAR(date)='$annee' GROUP BY mois";

        $res= Document::where('type','Facture')->where('etat', 1)->where('tva', '>', 0)
        ->get()
        ->groupBy(function($val) {
            dd(Carbon::parse($val->date)->format('M'));
        return Carbon::parse($val->date)->format('m');
  });
        // $documents = Document::where('type', 'Facture')->where('etat', 1)->where('tva', '>', 0)->whereBetween('date',[$monthStartDate, $monthEndDate])->sum('montantttc');
        // dd($res);
        return view("statistiques.tva", [
            'tva'=>$tva,
            'nbrFacTva'=>$nbrFacTva,
            'res'=>$res,
            
        ]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Statistiques des ventes
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ventes(Request $request)
    {
        $data = [];

        /**
         * Chiffre d'affaire graphe
         */
        
        if(isset($request->annee1) && isset($request->annee2)) {
            $data['comparaison'] = true;
            $annee1 = \Carbon\Carbon::parse($request->annee1);
            $annee2 = \Carbon\Carbon::parse($request->annee2);
            $data['annee2'] = $request->annee2;
            
            $chiffre_affaires2 = Document::whereYear('date', $request->annee2)
                ->where('type', 'Facture')
                ->select(DB::raw('MONTH(date) month'), DB::raw('sum(documents.montantht) as total'))
                ->groupBy('month')
                ->pluck('total', 'month')
                ->all();
            // $data['year'] = $annee1->translatedFormat('Y');
            $chiffre_affaires_data = [];
            for($i = 1; $i <= 12; $i++) array_push($chiffre_affaires_data, $chiffre_affaires2[$i] ?? 0);
            $data['chiffre_affaires2']['labels'] = ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Dec'];
            $data['chiffre_affaires2']['data'] = $chiffre_affaires_data;
            $data['year'] = $request->annee1;
        } elseif(isset($request->annee1)) {
            $data['comparaison'] = false;
            $data['year'] = $request->annee1;
        } else {
            $data['comparaison'] = false;
            $annee1 = \Carbon\Carbon::now();
            $data['year'] = $annee1->translatedFormat('Y');
        }
        
        $chiffre_affaires = Document::whereYear('date', $data['year'])
            ->where('type', 'Facture')
            ->select(DB::raw('MONTH(date) month'), DB::raw('sum(documents.montantht) as total'))
            ->groupBy('month')
            ->pluck('total', 'month')
            ->all();
        $chiffre_affaires_data = [];
        for($i = 1; $i <= 12; $i++) array_push($chiffre_affaires_data, $chiffre_affaires[$i] ?? 0);
        $data['chiffre_affaires']['labels'] = ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Dec'];
        $data['chiffre_affaires']['data'] = $chiffre_affaires_data;
        
        /**
         * Total Chiffre d'affaire
         */
        $data['chiffre_affaires_total'] = Document::whereYear('date', $data['year'])
            ->where('type', 'Facture')
            ->select(DB::raw('sum(documents.montantht) as total'))
            ->pluck('total')
            ->all()[0];

        /**
         * Total Facture
         */
        $data['nombre_facture_total'] = Document::whereYear('date', $data['year'])
            ->where('type', 'Facture')
            ->get()->count();

        /**
         * Total Encours
         */
        $data['en_cours_total'] = Document::whereYear('date', $data['year'])
            ->where('type', 'Facture')
            ->select(DB::raw('sum(documents.total_versement) as total'))
            ->pluck('total')
            ->all()[0];

        /**
         * Liste des 10 dernieres annees
         */
        $data['annees'] = [];
        $annee = (int)\Carbon\Carbon::now()->translatedFormat('Y');
        for($i = 0; $i < 10; $i++)
            array_push($data['annees'], $annee - $i);
          
        /**
         * Chiffre A. HT
         */
        $chiffre_affaires_ht = Document::whereYear('date', $data['year'])
            ->where('type', 'Facture')
            ->select(DB::raw('MONTH(date) month'), DB::raw('sum(documents.montantht) as total'))
            ->groupBy('month')
            ->pluck('total', 'month')
            ->all();
        $chiffre_affaires_data = [];
        for($i = 1; $i <= 12; $i++) array_push($chiffre_affaires_data, $chiffre_affaires_ht[$i] ?? 0);
        $data['chiffre_affaires_ht']['labels'] = ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Dec'];
        $data['chiffre_affaires_ht']['data'] = $chiffre_affaires_data;

        /**
         * Chiffre A. TTC
         */
        $chiffre_affaires_ttc = Document::whereYear('date', $data['year'])
            ->where('type', 'Facture')
            ->select(DB::raw('MONTH(date) month'), DB::raw('sum(documents.montantttc) as total'))
            ->groupBy('month')
            ->pluck('total', 'month')
            ->all();
        $chiffre_affaires_data = [];
        for($i = 1; $i <= 12; $i++) array_push($chiffre_affaires_data, $chiffre_affaires_ttc[$i] ?? 0);
        $data['chiffre_affaires_ttc']['labels'] = ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Dec'];
        $data['chiffre_affaires_ttc']['data'] = $chiffre_affaires_data;
        
        /**
         * Recouvrement
         */
        $chiffre_affaires_ht = Document::whereYear('date', $data['year'])
            ->where('type', 'Facture')
            ->select(DB::raw('MONTH(date) month'), DB::raw('sum(documents.total_versement) as total'))
            ->groupBy('month')
            ->pluck('total', 'month')
            ->all();
        $chiffre_affaires_data = [];
        for($i = 1; $i <= 12; $i++) array_push($chiffre_affaires_data, $chiffre_affaires_ht[$i] ?? 0);
        $data['chiffre_affaires_recouvrement']['labels'] = ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Dec'];
        $data['chiffre_affaires_recouvrement']['data'] = $chiffre_affaires_data;
        $data['total_versement'] = 0;
        foreach($chiffre_affaires_data as $ca) $data['total_versement'] += $ca;

        return view('statistiques.ventes', $data);
    }

    /**
     * Statistiques des TVA
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function tva(Request $request)
    {
        $data = [];

        /**
         * TVA graphe
         */
        if(isset($request->annee1) && isset($request->annee2)) {
            $data['comparaison'] = true;
            $annee1 = \Carbon\Carbon::parse($request->annee1);
            $annee2 = \Carbon\Carbon::parse($request->annee2);
            $data['annee2'] = $request->annee2;
            
            $chiffre_affaires2 = Document::whereYear('date', $request->annee2)
                ->where('type', 'Facture')
                ->select(DB::raw('MONTH(date) month'), DB::raw('sum(documents.tva) as total'))
                ->groupBy('month')
                ->pluck('total', 'month')
                ->all();
            // $data['year'] = $annee1->translatedFormat('Y');
            $chiffre_affaires_data = [];
            for($i = 1; $i <= 12; $i++) array_push($chiffre_affaires_data, $chiffre_affaires2[$i] ?? 0);
            $data['chiffre_affaires2']['labels'] = ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Dec'];
            $data['chiffre_affaires2']['data'] = $chiffre_affaires_data;
            $data['year'] = $request->annee1;
        } elseif(isset($request->annee1)) {
            $data['comparaison'] = false;
            $data['year'] = $request->annee1;
        } else {
            $data['comparaison'] = false;
            $annee1 = \Carbon\Carbon::now();
            $data['year'] = $annee1->translatedFormat('Y');
        }
        
        $chiffre_affaires = Document::whereYear('date', $data['year'])
            ->where('type', 'Facture')
            ->select(DB::raw('MONTH(date) month'), DB::raw('sum(documents.tva) as total'))
            ->groupBy('month')
            ->pluck('total', 'month')
            ->all();
        $chiffre_affaires_data = [];
        for($i = 1; $i <= 12; $i++) array_push($chiffre_affaires_data, $chiffre_affaires[$i] ?? 0);
        $data['chiffre_affaires']['labels'] = ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Dec'];
        $data['chiffre_affaires']['data'] = $chiffre_affaires_data;
        
        
        /**
         * Total TVA
         */
        $data['tva_total'] = Document::whereYear('date', $data['year'])
            ->where('type', 'Facture')
            ->select(DB::raw('sum(documents.tva) as total'))
            ->pluck('total')
            ->all()[0];

        /**
         * Total Facture
         */
        $data['nombre_facture_total'] = Document::whereYear('date', $data['year'])
            ->where('type', 'Facture')
            ->whereNotNull('tva')
            ->get()->count();
            
        /**
         * Liste des 10 dernieres annees
         */
        $data['annees'] = [];
        $annee = (int)\Carbon\Carbon::now()->translatedFormat('Y');
        for($i = 0; $i < 10; $i++)
            array_push($data['annees'], $annee - $i);
          
        /**
         * Chiffre A. HT
         */
        $chiffre_affaires_ht = Document::whereYear('date', $data['year'])
            ->where('type', 'Facture')
            ->select(DB::raw('MONTH(date) month'), DB::raw('sum(documents.montantht) as total'))
            ->groupBy('month')
            ->pluck('total', 'month')
            ->all();
        $chiffre_affaires_data = [];
        for($i = 1; $i <= 12; $i++) array_push($chiffre_affaires_data, $chiffre_affaires_ht[$i] ?? 0);
        $data['chiffre_affaires_ht']['labels'] = ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Dec'];
        $data['chiffre_affaires_ht']['data'] = $chiffre_affaires_data;
        
        /**
         * Recouvrement
         */
        $chiffre_affaires_ht = Document::whereYear('date', $data['year'])
            ->where('type', 'Facture')
            ->select(DB::raw('MONTH(date) month'), DB::raw('sum(documents.total_versement) as total'))
            ->groupBy('month')
            ->pluck('total', 'month')
            ->all();
        $chiffre_affaires_data = [];
        for($i = 1; $i <= 12; $i++) array_push($chiffre_affaires_data, $chiffre_affaires_ht[$i] ?? 0);
        $data['chiffre_affaires_recouvrement']['labels'] = ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Dec'];
        $data['chiffre_affaires_recouvrement']['data'] = $chiffre_affaires_data;
        $data['total_versement'] = 0;
        foreach($chiffre_affaires_data as $ca) $data['total_versement'] += $ca;
        
        /**
         * TVA
         */
        $chiffre_affaires_ht = Document::whereYear('date', $data['year'])
            ->where('type', 'Facture')
            ->select(DB::raw('MONTH(date) month'), DB::raw('sum(documents.tva) as total'))
            ->groupBy('month')
            ->pluck('total', 'month')
            ->all();
        $chiffre_affaires_data = [];
        for($i = 1; $i <= 12; $i++) array_push($chiffre_affaires_data, $chiffre_affaires_ht[$i] ?? 0);
        $data['tva']['labels'] = ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Dec'];
        $data['tva']['data'] = $chiffre_affaires_data;

        return view('statistiques.tva', $data);
    }

    /**
     * Statistiques des clients
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function clients(Request $request)
    {
        $data = [];
        
        $data['year'] = \Carbon\Carbon::now()->translatedFormat('Y');
        
        /**
         * Liste des clients
         */
        $data['clients'] = Client::where('type', 'Client')->orderBy('name')->get();
        
        /**
         * Liste des 10 dernieres annees
         */
        $data['annees'] = [];
        $annee = (int)\Carbon\Carbon::now()->translatedFormat('Y');
        for($i = 0; $i < 10; $i++)
            array_push($data['annees'], $annee - $i);
            
        /**
         * Données pour tableau de variation des clients
         */
        $data['variation_clients'] = Document::whereYear('date', $data['year'])
            ->where('type', 'Facture')
            ->select('client_id', DB::raw('count(documents.id) as total'), DB::raw('sum(documents.montantht) as total_ht'), DB::raw('sum(documents.montantttc) as total_ttc'), DB::raw('sum(documents.total_versement) as total_versement'), DB::raw('sum(documents.tva) as total_tva'))
            ->groupBy('client_id')
            ->get();
         
        /**
         * Evolution
         */
        $data['evolution'] = false;
        if(isset($request->client_id) && isset($request->annee)) {
            $data['evolution'] = true;
            $data['client_evolution'] = Client::find($request->client_id);
            $data['year'] = $request->annee;
            $chiffre_affaires_ttc = Document::whereYear('date', $request->annee)
                ->where('type', 'Facture')
                ->where('client_id', $request->client_id)
                ->select(DB::raw('MONTH(date) month'), DB::raw('sum(documents.montantttc) as total'))
                ->groupBy('month')
                ->pluck('total', 'month')
                ->all();
            $chiffre_affaires_data = [];
            for($i = 1; $i <= 12; $i++) array_push($chiffre_affaires_data, $chiffre_affaires_ttc[$i] ?? 0);
            $data['client_evolution']['labels'] = ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Dec'];
            $data['client_evolution']['data'] = $chiffre_affaires_data;
            
            /**
             * Chiffre A. HT
             */
            $chiffre_affaires_ht = Document::whereYear('date', $data['year'])
                ->where('type', 'Facture')
                ->where('client_id', $request->client_id)
                ->select(DB::raw('MONTH(date) month'), DB::raw('sum(documents.montantht) as total'))
                ->groupBy('month')
                ->pluck('total', 'month')
                ->all();
            $chiffre_affaires_data = [];
            for($i = 1; $i <= 12; $i++) array_push($chiffre_affaires_data, $chiffre_affaires_ht[$i] ?? 0);
            $data['client_evolution_ht']['labels'] = ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Dec'];
            $data['client_evolution_ht']['data'] = $chiffre_affaires_data;
            
            /**
             * Recouvrement
             */
            $chiffre_affaires_ht = Document::whereYear('date', $data['year'])
                ->where('type', 'Facture')
                ->where('client_id', $request->client_id)
                ->select(DB::raw('MONTH(date) month'), DB::raw('sum(documents.total_versement) as total'))
                ->groupBy('month')
                ->pluck('total', 'month')
                ->all();
            $chiffre_affaires_data = [];
            for($i = 1; $i <= 12; $i++) array_push($chiffre_affaires_data, $chiffre_affaires_ht[$i] ?? 0);
            $data['client_evolution_recouvrement']['labels'] = ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Dec'];
            $data['client_evolution_recouvrement']['data'] = $chiffre_affaires_data;
            
            /**
             * TVA
             */
            $chiffre_affaires_ht = Document::whereYear('date', $data['year'])
                ->where('type', 'Facture')
                ->where('client_id', $request->client_id)
                ->select(DB::raw('MONTH(date) month'), DB::raw('sum(documents.tva) as total'))
                ->groupBy('month')
                ->pluck('total', 'month')
                ->all();
            $chiffre_affaires_data = [];
            for($i = 1; $i <= 12; $i++) array_push($chiffre_affaires_data, $chiffre_affaires_ht[$i] ?? 0);
            $data['client_evolution_tva']['labels'] = ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Dec'];
            $data['client_evolution_tva']['data'] = $chiffre_affaires_data;
        }
            
        return view('statistiques.clients', $data);
    }

    /**
     * Statistiques des Package
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function packages(Request $request) {
        $data = [];
        
        $data['year'] = \Carbon\Carbon::now()->translatedFormat('Y');
        $data['evolution'] = false;
        
        /**
         * Liste des packages
         */
        $data['packages'] = Package::all();

        /**
         * Liste des 10 dernieres annees
         */
        $data['annees'] = [];
        $annee = (int)\Carbon\Carbon::now()->translatedFormat('Y');
        for($i = 0; $i < 10; $i++)
            array_push($data['annees'], $annee - $i);
            
        /**
         * Données pour tableau de variation des packages
         */
        $data['variation_packages'] = DocumentPackage::join('packages', 'packages.id', '=', 'document_packages.package_id')
            ->join('documents', 'document_packages.document_id', '=', 'documents.id')
            ->where('ref', 'LIKE', 'SER%')
            ->where('documents.type', 'Facture')
            ->whereNotIn('ref', ['SER23', 'SER36', 'ServRout'])
            ->whereYear('documents.date', $data['year'])
            ->select('documents.client_id', DB::raw('count(documents.id) as total'), DB::raw('sum(documents.montantht) as total_ht'), DB::raw('sum(documents.montantttc) as total_ttc'), DB::raw('sum(documents.total_versement) as total_versement'), DB::raw('sum(documents.tva) as total_tva'))
            ->groupBy('documents.client_id')
            ->groupBy('packages.nom')
            ->orderBy('packages.nom')
            ->get();

        $chiffre_affaire_packages = DocumentPackage::join('packages', 'packages.id', '=', 'document_packages.package_id')
            ->join('documents', 'document_packages.document_id', '=', 'documents.id')
            ->where('ref', 'LIKE', 'SER%')
            ->where('documents.type', 'Facture')
            ->whereNotIn('ref', ['SER23', 'SER36', 'ServRout'])
            ->whereYear('documents.date', $data['year'])
            ->select('packages.nom as nom', DB::raw('sum(document_packages.prix_unitaire)  as total'))
            // ->groupBy('documents.client_id')
            ->groupBy('packages.nom')
            ->orderBy('packages.nom')
            ->pluck('total', 'nom')
            ->all();
        // $data['variation_packages']['labels'] = array_keys($chiffre_affaire_packages);
        $data['variation_packages']['chiffre_affaire'] = array_values($chiffre_affaire_packages);

        /**
         * Nombre de client par package
         */
        $chiffre_affaire_packages = DocumentPackage::join('packages', 'packages.id', '=', 'document_packages.package_id')
            ->join('documents', 'documents.id', '=', 'document_packages.document_id')
            ->where('documents.type', 'Facture')
            ->whereYear('documents.date', $data['year'])
            ->where('packages.ref', 'LIKE', 'SER%')
            ->whereNotIn('packages.ref', ['SER23', 'SER36', 'ServRout'])
            ->select('packages.nom as nom', DB::raw('count(distinct documents.client_id) as total'))
            // ->groupBy('documents.client_id')
            ->groupBy('packages.nom')
            ->orderBy('packages.nom')
            ->pluck('total', 'nom')
            ->all();
        $data['variation_packages']['labels'] = array_keys($chiffre_affaire_packages);
        $data['variation_packages']['total_client'] = array_values($chiffre_affaire_packages);

        /**
         * Nombre de facture par package
         */
        $chiffre_affaire_packages = DocumentPackage::join('packages', 'packages.id', '=', 'document_packages.package_id')
            ->join('documents', 'documents.id', '=', 'document_packages.document_id')
            ->where('documents.type', 'Facture')
            ->whereYear('documents.date', $data['year'])
            ->where('packages.ref', 'LIKE', 'SER%')
            ->whereNotIn('packages.ref', ['SER23', 'SER36', 'ServRout'])
            ->select('packages.nom as nom', DB::raw('count(documents.id) as total'))
            // ->groupBy('documents.id')
            ->groupBy('packages.nom')
            ->orderBy('packages.nom')
            ->pluck('total', 'nom')
            ->all();
        $data['variation_packages']['total_facture'] = array_values($chiffre_affaire_packages);

        /**
         * Evolution
         */
        $data['evolution'] = false;
        if(isset($request->package_id) && isset($request->annee)) {
            $data['evolution'] = true;
            $data['package_evolution'] = Package::find($request->package_id);
            $data['year'] = $request->annee;

            $chiffre_affaires = Package::join('document_packages', 'packages.id', '=', 'document_packages.package_id')
                ->join('documents', 'documents.id', '=', 'document_packages.document_id')
                ->where('ref', 'LIKE', 'SER%')
                ->where('documents.type', 'Facture')
                ->whereNotIn('ref', ['SER23', 'SER36', 'ServRout'])    
                ->whereYear('documents.date', $request->annee)
                ->where('packages.id', $request->package_id)
                ->select(DB::raw('MONTH(documents.date) month'), DB::raw('sum(packages.montant) as total'))
                ->groupBy('month')
                ->pluck('total', 'month')
                ->all();
            $chiffre_affaires_data = [];
            for($i = 1; $i <= 12; $i++) array_push($chiffre_affaires_data, $chiffre_affaires[$i] ?? 0);
            $data['package_evolution']['labels'] = ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Dec'];
            $data['package_evolution']['data'] = $chiffre_affaires_data;

             /**
             * Nombre de client par package
             */
            $chiffre_affaire_packages = Package::join('document_packages', 'packages.id', '=', 'document_packages.package_id')
                ->join('documents', 'documents.id', '=', 'document_packages.document_id')->where('ref', 'LIKE', 'SER%')
                ->where('documents.type', 'Facture')
                ->whereNotIn('ref', ['SER23', 'SER36', 'ServRout'])
                ->whereYear('documents.date', $request->annee)
                ->where('packages.id', $request->package_id)
                ->select(DB::raw('MONTH(documents.date) month'), DB::raw('count(documents.client_id) as total'))
                ->groupBy('month')
                ->pluck('total', 'month')
                ->all();
            $chiffre_affaires_data = [];
            for($i = 1; $i <= 12; $i++) array_push($chiffre_affaires_data, $chiffre_affaire_packages[$i] ?? 0);
            $data['package_evolution']['total_client'] = $chiffre_affaires_data;
        }

        return view('statistiques.packages', $data);
    }
}
