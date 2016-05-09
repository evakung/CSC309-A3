
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
		margin:0;
		padding:0 
	}

	</style> 
<!-- color : #2522d4-->
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="<?= base_url() ?>/js/jquery.timers.js"></script>
	<script>
		$(function(){
			$('#availableUsers').everyTime(500,function(){
					$('#availableUsers').load('<?= base_url() ?>arcade/getAvailableUsers');

					$.getJSON('<?= base_url() ?>arcade/getInvitation',function(data, text, jqZHR){
							if (data && data.invited) {
								var user=data.login;
								var time=data.time;

								if(confirm('Play against ' + user + '?')) 

									$.getJSON('<?= base_url() ?>arcade/acceptInvitation',function(data, text, jqZHR){
										if (data && data.status == 'success')
											window.location.href = '<?= base_url() ?>board/index'
									});
								else  
									$.post("<?= base_url() ?>arcade/declineInvitation");
							}
						});
				});
			});
	
	</script>
	</head> 
<body> 
<center>
	
	<div id="connect4" align="center">
		<img border="0" src="http://www.snazzyspace.com/banner-creator/banners/1396643529.png" height="" width=""/>
	</div>
	
	<div>
	<h2>Welcome, <?= $user->fullName() ?> !</h2> <br><?= anchor('account/logout','Logout') ?> | <?= anchor('account/updatePasswordForm','Change Password') ?>
	</div>
	
<?php 
	if (isset($errmsg)) 
		echo "<p>$errmsg</p>";
?>
<!-- GAMELOBBY Available Users ! -->

	 <div id="lobby" align="left"><img border="0" src="http://www.snazzyspace.com/banner-creator/banners/1396643818.png" height="80" width="390"/></a></div>

	 <b>
	<div id="availableUsers">
	</div>
	
	</center>

	</b>

</body>

</html>

