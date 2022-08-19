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

			$table->string('PASTO_NOME');
			$table->date('PASTO_DATA_INICIAL')->nullable();
			$table->date('PASTO_DATA_FINAL')->nullable();
			$table->longText('PASTO_DESCRICAO')->nullable();

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
