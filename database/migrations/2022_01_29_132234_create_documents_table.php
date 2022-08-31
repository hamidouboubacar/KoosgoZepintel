<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->nullable();
            $table->string('type');
            $table->string('reference')->nullable();
            $table->string('date')->nullable();
            $table->string('objet')->nullable();
            $table->string('remise')->nullable();
            $table->string('periode')->nullable();
            $table->string('reste_a_payer')->nullable();
            $table->string('delai_de_livraison')->nullable();
            $table->string('validite')->nullable();
            $table->string('commentaire', 1000)->nullable();
            $table->integer('tva')->nullable();
            $table->string('suivi_par')->nullable();
            $table->string('contact_personne')->nullable();
            $table->string('total_versement')->nullable();
            $table->integer('montantttc')->nullable();
            $table->integer('montantht')->nullable();
            $table->string('condition')->nullable();
            $table->foreignId("user_id")->constrained("users")->nullable();
            $table->foreignId("client_id")->constrained("clients")->nullable();
            $table->integer("parent_id")->nullable();
            $table->string('etat')->default(1);
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
        Schema::dropIfExists('documents');
    }
}
