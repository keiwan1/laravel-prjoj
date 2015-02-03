<?php

class UserFlag extends Eloquent {

	protected $table = 'user_flags';
	protected $guarded = array();
	public static $rules = array();

	public function user(){
		return $this->belongsTo('User', 'user_flagged_id')->first();
	}

}
