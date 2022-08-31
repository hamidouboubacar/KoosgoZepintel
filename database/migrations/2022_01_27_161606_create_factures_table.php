<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('reference');
            $table->string('numero')->nullable();
            $table->string('date')->nullable();
            $table->string('tva')->nullable();
            $table->foreignId("user_id")->constrained("users")->nullable();
            $table->foreignId("client_id")->constrained("clients")->nullable();
            $table->string('periode')->nullable();
            $table->string('total_remise')->nullable();
            $table->integer('montantttc')->nullable();
            $table->integer('montantht')->nullable();
            $table->string('modalite')->nullable();
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
        Schema::dropIfExists('factures');
    }
}
