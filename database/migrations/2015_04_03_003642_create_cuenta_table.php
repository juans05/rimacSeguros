<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuentaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('cuenta', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('aplicativo_id')->unsigned();
            $table->foreign('aplicativo_id')->references('id')->on('aplicativo');
            $table->integer('persona_ticket_id')->unsigned();
            $table->foreign('persona_ticket_id')->references('id')->on('persona_tickets');
            $table->string('cuenta_usu')->nullable();;
            $table->string('clave')->nullable();;
            $table->string('usucrea');
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
        Schema::drop('cuenta');
	}

}
