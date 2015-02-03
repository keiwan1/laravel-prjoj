
<div class="white_container">
		
		<h2 style="margin-bottom:20px; float:left;"><i class="fa fa-list"></i><span> {{ Lang::get('lang.categories') }}</span></h2>
		<div class="btn btn-color" style="margin-left:20px;" data-toggle="modal" data-target="#new-category"><span class="fa fa-plus"></span> New Category</div>
		<div style="clear:both"></div>
		<div class="table-responsive">
			<table class="table table-condensed">
				<tr>
					<th>{{ Lang::get('lang.category') }}</th>
					<th>{{ Lang::get('lang.category_total') }}</th>
					<th>{{ Lang::get('lang.order') }}</th>
					<th>{{ Lang::get('lang.actions') }}</th>
					@foreach($categories as $category)

							<tr>
								<td>
									{{ $category->name }}
								</td>
								<td>
									{{ $category->totalMedia() }}
								</td>
								<td>
									{{ $category->order }}
								</td>
								<td style="width:190px;">
									<a href="#" data-toggle="modal" data-target="#edit-{{ $category->id }}" class="btn btn-xs btn-primary edit-category" style="margin-right:10px;"><span class="fa fa-edit"></span> {{ Lang::get('lang.edit') }}</a>
									@if($category->id != 1)
										<a href="{{ URL::to('category/delete') . '/' . $category->id }}" class="btn btn-xs btn-danger"><span class="fa fa-trash-o"></span> {{ Lang::get('lang.delete') }}</a>
									@endif
								</td>
								
							</tr>
							
					@endforeach
			</table>
		</div>
		
	</div>



	<!-- Create Category Modal -->
	<div class="modal fade" id="new-category" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">{{ Lang::get('lang.category_new') }}</h4>
			</div>
		    <form method="POST" action="{{ URL::to('categories') }}" accept-charset="UTF-8">
		    <div class="modal-body">
		      
				<p><input name="name" type="text" class="form-control" id="name" placeholder="name"></p>
				<p><input name="order" type="text" class="form-control" id="order" placeholder="order"></p>
		      	
			</div><!-- .modal-body -->
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('lang.cancel') }}</button>
				<input type="submit" class="btn btn-color" value="Add Category" />
			</div>
				</form>

	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<!-- END Create Category Modal -->

	@foreach($categories as $category)
	<!-- Modal -->
	<div class="modal fade" id="edit-{{ $category->id }}" data-id="{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">{{ Lang::get('lang.editing') }} {{ $category->name }}</h4>
			</div>
			<form method="POST" action="{{ URL::to('categories/update') . '/' . $category->id }}" accept-charset="UTF-8">
		    <div class="modal-body">
		      
		      	
					<ul>
				        <li>
				        	<label for="name">{{ Lang::get('lang.name') }}</label>
		           			<input type="text" class="form-control" name="name" id="name" value="{{ $category->name }}" />
				        </li>

				        <li>
				        	<label for="order">{{ Lang::get('lang.order') }}</label>
		           			<input type="number" class="form-control" name="order" id="order" value="{{ $category->order }}" />
				        </li>
					</ul>
			</div><!-- .modal-body -->
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('lang.cancel') }}</button>
				<input type="submit" class="btn btn-color" value="Update Category" />
			</div>
			</form>

	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->



	@endforeach

<script type="text/javascript">
	$(document).ready(function(){
		$('.edit-category').click(function(){
				$(window).scrollTop(0);
			});
	});
</script>
