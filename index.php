<?php require 'php-sdk/facebook.php';
$facebook = new Facebook(array(
  'appId'  => '312229638880822',
  'secret' => '20b2eba7de6a54af3c2137d169c7a5f6',
	'sharedSession' => true,
	'trustForwarded' => true,
));

$userId = $facebook->getUser();


		$username = "gameadm";
		$password = "7IjJDGpB";
		$hostname = "localhost"; 

		//connection to the database
		$dbhandle = mysql_connect($hostname, $username, $password) 
		  or die("Unable to connect to MySQL");
		echo "Connected to MySQL<br>";

		printf("MySQL server version: %s\n", mysql_get_server_info());


		@mysql_select_db("gameadm_usertest") or die( "Unable to select database");
		$result = mysql_query("SELECT * FROM test1");
		mysql_close($dbhandle);
		//fetch tha data from the database
		while ($row = mysql_fetch_array($result)) {
		   echo "ID:".$row{'ID'}." Name:".$row{'Name'}." ".$row{'Score'}."<br>";
		}
?>
<html xmlns:fb="https://www.facebook.com/2008/fbml">
	<head>
		<title>Project</title>
		<link rel="stylesheet" type="text/css" href="styleTest.css">
		
	</head>
	<body>
		<!-- <div class="title">Hello</div> -->
		<h1 id="colorTitle">Game</h1>

  <div id="fb-root"></div>
    <?php
		
			if ($userId) {
				try{
					$userInfo = $facebook->api('/' . $userId);
					$friends=$facebook->api('/me/friends');
					$friends=$friends['data'];
					$friendcount = count($friends);
					$randomfriendnum = rand(0,$friendcount-1);
					$randomfriend = $friends[$randomfriendnum];
					
					$randomfriend2 = $friends[$randomfriendnum+1];
					$randomfriend3 = $friends[$randomfriendnum+2];
					$randomfriend4 = $friends[$randomfriendnum+3];
					$randomfriend5 = $friends[$randomfriendnum+4];
					echo "<img src='http://graph.facebook.com/" . $randomfriend['id']  ."/picture'>";
					echo "<img src='http://graph.facebook.com/" . $randomfriend2['id']  ."/picture'>";
					echo "<img src='http://graph.facebook.com/" . $randomfriend3['id']  ."/picture'>";
					echo "<img src='http://graph.facebook.com/" . $randomfriend4['id']  ."/picture'>";
					echo "<img src='http://graph.facebook.com/" . $randomfriend5['id']  ."/picture'>";
		
				 foreach($friends['data'] as $key=>$value)
				 {
								echo "<img src='http://graph.facebook.com/" . $value['id'] ."/picture'><br>"  ; 
				 }
				}catch(FacebookApiException $e) {
					$result = $e->getResult();
					echo $result;
				}


		$dbhandle = mysql_connect($hostname, $username, $password) 
		  or die("Unable to connect to MySQL");
		echo "Connected to MySQL<br>";

		@mysql_select_db("gameadm_usertest") or die( "Unable to select database");
		$result = mysql_query("SELECT * FROM userdata");
		 echo "<b><center>Database Test</center></b><br><br>";
		//fetch tha data from the database
		$newuser =true;
		while ($row = mysql_fetch_array($result)) {
			$id = $row["ID"];
			if($userId == $id)
			{
					$newuser = false;
					$name=$row["NAME"];
					$hscore=$row["HSCORE"];
			}
      echo "<b>$name </b><br>Score: $hscore <br>";
		}
			if($newuser == 1)
			{ 
				$dbresult = mysql_query("INSERT INTO userdata (ID, NAME, HSCORE) VALUES (" . intval($userId) . ", '" . $userInfo["name"] . "', 0)") or die (mysql_error());
			$name=$userInfo["name"];
      $hscore=0;
			}

		mysql_close($dbhandle);
			


		?>

		 <h2 id='colorTitle'> Welcome <?= $userInfo['name'] ?> </h2>
     <script>
function fbLogout() {
        FB.logout(function (response) {
            //Do what ever you want here when logged out like reloading the page
            window.location.reload();
        });
    }
</script>

<span id="fbLogout" onclick="fbLogout()"><a class="fb_button fb_button_medium"><span class="fb_button_text">Logout</span></a></span>
    <?php } else { ?>
      <p>Not Logged into Facebook</p>
    <fb:login-button></fb:login-button>
    <?php } ?>


        <div id="fb-root"></div>
        <script>
          window.fbAsyncInit = function() {
            FB.init({
              appId      : '312229638880822', // App ID
              status     : true, // check login status
              cookie     : true, // enable cookies to allow the server to access the session
              xfbml      : true  // parse XFBML
            });
        FB.Event.subscribe('auth.login', function(response) {
          window.location.reload();
        });
          };
          // Load the SDK Asynchronously
          (function(d){
             var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
             if (d.getElementById(id)) {return;}
             js = d.createElement('script'); js.id = id; js.async = true;
             js.src = "//connect.facebook.net/en_US/all.js";
             ref.parentNode.insertBefore(js, ref);
           }(document));
        </script>
				
		<p id="textColor">click to select player</p>
		<p id="textColor">click again to move them</p>
		<br/>
		
		<script>
			function resize() {
				var width = window.innerWidth/2 - 500;
				document.getElementById("centerCanvas").style.paddingLeft = width.toString() - 12 + "px";
			}
			window.onresize = resize;
		</script>
		
		<span id="centerCanvas" style="height: 630px;">
			<script>
				resize();
			</script>
			<iframe src="capstonegame.php" height="624" width="1024" scrolling="no" frameborder="no">
				<p>Your browser does not support iframes.</p>
			</iframe>
		</span>
		
		<div><iframe src = "https://www.facebook.com/plugins/like.php?href=http://www.kkpsi.org/"
		scrolling = "no" frameborder = "0"
		style = "border:none; width:450px; height:80px;
		margin-top: 0; margin-left: 0; background-color: white;">
		Sorry your browser doesn't support inline frames
		</iframe></div>
		<div  style="padding-left: 500px;">
		<h2 style="color: #ffff00;"><?php echo $name ?>'s stats: </h2>
		<table><tr><th>High Score</th></tr><tr><td><?php echo $hscore ?></td></tr></table>
		</div>
			
		<a href="example.htm" id="button3" class="buttonText">Tic Tac Toe</a>
		<a href="http://austin.thautech.com" id="button3" class="buttonText">Austin</a>
		<a href="collision.htm" id="button3" class="buttonText">collisions</a>
	</body>
</html>
