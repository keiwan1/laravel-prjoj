<!-- Edit User Profile -->

	<div class="modal fade" id="edit-modal" data-id="edit-user-profile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="myModalLabel">{{ Lang::get('lang.edit_profile') }}</h4>
	      </div>
	      <div class="modal-body">
	      
	      	<form method="POST" action="{{ URL::to('/') }}/user/update/{{ Auth::user()->id }}" accept-charset="UTF-8" enctype="multipart/form-data">
			<ul>
				<li>
					<label for="username" >{{ Lang::get('lang.username') }}:</label>					
					<input name="username" type="text" id="username" class="form-control" value="{{ Auth::user()->username }}">
				</li>
				<li>
					<label for="email">{{ Lang::get('lang.email_address') }}:</label>					
					<input name="email" type="text" id="email" class="form-control" value="{{ Auth::user()->email }}">
				</li>
				<li>
					<label for="image" style="margin-left:24px; margin-top:10px;">{{ Lang::get('lang.update_avatar') }}</label>
		            <img src="{{ URL::to('') }}/content/uploads/avatars/{{ Auth::user()->avatar }}" alt="{{ $user->username }}" class="img-circle user-avatar-medium pull-left" style="width:75px">
		            {{ Form::file('file', array('name' => 'avatar', 'style' => 'line-height:15px; margin-left:100px;')) }}
		            <div style="clear:both"></div>
		        </li>
		        <li>
					<lable for="password">{{ Lang::get('lang.password_edit') }}:</label>
					<input type="password" name="password" id="password" class="form-control" />


			<input type="hidden" id="id" name="id" value="{{ Auth::user()->id }}" />
			<input type="hidden" id="redirect" name="redirect" value="{{ Request::url() }}" />

	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('lang.cancel') }}</button>
	        <input type="submit" class="btn btn-color" value="{{ Lang::get('lang.update_profile') }}" />
	      </div>
	      </form>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

<!-- End Edit User Profile -->