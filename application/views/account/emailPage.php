
<!DOCTYPE html>

<html>
	<head>
		<style type="text/css">
			*{
				font-family: "Century Gothic", CenturyGothic, Geneva, AppleGothic, sans-serif;
			}
			body{
				background-image: url('http://backgrounds.picaboo.com/download/15/55/155f32631fd64f138687514eb46b2e8a/butterfly2.jpg'); 
				background-attachment: fixed;
			}
			input {
				display: block;
			}
		</style> 
	</head> 
<body>  
		 <div align="center">
	 	<img border="0" src="http://www.snazzyspace.com/banner-creator/banners/1396643529.png" height="" width=""/>
	 </div>
	 
	<h1>Password Recovery</h1>
	
	<p>Please check your email for your new password.
	</p>
	
	
	
<?php 
	if (isset($errorMsg)) {
		echo "<p>" . $errorMsg . "</p>";
	}

	echo "<p>" . anchor('account/index','Login') . "</p>";
?>	
</body>

</html>

