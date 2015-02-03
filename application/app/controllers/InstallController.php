<?php

class InstallController extends BaseController {
	
	// ********** Main Install Route ********** //

	public function install(){
		try{

			$settings = Setting::first();
			if($settings){
				return Redirect::to('/');
			} else {
				throw new Exception('settings not set, first install the script');
			}

		}catch(Exception $e){

				return Redirect::to('/install.php');

		}
	}


	// ********** Add the DB Credentials to a file ********** //

	public function setup(){
		if(Request::ajax()){
			try{

				if (Schema::hasTable('users')){

					return Redirect::to('/');
					
				} else {

					echo $this->add_db_credentials($_POST['database_host'], $_POST['database_name'], $_POST['database_user'], $_POST['database_password']);
				}

			} catch(Exception $e){

				echo $this->add_db_credentials($_POST['database_host'], $_POST['database_name'], $_POST['database_user'], $_POST['database_password']);
			
			}

		} else {
			echo false;
		}
	}


	private function add_db_credentials($db_host, $db_name, $db_user, $db_password){

		$NMSConfig = new Nmsconfig;
		$NMSConfig->add('db_host', $db_host);
		$NMSConfig->add('db_name', $db_name);
		$NMSConfig->add('db_user', $db_user);
		$NMSConfig->add('db_password', $db_password);

		$success = $NMSConfig->updateConfig();

		if($success !== FALSE){
			return true;
		} else {
			return false;
		}
	}

	// ********** Test the Database Connection ********** //

	public function test_db_connection(){
		if(Request::ajax()){

			try{

				$db_host = $_POST['database_host'];
				$db_name = $_POST['database_name'];
				$db_user = $_POST['database_user'];
				$db_password = $_POST['database_password'];

				// Create connection
				$con=mysqli_connect($db_host,$db_user,$db_password,$db_name);

				// Check connection
				if (mysqli_connect_errno()){
					echo false;
				} else {
					echo true;
				}

			} catch (Exception $e){
				echo false;
			}

		} else {
			echo false;
		}
	}

	// ********** Add pre-installed data ********** //

	public function add_db_data(){
		if(Request::ajax()){
			try{

				$settings = Setting::first();
				if($settings){
					return Redirect::to('/');
				} else {
					throw new Exception('settings not set, first install the script');
				}

			}catch(Exception $e){

				try{
					
					$this->add_all_tables();
					
					$this->insert_settings();
					$this->insert_categories();

					if(Input::get('preloaded_data') == 'true'){
						$this->insert_media();
					}

					$this->upgrade();

					echo true;
				
				} catch(Exception $e){
					echo false;
				}

			}

		} else {
			echo false;
		}
	}

	// ********** Add the admin to the database ********** //

	public function add_admin_user(){
		if(Request::ajax()){

			try{

				$user = User::first();
				if($user){
					return Redirect::to('/');
				} else {
					throw new Exception('We cannot detect any current user. Okay to add new admin');
				}

			}catch(Exception $e){

				$admin_username = Input::get('admin_username');
				$admin_email = Input::get('admin_email');
				$admin_password = Hash::make(Input::get('admin_password'));

				$user = new User;
				$user->username = $admin_username;
				$user->email = $admin_email;
				$user->password = $admin_password;
				$user->admin = 1;

				$new_user = $user->save();

				$point = new Point;
		    	$point->user_id = $user->id;
		    	$point->points = 200;
		    	$point->description = Lang::get('lang.registration');
		    	$point->save();

				if($new_user){
					Auth::attempt(array('email' => Input::get('admin_email'), 'password' => Input::get('admin_password')));
					echo true;
				} else {
					echo false;
				}

			}

		} else {
			echo false;
		}
	}

	// ********** Upgrade functionality ********** //

	public function upgrade(){

		$upgraded = $this->upgrade102();
		$upgraded = $this->upgrade105();
		$upgraded = $this->upgrade106();
		$upgraded = $this->upgrade107();
		$upgraded = $this->upgrade108();
		$upgraded = $this->upgrade109();
		$upgraded = $this->upgrade110();

		if($upgraded){
			return Redirect::to('/')->with(array('note' => 'Successfully Updated Your Script', 'note_type' => 'success') );
		} else {
			return Redirect::to('/');
		}

	}

	public function upgrade102(){

		if( !Schema::hasColumn('settings', 'analytics') ){

			Schema::table('settings', function($table)
			{
			    // Added for V 1.0.2
				$table->text('analytics');
				$table->boolean('user_registration')->default(1);
				$table->boolean('infinite_scroll')->default(1);
			});

			Schema::table('users', function($table){
				$table->string('activation_code')->nullable();
			});

			return true;

		} else {
			return false;
		}
	}

	public function upgrade105(){

		if( !Schema::hasColumn('settings', 'random_bar_enabled') ){

			Schema::table('settings', function($table)
			{
			    // Added for V 1.0.5
				$table->boolean('random_bar_enabled')->default(0);
			});

			return true;

		} else {
			return false;
		}

	}

	public function upgrade106(){

		if(!Schema::hasColumn('settings', 'media_description')){

			Schema::table('settings', function($table)
			{
			    // Added for V 1.0.6
				$table->boolean('media_description')->default(0);
			});

			return true;

		} else {
			return false;
		}

	}

	public function upgrade107(){

		if(!Schema::hasColumn('settings', 'inbetween_ads')){

			Schema::table('settings', function($table)
			{
			    // Added for V 1.0.7
				$table->text('inbetween_ads')->nullable();
				$table->integer('inbetween_ads_repeat')->default(5);
			});

			Schema::table('media', function($table)
			{
			    // Added for V 1.0.7
				$table->boolean('nsfw')->default(0);
			});

			return true;

		} else {
			return false;
		}

	}

	public function upgrade108(){

		if(!Schema::hasColumn('settings', 'enable_watermark')){

			Schema::table('settings', function($table)
			{
			    // Added for V 1.0.8
				$table->boolean('enable_watermark')->default(0);
				$table->string('watermark_image')->default('application/assets/img/watermark.png');
				$table->string('watermark_position')->default('bottom-right');
				$table->integer('watermark_offset_x')->default(0);
				$table->integer('watermark_offset_y')->default(0);
			});

			return true;

		} else {
			return false;
		}

	}

