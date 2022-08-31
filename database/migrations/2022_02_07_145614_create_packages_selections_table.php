<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesSelectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages_selections', function (Blueprint $table) {
            $table->id();
            $table->string('numero_document')->nullable();
            $table->string('reference_packages')->nullable();
            $table->string('libelle_package')->nullable();
            $table->string('prix_unitaire')->nullable();
            $table->string('total')->nullable();
            $table->foreignId("document_id")->constrained("documents")->nullable();
            $table->foreignId("client_id")->constrained("clients")->nullable();
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
        Schema::dropIfExists('packages_selections');
    }
}
