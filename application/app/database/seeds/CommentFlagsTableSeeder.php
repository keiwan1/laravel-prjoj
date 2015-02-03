<?php

class CommentFlagsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('comment_flags')->delete();
		\DB::table('comment_flags')->insert(array (
			0 => 
			array (
				'id' => 8,
				'user_id' => 1,
				'comment_id' => 3,
				'created_at' => '2013-11-01 06:29:03',
				'updated_at' => '2013-11-01 06:29:03',
			),
			1 => 
			array (
				'id' => 17,
				'user_id' => 1,
				'comment_id' => 2,
				'created_at' => '2013-11-01 06:59:48',
				'updated_at' => '2013-11-01 06:59:48',
			),
			2 => 
			array (
				'id' => 18,
				'user_id' => 7,
				'comment_id' => 1,
				'created_at' => '2013-11-01 07:03:14',
				'updated_at' => '2013-11-01 07:03:14',
			),
			3 => 
			array (
				'id' => 19,
				'user_id' => 8,
				'comment_id' => 1,
				'created_at' => '2013-11-01 07:04:04',
				'updated_at' => '2013-11-01 07:04:04',
			),
		));
	}

}
