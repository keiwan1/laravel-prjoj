<!-- Edit User Profile -->

	<div class="modal fade" id="leaderboards" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-trophy" style="color:gold;"></i> {{ Lang::get('lang.leaderboards') }}</h4>
	      </div>
	      <div class="modal-body">
	      
	      	<?php $leaders = User::join('points', 'users.id', '=', 'points.user_id')->groupBy('points.user_id')->orderBy(DB::raw('SUM(points.points)'), 'DESC')->select('users.*')->get(); ?>

	      	<?php //print_r($leaders); die(); ?>
	      	<ul>
	      		@foreach($leaders as $user)

	      			<li style="color:#f1f1f1; line-height:30px; display:block; width:100%; margin:20px auto;">
	      				<a href="{{ URL::to('user/' . $user->username ) }}" style="display:block; float:left; width:130px; overflow:hidden;"><img src="{{ URL::to('') }}/content/uploads/avatars/{{ $user->avatar }}" alt="{{ $user->username }}" class="img-circle user-avatar-small" style="margin-right:10px; display:block; float:left;"> {{ $user->username }} </a><div style="float:left; margin-right:150px; color:#333"><i class="fa fa-star" style="color:gold"></i> {{ $user->totalPoints() }}</div>
	      			</li>
	      			<div style="clear:both"></div>

	      		@endforeach
	      	</ul>

	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('lang.close') }}</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

<!-- End Edit User Profile -->