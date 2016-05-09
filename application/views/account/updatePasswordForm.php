
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
		 <div align="center">
	 	<img border="0" src="http://www.snazzyspace.com/banner-creator/banners/1396643529.png" height="" width=""/>
	 </div>

	 <div align="center">
	 	<img border="0" src="http://www.snazzyspace.com/banner-creator/banners/1396644191.png"  height="80" width="390"/>
	 </div>

<?php 
	if (isset($errorMsg)) {
		echo "<p>" . $errorMsg . "</p>";
	}
	echo '<h5><span class="red">*</span> = Required Fields</h5>';
	echo form_open('account/updatePassword');

	echo form_label('<span class="red">*</span>Current Password: '); 
	echo form_error('oldPassword');
	echo form_password('oldPassword',set_value('oldPassword'),"required");
	echo form_label('<br><span class="red">*</span>New Password: '); 
	echo form_error('newPassword');
	echo form_password('newPassword','',"id='pass1' required");
	echo form_label('<br><span class="red">*</span>Password Confirmation: '); 
	echo form_error('passconf');
	echo form_password('passconf','',"id='pass2' required oninput='checkPassword();'");
	echo "<br>";

	echo form_submit('submit', 'Change Password');
	echo form_close();

	echo '<br><p>'.anchor('account/gameLobby', 'Back').'</p>';
?>	


</body>

</html>

