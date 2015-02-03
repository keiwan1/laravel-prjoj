<?php

class Page extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'title' => 'required',
		'body' => 'required'
	);

	public function totalPages(){
		return DB::table('pages')->count();
	}
}
