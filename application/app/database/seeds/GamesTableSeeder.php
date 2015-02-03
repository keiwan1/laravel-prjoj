<?php

class GamesTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('games')->delete();
        
		\DB::table('games')->insert(array (
			0 => 
			array (
				'id' => 2,
				'user_id' => 31,
				'name' => 'Memory Match - Easy Mode',
				'identifier' => 'memory-match-easy',
				'points' => 65,
				'created_at' => '2013-11-23 03:44:26',
				'updated_at' => '2013-11-23 03:44:26',
			),
			1 => 
			array (
				'id' => 4,
				'user_id' => 31,
				'name' => 'Memory Match - Hard Mode',
				'identifier' => 'memory-match-hard',
				'points' => 161,
				'created_at' => '2013-11-23 03:52:01',
				'updated_at' => '2013-11-23 03:52:01',
			),
		));
	}

}
