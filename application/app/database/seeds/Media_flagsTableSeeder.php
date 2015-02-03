<?php

class Media_flagsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('media_flags')->delete();
        
		\DB::table('media_flags')->insert(array (
			0 => 
			array (
				'id' => 16,
				'user_id' => 7,
				'media_id' => 34,
				'created_at' => '2013-11-01 06:27:21',
				'updated_at' => '2013-11-01 06:27:21',
			),
			1 => 
			array (
				'id' => 17,
				'user_id' => 1,
				'media_id' => 34,
				'created_at' => '2013-11-01 06:29:01',
				'updated_at' => '2013-11-01 06:29:01',
			),
			2 => 
			array (
				'id' => 26,
				'user_id' => 1,
				'media_id' => 32,
				'created_at' => '2013-11-01 06:59:43',
				'updated_at' => '2013-11-01 06:59:43',
			),
			3 => 
			array (
				'id' => 27,
				'user_id' => 7,
				'media_id' => 33,
				'created_at' => '2013-11-01 07:03:19',
				'updated_at' => '2013-11-01 07:03:19',
			),
		));
	}

}
