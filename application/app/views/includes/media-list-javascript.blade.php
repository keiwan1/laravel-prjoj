<script type="text/javascript" src="/application/assets/js/jquery.isOnScreen.js"></script>

<script type="text/javascript">

	var nearest_item = '';

	$(window).scroll(function(){

		nearest_item = $.nearest({x: 0, y: $('.navbar-fixed-top').offset().top}, $('.item'));

	});

	$('document').ready(function(){

		$(".timeago").timeago();

		$.each($('.item'), function(index, value){
			item_click_events($(value));
		});

	});


	@if($settings->infinite_scroll && !$settings->infinite_load_btn)

		$(document).ready(function(){

			var $container = $('#media');
			var no_more_media = "{{ Lang::get('lang.no_more_to_load') }}";
			var loading_more_media = "{{ Lang::get('lang.loading_more_media') }}";

			$container.infinitescroll({

				loading: {
			        finished: undefined,
			        finishedMsg: "<p>" + no_more_media + "</p>",
			        img: "/application/assets/img/loader2.gif",
			        msg: null,
			        msgText: "<p>" + loading_more_media + "</p>",
			        selector: null,
			        speed: 'fast',
			        start: undefined,
			    },
	 
			    navSelector  : "ul.pagination",            
			                   // selector for the paged navigation (it will be hidden)
			    nextSelector : "ul.pagination a:first",    
			                   // selector for the NEXT link (to page 2)
			    itemSelector : ".container #media .item",

			    animate:true,

			    bufferPx: 1000,
			  },

			  function( newElements ) {
			  	 // hide new items while they are loading
	    		var $newElems = $( newElements ).css({ opacity: 0 });

	    		$.each($(newElements), function(index, value){
	    			item_click_events($(value));
	    		});

			  	$("#media").imagesLoaded(function(){
				   var $newElems = $( newElements );
				   $newElems.animate({ opacity: 1 });
				});
			  });

		});

	@elseif($settings->infinite_scroll && $settings->infinite_load_btn)

		$(document).ready(function(){
			
			$('#media').on('click', ".load-more-btn", function(){
				console.log('hit');
				$(this).css('padding', '0px');
				$(this).css('padding-top', '3px');
				$('.load-more-btn p').hide();
				$('.load-more-btn span').css('display', 'inline-block');
				var remove = $(this).parent();
				$('#hidden_load_content').load($(this).data('href') + ' #media', function(){
					$('.items.new-items').removeClass('new-items');
					$.each($('#hidden_load_content #media .item'), function(index, value){
						$(this).addClass('new-items');
					});

					$('#media').append($('#hidden_load_content #media').html());
					
					item_click_events($('.new-items'));

					$('#hidden_load_content').html('');
					remove.remove();
				});
				
			});
		});

	@endif

	function toggle_gif(img, icon){
		if($(img).data('state') == 0){
			play_gif(img, icon);
		} else {
			stop_gif(img, icon);
		}
	}

	function play_gif(img, icon){
		$(img).attr('src', $(img).data('animation'));
		$(img).data('state', 1);
		$(icon).fadeOut();
	}

	function stop_gif(img, icon){
		$(img).attr('src', $(img).data('original'));
		$(img).data('state', 0);
		$(icon).fadeIn();
	}

	function item_click_events(item){

		$(item).find('.video_container').fitVids();

		item_gif_vine_events(item);
		
		media_like = $(item).find('.home-media-like');

		$(media_like).click(function(){
			if($(this).data('authenticated') == false){
				window.location = '{{ URL::to("signup") }}';
			}
			this_object = $(this);
			$(this).children('i').removeClass('animated').removeClass('rotateIn');
			$(this_object).toggleClass('active');
			var like_count = $(this_object).parent().find('.home-like-count span');
			if($(this_object).hasClass('active')){
				$(this_object).children('i').addClass('animated').addClass('bounceIn');
				like_count.text( parseInt(like_count.text()) + 1 );
			} else {
				like_count.text( parseInt(like_count.text()) - 1 );
			}
			$.post("{{ URL::to('media') . '/add_like' }}", { media_id: $(this).data('id') }, function(data){
				
			});
		});
	
	}

	function item_gif_vine_events(object){

		var gifs = $(object).find('.animated-gif .animation');
		var gif_play = $(object).find('.gif-play');

		gif_click(gifs);
		gif_click(gif_play);


		var vine = $(object).find('.vine-thumbnail');
		var vine_play = $(object).find('.vine-thumbnail-play');

		vine_click(vine);
		vine_click(vine_play);
		
	}

	function gif_click(object){
		$(object).click(function(){
			animated_gif = $(this).parent('.animated-gif').find('.animation');
			play_icon = $(this).parent('.animated-gif').find('.gif-play');
			toggle_gif(animated_gif, play_icon);
		});
	}

	function vine_click(object){
		$(object).click(function(){
			var embed = $(this).data('embed');
			$(this).parent('.video_container').html('<iframe class="vine-embed" src="' + embed + '" width="100%" height="600" frameborder="0"></iframe>');
		});
	}


</script>