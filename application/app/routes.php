<?php

/*
|--------------------------------------------------------------------------
| Ninja Media Script
|--------------------------------------------------------------------------
|
| Version: 1.1.1
| Date: June 01, 2014
|
*/


// **********	INSTALLATION ROUTES *********//

Route::get('install', 'InstallController@install');
Route::post('install_setup', 'InstallController@setup');
Route::post('install_connection', 'InstallController@test_db_connection');
Route::post('install_data', 'InstallController@add_db_data');
Route::post('install_admin', 'InstallController@add_admin_user');

Route::get('tester123', function(){
	$NMSConfig = new Nmsonfig;
	$NMSConfig->add('db_name', 'test123');
	print_r($NMSConfig);
	echo 'test';
});

// ********** UPGRADE ROUTES **********//
Route::get('upgrade', 'InstallController@upgrade');


// **********	HOME/ROOT ROUTE *********//

Route::get('/', 'HomeController@home');

Route::get('tst', function(){
	?>

<iframe title="YouTube video player" class="youtube-player" type="text/html" width="640"
	height="360" src="http://www.youtube.com/embed/<?php echo Youtubehelper::extractUTubeVidId('http://www.youtube.com/watch?v=gspaoaecNAg'); ?>?theme=light&rel=0" frameborder="0"
	allowFullScreen></iframe>

	
	<?php 
});


// ********* POPULAR ROUTE ********** //

Route::get('popular', function(){

	$media = Media::where('active', '=', '1')->join('media_likes', 'media.id', '=', 'media_likes.media_id')->groupBy('media_likes.media_id')->orderBy(DB::raw('COUNT(media_likes.id)'), 'DESC')->select('media.*')->paginate(30);

    $data = array(
    	'media' => $media);

	return View::make('home', $data);

});

Route::get('popular/week', function(){

	$media = Media::where('active', '=', '1')->join('media_likes', 'media.id', '=', 'media_likes.media_id')->where('media_likes.created_at', '>=', date('Y-m-d H:i:s', strtotime('-1 week')))->groupBy('media_likes.media_id')->orderBy(DB::raw('COUNT(media_likes.id)'), 'DESC')->select('media.*')->paginate(30);

    $data = array(
    	'media' => $media);

	return View::make('home', $data);

});

Route::get('popular/month', function(){

	$media = Media::where('active', '=', '1')->join('media_likes', 'media.id', '=', 'media_likes.media_id')->where('media_likes.created_at', '>=', date('Y-m-d H:i:s', strtotime('-1 month')))->groupBy('media_likes.media_id')->orderBy(DB::raw('COUNT(media_likes.id)'), 'DESC')->select('media.*')->paginate(30);

    $data = array(
    	'media' => $media);

	return View::make('home', $data);

});

Route::get('popular/year', function(){

	$media = Media::where('active', '=', '1')->join('media_likes', 'media.id', '=', 'media_likes.media_id')->where('media_likes.created_at', '>=', date('Y-m-d H:i:s', strtotime('-1 year')))->groupBy('media_likes.media_id')->orderBy(DB::raw('COUNT(media_likes.id)'), 'DESC')->select('media.*')->paginate(30);

    $data = array(
    	'media' => $media);

	return View::make('home', $data);

});


// ********* TAGS ROUTE ********** //

Route::get('tags/{tag}', function($tag){
	
	$media = Media::where('active', '=', 1)->where('tags', 'LIKE', $tag.',%')->orWhere('tags', 'LIKE', '%,'.$tag.',%')->orWhere('tags', 'LIKE', '%,'.$tag)->orWhere('tags', '=', $tag)->orderBy('created_at', 'desc')->paginate(Config::get('site.num_results_per_page'));

	$data = array(
		'media' => $media,
		'tag' => $tag
		);

	return View::make('home', $data);
});


// ********* CATEGORY ROUTE ********** //

Route::get('category/{category}', 'CategoriesController@index');


// ********** USER AUTHENTICATION ROUTES  ********** //

// SIGN IN

Route::get('signin', function(){
	return View::make('auth.signin');
});

Route::post('signin', 'UserController@signin');

// SIGNUP

Route::get('signup', function(){
	return View::make('auth.signup');
});

Route::post('signup', 'UserController@signup');

// LOGOUT

Route::get('logout', function(){
	Auth::logout();
	return Redirect::to('/');
});

// OAUTH ROUTES

Route::get('auth/facebook', 'UserController@facebook');
Route::get('auth/google', 'UserController@google');

