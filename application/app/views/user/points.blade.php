@extends('layouts.master')

@section('content')

<?php $user_points = DB::table('points')->where('user_id', '=', $user->id)->sum('points'); ?>

@include('includes.profile-mobile')

<div class="container main_home_container">

	<div class="well col-md-12">

		<div class="col-md-8 col-lg-8" style="padding:0px;">
			<h2><i class="icon-star"></i> {{ Lang::get('lang.user_points', array('username' => $user->username)) }}</h2>
			<p>{{ Lang::get('lang.view_info_about_points') }}</p>

			<br />
			<h3 style="background:#ccc; float:left; padding:11px; margin-top:0px;">{{ Lang::get('lang.user_points', array('username' => $user->username)) }}</h3><p style="padding:10px; line-height:auto; font-size:20px; background:#e3e3e3; float:left">{{ $user_points }}</p>
			<div data-toggle="modal" data-target="#leaderboards" class="pull-left" style="padding:10px; text-decoration:underline; background:#f5f5f5; font-size:14px; cursor:pointer; height:48px; line-height:30px; font-weight:bold;"><i class="fa fa-trophy" style="color:gold; margin-right:5px;"></i>{{ Lang::get('lang.view_leaderboards') }}</div>
			<div style="clear:both"></div>

			<br />
			<div class="table-responsive">
				<table class="table table-condensed">
					<tr>
						<th>{{ Lang::get('lang.points') }}</th>
						<th>{{ Lang::get('lang.description') }}</th>
						<th>{{ Lang::get('lang.time') }}</th>
					</tr>
						@foreach($points as $point)
						<tr>
							<td>{{ $point->points }}</td>
							<td>{{ $point->description }}</td>
							<td>{{ $point->created_at }}</td>
						</tr>
						@endforeach
				</table>
			</div>
		</div>

		@include('includes.profile-sidebar')

	</div>

</div>


@stop

@section('javascript')
	
	@if(!Auth::guest() && Auth::user()->id == $user->id)

		@include('includes.edit-user-profile')

	@endif

	@include('includes.leaderboards')

	
	@include('includes.aboutpoints')

@stop