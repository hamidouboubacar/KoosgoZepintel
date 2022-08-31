<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaiementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->string('date_paiement')->nullable();
            $table->string('date')->nullable();
            $table->string('etat')->default(1);
            $table->string('montant_payer')->nullable();
            $table->string('reste')->nullable();
            $table->string('mode_paiement')->nullable();
            $table->string('numero_paiement')->nullable();
            $table->string('id_trans')->nullable();
            $table->foreignId("user_id")->constrained("users")->nullable();
            $table->foreignId("document_id")->constrained("documents")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paiements');
    }
}
