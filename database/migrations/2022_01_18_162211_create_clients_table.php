<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code_client');
            $table->string('telephone')->nullable();
            $table->string('adresse', 255)->nullable();
            $table->string('type')->nullable();
            $table->foreignId("user_id")->nullable()->constrained("users");
            $table->integer("user_client_id")->nullable();
            // $table->unsignedBigInteger("user_client_id")->nullable();
            // $table->foreign("user_client_id")->references('id')->on("users");
            $table->string('ifu')->nullable();
            $table->string('rccm')->nullable();
            $table->string('pays')->nullable();
            $table->string('ville')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable()->default(1);
            $table->string('email')->nullable();
            $table->string('numero_paiement')->nullable();
            $table->string('etat')->default();
            $table->string('recurrence')->nullable();
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
        Schema::dropIfExists('clients');
    }
}
