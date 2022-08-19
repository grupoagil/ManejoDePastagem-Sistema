<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePastosPeriodosTable.
 */
class CreatePastosPeriodosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pastos_periodos', function(Blueprint $table) {
            $table->increments('id');
			// Pasto
			$table->integer('PASTO_ID')->unsigned();
			$table->foreign('PASTO_ID')->references('id')->on('pastos')->onDelete('cascade');
			// Nome Pasto
			$table->string('PASTO_PERIODO_NOME');

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
		Schema::drop('pastos_periodos');
	}
}
