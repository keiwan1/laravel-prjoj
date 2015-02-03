<!DOCTYPE html>
<html>
<head>
    <title>Ninja Media Script Installer</title>
    <meta name="viewport" content="initial-scale=1">
    <link rel="stylesheet" href="/application/assets/installer/style.css" />

    <link rel="stylesheet" href="/application/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/application/assets/css/style.css" />
    <link rel="stylesheet" href="/application/assets/css/animate.min.css" />
    <link rel="stylesheet" href="/application/assets/css/font-awesome.min.css" />

    
</head>
<body>

	<h1 class="animated fadeInDown"><i class="fa fa-download"></i> Ninja Media Script Installer</h1>

	<div class="install_description">
		<p class="msg">Installing</p>
	</div>

	<div class="install_progress"></div>

	<div class="progress-list">

	</div>

	<div id="finish_btn">
		<a href="{{ URL::to('/') }}" id="successful_install_button" class="btn btn-success btn-finish">Click Here to Visit Your Site</a>
	</div>

	<div id="error_btn">
		<a href="{{ URL::to('/install') }}" id="error_install_button" class="btn btn-error btn-finish">Retry installation</a>
	</div>

	<form method="POST" action="#_" class="install-form animated fadeInUp">

		<label for="admin">Admin Info</label>
		<input type="text" class="form-control" name="admin_username" id="admin_username" placeholder="Admin Username" />
		<input type="text" class="form-control" name="admin_email" id="admin_email" placeholder="Admin Email" />
		<input type="password" class="form-control" name="admin_password" id="admin_password" placeholder="Admin Password" />
		<br />
		<label for="database">Database Info</label>
		<input type="text" class="form-control" name="database_host" id="database_host" placeholder="Database Host" />
		<input type="text" class="form-control" name="database_name" id="database_name" placeholder="Database Name" />
		<input type="text" class="form-control" name="database_user" id="database_user" placeholder="Database User" />
		<input type="password" class="form-control" name="database_password" id="database_password" placeholder="Database Password" />
		<div class="checkbox">
			<label>
		    	<input type="checkbox" name="preloaded_data" id="preloaded_data" checked="checked" value="1"> Add Pre-installed Media
			</label>
		</div>
		<input type="submit" class="form-control btn btn-color" value="Install" />

	</form>

<script type="text/javascript" src="/application/assets/js/jquery-2.1.0.min.js"></script>
<script type="text/javascript">

	$('.install-form').submit(function(e){
		e.preventDefault();
		$('.install-form').addClass('slideOutRight').hide();
		$('.install_description .msg').text('Testing Database Connection');
		$('.install_description').fadeIn();
		$.post("{{ URL::to('install_db') }}", { database_host: $('#database_host').val(), database_name: $('#database_name').val(), database_user: $('#database_user').val(), database_password: $('#database_password').val(), }, function(data){
			if(data == 1){

				$('.install_progress').append(progress_success_template('Successfully Updated Config File'));
				$('.install_description .msg').text('Adding Data to Database');

				$.post("{{ URL::to('install_data') }}", { database_host: $('#database_host').val(), database_name: $('#database_name').val(), database_user: $('#database_user').val(), database_password: $('#database_password').val(), preloaded_data: $('#preloaded_data').prop('checked') }, function(install_data){
					
					if(install_data == 1){
						$('.install_progress').append(progress_success_template('Successfully added database tables and data'));
						$('.install_description .msg').text('Creating New Admin Login');

						$.post("{{ URL::to('install_admin') }}", { admin_username: $('#admin_username').val(), admin_email: $('#admin_email').val(), admin_password: $('#admin_password').val(), }, function(install_admin){
							if(install_admin == 1){
								$('.install_progress').append(progress_success_template('Successfully added admin login'));
								$('.install_description').html('Install Completed Successfully');
								$('#finish_btn').fadeIn();
							} else {
								$('.install_progress').append(progress_error_template('Error: could not add admin credentials'));
								$('#error_btn').fadeIn();
								$('.install_description').html('Oops, something went wrong');
							}
						});

					} else {
						$('.install_progress').append(progress_error_template('Error: could not add database tables and data'));
						$('#error_btn').fadeIn();
						$('.install_description').html('Oops, something went wrong');
					}
				});

			} else{
				$('.install_progress').append(progress_error_template('Error: could not save db creds to config file'));
				$('#error_btn').fadeIn();
				$('.install_description').html('Oops, something went wrong');
			}
		});
	});

	function progress_success_template(msg){
		return '<p class="success animated fadeInUp"><i class="fa fa-check"></i> ' + msg + '</p>';
	}

	function progress_error_template(msg){
		return '<p class="error animated shake"><i class="fa fa-exclamation-circle"></i> ' + msg + '</p>';
	}

</script>
</body>
</html>