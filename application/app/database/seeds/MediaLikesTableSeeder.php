<?php

class MediaLikesTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('media_likes')->delete();
		\DB::table('media_likes')->insert(array (
			0 => 
			array (
				'id' => 2,
				'user_id' => 7,
				'media_id' => 32,
				'created_at' => '2013-11-01 17:47:57',
				'updated_at' => '2013-11-01 17:47:57',
			),
			1 => 
			array (
				'id' => 3,
				'user_id' => 7,
				'media_id' => 36,
				'created_at' => '2013-11-01 18:09:48',
				'updated_at' => '2013-11-01 18:09:48',
			),
			2 => 
			array (
				'id' => 4,
				'user_id' => 7,
				'media_id' => 37,
				'created_at' => '2013-11-01 20:09:18',
				'updated_at' => '2013-11-01 20:09:18',
			),
		));
	}

}
