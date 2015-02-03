<?php

class CommentsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('comments')->delete();
        
		\DB::table('comments')->insert(array (
			0 => 
			array (
				'id' => 1,
				'user_id' => 1,
				'media_id' => 33,
				'comment' => 'I love the \'Hide Your Kids, Hide Your Wife Remix\'',
				'pic_url' => NULL,
				'vid_url' => NULL,
				'created_at' => '2013-10-31 16:39:34',
				'updated_at' => '2013-10-31 16:39:34',
			),
			1 => 
			array (
				'id' => 2,
				'user_id' => 8,
				'media_id' => 32,
				'comment' => 'My favorite is Toy Story :)',
				'pic_url' => NULL,
				'vid_url' => NULL,
				'created_at' => '2013-10-31 21:39:11',
				'updated_at' => '2013-10-31 21:39:11',
			),
			2 => 
			array (
				'id' => 3,
				'user_id' => 1,
				'media_id' => 34,
				'comment' => 'This one... The Rebecca Black Video :)',
				'pic_url' => NULL,
				'vid_url' => NULL,
				'created_at' => '2013-11-01 05:59:03',
				'updated_at' => '2013-11-01 05:59:03',
			),
			3 => 
			array (
				'id' => 5,
				'user_id' => 9,
				'media_id' => 38,
				'comment' => 'Animal Jam. It\'s at http://www.animaljam.com',
				'pic_url' => NULL,
				'vid_url' => NULL,
				'created_at' => '2013-11-04 01:57:07',
				'updated_at' => '2013-11-04 01:57:07',
			),
			4 => 
			array (
				'id' => 7,
				'user_id' => 1,
				'media_id' => 27,
				'comment' => 'I\'m not too sure. It looks like a cool copter though :)',
				'pic_url' => NULL,
				'vid_url' => NULL,
				'created_at' => '2013-11-04 02:10:50',
				'updated_at' => '2013-11-04 02:10:50',
			),
			5 => 
			array (
				'id' => 8,
				'user_id' => 1,
				'media_id' => 43,
				'comment' => 'That looks like the next iPhone',
				'pic_url' => NULL,
				'vid_url' => NULL,
				'created_at' => '2013-11-04 02:38:43',
				'updated_at' => '2013-11-04 02:38:43',
			),
			6 => 
			array (
				'id' => 9,
				'user_id' => 1,
				'media_id' => 41,
				'comment' => 'My Favorite Part is when the Bear Waves back at the people :)',
				'pic_url' => NULL,
				'vid_url' => NULL,
				'created_at' => '2013-11-06 02:20:47',
				'updated_at' => '2013-11-06 02:20:47',
			),
			7 => 
			array (
				'id' => 10,
				'user_id' => 1,
				'media_id' => 33,
				'comment' => 'Also the back\'n up Back\'n up remix is pretty funny :)',
				'pic_url' => NULL,
				'vid_url' => NULL,
				'created_at' => '2013-11-06 02:22:54',
				'updated_at' => '2013-11-06 02:22:54',
			),
			8 => 
			array (
				'id' => 11,
				'user_id' => 1,
				'media_id' => 28,
				'comment' => 'Hmmm... Not too sure...',
				'pic_url' => NULL,
				'vid_url' => NULL,
				'created_at' => '2013-11-06 02:53:30',
				'updated_at' => '2013-11-06 02:53:30',
			),
			9 => 
			array (
				'id' => 12,
				'user_id' => 1,
				'media_id' => 36,
				'comment' => 'Not sure... Cool Pic though :)',
				'pic_url' => NULL,
				'vid_url' => NULL,
				'created_at' => '2013-11-06 02:54:04',
				'updated_at' => '2013-11-06 02:54:04',
			),
			10 => 
			array (
				'id' => 13,
				'user_id' => 1,
				'media_id' => 42,
				'comment' => 'Aren\'t those just regular Monarch Butterflies?',
				'pic_url' => NULL,
				'vid_url' => NULL,
				'created_at' => '2013-11-06 02:54:28',
				'updated_at' => '2013-11-06 02:54:28',
			),
			11 => 
			array (
				'id' => 14,
				'user_id' => 1,
				'media_id' => 32,
				'comment' => 'It\'s gotta be Monsters Inc :)',
				'pic_url' => NULL,
				'vid_url' => NULL,
				'created_at' => '2013-11-06 02:55:00',
				'updated_at' => '2013-11-06 02:55:00',
			),
			12 => 
			array (
				'id' => 16,
				'user_id' => 15,
				'media_id' => 49,
				'comment' => 'Bird eating spider',
				'pic_url' => NULL,
				'vid_url' => NULL,
				'created_at' => '2013-11-08 02:00:53',
				'updated_at' => '2013-11-08 02:01:01',
			),
			13 => 
			array (
				'id' => 17,
				'user_id' => 15,
				'media_id' => 53,
				'comment' => 'Isn\'t that a blue jay?',
				'pic_url' => NULL,
				'vid_url' => NULL,
				'created_at' => '2013-11-08 02:01:33',
				'updated_at' => '2013-11-08 02:01:33',
			),
			14 => 
			array (
				'id' => 35,
				'user_id' => 31,
				'media_id' => 81,
				'comment' => 'My favorite season would definitely have to be summer :)',
				'pic_url' => 'November2013/summer-holiday.jpg',
				'vid_url' => NULL,
				'created_at' => '2013-11-13 23:58:59',
				'updated_at' => '2013-11-13 23:58:59',
			),
			15 => 
			array (
				'id' => 36,
				'user_id' => 1,
				'media_id' => 81,
				'comment' => 'My Favorite is the Fall Season!',
				'pic_url' => 'November2013/fall-season.jpg',
				'vid_url' => NULL,
				'created_at' => '2013-11-14 00:29:37',
				'updated_at' => '2013-11-14 00:29:37',
			),
			16 => 
			array (
				'id' => 37,
				'user_id' => 33,
				'media_id' => 81,
				'comment' => 'My Fave is definitely Spring Time',
				'pic_url' => 'November2013/spring-02.jpg',
				'vid_url' => NULL,
				'created_at' => '2013-11-14 00:41:29',
				'updated_at' => '2013-11-14 00:41:29',
			),
			17 => 
			array (
				'id' => 38,
				'user_id' => 31,
				'media_id' => 79,
				'comment' => 'Nah, that\'s not really a sport. This is a sport!',
				'pic_url' => 'November2013/football.jpg',
				'vid_url' => NULL,
				'created_at' => '2013-11-14 23:13:10',
				'updated_at' => '2013-11-14 23:13:10',
			),
			18 => 
			array (
				'id' => 39,
				'user_id' => 31,
				'media_id' => 32,
				'comment' => 'This is my fave',
				'pic_url' => NULL,
				'vid_url' => 'http://www.youtube.com/watch?v=QHH3iSeDBLo',
				'created_at' => '2013-11-25 03:43:20',
				'updated_at' => '2013-11-25 03:43:20',
			),
		));
	}

}
