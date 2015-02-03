<div id="media_container">
<div class="white_container">

	<h2 style="margin-bottom:20px;"><i class="fa fa-picture-o"></i><span> {{ Lang::get('lang.media') }}</span></h2>
	<div class="col-sm-12" style="padding-left:0px; padding-right:0px;">

		<div class="table-responsive">
			<table class="table table-striped">
				<tr class="table-header">
					<th><a href="?sort=title&order=<?php if(isset($_GET['order']) && $_GET['order'] == 'ASC'){ echo 'DESC'; }else{ echo 'ASC'; } ?>">{{ Lang::get('lang.title') }} <i class="fa fa-sort"></i></a></th>
					<th>{{ Lang::get('lang.category') }}</th>
					<th style="min-width:100px;"><a href="?sort=active&order=<?php if(isset($_GET['order']) && $_GET['order'] == 'ASC'){ echo 'DESC'; }else{ echo 'ASC'; } ?>">{{ Lang::get('lang.active') }} <i class="fa fa-sort"></i></th>
					
					<th><a href="?sort=created_at&order=<?php if(isset($_GET['order']) && $_GET['order'] == 'ASC'){ echo 'DESC'; }else{ echo 'ASC'; } ?>">{{ Lang::get('lang.date_added') }} <i class="fa fa-sort"></i></th>
					<th>{{ Lang::get('lang.actions') }}</th>
					@foreach($media as $item)
					<tr>
						<td><a href="{{ URL::to('media') . '/' . $item->slug }}" data-toggle="modal">
							<?php if(strlen($item->title) > 40){
									echo substr($item->title, 0, 40) . '...';
								  } else {
								  	echo $item->title;
								  }
							?>
							</a>
						</td>
						<td>@if($item->category)<a href="{{ URL::to('category') . '/' . strtolower($item->category->name) }}">{{ $item->category->name }}</a>@endif</td>
						<td class="active-{{$item->id}}">{{ $item->active }}</th>
						<td>{{ date('M d, Y - h:ia', strtotime($item->created_at)) }}</td>
						<td style="min-width:152px;"><a href="#" data-toggle="modal" data-target="#edit-{{ $item->id }}" class="btn btn-xs btn-primary edit-media" style="margin-right:10px;"><span class="fa fa-edit"></span></a><a href="#_" data-href="{{ URL::to('media/delete') . '/' . $item->id }}" onclick="confirm_delete(this)" class="btn btn-xs btn-danger" style="margin-right:10px;"><span class="fa fa-trash-o"></span></a><a href="#_" data-id="{{ $item->id }}" data-href="{{ URL::to('admin/media/toggle_active') . '/' . $item->id }}" onclick="toggle_active(this)" class="btn btn-xs @if($item->active) btn-danger @else btn-success @endif active-toggle"><span class="fa fa-minus-circle"></span> <span class="text">@if($item->active) {{ Lang::get('lang.set_inactive') }} @else {{ Lang::get('lang.set_active') }} @endif</span></a></td>
						
					</tr>
					@endforeach
			</table>
		</div>

	</div>

	{{ $media->appends(array('sort' => Input::get('sort'), 'order' => Input::get('order')))->links() }}

</div>
</div>

<script type="text/javascript" src="/application/assets/js/bootstrap-confirmation.js"></script>
<script>
$(document).ready(function(){
	$('.active-toggle').click(function(){
		if($(this).hasClass('btn-danger')){
			$(this).removeClass('btn-danger').addClass('btn-success');
			$(this).children('span.fa').removeClass('fa-minus-circle').addClass('fa-plus-circle');
			$(this).children('span.text').text("{{ Lang::get('lang.set_active') }}");
			active_class = '.active-' + $(this).data('id');
			$(active_class).text(0);
		} else {
			$(this).removeClass('btn-success').addClass('btn-danger');
			$(this).children('span.fa').removeClass('fa-plus-circle').addClass('fa-minus-circle');
			$(this).children('span.text').text("{{ Lang::get('lang.set_inactive') }}");
			active_class = '.active-' + $(this).data('id');
			$(active_class).text(1);
		}

	});

	$('.pagination a').click(function(e) {
		e.preventDefault();
	  	var url = $(this).attr('href');
	 	$('div#admin_section').load(url, function(data){
	 		console.log('hit');
	 	}); // load the html response into a DOM element
	});
});

