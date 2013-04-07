  var uiCanvas = document.getElementById("UICanvas");
  var uictx = uiCanvas.getContext("2d");
  
function drawUI(){
  uictx.clearRect(0,0,uiCanvas.width, uiCanvas.height);
 uictx.fillStyle="#ffffff";
 uictx.fillRect(0,0,uiCanvas.width,uiCanvas.height);
 uictx.fillStyle="#0000ff";
  uictx.font="20px Georgia";
  uictx.fillText("Score: " + Math.floor(score),20,50);
  uictx.fillText("High Score: " + hscore,20,80);
  uictx.fillText("Games Played: " + gamesplayed,20,110);
  uictx.fillText("Leaderboard",20,140);
  for(var i = 0; i < leadernames.length; i++)
  {
    uictx.fillText(i + ".\t" + leadernames[i] + "\t:   " + leaderscores[i],20,170 + i * 30);
  }
}

function resetScore()
{
  score = 0;
}