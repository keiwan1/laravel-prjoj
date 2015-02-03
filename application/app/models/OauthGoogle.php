<?php

class OauthGoogle extends Eloquent {
	protected $table = 'oauth_google';

	protected $guarded = array();

	public static $rules = array();

	public function user(){
		return $this->belongsTo('User')->first();
	}
}
