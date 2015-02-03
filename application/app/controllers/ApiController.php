<?php

class ApiController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	// ********** Main API page ********** //

	public function getIndex()
	{
		echo 'API Configuration Coming Soon';
	}

	// ********** API to show all media ********** //

	public function getMedia(){
		$media = Media::all();
		return Response::json($media);
	}

	// ********** API to show comments based on media ********** //

	public function getComments($id){
		$comments = Comment::where('media_id', '=', $id)->get();
		return Response::json($comments);
	}

	// ********** API to show comment votes for a specific comment ********** //

	public function getCommentvotes($id){
		$upVotes = DB::table('comment_votes')->where('comment_id', '=', $id)->sum('up');
		$downVotes = DB::table('comment_votes')->where('comment_id', '=', $id)->sum('down');
		$totalVotes = $upVotes - $downVotes;
		return Response::json($totalVotes);
	}

	// ********** API to show comment flags from comment ********** //

	public function getCommentflags($id){
		$num_flags = DB::table('comment_flags')->where('comment_id', '=', $id)->count();
		return Response::json($num_flags);
	}

	// ********** API to show media based on media ID ********** //

	public function getMediaflags($id){
		$num_flags = DB::table('media_flags')->where('media_id', '=', $id)->count();
		return Response::json($num_flags);
	}

}