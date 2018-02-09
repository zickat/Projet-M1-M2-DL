<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('facturations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->date('semaine');
			$table->integer('fixe');
			$table->integer('non_fixe');
			$table->integer('abscence_signalee');
			$table->integer('enfant_id')->unsigned()->index();
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
		Schema::drop('facturations');
	}

}
