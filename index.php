<!DOCTYPE HTML>

<?php require 'php-sdk/facebook.php';
$facebook = new Facebook(array(
  'appId'  => '312229638880822',
  'secret' => '20b2eba7de6a54af3c2137d169c7a5f6',
	'sharedSession' => true,
	'trustForwarded' => true,
));

$userId = $facebook->getUser();

		$hscore = 0;
		$score = 0;
		$gamesplayed = 0;
		$username = "gameadm";
		$password = "7IjJDGpB";
		$hostname = "localhost"; 

		//connection to the database
		$dbhandle = mysql_connect($hostname, $username, $password) 
		  or die("Unable to connect to MySQL");
	//	echo "Connected to MySQL<br>";

		//printf("MySQL server version: %s\n", mysql_get_server_info());


		@mysql_select_db("gameadm_usertest") or die( "Unable to select database");
		$result = mysql_query("SELECT * FROM test1");
		mysql_close($dbhandle);
		//fetch tha data from the database
		while ($row = mysql_fetch_array($result)) {
		   //echo "ID:".$row{'ID'}." Name:".$row{'Name'}." ".$row{'Score'}."<br>";
		}
?>
<html xmlns:fb="https://www.facebook.com/2008/fbml">
	<head>
	
		<title>Cabin Crashers</title>
		<link rel="stylesheet" type="text/css" href="styleTest.css">
	       <link rel="shortcut icon" href="favicon.ico">
	       <meta property="og:image" content="https://fbcdn-photos-d-a.akamaihd.net/hphotos-ak-ash3/851556_331805843589868_516124963_n.png"/>
	       <meta property="og:title" content="Cabin Crashers!"/>
	       <meta property="og:url" content="http://game.courses.asu.edu"/>
	       <meta property="og:site_name" content="Cabin Crashers: An Online Facebook Game"/>
	       <meta property="og:type" content="facebook game"/>
	       <meta name="description" content="Save your pie, and your cabin, from the hungry woodland creatures in this unique online facebook game!"
	       
	</head>
	<script>
		function updateLeaderBoard(data)
		{
			var board = document.getElementById("leaderboard");
			board.innerHTML = "<th>Rank</th><th>Name</th><th>Score</th>";
			for(var i= 0; i < data.length && i < 10; i++)
			{
				leadernames[i] = data[i].user.name;
				leaderscores[i] = data[i].score;
				board.innerHTML += "<tr><td>" + (i+1) + "</td><td>" + data[i].user.name + "</td><td>" + data[i].score + "</td></tr>";
			}

		}
	    function updateHighScore(score)
	    {
				score = Math.floor(score);
		    var xmlhttp;    
		    gamesplayed++;
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
							//document.getElementById("score_cell").innerHTML = xmlhttp.responseText;
					   //send the new high score to facebook
						 FB.api("/me/scores?score=" + xmlhttp.responseText, "post", function(response){
							FB.api("/" + appID +"/scores", "get", function(response){updateLeaderBoard(response.data);});
							});
						 //read the scores for your friends and update the leaderboard
						 
						 // alert("request complete " + xmlhttp.responseText);
				    //document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
				    }
			    }
		    xmlhttp.open("GET","updateHighScore.php?scr="+score+"&usr="+ getUserId() +"&games="+gamesplayed,true);
				xmlhttp.send();
		    }
				var loggedIn = true;
		    
	    </script>
	<body>
		<!-- UPPER UI BAR ----------------------------------- -->
		<div id="upperBar" >
			<div style="float:left; width:500px;"><img src="art\GUI\LogoSimple.png" width=486px height=300px></div>
			<div style="text-align: center; height: 300px; clear: right;" id="rightBox" class="mainfont">
				<span style=" font-size: 60px;" id="welcome"><br>Welcome, please log in!</span>
			</div>
		</div>

  <div id="fb-root"></div>
    <?php
			if ($userId) {
				try{

					echo "<script>loggedIn = true</script>";
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
					//$randomfriendnum3 = $randomnumarray[3];
					//$randomfriendnum4 = $randomnumarray[4];

					$randomfriend= $friends[$randomfriendnum];

					$randomfriend2 = $friends[$randomfriendnum1];
					$randomfriend3 = $friends[$randomfriendnum2];
					//$randomfriend4 = $friends[$randomfriendnum3];
					//$randomfriend5 = $friends[$randomfriendnum4];
					//echo "<img src='http://graph.facebook.com/" . $randomfriend['id']  ."/picture'>";
					//echo "<img src='http://graph.facebook.com/" . $randomfriend2['id']  ."/picture'>";
					//echo "<img src='http://graph.facebook.com/" . $randomfriend3['id']  ."/picture'>";
					//echo "<img src='http://graph.facebook.com/" . $randomfriend4['id']  ."/picture'>";
					//echo "<img src='http://graph.facebook.com/" . $randomfriend5['id']  ."/picture'>";
                                        
					$connected = true;

					$randomfriendimage = "http://graph.facebook.com/" . $randomfriend['id']  ."/picture";
					$randomfriendimage2 = "http://graph.facebook.com/" . $randomfriend2['id']  ."/picture";
					$randomfriendimage3 = "http://graph.facebook.com/" . $randomfriend3['id']  ."/picture";
					//$randomfriendimage4 = "http://graph.facebook.com/" . $randomfriend4['id']  ."/picture";
					//$randomfriendimage5 = "http://graph.facebook.com/" . $randomfriend5['id']  ."/picture";
                                        $userImage = "http://graph.facebook.com/" . $userInfo['id'] . "/picture";
                                        
                                        $friendId1 = $randomfriend['id'];
                                        $friendId2 = $randomfriend2['id'];
                                        $friendId3 = $randomfriend3['id'];
                                        
                                        $friendname1 = explode (" ", $randomfriend['name']);
                                        $randomfriendName = $friendname1[0];
                                        $friendname2 = explode (" ", $randomfriend2['name']);
                                        $randomfriendName2 = $friendname2[0];
                                        $friendname3 = explode (" ", $randomfriend3['name']);
                                        $randomfriendName3 = $friendname3[0];
                                        /*$friendname4 = explode (" ", $randomfriend4['name']);
                                        $randomfriendName4 = $friendname4[0];
                                        $friendname5 = explode (" ", $randomfriend5['name']);
                                        $randomfriendName5 = $friendname5[0];*/

                                        $userfirstname = explode (" ", $userInfo['name']);
                                        $userName= $userfirstname[0];
                                        
                                        
                                        $userGender - $userInfo['gender'];
                                        $randomfriendGender = $randomfriend['gender'];
                                        $randomfriendGender2 = $randomfriend2['gender'];
                                        $randomfriendGender3 = $randomfriend3['gender'];
                                        
				 foreach($friends['data'] as $key=>$value)
				 {
					//echo "<img src='http://graph.facebook.com/" . $value['id'] ."/picture'><br>"  ; 
				 }

				}catch(FacebookApiException $e) {
					$result = $e->getType();
					//echo $result;
					//echo "<script>console.log(". $result .");</script>";
					echo "<script>loggedIn = false;</script>";
				}

		$dbhandle = mysql_connect($hostname, $username, $password) 
		  or die("Unable to connect to MySQL");


		@mysql_select_db("gameadm_usertest") or die( "Unable to select database");
		$result = mysql_query("SELECT * FROM userdata");
		// echo "<b><center>Database Test</center></b><br><br>";
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
					$gamesplayed=$row["GAMES"];
			}
			if($friendId1 == $id)
			{
				$friendgames1=$row["GAMES"];
				
			}
			if($friendId2 == $id)
			{
				$friendgames2=$row["GAMES"];
				
			}
			if($friendId3 == $id)
			{
				$friendgames3=$row["GAMES"];
				
			}
      //echo "<b> $tname </b><br>Score: $thscore <br>";
		}
			if($newuser == 1)
			{ 
				$dbresult = mysql_query("INSERT INTO userdata (ID, NAME, HSCORE) VALUES (" . intval($userId) . ", '" . $userInfo["name"] . "', 0)") or die (mysql_error());
			$name=$userInfo["name"];
      $hscore=0;
			}

		mysql_close($dbhandle);



		?>

		 
     <script>
