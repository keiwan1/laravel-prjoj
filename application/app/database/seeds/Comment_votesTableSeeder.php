<?php

class Comment_votesTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('comment_votes')->delete();
        
		\DB::table('comment_votes')->insert(array (
			0 => 
			array (
				'id' => 2,
				'user_id' => 6,
				'comment_id' => 1,
				'up' => 1,
				'down' => 0,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			1 => 
			array (
				'id' => 4,
				'user_id' => 1,
				'comment_id' => 1,
				'up' => 1,
				'down' => 0,
				'created_at' => '2013-10-31 18:16:39',
				'updated_at' => '2013-10-31 19:51:53',
			),
			2 => 
			array (
				'id' => 5,
				'user_id' => 7,
				'comment_id' => 1,
				'up' => 1,
				'down' => 0,
				'created_at' => '2013-10-31 18:29:15',
				'updated_at' => '2013-10-31 18:29:25',
			),
			3 => 
			array (
				'id' => 6,
				'user_id' => 8,
				'comment_id' => 2,
				'up' => 1,
				'down' => 0,
				'created_at' => '2013-10-31 21:39:25',
				'updated_at' => '2013-11-01 07:04:53',
			),
			4 => 
			array (
				'id' => 7,
				'user_id' => 1,
				'comment_id' => 2,
				'up' => 1,
				'down' => 0,
				'created_at' => '2013-10-31 21:53:13',
				'updated_at' => '2013-11-01 06:59:57',
			),
			5 => 
			array (
				'id' => 8,
				'user_id' => 1,
				'comment_id' => 3,
				'up' => 1,
				'down' => 0,
				'created_at' => '2013-11-01 05:59:12',
				'updated_at' => '2013-11-01 05:59:12',
			),
			6 => 
			array (
				'id' => 9,
				'user_id' => 8,
				'comment_id' => 1,
				'up' => 1,
				'down' => 0,
				'created_at' => '2013-11-01 06:51:47',
				'updated_at' => '2013-11-01 06:51:47',
			),
		));
	}

}
