<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_packages', function (Blueprint $table) {
            $table->id();
            $table->integer('document_id');
            $table->string('nom_package');
            $table->integer('package_id');
            $table->integer('prix_unitaire');
            $table->integer('quantite')->nullable();
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
        Schema::dropIfExists('document_packages');
    }
}
