<!DOCTYPE HTML>
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
	<script>
		function updateLeaderBoard(data)
		{
			var board = document.getElementById("leaderboard");
			board.innerHTML = "<th>Rank</th><th>Name</th><th>Score</th>";
			for(var i= 0; i < data.length && i < 10; i++)
			{
				board.innerHTML += "<tr><td>" + (i+1) + "</td><td>" + data[i].user.name + "</td><td>" + data[i].score + "</td></tr>";
			}

		}
	    function updateHighScore(score)
	    {
		    var xmlhttp;    
		    
		    if (window.XMLHttpRequest)
			    {// code for IE7+, Firefox, Chrome, Opera, Safari
			    xmlhttp=new XMLHttpRequest();
			    }
		    else
			    {// code for IE6, IE5
			    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			    }
		    xmlhttp.onreadystatechange=function()
			    {
			    if (xmlhttp.readyState==4 && xmlhttp.status==200)
				    {
							document.getElementById("score_cell").innerHTML = xmlhttp.responseText;
					   //send the new high score to facebook
						 FB.api("/me/scores?score=" + xmlhttp.responseText, "post", function(response){});
						 //read the scores for your friends and update the leaderboard
						 FB.api("/" + appID +"/scores", "get", function(response){updateLeaderBoard(response.data);});
						 // alert("request complete " + xmlhttp.responseText);
				    //document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
				    }
			    }
		    xmlhttp.open("GET","updateHighScore.php?scr="+score+"&usr="+window.parent.getUserId(),true);
		    xmlhttp.send();
		    }
		    var score = 0;
	    </script>
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
					
					
					
					for($i=0; $i<=5; $i++){
					$randomnumarray[$i] = rand(0,$friendcount-5);
						for($j=0; $j<$i; $j++){
							while ($randomnumarray[$j] == $randomnumarray[$i]){
								$randomnumarray[$i] = rand(0, $friendcount-5);
								$j = 0;
							}
						}
					}
					$randomfriendnum = $randomnumarray[0];
					$randomfriendnum1 = $randomnumarray[1];
					$randomfriendnum2 = $randomnumarray[2];
					$randomfriendnum3 = $randomnumarray[3];
					$randomfriendnum4 = $randomnumarray[4];
			
					$randomfriend= $friends[$randomfriendnum];
					
					$randomfriend2 = $friends[$randomfriendnum1];
					$randomfriend3 = $friends[$randomfriendnum2];
					$randomfriend4 = $friends[$randomfriendnum3];
					$randomfriend5 = $friends[$randomfriendnum4];
					echo "<img src='http://graph.facebook.com/" . $randomfriend['id']  ."/picture'>";
					echo "<img src='http://graph.facebook.com/" . $randomfriend2['id']  ."/picture'>";
					echo "<img src='http://graph.facebook.com/" . $randomfriend3['id']  ."/picture'>";
					echo "<img src='http://graph.facebook.com/" . $randomfriend4['id']  ."/picture'>";
					echo "<img src='http://graph.facebook.com/" . $randomfriend5['id']  ."/picture'>";
					$connected = true;
					
					$randomfriendimage = "http://graph.facebook.com/" . $randomfriend['id']  ."/picture";
					$randomfriendimage2 = "http://graph.facebook.com/" . $randomfriend2['id']  ."/picture";
					$randomfriendimage3 = "http://graph.facebook.com/" . $randomfriend3['id']  ."/picture";
					$randomfriendimage4 = "http://graph.facebook.com/" . $randomfriend4['id']  ."/picture";
					$randomfriendimage5 = "http://graph.facebook.com/" . $randomfriend5['id']  ."/picture";
		
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
			$tname = $row["NAME"];
			$thscore = $row["HSCORE"];
			if($userId == $id)
			{
					$newuser = false;
					$name=$row["NAME"];
					$hscore=$row["HSCORE"];
			}
      echo "<b> $tname </b><br>Score: $thscore <br>";
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
    <fb:login-button scope ='publish_stream, friends_games_activity, user_games_activity'></fb:login-button>
    <?php } ?>


        <div id="fb-root"></div>
        <script>
					var appID = '312229638880822';
          window.fbAsyncInit = function() {
            FB.init({
              appId      : appID, // App ID
              status     : true, // check login status
              cookie     : true, // enable cookies to allow the server to access the session
              xfbml      : true  // parse XFBML
            });
				FB.getLoginStatus(function(response) {
					if (response.status === 'connected') {
						// connected
						FB.api("/" + appID +"/scores", "get", function(response){updateLeaderBoard(response.data);});
					} else if (response.status === 'not_authorized') {
						// not_authorized;
					} else {
						// not_logged_in
					}
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
           
           function postToFeed(){
           var obj = {
           	method: 'feed',
           	redirect_uri: 'http://game.courses.asu.edu',
           	link: 'https://developers.facebook.com/docs/reference/dialogs',
           	picture: 'http://fbrell.com/f8.jpg',
           	caption: 'Reference Documentation',
           	description: 'Someone beat your High Score in Cabin Crashers! Play again!'
           	
           };
           
           function callback(response) {
           	document.getElementById('msg').innerHTML = "Post ID: " + response['post_id'];
           	
           }
           FB.ui(obj, callback);
           }
        </script>
				
		<p id="textColor">click to select player</p>
		<p id="textColor">click again to move them</p>
		<br/>
		
		<audio id="MyAudio" loop="true">
			<source src="testHouseholds.mp3" type="audio/mpeg"/> //Rest of the browsers
			<source src="testHouseholds.ogg" type="audio/ogg" /> //Firefox, since MP3 is not supported
		</audio>
		<button type="button" onclick="updateHighScore(score)">Update Score</button>
		<button type="button" onclick="postToFeed()">Post to Feed</button>
		
		<script>
		
		
			function getUserId()
			{
				return <?php echo $userId; ?>;
			}
			function resize() {
				var width = window.innerWidth/2 - 500;
				document.getElementById("centerCanvas").style.paddingLeft = width.toString() - 12 + "px";
				document.getElementById("tables").style.paddingLeft = width.toString() - 12 + "px";
			}
			function refresh(){
				drawFloor();
			}
			window.onload = refresh;
			window.onresize = resize;
			
			var friendPics = new Array();
			var connectedFacebook = false;
			if("<?php echo $connected ?>"){
			   friendPics.push("<?php echo $randomfriendimage ?>");
			   friendPics.push("<?php echo $randomfriendimage2 ?>");
			   friendPics.push("<?php echo $randomfriendimage3 ?>");
			   friendPics.push("<?php echo $randomfriendimage4 ?>");
			   friendPics.push("<?php echo $randomfriendimage5 ?>");
			   connectedFacebook = true;
			}			
		</script>
		
		<div id="centerCanvas" style="height: 630px;">
		<span id="centerCanvas" style="height: 630px;">
			
			<!--<iframe src="capstonegame.php" height="624" width="1024" scrolling="no" frameborder="no">
				<p>Your browser does not support iframes.</p>
			</iframe>-->
			<canvas id = "menu" width = "1000" height = "600" style = "z-index: 4; position: absolute;">
				Your browser does not support the HTML5 canvas tag
			</canvas>
			<canvas id = "canvas" width = "1000" height = "600" style = "z-index: 3; position: absolute;">
				Your browser does not support the HTML5 canvas tag
			</canvas>
			<canvas id = "canvasFloor" width = "1000" height = "600" style = "z-index: 1; position: absolute;">
				Your browser does not support the HTML5 canvas tag
			</canvas>
			<canvas id = "canvasWalls" width = "1000" height = "600" style = "z-index: 2; position: absolute;">
				Your browser does not support the HTML5 canvas tag
			</canvas>
		</span>
		</div>

		<script src="game.php"></script>
		
		
		<div id="tables">
			<?php if($userId){ ?>
				
				<h2 style="color: #ffff00;"><?php echo $name ?>'s stats: </h2>
				<table><tr><th>High Score</th></tr><tr><td id="score_cell"><?php echo $hscore ?></td></tr></table>
				<h2 style="color: #ffff00;">Friends Leaderboard</h2>
				<table id="leaderboard"></table>
				<?php } ?>
				<br>
				<div><iframe src = "https://www.facebook.com/plugins/like.php?href=http://game.courses.asu.edu/"
					scrolling = "no" frameborder = "0">
					Sorry your browser doesn't support inline frames
					</iframe>
				</div>
		</div>
			<script>
				resize();
			</script>
		<a href="example.htm" id="button3" class="buttonText">Tic Tac Toe</a>
		<a href="http://austin.thautech.com" id="button3" class="buttonText">Austin</a>
		<a href="collision.htm" id="button3" class="buttonText">collisions</a>
	</body>
</html>
