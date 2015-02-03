<!-- Edit Modal -->
<?php $categories = Category::all(); ?>
<div class="modal fade" id="edit-modal" data-id="{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">{{ Lang::get('lang.editing') }} {{ $item->title }}</h4>
      </div>
      <div class="modal-body">
      
      	{{ Form::model($media, array('method' => 'PATCH', 'route' => array('media.update', $item->id))) }}
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
					{{ Form::checkbox('nsfw', '', $nsfw, array('class' => 'onoffswitch-checkbox', 'id' => 'nsfw')) }}					   
				    
			</li>

		</ul>
		<input type="hidden" id="id" name="id" value="{{ $item->id }}" />
		<input type="hidden" id="redirect" name="redirect" value="{{ Request::url() }}" />

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('lang.cancel') }}</button>
        <input type="submit" class="btn btn-color" value="{{ Lang::get('lang.update_media') }}" />
      </div>
      {{ Form::close() }}
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript" src="/application/assets/js/tagsinput/jquery.tagsinput.js"></script>
<script>
	$(document).ready(function(){
		$('.tags_input').tagsInput();
	});

	function confirm_delete(obj){
		var confirm_text = "{{ Lang::get('lang.confirm_delete_item') }}";
		var delete_link = $(obj).data('href');
		var result = confirm(confirm_text);
		if(result){
			location.href=delete_link;
		}
	}
</script>