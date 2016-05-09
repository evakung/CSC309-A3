
<!DOCTYPE html>

<html>
	<head>
		<style>
			*{
				font-family: "Century Gothic", CenturyGothic, Geneva, AppleGothic, sans-serif;
				text-align: center;
			}
			body{
				background-image: url('http://backgrounds.picaboo.com/download/15/55/155f32631fd64f138687514eb46b2e8a/butterfly2.jpg'); 
				background-attachment: fixed;
			}
			input {
				display: block;
				margin: 0px auto;
			}
			*{
				font-family: "Century Gothic", CenturyGothic, Geneva, AppleGothic, sans-serif;
			}
			body{
				background-image: url('http://backgrounds.picaboo.com/download/15/55/155f32631fd64f138687514eb46b2e8a/butterfly2.jpg'); 
				background-attachment: fixed;
			}
		</style>

	</head> 
<body>  


	<div align="center">
	 	<img border="0" src="http://www.snazzyspace.com/banner-creator/banners/1396643529.png" height="" width=""/>
	</div>
	<h3>Recover Your Password</h3>


		 <div align="center">
	 	<img border="0" src="http://www.snazzyspace.com/banner-creator/banners/1396643529.png" height="" width=""/>
	 </div>
	<h1>Recover Password</h1>

<?php 
	if (isset($errorMsg)) {
		echo "<p>" . $errorMsg . "</p>";
	}
	echo form_open('account/recoverPassword');

	echo form_label('Enter Your Email: '); 
	echo form_error('email');
	echo form_input('email',set_value('email'),"required");
	echo "<br>";

	echo form_label('Email'); 
	echo form_error('email');
	echo form_input('email',set_value('email'),"required");

	echo form_submit('submit', 'Recover Password');
	echo form_close();
	echo "<p>".anchor('account/login', 'Back').'</p>';
?>	

</body>

</html>

