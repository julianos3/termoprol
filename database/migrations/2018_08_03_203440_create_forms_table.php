<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateFormsTable.
 */
class CreateFormsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('forms', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('subject')->nullable();
            $table->string('from')->nullable();
            $table->string('reply_to')->nullable();
            $table->text('description')->nullable();
            $table->integer('order')->nullable();
            $table->timestamps();
            $table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('forms');
	}
}
