<?php

use App\Http\Controllers\DashbordController;
use App\Http\Controllers\FonctionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BonCommandeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ContratController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProspectController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\CommercialController;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\PlanningTacheController;
use App\Http\Controllers\PlanningRdvController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\PaiementController;
use App\Models\BonLivraison;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OffreServiceController;
use App\Http\Controllers\RefacturationController;
use App\Http\Controllers\StatistiqueController;
use App\Http\Controllers\TacheController;
use App\Models\Refacturation;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('run-cmd', function(){
    // Artisan::call('migrate', ["--force" => true ]);
    // Artisan::call('db:seed', ["--force" => true ]);
    Artisan::call('storage:link');
    Artisan::call('storage');
});

Route::get('db-seed', function(){
    Artisan::call('db:seed', ["--force" => true ]);
});

Route::get('migrate-refresh', function(){
    Artisan::call('migrate:refresh', ["--force" => true ]);
});

Route::get('migrate', function(){
    Artisan::call('migrate', ["--force" => true ]);
});

Route::get('cache-clear', function(){
    Artisan::call('cache:clear');
});

Route::get('route-cache', function(){
    Artisan::call('route:cache');
});

Route::get('config-cache', function(){
    Artisan::call('config:cache');
});

Route::get('/', function () {
    return redirect()->route('login');
 });
 Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [DashbordController::class, 'index'])->name('dashboard');

