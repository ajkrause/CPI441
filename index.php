<?php require 'php-sdk/facebook.php';
$facebook = new Facebook(array(
  'appId'  => '312229638880822',
  'secret' => '20b2eba7de6a54af3c2137d169c7a5f6',
));

$userId = $facebook->getUser();

?>
<?php
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
    <?php if ($userId) { 
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
		 

		$dbhandle = mysql_connect($hostname, $username, $password) 
		  or die("Unable to connect to MySQL");
		echo "Connected to MySQL<br>";

		@mysql_select_db("gameadm_usertest") or die( "Unable to select database");
		$result = mysql_query("SELECT * FROM test1");
		mysql_close($dbhandle);
		 echo "<b><center>Database Test</center></b><br><br>";
		//fetch tha data from the database
		while ($row = mysql_fetch_array($result)) {
			$name=$row["Name"];
      $score=$row["Score"];
      echo "<b>$name </b><br>Score: $score <br>";
		  
		}


	
		?>
     <h2 id='colorTitle'> Welcome <?= $userInfo['name'] ?> </h2>

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
		
		<div id="centerCanvas">
			<script>
				var width = window.innerWidth/2 - 400;
				document.getElementById("centerCanvas").style.paddingLeft = width.toString() + "px";
			</script>
			<canvas id = "canvas" width = "800" height = "580" style = "border:10px solid #FFFFFF; background: gray;">
				Your browser does not support the HTML5 canvas tag
			</canvas>
		</div>
		
		<div><iframe src = "https://www.facebook.com/plugins/like.php?href=http://www.kkpsi.org/"
		scrolling = "no" frameborder = "0"
		style = "border:none; width:450px; height:80px;
		margin-top: 0; margin-left: 0; background-color: white;">
		Sorry your browser doesn't support inline frames
		</iframe></div>

		<script>
			var left;
			var right;
			var down;
			var up; 
			var buttonDown = false;
			
			var yPos1 = canvas.height/2 - 50; //paddle1 starting position
			var yPos2 = canvas.height/2 - 50; //paddle2 starting position
			
			var pongPosX = (canvas.width/2); //pong starting xvalue
			var pongPosY = (canvas.height/2); //pong starting yvalue
			
			var c; //canvas
			var ctx; //canvas context
			
			var pongImage;
			var wall;
			var offset = 0;

			//how many characters to draw
			var numCharacters = 5;
			
			var activePlayer = -1;
			var boardWidth = 30;
			var boardHeight = 30;
			var squareWidth = canvas.width/boardWidth;
			//var squareWidth = canvas.height/boardWidth;
			var squareHeight = canvas.height/boardHeight;
			var board = new Array(boardWidth);

			var Characters = []; //set of pongs
			var neighbors = []; //neighbors
			var startNode;
			var endNode;
			var openList = [];

			var topMax = -1;
			var bottomMax = -1;
			var leftMax = -1;
			var rightMax = -1;

			//animation frame
			window.requestAnimFrame = (function(){
				return  window.requestAnimationFrame       || 
					window.webkitRequestAnimationFrame || 
					window.mozRequestAnimationFrame    || 
					window.oRequestAnimationFrame      || 
					window.msRequestAnimationFrame     || 
					function(/* function */ callback, /* DOMElement */ element){
					  window.setTimeout(callback, 1000 / 60);
					};
			})();

			function init() {
				document.onkeydown = keyDown;
				document.onkeyup = keyUp;
				document.onmousedown = mouseDown;
				
				c = document.getElementById("canvas");
				ctx = c.getContext("2d");
				
				pongImage = new Image();
				wall = new Image();
				//pongImage.src = "pacman.png";
				//pongImage.src = "walkMan1.png";
				pongImage.src = "walkMan2.png";
				wall.src = "tiles/log1.png";

				//create board
				//(1=outerfloor, 3=innerfloor, 2=character, 0=wall, 4=enemy)
				for(var i = 0; i < boardWidth; i++){
					board[i] = new Array(boardHeight);
				}

				//set the board
				for(var x = 0; x < boardWidth; x++){
				for(var y = 0; y < boardHeight; y++){
					board[x][y] = ({index: 1, health: -1, opened: false, closed: false, g: 0, f: 0, h: 0, parent: []});
				}
				}

				//place begining inner floor
				for(var x = 0; x < boardWidth; x++){
				for(var y = 0; y < boardHeight; y++){
					if(x > (Math.floor((boardWidth/2)-(boardWidth/8))) && y > (Math.floor((boardHeight/2)-(boardWidth/8))) && 
					x < (Math.floor((boardWidth/2)+(boardWidth/8))) && y < (Math.floor(boardHeight/2)+(boardWidth/8)-1)){
						board[x][y].index = 3;
					}
				}
				}
				var Position = [];

				for(var i = 0; i < 4; i++){
				var Wmax = Math.floor(boardWidth/2) + 2;
				var Wmin = Math.floor(boardWidth/2) - 2;
				var Hmax = Math.floor(boardHeight/2) + 2;
				var Hmin = Math.floor(boardHeight/2) - 2;
	
				Position.push({W: Math.floor((Math.random()*(Wmax-Wmin+1)))+Wmin, H: Math.floor((Math.random()*(Hmax-Hmin+1)))+Hmin});
				}

				for(var k=0; k<Position.length; k++){
					if(Position[k].W < Math.floor(boardWidth/2) && Position[k].H < Math.floor(boardHeight/2)){
						for(var j=0; j<4; j++){
						for(var h=0; h<4; h++){
							//lower left corner
							board[Position[k].W-(j)][Position[k].H-(h-1)].index = 3;
						}
						}
					}
					if(Position[k].W < Math.floor(boardWidth/2) && Position[k].H > Math.floor(boardHeight/2)){
						for(var j=0; j<4; j++){
						for(var h=0; h<4; h++){
							//upper left corner
							board[Position[k].W-(j)][Position[k].H+(h)].index = 3;
						}
						}
					}
					if(Position[k].W > Math.floor(boardWidth/2) && Position[k].H < Math.floor(boardHeight/2)){
						for(var j=0; j<4; j++){
						for(var h=0; h<4; h++){
							//lower right corner
							board[Position[k].W+(j-1)][Position[k].H-(h-1)].index = 3;
						}
						}
					}
					if(Position[k].W > Math.floor(boardWidth/2) && Position[k].H > Math.floor(boardHeight/2)){
						for(var j=0; j<4; j++){
						for(var h=0; h<4; h++){
							//upper right corner
							board[Position[k].W+(j-1)][Position[k].H+(h)].index = 3;
						}
						}
					}
				}
				
				//place walls
				for(var y = 2; y < (boardHeight-2); y++){
				for(var x = 2; x < (boardWidth-2); x++){
					if(board[x+1][y].index == 3 && (board[x-1][y].index == 1 || board[x-1][y].index == 0) && board[x][y].index == 1){
						board[x][y].index = 0; //left wall
						board[x][y].health = 0;
						
					}
					if(board[x-1][y].index == 3 && (board[x+1][y].index == 1 || board[x+1][y].index == 0) && board[x][y].index == 1){
						board[x][y].index = 0; //right wall
						board[x][y].health = 0;
					}
					if(board[x][y+1].index == 3 && (board[x][y-1].index == 1 || board[x][y-1].index == 0) && board[x][y].index == 1){
						board[x][y].index = 0; //top wall
						board[x][y].health = 0;
					}
					if(board[x][y-1].index == 3 && (board[x][y+1].index == 1 || board[x][y+1].index == 0) && board[x][y].index == 1){
						board[x][y].index = 0; //bottom wall
						board[x][y].health = 0;
					}
					//check
					if(board[x-1][y-1].index == 3 && (board[x+1][y+1].index == 1 || board[x+1][y+1].index == 0) && board[x][y].index == 1){
						board[x][y].index = 0; //bottom right corner
						board[x][y].health = 0;
						//board[x-1][y-1].index = 2;
						//Characters.push({boardX: x-1, boardY: y-1, PosX: (squareWidth*(x-1)) + (squareWidth/2), PosY: (squareHeight*(y-1)) + (squareHeight/2), Rotate: 0, power: 1});
					}
					//check
					if(board[x+1][y-1].index == 3 && (board[x-1][y+1].index == 1 || board[x-1][y+1].index == 0) && board[x][y].index == 1){
						board[x][y].index = 0; //bottom left corner
						board[x][y].health = 0;
						//board[x+1][y-1].index = 2;
						//Characters.push({boardX: x+1, boardY: y-1, PosX: (squareWidth*(x+1)) + (squareWidth/2), PosY: (squareHeight*(y-1)) + (squareHeight/2), Rotate: 0, power: 1});
					}
					//check
					if(board[x-1][y+1].index == 3 && (board[x+1][y-1].index == 1 || board[x+1][y-1].index == 0) && board[x][y].index == 1){
						board[x][y].index = 0; //top right corner
						board[x][y].health = 0;
						//board[x-1][y+1].index = 2;
						//Characters.push({boardX: x-1, boardY: y+1, PosX: (squareWidth*(x-1)) + (squareWidth/2), PosY: (squareHeight*(y+1)) + (squareHeight/2), Rotate: 0, power: 1});
					}
					//check		
					if(board[x+1][y+1].index == 3 && (board[x-1][y-1].index == 1 || board[x-1][y-1].index == 0) && board[x][y].index == 1){
						board[x][y].index = 0; //top left corner
						board[x][y].health = 0;
						//board[x+1][y+1].index = 2;
						//Characters.push({boardX: x+1, boardY: y+1, PosX: (squareWidth*(x+1)) + (squareWidth/2), PosY: (squareHeight*(y+1)) + (squareHeight/2), Rotate: 0, power: 1});
					}
					if((board[x][y].index == 0 || board[x][y].index == 1) && 
					(((board[x+1][y].index == 3 || board[x+2][y].index == 3) && board[x-1][y].index == 3) || 
					((board[x][y+1].index == 3 || board[x][y+2].index == 3) && board[x][y-1].index == 3))){
						board[x][y].index = 3;
					}
				}
				}

				for(var y = 2; y < (boardHeight-2); y++){
				for(var x = 2; x < (boardWidth-2); x++){
					//bottom right
					if(board[x][y].index == 0 && board[x][y-1].index == 0 && board[x-1][y].index == 0 && board[x-1][y-1].index == 3){
						if(numCharacters != 0){
							board[x-1][y-1].index = 2;
							//board[x-1][y-1].parent = [x,y];
							Characters.push({boardX: x-1, boardY: y-1, PosX: (squareWidth*(x-1)) + (squareWidth/2), PosY: (squareHeight*(y-1)) + (squareHeight/2), Rotate: 0, power: 1});
							numCharacters = numCharacters - 1;
						}
					}
					//bottom left
					if(board[x][y].index == 0 && board[x][y-1].index == 0 && board[x+1][y].index == 0 && board[x+1][y-1].index == 3){
						if(numCharacters != 0){
							board[x+1][y-1].index = 2;
							//board[x+1][y-1].parent = [x,y];
							Characters.push({boardX: x+1, boardY: y-1, PosX: (squareWidth*(x+1)) + (squareWidth/2), PosY: (squareHeight*(y-1)) + (squareHeight/2), Rotate: 0, power: 1});
							numCharacters = numCharacters - 1;
						}
					}
					//top right
					if(board[x][y].index == 0 && board[x-1][y].index == 0 && board[x][y+1].index == 0 && board[x-1][y+1].index == 3){
						if(numCharacters != 0){
							board[x-1][y+1].index = 2;
							//board[x-1][y+1].parent = [x,y];
							Characters.push({boardX: x-1, boardY: y+1, PosX: (squareWidth*(x-1)) + (squareWidth/2), PosY: (squareHeight*(y+1)) + (squareHeight/2), Rotate: 0, power: 1});
							numCharacters = numCharacters - 1;
						}
					}
					//top left	
					if(board[x][y].index == 0 && board[x+1][y].index == 0 && board[x][y+1].index == 0 && board[x+1][y+1].index == 3){
						if(numCharacters != 0){
							board[x+1][y+1].index = 2;
							//board[x+1][y+1].parent = [x,y];
							Characters.push({boardX: x+1, boardY: y+1, PosX: (squareWidth*(x+1)) + (squareWidth/2), PosY: (squareHeight*(y+1)) + (squareHeight/2), Rotate: 0, power: 1});
							numCharacters = numCharacters - 1;
						}
					}
				}
				}
				
				//test bounds
				for(var t=0; t<boardHeight; t++){
				for(var p=0; p<boardWidth; p++){
					if(board[p][t].index == 0 && topMax == -1){
						topMax = t;
					}
					if(board[p][boardHeight-(t+1)].index == 0 && bottomMax == -1){
						bottomMax = boardHeight-(t+1);
					}
				}
				}

				for(var p=0; p<boardWidth; p++){
				for(var t=0; t<boardHeight; t++){
					if(board[p][t].index == 0 && leftMax == -1){
						leftMax = p;
					}
					if(board[boardWidth-(p+1)][t].index == 0 && rightMax == -1){
						rightMax = boardWidth-(p+1);
					}
				}
				}
				
				//board[15][15].index = 2;
				//Characters.push({boardX: 15, boardY: 15, PosX: (squareWidth*15) + (squareWidth/2), PosY: (squareHeight*15) + (squareHeight/2), Rotate: 0, power: 1});
				//image, xposition, yposition, , , xoffset, yoffset,height, width
				//ctx.drawImage(pongImage, 0, 0, 128, 128, 0, 0, squareHeight, squareWidth);
				rotate = 0;
			}

			init();
			gameLoop();
			var myVar=setInterval(function(){MoveBear(0, 0, 0)},1000);

			function keyDown(e) {
				if(!e) {
					e = window.event;
				}
				if(e.keyCode == 65) {
					if(!buttonDown){
						left = true;
						buttonDown = true;
					}
				}
				else if(e.keyCode == 68) {
					if(!buttonDown){
						right = true;
						buttonDown = true;
					}
				}
				else if(e.keyCode == 87) {
					if(!buttonDown){
						up = true;
						buttonDown = true;
					}
				}
				else if(e.keyCode == 83) {
					if(!buttonDown){
						down = true;
						buttonDown = true;
					}
				}
				//h key for test
				else if(e.keyCode == 72){
					var path = findPath(Characters[0].boardX, Characters[0].boardY, 15, 16);
					alert("hi");
				}
				else if(e.keyCode == 107){
					board[13][10].index = 2;
					Characters.push({boardX: 13, boardY: 10, PosX: (squareWidth*13) + (squareWidth/2), PosY: (squareHeight*10) + (squareHeight/2), Rotate: 0, power: 1});
				}
			}

			function keyUp(e) {
				buttonDown = false;
			}
			
			function mouseDown(e){
				var x = e.clientX + document.body.scrollLeft +
                		document.documentElement.scrollLeft - c.offsetLeft;
    				var y = e.clientY + document.body.scrollTop +
                		document.documentElement.scrollTop - c.offsetTop;

				if(x > 0 && x < c.width && y > 0 && y < c.height){
					//if clicked on player
					for(var i = 0; i < Characters.length; i++){
						if(x > (Characters[i].PosX - (squareWidth/2)) && x < (Characters[i].PosX + (squareWidth/2)) &&
						y > (Characters[i].PosY - (squareWidth/2)) && y < (Characters[i].PosY + (squareHeight/2))){
							activePlayer = i;
						}
					}
					
					//look at, getting decimals 
					var x2 = (((squareWidth-(x%squareWidth))+x)/squareWidth)-1;
					var y2 = (((squareHeight-(y%squareHeight))+y)/squareHeight)-1;
					var x1 = Math.round(x2);
					var y1 = Math.round(y2);
					//if clicked on wall
					if(board[x1][y1].index == 0){
						alert(board[x1][y1].health);
					}
					//move active player
					if(board[x1][y1].index == 3 && activePlayer != -1){
						board[Characters[activePlayer].boardX][Characters[activePlayer].boardY].index = 3;
						Characters[activePlayer].boardX = x1;
						Characters[activePlayer].boardY = y1;
						Characters[activePlayer].PosX = ((squareWidth*x1) + (squareWidth/2));
						Characters[activePlayer].PosY = ((squareHeight*y1) + (squareHeight/2));
						board[Characters[activePlayer].boardX][Characters[activePlayer].boardY].index = 2;
						
						ctx.save();
                                        	ctx.translate(Characters[activePlayer].PosX, Characters[activePlayer].PosY);
						ctx.drawImage(pongImage, 0, 0, 128, 128, -(squareHeight/2), -(squareWidth/2), squareHeight, squareWidth);
						ctx.translate(Characters[activePlayer].PosX, Characters[activePlayer].PosY);
						ctx.restore();

						activePlayer = -1;
					}
				}
			}

			function gameLoop() {
				requestAnimFrame(gameLoop);
				pongCollide();
				draw();
			}
			
			function draw() {
				if(offset == 60){
					offset = 0;
				}
				//CLEAR CANVAS
				ctx.clearRect(0,0,canvas.width, canvas.height);
				
				ctx.beginPath();

				//draw the map
				for(var x = 0; x < boardWidth; x++){
				for(var y = 0; y < boardHeight; y++){
					ctx.lineWidth = 1;
					ctx.strokeStyle = "#000000";
					//floor
					if(board[x][y].index == 1){
						ctx.fillStyle = "#FF00FF";
					}
					else if(board[x][y].index == 3){
						ctx.fillStyle = "#FFFF00";
					}
					//character
					else if(board[x][y].index == 2){
						ctx.fillStyle = "#FFFFFF";
					}
					//walls
					else if(board[x][y].index == 0){
						switch(true){
							case ((board[x][y].health>=0) && (board[x][y].health<119)):
								//ctx.drawImage(wall, 0, 0);
								ctx.fillStyle = "#000000";
								break;
							case ((board[x][y].health>=120) && (board[x][y].health<180)):
								ctx.fillStyle = "#FFFFFF";
								break;
							default:
								ctx.fillStyle = "#00FF00";
								break;
						}	
					}
					ctx.fillRect(squareWidth*x, squareHeight*y, squareWidth, squareHeight);
					ctx.strokeRect(squareWidth*x, squareHeight*y, squareWidth, squareHeight);
				}
				}
				
				//move the characters
				for(i = 0; i < Characters.length; i++){
					var Px = Characters[i].boardX;
					var Py = Characters[i].boardY;

					//if next to a wall
					//right
					if(board[Characters[i].boardX+1][Characters[i].boardY].index == 0 && board[Characters[i].boardX+1][Characters[i].boardY].health < 180){
						board[Characters[i].boardX+1][Characters[i].boardY].health = board[Characters[i].boardX+1][Characters[i].boardY].health + 1;
					}
					if(board[Characters[i].boardX+1][Characters[i].boardY+1].index == 0 && board[Characters[i].boardX+1][Characters[i].boardY+1].health < 180){
						board[Characters[i].boardX+1][Characters[i].boardY+1].health = board[Characters[i].boardX+1][Characters[i].boardY+1].health + 1;
					}
					if(board[Characters[i].boardX+1][Characters[i].boardY-1].index == 0 && board[Characters[i].boardX+1][Characters[i].boardY-1].health < 180){
						board[Characters[i].boardX+1][Characters[i].boardY-1].health = board[Characters[i].boardX+1][Characters[i].boardY-1].health + 1;
					}
					//left
					if(board[Characters[i].boardX-1][Characters[i].boardY].index == 0 && board[Characters[i].boardX-1][Characters[i].boardY].health < 180){
						board[Characters[i].boardX-1][Characters[i].boardY].health = board[Characters[i].boardX-1][Characters[i].boardY].health + 1;
					}
					if(board[Characters[i].boardX-1][Characters[i].boardY+1].index == 0 && board[Characters[i].boardX-1][Characters[i].boardY+1].health < 180){
						board[Characters[i].boardX-1][Characters[i].boardY+1].health = board[Characters[i].boardX-1][Characters[i].boardY+1].health + 1;
					}
					if(board[Characters[i].boardX-1][Characters[i].boardY-1].index == 0 && board[Characters[i].boardX-1][Characters[i].boardY-1].health < 180){
						board[Characters[i].boardX-1][Characters[i].boardY-1].health = board[Characters[i].boardX-1][Characters[i].boardY-1].health + 1;
					}
					//bottom
					if(board[Characters[i].boardX][Characters[i].boardY+1].index == 0 && board[Characters[i].boardX][Characters[i].boardY+1].health < 180){
						board[Characters[i].boardX][Characters[i].boardY+1].health = board[Characters[i].boardX][Characters[i].boardY+1].health + 1;
					}
					//top
					if(board[Characters[i].boardX][Characters[i].boardY-1].index == 0 && board[Characters[i].boardX][Characters[i].boardY-1].health < 180){
						board[Characters[i].boardX][Characters[i].boardY-1].health = board[Characters[i].boardX][Characters[i].boardY-1].health + 1;
					}
					
					Characters[i].PosX = ((squareWidth*Characters[i].boardX) + (squareWidth/2));
					Characters[i].PosY = ((squareHeight*Characters[i].boardY) + (squareHeight/2));
					ctx.save();
                                        ctx.translate(Characters[i].PosX, Characters[i].PosY);
					ctx.drawImage(pongImage, 0, 0, 128, 128, -(squareHeight/2), -(squareWidth/2), squareHeight, squareWidth);
					ctx.translate(Characters[i].PosX, Characters[i].PosY);
					ctx.restore();
				}
				offset += 1;
				
				rotate = rotate + 3;
				left = false;
				right = false;
				up = false;
				down = false;
			}

			function MoveBear(x, y, direction){
				
			}

			//find the path from(startX, startY) to (endX, endY)
			function findPath(startX, startY, endX, endY){
				//var openList = [];
				startNode = [startX, startY];
				endNode = [endX, endY];

				board[startX][startY].g = 0;
				board[startX][startY].f = 0;

				//push the start node onto the open list
				openList.push([startX, startY]);
				board[startX][startY].opened = true;

				while(openList.cout != 0){
					//pop the position of the node which has the minimum 'f' value
					var node = openList.pop();
					board[node[0]][node[1]].closed = true;

					if(node[0] == endX && node[1] == endY){
						var path = [[node[0], node[1]]];
						var par = board[node[0]][node[1]].parent;
			    			while (par.length != 0) {
			    		    		node = board[node[0]][node[1]].parent;
					        	path.push([node[0], node[1]]);
							par = board[node[0]][node[1]].parent;
					    	}
					    	return path.reverse();
					}

					identifySuccessors(node[0], node[1]);
				}
				return [];
			}

			//find successors
			function identifySuccessors(x, y){
				var px = board[x][y].parent[0];
				var py = board[x][y].parent[1];
				var jx;
				var jy; 
				var jumpNode = new Object();

				//find all neighbors of point[x,y] from direction[px,py]
				findNeighbors(x, y);
				for(i = 0; i<neighbors.length; i++){
					var neighbor = neighbors[i];
					//find a jumpPoint from each neighbor
					var jumpPoint = jump(neighbor.xpos, neighbor.ypos, x, y);
		
					if(jumpPoint){
						jx = jumpPoint[0];
						jy = jumpPoint[1];
						jumpNode.xpos = jx;
						jumpNode.ypos = jy; 	
						var index = openList.indexOf([jx, jy]);

						if(jumpNode.closed){
							return;
						}
			
						//include distance, as parent may not be immediately adjacent
						//var d = Heuristic.euclidean(Math.abs(jx-x), Math.abs(jy-y));
						//distance between the two points 
						var d = Math.sqrt(((jx-x)*(jx-x))+((jy-y)*(jy-y)));
						var ng = board[x][y].g + d; //next g value
					
						if(!board[jx][jy].opened || ng < board[jx][jy].g){
							board[jx][jy].g = ng;
							board[jx][jy].h = board[jx][jy].h || Math.sqrt(((jx-endNode[0])*(jx-endNode[0]))+((jy-endNode[1])*(jy-endNode[1])));
							//cost of moving from[x,y] to the jump point
							board[jx][jy].f = board[jx][jy].g + board[jx][jy].h;
							board[jx][jy].parent = [x, y];
						
							if(!board[jx][jy].opened){
								openList.push([jx, jy]);
								//sort openList in reverse order on f value
								openList.sort(function(a,b) {return board[b[0]][b[1]].f-board[a[0]][b[1]].f});
								board[jx][jy].opened = true;
							}
							else{
								//update openList
								if(index != -1){
									openList[index] = [jx, jy];
									openList.sort(function(a,b) {return board[b[0]][b[1]].f-board[a[0]][b[1]].f});
								}
							}
						}		
					}
				}
			}

			//find jump points
			function jump(x, y, px, py){
				var dx = x - px;
				var dy = y - py;
				var jx;
				var jy;
			
				//if your in a wall
				if(board[x][y].index == 0){
					return null;
				}
				//if your at the end
				else if(x == endNode[0] && y == endNode[1]){
					return[x, y];
				}

				//check for forced neighbors
				//along the diagonal
				if(dx != 0 && dy != 0){
					if((board[x-dx][y+dy].index != 0 && board[x-dx][y].index == 0) ||
					(board[x+dx][y-dy].index != 0 && board[x][y-dy].index == 0)){
						return[x, y];
					}
				}
				//horizonally/vertically
				else{
					//vertical
					if(dx != 0){
						if((board[x+dx][y+1].index != 0 && board[x][y+1].index == 0) ||
						(board[x+dx][y-1].index != 0 && board[x][y-1].index == 0)){
							return[x, y];
						}
					}
					else{
						if((board[x+1][y+dy].index != 0 && board[x+1][y].index == 0) ||
						(board[x-1][y+dy].index != 0 && board[x-1][y].index == 0)){
							return[x, y];
						}
					}
				}

				//when moving diagonally, must check for vertical/horizontal jump points
				if(dx != 0 && dy != 0){
					jx = jump(x+dx, y, x, y);
					jy = jump(x, y+dy, x, y);
					if(jx || jy){
						return[x, y]; 
					}
				}
			
				//moving diagonally, must make sure one of the vertical/horivontal
				//neighbors is open to allow the path
				if(board[x+dx][y].index != 0 || board[x][y+dy].index != 0){
					return jump(x+dx, y+dy, x, y);
				}
				else{
					return null;
				}
			}

			//find the neighbors
			function findNeighbors(x, y){
				neighbors = [];
				var parent = board[x][y].parent;
				if(parent.count == 0){
					var px = parent[0];
					var py = parent[1];
					var dx = (x-px)/Math.max(Math.abs(x-px),1);
					var dy = (y-py)/Math.max(Math.abs(y-py),1);

					//search diagonally 
					if(dx != 0 && dy != 0){
						//vertical
						if(board[x][y+dy].index != 0){
							neighbors.push({xpos: x, ypos: y+dy});
						}	
						//horizontal
						if(board[x+dx][y].index != 0){
							neighbors.push({xpos:x+dx, ypos: y});
						}
						//diagonal
						if(board[x+dx][y+dy].index != 0){
							neighbors.push({xpos:x+dx, ypos: y+dy});
						}
						//forced neightbor
						if(board[x-dx][y].index == 0 && board[x][y+dy].index != 0){
							neighbors.push({xpos:x-dx, ypos: y+dy});
						}
						//forced neightbor
						if(board[x][y-dy].index == 0 && board[x+dx][y].index != 0){
							neighbors.push({xpos: x+dx, ypos: y-dy});
						}
					}
					//search horizontally/ vertically
					else{
						//vertical
						if(dx == 0){
							if(board[x][y+dy].index != 0){
								if(board[x][y+dy].index != 0){
									neighbors.push({xpos: x, ypos: y+dy});
								}
								if(board[x+1][y].index == 0){
									neighbors.push({xpos: x+1, ypos: y+dy});
								}
								if(board[x-1][y].index == 0){
									neighbors.push({xpos: x-1, ypos: y+dy});
								}
							}
						}
						else{
							if(board[x+dx][y].index != 0){
								if(board[x+dx][y].index != 0){
									neighbors.push({xpos: x+dx, ypos: y});
								}
								if(board[x][y+1].index == 0){
									neighbors.push({xpos: x+dx, ypos: y+1});
								}
								if(board[x][y-1].index == 0){
									neighbors.push({xpos: x+dx, ypos: y-1});
								}
							}
						}
					}
				}
				else{
					if(board[x][y-1].index != 0){
						neighbors.push({xpos: x, ypos: y-1});
					}	
					if(board[x+1][y].index != 0){
						neighbors.push({xpos: x+1, ypos: y});
					}
					if(board[x][y+1].index != 0){
						neighbors.push({xpos: x, ypos: y+1});
					}
					if(board[x-1][y].index != 0){
						neighbors.push({xpos: x-1, ypos: y});
					}
					if(board[x-1][y-1].index != 0){
						neighbors.push({xpos: x-1, ypos: y-1});
					}
					if(board[x+1][y-1].index != 0){
						neighbors.push({xpos: x+1, ypos: y-1});
					}
					if(board[x+1][y+1].index != 0){
						neighbors.push({xpos: x+1, ypos: y+1});
					}
					if(board[x-1][y+1].index != 0){
						neighbors.push({xpos: x-1, ypos: y+1});
					}	
				}
			}

			function pongCollide() {
				for(i = 0; i < Characters.length; i++) {
					for(j = i+1; j < Characters.length; j++) {
						
						var distance = Math.sqrt((Characters[j].PosX - Characters[i].PosX)*(Characters[j].PosX - Characters[i].PosX)
							     + (Characters[j].PosY - Characters[i].PosY)*(Characters[j].PosY - Characters[i].PosY))
						if(distance < 80) {
							//Characters[i].Rotate = Characters[i].Rotate/2;
							//Characters[j].Rotate = Characters[j].Rotate/2;
						}
					}
				}
			}
		</script>
			<a href="example.htm" id="button3" class="buttonText">Tic Tac Toe</a>
			<a href="http://austin.thautech.com" id="button3" class="buttonText">Austin</a>
			<a href="collision.htm" id="button3" class="buttonText">collisions</a>
	</body>
</html>
