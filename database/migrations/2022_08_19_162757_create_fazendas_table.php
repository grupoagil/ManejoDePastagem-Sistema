<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateFazendasTable.
 */
class CreateFazendasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fazendas', function(Blueprint $table) {
            $table->increments('id');

			$table->string('FAZENDA_NOME');
			$table->integer('PASTO_ID')->unsigned();
			$table->foreign('PASTO_ID')->references('id')->on('pastos')->onDelete('cascade');

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
		Schema::drop('fazendas');
	}
}
