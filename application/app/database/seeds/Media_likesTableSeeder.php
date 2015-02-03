<?php

class Media_likesTableSeeder extends Seeder {

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
			3 => 
			array (
				'id' => 5,
				'user_id' => 31,
				'media_id' => 81,
				'created_at' => '2013-11-13 02:28:00',
				'updated_at' => '2013-11-13 02:28:00',
			),
			4 => 
			array (
				'id' => 6,
				'user_id' => 1,
				'media_id' => 81,
				'created_at' => '2013-11-14 00:04:53',
				'updated_at' => '2013-11-14 00:04:53',
			),
			5 => 
			array (
				'id' => 7,
				'user_id' => 31,
				'media_id' => 80,
				'created_at' => '2013-11-14 23:11:56',
				'updated_at' => '2013-11-14 23:11:56',
			),
			6 => 
			array (
				'id' => 8,
				'user_id' => 31,
				'media_id' => 68,
				'created_at' => '2013-11-15 01:34:14',
				'updated_at' => '2013-11-15 01:34:14',
			),
			7 => 
			array (
				'id' => 9,
				'user_id' => 31,
				'media_id' => 45,
				'created_at' => '2013-11-15 01:34:24',
				'updated_at' => '2013-11-15 01:34:24',
			),
			8 => 
			array (
				'id' => 10,
				'user_id' => 31,
				'media_id' => 39,
				'created_at' => '2013-11-15 01:34:27',
				'updated_at' => '2013-11-15 01:34:27',
			),
			9 => 
			array (
				'id' => 12,
				'user_id' => 31,
				'media_id' => 82,
				'created_at' => '2013-11-15 01:34:51',
				'updated_at' => '2013-11-15 01:34:51',
			),
			10 => 
			array (
				'id' => 13,
				'user_id' => 31,
				'media_id' => 79,
				'created_at' => '2013-11-15 01:34:52',
				'updated_at' => '2013-11-15 01:34:52',
			),
			11 => 
			array (
				'id' => 14,
				'user_id' => 31,
				'media_id' => 74,
				'created_at' => '2013-11-15 01:34:55',
				'updated_at' => '2013-11-15 01:34:55',
			),
			12 => 
			array (
				'id' => 15,
				'user_id' => 31,
				'media_id' => 70,
				'created_at' => '2013-11-15 01:34:57',
				'updated_at' => '2013-11-15 01:34:57',
			),
			13 => 
			array (
				'id' => 16,
				'user_id' => 31,
				'media_id' => 65,
				'created_at' => '2013-11-15 01:35:01',
				'updated_at' => '2013-11-15 01:35:01',
			),
			14 => 
			array (
				'id' => 17,
				'user_id' => 31,
				'media_id' => 57,
				'created_at' => '2013-11-15 01:35:04',
				'updated_at' => '2013-11-15 01:35:04',
			),
			15 => 
			array (
				'id' => 20,
				'user_id' => 31,
				'media_id' => 52,
				'created_at' => '2013-11-15 01:35:09',
				'updated_at' => '2013-11-15 01:35:09',
			),
			16 => 
			array (
				'id' => 22,
				'user_id' => 31,
				'media_id' => 53,
				'created_at' => '2013-11-15 01:35:10',
				'updated_at' => '2013-11-15 01:35:10',
			),
			17 => 
			array (
				'id' => 23,
				'user_id' => 15,
				'media_id' => 45,
				'created_at' => '2013-11-22 22:54:17',
				'updated_at' => '2013-11-22 22:54:17',
			),
		));
	}

}
