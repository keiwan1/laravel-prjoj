@if(isset($settings->twitter_page_id) && !empty($settings->twitter_page_id))
	<div class="twitter-follow pull-left">
		<a href="https://twitter.com/{{ $settings->twitter_page_id }}" class="twitter-follow-button" data-show-count="false">{{ Lang::get('lang.follow_at') }}{{ $settings->twitter_page_id }}</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
	</div>
@endif

@if(isset($settings->facebook_page_id) && !empty($settings->facebook_page_id))
	<div class="facebook-like pull-left">
		<iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2F{{ $settings->facebook_page_id }}&amp;width=&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:95px; height:21px;" allowTransparency="true"></iframe>
	</div>
@endif

@if(isset($settings->google_page_id) && !empty($settings->google_page_id))
	<div class="google-follow pull-left">
		<!-- Place this tag where you want the widget to render. -->
		<div class="g-follow" data-annotation="bubble" data-height="20" data-href="//plus.google.com/{{ $settings->google_page_id }}" data-rel="author"></div>

		<!-- Place this tag after the last widget tag. -->
		<script type="text/javascript">
		  (function() {
		    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
		    po.src = 'https://apis.google.com/js/platform.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
		  })();
		</script>
	</div>
@endif