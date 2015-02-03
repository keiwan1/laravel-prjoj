<!-- Edit User Profile -->

	<div class="modal fade" id="aboutpoints" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-question-circle"></i> {{ Lang::get('lang.how') }}</h4>
	      </div>
	      <div class="modal-body">
	      
	      	<p>{{ Lang::get('lang.here_is_how') }}</p>
	      	<ul>
	      		<li>{{ Lang::get('lang.earn_points_1') }}</li>
	      		<li>{{ Lang::get('lang.earn_points_2') }}</li>
	      		<li>{{ Lang::get('lang.earn_points_3') }}</li>
	      	</ul>

	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('lang.close') }}</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

<!-- End Edit User Profile -->