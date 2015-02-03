<div class="white_container">
		
		<h2 style="margin-bottom:20px;"><i class="fa fa-cog"></i><span> {{ Lang::get('lang.site_settings') }}</span></h2>
		<form method="POST" action="{{ URL::to('admin/') . '/update_settings' }}" id="media-form" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
			<ul>
				<li>
					<label for="website_name">{{ Lang::get('lang.website_name') }}:</label>
					{{ Form::text('website_name', $settings->website_name, array('class'=>'form-control')) }}
				</li>

				<li>
					<label for="website_description">{{ Lang::get('lang.website_description') }}:</label>
					{{ Form::text('website_description', $settings->website_description, array('class'=>'form-control')) }}
				</li>

				<li>
					<label for="logo">{{ Lang::get('lang.logo') }}:</label>
					<img src="{{ URL::to('/') . '/' . $settings->logo }}" width="200" />
					<input type="file" name="logo" id="logo" style="margin-top:10px;" />
				</li>

				<li>
					<label for="favicon">{{ Lang::get('lang.favicon') }}:</label>
					<img src="{{ URL::to('/') . '/' . $settings->favicon }}" width="16px" />
					<input type="file" name="favicon" id="favicon" style="margin-top:10px;" />
				</li>

				<li>
					<label for="color_scheme">{{ Lang::get('lang.color_scheme') }}:</label>
					@if(!isset($settings->color_scheme))
						<?php $settings->color_scheme = ''; ?>
					@endif
					{{ Form::select('color_scheme', array('light' => 'light', 'dark' => 'dark'), $settings->color_scheme) }}
				</li>

				<li>
					@if(isset($settings->primary_color))<?php $primary_color = $settings->primary_color ?>@else<?php $primary_color = ''; ?>@endif
					<label for="primary_color">{{ Lang::get('lang.primary_color') }}:</label>
					{{ Form::text('primary_color', $primary_color, array('class'=>'form-control', 'id' => 'primary_color',  'style'=> 'width:110px;')) }}
				</li>

				<li>
					@if(isset($settings->secondary_color))<?php $secondary_color = $settings->secondary_color ?>@else<?php $secondary_color = ''; ?>@endif
					<label for="secondary_color">{{ Lang::get('lang.secondary_color') }}:</label>
					{{ Form::text('secondary_color', $secondary_color, array('class'=>'form-control', 'id' => 'secondary_color',  'style'=> 'width:110px;')) }}
				</li>

				<li>
					<label for="like_icon">{{ Lang::get('lang.like_icon') }}:</label>
					@if(!isset($settings->like_icon))
						<?php $settings->like_icon = ''; ?>
					@endif
					{{ Form::select('like_icon', array('fa-thumbs-o-up' => 'Thumbs Up', 'fa-star' => 'Star', 'fa-heart' => 'Heart', 'fa-sun-o' => 'Sun', 'fa-smile-o' => 'Smile', 'fa-check' => 'Checkmark'), $settings->like_icon) }}
				</li>

				<li>
					@if(isset($settings->fb_key))<?php $fb_key = $settings->fb_key ?>@else<?php $fb_key = ''; ?>@endif
					<label for="fb_key">{{ Lang::get('lang.fb_app_key') }}:</label>
					{{ Form::text('fb_key', $fb_key, array('class'=>'form-control')) }}
				</li>

				<li>
					@if(isset($settings->fb_secret_key))<?php $fb_secret_key = $settings->fb_secret_key ?>@else<?php $fb_secret_key = ''; ?>@endif
					<label for="fb_secret_key">{{ Lang::get('lang.fb_app_secret') }}:</label>
					{{ Form::text('fb_secret_key', $fb_secret_key, array('class'=>'form-control')) }}
				</li>

				<li>
					@if(isset($settings->facebook_page_id))<?php $facebook_page_id = $settings->facebook_page_id ?>@else<?php $facebook_page_id = ''; ?>@endif
					<label for="facebook_page_id">{{ Lang::get('lang.fb_page_id') }}:</label>
					{{ Form::text('facebook_page_id', $facebook_page_id, array('class'=>'form-control')) }}
				</li>

				<li>
					@if(isset($settings->google_key))<?php $google_key = $settings->google_key ?>@else<?php $google_key = ''; ?>@endif
					<label for="google_key">{{ Lang::get('lang.google_oauth_key') }}:</label>
					{{ Form::text('google_key', $google_key, array('class'=>'form-control')) }}
				</li>

				<li>
					@if(isset($settings->google_secret_key))<?php $google_secret_key = $settings->google_secret_key ?>@else<?php $google_secret_key = ''; ?>@endif
					<label for="google_secret_key">{{ Lang::get('lang.google_secret_key') }}:</label>
					{{ Form::text('google_secret_key', $google_secret_key, array('class'=>'form-control')) }}
				</li>

				<li>
					@if(isset($settings->google_page_id))<?php $google_page_id = $settings->google_page_id ?>@else<?php $google_page_id = ''; ?>@endif
					<label for="google_page_id">{{ Lang::get('lang.google_page_id') }}:</label>
					{{ Form::text('google_page_id', $google_page_id, array('class'=>'form-control')) }}
				</li>

				<li>
					@if(isset($settings->twitter_page_id))<?php $twitter_page_id = $settings->twitter_page_id ?>@else<?php $twitter_page_id = ''; ?>@endif
					<label for="twitter_page_id">{{ Lang::get('lang.twitter_username') }}:</label>
					{{ Form::text('twitter_page_id', $twitter_page_id, array('class'=>'form-control')) }}
				</li>

				<li>
					<label for="auto_approve_posts">{{ Lang::get('lang.auto_approve_posts') }}:</label>

					@if(isset($settings->auto_approve_posts))<?php $auto_approve = $settings->auto_approve_posts ?>@else<?php $auto_approve = 1 ?>@endif	
					<div class="onoffswitch">
						{{ Form::checkbox('auto_approve_posts', '', $auto_approve, array('class' => 'onoffswitch-checkbox', 'id' => 'auto_approve_posts')) }}					   
					    <label class="onoffswitch-label" for="auto_approve_posts">
					        <div class="onoffswitch-inner"></div>
					        <div class="onoffswitch-switch"></div>
					    </label>
					</div>

				</li>

				<li>
					<label for="user_registration">{{ Lang::get('lang.allow_user_register') }}:</label>

					@if(isset($settings->user_registration))<?php $user_registration = $settings->user_registration ?>@else<?php $user_registration = 1 ?>@endif
					<div class="onoffswitch">
						{{ Form::checkbox('user_registration', '', $user_registration, array('class' => 'onoffswitch-checkbox', 'id' => 'user_registration')) }}					   
					    <label class="onoffswitch-label" for="user_registration">
					        <div class="onoffswitch-inner"></div>
					        <div class="onoffswitch-switch"></div>
					    </label>
					</div>

					<div id="captcha_block" @if(isset($settings->user_registration) && $settings->user_registration == 1) style="display:block" @endif>
						<label for="captcha">{{ Lang::get('lang.captcha_reg') }}:</label>

						@if(isset($settings->captcha))<?php $captcha = $settings->captcha ?>@else<?php $captcha = 0 ?>@endif
						<div class="onoffswitch">
							{{ Form::checkbox('captcha', '', $captcha, array('class' => 'onoffswitch-checkbox', 'id' => 'captcha')) }}					   
						    <label class="onoffswitch-label" for="captcha">
						        <div class="onoffswitch-inner"></div>
						        <div class="onoffswitch-switch"></div>
						    </label>
						</div>

						<div id="captcha_info" @if(isset($settings->captcha) && $settings->captcha == 1) style="display:block" @endif>

							@if(isset($settings->captcha_public_key))<?php $captcha_public_key = $settings->captcha_public_key ?>@else<?php $captcha_public_key = ''; ?>@endif
							<label for="captcha_public_key">{{ Lang::get('lang.captcha_public_key') }}:</label>
							{{ Form::text('captcha_public_key', $captcha_public_key, array('class'=>'form-control')) }}

							@if(isset($settings->captcha_private_key))<?php $captcha_private_key = $settings->captcha_private_key ?>@else<?php $captcha_private_key = ''; ?>@endif
							<label for="captcha_private_key">{{ Lang::get('lang.captcha_private_key') }}:</label>
							{{ Form::text('captcha_private_key', $captcha_private_key, array('class'=>'form-control')) }}

						</div>

					</div>
				</li>

				<li>
					<label for="infinite_scroll">{{ Lang::get('lang.enable_infinite_scr') }}:</label>

					@if(isset($settings->infinite_scroll))<?php $infinite_scroll = $settings->infinite_scroll ?>@else<?php $infinite_scroll = 1 ?>@endif
					<div class="onoffswitch">
						{{ Form::checkbox('infinite_scroll', '', $infinite_scroll, array('class' => 'onoffswitch-checkbox', 'id' => 'infinite_scroll')) }}					   
					    <label class="onoffswitch-label" for="infinite_scroll">
					        <div class="onoffswitch-inner"></div>
					        <div class="onoffswitch-switch"></div>
					    </label>
					</div>

					<div id="infinite_scroll_load_more_block" @if(isset($settings->infinite_scroll) && $settings->infinite_scroll == 1) style="display:block" @else style="display:none" @endif>
						<label for="infinite_scroll_load_more">{{ Lang::get('lang.infinite_scr_load') }}:</label>

						@if(isset($settings->infinite_load_btn))<?php $infinite_load_btn = $settings->infinite_load_btn ?>@else<?php $infinite_load_btn = 1 ?>@endif
						<div class="onoffswitch">
							{{ Form::checkbox('infinite_load_btn', '', $infinite_load_btn, array('class' => 'onoffswitch-checkbox', 'id' => 'infinite_load_btn')) }}					   
						    <label class="onoffswitch-label" for="infinite_load_btn">
						        <div class="onoffswitch-inner"></div>
						        <div class="onoffswitch-switch"></div>
						    </label>
						</div>
					</div>
				</li>

				<li>
					<label for="random_bar_enabled">{{ Lang::get('lang.random_bar_enabled') }}:</label>

					@if(isset($settings->random_bar_enabled))<?php $random_bar_enabled = $settings->random_bar_enabled ?>@else<?php $random_bar_enabled = 1 ?>@endif
					<div class="onoffswitch">
						{{ Form::checkbox('random_bar_enabled', '', $random_bar_enabled, array('class' => 'onoffswitch-checkbox', 'id' => 'random_bar_enabled')) }}					   
					    <label class="onoffswitch-label" for="random_bar_enabled">
					        <div class="onoffswitch-inner"></div>
					        <div class="onoffswitch-switch"></div>
					    </label>
					</div>
				</li>

				<li>
					<label for="media_description">{{ Lang::get('lang.media_description') }}:</label>

					@if(isset($settings->media_description))<?php $media_description = $settings->media_description ?>@else<?php $media_description = 1 ?>@endif
					<div class="onoffswitch">
						{{ Form::checkbox('media_description', '', $media_description, array('class' => 'onoffswitch-checkbox', 'id' => 'media_description')) }}					   
					    <label class="onoffswitch-label" for="media_description">
					        <div class="onoffswitch-inner"></div>
					        <div class="onoffswitch-switch"></div>
					    </label>
					</div>
				</li>


				<li>
					<label for="enable_watermark">{{ Lang::get('lang.enable_watermark') }}:</label>

					@if(isset($settings->enable_watermark))<?php $enable_watermark = $settings->enable_watermark ?>@else<?php $enable_watermark = 1 ?>@endif
					<div class="onoffswitch">
						{{ Form::checkbox('enable_watermark', '', $enable_watermark, array('class' => 'onoffswitch-checkbox', 'id' => 'enable_watermark')) }}					   
					    <label class="onoffswitch-label" for="enable_watermark">
					        <div class="onoffswitch-inner"></div>
					        <div class="onoffswitch-switch"></div>
					    </label>
					</div>
					<div class="enable_watermark_info" @if(isset($settings->enable_watermark) && $settings->enable_watermark == 1) style="display:block" @endif>
						<div class="image">
							<label for="watermark_image">{{ Lang::get('lang.watermark') }}:</label>
							<img src="{{ URL::to('/') . '/' . $settings->watermark_image }}" width="auto" />
							<input type="file" name="watermark_image" id="watermark_image" style="margin-top:10px;" />
						</div>
						<div class="position">
							<label for="watermark_position">{{ Lang::get('lang.watermark_position') }}:</label>
							@if(!isset($settings->watermark_position))
								<?php $settings->watermark_position = 'bottom-right'; ?>
							@endif
							{{ Form::select('watermark_position', array('top-left' => 'Top Left', 'top-center' => 'Top Center', 'top-right' => 'Top Right', 'left' => 'Left', 'center' => 'Center', 'right' => 'Right', 'bottom-left' => 'Bottom Left', 'bottom' => 'Bottom', 'bottom-right' => 'Bottom Right'), $settings->watermark_position) }}
						</div>

						<div class="clear" style="padding-top:20px;"></div>
						<label for="watermark_offset_x">{{ Lang::get('lang.watermark_offset_x') }}:</label>
						{{ Form::text('watermark_offset_x', $settings->watermark_offset_x, array('class'=>'form-control')) }}

						<label for="watermark_offset_y">{{ Lang::get('lang.watermark_offset_y') }}:</label>
						{{ Form::text('watermark_offset_y', $settings->watermark_offset_y, array('class'=>'form-control')) }}
						<div class="clear"></div>
					</div>
				</li>

				<li>
					<label for="pages_in_menu">{{ Lang::get('lang.pages_in_menu') }}:</label>

					@if(isset($settings->pages_in_menu))<?php $pages_in_menu = $settings->pages_in_menu ?>@else<?php $pages_in_menu = 1 ?>@endif
					<div class="onoffswitch">
						{{ Form::checkbox('pages_in_menu', '', $pages_in_menu, array('class' => 'onoffswitch-checkbox', 'id' => 'pages_in_menu')) }}					   
					    <label class="onoffswitch-label" for="pages_in_menu">
					        <div class="onoffswitch-inner"></div>
					        <div class="onoffswitch-switch"></div>
					    </label>
					</div>

					<div id="pages_in_menu_text_block" @if(isset($settings->pages_in_menu) && $settings->pages_in_menu == 1) style="display:block" @else style="display:none" @endif>
						@if(isset($settings->pages_in_menu_text))<?php $pages_in_menu_text = $settings->pages_in_menu_text ?>@else<?php $pages_in_menu_text = ''; ?>@endif
						<label for="pages_in_menu_text">{{ Lang::get('lang.pages_in_menu_text') }}:</label>
						{{ Form::text('pages_in_menu_text', $pages_in_menu_text, array('class'=>'form-control')) }}
					</div>

				</li>


				<li>
					@if(isset($settings->square_ad))<?php $square_ad = $settings->square_ad ?>@else<?php $square_ad = ''; ?>@endif
					<label for="square_ad">{{ Lang::get('lang.sidebar_advertisement') }}:</label>
					{{ Form::textarea('square_ad', $square_ad, array('class'=>'form-control')) }}
				</li>

				<li>
					@if(isset($settings->inbetween_ads))<?php $inbetween_ads = $settings->inbetween_ads ?>@else<?php $inbetween_ads = ''; ?>@endif
					<label for="inbetween_ads">{{ Lang::get('lang.inbetween_ads') }}:</label>
					{{ Form::textarea('inbetween_ads', $inbetween_ads, array('class'=>'form-control')) }}
				</li>

				<li>
					@if(isset($settings->inbetween_ads_repeat))<?php $inbetween_ads_repeat = $settings->inbetween_ads_repeat ?>@else<?php $inbetween_ads_repeat = ''; ?>@endif
					<label for="inbetween_ads_repeat">{{ Lang::get('lang.inbetween_ads_repeat') }}:</label>
					{{ Form::text('inbetween_ads_repeat', $inbetween_ads_repeat, array('class'=>'form-control')) }}
				</li>

				<li>
					@if(isset($settings->analytics))<?php $analytics = $settings->analytics ?>@else<?php $analytics = ''; ?>@endif
					<label for="analytics">{{ Lang::get('lang.analytics_code') }}:</label>
					{{ Form::textarea('analytics', $analytics, array('class'=>'form-control')) }}
				</li>


				<li style="min-height:45px">
					<input type="submit" class="btn btn-color pull-right" value="{{ Lang::get('lang.update_settings') }}" />
				</li>
				<div style="clear:both"></div>
			</ul>
		</form>
</div>

<script type="text/javascript" src="/application/assets/js/jquery-minicolors/jquery.minicolors.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('input#primary_color, input#secondary_color').minicolors();

		$('#enable_watermark').change(function(){
			$('.enable_watermark_info').slideToggle();
		});

		$('#pages_in_menu').change(function(){
			$('#pages_in_menu_text_block').slideToggle();
		});

		$('#infinite_scroll').change(function(){
			$('#infinite_scroll_load_more_block').slideToggle();
		});

		$('#user_registration').change(function(){
			$('#captcha_block').slideToggle();
		});

		$('#captcha').change(function(){
			$('#captcha_info').slideToggle();
		});

		
	});
</script>

