<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('persona', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('nombre_persona');
            $table->string('dni')->unique();
            $table->string('email', 60);
            $table->string('usuCrea', 60);
            $table->string('usuModi', 60)->nullable();
            $table->integer('estado');
            $table->rememberToken();
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
        Schema::drop('persona');
	}

}
