<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJourneysTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('journeys', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->date("journey_date");
			$table->string("from");
			$table->string("dest1");
			$table->string("dest2")->nullable();
			$table->string("dest3")->nullable();
			$table->string("dest4")->nullable();
			$table->string("dest5")->nullable();
			$table->string("dest6")->nullable();
			$table->string("reason");
			$table->string("type", 1);
			$table->decimal("mileage");
			$table->decimal('distance_matrix')->nullable();
			$table->string("other_description")->nullable();
			$table->decimal("other_amount")->nullable();
			$table->boolean("salary_sacrifice")->nullable();
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
		Schema::drop('journeys');
	}

}
