<?php

class SettingsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('settings')->truncate();
        
		\DB::table('settings')->insert(array (
			0 => 
			array (
				'id' => 1,
				'website_name' => 'Ninja Media Script',
				'website_description' => 'Viral Fun Media Sharing Script',
				'logo' => 'application/assets/img/logo.png',
				'favicon' => 'application/assets/img/favicon.png',
				'theme' => '',
				'fb_key' => '',
				'fb_secret_key' => '',
				'facebook_page_id' => 'envato',
				'google_key' => '',
				'google_secret_key' => '',
				'google_page_id' => 'envato',
				'twitter_page_id' => 'envato',
				'post_title_length' => 0,
				'auto_approve_posts' => 1,
				'custom_css' => '',
				'like_icon' => 'fa-thumbs-o-up',
				'secondary_color' => '#12c3ee',
				'primary_color' => '#ee222e',
				'square_ad' => '',
				'updated_at' => '2014-01-04 00:08:17',
				'created_at' => '0000-00-00 00:00:00',
			),
		));
	}

}