	public function upgrade109(){

		$return_value = false;

		if(!Schema::hasColumn('media', 'views')){

			Schema::table('media', function($table)
			{
			    // Added for V 1.0.9
				$table->integer('views')->default(0);
				//update description to text
				DB::statement('ALTER TABLE `media` CHANGE `description` `description` TEXT');
			});

			$return_value = true;
		}

		if(!Schema::hasColumn('settings', 'pages_in_menu')){

			Schema::table('settings', function($table)
			{
				$table->boolean('pages_in_menu')->default(1);
			});

			$return_value = true;
		}

		if(!Schema::hasColumn('settings', 'pages_in_menu_text')){

			Schema::table('settings', function($table)
			{
				$table->string('pages_in_menu_text')->default('More');
			});

			$return_value = true;
		}

		if(!Schema::hasColumn('settings', 'infinite_load_btn')){

			Schema::table('settings', function($table)
			{
				$table->boolean('infinite_load_btn')->default(0);
			});

			$return_value = true;
		}

		if (!Schema::hasTable('pages'))
		{
		    Schema::create('pages', function($table) {
				$table->increments('id');
				$table->string('title');
				$table->string('url');
				$table->text('body');
				$table->integer('order')->default(0);
				$table->boolean('active')->default(1);
				$table->boolean('show_in_menu')->default(1);
				$table->timestamps();
			});

			$return_value = true;
		}

		return $return_value;

	}


	public function upgrade110(){

		$return_value = false;

		if(!Schema::hasColumn('settings', 'captcha')){

			Schema::table('settings', function($table)
			{
				$table->boolean('captcha')->default(0);
				$table->string('captcha_public_key')->default('');
				$table->string('captcha_private_key')->default('');
			});

			$return_value = true;
		}

		return $return_value;

	}

	private function add_all_tables(){

		if (!Schema::hasTable('users'))
		{
			Schema::create('users', function($table){
				$table->increments('id');
				$table->string('username');
				$table->integer('admin')->default(0);
				$table->integer('active')->default(1);
				$table->string('email');
				$table->string('password');
				$table->string('avatar')->default('default.jpg');
				$table->timestamps();
			});
		}

		if (!Schema::hasTable('media'))
		{
			Schema::create('media', function($table) {
				$table->increments('id');
				$table->integer('user_id');
				$table->integer('category_id')->default(1);
				$table->string('title');
				$table->string('slug');
				$table->string('description', 250)->default('');
				$table->boolean('active')->default(1);
				$table->boolean('vid')->default(0);
				$table->boolean('pic')->default(1);
				$table->string('pic_url')->nullable();
				$table->text('vid_url')->nullable();
				$table->string('link_url')->nullable();
				$table->text('tags')->nullable();
				$table->timestamps();
			});
		}

		if (!Schema::hasTable('categories'))
		{
			Schema::create('categories', function($table) {
				$table->increments('id');
				$table->string('name');
				$table->integer('order');
				$table->timestamps();
			});
		}

		if (!Schema::hasTable('comments'))
		{
			Schema::create('comments', function($table) {
				$table->increments('id');
				$table->integer('user_id');
				$table->integer('media_id');
				$table->string('comment');
				$table->string('pic_url')->nullable();
				$table->text('vid_url')->nullable();
				$table->timestamps();
			});
		}

		if (!Schema::hasTable('points'))
		{
			Schema::create('points', function($table) {
				$table->increments('id');
				$table->integer('user_id');
				$table->integer('points');
				$table->string('description');
				$table->timestamps();
			});
		}

		if (!Schema::hasTable('comment_votes'))
		{
			Schema::create('comment_votes', function($table) {
				$table->increments('id');
				$table->integer('user_id');
				$table->integer('comment_id');
				$table->boolean('up')->default(0);
				$table->boolean('down')->default(0);
				$table->timestamps();
			});
		}

		if (!Schema::hasTable('comment_flags'))
		{
			Schema::create('comment_flags', function($table) {
				$table->increments('id');
				$table->integer('user_id');
				$table->integer('comment_id');
				$table->timestamps();
			});
		}

		if (!Schema::hasTable('user_flags'))
		{
			Schema::create('user_flags', function($table) {
				$table->increments('id');
				$table->integer('user_id');
				$table->integer('user_flagged_id');
				$table->timestamps();
			});
		}

		if (!Schema::hasTable('media_flags'))
		{
			Schema::create('media_flags', function($table) {
				$table->increments('id');
				$table->integer('user_id');
				$table->integer('media_id');
				$table->timestamps();
			});
		}

		if (!Schema::hasTable('media_likes'))
		{
			Schema::create('media_likes', function($table) {
				$table->increments('id');
				$table->integer('user_id');
				$table->integer('media_id');
				$table->timestamps();
			});
		}

		if (!Schema::hasTable('oauth_facebook'))
		{
			Schema::create('oauth_facebook', function($table) {
				$table->increments('id');
				$table->integer('user_id');
				$table->string('oauth_userid', 64);
				$table->timestamps();
			});
		}

		if (!Schema::hasTable('oauth_google'))
		{
			Schema::create('oauth_google', function($table) {
				$table->increments('id');
				$table->integer('user_id');
				$table->string('oauth_userid', 64);
				$table->timestamps();
			});
		}

		if (!Schema::hasTable('settings'))
		{
			Schema::create('settings', function($table) {
				$table->increments('id');
				$table->string('website_name');
				$table->string('website_description');
				$table->string('logo');
				$table->string('favicon');
				$table->string('theme');
				$table->string('fb_key');
				$table->string('fb_secret_key');
				$table->string('facebook_page_id');
				$table->string('google_key');
				$table->string('google_secret_key');
				$table->string('google_page_id');
				$table->string('twitter_page_id');
				$table->integer('post_title_length');
				$table->boolean('auto_approve_posts');
				$table->text('custom_css');
				$table->string('like_icon', 20);
				$table->string('secondary_color', 20);
				$table->string('primary_color', 10);
				$table->text('square_ad');
				$table->string('color_scheme', 20)->default('light');
				$table->timestamps();
			});
		}

		if (!Schema::hasTable('password_reminders'))
		{
			Schema::create('password_reminders', function($table)
			{
				$table->string('email')->index();
				$table->string('token')->index();
				$table->timestamp('created_at');
			});
		}
	}

