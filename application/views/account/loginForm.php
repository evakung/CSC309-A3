
<!DOCTYPE html>

<html>
	<head>
		<style type="text/css">
			*{
				font-family: "Century Gothic", CenturyGothic, Geneva, AppleGothic, sans-serif;
				text-align:center;

			}
			body{
				background-image: url('http://backgrounds.picaboo.com/download/15/55/155f32631fd64f138687514eb46b2e8a/butterfly2.jpg'); 
				background-attachment: fixed;
			}
			input {
				display: block;
				margin: 0px auto;
			}
			.blue{
				color: blue;
			}
		</style> 

	</head> 
<body>  

	 <div align="center">
	 	<img border="0" src="http://www.snazzyspace.com/banner-creator/banners/1396643529.png" height="" width=""/>
	 </div>

	 <div align="center">
	 	<img border="0" src="http://www.snazzyspace.com/banner-creator/banners/1396643288.png"  height="80" width="390"/>
	 </div>
<?php 
	if (isset($errorMsg)) {
		echo "<p>" . $errorMsg . "</p>";
	}


	echo form_open('account/login');
	echo form_label('Username'); 
	echo form_error('username');
	echo form_input('username',set_value('username'),"required");
	echo form_label('Password'); 
	echo form_error('password');
	echo form_password('password','',"required");
	
	echo form_submit('submit', 'Login');
	
	echo "<p>New User? Click " . anchor('account/newForm','<span class="blue">Here</span>') . " to regiser for a new account!</p>";

	echo "<p>" . anchor('account/recoverPasswordForm','<span class="blue">Forgot Password?</span> ') . "</p>";
	
	
	echo form_close();
?>	
</body>

</html>

