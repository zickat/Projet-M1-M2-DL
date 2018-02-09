<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnfantsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('enfants', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nom');
			$table->string('prenom');
			$table->string('sexe');
			$table->string('niveau_classe');
			$table->integer('classe_id')->unsigned()->index();
			$table->date('naissance');
			$table->boolean('garderie')->default(true);
			$table->boolean('prendre_bus')->default(false);
			$table->string('responsable_bus');
			$table->integer('arret_id')->unsigned()->index();
			$table->boolean('rentre_seul')->default(false);
			$table->boolean('mange_cantine')->default(true);
			$table->boolean('exception_porc')->default(false);
			$table->boolean('exception_viande')->default(false);
			$table->string('exception_autre');
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
		Schema::drop('enfants');
	}

}
