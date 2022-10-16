<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePiquetesHistoriesTable.
 */
class CreatePiquetesHistoriesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('piquetes_histories', function(Blueprint $table) {
            $table->increments('id');

			$table->integer('PIQUETE_ID')->unsigned();
			$table->foreign('PIQUETE_ID')->references('id')->on('fazendas_piquetes')->onDelete('cascade');
			$table->integer('PIQUETE_OP'); // 0 - OCUPADO | 1 - DESOCUPADO
			$table->timestamp('PIQUETE_TIME')->nullable();
			$table->integer('USER_ID')->unsigned()->nullable();
			$table->foreign('USER_ID')->references('id')->on('users')->onDelete('cascade');

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
		Schema::drop('piquetes_histories');
	}
}
