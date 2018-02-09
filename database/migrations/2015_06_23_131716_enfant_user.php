<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EnfantUser extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('enfant_user', function(Blueprint $table){
			$table->increments('id');
			$table->integer('enfant_id')->unsigned()->index();
			$table->integer('user_id')->unsigned()->index();
			$table->foreign('enfant_id')->references('id')->on('enfants')->onDelete('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
