@extends('layouts.master')

@section('css')
<style type="text/css">
	.item-large{
		width:100%;
	}
</style>

@if(!Auth::guest() && (Auth::user()->admin == 1 || Auth::user()->id == $media->user_id))
	<link rel="stylesheet" href="/application/assets/js/tagsinput/jquery.tagsinput.css" />
@endif

@stop

<?php $settings = Setting::first(); ?>

@section('outer-content')

	@if(isset($settings->random_bar_enabled) && $settings->random_bar_enabled == 1)
	  @include('includes.random-bar')
	@endif

@stop

@section('content')

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


<?php $item = $media; ?>

<div class="container main_home_container single">

	<div class="single-left col-md-8 col-lg-8 col-sm-12">
		
		<div class="col-sm-12 item animated single-left" data-href="{{ URL::to('media') . '/' . $media->id }}">

			@include('includes.media_item')

			<div style="clear:both"></div>

			<?php $media_url = URL::to('media') . '/' . $item->slug; ?>
		
			<div id="below_media">
				<div class="social-icons">
					<ul class="socialcount socialcount-large" data-url="{{ $media_url }}" style="width:100%; position:relative; right:0px">
						<li class="facebook"><a href="https://www.facebook.com/sharer/sharer.php?u={{ $media_url }}" target="_blank" title="{{ Lang::get('lang.share_facebook') }}" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600');return false;"><span class="fa fa-facebook"></span><span class="count">{{ Lang::get('lang.like') }}</span></a></li>
						<li class="twitter" data-share-text="{{ $media->title }}"><a href="https://twitter.com/intent/tweet?url={{ $media_url }}&text={{ $media->title }}" data-url="{{ $media_url }}" title="{{ Lang::get('lang.share_twitter') }}" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600');return false;"><span class="fa fa-twitter" data-url="{{ $media_url }}"></span><span class="count">{{ Lang::get('lang.tweet') }}</span></a></li>
						<li class="googleplus"><a href="https://plus.google.com/share?url={{ $media_url }}" target="_blank" title="{{ Lang::get('lang.share_google') }}" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600');return false;"><span class="fa fa-google-plus"></span><span class="count">{{ Lang::get('lang.plus_one') }}</span></a></li>
						<li class="pinterest"><a href="//www.pinterest.com/pin/create/button/?url={{ $media_url }}&media={{ URL::to('/') . '/content/uploads/images/' . $media->pic_url }}&description={{ $media->title }}" title="{{ Lang::get('lang.pin_it') }}" target="_blank" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600');return false;"><span class="fa fa-pinterest"></span><span class="count">{{ Lang::get('lang.pin_it') }}</span></a></li>
					</ul>
				</div>

				@if(!Auth::guest())
					<?php $flagged = MediaFlag::where('user_id', '=', Auth::user()->id)->where('media_id', '=', $media->id)->first(); ?>
					<div class="media-flag pull-right border-radius @if(isset($flagged->id)) active @endif" data-id="{{ $media->id }}" style="margin-top:5px;"><i class="fa fa-flag"></i> <span class="media-flag-desc">@if(isset($flagged->id)){{ Lang::get('lang.flagged') }}@else{{ Lang::get('lang.flag_this') }}@endif</span></div>
				@endif

				@if(isset($item->link_url) && $item->link_url != '')
					<a href="{{ $item->link_url }}" target="_blank" class="label label-success" style="margin-top:6px;"><i class="fa fa-globe"></i> {{ Lang::get('lang.source') }}</a>
				@endif

				@if(!Auth::guest() && (Auth::user()->admin == 1 || Auth::user()->id == $item->user_id))
				
				<div class="edit-delete">
					<a href="#_" data-href="{{ URL::to('media/delete') . '/' . $item->id }}" onclick="confirm_delete(this)" class="label label-danger"><i class="icon-trash"></i> {{ Lang::get('lang.delete') }}</a>
					<a href="#_" data-toggle="modal" data-target="#edit-modal" class="label label-warning"><i class="icon-edit"></i> {{ Lang::get('lang.edit') }}</a>
				</div>
				@endif
			</div>
		

			<div style="clear:both"></div>

			<h3 class="comment-type site active" data-comments="#current_comments">{{ Lang::get('lang.site_comments') }} (<span class="current_comment_count site_comments">{{ $media->comments()->get()->count() }}</span>)</h3>
			<h3 class="comment-type facebook" data-comments="#facebook_comments">{{ Lang::get('lang.facebook_comments') }} (<span class="current_comment_count"><fb:comments-count href="{{ Request::url() }}"></fb:comments-count></span>)</h3>

			<div id="facebook_comments">
				<div class="fb-comments" data-href="{{ Request::url() }}" data-width="660" data-numposts="5" data-colorscheme="light"></div>
			</div>

			<div id="current_comments">

				<div class="comment-submit">
					@if(Auth::guest())
						<h2 style="padding-left:0px; text-align:center;">{{ Lang::get('lang.sign_in_to_comment', array('before_signin' => '<a href="' . URL::to("signin") . '">', 'after_signin' => '</a>', 'before_signup' => '<a href="' . URL::to("signup") . '">', 'after_signup' => '</a>')) }}</h2>
					@else
						<h5>{{ Lang::get('lang.add_a_comment') }}</h5>
						<img src="{{ URL::to('/') }}/content/uploads/avatars/{{ Auth::user()->avatar }}" class="user-avatar-small img-rounded" style="width:8.5%; margin-right:1.5%" /><textarea placeholder="{{ Lang::get('lang.write_comment_here') }}" class="form-control" style="border-width:2px; width:90%;" id="comment"></textarea>
						<div class="btn pull-right btn-color" style="margin-top:15px;" id="comment-submit">{{ Lang::get('lang.post_comment_btn') }}</div><div style="clear:both"></div>
						<input type="hidden" name="media_id" id="media_id" value="{{ $media->id }}" />
					@endif
				</div>
				<div style="clear:both"></div><br />
				<div class="comment-loop">
				@foreach($media->comments()->orderBy('created_at', 'desc')->get() as $comment)

					<div class="comment comment-{{ $comment->id }}">
						
						@if(!Auth::guest())
							<?php $user_vote = CommentVote::where('user_id', '=', Auth::user()->id)->where('comment_id', '=', $comment->id)->first(); ?>
						@endif

						<div class="comment_vote pull-left">
							<i class="fa fa-chevron-up vote-up @if(isset($user_vote->up) && $user_vote->up) active @endif" data-commentid="{{ $comment->id }}"></i>
							<p>{{ $comment->totalVotes() }}</p>
							<i class="fa fa-chevron-down vote-down @if(isset($user_vote->down) && $user_vote->down == 1) active @endif" data-commentid="{{ $comment->id }}"></i>
						</div>

						@if(!Auth::guest())
							
							<div class="flag_edit_delete_comment">
								<a class="flag_comment" data-id="{{ $comment->id }}"><i class="fa fa-flag"></i> + <span class="num_flags">{{ $comment->totalFlags() }}</span></a>@if(Auth::user()->id == $comment->user_id  || Auth::user()->admin == 1)<a class="edit_comment" data-id="{{ $comment->id }}"><i class="fa fa-edit"></i></a><a class="delete_comment" data-id="{{ $comment->id }}"><i class="fa fa-trash-o"></i></a>@endif
							</div>

						@endif

						<div class="comment_container border-radius" data-id="{{ $comment->id }}">
							
							<a href="{{ URL::to('user') . '/' . $comment->user()->username }}"><img src="{{ URL::to('/') }}/content/uploads/avatars/{{ $comment->user()->avatar }}" class="user-avatar-small img-circle" /></a>
							<div class="comment_info">
								<p class="timeago" title="{{ date('F j, Y, g:i a', strtotime($comment->updated_at)) }}">{{ date('F j, Y, g:i a', strtotime($comment->created_at)) }}</p>
								<h4><a href="{{ URL::to('user') . '/' . $comment->user()->username }}">{{ $comment->user()->username }}</a> {{ Lang::get('lang.wrote') }}:</h4>
							</div>
							<p class="comment_data">{{ $comment->comment }}</p>

						</div>
					</div>

				@endforeach
				</div>

			</div><!-- #current_comments -->

		</div>

	</div>


	<input type="hidden" id="user_media" name="user_media" value="@if(!Auth::guest() && Auth::user()->id == $media->user_id){{ 'true' }}@else{{ 'false' }}@endif" />
	<input type="hidden" id="user_id" name="user_id" value="@if(!Auth::guest()){{ Auth::user()->id }}@else0@endif" />
	@include('media.show-sidebar')

</div>


<script type="text/javascript" src="/application/assets/js/imgLiquid-min.js"></script>
@include('media.show-javascript')

@stop

@section('javascript')
	@if(!Auth::guest() && (Auth::user()->admin == 1 || Auth::user()->id == $item->user_id))
		@include('media.show-edit-media')
	@endif
	
@stop

