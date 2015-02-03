<!DOCTYPE html>
<html>
<head>
    <title>Ninja Media Script Installer</title>
    <meta name="viewport" content="initial-scale=1">
    

    <link rel="stylesheet" href="application/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="application/assets/css/style.css" />
    <link rel="stylesheet" href="application/assets/css/animate.min.css" />
    <link rel="stylesheet" href="application/assets/css/font-awesome.min.css" />
    <link rel="stylesheet" href="application/assets/installer/style.css" />

    
</head>
<body>

	<h1 class="animated fadeInDown"><i class="fa fa-download"></i> Ninja Media Script Installer</h1>

	<ol class="progtrckr" data-progtrckr-steps="3">
	    <li class="progress-requirements progtrckr-todo">System Requirements</li>
	    <li class="progress-creds progtrckr-todo">Configuration Setup</li>
	    <li class="progress-install progtrckr-todo">Installation</li>
	</ol> 


	<div id="requirements" class="install-form animated fadeInUp">
		<?php

			$writable_files = getcwd() . '/config.php';

			$passed = run_checks($writable_files);


			function new_line(){
				echo '<br />';
			}

			function run_checks($writable_files){

				$passed = true;

				if(is_writable($writable_files)){
					echo '<p>Files and Folders are Writable <i class="fa fa-check-circle-o"></i></p>';
					$config_string = "<?php return array();";
					file_put_contents('./config.php', $config_string);
				} else {
					echo '<p>Files not writable! <i class="fa fa-times-circle-o"></i></p>';
					$passed = false;
				}
				new_line();

				if(version_compare(PHP_VERSION , "5.3.7", ">=")){
					echo '<p>PHP 5.3.7 or greater installed <i class="fa fa-check-circle-o"></i></p>';
				} else {
					echo '<p>minumum version of PHP 5.4 is required <i class="fa fa-times-circle-o"></i></p>';
					$passed = false;
				}
				new_line();

				if(!ini_get('safe_mode')){
					echo '<p>Safe mode is not enabled <i class="fa fa-check-circle-o"></i></p>';
				} else {
					echo '<p>Safe mode is enabled <i class="fa fa-times-circle-o"></i></p>';
					$passed = false;
				}
				new_line();

				if(defined('PDO::ATTR_DRIVER_NAME')){
					echo '<p>PDO Driver is enabled <i class="fa fa-check-circle-o"></i></p>';
				} else {
					echo '<p>PDO Driver is not enabled <i class="fa fa-times-circle-o"></i></p>';
					$passed = false;
				}
				new_line();

				if(extension_loaded('mcrypt')){
					echo '<p>Mcrypt library is available <i class="fa fa-check-circle-o"></i></p>';
				} else {
					echo '<p>Mcrypt library is not available <i class="fa fa-times-circle-o"></i></p>';
					$passed = false;
				}
				new_line();

				if(extension_loaded('gd')){
					echo '<p>GD library is available <i class="fa fa-check-circle-o"></i></p>';
				} else {
					echo '<p>GD library is not available <i class="fa fa-times-circle-o"></i></p>';
					$passed = false;
				}
				new_line();

				if(function_exists('curl_init')){
					echo '<p>Curl library is available <i class="fa fa-check-circle-o"></i></p>';
				} else {
					echo '<p>Curl library is not available <i class="fa fa-times-circle-o"></i></p>';
					$passed = false;
				}
				new_line();

				return $passed;
			}

			
			if($passed){
				echo '<div class="form-control btn btn-color step1-complete">Next<i class="fa fa-arrow-right"></i></div>';
			} else {
				echo '<div class="form-control btn btn-color step1-complete">Continue Anyway</div>';
			}

		?>


	</div>


	<div class="install_description"></div>

	<div class="install_progress"></div>

	<div class="progress-list">

	</div>

	<div id="finish_btn">
		<a href="/" id="successful_install_button" class="btn btn-success btn-finish">Click Here to Visit Your Site</a>
	</div>

	<div id="error_btn">
		<a href="/install.php" id="error_install_button" class="btn btn-error btn-finish">Retry installation</a>
	</div>

	<div id="config_setup">

		<form method="POST" action="#_" class="install-form animated fadeInUp">
			
			<label for="database">Database Info</label>
			<input type="text" class="form-control" name="database_host" id="database_host" placeholder="Database Host" />
			<input type="text" class="form-control" name="database_name" id="database_name" placeholder="Database Name" />
			<input type="text" class="form-control" name="database_user" id="database_user" placeholder="Database User" />
			<input type="password" class="form-control" name="database_password" id="database_password" placeholder="Database Password" />
			<br />
			<label for="admin">Admin Info</label>
			<input type="text" class="form-control" name="admin_username" id="admin_username" placeholder="Admin Username" />
			<input type="text" class="form-control" name="admin_email" id="admin_email" placeholder="Admin Email" />
			<input type="password" class="form-control" name="admin_password" id="admin_password" placeholder="Admin Password" />
			

			<div class="checkbox">
				<label>
			    	<input type="checkbox" name="preloaded_data" id="preloaded_data" checked="checked" value="1"> Add Pre-installed Media
				</label>
			</div>
			
			<div class="form-control btn btn-color step2-complete">Next<i class="fa fa-arrow-right"></i></div>

		</form>
	</div>

	<div id="install" class="animated fadeInUp">
		<p>Finally, run the script installer</p>
		<div class="form-control btn btn-color step3-complete">Install <i class="fa fa-download"></i></div>
		<div class="install_message">
			<p><i class="fa fa-spin fa-cog"></i> Working Some Magic...</p>
			<div id="install-prog"><span class="progress"></span></div>
		</div>
	</div>

	<div id="main_bg"></div>

