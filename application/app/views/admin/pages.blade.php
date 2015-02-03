
<div class="white_container">
		
		<h2 style="margin-bottom:20px; float:left;"><i class="fa fa-file"></i><span> {{ Lang::get('lang.pages') }}</span></h2>
		<div class="btn btn-color" style="margin-left:20px;" data-toggle="modal" data-target="#new-page"><span class="fa fa-plus"></span> New Page</div>
		<div style="clear:both"></div>
		<div class="table-responsive">
			<table class="table table-condensed">
				<tr>
					<th>{{ Lang::get('lang.title') }}</th>
					<th>{{ Lang::get('lang.active') }}</th>
					<th>{{ Lang::get('lang.order') }}</th>
					<th>{{ Lang::get('lang.actions') }}</th>
					@foreach($pages as $page)

							<tr>
								<td>
									{{ $page->title }}
								</td>
								<td>
									{{ $page->active }}
								</td>
								<td>
									{{ $page->order }}
								</td>
								<td style="width:190px;">
									<a href="#" data-toggle="modal" data-target="#edit-{{ $page->id }}" class="btn btn-xs btn-primary edit-media" style="margin-right:10px;"><span class="fa fa-edit"></span> {{ Lang::get('lang.edit') }}</a>
									
										<a href="{{ URL::to('admin/pages/delete') . '/' . $page->id }}" class="btn btn-xs btn-danger"><span class="fa fa-trash-o"></span> {{ Lang::get('lang.delete') }}</a>
								
								</td>
								
							</tr>
							
					@endforeach
			</table>
		</div>
		
	</div>



	<!-- Create Category Modal -->
	<div class="modal fade" id="new-page" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">{{ Lang::get('lang.page_new') }}</h4>
			</div>
		    <form method="POST" action="{{ URL::to('admin/pages/create') }}" accept-charset="UTF-8">
		    <div class="modal-body">
		      
				<ul>
			        <li>
			        	<label for="title">{{ Lang::get('lang.title') }}</label>
	           			<input type="text" class="form-control" name="title" id="title" placeholder="{{ Lang::get('lang.title') }}" />
			        </li>

			        <li>
			        	<label for="url">{{ Lang::get('lang.url') }}</label>
	           			<input type="text" class="form-control" name="url" id="url" placeholder="{{ Lang::get('lang.url') }}" />
			        </li>

			        <li>
		        		<label for="body">{{ Lang::get('lang.body') }}</label>
	                	<p><textarea name="body" class="form-control" id="body" placeholder="{{ Lang::get('lang.body') }}"></textarea></p>   
		        	</li>

		        	<li>
			        	<label for="order">{{ Lang::get('lang.order') }}</label>
	           			<input type="text" class="form-control" name="order" id="order" value="0" placeholder="{{ Lang::get('lang.order') }}" />
			        </li>

			        <li>
						<label for="active">{{ Lang::get('lang.active') }}:</label>

						@if(isset($page->active))<?php $active = $page->active ?>@else<?php $active = 1 ?>@endif
						<div class="onoffswitch">
							{{ Form::checkbox('active', '', $active, array('class' => 'onoffswitch-checkbox', 'id' => 'active')) }}					   
						    <label class="onoffswitch-label" for="active">
						        <div class="onoffswitch-inner"></div>
						        <div class="onoffswitch-switch"></div>
						    </label>
						</div>
					</li>

					<li>
						<label for="show_in_menu">{{ Lang::get('lang.show_in_menu') }}:</label>

						@if(isset($page->show_in_menu))<?php $show_in_menu = $page->show_in_menu ?>@else<?php $show_in_menu = 1 ?>@endif
						<div class="onoffswitch">
							{{ Form::checkbox('show_in_menu', '', $show_in_menu, array('class' => 'onoffswitch-checkbox', 'id' => 'show_in_menu')) }}					   
						    <label class="onoffswitch-label" for="show_in_menu">
						        <div class="onoffswitch-inner"></div>
						        <div class="onoffswitch-switch"></div>
						    </label>
						</div>
					</li>

				</ul>
		      	
			</div><!-- .modal-body -->
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('lang.cancel') }}</button>
				<input type="submit" class="btn btn-color" value="Add Page" />
			</div>
				</form>

	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<!-- END Create Category Modal -->

	@foreach($pages as $page)
	<!-- Modal -->
	<div class="modal fade" id="edit-{{ $page->id }}" data-id="{{ $page->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">{{ Lang::get('lang.editing') }} {{ $page->title }}</h4>
			</div>
			<form method="POST" action="{{ URL::to('admin/pages/update') . '/' . $page->id }}" accept-charset="UTF-8">
		    <div class="modal-body">
		      
		      	
					<ul>
			        <li>
			        	<label for="title">{{ Lang::get('lang.title') }}</label>
	           			<input type="text" class="form-control" name="title" id="title" value="{{ $page->title }}" placeholder="{{ Lang::get('lang.title') }}" />
			        </li>

			        <li>
			        	<label for="url">{{ Lang::get('lang.url') }}</label>
	           			<input type="text" class="form-control" name="url" id="url" value="{{ $page->url }}" placeholder="{{ Lang::get('lang.url') }}" />
			        </li>

			        <li>
		        		<label for="body">{{ Lang::get('lang.body') }}</label>
	                	<p><textarea name="body" class="form-control" id="body edit-{{ $page->id }}" placeholder="{{ Lang::get('lang.body') }}">{{ $page->body }}</textarea></p>   
		        	</li>

		        	<li>
			        	<label for="order">{{ Lang::get('lang.order') }}</label>
	           			<input type="text" class="form-control" name="order" id="order" value="{{ $page->order }}" placeholder="{{ Lang::get('lang.order') }}" />
			        </li>

			        <li>
						<label for="active">{{ Lang::get('lang.active') }}:</label>

						@if(isset($page->active))<?php $active = $page->active ?>@else<?php $active = 1 ?>@endif
						<div class="onoffswitch">
							{{ Form::checkbox('active', '', $active, array('class' => 'onoffswitch-checkbox', 'id' => 'active')) }}					   
						    <label class="onoffswitch-label" for="active">
						        <div class="onoffswitch-inner"></div>
						        <div class="onoffswitch-switch"></div>
						    </label>
						</div>
					</li>

					<li>
						<label for="show_in_menu">{{ Lang::get('lang.show_in_menu') }}:</label>

						@if(isset($page->show_in_menu))<?php $show_in_menu = $page->show_in_menu ?>@else<?php $show_in_menu = 1 ?>@endif
						<div class="onoffswitch">
							{{ Form::checkbox('show_in_menu', '', $show_in_menu, array('class' => 'onoffswitch-checkbox', 'id' => 'show_in_menu')) }}					   
						    <label class="onoffswitch-label" for="show_in_menu">
						        <div class="onoffswitch-inner"></div>
						        <div class="onoffswitch-switch"></div>
						    </label>
						</div>
					</li>

				</ul>
			</div><!-- .modal-body -->
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('lang.cancel') }}</button>
				<input type="submit" class="btn btn-color" value="Update Page" />
			</div>
			</form>

	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->



	@endforeach

<script type="text/javascript" src="/application/assets/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">

	//attach_tiny_mce($('textarea'));

	$(document).ready(function(){
		$('.edit-media').click(function(){
			console.log('tst');
			//attach_tiny_mce();
			var target = $(this).data('target');
			console.log(target);
			tinymce.init({
			    selector: 'textarea'+target,
			    toolbar: "styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview media | forecolor backcolor ",
			    plugins: [
			         "advlist autolink link image code lists charmap print preview hr anchor pagebreak spellchecker code fullscreen",
			         "save table contextmenu directionality emoticons template paste textcolor code"
			   ],
			   menubar:false,
			 });
		});

		$(document).on('focusin', function(e) {
		    if ($(event.target).closest(".mce-window").length) {
		        e.stopImmediatePropagation();
		    }
		});
	});
	



	tinymce.init({
	    selector: 'textarea',
	    toolbar: "styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview media | forecolor backcolor ",
	    plugins: [
	         "advlist autolink link image code lists charmap print preview hr anchor pagebreak spellchecker code fullscreen",
	         "save table contextmenu directionality emoticons template paste textcolor code"
	   ],
	   menubar:false,
	 });


</script>
