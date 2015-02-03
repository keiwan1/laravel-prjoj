<?php

class OauthFacebook extends Eloquent {

	protected $table = 'oauth_facebook';

	protected $guarded = array();

	public static $rules = array();

	public function user(){
		return $this->belongsTo('User')->first();
	}
}