function confirm_delete(obj){
	var delete_link = $(obj).data('href');
	var result = confirm("{{ Lang::get('lang.delete_item_confirm') }}");
	if(result){
		location.href=delete_link;
	}
}

function toggle_active(obj){
	url = $(obj).data('href');
	$.get(url);
}
	//$('.edit-media').confirmation();
</script>

<?php $categories = Category::orderBy('order', 'ASC')->get(); ?>
<?php $settings = Setting::first(); ?>


<div class="modal-container">
	@foreach($media as $item)
	<!-- Modal -->
	<div class="modal fade edit-media-modal" id="edit-{{ $item->id }}" data-id="{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog" style="min-height:700px;">
	    <div class="modal-content">
	      
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="myModalLabel">{{ Lang::get('lang.editing') }} {{ $item->title }}</h4>
	      </div>

	      {{ Form::model($media, array('method' => 'PATCH', 'route' => array('media.update', $item->id))) }}
	      <div class="modal-body">
	      	
			<ul>
		        <li>
		            <label for="title">{{ Lang::get('lang.title') }}</label>
		            <input type="text" class="form-control" name="title" id="title" value="{{ $item->title }}" />
		        </li>

		        <li>
		        	<label for="title">{{ Lang::get('lang.category') }}</label>
		        	<select class="form-control" id="category" name="category">
		        		@foreach($categories as $category)
		        			<option value="{{ $category->id }}" @if($category->id == $item->category_id) selected="selected" @endif>{{ $category->name }}</option>
		        		@endforeach
		        	</select>
		        </li>

		        @if($settings->media_description)
		        	<li>
		        		<label for="description">{{ Lang::get('lang.description') }}</label>
	                	<p><textarea name="description" class="form-control" id="description" placeholder="{{ Lang::get('lang.description') }}">{{ $item->description }}</textarea></p>   
		        	</li>
		        @endif

		        <li>
		            <label for="source">{{ Lang::get('lang.source') }}</label>
		            <input type="text" class="form-control" name="source" id="source" value="{{ $item->link_url }}" />
		        </li>

		        <li>
		            <label for="tags">{{ Lang::get('lang.tags') }}</label>
		            <input class="form-control tags_input" name="tags" id="tags" value="{{ $item->tags }}" style="width:100%; height:auto;" />
		        </li>

		        <li>
		            <label for="slug">{{ Lang::get('lang.url') }}</label>
		            <input type="text" class="form-control" name="slug" id="slug" value="{{ $item->slug }}" />
		        </li>

		        <li>
					<label for="nsfw">{{ Lang::get('lang.nsfw') }}:</label>

					@if(isset($item->nsfw))<?php $nsfw = $item->nsfw ?>@else<?php $nsfw = 0 ?>@endif
					<div class="onoffswitch">
						{{ Form::checkbox('nsfw', '', $nsfw, array('class' => 'onoffswitch-checkbox', 'id' => 'nsfw')) }}					   
					    <label class="onoffswitch-label" for="nsfw">
					        <div class="onoffswitch-inner"></div>
					        <div class="onoffswitch-switch"></div>
					    </label>
					</div>
				</li>

			</ul>
			<input type="hidden" id="id" name="id" value="{{ $item->id }}" />
			<input type="hidden" id="redirect" name="redirect" value="{{ URL::to('admin') }}" />
	      </div>
	      
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('lang.cancel') }}</button>
	        <input type="submit" class="btn btn-color" value="{{ Lang::get('lang.update_media') }}" />
	      </div>
	      {{ Form::close() }}

	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->



	@endforeach
</div>

	<script type="text/javascript" src="/application/assets/js/tagsinput/jquery.tagsinput.js"></script>
	<script>

		$(document).ready(function(){

			$('.tags_input').tagsInput();
			$('.edit-media').click(function(){
				$(window).scrollTop(0);
			});
		});
	</script>