document.getElementById("welcome").innerHTML = "<br>Welcome, <?php echo $userInfo['name']; ?><br>";
document.getElementById("rightBox").innerHTML += "<button class='fbbutton confirm' id='fbLogout' onclick='fbLogout()'>Logout</button>";function fbLogout() {
        FB.logout(function (response) {
            //Do what ever you want here when logged out like reloading the page
            window.location.reload();
        });
    }
</script>


 </div></div>
    <?php } else { ?>
      <!-- <p>Not Logged into Facebook</p> -->
			<script>
			document.getElementById("rightBox").innerHTML += "<br><fb:login-button scope ='publish_stream, friends_games_activity, user_games_activity'></fb:login-button>";
			</script>
	  <?php } ?>

					<div id="colorTitle"></div>
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
						if(!loggedIn)
						{
							window.location.reload();
						}
						FB.api("/" + appID +"/scores", "get", function(response){updateLeaderBoard(response.data);});
					} else if (response.status === 'not_authorized') {
						// not_authorized;
					}else{
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
                
           	link: 'https://www.facebook.com/appcenter/asu_cpi_game?preview=1&locale=en_US',
           	picture: 'http://game.courses.asu.edu/art/GUI/highscoretext.png',
           	caption: 'You helped save a pie!',
           	description: 'Your Avatar helped someone save their pie in Cabin Crashers! Try and beat their score!'
           	
           };
           
           function callback(response) {
           	document.getElementById('msg').innerHTML = "Post ID: " + response['post_id'];
           	
           }
           FB.ui(obj, callback);
           }
					 
					 var score = 0;
					var hscore =  <?php echo $hscore ?>;
					var gamesplayed = <?php echo $gamesplayed; ?>;
					var newgame = true;
					var leadernames = new Array();
					var leaderscores = new Array();
        </script>
				

		<br/>
		
		<audio id="MyAudio" autoplay loop="true">
			<source src="menu.mp3" type="audio/mpeg"/> //Rest of the browsers
			<!--<source src="testHouseholds.ogg" type="audio/ogg" /> //Firefox, since MP3 is not supported -->
		</audio>
		
		<audio id="PlayAudio" loop="true">
			<source src="InGameC.mp3" type="audio/mpeg"/> //Rest of the browsers
			<!--<source src="testHouseholds.ogg" type="audio/ogg" /> //Firefox, since MP3 is not supported -->
		</audio>
		<!--<button type="button" onclick="updateHighScore(score)">Update Score</button>
		<button type="button" onclick="postToFeed()">Post to Feed</button>-->
		<br>
		<script>
		
		
			function getUserId()
			{
				return <?php echo $userId; ?>;
			}
			function resize() {
				var width = 1400/2 -500;
				document.getElementById("centerCanvas").style.paddingLeft = width.toString() + "px";
				//document.getElementById("tables").style.paddingLeft = width.toString() - 12 + "px";
			}
			function refresh(){
				drawFloor();
			}
			window.onload = refresh;
			window.onresize = resize;
			
			var friendPics = new Array();
			var friendNames = new Array();
                        var friendGenders = new Array();
                        var friendGamesPlayed = new Array();
			var connectedFacebook = false;
                        var UserName;
                        var UserGender;
                        var UserImage;
                        var numfriends;
			var friendID;
			if("<?php echo $connected ?>"){
			   friendPics.push("<?php echo $userImage ?>");
                           friendPics.push("<?php echo $randomfriendimage ?>");
			   friendPics.push("<?php echo $randomfriendimage2 ?>");

			   friendPics.push("<?php echo $randomfriendimage3 ?>");
			   //friendPics.push("<?php echo $randomfriendimage4 ?>");
			   //friendPics.push("<?php echo $randomfriendimage5 ?>");
                           //UserImage = "<?php echo $userImage ?>";
                           friendGamesPlayed.push("<?php echo $gamesplayed ?>");
                           friendGamesPlayed.push("<?php echo $friendgames1 ?>");
                           friendGamesPlayed.push("<?php echo $friendgames2 ?>");
                           friendGamesPlayed.push("<?php echo $friendgames3 ?>");
                           
                           numfriends = "<?php echo $friendcount ?>";
                           //UserName = "<?php echo $userName ?>";
                           friendID = "<?php echo $friendId2 ?>";
                           friendNames.push("<?php echo $userName ?>");
                           friendNames.push("<?php echo $randomfriendName ?>");
                           friendNames.push("<?php echo $randomfriendName2 ?>");
                           friendNames.push("<?php echo $randomfriendName3 ?>");
                           //friendNames.push("<?php echo $randomfriendName4 ?>");
                           //friendNames.push("<?php echo $randomfriendName5 ?>");
                           
                           friendGenders.push("<?php echo $userGender ?>");
                           friendGenders.push("<?php echo $randomfriendGender ?>");
                           friendGenders.push("<?php echo $randomfriendGender2 ?>");
                           friendGenders.push("<?php echo $randomfriendGender3 ?>");
                           //UserGender -"<?php echo $userGender ?>";
                           
			   connectedFacebook = true;
			}			
		</script>
		
		<div  id="centerCanvas" style="height: 630px; ">
		<div  style="position:relative;">

			<div style="z-index: 0; position:absolute; left: -30px; top: -30px;"><img src="art\GUI\canvas_bckrnd.png" width = "1060", height = "660" ></div>
		</div>	
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
			<canvas id = "canvasGUI" width = "1000" height = "600" style = "z-index: 4; position: absolute;">
				Your browser does not support the HTML5 canvas tag
			</canvas>
			<canvas id = "canvasEnd" width = "1000" height = "600" style = "z-index: 6; position: absolute;">
				Your browser does not support the HTML5 canvas tag
			</canvas>
			
		<!--</span>-->
		</div>
		
		<!--<div  style="height: 630px;">
				<h2 style="color: #ffff00;"><?php echo $name ?>'s stats: </h2>
				<table><tr><th>High Score</th></tr><tr><td id="score_cell"><?php echo $hscore ?></td></tr></table>
				<h2 style="color: #ffff00;">Friends Leaderboard</h2>
				<table id="leaderboard"></table>
		</div>-->
		<!--</span>-->

		<script src="game.php"></script>
		
		<div id="tables">
			<?php if($userId){ ?>
				
				
				<h2 class = "mainfont">Friends Leaderboard</h2>
				<table id="leaderboard"></table>
				<?php } ?>
				<br>
					<h1 class="mainfont"> Cabin Crashers: The Facebook Game </h1>
					<h2 class="mainfont"> Instructions: </h2>
					<p class="mainfont">You and your friends were just about to sit down to a delicious meal
					when some uninvited guests showed up for dinner! Defend your food from the relentless
					woodland creatures by repairing cabin walls before the animals break through!</p>
					<p class="mainfont">Click on a person, then click a spot on the interior of the
					cabin to direct them there. You can repair cabin walls adjacent to you in any direction, and
					you will repair walls faster if working with another person. </p>
					<p class="mainfont">Friends in the cabin who have played Cabin Crashers before get a boost to
					repair ability, so the more people you get to try the game, the higher chance of getting a "starred" player in your crew!
					</p>
					<br>
						<h2 class="mainfont"> <i>Brought to you by <b>Banjo Bear Studios</b></i>: </h2>
						<h3 class="mainfont">Programming: </h3>
						<p class="mainfont"><i>Branden Booth<br>Tyler Fleck<br>Austin Krause<br>Austin Stapley </i></p>
						<h3 class="mainfont">Art: </h3>
						<p class="mainfont"><i>Aldo Cervantes<br>Evan Lake<br>Ian Smith</i></p>
				<div><iframe src = "https://www.facebook.com/plugins/like.php?href=http://game.courses.asu.edu/"
					scrolling = "no" frameborder = "0">
					Sorry your browser doesn't support inline frames
					</iframe>
				</div>
		</div>
			<script>
				resize();
			</script>
			<!--
		<a href="example.htm" id="button3" class="buttonText">Tic Tac Toe</a>
		<a href="http://austin.thautech.com" id="button3" class="buttonText">Austin</a>
		<a href="collision.htm" id="button3" class="buttonText">collisions</a>
			-->
	</body>
</html>
