<?php

class Oauth_facebookTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('oauth_facebook')->delete();
        
		\DB::table('oauth_facebook')->insert(array (
			0 => 
			array (
				'id' => '3',
				'user_id' => '31',
				'oauth_userid' => '100003494607095',
				'created_at' => '2013-11-08 02:53:34',
				'updated_at' => '2013-11-08 02:53:34',
			),
			1 => 
			array (
				'id' => '5',
				'user_id' => '35',
				'oauth_userid' => '9311862',
				'created_at' => '2013-11-25 19:39:52',
				'updated_at' => '2013-11-25 19:39:52',
			),
		));
	}

}
