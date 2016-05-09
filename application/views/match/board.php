
<!DOCTYPE html>

<html>
<link href="<?= base_url()?>css/test.css" type="text/css" rel="stylesheet" />
	<head>
		<style type="text/css">
			*{
				font-family: "Century Gothic", CenturyGothic, Geneva, AppleGothic, sans-serif;
				text-align:left;

			body{margin:0;padding:0} 

			}
			body{
				background-image: url('http://backgrounds.picaboo.com/download/15/55/155f32631fd64f138687514eb46b2e8a/butterfly2.jpg'); 
				background-attachment: fixed;
			}

			input {
				display: block;
				margin: 0px auto;
			}
			.red{
				color: red;
			}
			.yellow{
				color: #D6AD33;
			}

		</style>
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="<?= base_url() ?>/js/jquery.timers.js"></script>
	<script>

		var otherUser = "<?= $otherUser->login ?>";
		var user = "<?= $user->login ?>";
		var status = "<?= $status ?>";
		
		$(function(){
			$('body').everyTime(200,function(){
					if (status == 'waiting') {
						$.getJSON('<?= base_url() ?>arcade/checkInvitation',function(data, text, jqZHR){
								if (data && data.status=='rejected') {
									alert("Enemy has rejected your request!");
									window.location.href = '<?= base_url() ?>arcade/index';
								}
								if (data && data.status=='accepted') {
									status = 'playing';
									$('#status').html('Playing ' + otherUser);
								}
								
						});
					}
						
						var url = "<?= base_url() ?>board/getBoard";
						$.getJSON(url, function (data,text,jqXHR){
							if (data && (data.status=='success' || data.status== 'otherWon')) {
								var msg = data.message;
								if (msg.length > 0){
						    		var temp = '[id=pic';
						    		temp = temp.concat(msg.toString());
						    		temp = temp.concat(']');
									$(temp).attr('src', '<?= base_url() ?>images/circle_yellow.png');
									var remains = msg%6;
									var column = (msg - remains) / 6;
									if ( remains != 0){
										column = column + 1;
									}
									var temp2 = '[id=inner';
									temp2 = temp2.concat(column);
									temp2 = temp2.concat(']');
									var temp3 = $(temp2).attr('data-col');
									$(temp2).attr('data-col', temp3-1);
									if ( data.status == 'otherWon' ){
										var lock = $('[id=outerDiv]').attr('data-lock');
										if ( lock == 1 ){

											alert('You Lose!');

											$('[id=outerDiv]').attr('data-lock', 2);
											}}
									else{
										$('[id=outerDiv]').attr('data-lock', 0);
									}
								};
							}
						});
			});

			$('[id=outerDiv]').click(function(){
				var arguments = $('form').serialize();
				var lock = $('[id=outerDiv]').attr('data-lock');
				if ( lock == 0 ){
					if( $('[name=msg]').val().length > 0){
						$('[id=outerDiv]').attr('data-lock', 1);
						var url = "<?= base_url() ?>board/postBoard";
						$.post(url,arguments, function (data,textStatus,jqXHR){
							if (data == '"youWon"'){

								alert('You Win!');

								var url = "<?= base_url() ?>board/gameSetWin";
								$.post(url, user);
							}
						});
					return false;
					}}
				});	
		});
	
	</script>
	</head> 
<body>  

		<div id="connect4" align="center">
		<img border="0" src="http://www.snazzyspace.com/banner-creator/banners/1396643529.png" height="" width=""/>

	<center>

		<div><b>Your Chip Color: <span class="red">RED</span>, Enemies Chip Color: <span class="yellow">YELLOW</span></div></b>
		<div align="center"><img border="0" src="http://www.snazzyspace.com/banner-creator/banners/1396646341.png" height="80" width="390"></div>
	
	<div>
		<b>Hello <?= $user->fullName() ?></b>  <?= anchor('account/logout','<br>Logout') ?> | 
		<?= anchor('account/gameLobby', 'Back To Lobby')?>
	</div>
	
	<div id='status'> 
	<?php 
		if ($status == "playing")
			echo "<br><i> You Are Currently Playing Against User: " . $otherUser->login."</i>";
		else
			echo "Still waiting on...." . $otherUser->login;
	?>
	</div>
	
	<?php 
	echo form_open();
	echo form_hidden('msg');
	echo form_close();
		
	$this->load->helper('url');
	
	echo " <div id = 'outerDiv' data-lock = ";
	if ($status == "playing")
		echo 0;
	else
		echo 1; 
	echo ">";
	
	for( $i = 1; $i <=7; $i++){
		echo "<div id = 'inner";
		echo $i;
		echo "' style='height: 315px;  width: 50px;' onclick = updateCol";
		echo $i;
		echo "(this) data-col = ";
		echo $i*6;
		echo ">";
		for ( $m = 1; $m <= 6; $m++){
			echo " <img src='";
			echo base_url();
			echo "images/blue.png' id='pic";
			echo ($i-1)*6 + $m;
			echo "'/>";
		}
		echo "</div>";
	}
	echo "</div>";
	
		
	echo "<script type='text/javascript'>";
	
	for ($u = 1; $u <=7; $u++){
		echo "function updateCol";
		echo $u;
		echo " (obj){";
		echo "var outer = document.getElementById('outerDiv');";
		echo "var lock = outer.getAttribute('data-lock');";
		echo "if( lock == 0){"; 
		echo "var cur = obj.getAttribute('data-col');";
		echo "if( cur >";
		echo ($u - 1)* 6;
		echo "){
    		var temp = 'pic';
    		var temp2 = cur;
			   temp = temp.concat(temp2);
			   var gp = document.getElementById(temp);
    		   gp.src = '";
		echo base_url();
		echo "images/circle_red.png';";
		echo "$('[name=msg]').val(temp2);";
		echo "obj.setAttribute('data-col', temp2-1);";
		echo "} else{";
		echo "$('[name=msg]').val('');";
		echo "}";
		echo "}}";	
	}
	
	echo "</script>";?>
   
    </center>
</body>

</html>

