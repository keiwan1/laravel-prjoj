@extends('layouts.master')

<?php $settings = Setting::first(); ?>

@section('css')
	<style type="text/css">

		.navbar.gallery-sub-header{
			display:none;
		}

		.item-large{
			width:100%;
			margin:0px auto;
		}

		div.pagination{
			padding-left:90px;
			padding-right:80px;
		}

	</style>


	@if($settings->infinite_scroll)
		<style type="text/css">
			div.pagination{
				visibility:hidden;
			}
		</style>
	@endif
@stop

@section('outer-content')
	<?php $user_points = DB::table('points')->where('user_id', '=', $user->id)->sum('points'); ?>
	@include('includes.profile-mobile')
@stop

@section('content')

<?php $settings = Setting::first(); ?>

<div class="container main_home_container">


	<div class="well col-md-12">

	<div id="media" class="col-md-8 col-lg-8" style="display:block; clear:both; margin:0px auto; padding:0px; background:#fff; padding-bottom:70px;">

		@if(count($media) == 0)
			<h2 style="padding:10px 0px;"><i class="fa-meh-o fa"></i> @if(isset($likes)){{ Lang::get('lang.no_likes_yet') }}@else{{ Lang::get('lang.no_uploads_yet') }}@endif</h2>
		@endif

		@foreach($media as $item)

			<?php
			if(isset($likes)){
			 	$item = $item->media();
			} 
			?>

			  
			<div class="col-sm-12 item animated single-left" data-href="{{ URL::to('media') . '/' . $item->id }}">

				@include('includes.media_item')

			</div>
			  

		@endforeach	
		
		<div style="clear:both"></div>
		@include('includes.pagination')	

	</div><!-- #media -->


	@include('includes.profile-sidebar')


</div>

	</div>

</div>

@if(!Auth::guest() && Auth::user()->id == $user->id)

	@include('includes.edit-user-profile')

@endif

@include('includes.aboutpoints')


<script type="text/javascript">

	$(document).ready(function(){

		$('.hover_tooltip').tooltip({ placement: 'bottom' });

		$('.flag-user').click(function(){
				this_object = $(this);
				$.post("{{ URL::to('user') . '/add_flag' }}", { user_id: $(this).data('id') }, function(data){
					
					$.getJSON("{{ URL::to('api') . '/commentflags/' }}" + String($(this_object).data('id')), function(data){
						flagged_user = "{{ Lang::get('lang.flagged_this_user') }}";
						flag_user = "{{ Lang::get('lang.flag_user') }}";
						if($(this_object).find('.flag-message').text() == flagged_user)
						{	
							$(this_object).find('.flag-message').text(flag_user);
						} else {
							$(this_object).find('.flag-message').text(flagged_user);
						}
					});
				});
			});
	});

</script>

@include('includes.media-list-javascript')

@stop