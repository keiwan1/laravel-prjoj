<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// $this->call('UserTableSeeder');
		//$this->call('UsersTableSeeder');
		$this->call('MediaTableSeeder');
		$this->call('CategoriesTableSeeder');
		$this->call('SettingsTableSeeder');
		
		//$this->call('CommentsTableSeeder');
		//$this->call('PointsTableSeeder');
		//$this->call('CommentFlagsTableSeeder');
		//$this->call('CommentVotesTableSeeder');
		//$this->call('MediaFlagsTableSeeder');
		//$this->call('UserFlagsTableSeeder');
		//$this->call('MediaLikesTableSeeder');
		//$this->call('OauthFacebookTableSeeder');
		//$this->call('OauthGoogleTableSeeder');
	}

}