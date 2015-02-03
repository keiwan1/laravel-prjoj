<div class="white_container">
	
	<h2 style="padding-bottom:20px;"><i class="fa fa-code"></i><span> {{ Lang::get('lang.add_own_css') }}</span></h2>
	<pre id="editor" class="ace-editor" style="min-height:500px; font-size:22px;">{{ $custom_css }}</pre>
	<div class="btn btn-color pull-right" id="submit-code"><i class="fa fa-code"></i> {{ Lang::get('lang.submit_custom_code') }}</div>
	<div style="clear:both"></div>
</div>


<script type="text/javascript" src="/application/assets/js/ace/ace.js"></script>
<script type="text/javascript" src="/application/assets/js/ace/mode-css.js"></script>

<script>
    var editor = ace.edit("editor");
    editor.setTheme("ace/theme/github");
    editor.getSession().setMode("ace/mode/css");

    $(document).ready(function(){
    	$('#submit-code').click(function(){
    		var new_css = editor.getSession().getValue();
    		$.post('{{ URL::to("/") }}/admin/custom_css', { css: editor.getSession().getValue() }, function(data){
    			if(data){
    				var n = noty({text: 'Successfully Updated Your Custom Code', layout: 'top', type: 'success', template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>', closeWith: ['button'], timeout:2000 });
    				$('body').append('<style type="text/css">' + new_css + '</style>');
    			}
    		});
    	});
    });

</script>