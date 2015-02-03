<?php

class PointsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('points')->delete();
        
		\DB::table('points')->insert(array (
			0 => 
			array (
				'id' => 1,
				'user_id' => 1,
				'points' => 200,
				'description' => 'Registration',
				'created_at' => '2013-10-11 15:14:47',
				'updated_at' => '2013-10-11 15:14:47',
			),
			1 => 
			array (
				'id' => 5,
				'user_id' => 6,
				'points' => 200,
				'description' => 'Registration',
				'created_at' => '2013-10-23 02:47:29',
				'updated_at' => '2013-10-23 02:47:29',
			),
			2 => 
			array (
				'id' => 6,
				'user_id' => 7,
				'points' => 200,
				'description' => 'Registration',
				'created_at' => '2013-10-24 16:05:28',
				'updated_at' => '2013-10-24 16:05:28',
			),
			3 => 
			array (
				'id' => 7,
				'user_id' => 8,
				'points' => 200,
				'description' => 'Registration',
				'created_at' => '2013-10-24 16:05:28',
				'updated_at' => '2013-10-24 16:05:28',
			),
			4 => 
			array (
				'id' => 8,
				'user_id' => 9,
				'points' => 200,
				'description' => 'Registration',
				'created_at' => '2013-11-04 01:51:59',
				'updated_at' => '2013-11-04 01:51:59',
			),
			5 => 
			array (
				'id' => 10,
				'user_id' => 1,
				'points' => 5,
				'description' => 'Daily Login',
				'created_at' => '2013-11-06 01:54:30',
				'updated_at' => '2013-11-06 01:54:30',
			),
			6 => 
			array (
				'id' => 11,
				'user_id' => 1,
				'points' => 1,
				'description' => 'Daily Answer',
				'created_at' => '2013-11-06 02:20:47',
				'updated_at' => '2013-11-06 02:20:47',
			),
			7 => 
			array (
				'id' => 12,
				'user_id' => 1,
				'points' => 1,
				'description' => 'Daily Answer',
				'created_at' => '2013-11-06 02:22:54',
				'updated_at' => '2013-11-06 02:22:54',
			),
			8 => 
			array (
				'id' => 13,
				'user_id' => 1,
				'points' => 1,
				'description' => 'Daily Answer',
				'created_at' => '2013-11-06 02:53:30',
				'updated_at' => '2013-11-06 02:53:30',
			),
			9 => 
			array (
				'id' => 14,
				'user_id' => 1,
				'points' => 1,
				'description' => 'Daily Answer',
				'created_at' => '2013-11-06 02:54:04',
				'updated_at' => '2013-11-06 02:54:04',
			),
			10 => 
			array (
				'id' => 15,
				'user_id' => 1,
				'points' => 1,
				'description' => 'Daily Answer',
				'created_at' => '2013-11-06 02:54:28',
				'updated_at' => '2013-11-06 02:54:28',
			),
			11 => 
			array (
				'id' => 16,
				'user_id' => 1,
				'points' => 1,
				'description' => 'Daily Question',
				'created_at' => '2013-11-06 03:03:50',
				'updated_at' => '2013-11-06 03:03:50',
			),
			12 => 
			array (
				'id' => 17,
				'user_id' => 10,
				'points' => 200,
				'description' => 'Registration',
				'created_at' => '2013-11-06 03:06:47',
				'updated_at' => '2013-11-06 03:06:47',
			),
			13 => 
			array (
				'id' => 18,
				'user_id' => 10,
				'points' => 1,
				'description' => 'Daily Question',
				'created_at' => '2013-11-06 03:09:02',
				'updated_at' => '2013-11-06 03:09:02',
			),
			14 => 
			array (
				'id' => 19,
				'user_id' => 10,
				'points' => 1,
				'description' => 'Daily Question',
				'created_at' => '2013-11-06 03:10:39',
				'updated_at' => '2013-11-06 03:10:39',
			),
			15 => 
			array (
				'id' => 20,
				'user_id' => 10,
				'points' => 1,
				'description' => 'Daily Question',
				'created_at' => '2013-11-06 03:12:12',
				'updated_at' => '2013-11-06 03:12:12',
			),
			16 => 
			array (
				'id' => 21,
				'user_id' => 10,
				'points' => 1,
				'description' => 'Daily Question',
				'created_at' => '2013-11-06 03:12:55',
				'updated_at' => '2013-11-06 03:12:55',
			),
			17 => 
			array (
				'id' => 22,
				'user_id' => 10,
				'points' => 1,
				'description' => 'Daily Question',
				'created_at' => '2013-11-06 03:14:20',
				'updated_at' => '2013-11-06 03:14:20',
			),
			18 => 
			array (
				'id' => 23,
				'user_id' => 15,
				'points' => 200,
				'description' => 'Registration',
				'created_at' => '2013-11-07 00:12:21',
				'updated_at' => '2013-11-07 00:12:21',
			),
			19 => 
			array (
				'id' => 24,
				'user_id' => 15,
				'points' => 5,
				'description' => 'Daily Login',
				'created_at' => '2013-11-07 00:18:45',
				'updated_at' => '2013-11-07 00:18:45',
			),
			20 => 
			array (
				'id' => 27,
				'user_id' => 22,
				'points' => 200,
				'description' => 'Registration',
				'created_at' => '2013-11-07 01:30:32',
				'updated_at' => '2013-11-07 01:30:32',
			),
			21 => 
			array (
				'id' => 36,
				'user_id' => 27,
				'points' => 200,
				'description' => 'Registration',
				'created_at' => '2013-11-07 15:50:35',
				'updated_at' => '2013-11-07 15:50:35',
			),
			22 => 
			array (
				'id' => 37,
				'user_id' => 26,
				'points' => 1,
				'description' => 'Daily Answer',
				'created_at' => '2013-11-07 15:52:09',
				'updated_at' => '2013-11-07 15:52:09',
			),
			23 => 
			array (
				'id' => 38,
				'user_id' => 10,
				'points' => 5,
				'description' => 'Daily Login',
				'created_at' => '2013-11-07 21:55:12',
				'updated_at' => '2013-11-07 21:55:12',
			),
			24 => 
			array (
				'id' => 39,
				'user_id' => 10,
				'points' => 1,
				'description' => 'Daily Question',
				'created_at' => '2013-11-07 21:57:18',
				'updated_at' => '2013-11-07 21:57:18',
			),
			25 => 
			array (
				'id' => 40,
				'user_id' => 10,
				'points' => 1,
				'description' => 'Daily Question',
				'created_at' => '2013-11-07 21:57:47',
				'updated_at' => '2013-11-07 21:57:47',
			),
			26 => 
			array (
				'id' => 41,
				'user_id' => 15,
				'points' => 1,
				'description' => 'Daily Question',
				'created_at' => '2013-11-07 22:22:41',
				'updated_at' => '2013-11-07 22:22:41',
			),
			27 => 
			array (
				'id' => 43,
				'user_id' => 15,
				'points' => 1,
				'description' => 'Daily Question',
				'created_at' => '2013-11-07 22:25:19',
				'updated_at' => '2013-11-07 22:25:19',
			),
			28 => 
			array (
				'id' => 44,
				'user_id' => 15,
				'points' => 1,
				'description' => 'Daily Question',
				'created_at' => '2013-11-07 22:26:59',
				'updated_at' => '2013-11-07 22:26:59',
			),
			29 => 
			array (
				'id' => 45,
				'user_id' => 15,
				'points' => 1,
				'description' => 'Daily Question',
				'created_at' => '2013-11-07 22:28:01',
				'updated_at' => '2013-11-07 22:28:01',
			),
			30 => 
			array (
				'id' => 46,
				'user_id' => 15,
				'points' => 1,
				'description' => 'Daily Question',
				'created_at' => '2013-11-07 22:28:58',
				'updated_at' => '2013-11-07 22:28:58',
			),
			31 => 
			array (
				'id' => 47,
				'user_id' => 15,
				'points' => 1,
				'description' => 'Daily Question',
				'created_at' => '2013-11-08 00:46:10',
				'updated_at' => '2013-11-08 00:46:10',
			),
			32 => 
			array (
				'id' => 48,
				'user_id' => 15,
				'points' => 1,
				'description' => 'Daily Question',
				'created_at' => '2013-11-08 00:47:16',
				'updated_at' => '2013-11-08 00:47:16',
			),
			33 => 
			array (
				'id' => 49,
				'user_id' => 15,
				'points' => 1,
				'description' => 'Daily Question',
				'created_at' => '2013-11-08 00:48:43',
				'updated_at' => '2013-11-08 00:48:43',
			),
			34 => 
			array (
				'id' => 50,
				'user_id' => 15,
				'points' => 1,
				'description' => 'Daily Question',
				'created_at' => '2013-11-08 00:50:42',
				'updated_at' => '2013-11-08 00:50:42',
			),
			35 => 
			array (
				'id' => 51,
				'user_id' => 15,
				'points' => 1,
				'description' => 'Daily Question',
				'created_at' => '2013-11-08 01:22:43',
				'updated_at' => '2013-11-08 01:22:43',
			),
			36 => 
			array (
				'id' => 52,
				'user_id' => 15,
				'points' => 1,
				'description' => 'Daily Answer',
				'created_at' => '2013-11-08 02:00:53',
				'updated_at' => '2013-11-08 02:00:53',
			),
			37 => 
			array (
				'id' => 53,
				'user_id' => 15,
				'points' => 1,
				'description' => 'Daily Answer',
				'created_at' => '2013-11-08 02:01:33',
				'updated_at' => '2013-11-08 02:01:33',
			),
			38 => 
			array (
				'id' => 58,
				'user_id' => 15,
				'points' => 5,
				'description' => 'Daily Login',
				'created_at' => '2013-11-08 02:26:40',
				'updated_at' => '2013-11-08 02:26:40',
			),
			39 => 
			array (
				'id' => 61,
				'user_id' => 31,
				'points' => 200,
				'description' => 'Registration',
				'created_at' => '2013-11-08 02:53:34',
				'updated_at' => '2013-11-08 02:53:34',
			),
			40 => 
			array (
				'id' => 62,
				'user_id' => 31,
				'points' => 5,
				'description' => 'Daily Login',
				'created_at' => '2013-11-08 02:53:34',
				'updated_at' => '2013-11-08 02:53:34',
			),
			41 => 
			array (
				'id' => 63,
				'user_id' => 32,
				'points' => 200,
				'description' => 'Registration',
				'created_at' => '2013-11-08 02:54:20',
				'updated_at' => '2013-11-08 02:54:20',
			),
			42 => 
			array (
				'id' => 64,
				'user_id' => 32,
				'points' => 5,
				'description' => 'Daily Login',
				'created_at' => '2013-11-08 02:54:20',
				'updated_at' => '2013-11-08 02:54:20',
			),
			43 => 
			array (
				'id' => 65,
				'user_id' => 8,
				'points' => 5,
				'description' => 'Daily Login',
				'created_at' => '2013-11-08 02:55:19',
				'updated_at' => '2013-11-08 02:55:19',
			),
			44 => 
			array (
				'id' => 66,
				'user_id' => 31,
				'points' => 5,
				'description' => 'Daily Login',
				'created_at' => '2013-11-12 16:55:49',
				'updated_at' => '2013-11-12 16:55:49',
			),
			45 => 
			array (
				'id' => 67,
				'user_id' => 31,
				'points' => 1,
				'description' => 'Daily Answer',
				'created_at' => '2013-11-13 01:58:59',
				'updated_at' => '2013-11-13 01:58:59',
			),
			46 => 
			array (
				'id' => 68,
				'user_id' => 31,
				'points' => 1,
				'description' => 'Daily Answer',
				'created_at' => '2013-11-13 02:06:32',
				'updated_at' => '2013-11-13 02:06:32',
			),
			47 => 
			array (
				'id' => 69,
				'user_id' => 31,
				'points' => 1,
				'description' => 'Daily Answer',
				'created_at' => '2013-11-13 02:28:41',
				'updated_at' => '2013-11-13 02:28:41',
			),
			48 => 
			array (
				'id' => 70,
				'user_id' => 31,
				'points' => 5,
				'description' => 'Daily Login',
				'created_at' => '2013-11-13 15:39:20',
				'updated_at' => '2013-11-13 15:39:20',
			),
			49 => 
			array (
				'id' => 71,
				'user_id' => 31,
				'points' => 1,
				'description' => 'Daily Answer',
				'created_at' => '2013-11-13 15:41:07',
				'updated_at' => '2013-11-13 15:41:07',
			),
			50 => 
			array (
				'id' => 72,
				'user_id' => 31,
				'points' => 1,
				'description' => 'Daily Answer',
				'created_at' => '2013-11-13 16:48:08',
				'updated_at' => '2013-11-13 16:48:08',
			),
			51 => 
			array (
				'id' => 73,
				'user_id' => 1,
				'points' => 5,
				'description' => 'Daily Login',
				'created_at' => '2013-11-14 00:04:48',
				'updated_at' => '2013-11-14 00:04:48',
			),
			52 => 
			array (
				'id' => 74,
				'user_id' => 31,
				'points' => 5,
				'description' => 'Daily Login',
				'created_at' => '2013-11-14 00:05:49',
				'updated_at' => '2013-11-14 00:05:49',
			),
			53 => 
			array (
				'id' => 75,
				'user_id' => 1,
				'points' => 1,
				'description' => 'Daily Answer',
				'created_at' => '2013-11-14 00:29:37',
				'updated_at' => '2013-11-14 00:29:37',
			),
			54 => 
			array (
				'id' => 76,
				'user_id' => 15,
				'points' => 5,
				'description' => 'Daily Login',
				'created_at' => '2013-11-14 00:38:51',
				'updated_at' => '2013-11-14 00:38:51',
			),
			55 => 
			array (
				'id' => 77,
				'user_id' => 33,
				'points' => 200,
				'description' => 'Registration',
				'created_at' => '2013-11-14 00:41:01',
				'updated_at' => '2013-11-14 00:41:01',
			),
			56 => 
			array (
				'id' => 78,
				'user_id' => 33,
				'points' => 1,
				'description' => 'Daily Answer',
				'created_at' => '2013-11-14 00:41:29',
				'updated_at' => '2013-11-14 00:41:29',
			),
			57 => 
			array (
				'id' => 79,
				'user_id' => 31,
				'points' => 1,
				'description' => 'Daily Answer',
				'created_at' => '2013-11-14 23:13:10',
				'updated_at' => '2013-11-14 23:13:10',
			),
			58 => 
			array (
				'id' => 80,
				'user_id' => 31,
				'points' => 5,
				'description' => 'Daily Login',
				'created_at' => '2013-11-22 22:03:41',
				'updated_at' => '2013-11-22 22:03:41',
			),
			59 => 
			array (
				'id' => 81,
				'user_id' => 15,
				'points' => 5,
				'description' => 'Daily Login',
				'created_at' => '2013-11-22 22:53:48',
				'updated_at' => '2013-11-22 22:53:48',
			),
			60 => 
			array (
				'id' => 82,
				'user_id' => 31,
				'points' => 5,
				'description' => 'Daily Login',
				'created_at' => '2013-11-23 03:03:06',
				'updated_at' => '2013-11-23 03:03:06',
			),
			61 => 
			array (
				'id' => 83,
				'user_id' => 15,
				'points' => 5,
				'description' => 'Daily Login',
				'created_at' => '2013-11-23 04:35:19',
				'updated_at' => '2013-11-23 04:35:19',
			),
		));
	}

}
