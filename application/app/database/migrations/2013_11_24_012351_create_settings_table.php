<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('settings', function(Blueprint $table) {
			$table->increments('id');
			$table->string('website_name');
			$table->string('website_description');
			$table->string('logo');
			$table->string('favicon');
			$table->string('theme');
			$table->string('fb_key');
			$table->string('fb_secret_key');
			$table->string('facebook_page_id');
			$table->string('google_key');
			$table->string('google_secret_key');
			$table->string('google_page_id');
			$table->string('twitter_page_id');
			$table->integer('post_title_length');
			$table->boolean('auto_approve_posts');
			$table->text('custom_css');
			$table->string('like_icon', 20);
			$table->string('secondary_color', 20);
			$table->string('primary_color', 10);
			$table->text('square_ad');
			$table->string('color_scheme', 20)->default('light');
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
		Schema::drop('settings');
	}

}
