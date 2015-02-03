<div class="item-large">
  	<div class="single-title">
  		@if($item->user())
  			<?php $user_url = URL::to('user') . '/' . $item->user()->username;
  				  $username = $item->user()->username;
  				  $user_avatar = URL::to('/') . '/content/uploads/avatars/' . $item->user()->avatar;
  			?>
  		@else
  			<?php $user_url = '#_';
  				  $username = Lang::get('lang.anonymous');
  				  $user_avatar = URL::to('/') . '/content/uploads/avatars/default.jpg';
  			?>
  		@endif

			<a href="{{ $user_url }}"><img src="{{ $user_avatar }}" class="img-circle user-avatar-medium" /></a><h2 class="item-title"><a href="{{ URL::to('media') . '/' . $item->slug; }}" alt="{{ $item->title }}">{{{ stripslashes($item->title) }}}</a></h2>
			<div class="item-details">
				<p class="details">{{ Lang::get('lang.submitted_by') }}: <a href="{{ $user_url }}">{{ $username}}</a> {{ Lang::get('lang.submitted_on') }} {{ date("F j, Y", strtotime($item->created_at)) }}</p>
				<p class="home-like-count"><i class="fa {{ $settings->like_icon }}"></i> <span>{{ $item->totalLikes() }}</span></p>
				<p class="home-comment-count"><i class="fa fa-comments"></i> {{ $item->totalComments() }}</p>
				<p class="home-view-count"><i class="fa fa-eye"></i> @if(isset($view_increment) && $view_increment == true ){{ $item->views + 1 }}@else{{ $item->views }}@endif </p>
			</div>
			@if(!Auth::guest())
				<?php $liked = MediaLike::where('user_id', '=', Auth::user()->id)->where('media_id', '=', $item->id)->first(); ?> 
			@endif
			<div class="home-media-like @if(isset($liked->id)) active @endif" data-authenticated="@if(Auth::guest()){{ 'false' }}@else{{ 'true' }}@endif" data-id="{{ $item->id }}"><i class="fa {{ $settings->like_icon }}"></i></div>
		
	</div>

	<div class="clear"></div>

	@if($item->nsfw != 0 && Auth::guest())

		<div class="nsfw-container">
			<h1>NSFW!</h1>
			<p>This content has been marked as Not Safe For Work, login to view this content</p>
			<div class="nsfw-login-signup">
				<a href="{{ URL::to('signin') }}?redirect={{ URL::to('media') . '/' . $item->slug; }}" class="btn btn-color nsfw-login">login</a>
				<span>or</span>
				<a href="{{ URL::to('signup') }}?redirect={{ URL::to('media') . '/' . $item->slug; }}" class="btn btn-color">signup</a>
			</div>
		</div>
	
	@else
	
		@if($item->vid != 1)
			@if(strpos($item->pic_url, '.gif') > 0)
				<div class="animated-gif">
					<img class="single-media animation" alt="..." src="{{ URL::to('/') . '/content/uploads/images/' . $item->pic_url }}" data-animation="{{ URL::to('/') . '/content/uploads/images/' . str_replace('.gif', '-animation.gif', $item->pic_url) }}" data-original="{{ URL::to('/') . '/content/uploads/images/' . $item->pic_url }}" data-state="0" />
					<img style="display:none" src="{{ URL::to('/') . '/content/uploads/images/' . str_replace('.gif', '-animation.gif', $item->pic_url) }}" />
					<p class="gif-play"><i class="fa fa-play-circle-o"></i></p>
				</div>
			@else
				<a href="{{ URL::to('media') . '/' . $item->slug; }}" alt="{{ $item->title }}"><img class="single-media" alt="..." src="{{ URL::to('/') . '/content/uploads/images/' . $item->pic_url }}" /></a>
			@endif
		@else
			
			<div class="video_container">

				<!-- YOUTUBE VIDEO -->
				@if (strpos($item->vid_url, 'youtube') > 0 || strpos($item->vid_url, 'youtu.be') > 0)
			        
					<iframe title="YouTube video player" class="youtube-player" type="text/html" width="640"
	height="360" src="http://www.youtube.com/embed/{{ Youtubehelper::extractUTubeVidId($item->vid_url); }}?theme=light&rel=0" frameborder="0"
	allowFullScreen></iframe>

			   

			    <!-- VIMEO VIDEO -->
			    @elseif (strpos($item->vid_url, 'vimeo') > 0)
			        <?php $vimeo_id = (int)substr(parse_url($item->vid_url, PHP_URL_PATH), 1); ?>
			        <iframe src="//player.vimeo.com/video/{{ $vimeo_id; }}" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
			    
			    <!-- VINE Video -->
			    @elseif (strpos($item->vid_url, 'vine') > 0)
			    	<?php $include_embed = (strpos($item->vid_url, '/embed') > 0) ? '' : '/embed'; ?>
			    	<img class="single-media vine-thumbnail" style="cursor:pointer;" alt="..." src="{{ URL::to('/') . '/content/uploads/images/' . $item->pic_url }}" data-embed="{{ $item->vid_url . $include_embed }}/simple?audio=1" />
			    	<p class="vine-thumbnail-play" data-embed="{{ $item->vid_url . $include_embed }}/simple?audio=1" style="color:#fff; color:rgba(255, 255, 255, 0.6); font-size:50px; position:absolute; z-index:999; width:50px; height:50px; top:50%; left:50%; margin:0px; padding:0px; margin-left:-30px; margin-top:-30px; cursor:pointer;"><i class="fa fa-play-circle-o"></i></p>
			    	
			    @endif

				


			</div>
		@endif

	@endif 

	<!-- end NSFW IF -->

	@if($settings->media_description && isset($item->description) && !empty($item->description))
		<p class="media_description"><i class="fa fa-quote-left"></i> {{ $item->description }}</p>
	@endif
</div><!-- item-large -->