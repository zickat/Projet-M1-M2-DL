<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Enfant;
use App\Reguliere;

class CreateRegulieresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('regulieres', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('type');
			$table->string('jours');
			$table->integer('enfant_id')->unsigned()->index();
			$table->integer('modificate_by');
			$table->timestamps();
		});

		/*$repas = new Enfant;
		$repas->nom = 'repas';
		$repas->prenom = 'temoin primaire';*/


	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('regulieres');
	}

}
