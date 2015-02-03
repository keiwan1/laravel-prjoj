<?php

class Media extends Eloquent {

	protected $table = 'media';
	
	protected $guarded = array();

	public static $rules = array(
		'user_id' => 'required',
		'title' => 'required'
	);

	public function category(){
		return $this->belongsTo('Category');
	}

	public function comments(){
		return $this->hasMany('Comment');
	}

	public function user(){
		return $this->belongsTo('User')->first();
	}

	public function totalFlags(){
		return DB::table('media_flags')->where('media_id', '=', $this->id)->count();
	}

	public function totalLikes(){
		return DB::table('media_likes')->where('media_id', '=', $this->id)->count();
	}

	public function media_likes(){
		return $this->hasMany('MediaLike');
	}

	public function totalComments(){
		return DB::table('comments')->where('media_id', '=', $this->id)->count();
	}
}
