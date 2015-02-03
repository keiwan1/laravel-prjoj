<script type="text/javascript">

	$(document).ready(function(){

		$(".imgLiquidFill").imgLiquid();

		$('.comment-type').click(function(){
			var comment_type = $(this).data('comments');
			$('#current_comments, #facebook_comments').hide();
			$(comment_type).show();
			$('.comment-type').removeClass('active');
			$(this).addClass('active');
		});

		$(".timeago").timeago();
		
		$('.item-large').find('.video_container').fitVids();

		$('.delete_comment').click(function(){ delete_comment($(this).data('id')); });
		$('.edit_comment').click(function(){ edit_comment($(this).data('id')); });

		$('.vote-up').click(function(){ vote_up($(this)); });
		$('.vote-down').click(function(){ vote_down($(this)); });

		$('.media-flag').click(function(){
			this_object = $(this);
			flag_this_text = "{{ Lang::get('lang.flag_this') }}";
			flagged_text = "{{ Lang::get('lang.flagged') }}";
			$.post("{{ URL::to('media') . '/add_flag' }}", { media_id: $(this).data('id') }, function(data){
				$(this_object).toggleClass('active');
				if($(this_object).find('.media-flag-desc').text() == flag_this_text){
					$(this_object).find('.media-flag-desc').text(flagged_text);
				} else {
					$(this_object).find('.media-flag-desc').text(flag_this_text);
				}
			});
		});

		$('.animation').attr('src', $('.animation').data('animation'));
		$('.animation').data('state', 1);
		$('.animated-gif').find('.gif-play').hide();

		if($('.vine-thumbnail-play')[0]){

			var embed = $('.vine-thumbnail').data('embed');
			$('.video_container').html('<iframe class="vine-embed" src="' + embed + '" width="100%" height="600" frameborder="0"></iframe>');

		}

		$('.home-media-like').click(function(){
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

		$('.flag_comment').click(function(){
			flag_comment($(this));
		});

		$('#comment-submit').click(function(){

			if($('#comment').val().length >= 5){

				$('#comment-submit').prepend('<i class="fa fa-refresh fa-spin"></i> ');

				var newComment = {
					comment: $('#comment').val(),
					media_id: $('#media_id').val()
				};

				$.post('/comments', newComment, function(data){
					comment = JSON.parse(data);
					if(comment){
						$('.comment-loop').prepend( comment_template( comment ) );
						$('.delete_comment').on('click', function(){ delete_comment($(this).data('id')); });
						$('.edit_comment').on('click', function(){ edit_comment($(this).data('id')); });
						$('.flag_comment').on('click', function(){ flag_comment($(this)); });
						$('.vote-up').on('click', function(){ vote_up($(this)); });
						$('.vote-down').on('click', function(){ vote_down($(this)); });
						increment_comment_count();
						clear_comment_fields();
					} else {
						var no_spamming_text = "{{ Lang::get('lang.spam_warn_comments') }}";
						var n = noty({text: no_spamming_text, layout: 'top', type: 'error', template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>', closeWith: ['button'], timeout:2000 });
					}
					$('#comment-submit').children('i').remove();
				});

			} else {
				var min_char_comment_text = "{{ Lang::get('lang.min_char_comments') }}";
				var n = noty({text: min_char_comment_text, layout: 'top', type: 'error', template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>', closeWith: ['button'], timeout:2000 });
			}

		});

		img_vid_toggle();


	});

	function img_vid_toggle(){
		$('#vid_selected').click(function(){
			$(this).addClass('active');
			$('#img_selected').removeClass('active');
			$('#vid_container').show();
			$('#img_container').hide();
		});

		$('#img_selected').click(function(){
			$(this).addClass('active');
			$('#vid_selected').removeClass('active');
			$('#vid_container').hide();
			$('#img_container').show();
		});

	}

	function increment_comment_count(){
		cur_val = parseInt($('.current_comment_count.site_comments').text());
		$('.current_comment_count.site_comments').text(cur_val + 1);
	}

	function decrement_comment_count(){
		cur_val = $('.current_comment_count').text();
		$('.current_comment_count').text(parseInt(cur_val) - 1);
	}

	function update_comment_votes(this_object){
		$(this_object).parent().find('p').removeClass('animated').addClass('flip');
		$.getJSON("{{ URL::to('api') . '/commentvotes/' }}" + String($(this_object).data('commentid')), function(data){
			$(this_object).parent().find('p').text(data);
			$(this_object).parent().find('p').addClass('animated').addClass('flip');
			console.log(data);
		});
	}

	function edit_comment(id){


		container = '.comment-'+ id + ' .comment_container';
		comment = $(container).find('p.comment_data');
		if($(container).find('p.comment_data').css('display') == 'block'){
			comment.hide();
			if($(container).find('.correct-comment-btn').length != 0){
				$(container).find('.correct-comment-btn').hide();
			}
			var cancel_text = "{{ Lang::get('lang.cancel') }}";
			$(container).append('<div class="update-comment"><textarea class="form-control update-comment-' + id + '">'+ comment.html() + '</textarea><div class="btn btn-color pull-right comment-update-update" data-commentid="' + id + '">Update</div><div class="btn pull-right comment-update-cancel" data-commentid="' + id + '">'+cancel_text+'</div><div style="clear:both"></div></div>');
			$(container).find('.update-comment').focus();
			bind_update_buttons();
		} else {
			if($(container).find('.correct-comment-btn').length != 0){
				$(container).find('.correct-comment-btn').show();
			}
			comment.show();
			$('.update-comment').hide();
		}
	}

	function flag_comment(object){
		this_object = $(object);
		$.post("{{ URL::to('comments') . '/add_flag' }}", { comment_id: $(this_object).data('id') }, function(data){
			$.getJSON("{{ URL::to('api') . '/commentflags/' }}" + String($(this_object).data('id')), function(data){
				$(this_object).parent().find('.num_flags').text(data);
			});
		});
	}

	function vote_up(object){
		this_object = $(object);
		$.post("{{ URL::to('comments') . '/vote_up' }}", { comment_id: $(this_object).data('commentid') }, function(data){
			update_comment_votes(this_object);
		});
		$(this_object).addClass('active');
		$(this_object).parent().find('.vote-down').removeClass('active');
	}

	function vote_down(object){
		this_object = $(object);
		$.post("{{ URL::to('comments') . '/vote_down' }}", { comment_id: $(this_object).data('commentid') }, function(data){
			update_comment_votes(this_object);
		});
		$(this).addClass('active');
		$(this).parent().find('.vote-up').removeClass('active');
	}

	function bind_update_buttons(){
		$('.comment-update-cancel').bind('click', function(){
			comment_id = $(this).data('commentid');
			container = '.comment-'+ comment_id + ' .comment_container';
			$(container).find('p.comment_data').show();
			$(container).find('.update-comment').hide();
			if($(container).find('.correct-comment-btn').length != 0){
				$(container).find('.correct-comment-btn').show();
			}
		});

		$('.comment-update-update').bind('click', function(){
			comment_id = $(this).data('commentid');
			container = '.comment-'+ comment_id + ' .comment_container';
			var updateComment = {
				comment: $('.update-comment-'+comment_id).val(),
				_method: 'PATCH'
			};

			$.post('/comments/'+comment_id, updateComment, function(data){
				$(container).find('p.comment_data').html($('.update-comment-'+comment_id).val());
				$(container).find('p.comment_data').show();
				$(container).find('.update-comment').hide();
			});
		});
	}

	function comment_template(comment){
		if(comment.user_id == $('#user_id').val()){
			edit = '<div class="flag_edit_delete_comment"><a class="flag_comment" data-id="' + comment.id + '"><i class="fa fa-flag"></i> + <span class="num_flags">0</span></a><a class="edit_comment" data-id="' + comment.id + '"><i class="fa fa-edit"></i></a><a class="delete_comment" data-id="' + comment.id + '"><i class="fa fa-trash-o"></i></a></div>';
		} else {
			edit = '';
		}

		votes = '<div class="comment_vote pull-left"><i class="fa fa-chevron-up vote-up" data-commentid="' + comment.id + '"></i><p>0</p><i class="fa fa-chevron-down vote-down" data-commentid="' + comment.id + '"></i></div>';
		
		@if(Auth::guest())
			return false;
		@else
			few_seconds_ago = "{{ Lang::get('lang.few_seconds_ago') }}";
			wrote_text = "{{ Lang::get('lang.wrote') }}";
			comment_info = '<div class="comment_info"><p class="timeago">' + few_seconds_ago + '</p><h4><a href="{{ URL::to("user") . "/" . Auth::user()->username }}">{{ Auth::user()->username }}</a> ' + wrote_text + ':</h4></div>';
			user_avatar = '<a href="{{ URL::to("user") . "/" . Auth::user()->username }}"><img src="{{ URL::to("/") }}/content/uploads/avatars/{{ Auth::user()->avatar }}" class="user-avatar-small img-circle" /></a>';
			new_comment = '<div class="comment comment-' + comment.id + '">' + votes + edit + '<div class="comment_container" data-id="'+ comment.id +'">' + user_avatar + comment_info + '<p class="comment_data">' + comment.comment + '</p><div style="clear:both"></div></div></div>';
			console.log(comment);
			return new_comment;
		@endif
	}

	function clear_comment_fields(){
		$('#comment').val('');
		$('#file_upload').show();

		$('#preview_image').attr('src', '');
		$('#img_attached').text('');
		$('#video_link').val('');

	}

	function delete_comment(id){
		$.ajax({
			url:'/comments/'+id, 
			type: 'POST',
		 	data: { _method:'DELETE' }, 
		 	success: function(data){
		 		if(data){
		 			$('.comment-'+id).fadeOut();
		 			decrement_comment_count();
		 		}
			}
		});
	}

</script>