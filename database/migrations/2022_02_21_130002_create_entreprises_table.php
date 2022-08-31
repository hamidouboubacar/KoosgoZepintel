<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntreprisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entreprises', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('forme_juridique')->nullable();
            $table->string('activite')->nullable();
            $table->string('adresse')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('web')->nullable();
            $table->string('banque')->nullable();
            $table->string('compte')->nullable();
            $table->string('rccm')->nullable();
            $table->string('ifu')->nullable();
            $table->string('logo')->nullable();
            $table->string('pieddepage')->nullable();
            $table->string('entete')->nullable();
            $table->string('signature')->nullable();
            $table->string("fax");
            $table->string("rib");
            $table->string('bic')->nullable();
            $table->string('ville')->nullable();
            $table->string('pays')->nullable();
            $table->string("tva");
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
        Schema::dropIfExists('entreprises');
    }
}
