<?php $settings = Setting::first(); ?>
<div class="col-md-4 col-lg-4" id="sidebar_container">
	<div id="sidebar_inner">
		<div id="sidebar" class="" style="margin-top:15px;">
			<a class="spcl-button color" href="{{ URL::to('upload') }}">{{ Lang::get('lang.submit_pic_or_video') }}</a>

			<div class="social_block">
				<iframe src="//www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2F{{ $settings->facebook_page_id }}&amp;width&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:240px; width:100%;" allowTransparency="true"></iframe>
			</div>
			
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
		$("#sidebar_inner").sticky({topSpacing:50});
	});
</script>