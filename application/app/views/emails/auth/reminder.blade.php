<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>{{ Lang::get('lang.password_reset') }}</h2>

		<div>
			{{ Lang::get('lang.reset_password_email') }} {{ URL::to('password_reset', array($token)) }}.
		</div>
	</body>
</html>