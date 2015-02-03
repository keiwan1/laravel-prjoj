<?php $settings = Setting::first(); ?>
<div class="col-md-12 col-lg-12" id="profile-mobile">
	<div class="profile-container">
		
		@if(!Auth::guest() && Auth::user()->id == $user->id)
			<?php 
				$my_or_user_uploads = Lang::get('lang.my_uploads');
				$my_or_user_likes = Lang::get('lang.my_likes');
					$is_user_profile = true;
			?>
		@else
			<?php 
				$my_or_user_uploads = Lang::get('lang.your_uploads');
				$my_or_user_likes = Lang::get('lang.your_likes');
				$is_user_profile = false;
			?>
		@endif

		<a href="{{ URL::to('user/' . $user->username ) }}"><img src="{{ URL::to('') }}/content/uploads/avatars/{{ $user->avatar }}" alt="{{ $user->username }}" class="img-circle user-avatar-large"></a>
		<h2>{{ $user->username }} @if($is_user_profile) <i class="fa fa-edit" data-toggle="modal" data-target="#edit-modal" style="cursor:pointer;"></i>@endif</h2>
		<p><i class="fa fa-star" style="color:gold"></i> <a href="{{ URL::to('user/' . $user->username . '/points' ) }}"">{{ $user_points }} points</a> <i class="fa fa-question-circle points-question" style="cursor:pointer" data-toggle="modal" data-target="#aboutpoints"></i></p>
		<p>{{ Lang::get('lang.member_since') }}: {{ date("F j, Y", strtotime($user->created_at)) }}</p>
		@if(!Auth::guest() && Auth::user()->id != $user->id)
			<?php $user_flag = UserFlag::where('user_id', '=', Auth::user()->id)->where('user_flagged_id', '=', $user->id)->first(); ?>
			<div class="flag-user" data-id="{{ $user->id }}"><i class="fa fa-flag"></i> <span class="flag-message">@if(isset($user_flag->id)) {{ Lang::get('lang.flagged_this_user') }} @else {{ Lang::get('lang.flag_user') }} @endif</span></div>
		@endif

		<div class="user-btn-group">
			<div class="btn-group vid-pic" data-toggle="buttons" style="margin-bottom:5px;">
			  <label class="btn btn-default @if(Request::is('user/' . $user->username )) active @endif user_profile_view" data-href="{{ URL::to('user/' . $user->username ) }}" style="line-height:20px;">
			    <input type="radio" name="user_profile" id="uploads"> <i class="fa icon-cloud-upload" style="font-size:14px; margin-right:4px;"></i> {{ $my_or_user_uploads }}
			  </label>
			  <label class="btn btn-default @if(Request::is('user/' . $user->username .'/likes')) active @endif user_profile_view" data-href="{{ URL::to('user/' . $user->username . '/likes/' ) }}" style="line-height:20px;">
			    <input type="radio" name="user_profile" id="likes"> <i class="fa {{ $settings->like_icon }}" style="font-size:14px; margin-right:4px;"></i> {{ $my_or_user_likes }}
			  </label>
			</div>
		</div>

	</div>
</div>



<div style="clear:both"></div>


<script type="text/javascript">
	$(document).ready(function(){

		$('.user_profile_view').click(function(){
			window.location = $(this).data('href');
		});

		$('points-question').tooltip('show')

	});
</script>