<div class="container">

	<div style="width:100%; text-align:center">
		<img src="application/assets/img/error.png" style="width:100px; display:inline; position:relative; z-index:999999" />
		<h2 style="top:-44px; position:relative; padding-left:10px; display:inline">
			Whoopsie! It looks like something went wrong...
		</h2>
	</div>
	@if(Config::get('app.debug'))
		<pre style="text-align:left; width:80%; margin:0px auto; background:#f1f1f1; border:1px solid #ddd; overflow:scroll; padding:2%; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px;">{{ Lang::get('lang.error') }}: {{ $exception }}</pre>
		<a href="{{ URL::to('/') }}" style="text-align:center; width:100%; padding-top:10px; display:block; font-size:20px;">{{ Lang::get('lang.return_home') }}</a>
	@else
		<a href="{{ URL::to('/') }}" style="text-align:center; width:100%; padding-top:10px; display:block; font-size:20px;">{{ Lang::get('lang.return_home') }}</a><br /><br />
		<pre style="text-align:center; width:80%; margin:0px auto; background:#f1f1f1; border:1px solid #ddd; overflow:scroll; padding:2%; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px;">To see a more valid error message turn on debug mode. In `app/config/app.php` set 'debug' => false; to 'debug' => true;</pre>
	@endif
	

</div>
