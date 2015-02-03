@extends('layouts.master')

<?php $settings = Setting::first(); ?>

@section('css')

@if($settings->infinite_scroll)
	<style type="text/css">
		div.pagination{
			visibility:hidden;
		}
	</style>
@endif

@stop

@section('outer-content')

	@if(isset($settings->random_bar_enabled) && $settings->random_bar_enabled == 1)
	  @include('includes.random-bar')
	@endif

@stop

@section('content')


<div class="navbar gallery-sub-header" style="z-index:9;">
  <div class="container">
    <div class="pull-left desc-follow">

    	<p class="website_desc pull-left">{{ $settings->website_description }}</p> 

    	@include('includes.home-social')

    </div>

    <form class="navbar-form pull-right search-form col-xs-12" role="search" style="margin:0px; padding-top:4px;" action="{{ URL::to('/') }}" method="GET">
            <div class="form-group">
              <input type="text" class="form-control" name="search" placeholder="{{ Lang::get('lang.search') }}" style="-webkit-border-radius: 20px; -moz-border-radius: 20px; border-radius: 20px; height:30px;">
            </div>
          </form>

  </div>
</div>

	@if(isset($search))
		<h4 class="container search-text">{{ Lang::get('lang.search_results_for') }}: {{ $search }}</h4>
		<style type="text/css">.main_home_container{ padding-top:0px; }</style>
	@endif

	<div class="container main_home_container main_home">

	

		<div id="media" class="col-md-8 col-lg-8" style="display:block; clear:both; margin:0px auto; padding:0px; background:#fff; padding-bottom:70px;">

		<?php $count = 1; ?>
		@foreach($media as $item)

			  
			<div class="col-sm-12 item animated single-left" data-href="{{ URL::to('media') . '/' . $item->id }}" data-id="{{ $item->id }}">
				
				<?php $media_url = URL::to('media') . '/' . $item->slug; ?>

				<div class="social_container" style="width:12%; float:left; top:0px;">
					 <ul class="socialcount socialcount-large" data-url="{{ $media_url }}" style="width:60px; margin-top:80px; position:relative; right:0px">
						<li class="facebook"><a href="https://www.facebook.com/sharer/sharer.php?u={{ $media_url }}" target="_blank" title="{{ Lang::get('lang.share_facebook') }}" onclick="javascript:window.open(this.href, '_blank', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600');return false;"><span class="fa fa-facebook"></span><span class="count">{{ Lang::get('lang.like') }}</span></a></li>
						<li class="twitter" data-share-text="{{ $item->title }}"><a href="https://twitter.com/intent/tweet?url={{ $media_url }}&text={{ $item->title }}" data-url="{{ $media_url }}" title="{{ Lang::get('lang.share_twitter') }}" onclick="javascript:window.open(this.href, '_blank', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600');return false;"><span class="fa fa-twitter" data-url="{{ $media_url }}"></span><span class="count">{{ Lang::get('lang.tweet') }}</span></a></li>
						<li class="googleplus"><a href="https://plus.google.com/share?url={{ $media_url }}" target="_blank" title="{{ Lang::get('lang.share_google') }}" onclick="javascript:window.open(this.href, '_blank', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600');return false;"><span class="fa fa-google-plus"></span><span class="count">{{ Lang::get('lang.plus_one') }}</span></a></li>
						<li class="pinterest"><a href="//www.pinterest.com/pin/create/button/?url={{ $media_url }}&media={{ URL::to('/') . '/content/uploads/images/' . $item->pic_url }}&description={{ $item->title }}" title="{{ Lang::get('lang.share_pinit') }}" target="_blank" onclick="javascript:window.open(this.href, '_blank', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600');return false;"><span class="fa fa-pinterest"></span><span class="count">{{ Lang::get('lang.pin_it') }}</span></a></li>						
					</ul>
				</div>

				@include('includes.media_item')

				@if($count%$settings->inbetween_ads_repeat == 0 && isset($settings->inbetween_ads) && !empty($settings->inbetween_ads))
					<div style="clear:both"></div>
					<div class="inbetween_ads">
						{{ $settings->inbetween_ads }}
					</div>
				
				@endif

			<?php $count += 1; ?>

			</div>
			
			<div class="media-separator"></div>

			

		@endforeach
		
			<div style="clear:both"></div>

			@include('includes.pagination')	

		</div><!-- #media -->


	@include('includes.sidebar')

</div>

@include('includes.media-list-javascript')

@stop