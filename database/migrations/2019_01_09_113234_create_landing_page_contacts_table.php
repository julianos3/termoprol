<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateLandingPageContactsTable.
 */
class CreateLandingPageContactsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('landing_page_contacts', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('landing_page_id')->unsigned();
            $table->foreign('landing_page_id')->references('id')->on('landing_pages');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->text('message')->nullable();
            $table->enum('view', ['y', 'n'])->nullable('n');
            $table->string('session_id');
            $table->string('ip');
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
		Schema::drop('landing_page_contacts');
	}
}
