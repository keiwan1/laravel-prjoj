@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="/application/assets/js/tagsinput/jquery.tagsinput.css" />
    <link rel="stylesheet" href="/application/assets/js/jquery-minicolors/jquery.minicolors.css" />
    <link rel="stylesheet" href="/application/assets/css/admin.css" />
@stop

@section('outer-content')

	<h2 class="subheader">
		<div class="container">
			<i class="fa fa-coffee"></i> {{ Lang::get('lang.admin_functionality') }}</h2>
		</div>
	</h2>

@stop

@section('content')


<div class="container admin">

	<div class="col-md-3 col-lg-3 admin-left">

		@include('admin.sections.version')
		
		<div class="row">
			<div class="col-md-12">
				<a class="admin-block rounded-top-left rounded-top-right @if(!Input::get('section') || Input::get('section') == 'media') active @endif" data-section="media" style="background:#cb9800" href="{{ URL::to('admin/media') }}">
					<i class="fa fa-picture-o"></i><span>{{ Lang::get('lang.media') }} ({{ count(Media::all()) }})</span>
				</a>
			</div>

			<div class="col-md-12">
				<a class="admin-block @if(Input::get('section') == 'comments') active @endif" data-section="comments" style="background:#98cb00" href="{{ URL::to('admin/comments') }}">
					<i class="fa fa-comments"></i><span>{{ Lang::get('lang.comments') }} ({{ count(Comment::all()) }})</span>
				</a>
			</div>

			<div class="col-md-12">
				<a class="admin-block @if(Input::get('section') == 'users') active @endif" data-section="users" style="background:#0098cb" href="{{ URL::to('admin/users') }}">
					<i class="fa fa-user"></i><span>{{ Lang::get('lang.users') }} ({{ count(User::all()) }})</span>
				</a>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<a class="admin-block @if(Input::get('section') == 'categories') active @endif" data-section="categories" style="background:#bb00c0" href="{{ URL::to('admin/categories') }}">
					<i class="fa fa-list"></i><span>{{ Lang::get('lang.categories') }} ({{ count(Category::all()) }})</span>
				</a>
			</div>

			<div class="col-md-12">
				<a class="admin-block @if(Input::get('section') == 'pages') active @endif" data-section="pages" style="background:#D12362" href="{{ URL::to('admin/pages') }}">
					<i class="fa fa-file"></i><span>{{ Lang::get('lang.pages') }} (beta*)</span>
				</a>
			</div>

			<div class="col-md-12">
				<a class="admin-block @if(Input::get('section') == 'settings') active @endif" data-section="settings" style="background:#333344" href="{{ URL::to('admin/settings') }}">
					<i class="fa fa-cog"></i><span>{{ Lang::get('lang.settings') }}</span>
				</a>
			</div>

			<div class="col-md-12">
				<a class="admin-block rounded-bottom-left rounded-bottom-right @if(Input::get('section') == 'custom_code') active @endif" data-section="custom_code" style="background:#889966" href="{{ URL::to('admin/custom_css') }}">
					<i class="fa fa-code"></i><span>{{ Lang::get('lang.custom_code') }}</span>
				</a>
			</div>

			
		</div>
		
	</div>

	<div id="admin_section" class="col-md-9">

	</div>

	@if(Input::get('sort') != '' && Input::get('order') != '')
		<input type="hidden" id="sort_order" value="{{ '?sort=' . Input::get('sort') . '&order=' . Input::get('order') }}" />
	@else
		<input type="hidden" id="sort_order" value="" />
	@endif

</div>

@stop

@section('javascript')

	<script type="text/javascript">

		$('document').ready(function(){
			$('a.admin-block').bind('click', function(e) {
				$('a.admin-block.active').removeClass('active');
				$(this).addClass('active');
				//window.location.href = '/?section=comments';
			  var url = $(this).attr('href');
			  $('div#admin_section').load(url + $('#sort_order').val()); // load the html response into a DOM element
			  e.preventDefault(); // stop the browser from following the link
			});

			$('a.admin-block.active').trigger('click');
		});

	</script>

@stop

