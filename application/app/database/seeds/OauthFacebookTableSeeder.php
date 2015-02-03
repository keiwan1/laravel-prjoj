<?php

class OauthFacebookTableSeeder extends Seeder {

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
				'id' => 3,
				'user_id' => 31,
				'oauth_userid' => '100003494607095',
				'created_at' => '2013-11-08 02:53:34',
				'updated_at' => '2013-11-08 02:53:34',
			),
		));
	}

}
