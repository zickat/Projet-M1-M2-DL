<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Classe;

class CreateClassesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('classes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('niveau');
			$table->string('instituteur');
			$table->string('cycle');
			$table->timestamps();
		});

		$classe = new Classe;
		$classe->niveau = 'instituteur';
		$classe->instituteur = '';
		$classe->cycle = 'adulte';
		$classe->save();
		$classe = new Classe;
		$classe->niveau = 'personnel';
		$classe->instituteur = '';
		$classe->cycle = 'adulte';
		$classe->save();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('classes');
	}

}
