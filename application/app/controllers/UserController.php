<?php 

class UserController extends BaseController{

	/**
	 * User Repository
	 *
	 * @var User
	 */
	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public static $rules = array(
		'username' => 'required|unique:users',
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed'
    );

    // *********** USER SIGNUP ********** //

	public function signup(){

		$validation = Validator::make( Input::all(), static::$rules );

		if ($validation->fails()){
			return Redirect::to('signup')->with(array('note' => Lang::get('lang.signup_error'), 'note_type' => 'error'));
		}

		$settings = Setting::first();


		if($settings->captcha){
			

			$privatekey = $settings->captcha_private_key;
			$resp = Recaptcha::recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], Input::get('recaptcha_challenge_field'), Input::get('recaptcha_response_field'));

			if (!$resp->is_valid) {
			  // Incorrect Captcha
			  return Redirect::to('signup')->with(array('note' => Lang::get('lang.incorrect_captcha'), 'note_type' => 'error'));
			} else {

			}
		}


		$username = htmlspecialchars(stripslashes(Input::get('username')));

		$user = User::where('username', '=', $username)->first();

		if(!$user){

			if($settings->user_registration){

				if( count(explode(' ', $username)) == 1 ){

					if(Input::get('password') != ''){
						$user = $this->new_user( $username, Input::get('email'), Hash::make(Input::get('password')) ); 
				    

					    if($user){
					    	Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password')));
					    	$this->new_user_points($user->id);
					    }

					    $redirect = Input::get('redirect');

					    if($redirect == '') $redirect = '/';

					    return Redirect::to($redirect)->with(array('note' => Lang::get('lang.signup_success'), 'note_type' => 'success'));

					} else {
						return Redirect::to('signup')->with(array('note' => Lang::get('lang.signup_invalidpass'), 'note_type' => 'error'));
					}

				} else {
					return Redirect::to('/signup')->with(array('note' => Lang::get('lang.username_no_spaces'), 'note_type' => 'error'));
				}

			} else {
				return Redirect::to('/')->with(array('note' => Lang::get('lang.signup_reg_closed'), 'note_type' => 'error'));
			}

		} else {
			return Redirect::to('signup')->with(array('note' => Lang::get('lang.username_in_use'), 'note_type' => 'error'));
		}

	}

	// *********** CREATE A NEW USERNAME WITH USERNAME EMAIL AND PASSWORD ********** //

	private function new_user($username, $email, $password, $filename = NULL){
	    $user = new User;
	    $user->username = $username;
	    $user->email = $email;
	    $user->password = $password;

	    if($filename){
	    	$user->avatar = $filename;
	    }

	    $user->save();

	    return $user;
	}

	// *********** WHEN USER SIGNS UP AWARD THEM WITH POINTS ********** //

	private function new_user_points($user_id){
		$point = new Point;
    	$point->user_id = $user_id;
    	$point->points = 200;
    	$point->description = Lang::get('lang.registration');
    	$point->save();
	}

	// *********** USER SIGNIN ********** //

	public function signin(){

	    // get login POST data
	    $email_login = array(
	        'email' => Input::get('email'),
	        'password' => Input::get('password')
	    );

	    $username_login = array(
	        'username' => Input::get('email'),
	        'password' => Input::get('password')
	    );

	    if ( Auth::attempt($email_login) || Auth::attempt($username_login) ){

	    	if(Auth::user()->active){
		    	$this->add_user_login_point();

		    	$redirect = Input::get('redirect');
				if($redirect == '') $redirect = '/';

		    	return Redirect::to($redirect)->with(array('note' => Lang::get('lang.signin_success'), 'note_type' => 'success'));
		    } else {
		    	Auth::logout();
		    	return Redirect::to('signin')->with(array('note' => 'This account is no longer active', 'note_type' => 'error'));
		    }
	    	
	    } else {
	        // auth failure! redirect to login with errors
	        return Redirect::to('signin')->with(array('note' => Lang::get('lang.signin_error'), 'note_type' => 'error'));
	    }

	}

	// *********** FACEBOOK OAUTH SIGNIN/SIGNUP ********** //

	public function facebook(){
	
		$settings = Setting::first();

		if($settings->user_registration){	

			// get data from input
		    $code = Input::get( 'code' );

		    // get fb service
		    $fb = OAuth::consumer( 'Facebook' );

		    // check if code is valid

		    // if code is provided get user data and sign in
		    if ( !empty( $code ) ) {
				
				$facebook = new Facebook(array(
				  'appId'  => $settings->fb_key,
				  'secret' => $settings->fb_secret_key,
				  'cookie' => true,
				  'oauth' => true,
				));
				
		        // This was a callback request from google, get the token
		        $token = $facebook->getAccessToken();
		        
		        $facebook->setAccessToken($token);
		        
		        $user = $facebook->getUser();

				$user_profile = $facebook->api('/me');

				//print_r($user_profile); die();

		        // Send a request with it
		        $result = $facebook->api('/me');

		        $oauth_userid = $result['id'];
		        $oauth_username = $result['first_name'];
		        $oauth_email = $result['email'];
		       	$headers = get_headers('http://graph.facebook.com/' . $oauth_userid . '/picture?type=large',1);
			    // just a precaution, check whether the header isset...
			    if(isset($headers['Location'])) {
			        $oauth_picture = $headers['Location']; // string
			    } else {
			        $oauth_picture = ''; // nothing there? .. weird, but okay!
			    }
		        if(isset($oauth_userid) && isset($oauth_username) && isset($oauth_email) && isset($oauth_picture)){
		        	
		        	$fb_auth = OauthFacebook::where('oauth_userid', '=', $oauth_userid)->first();
			        	
			        if(isset($fb_auth->id)){
			        	$user = User::find($fb_auth->user_id);
			        } else {
			        	// Execute Add or Login Oauth User
			        	$user = User::where('email', '=', $oauth_email)->first();

			        	if(!isset($user->id)){
			        		$username = $this->create_username_if_exists($oauth_username);
			        		$email = $oauth_email;
			        		$password = Hash::make($this->rand_string(15));

			        		try{
								$oauth_image = Helper::uploadImage($oauth_picture, 'avatars', $username, 'url');
							} catch(Exception $e) {
								$oauth_image = 'default.jpg';
							}

			        		$user = $this->new_user($username, $email, $password, $oauth_image );

			        		$this->new_user_points($user->id);

			        		$new_oauth_user = new OauthFacebook;
			        		$new_oauth_user->user_id = $user->id;
			        		$new_oauth_user->oauth_userid = $oauth_userid;
			        		$new_oauth_user->save();

			        	} else {
			        		// Redirect and send error message that email already exists. Let them know that they can request to reset password if they do not remember
			        		return Redirect::to('/')->with(array('note' => Lang::get('lang.oauth_email_used'), 'note_type' => 'error'));
			        	}
			        }

		        	// Redirect to new User Login;
		        	Auth::login($user);
		        	$this->add_user_login_point();

		        	return Redirect::to('/')->with(array('note' => Lang::get('lang.facebook_success'), 'note_type' => 'success'));
		        	

		        } else {
		        	// Something went wrong, redirect and send error msg
		        	echo Lang::get('lang.oauth_error');
		        	echo '<br />Info retrieved:<br />';
		        	echo '<br />userid: ' . $oauth_userid;
		        	echo '<br />username: ' . $oauth_username;
		        	echo '<br />email: ' . $oauth_email;
		        	echo '<br />picture: ' . $oauth_picture;
		        }

		    }
		    // if not ask for permission first
		    else {
		        // get fb authorization
		        $url = $fb->getAuthorizationUri();

		        // return to facebook login url
		        return Response::make()->header( 'Location', (string)$url );
		    }
		} else {
			return Redirect::to('/')->with(array('note' => Lang::get('lang.signup_reg_closed'), 'note_type' => 'error'));
		}
	}

	// *********** GOOGLE OAUTH SIGNIN/SIGNUP ********** //

	public function google() {

		$settings = Setting::first();

		if($settings->user_registration){	
		    // get data from input
		    $code = Input::get( 'code' );

		    // get google service
		    $googleService = OAuth::consumer( 'Google' );

		    // check if code is valid

		    // if code is provided get user data and sign in
		    if ( !empty( $code ) ) {

		        // This was a callback request from google, get the token
		        $token = $googleService->requestAccessToken( $code );

		        // Send a request with it
		        $result = json_decode( $googleService->request( 'https://www.googleapis.com/oauth2/v1/userinfo' ), true );
		        // $message = 'Your unique Google user id is: ' . $result['id'] . ' and your name is ' . $result['name'];
		        // dd($result);

		        $oauth_userid = $result['id'];
		        $oauth_username = Helper::slugify($result['name']);
		        $oauth_email = $result['email'];
		        if(!isset($result['picture'])){
		        	$oauth_picture = NULL;
		        } else {
		        	$oauth_picture = $result['picture'];
		        }

		        if(isset($oauth_userid) && isset($oauth_username) && isset($oauth_email)){
		        	
		        	$google_auth = OauthGoogle::where('oauth_userid', '=', $oauth_userid)->first();
			        	
			        if(isset($google_auth->id)){
			        	$user = User::find($google_auth->user_id);
			        } else {
			        	// Execute Add or Login Oauth User
			        	$user = User::where('email', '=', $oauth_email)->first();

			        	if(!isset($user->id)){
			        		$username = $this->create_username_if_exists($oauth_username);
			        		$email = $oauth_email;
			        		$password = Hash::make($this->rand_string(15));

			        		$avatar = ($oauth_picture != NULL) ? Helper::uploadImage($oauth_picture, 'avatars', $username, 'url') : NULL;

			        		$user = $this->new_user($username, $email, $password, $avatar);

			        		$this->new_user_points($user->id);

			        		$new_oauth_user = new OauthGoogle;
			        		$new_oauth_user->user_id = $user->id;
			        		$new_oauth_user->oauth_userid = $oauth_userid;
			        		$new_oauth_user->save();

			        	} else {
			        		// Redirect and send error message that email already exists. Let them know that they can request to reset password if they do not remember
			        		return Redirect::to('/')->with('error', Lang::get('lang.oauth_email_used'));
			        	}
			        }


		        	// Redirect to new User Login;
		        	Auth::login($user);
		        	$this->add_user_login_point();

		        	return Redirect::to('/')->with('success', Lang::get('lang.google_success'));
		        	

		        } else {
		        	// Something went wrong, redirect and send error msg
		        	echo Lang::get('lang.oauth_error');
		        	echo '<br />Info retrieved:<br />';
		        	echo '<br />userid: ' . $oauth_userid;
		        	echo '<br />username: ' . $oauth_username;
		        	echo '<br />email: ' . $oauth_email;
		        	echo '<br />picture: ' . $oauth_picture;
		        }



		    }
		    // if not ask for permission first
		    else {
		        // get googleService authorization
		        $url = $googleService->getAuthorizationUri();

		        // return to facebook login url
		        return Response::make()->header( 'Location', (string)$url );
		    }
		} else {
			return Redirect::to('/')->with(array('note' => Lang::get('lang.signup_reg_closed'), 'note_type' => 'error'));
		}
	}

	// *********** LOOP THROUGH USERNAMES TO RETURN ONE THAT DOESN'T EXIST ********** //

	private function create_username_if_exists($username){
		$user = User::where('username', '=', $username)->first();

		while (isset($user->id)) {
			$username = $username . uniqid();
			$user = User::where('username', '=', $username)->first();
		}

		return $username;
	}

	// *********** RANDOM STRIN GENERATOR ********** //

	private function rand_string( $length ) {

	    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	    return substr(str_shuffle($chars),0,$length);

	}

	// *********** ADD USER LOGIN POINT, ONE PER DAY ********** //

	private function add_user_login_point(){
		$user_id = Auth::user()->id;

		$LastLoginPoints = Point::where('user_id', '=', $user_id)->where('description', '=', Lang::get('lang.daily_login'))->orderBy('created_at', 'desc')->first();
		if(!isset($LastLoginPoints) || date('Ymd') !=  date('Ymd', strtotime($LastLoginPoints->created_at)) ){
			$point = new Point;
			$point->user_id = $user_id;
			$point->description = Lang::get('lang.daily_login');
			$point->points = 5;
			$point->save();
			return true;
		} else {
			return false;
		}
	}

	// *********** ADD USER FLAG ********** //

	public function add_flag(){
		$id = Input::get('user_id');
		$user_flag = UserFlag::where('user_id', '=', Auth::user()->id)->where('user_flagged_id', '=', $id)->first();

		if(isset($user_flag->id)){ 
			$user_flag->delete();
		} else {
			$flag = new UserFlag;
			$flag->user_id = Auth::user()->id;
			$flag->user_flagged_id = $id;
			$flag->save();
			echo $flag;
		}
	}


	// *********** UPDATE USER ********** //

	public function update($id)
	{
		$input = array_except(Input::all(), '_method');
		$input['username'] = str_replace('.', '-', $input['username']);
		$validation = Validator::make($input, User::$update_rules);

		if ($validation->passes())
		{
			$user = $this->user->find($id);

			if(file_exists($input['avatar'])){
            	$input['avatar'] = Helper::uploadImage(Input::file('avatar'), 'avatars');
            } else { $input['avatar'] = $user->avatar; }

            if($input['password'] == ''){
            	$input['password'] = $user->password;
            } else{ $input['password'] = Hash::make($input['password']); }

            if($user->username != $input['username']){
            	$username_exist = User::where('username', '=', $input['username'])->first();
            	if($username_exist){
            		return Redirect::to('user/' .$user->username)->with(array('note' => Lang::get('lang.username_in_use'), 'note_type' => 'error') );
            	}
            }

			$user->update($input);

			return Redirect::to('user/' .$user->username)->with(array('note' => Lang::get('lang.update_user'), 'note_type' => 'success') );
		}

		return Redirect::to('user/' . Auth::user()->username)->with(array('note' => Lang::get('lang.validation_errors'), 'note_type' => 'error') );
		
	}


	// *********** SHOW USER PROFILE ********** //

	public function profile($username){

		$user = User::where('username', '=', $username)->first();
		$medias = Media::where('user_id', '=', $user->id)->orderBy('created_at', 'desc')->paginate(Config::get('site.num_results_per_page'));

		$data = array(
				'user' => $user,
				'media' => $medias,
				);

		return View::make('user.index', $data);
	}

	// *********** SHOW USER PROFILE LIKES ********** //

	public function profile_likes($username){

		$user = User::where('username', '=', $username)->first();
		$medias = MediaLike::where('user_id', '=', $user->id)->orderBy('created_at', 'desc')->paginate(Config::get('site.num_results_per_page'));

		$data = array(
				'user' => $user,
				'media' => $medias,
				'likes' => true,
				);

		return View::make('user.index', $data);
	}

	// ********** USER POINTS PAGE **********  //

	public function points($username){

		$user = User::where('username', '=', $username)->first();

		$data = array(
			'user' => $user,
			'points' => Point::where('user_id', '=', $user->id)->get(),
			);

		return View::make('user.points', $data);
	}

	// ********** RESET PASSWORD ********** //

	public function password_reset()
	{
		return View::make('auth.password_reset');
	}

	// ********** RESET REQUEST ********** //

	public function password_request()
	{
	  $credentials = array('email' => Input::get('email'));
	  return Password::remind($credentials, function($message){
	  	$message->subject('Password Reset Info');
	  });
	}

	// ********** RESET PASSWORD TOKEN ********** //

	public function password_reset_token($token)
	{
	  return View::make('auth.password_reset_form')->with('token', $token);
	}

	// ********** RESET PASSWORD POST ********** //

	public function password_reset_post()
	{
	  $credentials = array('email' => Input::get('email'));
	 
	  return Password::reset($credentials, function($user, $password)
	  {
	    $user->password = Hash::make($password);
	 
	    $user->save();
	 
	    return Redirect::to('signin')->with(array('note' => Lang::get('lang.password_reset'), 'note_type' => 'success'));
	  });
	}

}