  var uiCanvas = document.getElementById("UICanvas");
  var uictx = uiCanvas.getContext("2d");
  var scoreim = new Image();
  scoreim.src = "art/ui/Numbers.png";
  var scoretext = new Image();
  scoretext.src = "art/ui/score.png";
  var hscoretext = new Image();
  hscoretext.src = "art/ui/HighScore.png";
  var pauseim = new Image();
  pauseim.src = "art/ui/UI_pause.png";
  var uibackground = new Image();
   uibackground.src = "art/ui/UI_logs_bckrnd_woodgrain.png";
  var divider = new Image();
  divider.src = "art/ui/UI_div.png";
  var frameIm = new Image();
  frameIm.src = "art/ui/fb_profile_frame.png";

  var faces = new Array()
  for(var i = 0; i < 4; i++)
  {
    faces[i] = new Image();
    faces[i].src = friendPics[i];
  }
  
  
function drawUI(){
  uictx.clearRect(0,0,uiCanvas.width, uiCanvas.height);
 uictx.drawImage(uibackground, 0, 0, uiCanvas.width, uiCanvas.height);
 uictx.drawImage(scoretext, 80, 30, 100, 50);
 uictx.fillStyle="#E19c00";
  uictx.font="30px Calibri";
  
  
  var workingscore = Math.floor(score/6);
  var digits = new Array();
  for (var i = 0; workingscore > 0; i++) {
    digits[i] = workingscore % 10;
    workingscore = Math.floor(workingscore / 10);
  }
  var j = 0;
  for (var i = digits.length; i > 0; i--) {
      uictx.drawImage(scoreim, 47.5 * digits[i-1], 0, 47.5, 50, 30 + 35 * j , 80 , 50, 50);
      j++;
  }
  
  uictx.drawImage(divider, 52, 130, 196, 5);
  
  uictx.drawImage(hscoretext, 90, 130, 120, 30);
  
  var workinghigh = hscore;
  digits = new Array();
  for (var i = 0; workinghigh > 0; i++) {
    digits[i] = workinghigh % 10;
    workinghigh = Math.floor(workinghigh / 10);
  }
  var j = 0;
  for (var i = digits.length; i > 0; i--) {
      uictx.drawImage(scoreim, 47.5 * digits[i-1], 0, 47.5, 50, 70 + 20 * j , 160 , 30, 30);
      j++;
  }
  
    uictx.drawImage(divider, 52, 190, 196, 5);

  
  //uictx.fillText("Score: " + Math.floor(score),20,50);
  //uictx.fillText("High Score: " + hscore,30,80);
  //uictx.fillText("Games Played: " + gamesplayed,30,110);
  //uictx.fillText("Leaderboard",30,140);
  if(loggedIn)
  {
    for(var i = 0; i < 4; i++)
    {
      uictx.drawImage(frameIm,88,218 + i * 70, 44,44)
      uictx.drawImage(faces[i],90,220 + i * 70, 40,40)
      uictx.fillText(friendNames[i],140,250 + i * 70);
    }
  }
  else {
          uictx.fillText("Want some help?",30,250);
          uictx.fillText("Log in with",37,290);
          uictx.fillText("Facebook!",45,330);

  }

  
}

function resetScore()
{
  score = 0;
}