
<div class="col-md-4 col-lg-4" id="sidebar_container" style="margin-top:27px;">
	<div id="sidebar_inner">
		<div id="sidebar" class="" >


	<ul class="nav nav-pills pull-left" style="margin-bottom:15px;">
	  @if(isset($previous->id)) <li class=""><a href="{{ URL::to('media') . '/' . $previous->slug }}" class="btn btn-info btn-prev" style="padding:10px;">{{ Lang::get('lang.previous') }}</a></li>@endif
	   @if(isset($next->id)) <li class=""><a href="{{ URL::to('media') . '/' . $next->slug }}" style="padding:10px;" class="btn btn-info btn-next">{{ Lang::get('lang.next') }}</a></li>@endif
	</ul>


	<ul style="margin-bottom:15px;" id="next_media">
	<?php $prev_media_list = ''; ?>
	@foreach($media_prev as $prev_media)

		
		<?php
		if($prev_media->id == $media->id) {
			$isActive = 'active';
		} else {
			$isActive = '';
		} ?>


		<?php $prev_media_list = "<li class='col-md-4'><a href='" . URL::to('media') . '/' . $prev_media->slug . "'><div class='imgLiquidFill imgLiquid " . $isActive . "' style='width:95px; height:95px;'><img alt='...' src='" . URL::to('/') . '/content/uploads/images/' . $prev_media->pic_url . "' /></div></a></li>" . $prev_media_list; ?>

	@endforeach

	<?php echo $prev_media_list; ?>

	@foreach($media_next as $next_media)

		<li class="col-md-4"><a href="{{ URL::to('media') . '/' . $next_media->slug }}"><div class="imgLiquidFill imgLiquid @if($next_media->id == $media->id) active @endif" style="width:95px; height:95px;"><img alt="..." src="{{ URL::to('/') . '/content/uploads/images/' . $next_media->pic_url }}" /></div></a></li>

	@endforeach
	</ul>

	<div style="clear:both"></div>

	<?php $tags = array_filter(explode(',', $media->tags)); ?>
	
	@if(count($tags) >= 1 && !empty($tags))

	<h4>Tags</h4>

	<ul class="tags">
		@foreach($tags as $tag)
			<li><a href="{{ URL::to('tags') . '/' . $tag }}">{{ $tag }}</a></li>
		@endforeach
	</ul>
	<div style="clear:both"></div>

	@endif

	@if(isset($settings->square_ad) && !empty($settings->square_ad))
		{{ $settings->square_ad }}
	@else
		<img src="http://placehold.it/300x250&text=Advertisement" style='position:relative; left:1px; width:100%; overflow:hidden' />
	@endif
	
		</div>
	</div>
</div>
<div style="clear:both"></div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#sidebar_inner").sticky({topSpacing:60});
	});
</script>