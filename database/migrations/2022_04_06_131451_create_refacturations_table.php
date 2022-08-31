<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefacturationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refacturations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('document_refacturation', function (Blueprint $table) {
            $table->id();
            $table->foreignId("document_id")->constrained("documents")->nullable();
            $table->foreignId("refacturation_id")->constrained("refacturations")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('refacturations');
    }
}
