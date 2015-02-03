<?php

class Oauth_googleTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('oauth_google')->delete();
        
		\DB::table('oauth_google')->insert(array (
			0 => 
			array (
				'id' => 2,
				'user_id' => 32,
				'oauth_userid' => '114575530990254392103',
				'created_at' => '2013-11-08 02:54:20',
				'updated_at' => '2013-11-08 02:54:20',
			),
		));
	}

}