Route::get('google', function(){
	$googleService = OAuth::consumer( 'Google' );
	// get googleService authorization
    $url = $googleService->getAuthorizationUri();

    // return to facebook login url
    return Response::make()->header( 'Location', (string)$url );
});

// PASSWORD RESET

Route::get('password_reset', array(
  'uses' => 'UserController@password_reset',
  'as' => 'password.remind'
));

Route::post('password_reset', array(
  'uses' => 'UserController@password_request',
  'as' => 'password.request'
));

Route::get('password_reset/{token}', array(
  'uses' => 'UserController@password_reset_token',
  'as' => 'password.reset'
));

Route::post('password_reset/{token}', array(
  'uses' => 'UserController@password_reset_post',
  'as' => 'password.update'
));


// **********	SEARCH ROUTES  ********** //

Route::post('search', function(){
	$search = Input::get('search');
});


// **********	SINGLE MEDIA ROUTE ********** //

Route::get('media/{slug}', 'MediaController@show');


// **********	RANDOM MEDIA ROUTE ********** //

Route::get('random', 'MediaController@random');


/********** API Routes **********/

Route::controller('api', 'ApiController');


// **********	USER PROFILE ROUTES   ********** //

Route::get('user/{username}', 'UserController@profile');
Route::get('user/{username}/likes', 'UserController@profile_likes');


// **********	POINTS / FLAGS / LIKE ROUTES ********** //

Route::post('add_user_point', 'UserController@add_user_point');
Route::post('media/add_flag', 'MediaController@add_flag');
Route::post('media/add_like', 'MediaController@add_like');
Route::post('user/add_flag', 'UserController@add_flag');


// **********	COMMENTS ROUTES  **********//

Route::resource('comments', 'CommentsController');
Route::post('comments/vote_up', 'CommentsController@vote_up');
Route::post('comments/vote_down', 'CommentsController@vote_down');
Route::post('comments/add_flag', 'CommentsController@add_flag');


// **********	USER LOGGED IN ROUTES  ********** //

Route::group(array('before' => 'auth'), function()
{
	/********** Upload Routes **********/
	Route::get('upload', 'MediaController@create');
	Route::post('upload', 'MediaController@create');
	Route::post('image_ajax_upload', 'MediaController@image_ajax_upload');
	Route::resource('media', 'MediaController');

	/********** DELETE Media/Comments Routes *********/
	Route::get('media/delete/{id}', 'MediaController@delete');
	Route::get('comments/delete/{id}', 'CommentsController@delete');

	/********** User Routes **********/
	Route::get('user/{username}/edit', 'UserController@edit');
	Route::get('user/{username}/points', 'UserController@points');
	Route::get('user/{username}/asked', 'UserController@asked');
	Route::post('user/update/{id}', 'UserController@update');

});


// **********	ADMIN ROUTES  ********** //

Route::group(array('before' => 'admin'), function(){
	Route::get('admin', 'AdminController@index');
	Route::get('admin/media', 'AdminController@media');
	Route::get('admin/media/toggle_active/{id}', 'AdminController@toggle_active');
	Route::get('admin/comments', 'AdminController@comments');
	Route::get('admin/users', 'AdminController@users');
	Route::get('admin/categories', 'AdminController@categories');
	Route::post('categories/update/{id}', 'CategoriesController@update');
	Route::get('admin/settings', 'AdminController@settings');
	Route::get('admin/flagged/answers', 'AdminController@flagged_answers');
	Route::get('admin/flagged/users', 'AdminController@flagged_users');
	Route::get('admin/custom_css', 'AdminController@custom_css');
	Route::post('admin/custom_css', 'AdminController@update_custom_css');
	Route::post('admin/update_settings', 'AdminController@update_settings');
	Route::get('admin/deactivate_user/{id}', 'AdminController@deactivate_user');
	Route::get('admin/activate_user/{id}', 'AdminController@activate_user');
	Route::get('category/delete/{id}', 'CategoriesController@delete');
	Route::resource('categories', 'CategoriesController');

	Route::get('admin/pages', 'AdminController@pages');
	Route::post('admin/pages/update/{id}', 'AdminController@update_pages');
	Route::get('admin/pages/delete/{id}', 'AdminController@delete_pages');
	Route::post('admin/pages/create', 'AdminController@create_pages');
	
});

Route::get('pages/{slug}', function($slug){
	$page = Page::where('url', '=', $slug)->first();
	$data = array(
		'page' => $page,
		);
	return View::make('pages.index', $data);
});

Route::get('sitemap/generate', 'SitemapController@generate');

