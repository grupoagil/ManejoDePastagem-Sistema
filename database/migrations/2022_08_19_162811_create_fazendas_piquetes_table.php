<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateFazendasPiquetesTable.
 */
class CreateFazendasPiquetesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fazendas_piquetes', function(Blueprint $table) {
            $table->increments('id');
			$table->integer('FAZENDA_ID')->unsigned();
			$table->foreign('FAZENDA_ID')->references('id')->on('fazendas')->onDelete('cascade');
			$table->integer('PIQUETE_INDEX');
			$table->string('PIQUETE_DESCRICAO')->nullable();
			$table->integer('PIQUETE_OCUPADO')->default(false);
			$table->integer('PIQUETE_ULTIMA_DESOCUPACAO')->nullable();
			$table->integer('PIQUETE_ULTIMA_OCUPACAO')->nullable();

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
		Schema::drop('fazendas_piquetes');
	}
}
