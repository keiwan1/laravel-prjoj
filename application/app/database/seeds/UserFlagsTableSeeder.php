<?php

class UserFlagsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('user_flags')->delete();
		\DB::table('user_flags')->insert(array (
			0 => 
			array (
				'id' => 12,
				'user_id' => 8,
				'user_flagged_id' => 7,
				'created_at' => '2013-11-01 06:51:28',
				'updated_at' => '2013-11-01 06:51:28',
			),
			1 => 
			array (
				'id' => 13,
				'user_id' => 7,
				'user_flagged_id' => 1,
				'created_at' => '2013-11-01 07:03:34',
				'updated_at' => '2013-11-01 07:03:34',
			),
		));
	}

}
