<!DOCTYPE html>
<html>

<head>
	<title>Account Verificaion Mail</title>
	<link
		href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&display=swap"
		rel="stylesheet">
</head>
<style>

</style>

<body>
	<div style="border:5px solid red; padding: 15px; border-radius: 10px; max-width: 500px; background-color: #c2d5c2;
			font-family: 'Open Sans', sans-serif;
			margin: 0 auto;">
		<table style="width: 100%;">
			<thead>
				<tr>
					<th style="width: 20%; "><img src="{{asset('/assets/front/img/logo.png')}}" alt="Laubaa"
							style="width: 70px; height: auto;"></th>
					<th
						style="font-size: 25px; color: darkblue; font-weight: 600; text-shadow: 0px 1px 2px darkblue; border-bottom: 1px solid darkblue; width: 80%;">
						Laubaa
					</th>
				</tr>
			</thead>

		</table>
		<div>
			<h1 style="text-align: center; font-weight: 700; font-size: 30px;">Account Activation Email</h1>
			<p>
				Dear {{$name}}, <br>

				You have Registered an account in <strong>{{route('homepage')}}</strong> in {{date('Y-m-d h:i:s')}}. <br>
				You should activate your account to login your account in{{route('homepage')}}.
				<br>
				<strong>Registered Email Address:</strong> {{$email}}
				<br>
				<strong>Registered By:</strong> {{$name}}
				<br>

				<strong>Registered with Password :</strong> {{$password}} <br> <br>
				Here below a link has been attached with this email to activate your account. <br>
				<br>
				<br>

				<strong>Account Activation link : </strong>
				<a href="{{route('activate-account',$activation_link)}}" target="_blank"
					style="overflow-wrap: break-word;">{{route('activate-account',$activation_link)}}</a>

			</p>
			<br>
			<p> Regards,</p>
			<p>Laubaa Admin</p>
		</div>

	</div>

</body>

</html>