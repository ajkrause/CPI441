  var uiCanvas = document.getElementById("UICanvas");
  
  //var uimoveX = moveX - 1000;
  //var uimoveY = moveY;
  
  var uictx = uiCanvas.getContext("2d");
  var scoreim = new Image();
  scoreim.src = "art/ui/Numbers.png";
  var scoretext = new Image();
  scoretext.src = "art/ui/score.png";
  var hscoretext = new Image();
  hscoretext.src = "art/ui/HighScore.png";
  var pauseim = new Image();
  pauseim.src = "art/ui/UI_pause.png";
  var soundim = new Image();
  soundim.src = "art/ui/UI_nosound.png";
  var soundOff = new Image();
  soundOff.src = "art/ui/UI_nosound.png";
  var soundOffMo = new Image();
  soundOffMo.src = "art/ui/UI_nosound_mo.png";
  var uibackground = new Image();
   uibackground.src = "art/ui/UI_logs_bckrnd_woodgrain.png";
  var divider = new Image();
  divider.src = "art/ui/UI_div.png";
  var frameIm = new Image();
  frameIm.src = "art/ui/fb_profile_frame.png";
  var starim = new Image();
  starim.src = "art/ui/star.gif";
  var estar = new Image();
  estar.src = "art/ui/empty_star.png";
  
  var soundOn = false;
  var paused = false;
  
  var faces = new Array()
  for(var i = 0; i < 4; i++)
  {
    faces[i] = new Image();
    faces[i].src = friendPics[i];
  }
  
  function uiclick() {

    
  }
  function uimove(){
   var uimoveX = moveX - 1000;
   var uimoveY = moveY;
   //uictx.drawImage(soundim, 52, 535, 92, 35);
   if(uimoveX > 51 && uimoveX < 144 && uimoveY >535 && uimoveY < 570)
   {
    if(soundOn == false)
    {
      soundim.src = soundOffMo.src;
    }
   }
  else{
    if(soundOn == false)
    {
      soundim.src = soundOff.src;
    }
    
   }
   
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
      uictx.drawImage(starim, 30, 220 + i * 70, 40, 40);
      uictx.drawImage(frameIm,88,218 + i * 70, 44,44)
      uictx.drawImage(faces[i],90,220 + i * 70, 40,40)
      uictx.fillText(friendNames[i],140,250 + i * 70);
    }
  }
  else {
          uictx.fillText("Want some help?",30,250);
          uictx.fillText("Log in with",40,290);
          uictx.fillText("Facebook!",50,330);

  }
  
          
          uictx.drawImage(divider, 52, 520, 196, 5);
          uictx.drawImage(soundim, 52, 535, 92, 35);


  
}

function resetScore()
{
  score = 0;
}