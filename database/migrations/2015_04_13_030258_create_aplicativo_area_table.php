<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAplicativoAreaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('aplicativo_area', function(Blueprint $table)
        {
            $table->integer('area_id')->unsigned();
            $table->foreign('area_id')->references('id')->on('area');
            $table->integer('aplicativo_id')->unsigned();
            $table->foreign('aplicativo_id')->references('id')->on('aplicativo');
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
        Schema::drop('aplicativo_area');
	}

}
