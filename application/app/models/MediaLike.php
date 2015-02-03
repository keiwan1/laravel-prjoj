<?php

class MediaLike extends Eloquent {

	protected $table = 'media_likes';
	protected $guarded = array();
	public static $rules = array();

	public function user(){
		return $this->belongsTo('User')->first();
	}

	public function media(){
		return $this->belongsTo('Media')->first();
	}

}
