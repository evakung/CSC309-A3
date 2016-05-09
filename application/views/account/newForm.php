
<!DOCTYPE html>

<html>
	<head>
<style>
			input{
				display: block;
				margin: 0px auto;
			}

			*{
				font-family: "Century Gothic", CenturyGothic, Geneva, AppleGothic, sans-serif;
				text-align:center;
			}
			
			body{
				background-image: url('http://backgrounds.picaboo.com/download/15/55/155f32631fd64f138687514eb46b2e8a/butterfly2.jpg'); 
				background-attachment: fixed;
			}

			a{color:blue;}
			.red{color:red;}
		</style>
		<script src="http://code.jquery.com/jquery-latest.js"></script>
		<script>
			function checkPassword() {
				var p1 = $("#pass1"); 
				var p2 = $("#pass2");
				
				if (p1.val() == p2.val()) {
					p1.get(0).setCustomValidity("");  // All is well, clear error message
					return true;
				}	
				else	 {
					p1.get(0).setCustomValidity("Passwords do not match");
					return false;
				}
			}
		</script>
	</head> 
<body>  

		<marquee direction="left" loop="20" width="25%">
Don't worry, Signing up is completely Free! 
</marquee>
		 <div align="center">
	 	<img border="0" src="http://www.snazzyspace.com/banner-creator/banners/1396643529.png" height="" width=""/>
	 </div>
	<h3>Create An Account: </h3>



<?php 
	echo '<h5><span class="red">*</span> = Required Fields</h5>';
	echo form_open('account/createNew');

	echo form_open('account/createNew');
	echo form_label('<span class="red">*</span>User Login: '); 
	echo form_error('username');
	echo form_input('username',set_value('username'),"required");
	echo form_label('<span class="red">*</span>Password: '); 
	echo form_error('password');
	echo form_password('password','',"id='pass1' required");
	echo form_label('<span class="red">*</span>Confirm Password: '); 
	echo form_error('passconf');
	echo form_password('passconf','',"id='pass2' required oninput='checkPassword();'");
	echo form_label('<span class="red">*</span>First Name: ');
	echo form_error('first');
	echo form_input('first',set_value('first'),"required");
	echo form_label('<span class="red">*</span>Last Name: ');
	echo form_error('last');
	echo form_input('last',set_value('last'),"required");
	echo form_label('<span class="red">*</span>Email Address:');
	echo form_error('email');
	echo form_input('email',set_value('email'),"required");
	
	echo "<h3>Are you human? </h3>";
?>

	Please enter what you see in the image below <br> (Case sensitive):<br>
	<img id="captcha" src="/securimage/securimage_show.php" alt="CAPTCHA Image" />
	<input type='text' name='captcha_code' size='10' maxlength='6' required/>
	<a href="#" onclick="document.getElementById('captcha').src = '/securimage/securimage_show.php?' + Math.random(); return false">
		<img src="http://www.ameriplancashbacksaver.com/images/refresh_button.jpg"><!-- Different Image --> 
	</a>


<?php
	echo form_submit('submit', 'Register');
	echo form_close();
	echo '<br><p>'.anchor('account/login', 'Back').'</p>';
?>	


</body>

</html>

