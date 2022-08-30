<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePastosTable.
 */
class CreatePastosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pastos', function(Blueprint $table) {
            $table->increments('id');
			// Nome Pasto
			$table->string('PASTO_NOME');
			$table->string('PASTO_TIPO');

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
		Schema::drop('pastos');
	}
}
