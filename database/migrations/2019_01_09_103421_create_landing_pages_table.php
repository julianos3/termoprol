<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateLandingPagesTable.
 */
class CreateLandingPagesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('landing_pages', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('banner')->nullable();
            $table->text('description');
            $table->string('avatar_1_6')->nullable();
            $table->string('avatar_1_1')->nullable();
            $table->string('video')->nullable();
            $table->string('email',450)->nullable();
            $table->enum('active', ['n', 'y'])->default('n');
            $table->string('seo_keywords')->nullable();
            $table->string('seo_description')->nullable();
            $table->string('seo_link');
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
		Schema::drop('landing_pages');
	}
}
