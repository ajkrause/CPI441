  var uiCanvas = document.getElementById("UICanvas");
  var uictx = uiCanvas.getContext("2d");
  var scoreim = new Image();
  scoreim.src = "art/ui/Numbers.png";
  
function drawUI(){
  uictx.clearRect(0,0,uiCanvas.width, uiCanvas.height);
 uictx.fillStyle="#11ff00";
 uictx.fillRect(0,0,uiCanvas.width,uiCanvas.height);
 uictx.fillStyle="#0000ff";
  uictx.font="20px Georgia";
  
  var workingscore = Math.floor(score/6);
  var digits = new Array();
  for (var i = 0; workingscore > 0; i++) {
    digits[i] = workingscore % 10;
    workingscore = Math.floor(workingscore / 10);
  }
  var j = 0;
  for (var i = digits.length; i > 0; i--) {
      uictx.drawImage(scoreim, 200 * digits[i-1], 0, 200, 200, 20 + 40 * j , 0 , 50, 50);
      j++;
  }
  //uictx.fillText("Score: " + Math.floor(score),20,50);
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