Route::middleware(['auth'])->group(function() {
    //Fonction
    Route::resource('fonction', FonctionController::class);
    route::get("fonction/supprimer/{fonction}",[FonctionController::class, "delete"])->name("fonction.supprimer");
    //User
    Route::resource('user', UserController::class);
    route::get("user/supprimer/{user}",[UserController::class, "delete"])->name("user.supprimer");
    route::post("user/permission/",[UserController::class, "permission"])->name("user.permission");
    //Role
    Route::resource('role', RoleController::class);
    route::get("role/supprimer/{role}",[RoleController::class, "delete"])->name("role.supprimer");
    //client
    Route::resource('client', ClientController::class);
    route::get("client/supprimer/{client}",[ClientController::class, "delete"])->name("client.supprimer");
    Route::post("client/add", [ClientController::class, "add"])->name("client.add");
    //Prospect
    Route::resource('prospect', ProspectController::class);
    route::get("prospect/supprimer/{prospect}",[ProspectController::class, "delete"])->name("prospect.supprimer");

    //Docuemnt
    Route::resource('document', DocumentController::class);
    route::get("document/supprimer/{document}",[DocumentController::class, "delete"])->name("document.supprimer");

    // Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');

    Route::resource("articles", ArticleController::class);

    Route::resource("packages", PackageController::class);
    Route::post("packages/add", [PackageController::class, "add"])->name("packages.add");

    Route::resource("contrats", ContratController::class);

    Route::post('/contrats/export/{contrat}', [ContratController::class, 'createWordDocx'])->name('contrats.createWordDocx');

    Route::get('/contrats/edit/contrat_content/{contrat}', [ContratController::class, 'edit_contrat_content'])->name('contrats.edit_contrat_content');
    Route::post('/contrats/store/contrat_content/{contrat}', [ContratController::class, 'store_contrat_content'])->name('contrats.store_contrat_content');
    Route::get('/contrats/edit/apercu/{contrat}', [ContratController::class, 'apercu'])->name('contrats.apercu');
    Route::get('/contrats/edit/download/{contrat}', [ContratController::class, 'download'])->name('contrats.download');
    Route::get('/contrats/edit/renouveller/{contrat}', [ContratController::class, 'renouveller'])->name('contrats.renouveller');

    Route::resource("factures", FactureController::class);

    Route::get("/factures/dwonload/{facture}", [FactureController::class, 'download'])->name('factures.download');
    
    Route::get("/factures/avoir/liste", [FactureController::class, 'avoir'])->name('factures.avoir');

    Route::resource("commercials", CommercialController::class);

    Route::resource("planning_taches", PlanningTacheController::class);

    Route::resource("planning_rdvs", PlanningRdvController::class);

    Route::get('commercial-statistiques', [CommercialController::class, 'statistiques'])->name('commercials.statistiques');
    
    Route::get('exportDevis/{document}/{sans_signature}', [DocumentController::class, 'exportDevis'])->name('exportDevis');
    Route::get('exportBon/{document}', [DocumentController::class, 'exportBon'])->name('exportBonlivraison');
    Route::get('exportRecu/{paiement}', [DocumentController::class, 'exportRecu'])->name('exportRecu');
    Route::post('paiement/search', [PaiementController::class, 'search'])->name('paiement.search');
    Route::post('resume/search', [DocumentController::class, 'search'])->name('resume.search');

    Route::get('facturer/{document}', [DocumentController::class, 'facturer'])->name('document.facturer');
    Route::get('document_bon/{document}', [DocumentController::class, 'appercu'])->name('bon.show');
    // Route::get('ExportDevis/{document}', [DocumentController::class, 'exportDevis'])->name('exportDevis');

    Route::get("/notifications/get/liste", [NotificationController::class, 'getNotifications'])->name('notifications.get');

    Route::resource("offre_services", OffreServiceController::class);
    Route::get("offre_services/email/{offreService}", [OffreServiceController::class, 'mail'])->name('offre_services.mail');
    Route::get("offre_services/download/{offreService}", [OffreServiceController::class, 'download'])->name('offre_services.download');
    Route::get('exportDevis/{document}/{sans_signature}', [DocumentController::class, 'exportDevis'])->name('exportDevis');
    Route::get('telecharger/{document}', [ClientController::class, 'telechargerDocument'])->name('telecharger.document');
    Route::get('telechargement/{document}', [ClientController::class, 'telechargerBon'])->name('telecharger.bon');
    Route::get('telechargement/paiement/{paiement}', [ClientController::class, 'telechargerPaiement'])->name('telecharger.paiement');

    Route::resource("paiement", PaiementController::class);
    Route::resource("refacturation", RefacturationController::class);
    Route::get('paiement_document/{document}', [DocumentController::class, 'paiement'])->name('document.paiement');
    route::get("paiement/supprimer/{paiement}",[PaiementController::class, "delete"])->name("paiement.supprimer");
    route::get("paiements/client/{client}",[PaiementController::class, "paiementsClient"])->name("paiements.client");
    route::get("document/livraison/{document}",[DocumentController::class, "livraison"])->name("livraison.livraison");
    route::put("livraison",[DocumentController::class, "livrer"])->name("document.livrer");
    Route::resource("livraison", BonLivraison::class);

    Route::resource("entreprise", EntrepriseController::class);
    route::post("entreprise/updateSave/{entreprise}",[EntrepriseController::class, "updateSave"])->name("entreprise.updateSave");

    Route::put('factureration/{document}', [DocumentController::class, 'factureration'])->name('document.facturation');

    Route::get('resume', [DocumentController::class, 'resume'])->name('resume');
    Route::get('rapport/jour', [DocumentController::class, 'rapportJournalier'])->name('rapportJournalier');
    Route::get('rapport/semaine', [DocumentController::class, 'rapportHebdomadaire'])->name('rapportHebdomadaire');
    Route::get('rapport/mois', [DocumentController::class, 'rapportMensuel'])->name('rapportMensuel');
    Route::get('reglement', [PaiementController::class, 'reglement'])->name('reglement');

    Route::resource("bonCommande", BonCommandeController::class);
    route::get("bonCommande/supprimer/{bonCommande}",[BonCommandeController::class, "delete"])->name("bonCommande.supprimer");
    route::get("refacturation/suppression/{refacturation}/{document}",[RefacturationController::class, "delete"])->name("supprimer");
    route::get("refacturation/validation/{refacturation}",[RefacturationController::class, "validation"])->name("refacturation.validation");
    route::get("/mail",[ClientController::class, "mailDocument"])->name("sendMail");
    route::get("/mail/livraison",[ClientController::class, "mailBonLivraison"])->name("sendMailbl");
    route::get("/mail/paiement",[PaiementController::class, "mailPaiement"])->name("sendMailPaiment");
    route::get("/mail/refacturation",[RefacturationController::class, "mailGroupe"])->name("sendMailGroupe");



    
    Route::resource("statistiques", StatistiqueController::class);    
    route::get("/statistique/TVA",[StatistiqueController::class, "statistiqueTVA"])->name("statistiques.tva");
    Route::get("staistiques/ventes", [StatistiqueController::class, "ventes"])->name("statistiques.ventes");
    Route::get("staistiques/tva", [StatistiqueController::class, "tva"])->name("statistiques.tva");
    Route::get("staistiques/clients", [StatistiqueController::class, "clients"])->name("statistiques.clients");
    Route::get("staistiques/packages", [StatistiqueController::class, "packages"])->name("statistiques.packages");

    Route::post("/taches/store", [TacheController::class, "store"])->name("taches.store");
    // Route::put("/taches/change-stat", [TacheController::class, "changeStat"])->name("taches.change_stat");
    
});

Route::get("client/password_change", [ClientController::class, "password_change"])->name("client.password_change");