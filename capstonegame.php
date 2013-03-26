<!DOCTYPE HTML>
<html>
	<head>
		<script>
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
				alert("request complete " + xmlhttp.responseText);
			//document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
			}
		}
	xmlhttp.open("GET","updateHighScore.php?scr="+score+"&usr="+window.parent.getUserId(),true);
	xmlhttp.send();
	}
	var score = 0;
</script>
	</head>
	<body>
		<audio id="MyAudio" autoplay loop="true">
			<source src="testHouseholds.mp3" type="audio/mpeg"/> //Rest of the browsers
			<source src="testHouseholds.ogg" type="audio/ogg" /> //Firefox, since MP3 is not supported
		</audio>
		<button type="button" onclick="updateHighScore(score)">Update Score</button>
		<script>
			function refresh(){
				drawFloor();
			}
			window.onload = refresh;
		</script>
		
		<div id="centerCanvas" style="height: 630px; padding-left: inherit;">
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
		</div>

		<script src="game.php"></script>
	</body>
</html>