<script type="text/javascript" src="application/assets/js/jquery-2.1.0.min.js"></script>
<script type="text/javascript">

	$('.step1-complete').click(function(){
		step1_complete();
	});

	$('.install-form').submit(function(e){
		e.preventDefault();
		step2_complete();
	});

	$('.step2-complete').click(function(){
		step2_complete();
	});

	$('.step3-complete').click(function(){
		step3_complete();
	});

	function step1_complete(){
		$('#requirements').fadeOut('fast', function(){
			$('.progress-requirements').removeClass('progtrckr-todo').addClass('progtrckr-done');
			$('#config_setup').fadeIn();
		});
	}

	function step2_complete(){
		$('.install-form').addClass('slideOutRight').hide();
		$('.install_description').html('<i class="fa fa-spin fa-cog"></i> Adding Credentials');
		$('.install_description').fadeIn();
		$.post("/install_setup", { database_host: $('#database_host').val(), database_name: $('#database_name').val(), database_user: $('#database_user').val(), database_password: $('#database_password').val(), }, function(data){
			if(data == 1){

				$('#config_setup').fadeOut('fast', function(){
					$('.progress-creds').removeClass('progtrckr-todo').addClass('progtrckr-done');
					$('.install_description').fadeOut();
					$('#install').fadeIn();
				});

			} else{
				$('.install_progress').append(progress_error_template('Error: could not save db creds to config file'));
				$('#error_btn').fadeIn();
				$('.install_description').html('Oops, something went wrong');
			}
		});
	}

	function step3_complete(){
		$('#install p, #install .btn').fadeOut('fast', function(){
			$('.install_message').fadeIn();
			$('.install_message p').fadeIn();
			$('.install_progress').addClass('paddingtop');
		});

		$.post("/install_data", { preloaded_data: $('#preloaded_data').prop('checked') }, function(data){
			if(data){
				$.post("/install_admin", { admin_username: $('#admin_username').val(), admin_email: $('#admin_email').val(), admin_password: $('#admin_password').val() }, function(install_admin){
					if(install_admin == 1){
						
						increment_progress();
					
					} else {
						$('.install_progress').append(progress_error_template('Error: could not add admin credentials'));
						$('#error_btn').fadeIn();
						$('.install_description').html('Oops, something went wrong');
					}

				});
			} else {
				$('.install_progress').append(progress_error_template('Error: could not add database tables and content'));
				$('#error_btn').fadeIn();
				$('.install_description').html('Oops, something went wrong');
			}
		});
		

		
		
		
	}

	function increment_progress(){
		
		$( ".progress" ).animate({
		    opacity: 0.25,
		    width: "100%",
		  }, 2000, function() {
		  	$('.progress-install').removeClass('progtrckr-todo').addClass('progtrckr-done');
		  	$('.install_message').fadeOut('fast', function(){
		  		$('.install_progress').append(progress_success_template('Successfully added database tables'));
		   		$('.install_progress').append(progress_success_template('Successfully added admin login'));
				$('.install_description').html('Install Completed Successfully');
				$('#finish_btn').fadeIn();
			});
		  });
	}

	function progress_success_template(msg){
		return '<p class="success animated fadeInUp"><i class="fa fa-check"></i> ' + msg + '</p>';
	}

	function progress_error_template(msg){
		return '<p class="error animated shake"><i class="fa fa-exclamation-circle"></i> ' + msg + '</p>';
	}

</script>
</body>
</html>
