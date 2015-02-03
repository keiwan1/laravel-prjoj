<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	protected $fillable = array('username', 'email', 'password', 'avatar');

	public static $update_rules = array(
    	'username' => 'required|alpha_dash|min:3',
        'email' => 'required|email'
	);	

	public function totalQuestions(){
		return DB::table('media')->where('user_id', '=', $this->id)->count();
	}

	public function totalPoints(){
		return DB::table('points')->where('user_id', '=', $this->id)->sum('points');
	}

	public function totalAnswers(){
		return DB::table('comments')->where('user_id', '=', $this->id)->count();
	}

	public function totalVotes(){
		return DB::table('user_flags')->where('user_flagged_id', '=', $this->id)->count();
	}

	public function totalFlagged(){
		return DB::table('media_flags')->where('user_id', '=', $this->id)->count();
	}

	public function totalLikes(){
		return DB::table('media_likes')->where('user_id', '=', $this->id)->count();
	}

	public function totalFlags(){
		return DB::table('user_flags')->where('user_flagged_id', '=', $this->id)->count();
	}

	public function getFbID(){
		return DB::table('oauth_facebook')->where('user_id', '=', $this->id)->first()->oauth_userid;
	}
	

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

}