	private function insert_settings(){
		DB::table('settings')->insert(array (
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

	private function insert_categories(){
		DB::table('categories')->insert(array (
			0 => 
			array (
				'id' => '1',
				'name' => 'Uncategorized',
				'order' => '33',
				'created_at' => '2013-10-24 16:41:57',
				'updated_at' => '2014-01-28 15:25:19',
			),
			1 => 
			array (
				'id' => '2',
				'name' => 'Animals',
				'order' => '1',
				'created_at' => '2013-10-18 15:57:00',
				'updated_at' => '2014-01-28 15:45:25',
			),
			2 => 
			array (
				'id' => '25',
				'name' => 'News',
				'order' => '24',
				'created_at' => '2013-10-24 16:40:46',
				'updated_at' => '2013-10-24 16:40:46',
			),
			3 => 
			array (
				'id' => '29',
				'name' => 'Sports',
				'order' => '31',
				'created_at' => '2013-10-24 16:41:30',
				'updated_at' => '2014-01-26 17:22:09',
			),
			4 => 
			array (
				'id' => '31',
				'name' => 'Comics',
				'order' => '18',
				'created_at' => '2014-01-28 14:59:34',
				'updated_at' => '2014-01-28 16:00:58',
			),
			5 => 
			array (
				'id' => '32',
				'name' => 'Cartoon',
				'order' => '3',
				'created_at' => '2014-01-28 15:25:09',
				'updated_at' => '2014-01-28 15:25:09',
			),
			6 => 
			array (
				'id' => '33',
				'name' => 'Music',
				'order' => '22',
				'created_at' => '2014-01-28 15:44:11',
				'updated_at' => '2014-01-28 15:44:11',
			),
			7 => 
			array (
				'id' => '34',
				'name' => 'Architecture',
				'order' => '2',
				'created_at' => '2014-01-28 15:45:15',
				'updated_at' => '2014-01-28 15:45:31',
			),
			8 => 
			array (
				'id' => '35',
				'name' => 'Film',
				'order' => '20',
				'created_at' => '2014-01-28 16:00:22',
				'updated_at' => '2014-01-28 16:00:22',
			),
			9 => 
			array (
				'id' => '36',
				'name' => 'Family',
				'order' => '19',
				'created_at' => '2014-01-28 16:01:08',
				'updated_at' => '2014-01-28 16:01:08',
			),
			10 => 
			array (
				'id' => '37',
				'name' => 'Comedy',
				'order' => '13',
				'created_at' => '2014-01-31 04:11:41',
				'updated_at' => '2014-01-31 04:11:41',
			),
			11 => 
			array (
				'id' => '38',
				'name' => 'Vehicles',
				'order' => '38',
				'created_at' => '2014-01-31 04:20:05',
				'updated_at' => '2014-01-31 04:20:05',
			),
			12 => 
			array (
				'id' => '39',
				'name' => 'Food',
				'order' => '21',
				'created_at' => '2014-01-31 04:46:00',
				'updated_at' => '2014-01-31 04:46:00',
			),
			13 => 
			array (
				'id' => '40',
				'name' => 'Retro',
				'order' => '25',
				'created_at' => '2014-02-04 04:38:23',
				'updated_at' => '2014-02-04 04:38:23',
			),
		));
	}


	private function insert_media(){
		DB::table('media')->insert(array (
			0 => 
			array (
				'id' => '94',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'What would you do?',
				'slug' => 'what-would-you-do',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/what_would_you_do.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-27 17:27:31',
				'updated_at' => '2014-01-30 22:15:53',
			),
			1 => 
			array (
				'id' => '95',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Google Fridge',
				'slug' => 'google-fridge',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/google-egg-fridge.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-27 17:29:21',
				'updated_at' => '2014-01-30 22:15:53',
			),
			2 => 
			array (
				'id' => '96',
				'user_id' => '38',
				'category_id' => '39',
				'title' => 'Hamburger Helper',
				'slug' => 'hamburger-helper',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/hamburger-helper.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-27 17:30:03',
				'updated_at' => '2014-02-08 17:34:01',
			),
			3 => 
			array (
				'id' => '97',
				'user_id' => '38',
				'category_id' => '39',
				'title' => 'Lies',
				'slug' => 'lies',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/lies.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-27 17:30:40',
				'updated_at' => '2014-02-08 17:34:17',
			),
			4 => 
			array (
				'id' => '98',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Tips-n-Tricks',
				'slug' => 'tips-n-tricks',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/tips-n-tricks.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-27 17:31:04',
				'updated_at' => '2014-01-30 22:15:53',
			),
			5 => 
			array (
				'id' => '99',
				'user_id' => '38',
				'category_id' => '39',
				'title' => 'This Just in...',
				'slug' => 'this-just-in',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/cheeseburger-stabbing.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-27 17:31:42',
				'updated_at' => '2014-02-08 17:34:25',
			),
			6 => 
			array (
				'id' => '100',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Hold My Calls',
				'slug' => 'hold-my-calls',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/hold-my-calls.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-27 17:34:29',
				'updated_at' => '2014-01-30 22:15:53',
			),
			7 => 
			array (
				'id' => '101',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Welcome To The Jungle',
				'slug' => 'welcome-to-the-jungle',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/welcome_to_the_jungle.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-27 17:34:57',
				'updated_at' => '2014-01-30 22:15:53',
			),
			8 => 
			array (
				'id' => '102',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Will this be on the test?',
				'slug' => 'will-this-be-on-the-test',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/test-blackboard.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-27 17:35:19',
				'updated_at' => '2014-01-30 22:15:53',
			),
			9 => 
			array (
				'id' => '103',
				'user_id' => '38',
				'category_id' => '2',
				'title' => 'Just keep on smilin fatty',
				'slug' => 'just-keep-on-smilin-fatty',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/just_keep_smilin_fatty.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-27 17:40:47',
				'updated_at' => '2014-02-08 17:35:45',
			),
			10 => 
			array (
				'id' => '104',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Choose your own adventure',
				'slug' => 'choose-your-own-adventure',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/choose_your_own_adventure.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-27 17:41:34',
				'updated_at' => '2014-01-30 22:15:53',
			),
			11 => 
			array (
				'id' => '105',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Keep up the adequate work!',
				'slug' => 'keep-up-the-adequate-work',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/adequate_work.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-27 17:41:52',
				'updated_at' => '2014-01-30 22:15:53',
			),
			12 => 
			array (
				'id' => '106',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Hey Ladies...',
				'slug' => 'hey-ladies',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/hey_ladies.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-27 17:42:10',
				'updated_at' => '2014-01-30 22:15:53',
			),
			13 => 
			array (
				'id' => '107',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'A Case of the Mondays',
				'slug' => 'a-case-of-the-mondays',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/filled_with_excitement.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-27 17:42:33',
				'updated_at' => '2014-01-30 22:15:53',
			),
			14 => 
			array (
				'id' => '108',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Be Honest Now',
				'slug' => 'be-honest-now',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/be_honest_now.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-27 17:43:00',
				'updated_at' => '2014-01-30 22:15:53',
			),
			15 => 
			array (
				'id' => '109',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Meet Your New Cubemate',
				'slug' => 'meet-your-new-cubemate',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/cubemate_small.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-27 17:47:17',
				'updated_at' => '2014-01-30 22:15:53',
			),
			16 => 
			array (
				'id' => '110',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Those Bastards',
				'slug' => 'those-bastards',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/piano_robot.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-27 17:47:39',
				'updated_at' => '2014-01-30 22:15:53',
			),
			17 => 
			array (
				'id' => '112',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Is this a problem these days?',
				'slug' => 'is-this-a-problem-these-days',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/is-this-a-problem-these-days.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 02:51:52',
				'updated_at' => '2014-01-30 22:15:53',
			),
			18 => 
			array (
				'id' => '113',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Defense',
				'slug' => 'defense',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/defense.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 02:52:07',
				'updated_at' => '2014-01-30 22:15:53',
			),
			19 => 
			array (
				'id' => '114',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Ooops Sorry',
				'slug' => 'ooops-sorry',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/ooops-sorry.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 02:52:23',
				'updated_at' => '2014-01-30 22:15:53',
			),
			20 => 
			array (
				'id' => '115',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'The day I lost control...',
				'slug' => 'the-day-i-lost-control',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/the-day-i-lost-control.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 02:52:48',
				'updated_at' => '2014-01-30 22:15:53',
			),
			21 => 
			array (
				'id' => '116',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'What I remember most about LEGOs',
				'slug' => 'what-i-remember-most-about-legos',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/what-i-remember-most-about-legos.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 02:53:01',
				'updated_at' => '2014-01-30 22:15:53',
			),
			22 => 
			array (
				'id' => '117',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Tea Submarine',
				'slug' => 'tea-submarine',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/tea-submarine.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 02:53:28',
				'updated_at' => '2014-01-30 22:15:53',
			),
			23 => 
			array (
				'id' => '118',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Do we have a problem?',
				'slug' => 'do-we-have-a-problem',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/do-we-have-a-problem.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 02:53:44',
				'updated_at' => '2014-01-30 22:15:53',
			),
			24 => 
			array (
				'id' => '119',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Simplest rubiks cube solution',
				'slug' => 'simplest-rubiks-cube-solution',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/simplest-rubiks-cube-solution.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 03:03:45',
				'updated_at' => '2014-01-30 22:15:53',
			),
			25 => 
			array (
				'id' => '120',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'IMPOSTER!',
				'slug' => 'imposter',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/imposter.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 03:04:03',
				'updated_at' => '2014-01-30 22:15:53',
			),
			26 => 
			array (
				'id' => '121',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Life is just a game.',
				'slug' => 'life-is-just-a-game',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/life-is-just-a-game.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 03:04:22',
				'updated_at' => '2014-01-30 22:15:53',
			),
			27 => 
			array (
				'id' => '122',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Pepsi Vs. Coke',
				'slug' => 'pepsi-vs-coke',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/pepsi-vs-coke.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 03:04:52',
				'updated_at' => '2014-01-30 22:15:54',
			),
			28 => 
			array (
				'id' => '123',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Shadow Faces',
				'slug' => 'shadow-faces',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/shadow-faces.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 03:05:08',
				'updated_at' => '2014-01-30 22:15:54',
			),
			29 => 
			array (
				'id' => '124',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Oh Google...',
				'slug' => 'oh-google',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/oh-google.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 03:05:23',
				'updated_at' => '2014-01-30 22:15:54',
			),
			30 => 
			array (
				'id' => '125',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Poker is not for everyone',
				'slug' => 'poker-is-not-for-everyone',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/poker-is-not-for-everyone.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 03:05:49',
				'updated_at' => '2014-01-30 22:15:54',
			),
			31 => 
			array (
				'id' => '126',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'In case of nothing to do...',
				'slug' => 'in-case-of-nothing-to-do',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/in-case-of-nothing-to-do.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 03:06:03',
				'updated_at' => '2014-01-30 22:15:54',
			),
			32 => 
			array (
				'id' => '127',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Life was much easier...',
				'slug' => 'life-was-much-easier',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/life-was-much-easier.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 03:06:19',
				'updated_at' => '2014-01-30 22:15:54',
			),
			33 => 
			array (
				'id' => '128',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'well played son, well played',
				'slug' => 'well-played-son-well-played',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/well-played-son-well-played.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 03:06:35',
				'updated_at' => '2014-01-30 22:15:54',
			),
			34 => 
			array (
				'id' => '129',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Seat Savers',
				'slug' => 'seat-savers',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/seat-savers.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 03:06:52',
				'updated_at' => '2014-01-30 22:15:54',
			),
			35 => 
			array (
				'id' => '130',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Harry Potter on Facebook',
				'slug' => 'harry-potter-on-facebook',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/harry-potter-on-facebook.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 03:07:01',
				'updated_at' => '2014-01-30 22:15:54',
			),
			36 => 
			array (
				'id' => '131',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Donuts\\\' escalator',
				'slug' => 'donuts-escalator',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/donuts-escalator.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 03:07:16',
				'updated_at' => '2014-01-30 22:15:54',
			),
			37 => 
			array (
				'id' => '132',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Ctrl-V, Ctrl-X, Ctrl-Z',
				'slug' => 'ctrl-v-ctrl-x-ctrl-z',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/ctrl-v-ctrl-x-ctrl-z.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 03:07:29',
				'updated_at' => '2014-01-30 22:15:54',
			),
			38 => 
			array (
				'id' => '133',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Cleverness',
				'slug' => 'cleverness',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/cleverness.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 03:08:13',
				'updated_at' => '2014-01-30 22:15:54',
			),
			39 => 
			array (
				'id' => '134',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'If condoms had sponsors',
				'slug' => 'if-condoms-had-sponsors',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/if-condoms-had-sponsors.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 03:08:42',
				'updated_at' => '2014-01-30 22:15:54',
			),
			40 => 
			array (
				'id' => '135',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Eggregation',
				'slug' => 'eggregation',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/eggregation.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 03:08:53',
				'updated_at' => '2014-01-30 22:15:54',
			),
			41 => 
			array (
				'id' => '136',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Banana Bedtime',
				'slug' => 'banana-bedtime',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/banana-bedtime.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 03:09:11',
				'updated_at' => '2014-01-30 22:15:54',
			),
			42 => 
			array (
				'id' => '137',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Just Dream :)',
				'slug' => 'just-dream',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/just-dream.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 03:09:25',
				'updated_at' => '2014-01-30 22:15:54',
			),
			43 => 
			array (
				'id' => '138',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Formula of iPad',
				'slug' => 'formula-of-ipad',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/formula-of-ipad.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 15:32:42',
				'updated_at' => '2014-01-30 22:15:54',
			),
			44 => 
			array (
				'id' => '139',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'How to draw an owl',
				'slug' => 'how-to-draw-an-owl',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/how-to-draw-an-owl.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 15:33:10',
				'updated_at' => '2014-01-30 22:15:54',
			),
			45 => 
			array (
				'id' => '140',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'FALLING (in love) ROCKS',
				'slug' => 'falling-in-love-rocks',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/falling-in-love-rocks.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 15:33:30',
				'updated_at' => '2014-01-30 22:15:54',
			),
			46 => 
			array (
				'id' => '141',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'That\\\'s my plan',
				'slug' => 'that-s-my-plan',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/thats-my-plan.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 15:33:48',
				'updated_at' => '2014-01-30 22:15:54',
			),
			47 => 
			array (
				'id' => '142',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'What the flip...',
				'slug' => 'what-the-flip',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/what-the-flip.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 15:34:17',
				'updated_at' => '2014-01-30 22:15:54',
			),
			48 => 
			array (
				'id' => '143',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Blood Puddle Pillows',
				'slug' => 'blood-puddle-pillows',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/blood-puddle-pillows.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 15:36:03',
				'updated_at' => '2014-01-30 22:15:54',
			),
			49 => 
			array (
				'id' => '144',
				'user_id' => '38',
				'category_id' => '31',
				'title' => 'Play Outside',
				'slug' => 'play-outside',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/play-outside.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 15:36:23',
				'updated_at' => '2014-02-08 17:35:56',
			),
			50 => 
			array (
				'id' => '145',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Uses of Google',
				'slug' => 'uses-of-google',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/uses-of-google.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 15:36:38',
				'updated_at' => '2014-01-30 22:15:54',
			),
			51 => 
			array (
				'id' => '146',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Heavy Metal',
				'slug' => 'heavy-metal',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/heavy-metal.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 15:37:02',
				'updated_at' => '2014-01-30 22:15:54',
			),
			52 => 
			array (
				'id' => '147',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Check out what I can do...',
				'slug' => 'check-out-what-i-can-do',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/check-out-what-i-can-do.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 15:37:22',
				'updated_at' => '2014-01-30 22:15:54',
			),
			53 => 
			array (
				'id' => '148',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Bitchin',
				'slug' => 'bitchin',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/bitchin.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 15:37:40',
				'updated_at' => '2014-01-30 22:15:54',
			),
			54 => 
			array (
				'id' => '149',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Passport!',
				'slug' => 'passport',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/passport.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 15:37:54',
				'updated_at' => '2014-01-30 22:15:54',
			),
			55 => 
			array (
				'id' => '150',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Say goodbye to your friends and get in the car...',
				'slug' => 'say-goodbye-to-your-friends-and-get-in-the-car',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'December2013/say-goodbye-to-your-friends-and-get-in-the-car.jpg',
				'vid_url' => NULL,
				'link_url' => '',
				'tags' => '',
				'created_at' => '2013-12-28 15:38:09',
				'updated_at' => '2014-01-30 22:15:54',
			),
			56 => 
			array (
				'id' => '151',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Kitty Ping Pong',
				'slug' => 'kitty-ping-pong',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/kitty-gif.gif',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'funny,kitty,ping pong,cute',
				'created_at' => '2014-01-04 04:01:29',
				'updated_at' => '2014-01-30 22:15:54',
			),
			57 => 
			array (
				'id' => '152',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Cool Ball Flip',
				'slug' => 'cool-ball-flip',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/cool-ball-flip.gif',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'gif,cool ball flip,exercise ball',
				'created_at' => '2014-01-04 05:10:10',
				'updated_at' => '2014-01-30 22:15:54',
			),
			58 => 
			array (
				'id' => '153',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Alone In The Dark',
				'slug' => 'alone-in-the-dark',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/alone-in-the-dark.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'funny,black guys',
				'created_at' => '2014-01-04 05:12:40',
				'updated_at' => '2014-01-30 22:15:54',
			),
			59 => 
			array (
				'id' => '154',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Freedom of Speech',
				'slug' => 'freedom-of-speech',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/freedom-of-speech.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'freedom of speech,kids drawing,homework',
				'created_at' => '2014-01-04 05:14:13',
				'updated_at' => '2014-01-30 22:15:54',
			),
			60 => 
			array (
				'id' => '156',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Rainbow in your hand',
				'slug' => 'rainbow-in-your-hand',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/rainbow-in-your-hand.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'rainbow,cards,flipcards',
				'created_at' => '2014-01-04 05:16:19',
				'updated_at' => '2014-01-30 22:15:54',
			),
			61 => 
			array (
				'id' => '157',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'I need some space',
				'slug' => 'i-need-some-space',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/i-need-some-space.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'cartoon,keyboard,characters',
				'created_at' => '2014-01-04 05:17:04',
				'updated_at' => '2014-01-30 22:15:54',
			),
			62 => 
			array (
				'id' => '158',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'It\\\'s too late...',
				'slug' => 'it-s-too-late',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/its-too-late.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'funny,food,egg,chicken',
				'created_at' => '2014-01-04 05:18:06',
				'updated_at' => '2014-01-30 22:15:54',
			),
			63 => 
			array (
				'id' => '159',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Pizza Cat',
				'slug' => 'pizza-cat',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/pizza-cat.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'pizza,food,cat',
				'created_at' => '2014-01-04 05:18:51',
				'updated_at' => '2014-01-30 22:15:54',
			),
			64 => 
			array (
				'id' => '160',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Space Saving Sofa Bed',
				'slug' => 'space-saving-sofa-bed',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/52ceb86074c03-space-saving-sofa-bed.jpg.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'couch,cool,space saving,transform',
				'created_at' => '2014-01-09 14:55:28',
				'updated_at' => '2014-01-30 22:15:54',
			),
			65 => 
			array (
				'id' => '162',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Guillotine Bowling Alley',
				'slug' => 'guillotine-bowling-alley',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/52ceb8f06dc47-guillotine-bowling-alley.jpg.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'guillotine,bowling',
				'created_at' => '2014-01-09 14:57:52',
				'updated_at' => '2014-01-30 22:15:54',
			),
			66 => 
			array (
				'id' => '163',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'It\\\'s A Boy!',
				'slug' => 'it-s-a-boy',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/its-a-boy.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'card,funny,babies',
				'created_at' => '2014-01-09 14:58:21',
				'updated_at' => '2014-01-30 22:15:54',
			),
			67 => 
			array (
				'id' => '164',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Secrets of the Warp Whistle',
				'slug' => 'secrets-of-the-warp-whistle',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/secrets-of-the-warp-whistle.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'mario,warp whistle,games',
				'created_at' => '2014-01-09 14:59:15',
				'updated_at' => '2014-01-30 22:15:54',
			),
			68 => 
			array (
				'id' => '165',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'A common work occurrence',
				'slug' => 'a-common-work-occurrence',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/a-common-work-occurrence.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'funny,computer,music',
				'created_at' => '2014-01-09 15:00:16',
				'updated_at' => '2014-01-30 22:15:54',
			),
			69 => 
			array (
				'id' => '166',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Real Life Cartoon Boy',
				'slug' => 'real-life-cartoon-boy',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/real-life-cartoon-boy.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'up,movie',
				'created_at' => '2014-01-09 15:00:50',
				'updated_at' => '2014-01-30 22:15:54',
			),
			70 => 
			array (
				'id' => '167',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Timone and Pumba',
				'slug' => 'timone-and-pumba',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/timone-and-pumba.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'lion king,timone,pumba',
				'created_at' => '2014-01-09 15:01:18',
				'updated_at' => '2014-01-30 22:15:54',
			),
			71 => 
			array (
				'id' => '168',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'This is how phobias begin',
				'slug' => 'this-is-how-phobias-begin',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/this-is-how-phobias-begin.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'easter,creepy,phobias',
				'created_at' => '2014-01-09 15:02:11',
				'updated_at' => '2014-01-30 22:15:54',
			),
			72 => 
			array (
				'id' => '169',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Back in my day...',
				'slug' => 'back-in-my-day',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/back-in-my-day.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'ipod,music',
				'created_at' => '2014-01-09 15:03:00',
				'updated_at' => '2014-01-30 22:15:54',
			),
			73 => 
			array (
				'id' => '170',
				'user_id' => '38',
				'category_id' => '1',
				'title' => 'Flower Skirt',
				'slug' => 'flower-skirt',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/flower-skirt.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'flower,skirt,flower skirt',
				'created_at' => '2014-01-09 15:03:52',
				'updated_at' => '2014-01-30 22:15:54',
			),
			74 => 
			array (
				'id' => '171',
				'user_id' => '1',
				'category_id' => '32',
				'title' => 'This music smells funny',
				'slug' => 'this-music-smells-funny',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/this-music-smells-funny.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'simpsons,cartoon,funny',
				'created_at' => '2014-01-28 15:26:02',
				'updated_at' => '2014-01-30 22:15:54',
			),
			75 => 
			array (
				'id' => '172',
				'user_id' => '1',
				'category_id' => '2',
				'title' => 'Light me up!',
				'slug' => 'light-me-up',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/light-me-up.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'cigarette,lighter,bird,smoke',
				'created_at' => '2014-01-28 15:30:52',
				'updated_at' => '2014-01-30 22:15:54',
			),
			76 => 
			array (
				'id' => '173',
				'user_id' => '1',
				'category_id' => '1',
				'title' => 'Bubble Pop',
				'slug' => 'bubble-pop',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/bubble-pop.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'bubble,pop,slow motion',
				'created_at' => '2014-01-28 15:34:22',
				'updated_at' => '2014-01-30 22:15:54',
			),
			77 => 
			array (
				'id' => '174',
				'user_id' => '1',
				'category_id' => '32',
				'title' => 'The Pug Factory',
				'slug' => 'the-pug-factory',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/the-pug-factory.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'pugs,dogs,funny,cartoon',
				'created_at' => '2014-01-28 15:37:12',
				'updated_at' => '2014-01-30 22:15:54',
			),
			78 => 
			array (
				'id' => '175',
				'user_id' => '1',
				'category_id' => '32',
				'title' => 'Conspiracy',
				'slug' => 'conspiracy',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/conspiracy.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'funny,fridge,conspiracy,toe',
				'created_at' => '2014-01-28 15:38:32',
				'updated_at' => '2014-01-30 22:15:54',
			),
			79 => 
			array (
				'id' => '176',
				'user_id' => '1',
				'category_id' => '1',
				'title' => 'R2D2 Snowman',
				'slug' => 'r2d2-snowman',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/r2d2-snowman.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'snow,snowman',
				'created_at' => '2014-01-28 15:40:03',
				'updated_at' => '2014-01-30 22:15:54',
			),
			80 => 
			array (
				'id' => '177',
				'user_id' => '1',
				'category_id' => '29',
				'title' => 'Skate or Die',
				'slug' => 'skate-or-die',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/skate-or-die.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'skate,fall,hurt,injury',
				'created_at' => '2014-01-28 15:41:32',
				'updated_at' => '2014-01-30 22:15:54',
			),
			81 => 
			array (
				'id' => '178',
				'user_id' => '1',
				'category_id' => '36',
				'title' => 'The power of Christ compels you!',
				'slug' => 'the-power-of-christ-compels-you',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/the-power-of-christ-compels-you.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'funny,family photo,funny kid',
				'created_at' => '2014-01-28 16:01:54',
				'updated_at' => '2014-01-30 22:15:54',
			),
			82 => 
			array (
				'id' => '179',
				'user_id' => '1',
				'category_id' => '35',
				'title' => 'Dumb and Dumber - Inception Style',
				'slug' => 'dumb-and-dumber-inception-style',
				'description' => '',
				'active' => '1',
				'vid' => '1',
				'pic' => '1',
				'pic_url' => 'January2014/dumb-and-dumber---inception-style.jpg',
				'vid_url' => 'http://www.youtube.com/watch?v=zLDx-BPgxxA',
				'link_url' => '',
				'tags' => 'dumb & dumber,remake,inception',
				'created_at' => '2014-01-28 16:02:46',
				'updated_at' => '2014-01-30 22:15:54',
			),
			83 => 
			array (
				'id' => '180',
				'user_id' => '1',
				'category_id' => '35',
				'title' => 'Pick a vowel?',
				'slug' => 'pick-a-vowel',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/pick-a-vowel.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'scrubs,tv show',
				'created_at' => '2014-01-28 16:03:59',
				'updated_at' => '2014-01-30 22:15:54',
			),
			84 => 
			array (
				'id' => '181',
				'user_id' => '1',
				'category_id' => '1',
				'title' => 'Go Go Gadget Mailbox',
				'slug' => 'go-go-gadget-mailbox',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/go-go-gadget-mailbox.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'mailbox,ghetto rig',
				'created_at' => '2014-01-28 16:04:51',
				'updated_at' => '2014-01-30 22:15:54',
			),
			85 => 
			array (
				'id' => '182',
				'user_id' => '1',
				'category_id' => '2',
				'title' => 'Yodawg!',
				'slug' => 'yodawg',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/yodawg.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'yoda,dog,costume',
				'created_at' => '2014-01-28 16:05:58',
				'updated_at' => '2014-01-30 22:15:54',
			),
			86 => 
			array (
				'id' => '184',
				'user_id' => '1',
				'category_id' => '2',
				'title' => 'Can I hold him?',
				'slug' => 'can-i-hold-him',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/can-i-hold-him.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'pig,bacon,funny',
				'created_at' => '2014-01-31 03:56:28',
				'updated_at' => '2014-01-31 03:56:28',
			),
			87 => 
			array (
				'id' => '185',
				'user_id' => '1',
				'category_id' => '2',
				'title' => 'A dog towing a cat, towing a rat no, really',
				'slug' => 'a-dog-towing-a-cat-towing-a-rat-no-really',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/a-dog-towing-a-cat-towing-a-rat-no-really.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'dog,cat,rat,towing',
				'created_at' => '2014-01-31 03:57:47',
				'updated_at' => '2014-01-31 03:57:47',
			),
			88 => 
			array (
				'id' => '186',
				'user_id' => '1',
				'category_id' => '1',
				'title' => 'BATMAAN!',
				'slug' => 'batmaan',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/batmaan.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'batman',
				'created_at' => '2014-01-31 04:01:51',
				'updated_at' => '2014-01-31 04:01:51',
			),
			89 => 
			array (
				'id' => '187',
				'user_id' => '1',
				'category_id' => '32',
				'title' => 'Everybody Loves WiFi',
				'slug' => 'everybody-loves-wifi',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/everybody-loves-wifi.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'wifi,frog,alligator',
				'created_at' => '2014-01-31 04:04:23',
				'updated_at' => '2014-01-31 04:04:23',
			),
			90 => 
			array (
				'id' => '188',
				'user_id' => '1',
				'category_id' => '2',
				'title' => 'Awwww.....now I can go to sleep....',
				'slug' => 'awwww-now-i-can-go-to-sleep',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/awwwwnow-i-can-go-to-sleep.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'cat,sleep,kitten',
				'created_at' => '2014-01-31 04:05:49',
				'updated_at' => '2014-01-31 04:05:49',
			),
			91 => 
			array (
				'id' => '189',
				'user_id' => '1',
				'category_id' => '35',
				'title' => 'Pool Jumpers Trailer',
				'slug' => 'pool-jumpers-trailer',
				'description' => '',
				'active' => '1',
				'vid' => '1',
				'pic' => '1',
				'pic_url' => 'January2014/pool-jumpers-trailer.jpg',
				'vid_url' => 'http://www.youtube.com/watch?v=5GIZ3cN4JwA',
				'link_url' => '',
				'tags' => 'trailer,pool jumpers,pools',
				'created_at' => '2014-01-31 04:09:40',
				'updated_at' => '2014-01-31 04:09:40',
			),
			92 => 
			array (
				'id' => '190',
				'user_id' => '1',
				'category_id' => '2',
				'title' => 'Slowest Reader Ever',
				'slug' => 'slowest-reader-ever',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/slowest-reader-ever.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'cat,reading,book',
				'created_at' => '2014-01-31 04:10:45',
				'updated_at' => '2014-01-31 04:10:45',
			),
			93 => 
			array (
				'id' => '191',
				'user_id' => '1',
				'category_id' => '1',
				'title' => 'Fire Dragon... literally',
				'slug' => 'fire-dragon-literally',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/fire-dragon-literally.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'fire,dragon',
				'created_at' => '2014-01-31 04:13:52',
				'updated_at' => '2014-01-31 04:13:52',
			),
			94 => 
			array (
				'id' => '192',
				'user_id' => '1',
				'category_id' => '37',
				'title' => 'Harvard Sailing Team - Boys Will Be Girls ',
				'slug' => 'harvard-sailing-team-boys-will-be-girls',
				'description' => '',
				'active' => '1',
				'vid' => '1',
				'pic' => '1',
				'pic_url' => 'January2014/harvard-sailing-team---boys-will-be-girls.jpg',
				'vid_url' => 'http://www.youtube.com/watch?v=gspaoaecNAg',
				'link_url' => '',
				'tags' => 'harvard,sailing,sailing team,funny',
				'created_at' => '2014-01-31 04:15:55',
				'updated_at' => '2014-01-31 04:15:55',
			),
			95 => 
			array (
				'id' => '193',
				'user_id' => '1',
				'category_id' => '2',
				'title' => 'Rest up, little buddy.',
				'slug' => 'rest-up-little-buddy',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/rest-up-little-buddy.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'kitten,cast,cute,cat,hurt',
				'created_at' => '2014-01-31 04:17:03',
				'updated_at' => '2014-01-31 04:17:03',
			),
			96 => 
			array (
				'id' => '194',
				'user_id' => '1',
				'category_id' => '2',
				'title' => 'Stealth Mode',
				'slug' => 'stealth-mode',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/stealth-mode.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'food,steal,stealth,cat',
				'created_at' => '2014-01-31 04:18:35',
				'updated_at' => '2014-01-31 04:18:35',
			),
			97 => 
			array (
				'id' => '195',
				'user_id' => '1',
				'category_id' => '38',
				'title' => 'It\'s ok, truck. Things will get better.',
				'slug' => 'it-s-ok-truck-things-will-get-better',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/its-ok-truck-things-will-get-better.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'vehicle,truck,sad',
				'created_at' => '2014-01-31 04:20:51',
				'updated_at' => '2014-01-31 04:20:51',
			),
			98 => 
			array (
				'id' => '196',
				'user_id' => '1',
				'category_id' => '34',
				'title' => 'Book Cave',
				'slug' => 'book-cave',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/book-cave.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'books,cave,bookshelf',
				'created_at' => '2014-01-31 04:23:03',
				'updated_at' => '2014-01-31 04:23:03',
			),
			99 => 
			array (
				'id' => '197',
				'user_id' => '1',
				'category_id' => '34',
				'title' => 'Invisible Bookshelf',
				'slug' => 'invisible-bookshelf',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/invisible-bookshelf.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'books,bookshelf',
				'created_at' => '2014-01-31 04:23:36',
				'updated_at' => '2014-01-31 04:23:36',
			),
			100 => 
			array (
				'id' => '198',
				'user_id' => '1',
				'category_id' => '1',
				'title' => 'Awesome...',
				'slug' => 'awesome',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/awesome.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'outside,drive-in,theater',
				'created_at' => '2014-01-31 04:25:05',
				'updated_at' => '2014-01-31 04:25:05',
			),
			101 => 
			array (
				'id' => '199',
				'user_id' => '1',
				'category_id' => '2',
				'title' => 'I have the same look when I get to sleep in',
				'slug' => 'i-have-the-same-look-when-i-get-to-sleep-in',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/i-have-the-same-look-when-i-get-to-sleep-in.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'pig,blanket,sleep,cute',
				'created_at' => '2014-01-31 04:26:17',
				'updated_at' => '2014-01-31 04:26:17',
			),
			102 => 
			array (
				'id' => '200',
				'user_id' => '1',
				'category_id' => '1',
				'title' => 'Bare Necessities',
				'slug' => 'bare-necessities',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/bare-necessities.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'old school,nintendo,pizza',
				'created_at' => '2014-01-31 04:26:57',
				'updated_at' => '2014-01-31 04:26:57',
			),
			103 => 
			array (
				'id' => '201',
				'user_id' => '1',
				'category_id' => '1',
				'title' => 'Brain Transplant',
				'slug' => 'brain-transplant',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/brain-transplant.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'brain transplant,brain,gummy bear,candy',
				'created_at' => '2014-01-31 04:28:35',
				'updated_at' => '2014-01-31 04:28:35',
			),
			104 => 
			array (
				'id' => '204',
				'user_id' => '1',
				'category_id' => '39',
				'title' => 'Diet Coke Ninjas',
				'slug' => 'diet-coke-ninjas',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/diet-coke-ninjas.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'coke,ninjas',
				'created_at' => '2014-01-31 04:46:31',
				'updated_at' => '2014-01-31 04:46:31',
			),
			105 => 
			array (
				'id' => '205',
				'user_id' => '1',
				'category_id' => '1',
				'title' => 'The additional sign was necessary',
				'slug' => 'the-additional-sign-was-necessary',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/the-additional-sign-was-necessary.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'batman,atm,sign',
				'created_at' => '2014-01-31 04:51:12',
				'updated_at' => '2014-01-31 04:51:12',
			),
			106 => 
			array (
				'id' => '206',
				'user_id' => '1',
				'category_id' => '2',
				'title' => 'Raphael is Real',
				'slug' => 'raphael-is-real',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'January2014/raphael-is-real.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'ninja turtles,turtle,raphael,teenage mutant ninja turtles',
				'created_at' => '2014-01-31 04:52:34',
				'updated_at' => '2014-01-31 04:52:34',
			),
			107 => 
			array (
				'id' => '210',
				'user_id' => '1',
				'category_id' => '2',
				'title' => 'Today Has Been Ruff',
				'slug' => 'today-has-been-ruff',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'February2014/today-has-been-ruff.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'funny,couch,dog',
				'created_at' => '2014-02-03 01:36:30',
				'updated_at' => '2014-02-03 01:36:30',
			),
			108 => 
			array (
				'id' => '211',
				'user_id' => '1',
				'category_id' => '2',
				'title' => 'The Pug Life',
				'slug' => 'the-pug-life',
				'description' => '',
				'active' => '1',
				'vid' => '1',
				'pic' => '1',
				'pic_url' => 'February2014/the-pug-life.jpg',
				'vid_url' => 'https://vine.co/v/hWvK0WqFWKp/embed',
				'link_url' => '',
				'tags' => 'funny,dog,pug,thug life',
				'created_at' => '2014-02-03 02:03:41',
				'updated_at' => '2014-02-03 02:03:41',
			),
			109 => 
			array (
				'id' => '212',
				'user_id' => '1',
				'category_id' => '40',
				'title' => 'Nintendo Bed',
				'slug' => 'nintendo-bed',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'February2014/nintendo-bed.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'nintendo,bed',
				'created_at' => '2014-02-04 04:39:09',
				'updated_at' => '2014-02-04 04:39:09',
			),
			110 => 
			array (
				'id' => '213',
				'user_id' => '1',
				'category_id' => '32',
				'title' => 'Hate it when this happens!',
				'slug' => 'hate-it-when-this-happens',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'February2014/hate-it-when-this-happens.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'potato head,pee,urinal',
				'created_at' => '2014-02-04 04:39:59',
				'updated_at' => '2014-02-04 04:39:59',
			),
			111 => 
			array (
				'id' => '214',
				'user_id' => '1',
				'category_id' => '2',
				'title' => 'Must be Monday',
				'slug' => 'must-be-monday',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'February2014/must-be-monday.gif',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'funny,dog,puppies,fall',
				'created_at' => '2014-02-08 16:58:11',
				'updated_at' => '2014-02-08 16:58:11',
			),
			112 => 
			array (
				'id' => '215',
				'user_id' => '1',
				'category_id' => '39',
				'title' => 'Breakfast for One',
				'slug' => 'breakfast-for-one',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'February2014/breakfast-for-one.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'pan,solo,hans solo,pan solo',
				'created_at' => '2014-02-08 17:15:06',
				'updated_at' => '2014-02-08 17:15:06',
			),
			113 => 
			array (
				'id' => '216',
				'user_id' => '1',
				'category_id' => '31',
				'title' => 'Highlight Anything Stupid',
				'slug' => 'highlight-anything-stupid',
				'description' => '',
				'active' => '1',
				'vid' => '0',
				'pic' => '1',
				'pic_url' => 'February2014/highlight-anything-stupid.jpg',
				'vid_url' => '',
				'link_url' => '',
				'tags' => 'xkcd,hightlighter,final project,comic',
				'created_at' => '2014-02-08 17:31:12',
				'updated_at' => '2014-02-08 17:31:12',
			),
		));
	}

}
