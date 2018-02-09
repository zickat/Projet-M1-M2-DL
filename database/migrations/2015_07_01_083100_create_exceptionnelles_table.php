<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExceptionnellesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('exceptionnelles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('type');
			$table->date('jour');
			$table->integer('inscrit');
			$table->integer('enfant_id')->unsigned()->index();
			$table->integer('modificate_by');
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
		Schema::drop('exceptionnelles');
	}

}
