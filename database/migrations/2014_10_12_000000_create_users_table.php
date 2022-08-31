<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('telephone')->nullable();
            $table->string('whoIs')->nullable();
            $table->string('etat')->default(1);
            $table->string('signataire')->default(0);
            $table->string('email')->unique();
            $table->foreignId("fonction_id")->constrained("fonctions")->nullable();
            $table->integer('client_id')->nullable();
            // $table->unsignedBigInteger('client_id')->nullable();
            // $table->foreignId("client_id")->constrained("clients")->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
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
        Schema::dropIfExists('users');
    }
}
