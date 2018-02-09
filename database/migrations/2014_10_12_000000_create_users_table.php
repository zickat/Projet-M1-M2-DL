<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\User;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nom');
			$table->string('prenom');
			$table->string('identifiant')->unique();
			$table->string('email')->unique();
			$table->string('password', 60);
			$table->integer('niveau')->default(0);
			$table->string('adresse');
			$table->integer('cp');
			$table->string('ville');
			$table->rememberToken();
			$table->timestamps();
		});
		$user = new User;
		$user->nom = 'admin';
		$user->prenom = 'admin';
		$user->identifiant = 'admin';
		$user->email = 'admin@admin.fr';
		$user->password = bcrypt('admin');
		$user->niveau = 2;
		$user->save();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
