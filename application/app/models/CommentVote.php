<?php

class CommentVote extends Eloquent {

	protected $table = 'comment_votes';
	protected $guarded = array();

	public static $rules = array();
}
