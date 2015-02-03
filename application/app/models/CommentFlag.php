<?php

class CommentFlag extends Eloquent {

	protected $table = 'comment_flags';
	protected $guarded = array();
	public static $rules = array();

	public function comment(){
		return $this->belongsTo('Comment')->first();
	}

}
