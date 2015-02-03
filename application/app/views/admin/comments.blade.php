	<div class="white_container">
		
		<h2 style="margin-bottom:20px;"><i class="fa fa-comments"></i><span> {{ Lang::get('lang.comments') }}</span></h2>

		<div class="table-responsive">
			<table class="table table-striped">
				<tr class="table-header">
					<th>{{ Lang::get('lang.comment') }}</th>
					<th>{{ Lang::get('lang.votes') }}</th>
					<th>{{ Lang::get('lang.num_of_flags') }}</th>
					<th>{{ Lang::get('lang.actions') }}</th>
					@foreach($comments as $comment)
					<tr>
						<td><a href="{{ URL::to('media') . '/' . @$comment->media()->slug }}" target="_blank">
							<?php if(strlen($comment->comment) > 40){
									echo substr($comment->comment, 0, 40) . '...';
								  } else {
								  	echo $comment->comment;
								  }
							?>
							</a>
						</td>
						<td>
							{{ $comment->totalVotes() }}
						</td>
						<td>
							{{ $comment->totalFlags() }}
						</td>
						<td>
							<a href="{{ URL::to('comments/delete') . '/' . $comment->id }}" class="btn btn-xs btn-danger"><span class="fa fa-trash-o"></span> {{ Lang::get('lang.delete') }}</a>
						</td>
						
					</tr>
					@endforeach
			</table>
		</div>
		
	</div>