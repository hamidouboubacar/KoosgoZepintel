<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\TacheController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ClientController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/login", [ApiController::class, "login"])->name("api.login");
Route::get("/factures", [ApiController::class, "factures"])->name("api.factures");
Route::get("/paiements", [ApiController::class, "paiements"])->name("api.paiements");
Route::get("/impayes", [ApiController::class, "impayes"])->name("api.impayes");
Route::post("/paiement/en_cours", [ApiController::class, "paiement_encours"])->name("api.paiement.encours");

// Route::middleware(['auth:sanctum'])->group(function() {
    Route::post("/paiement", [ApiController::class, "paiement"])->name("api.paiement");
// });

Route::post("/taches/change-stat", [TacheController::class, "changeStat"])->name("taches.change_stat");
Route::post("/taches/supprimer", [TacheController::class, "supprimer"])->name("taches.supprimer");

Route::post("/add-numero-paiement", [ClientController::class, "add_numero_paiement"])->name("numero_paiement.add");
Route::post("/liste-numero-paiement", [ClientController::class, "liste_numero_paiement"])->name("numero_paiement.liste");
Route::post("/change-numero-paiement", [ClientController::class, "change_numero_paiement"])->name("numero_paiement.change");
Route::post("/delete-numero-paiement", [ClientController::class, "delete_numero_paiement"])->name("numero_paiement.delete");

Route::post("/document-package/update", [DocumentController::class, "update_document_pacakge"])->name("document_package.update");
