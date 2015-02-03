<?php

class CommentsController extends BaseController {


	/**
	 * Comment Repository
	 *
	 * @var Comment
	 */
	protected $comment;

	public function __construct(Comment $comment)
	{
		$this->comment = $comment;
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return View::make('comments.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('comments.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Comment::$rules);

		if ($validation->passes())
		{
			$last_comment = Comment::where('user_id', '=', Auth::user()->id)->orderBy('created_at', 'desc')->first();
			$current_date = new DateTime(date("Y-m-d H:i:s"));

			if(empty($last_comment)){
				$interval = 5;
			} else {
				$interval = $current_date->diff($last_comment->created_at);
				$interval = intval($interval->format('%i'));
			}
			if($interval >= 3){
			
				$this->add_daily_comment_points();

				$comment = new Comment;
				$comment->media_id = $input['media_id'];
				$comment->comment = htmlspecialchars($input['comment']);
				$comment->user_id = Auth::user()->id;
				$comment->save();

				echo $comment;
			} else {
				echo 0;
			}
		} else {

			echo 0;

		}
	}


	// ADD Daily Points for commenting max 5 per day //

	private function add_daily_comment_points(){
		$user_id = Auth::user()->id;

		$LastCommentPoints = Point::where('user_id', '=', $user_id)->where('description', '=', Lang::get('lang.daily_comment'))->orderBy('created_at', 'desc')->take(5)->get();
		
		$total_daily_comments = 0;
		foreach($LastCommentPoints as $CommentPoint){
			if( date('Ymd') ==  date('Ymd', strtotime($CommentPoint->created_at)) ){
				$total_daily_comments += 1;
			}
		}

		if($total_daily_comments < 5){
			$point = new Point;
			$point->user_id = $user_id;
			$point->description = Lang::get('lang.daily_comment');
			$point->points = 1;
			$point->save();
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        return View::make('comments.show');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        return View::make('comments.edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		if (Request::ajax())
		{
			$comment = Comment::find($id);
			if(Auth::user()->id == $comment->user_id){
				$comment->comment = htmlspecialchars(Input::get('comment'));
				$comment->save();
			}
		}
	}

	// Vote Up for comment

	public function vote_up(){
		$id = Input::get('comment_id');
		$comment_vote = CommentVote::where('user_id', '=', Auth::user()->id)->where('comment_id', '=', $id)->first();

		if(isset($comment_vote->id)){ 
			$comment_vote->up = 1;
			$comment_vote->down = 0;
			$comment_vote->save();
			echo $comment_vote;
		} else { 
			$vote = new CommentVote;
			$vote->user_id = Auth::user()->id;
			$vote->comment_id = $id;
			$vote->up = 1;
			$vote->save();
			echo $vote;
		}
	}

	// Vote Flag for comment

	public function add_flag(){
		$id = Input::get('comment_id');
		$comment_flag = CommentFlag::where('user_id', '=', Auth::user()->id)->where('comment_id', '=', $id)->first();

		if(isset($comment_flag->id)){ 
			$comment_flag->delete();
		} else {
			$flag = new CommentFlag;
			$flag->user_id = Auth::user()->id;
			$flag->comment_id = $id;
			$flag->save();
			echo $flag;
		}
	}

	// Vote Down for comment

	public function vote_down(){
		$id = Input::get('comment_id');
		$comment_vote = CommentVote::where('user_id', '=', Auth::user()->id)->where('comment_id', '=', $id)->first();

		if(isset($comment_vote->id)){ 
			$comment_vote->up = 0;
			$comment_vote->down = 1;
			$comment_vote->save();
			echo $comment_vote;
		} else { 
			$vote = new CommentVote;
			$vote->user_id = Auth::user()->id;
			$vote->comment_id = $id;
			$vote->down = 1;
			$vote->save();
			echo $vote;
		}
	}

	// Admin Delete Comment

	public function delete($id){
		if($this->delete_comment($id) == 1){

		}
		return Redirect::to('admin?section=comments')->with(array('note' => Lang::get('lang.delete_comment_success'), 'note_type' => 'success') );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if (Request::ajax())
		{
			$this->delete_comment($id);
		}
	}

	// Delete Comment from single media page

	public function delete_comment($id){
		$comment = Comment::find($id);
		if(Auth::user()->id == $comment->user_id || Auth::user()->admin == 1){

			$comment_votes = CommentVote::where('comment_id', '=', $id)->get();
			foreach($comment_votes as $votes){
				$votes->delete();
			}

			$comment_flags = CommentFlag::where('comment_id', '=', $id)->get();
			foreach($comment_flags as $flag){
				$flag->delete();
			}

			$comment->delete();
			echo 1;
		} else {
			echo 0;
		}
	}

}
