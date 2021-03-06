<?php Header("Content-Type: application/x-javascript; charset=UTF-8"); ?>

var comicArray = new Array();
for (var i = 0; i < 13; i++) {
    comicArray[i] = new Image();
    comicArray[i].src = "art/introanimation/Intro" + (i + 1) + ".png";
}

var count = 0;
var intro;

var introActive = false;
var playing = true;
var buttonDown = false;
var play = false;
var stopMenu;
var stopEnd;
var clearEndDisplay;
var endGraphic = false;
var endUndim = false;

var mouseX = 0;
var mouseY = 0;
var selectionX = 0;
var selectionY = 0;
var moveX = 0;
var moveY = 0;
var yPos1 = canvas.height/2 - 50; //paddle1 starting position
var yPos2 = canvas.height/2 - 50; //paddle2 starting position

var pongPosX = (canvas.width/2); //pong starting xvalue
var pongPosY = (canvas.height/2); //pong starting yvalue

//Canvas Variables
var c; //main game canvas
var ctx; //main game contex
var canvasFloor; //draws floor and grass once
var ctxFloor;
var canvasWalls; //updates walls less frequent
var ctxWalls;
var canvasMenu; //displays menu...then is transparent
var ctxMenu;
var canvasGUI;
var ctxGUI;
var canvasEnd;
var ctxEnd;

//GUI variables
var GUIWidth = 300;
var digits = new Array();
var digitOffset = 0;
var scoreTemp = 0;
var highScore = hscore;
var highScoreTemp = 0;
var initializedHS = false;
var highDigits = new Array();
var playState = 2;
var gameState = new Array();
var soundState = 0;
var musicState = new Array();
var playButtonState = 0;
var startButtonState = new Array();

var skipMouse = 0;
var skipState = new Array();

//GUI images
var GUIBackground;
var GUIScore;
var GUINumbers;
var divider;
var GUIHighScore;
var starFilled;
var starEmpty;
var profileImage;
var profileFrame;
var playImage;
var playImageMO;
var pauseImage;
var pauseImageMO;
var playMusicImage;
var playMusicImageMO;
var pauseMusicImage;
var pauseMusicImageMO;

var skipImage;
var skipImageMO;

var menuImage;
var playButtonImage;
var playButtonImageMO;
var pulseImage = 90;
var pulseOver = false;
var pulsePlayAgain = 90;
var pulseOverPlayAgain = false;
var pulseStar = 90;
var starSprite;
var starFrame = 0;

var endGameImage;
var endPlayAgain;
var endPlayAgainMO;
var gradientX = 0;
var gradientY = 0;
var gradientScale = 10;

var pulseFriend = 0;
var drawFriend = false;

var damagePulse = 0;
var damagePulseSwitch = false;

var newBear = 0;
var bearTime = -1;
var newFox = -3000;
var Ftime = -1;
var newRam = -7000;
var ramTime = -1;
var birdPath = [];
var ramAttacked = false;
var newBird = 0;
var Btime = -1;
var newBird2 = 0;
var Btime2 = -1;
var secondBird = true;
var foxpack = 1;
var birdcount = 1;
var bearflag = false;
var bearMin = 175;
var bearMax = 300;
var foxMin = 500;
var foxMax = 700;
var ramMin = 400;
var ramMax = 500;
var birdMin = 120;
var birdMax = 240;
var bearDamage = 50; //must be even
var foxDamage = 2;
var woodPeckerDamage = 1;
var ramDamage = 70;

var score = 0;

var blondeMale;
var brunetteMale;
var darkMale;
var blondeFemale;
var brunetteFemale;
var darkFemale;

var friendImage;
var friendName;

var bearImage;
var birdImage;
var ramImage;
var smoke;
var foxImage;

var wall1;
var wall2;
var wall3;
var wall4;

var wallDamaged;
var wallCritical;
var wallBroken;

var directions;
var grassLight;
var grassDark;
var grass;
var grassPlay;
var table;
var inside;
var insideLight;
var innerCorner;
var outerCorner;

var cornerBroken;
var cornerCritical;
var cornerDamaged;

var logPoint1;
var logPoint2;
var splinters;

var offset = 0;


//how many characters to draw
var numCharacters = 5;
var characterValue = 0;

var activePlayer = -1;
var characterSelected = false;
var mouseDownX = 0;
var mouseDownY = 0;
var boardWidth = 40;
var boardHeight = 24;
var halfBoardWidth = boardWidth/2;
var halfBoardHeight = boardHeight/2;
var squareWidth = canvas.width/boardWidth;
var squareHeight = canvas.height/boardHeight;
var board = new Array(boardWidth);

var damagedList = []; //value to draw regarding damaged walls
var smokeList = [];
var Characters = []; //set of characters
var Enemies = [];
var neighbors = []; //neighbors
var startNode;
var endNode;
var openList = [];

var shiftHouseX = -7;
var shiftHouseY = 0;
//Inner floor bound variables
var xMin = Math.floor((boardWidth/2)-(boardWidth/8)+shiftHouseX);
var xMax = Math.floor((boardWidth/2)+(boardWidth/8)+shiftHouseX+1);
var yMin = Math.floor((boardHeight/2)-(boardWidth/8)+shiftHouseY);
var yMax = Math.floor((boardHeight/2)+(boardWidth/8)+shiftHouseY);

//Room mins and maxes for X and Y
var roomXmin, roomXmax, roomYmin, roomYmax;

function object(index, health, type, opened, closed, g, f, h, parent, image, rotate, amountHealing, pulseHealth, pulseSwitch, beingAttacked){
        this.index = index;
        this.health = health;
        this.type = type;
        this.opened = opened;
        this.closed = closed;
        this.g = g;
        this.f = f;
        this.h = h;
        this.parent = parent;
        this.image = image;
        this.rotate = rotate;
        this.amountHealing = amountHealing;
        this.pulseHealth = pulseHealth;
        this.pulseSwitch = pulseSwitch;
        this.beingAttacked = beingAttacked;
}

function character(image, rotate, boardX, boardY, PosX, PosY, desiredPosX, desiredPosY, Path, power, mouseX, mouseY, moved, friendNumber, speed){
        this.image = image;
        this.rotate = rotate;
        this.boardX = boardX;
        this.boardY = boardY;
        this.PosX = PosX;
        this.PosY = PosY;
        this.desiredPosX = desiredPosX;
        this.desiredPosY = desiredPosY;
        this.Path = Path;
        this.power = power;
        this.mouseX = mouseX;
        this.mouseY = mouseY;
        this.moved = moved;
        this.friendNumber = friendNumber;
        this.speed = speed;
}

function enemy(image, type, startPosX, startPosY, posX, posY, desiredPosX, desiredPosY, rotation, damage, stage, speed, frame, translateX, translateY, attackBoardX, attackBoardY, phase){
        this.image = image;
        this.type = type; //Bear, wolf, rabbit, etc
        this.startPosX = startPosX;
        this.startPosY = startPosY;
        this.posX = posX;
        this.posY = posY;
        this.desiredPosX = desiredPosX;
        this.desiredPosY = desiredPosY;
        this.rotation = rotation;
        this.damage = damage;
        this.stage = stage;
        this.speed = speed;
        this.frame = frame;
        this.translateX = translateX;
        this.translateY = translateY;
        this.attackBoardX = attackBoardX;
        this.attackBoardY = attackBoardY;
        this.phase = phase;
}

function pathPoint(x, y){
        this.x = x;
        this.y = y;
}

function damagedObject(posX, posY, damage, alpha, linger, time){
        this.posX = posX;
        this.posY = posY;
        this.damage = damage;
        this.alpha = alpha;
        this.linger = linger;
        this.time = time;
}

function smokeObject(posX, posY, alpha, linger, time){
        this.posX = posX;
        this.posY = posY;
        this.alpha = alpha;
        this.linger = linger;
        this.time = time;
}

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

function randomInterval(from,to)
{
    return Math.floor(Math.random()*(to-from+1)+from);
}

function randomWall(random){
        if(random == 1){
                return wall1;
        }
        else if(random == 2){
                return wall2;
        }
        else if(random == 3){
                return wall3;
        }
        else{
                return wall4;
        }
        return wall1;
}

menu();
init();

function drawMenu(){
        ctxMenu.clearRect(0, 0, canvasMenu.width, canvasMenu.height);
        ctxMenu.beginPath();
        
        drawGUI();
        
        var length = document.getElementById('MyAudio').duration - 2;
        var length2 = document.getElementById('MyAudio').currentTime;
        if(length2 > length){
                document.getElementById('MyAudio').currentTime = 0;
        }
        
        if(!play){
                var temp = Math.abs(Math.cos(pulseImage*Math.PI/180))*3;
		ctxMenu.drawImage(menuImage, 0, 0, 700, 600, 0, 0, 700, 600);
                if(pulseOver){
                        if(pulseImage >= 360){
                                pulseImage = 0;
                        }
                        else{
                                pulseImage = pulseImage + 6;
                        }
                        ctxMenu.drawImage(startButtonState[playButtonState], 0, 0, 230, 88, 235 - temp, 490 - temp, 230 + (temp*2), 88 + (temp*2));
                }
                else{
                        pulseImage = 90;
                        ctxMenu.drawImage(startButtonState[playButtonState], 0, 0, 230, 88, 235, 490, 230, 88);
                }
        }
        else{
                clearInterval(stopMenu);
                playing = false;
                introActive = true;
                playGame();
                playIntro();
                
        }
}

function menu(){
        canvasMenu = document.getElementById("menu");
        ctxMenu = canvasMenu.getContext("2d");
        canvasGUI = document.getElementById("canvasGUI");
        ctxGUI = canvasGUI.getContext("2d");
        
        //GUI images
        GUIBackground = new Image();
        GUIScore = new Image();
        GUINumbers = new Image();
        divider = new Image();
        GUIHighScore = new Image();
        starFilled = new Image();
        starEmpty = new Image();
        profileImage = new Image();
        profileFrame = new Image();
        playImage = new Image();
        playImageMO = new Image();
        pauseImage = new Image();
        pauseImageMO = new Image();
        playMusicImage = new Image();
        playMusicImageMO = new Image();
        pauseMusicImage = new Image();
        pauseMusicImageMO = new Image();
        skipImage = new Image();
        skipImageMO = new Image();
        
        menuImage = new Image();
        playButtonImage = new Image();
	playButtonImageMO = new Image();
        grass = new Image();
        grassPlay = new Image();
        friendImage = new Image();
        directions = new Image();
        
        starSprite = new Image();
        
        //GUI image load
        GUIBackground.src = "art/GUI/UI_logs_bckrnd_woodgrains.png";
        GUIScore.src = "art/GUI/score.png";
        GUINumbers.src = "art/GUI/Numbers.png";
        divider.src = "art/GUI/UI_div.png";
        GUIHighScore.src = "art/GUI/HighScore.png";
        starFilled.src = "art/GUI/star.gif";
        starEmpty.src = "art/GUI/empty_star.png";
        profileImage.src = "art/GUI/profileBearCute.png";
        profileFrame.src = "art/GUI/fb_profile_frame.png";
        playImage.src = "art/GUI/UI_play.png";
        playImageMO.src = "art/GUI/UI_play_mo.png";
        pauseImage.src = "art/GUI/UI_pause.png";
        pauseImageMO.src = "art/GUI/UI_pause_mo.png";
        gameState.push(playImage);
        gameState.push(playImageMO);
        gameState.push(pauseImage);
        gameState.push(pauseImageMO);
        playMusicImage.src = "art/GUI/UI_sound.png";
        playMusicImageMO.src = "art/GUI/UI_sound_mo.png";
        pauseMusicImage.src = "art/GUI/UI_nosound.png";
        pauseMusicImageMO.src = "art/GUI/UI_nosound_mo.png";
        musicState.push(playMusicImage);
        musicState.push(playMusicImageMO);
        musicState.push(pauseMusicImage);
        musicState.push(pauseMusicImageMO);
        
        starSprite.src = "art/GUI/star_sprite_sheet.png";
        
        menuImage.src = "art/GUI/Start_Splash.png";
        playButtonImage.src = "art/GUI/UI_Start.png";
	playButtonImageMO.src = "art/GUI/UI_Start_mo.png";
        startButtonState.push(playButtonImage);
        startButtonState.push(playButtonImageMO);
        grass.src = "art/house/Grass_Continuous_Grid2.png";
        grassPlay.src = "art/house/Grass_Continuous_Grid_Play.png";
        directions.src = "art/GUI/instructions.png";
        
        skipImage.src = "art/GUI/UI_skip.png";
        skipImageMO.src = "art/GUI/UI_skip_mo.png";
        skipState.push(skipImage);
        skipState.push(skipImageMO);
        
        drawMenu();
        stopMenu = setInterval(drawMenu, 30);
}

function playGame(){
        refresh();
        gameLoop();
}

function init() {
document.onkeydown = keyDown;
document.onmouseup = mouseUp;
document.onmousemove = mouseMove;

c = document.getElementById("canvas");
ctx = c.getContext("2d");
ctx.font="16px Calibri";

canvasFloor = document.getElementById("canvasFloor");
ctxFloor = canvasFloor.getContext("2d");

canvasWalls = document.getElementById("canvasWalls");
ctxWalls = canvasWalls.getContext("2d");

canvasEnd = document.getElementById("canvasEnd");
ctxEnd = canvasEnd.getContext("2d");

//Image variables
blondeMale = new Image();
brunetteMale = new Image();
darkMale = new Image();
blondeFemale = new Image();
brunetteFemale = new Image();
darkFemale = new Image();

bearImage = new Image();
birdImage = new Image();
ramImage = new Image();
smoke = new Image();
foxImage = new Image();

wall1 = new Image();
wall2 = new Image();
wall3 = new Image();
wall4 = new Image();

wallDamaged = new Image();
wallCritical = new Image();
wallBroken = new Image();

table = new Image();
inside = new Image();
insideLight = new Image();
innerCorner = new Image();
outerCorner = new Image();

cornerCritical = new Image();
cornerDamaged = new Image();
cornerBroken = new Image();

logPoint1 = new Image();
logPoint2 = new Image();
splinters = new Image();

endGameImage = new Image();
endPlayAgain = new Image();
endPlayAgainMO = new Image();
endGameGradient = new Image();

//Loading images
blondeMale.src = "art/characters/blonde_male.png";
brunetteMale.src = "art/characters/brunette_male.png";
darkMale.src = "art/characters/dark_male.png";
blondeFemale.src = "art/characters/blonde_female.png";
brunetteFemale.src = "art/characters/brunette_female.png";
darkFemale.src = "art/characters/black_hair_female.png";

bearImage.src = "art/enemies/bear_sprite_sheet2.png";
birdImage.src = "art/enemies/woodpecker_sprite_sheet.png";
ramImage.src = "art/enemies/Ram_Sprite_Sheet.png";
smoke.src = "art/enemies/dustcloud_sprite_sheet.png";
foxImage.src = "art/enemies/Fox_Sprite_Sheet.png";

wall1.src = "art/house/Log1.png";
wall2.src = "art/house/Log2.png";
wall3.src = "art/house/Log3.png";
wall4.src = "art/house/Log4.png";

wallDamaged.src = "art/house/Log_Damaged.png";
wallCritical.src = "art/house/Log_Critical.png";
wallBroken.src = "art/house/Log_Destroyed.png";

table.src = "art/house/table.png";
inside.src = "art/house/Floor_Dark_Test.png";
insideLight.src = "art/house/Floor_Light_Test.png";
innerCorner.src = "art/house/Log_Interior.png";
outerCorner.src = "art/house/Log_Exterior.png";

cornerCritical.src = "art/house/Log_Interior_Critical.png";
cornerDamaged.src = "art/house/Log_Interior_Damaged.png";
cornerBroken.src = "art/house/Log_Interior_Destroyed.png";

logPoint1.src = "art/house/Log_Point1_Test.png";
logPoint2.src = "art/house/Log_Point2_Test.png";
splinters.src = "art/house/splinter_spritesheet2.png";

endGameImage.src = "art/GUI/corrected_game_over.png";
endPlayAgain.src = "art/GUI/play_again_button_revised.png";
endPlayAgainMO.src = "art/GUI/play_again_button_revised_mo.png";
endGameGradient.src = "art/enemies/EndGameGradient.png";

//Create 2D board
//(0 == wall, 1 == outerfloor, 2 == character, 3 == innerfloor, 4 == enemy, 5 == logPoint)
for(var i = 0; i < boardWidth; i++){
        board[i] = new Array(boardHeight);
}

//Initialize board
for(var x = 0; x < boardWidth; x++){
        for(var y = 0; y < boardHeight; y++){
                //If within inner bound, give index of 3
                if(x > xMin && y > yMin && x < xMax && y < yMax){
                        board[x][y] = (new object(3, -1, -1, false, false, 0, 0, 0, [], wall1, 0, 0, 0, false, false));
                }
                //Else set as outside
                else{
                        board[x][y] = (new object(1, -1, -1, false, false, 0, 0, 0, [], inside, 0, 0, 0, false, false));
                }
        }
}

//Create random levels
for(var i = 0; i < 4; i++){
        var randomX = randomInterval(3, 4);
        var randomY = randomInterval(3, 4);
        if(i == 0){
                for(var j = 0; j < randomY; j++){
                        for(var k = 0; k < randomX; k++){
                                board[halfBoardWidth-k-3+shiftHouseX][halfBoardHeight-j-3+shiftHouseY].index = 3;
                        }
                }
                roomXmin = xMin - randomX + 3;
                roomYmin = yMin - randomY + 3;
        }
        if(i == 1){
                for(var j = 0; j < randomY; j++){
                        for(var k = 0; k < randomX; k++){
                                board[halfBoardWidth+k+4+shiftHouseX][halfBoardHeight-j-3+shiftHouseY].index = 3;
                        }
                }
                
                if(roomYmin > (yMin - randomY + 3)){
                        roomYmin = yMin - randomY + 3;
                }
                roomXmax = xMax + randomX - 2;
        }
        if(i == 2){
                for(var j = 0; j < randomY; j++){
                        for(var k = 0; k < randomX; k++){
                                board[halfBoardWidth-k-3+shiftHouseX][halfBoardHeight+j+3+shiftHouseY].index = 3;
                        }
                }
                
                if(roomXmin > (xMin - randomX + 3)){
                        roomXmin = xMin - randomX + 3;
                }
                roomYmax = yMax + randomY - 2;
        }
        if(i == 3){
                for(var j = 0; j < randomY; j++){
                        for(var k = 0; k < randomX; k++){
                                board[halfBoardWidth+k+4+shiftHouseX][halfBoardHeight+j+3+shiftHouseY].index = 3;
                        }
                }
                
                if(roomXmax < (xMax + randomX - 2)){
                        roomXmax = xMax + randomX - 2;
                }
                if(roomYmax < (yMax + randomY - 2)){
                        roomYmax = yMax + randomY - 2;
                }
        }
}

//Expands boundary by 1 in each direction
roomXmax++;
roomXmin--;
roomYmax++;
roomYmin--;

//bird path
//top
birdPath.push(new pathPoint(7, 1));
//left
birdPath.push(new pathPoint(2, 6));
birdPath.push(new pathPoint(2, 17));
//bottom
birdPath.push(new pathPoint(7, 22));
birdPath.push(new pathPoint(22, 22));
//right
birdPath.push(new pathPoint(27, 17));
birdPath.push(new pathPoint(27, 7));
//top
birdPath.push(new pathPoint(22, 1));

//place walls
for(var y = roomYmin; y < roomYmax; y++){
        for(var x = roomXmin; x < roomXmax; x++){
                if(board[x+1][y].index == 3 && (board[x-1][y].index == 1 || board[x-1][y].index == 0) && board[x][y].index == 1){
                        board[x][y].index = 0; //left wall
                        board[x][y].health = 180;
                        
                }
                if(board[x-1][y].index == 3 && (board[x+1][y].index == 1 || board[x+1][y].index == 0) && board[x][y].index == 1){
                        board[x][y].index = 0; //right wall
                        board[x][y].health = 180;
                }
                if(board[x][y+1].index == 3 && (board[x][y-1].index == 1 || board[x][y-1].index == 0) && board[x][y].index == 1){
                        board[x][y].index = 0; //top wall
                        board[x][y].health = 180;
                }
                if(board[x][y-1].index == 3 && (board[x][y+1].index == 1 || board[x][y+1].index == 0) && board[x][y].index == 1){
                        board[x][y].index = 0; //bottom wall
                        board[x][y].health = 180;
                }
                if(board[x-1][y-1].index == 3 && (board[x+1][y+1].index == 1 || board[x+1][y+1].index == 0) && board[x][y].index == 1){
                        board[x][y].index = 0; //bottom right corner
                        board[x][y].health = 180;
                }
                if(board[x+1][y-1].index == 3 && (board[x-1][y+1].index == 1 || board[x-1][y+1].index == 0) && board[x][y].index == 1){
                        board[x][y].index = 0; //bottom left corner
                        board[x][y].health = 180;
                }
                if(board[x-1][y+1].index == 3 && (board[x+1][y-1].index == 1 || board[x+1][y-1].index == 0) && board[x][y].index == 1){
                        board[x][y].index = 0; //top right corner
                        board[x][y].health = 180;
                }
                if(board[x+1][y+1].index == 3 && (board[x-1][y-1].index == 1 || board[x-1][y-1].index == 0) && board[x][y].index == 1){
                        board[x][y].index = 0; //top left corner
                        board[x][y].health = 180;
                }
                if((board[x][y].index == 0 || board[x][y].index == 1) && 
                (((board[x+1][y].index == 3 || board[x+2][y].index == 3) && board[x-1][y].index == 3) || 
                ((board[x][y+1].index == 3 || board[x][y+2].index == 3) && board[x][y-1].index == 3))){
                        board[x][y].index = 3;
                }
        }
}

for(var y = roomYmin; y < roomYmax; y++){
        for(var x = roomXmin; x < roomXmax; x++){
                //top left corner
                if(board[x][y].index == 0 && board[x+1][y].index == 0 && board[x][y+1].index == 0){
                        if(board[x+1][y+1].index == 3){
                                board[x][y].type = 0;
                        }
                        else{
                                board[x][y].type = 8;
                        }
                }
                //top right corner
                else if(board[x][y].index == 0 && board[x-1][y].index == 0 && board[x][y+1].index == 0){
                        if(board[x-1][y+1].index == 3){
                                board[x][y].type = 1;
                        }
                        else{
                                board[x][y].type = 9;
                        }
                }
                //bottom left corner
                else if(board[x][y].index == 0 && board[x-1][y].index == 0 && board[x][y-1].index == 0){
                        if(board[x-1][y-1].index == 3){
                                board[x][y].type = 2;
                        }
                        else{
                                board[x][y].type = 10;
                        }
                }
                //bottom right corner
                else if(board[x][y].index == 0 && board[x+1][y].index == 0 && board[x][y-1].index == 0){
                        if(board[x+1][y-1].index == 3){
                                board[x][y].type = 3;
                        }
                        else{
                                board[x][y].type = 11;
                        }
                }
                //left
                else if(board[x][y].index == 0 && board[x-1][y].index == 1 && board[x+1][y].index == 3){
                        board[x][y].type = 4;
                }
                //right
                else if(board[x][y].index == 0 && board[x-1][y].index == 3 && board[x+1][y].index == 1){
                        board[x][y].type = 5;
                }
                //up
                else if(board[x][y].index == 0 && board[x][y-1].index == 1 && board[x][y+1].index == 3){
                        board[x][y].type = 6;
                }
                //bottom
                else if(board[x][y].index == 0 && board[x][y-1].index == 3 && board[x][y+1].index == 1){
                        board[x][y].type = 7;
                }	
        }
}

function createCharacters(x, y, rot){
        board[x][y].index = 2;
        var pic;
        pic = new Image();
        var check = randomInterval(0,5);
        switch(check){
                case 0:
                        pic.src = blondeMale.src;
                        break;
                case 1:
                        pic.src = brunetteMale.src;
                        break;
                case 2: 
                        pic.src = darkMale.src;
                        break;
                case 3:
                        pic.src = blondeFemale.src;
                        break;
                case 4:
                        pic.src = brunetteFemale.src;
                        break;
                case 5:
                        pic.src = darkFemale.src;
                        break;
                default:
                        pic.src = brunetteMale.src;
                        break;
        }
        var power = 1;
        if(friendGamesPlayed[characterValue] > 0) power = 1.5;
        Characters.push(new character(pic, rot, x, y, (squareWidth*x) + (squareWidth/2), (squareHeight*y) + (squareHeight/2), 
        (squareWidth*x) + (squareWidth/2), (squareHeight*y) + (squareHeight/2), [], power, 0, 0, false, characterValue, 2.0));
        numCharacters = numCharacters - 1;
        characterValue++;
}

//Get image and rotation
for(var y = roomYmin; y < roomYmax; y++){
        for(var x = roomXmin; x < roomXmax; x++){
                if(board[x][y].index == 0){
                        board[x][y].image = initializeWalls(board[x][y].type);
                        board[x][y].rotate = findRotation(board[x][y].type);
                        
                        //Calculate room log points
                        if(board[x][y].image == outerCorner && board[x][y].rotate == 0){
                                board[x+1][y].index = 5;
                                board[x+1][y].image = logPoint1;
                                board[x+1][y].rotate = 0;
                                board[x][y-1].index = 5;
                                board[x][y-1].image = logPoint2;
                                board[x][y-1].rotate = -90;
                        }
                        else if(board[x][y].image == outerCorner && board[x][y].rotate == 90){
                                board[x+1][y].index = 5;
                                board[x+1][y].image = logPoint2;
                                board[x+1][y].rotate = 0;
                                board[x][y+1].index = 5;
                                board[x][y+1].image = logPoint1;
                                board[x][y+1].rotate = 90;
                        }
                        else if(board[x][y].image == outerCorner && board[x][y].rotate == 180){
                                board[x-1][y].index = 5;
                                board[x-1][y].image = logPoint1;
                                board[x-1][y].rotate = 180;
                                board[x][y+1].index = 5;
                                board[x][y+1].image = logPoint2;
                                board[x][y+1].rotate = 90;
                        }
                        else if(board[x][y].image == outerCorner && board[x][y].rotate == 270){
                                board[x-1][y].index = 5;
                                board[x-1][y].image = logPoint2;
                                board[x-1][y].rotate = 180;
                                board[x][y-1].index = 5;
                                board[x][y-1].image = logPoint1;
                                board[x][y-1].rotate = -90;
                        }
                }
        }
}

rotate = 0;

board[13][11].index = 2;
board[13][12].index = 2;
board[13][13].index = 2;
board[14][11].index = 2;
board[14][12].index = 2;
board[14][13].index = 2;
board[13][11].type = -2;
board[13][12].type = -2;
board[13][13].type = -2;
board[14][11].type = -2;
board[14][12].type = -2;
board[14][13].type = -2;

createCharacters(12, 11, 90);
  if(connectedFacebook && numfriends.toString() > 2)
  {
    createCharacters(12, 13, 90);
    createCharacters(15, 11, -90);
    createCharacters(15, 13, -90);
  }
}

function keyDown(e) {
        if(!e) {
                e = window.event;
        }
        if(e.keyCode == 49){
                if(Characters[0].PosX == Characters[0].desiredPosX && Characters[0].PosY == Characters[0].desiredPosY){
                        if(moveX > 0 && moveX < c.width && moveY > 0 && moveY < c.height){
                        activePlayer = 0;
                        characterSelected = true;
                        selectionX = Characters[0].PosX;
                        selectionY = Characters[0].PosY;
                        }
                }
        }
        else if(e.keyCode == 50){
                if(Characters[1].PosX == Characters[1].desiredPosX && Characters[1].PosY == Characters[1].desiredPosY){
                        if(moveX > 0 && moveX < c.width && moveY > 0 && moveY < c.height){
                        activePlayer = 1;
                        characterSelected = true;
                        selectionX = Characters[1].PosX;
                        selectionY = Characters[1].PosY;
                        }
                }
        }
        else if(e.keyCode == 51){
                if(Characters[2].PosX == Characters[2].desiredPosX && Characters[2].PosY == Characters[2].desiredPosY){
                    if(moveX > 0 && moveX < c.width && moveY > 0 && moveY < c.height)   {
                        activePlayer = 2;
                        characterSelected = true;
                        selectionX = Characters[2].PosX;
                        selectionY = Characters[2].PosY;
                        }
                }
        }
        else if(e.keyCode == 52){
                if(Characters[3].PosX == Characters[3].desiredPosX && Characters[3].PosY == Characters[3].desiredPosY){
                if(moveX > 0 && moveX < c.width && moveY > 0 && moveY < c.height){
                        activePlayer = 3;
                        characterSelected = true;
                        selectionX = Characters[3].PosX;
                        selectionY = Characters[3].PosY;
                        }
                }
        }
}

function mouseUp(e){
mouseX = e.clientX + document.body.scrollLeft +
document.documentElement.scrollLeft - c.offsetLeft;
mouseY = e.clientY + document.body.scrollTop +
document.documentElement.scrollTop - c.offsetTop;

//Mouse click on play game
if(!play && mouseX <= 465 && mouseX >= 235 && mouseY <= 578 && mouseY >= 490){
        play = !play;
        bearTime = randomInterval(bearMin, bearMax);
        Ftime = randomInterval(foxMin, foxMax);
        ramTime = randomInterval(ramMin, ramMax);
        Btime = randomInterval(birdMin, birdMax);
        Btime2 = randomInterval(1800, 3600);
        placeBird();
        if(soundState == 0){
                pauseSound();
                playGameSound();
        }
}

if(!playing && mouseX <= 725 && mouseX >= 275 && mouseY <= 520 && mouseY >= 400){
        restart();
}

//Mouse click on play/pause...or mute/unmute
if(mouseX <= 952 && mouseX >= 860 && mouseY <= 555 && mouseY >= 520){
        if(soundState == 1){
                soundState = 3;
                pauseGameSound();
		pauseSound();
        }
        else{
                soundState = 1;
                if(!play){
                        playSound();
                }
                else{
                        playGameSound();
                }
        }
}

//Still need to add code to actually pause and play game
if(mouseX <= 842 && mouseX >= 650 && mouseY <= 555 && mouseY >= 520){
        if(introActive)
        {
            introActive = false;
            count = 14;
            
        }
        else
        {
          if(playState == 1){
                  playState = 3;
                  playing = true;
          }
          else{
                  playState = 1;
                  playing = false;
          }
        }
}

//Have mouse x and y snapped to grid
mouseDownX = (Math.floor((mouseX/squareWidth))*squareWidth) + (squareWidth/2);
mouseDownY = (Math.floor((mouseY/squareHeight))*squareHeight) + (squareHeight/2);

  if(playing)
  {
    gameSelection();
  }
}

function mouseMove(e){
moveX = e.clientX + document.body.scrollLeft +
document.documentElement.scrollLeft - c.offsetLeft;
moveY = e.clientY + document.body.scrollTop +
document.documentElement.scrollTop - c.offsetTop;
if(moveX > 0 && moveX < c.width && moveY > 0 && moveY < c.height){
    if(!play){
            if(moveX <= 465 && moveX >= 235 && moveY <= 578 && moveY >= 490){
                    pulseOver = true;
                    playButtonState = 1;
            }
            else{
                    pulseOver = false;
                    playButtonState = 0;
            }
    }
    else{
            if(board[Math.floor(moveX/squareWidth)][Math.floor(moveY/squareHeight)].index == 2){
                drawFriend = true;
            }
            else{
                drawFriend = false;
            }
    }
    if(moveX <= 842 && moveX >= 750 && moveY <= 555 && moveY >= 520){
            skipMouse = 1; 
            if(playState == 0){
                    playState = 1;
            }
            else if(playState == 2){
                    playState = 3;
            }
    }
    else{
            skipMouse = 0;
            if(playState == 1){
                    playState = 0;
            }
            else if(playState == 3){
                    playState = 2;
            }
    }
    
    if(moveX <= 952 && moveX >= 860 && moveY <= 555 && moveY >= 520){
            if(soundState == 0){
                    soundState = 1;
            }
            else if(soundState == 2){
                    soundState = 3;
            }
    }
    else{
            if(soundState == 1){
                    soundState = 0;
            }
            else if(soundState == 3){
                    soundState = 2;
            }
    }
    if(!playing && moveX <= 725 && moveX >= 275 && moveY <= 520 && moveY >= 400){
            pulseOverPlayAgain = true;
    }
    else{
            pulseOverPlayAgain = false;
    }
    }
}

function gameSelection(){
    if(mouseX > 0 && mouseX < c.width && mouseY > 0 && mouseY < c.height){
            //if clicked on player
            for(var i = 0; i < Characters.length; i++){
                    if(mouseX > (Characters[i].PosX - (squareWidth/2)) && mouseX < (Characters[i].PosX + (squareWidth/2)) &&
                    mouseY > (Characters[i].PosY - (squareWidth/2)) && mouseY < (Characters[i].PosY + (squareHeight/2))){
                            if(Characters[i].PosX == Characters[i].desiredPosX && Characters[i].PosY == Characters[i].desiredPosY){
                            activePlayer = i;
                            characterSelected = true;
                            selectionX = mouseDownX;
                            selectionY = mouseDownY;
                            }
                    }
            }
            
            //look at, getting decimals 
            var x2 = (((squareWidth-(mouseX%squareWidth))+mouseX)/squareWidth)-1;
            var y2 = (((squareHeight-(mouseY%squareHeight))+mouseY)/squareHeight)-1;
            var x1 = Math.round(x2);
            var y1 = Math.round(y2);
    
            //move active player
            if(board[x1][y1].index == 3 && activePlayer != -1){
                    board[Characters[activePlayer].boardX][Characters[activePlayer].boardY].index = 3;
                    Characters[activePlayer].mouseX = x1;
                    Characters[activePlayer].mouseY = y1;
                    Characters[activePlayer].moved = true;
                    openList = [];
                    neighbors = [];
                    var path = findPath(Characters[activePlayer].boardX, Characters[activePlayer].boardY, x1, y1);
                    Characters[activePlayer].Path = path;
                    Characters[activePlayer].desiredPosX = ((squareWidth*Characters[activePlayer].Path[1][0]) + (squareWidth/2));
                    Characters[activePlayer].desiredPosY = ((squareHeight*Characters[activePlayer].Path[1][1]) + (squareHeight/2));
                    Characters[activePlayer].Path = Characters[activePlayer].Path.splice(2, Characters[activePlayer].Path.length-2);
                    board[x1][y1].index = -1;
                    activePlayer = -1;
                    characterSelected = false;
                    resetBoard();
            }
    }
}

function resetBoard(){
        for(var y = roomYmin; y < roomYmax; y++){
                for(var x = roomXmin; x < roomXmax; x++){
                        board[x][y].opened = false;
                        board[x][y].closed = false;
                        board[x][y].g = 0;
                        board[x][y].f = 0;
                        board[x][y].h = 0;
                        board[x][y].parent = [];
                }
        }
}

function gameLoop() {
        var length = document.getElementById('PlayAudio').duration - 2;
        var length2 = document.getElementById('PlayAudio').currentTime;
        if(length2 > length){
                document.getElementById('PlayAudio').currentTime = 0;
        }
        drawGUI();
        if(playing)
        {
          draw();
          drawFloor();
          drawWalls();
          drawDamage();
          drawSmoke();
          moveCharacter();
          moveEnemy();
        }
        requestAnimFrame(gameLoop);
}

function placeBird(){
        var i = 1;
        Enemies.push(new enemy(birdImage, 2, 0, (birdPath[i].y)*squareHeight, 0, (birdPath[i].y)*squareHeight, (birdPath[i].x)*squareWidth, (birdPath[i].y)*squareHeight, 270, woodPeckerDamage,i+4, 2, 0, -squareWidth/2, squareHeight/2, 0, 0, 0));
}

function placeFox(){
        var y1 = randomInterval(roomYmin+1, roomYmax-1);
        var x1 = randomInterval(roomXmin+1, roomXmax+1);
        var dir = randomInterval(0, 3);

        //Attack from left
        if(dir == 0){
                for(var i = roomXmin; i < roomXmax; i++){
                        if(board[i][y1].type == 4 && !(board[i][y1-1].type == 9 || board[i][y1+1].type == 10) && !board[i][y1].beingAttacked){
                                board[i][y1].beingAttacked = true;
                                Enemies.push(new enemy(foxImage, 1, 0, y1*squareHeight, 0, y1*squareHeight, i*squareWidth, y1*squareHeight, 270, foxDamage, 0, 1.5, 0, -squareWidth-1, squareHeight/2, i, y1, -1));
                                break;
                        }
                        else{
                                placeFox();
                                break;
                        }
                }
        }

        //Attack from top
        else if(dir == 1){
                for(var i = roomYmin; i < roomYmax; i++){
                        if(board[x1][i].index == 0){
                                if(board[x1][i].type == 6 && !(board[x1-1][i].type == 11 || board[x1+1][i].type == 10) && !board[x1][i].beingAttacked){
                                        board[x1][i].beingAttacked = true;
                                        Enemies.push(new enemy(foxImage, 1, x1*squareWidth, -squareHeight, x1*squareWidth, -squareHeight, x1*squareWidth, (i-1)*squareHeight, 0, foxDamage, 0, 1.5, 0, squareWidth/2, 0, x1, i, -1));
                                        break;
                                }
                                else{
                                        placeFox();
                                        break;
                                }
                        }
                }
        }
        
        //Attack from right
        else if(dir == 2){
                for(var i = roomXmax; i > roomXmin; i--){
                        if(board[i][y1].index == 0){
                                if(board[i][y1].type == 5 && !(board[i][y1-1].type == 8 || board[i][y1+1].type == 11) && !board[i][y1].beingAttacked){
                                        board[i][y1].beingAttacked = true;
                                        Enemies.push(new enemy(foxImage, 1, canvas.width-GUIWidth, y1*squareHeight, canvas.width-GUIWidth, y1*squareHeight, i*squareWidth, y1*squareHeight, 90, foxDamage, 0, 1.5, 0, squareWidth*2, squareHeight/2, i, y1, -1));
                                        break;
                                }
                                else{
                                        placeFox();
                                        break;
                                }
                        }
                }
        }
        
        //Attack from bottom
        else if(dir == 3){
                for(var i = roomYmax; i > roomYmin; i--){
                        if(board[x1][i].index == 0){
                                if(board[x1][i].type == 7 && !(board[x1-1][i].type == 8 || board[x1+1][i].type == 9) && !board[x1][i].beingAttacked){
                                        board[x1][i].beingAttacked = true;
                                        Enemies.push(new enemy(foxImage, 1, x1*squareWidth, canvas.height-(squareHeight*2), x1*squareWidth, canvas.height-(squareHeight*2), x1*squareWidth, (i-1)*squareHeight, 180, foxDamage, 0, 1.5, 0, squareWidth/2, squareHeight*3, x1, i, -1));
                                        break;
                                }
                                else{
                                        placeFox();
                                        break;
                                }
                        }
                }
        }
}

function placeBear(){
        var y1 = randomInterval(roomYmin+1, roomYmax-1);
        var x1 = randomInterval(roomXmin+1, roomXmax-1);
        var dir = randomInterval(0, 3);
        
        //Attack from left
        if(dir == 0){
                for(var i = roomXmin; i < roomXmax; i++){
                        if(board[i][y1].index == 0){
                                if(board[i][y1].type == 4 && !(board[i][y1-1].type == 9 || board[i][y1+1].type == 10) && !board[i][y1].beingAttacked){
                                        board[i][y1].beingAttacked = true;
                                        Enemies.push(new enemy(bearImage, 0, 0, y1*squareHeight, 0, y1*squareHeight, i*squareWidth, y1*squareHeight, 270, bearDamage, 0, 0.59, 0, -squareWidth-6, squareHeight*(5/8), i, y1, -1));
                                        break;
                                }
                                else{
                                        placeBear();
                                        break;
                                }
                        }
                }
        }
        
        //Attack from top
        else if(dir == 1){
                for(var i = roomYmin; i < roomYmax; i++){
                        if(board[x1][i].index == 0){
                                if(board[x1][i].type == 6 && !(board[x1-1][i].type == 11 || board[x1+1][i].type == 10) && !board[x1][i].beingAttacked){
                                        board[x1][i].beingAttacked = true;
                                        Enemies.push(new enemy(bearImage, 0, x1*squareWidth, -squareHeight, x1*squareWidth, -squareHeight, x1*squareWidth, (i-1)*squareHeight, 0, bearDamage, 0, 0.59, 0, squareWidth*(3/8), -6, x1, i, -1));
                                        break;
                                }
                                else{
                                        placeBear();
                                        break;
                                }
                        }
                }
        }
        
        //Attack from right
        else if(dir == 2){
                for(var i = roomXmax; i > roomXmin; i--){
                        if(board[i][y1].index == 0){
                                if(board[i][y1].type == 5 && !(board[i][y1-1].type == 8 || board[i][y1+1].type == 11) && !board[i][y1].beingAttacked){
                                        board[i][y1].beingAttacked = true;
                                        Enemies.push(new enemy(bearImage, 0, canvas.width-GUIWidth, y1*squareHeight, canvas.width-GUIWidth, y1*squareHeight, i*squareWidth, y1*squareHeight, 90, bearDamage, 0, 0.59, 0, squareWidth*2+6, squareHeight*(3/8), i, y1, -1));
                                        break;
                                }
                                else{
                                        placeBear();
                                        break;
                                }
                        }
                }
        }
        
        //Attack from bottom
        else if(dir == 3){
                for(var i = roomYmax; i > roomYmin; i--){
                        if(board[x1][i].index == 0){
                                if(board[x1][i].type == 7 && !(board[x1-1][i].type == 8 || board[x1+1][i].type == 9) && !board[x1][i].beingAttacked){
                                        board[x1][i].beingAttacked = true;
                                        Enemies.push(new enemy(bearImage, 0, x1*squareWidth, canvas.height-(squareHeight*2), x1*squareWidth, canvas.height-(squareHeight*2), x1*squareWidth, (i-1)*squareHeight, 180, bearDamage, 0, 0.59, 0, squareWidth*(5/8), squareHeight*3+6, x1, i, -1));
                                        break;
                                }
                                else{
                                        placeBear();
                                        break;
                                }
                        }
                }
        }
}

function placeRam(){
        var y1 = randomInterval(roomYmin+1, roomYmax-1);
        var x1 = randomInterval(roomXmin+1, roomXmax-1);
        var dir = randomInterval(0, 3);
        
        //Attack from left
        if(dir == 0){
                for(var i = roomXmin; i < roomXmax; i++){
                        if(board[i][y1].index == 0){
                                if(board[i][y1].type == 4 && !(board[i][y1-1].type == 9 || board[i][y1+1].type == 10) && !board[i][y1].beingAttacked){
                                        board[i][y1].beingAttacked = true;
                                        Enemies.push(new enemy(ramImage, 3, 0, y1*squareHeight, 0, y1*squareHeight, squareWidth*2, y1*squareHeight, 270, ramDamage, 0, 0.8, 0, -squareWidth/2, squareHeight/2, i, y1, -1));
                                        break;
                                }
                                else{
                                        placeRam();
                                        break;
                                }
                        }
                }
        }
        
        //Attack from top
        else if(dir == 1){
                for(var i = roomYmin; i < roomYmax; i++){
                        if(board[x1][i].index == 0){
                                if(board[x1][i].type == 6 && !(board[x1-1][i].type == 11 || board[x1+1][i].type == 10) && !board[x1][i].beingAttacked){
                                        board[x1][i].beingAttacked = true;
                                        Enemies.push(new enemy(ramImage, 3, x1*squareWidth, -squareHeight, x1*squareWidth, -squareHeight, x1*squareWidth, squareHeight*2, 0, ramDamage, 0, 0.8, 0, squareWidth/2, -squareHeight/2, x1, i, -1));
                                        break;
                                }
                                else{
                                        placeRam();
                                        break;
                                }
                        }
                }
        }
        
        //Attack from right
        else if(dir == 2){
                for(var i = roomXmax; i > roomXmin; i--){
                        if(board[i][y1].index == 0){
                                if(board[i][y1].type == 5 && !(board[i][y1-1].type == 8 || board[i][y1+1].type == 11) && !board[i][y1].beingAttacked){
                                        board[i][y1].beingAttacked = true;
                                        Enemies.push(new enemy(ramImage, 3, canvas.width-GUIWidth, y1*squareHeight, canvas.width-GUIWidth, y1*squareHeight, canvas.width-GUIWidth-squareWidth*3, y1*squareHeight, 90, ramDamage, 0, 0.8, 0, squareWidth*(3/2), squareHeight/2, i, y1, -1));
                                        break;
                                }
                                else{
                                        placeRam();
                                        break;
                                }
                        }
                }
        }
        
        //Attack from bottom
        else if(dir == 3){
                for(var i = roomYmax; i > roomYmin; i--){
                        if(board[x1][i].index == 0){
                                if(board[x1][i].type == 7 && !(board[x1-1][i].type == 8 || board[x1+1][i].type == 9) && !board[x1][i].beingAttacked){
                                        board[x1][i].beingAttacked = true;
                                        Enemies.push(new enemy(ramImage, 3, x1*squareWidth, canvas.height, x1*squareWidth, canvas.height, x1*squareWidth, canvas.height-squareHeight*3, 180, ramDamage, 0, 0.8, 0, squareWidth/2, squareHeight*(3/2), x1, i, -1));
                                        break;
                                }
                                else{
                                        placeRam();
                                        break;
                                }
                        }
                }
        }
}

function moveEnemy(position){
        for(var x = 0; x < Enemies.length; x++){
                if(Enemies[x].posX != Enemies[x].desiredPosX || Enemies[x].posY != Enemies[x].desiredPosY){
                        var set = animate(Enemies[x].posX, Enemies[x].posY, Enemies[x].desiredPosX, Enemies[x].desiredPosY, Enemies[x].rotation, Enemies[x].speed);
                        Enemies[x].posX = set[0];
                        Enemies[x].posY = set[1];
                        Enemies[x].rotate = set[2];
                }
        }
}

function moveCharacter(){
        for(var x = 0; x < Characters.length; x++){
                if(Characters[x].PosX != Characters[x].desiredPosX || Characters[x].PosY != Characters[x].desiredPosY){
                        var set = animate(Characters[x].PosX, Characters[x].PosY, Characters[x].desiredPosX, Characters[x].desiredPosY, Characters[x].rotate, Characters[x].speed);
                        Characters[x].PosX = set[0];
                        Characters[x].PosY = set[1];
                        Characters[x].rotate = set[2];
                }
                else{
                        if(Characters[x].Path.length > 0){
                                
                                Characters[x].desiredPosX = ((squareWidth*Characters[x].Path[0][0]) + (squareWidth/2));
                                Characters[x].desiredPosY = ((squareWidth*Characters[x].Path[0][1]) + (squareWidth/2));
                                Characters[x].Path = Characters[x].Path.splice(1, Characters[x].Path.length-1);
                        }
                        else{
                                if(Characters[x].moved){
                                        Characters[x].boardX = Characters[x].mouseX;
                                        Characters[x].boardY = Characters[x].mouseY;
                                        Characters[x].moved = false;
                                        
                                        if(board[Characters[x].boardX + 1][Characters[x].boardY - 1].type == 1){
                                                Characters[x].rotate = 45;
                                        }
                                        else if(board[Characters[x].boardX + 1][Characters[x].boardY + 1].type == 2){
                                                Characters[x].rotate = 135;
                                        }
                                        else if(board[Characters[x].boardX - 1][Characters[x].boardY - 1].type == 0){
                                                Characters[x].rotate = 315;
                                        }
                                        else if(board[Characters[x].boardX - 1][Characters[x].boardY + 1].type == 3){
                                                Characters[x].rotate = 225;
                                        }
                                        //top
                                        else if(board[Characters[x].boardX][Characters[x].boardY - 1].index == 0){
                                                Characters[x].rotate = 0;
                                        }
                                        //left
                                        else if(board[Characters[x].boardX + 1][Characters[x].boardY].index == 0){
                                                Characters[x].rotate = 90;
                                        }
                                        //bottom
                                        else if(board[Characters[x].boardX][Characters[x].boardY + 1].index == 0){
                                                Characters[x].rotate = 180;
                                        }
                                        //right
                                        else if(board[Characters[x].boardX - 1][Characters[x].boardY].index == 0){
                                                Characters[x].rotate = 270;
                                        }
                                }
                                board[Characters[x].boardX][Characters[x].boardY].index = 2;
                        }
                }
        }
}

function drawFloor(){
        ctxFloor.clearRect(0, 0, canvasFloor.width, canvasFloor.height);
        ctxFloor.beginPath();
        
        ctxFloor.drawImage(grassPlay, 0, 0, 1000, 600, 0, 0, 1000, 600);
        
        //Drawing floor with alternating pattern
        for(var i = roomXmin; i < roomXmax; i++){
                for(var j = roomYmin; j < roomYmax; j++){
                        if(i%2 == 0 && j%2 == 0 && (board[i][j].index == 0 || board[i][j].index == 3 || board[i][j].index == 2 || board[i][j].index == -1)){
                                ctxFloor.drawImage(insideLight, 0, 0, 25, 25, squareWidth*i, squareHeight*j, squareWidth, squareHeight);
                        }
                        else if(i%2 == 0 && j%2 == 1 && (board[i][j].index == 0 || board[i][j].index == 3 || board[i][j].index == 2 || board[i][j].index == -1)){
                                ctxFloor.drawImage(inside, 0, 0, 25, 25, squareWidth*i, squareHeight*j, squareWidth, squareHeight);
                        }
                        else if(i%2 == 1 && j%2 == 0 && (board[i][j].index == 0 || board[i][j].index == 3 || board[i][j].index == 2 || board[i][j].index == -1)){
                                ctxFloor.drawImage(inside, 0, 0, 25, 25, squareWidth*i, squareHeight*j, squareWidth, squareHeight);
                        }
                        else if(i%2 == 1 && j%2 == 1 && (board[i][j].index == 0 || board[i][j].index == 3 || board[i][j].index == 2 || board[i][j].index == -1)){
                                ctxFloor.drawImage(insideLight, 0, 0, 25, 25, squareWidth*i, squareHeight*j, squareWidth, squareHeight);
                        }
                        if(board[i][j].index == -1){
                          ctx.beginPath();
                           ctx.fillStyle = "#003EFF";
                          ctx.globalAlpha = 0.35;
                          ctx.arc(squareWidth*i + squareWidth/2, squareHeight*j + squareHeight/2, squareWidth/2, 0, 2*Math.PI);
                          ctx.fill();
                          ctx.globalAlpha = 1.0;
                      }
                        
                }
        }
        //Draw log points
        for(var x = roomXmin-1; x < roomXmax+1; x++){
                for(var y = roomYmin-1; y < roomYmax+1; y++){
                        
                        ctxFloor.translate((squareWidth*x)+(squareWidth/2), (squareHeight*y)+(squareHeight/2));
                        //Log Points
                        if(board[x][y].index == 5){
                                ctxFloor.rotate(board[x][y].rotate*Math.PI/180);
                                ctxFloor.drawImage(board[x][y].image, 0, 0, 25, 25, -squareWidth/2, -squareHeight/2, squareWidth, squareHeight);
                                ctxFloor.rotate(-board[x][y].rotate*Math.PI/180);	
                        }
                        ctxFloor.translate(-((squareWidth*x)+(squareWidth/2)), -((squareHeight*y)+(squareHeight/2)));
                }
        }
        
}

function drawWalls() {
        ctxWalls.clearRect(0, 0, canvasWalls.width, canvasWalls.height);
        ctxWalls.beginPath();
        
        if(damagePulse >= 0.03 && damagePulseSwitch){
                damagePulse -= 0.01;
        }
        else if(damagePulse <= 0.5 && !damagePulseSwitch){
                damagePulse += 0.01;
        }
        else{
                damagePulseSwitch = !damagePulseSwitch;
        }
        
        for(var x = roomXmin; x < roomXmax; x++){
                for(var y = roomYmin; y < roomYmax; y++){
                        if(board[x][y].index == 0){
                                board[x][y].image = updateWalls(board[x][y].type, board[x][y].health, x, y);
                        
                                ctxWalls.translate((squareWidth*x)+(squareWidth/2), (squareHeight*y)+(squareHeight/2));
                                //Walls
                                if(board[x][y].index == 0 && board[x][y].health >= 0){
                                        ctxWalls.rotate(board[x][y].rotate*Math.PI/180);
                                        ctxWalls.drawImage(board[x][y].image, 0, 0, 25, 25, -squareWidth/2, -squareHeight/2, squareWidth, squareHeight);
                                        if(board[x][y].amountHealing != 0){
                                                if(board[x][y].pulseHealth >= 0.03 && board[x][y].pulseSwitch){
                                                        board[x][y].pulseHealth -= 0.005*(board[x][y].amountHealing*2);
                                                }
                                                else if(board[x][y].pulseHealth <= 0.5 && !board[x][y].pulseSwitch){
                                                        board[x][y].pulseHealth += 0.005*(board[x][y].amountHealing*2);
                                                }
                                                else{
                                                        board[x][y].pulseSwitch = !board[x][y].pulseSwitch;
                                                }
                                        }
                                        else{
                                                board[x][y].pulseHealth = 0;
                                        }
                                        
                                        ctxWalls.globalAlpha = board[x][y].pulseHealth;
                                        ctxWalls.fillStyle = "#00FF00";
                                        ctxWalls.fillRect(-12.5, -3, 25, 7);
                                        if(board[x][y].health < ramDamage && board[x][y].health > 0){
                                                ctxWalls.fillStyle = "#FF0000";
                                                ctxWalls.globalAlpha = damagePulse;
                                                ctxWalls.fillRect(-12.5, -10, 25, 7);
                                        }
                                        ctxWalls.globalAlpha = 1;
                                        ctxWalls.rotate(-board[x][y].rotate*Math.PI/180);	
                                }
                                if(board[x][y].health <= 0){
                                        //End of Game
                                        updateHighScore(Math.floor(score));
                                        if(score > highScore)
                                        {
                                            highScore = Math.floor(score);
                                            FB.api("/me/scores?score=" + score, "post", function(response){
                                              FB.api("/" + appID +"/scores", "get", function(response){updateLeaderBoard(response.data);});
                                            });
                                            window.setTimeout(postFeed,1000);
                                        }
                                        
                                        initializedHS = false;
                                        score = 0;
                                        
                                        gradientX = x*squareWidth + squareWidth/2;
					gradientY = y*squareHeight + squareHeight/2;
                                        gradientScale = 10;
                                        endUndim = true;
                                        endGraphic = false;
                                        
                                        drawEndGame();
                                        
                                        stopEnd = setInterval(drawEndGame, 30);
                                        
                                        playing = false;
                                }
                                ctxWalls.translate(-((squareWidth*x)+(squareWidth/2)), -((squareHeight*y)+(squareHeight/2)));
                        }
                }
        }
}

function displayEndGraphic(){
        endGraphic = true;
}

function postFeed(){
	postToFeed(highScore);
}

function drawEndGame(){
        ctxEnd.clearRect(0, 0, canvas.width, canvas.height);
        ctxEnd.beginPath();
        
        if(gradientScale > 1){
                ctxEnd.translate(gradientX, gradientY);
                ctxEnd.drawImage(endGameGradient, 0, 0, 1200, 1400, -600*gradientScale, -700*gradientScale, 1200*gradientScale, 1400*gradientScale);
                ctxEnd.translate(-gradientX, -gradientY);
                gradientScale -= 0.5;
        }
        else{
                ctxEnd.translate(gradientX, gradientY);
                ctxEnd.drawImage(endGameGradient, 0, 0, 1200, 1400, -600*gradientScale, -700*gradientScale, 1200*gradientScale, 1400*gradientScale);
                ctxEnd.translate(-gradientX, -gradientY);
        }
        
        if(gradientScale == 2){
                clearEndDisplay = setInterval(displayEndGraphic, 2500);
        }
        
        ctxEnd.clearRect(700, 0, 300, 600);
        
        if(endGraphic){
                clearInterval(clearEndDisplay);
                var temp = Math.abs(Math.cos(pulsePlayAgain*Math.PI/180))*5;
                ctxEnd.drawImage(endGameImage, 0, 0, 1000, 700, 0, 0, 1000, 600);
                if(pulseOverPlayAgain){
                        if(pulsePlayAgain >= 360){
                                pulsePlayAgain = 0;
                        }
                        else{
                                pulsePlayAgain = pulsePlayAgain + 6;
                        }
                        ctxEnd.drawImage(endPlayAgainMO, 0, 0, 788, 210, 275-temp, 400-temp, 450+(temp*2), 120+(temp*2));
                }
                else{
                        pulsePlayAgain = 90;
                        ctxEnd.drawImage(endPlayAgain, 0, 0, 788, 210, 275, 400, 450, 120);
                }
        }
}

function drawGUI(){
        ctxGUI.clearRect(0, 0, canvas.width, canvas.height);
        ctxGUI.beginPath();
        
        if(!playing && !introActive && !endUndim)
        {
          ctxGUI.fillStyle = "#000000";
          ctxGUI.globalAlpha = .5;
          ctxGUI.fillRect(0,0, canvas.width-GUIWidth, 600);
          ctxGUI.globalAlpha = 1;
        }
        
        ctxGUI.fillStyle = "#E19C00";
        ctxGUI.font = "20px Calibri";
        
        
        ctxGUI.drawImage(GUIBackground, 0, 0, 300, 600, canvas.width-GUIWidth, 0, GUIWidth, 600);
        ctxGUI.drawImage(GUIScore, 0, 0, 200, 100, canvas.width-GUIWidth+100, 25, 100, 50);
        
        scoreTemp = Math.floor(score);
        if(scoreTemp != 0){
                for (var i = 0; scoreTemp > 0; i++) {
                        digits[i] = scoreTemp % 10;
                        scoreTemp = Math.floor(scoreTemp / 10);
                }
                digitOffset = 0;
                for (var i = digits.length; i > 0; i--) {
                        ctxGUI.drawImage(GUINumbers, 47.5 * digits[i-1] + 6, 6, 47.5-6, 50-6, 850-((digits.length*40)/2)+(40*digitOffset), 75, 40, 40);
                        digitOffset++;
                }
        }
        else{
                ctxGUI.drawImage(GUINumbers, 6, 6, 47.5-6, 50-6, 825, 75, 40, 40);
        }
        
        ctxGUI.drawImage(divider, 0, 0, 196, 5, 730, 120, 240, 5);
        ctxGUI.drawImage(GUIHighScore, 0, 0, 400, 100, 800, 130, 100, 25);
        
        highScoreTemp = highScore;
        if(initializedHS){
                digitOffset = 0;
                for (var i = highDigits.length; i > 0; i--) {
                        ctxGUI.drawImage(GUINumbers, 47.5 * highDigits[i-1] + 6, 6, 47.5-6, 50-6, 850-((highDigits.length*20)/2)+(20*digitOffset), 160, 20, 20);
                        digitOffset++;
                }
        }
        else{
                for (var i = 0; highScoreTemp > 0; i++) {
                        highDigits[i] = highScoreTemp % 10;
                        highScoreTemp = Math.floor(highScoreTemp / 10);
                }
                digitOffset = 0;
                for (var i = highDigits.length; i > 0; i--) {
                        ctxGUI.drawImage(GUINumbers, 47.5 * highDigits[i-1] + 6, 6, 47.5-6, 50-6, 850-((highDigits.length*20)/2)+(20*digitOffset), 160, 20, 20);
                        digitOffset++;
                }
                initializedHS = true;
        }
        
        ctxGUI.drawImage(divider, 0, 0, 196, 5, 730, 185, 240, 5);
        
        var temp = Math.abs(Math.cos(pulseStar*Math.PI/180))*2;
        if(pulseStar >= 360){
                pulseStar = 0;
        }
        else{
                pulseStar = pulseStar + 4;
        }
        
        var test = Math.floor(starFrame/5);
        if(starFrame == 63){
                starFrame = 0;
        }
        else{
                starFrame += 1;
        }
        
        if(connectedFacebook && numfriends.toString() > 2)
        {
          var friend0 = new Image();
          friend0.src = friendPics[0];
          ctxGUI.drawImage(friend0, 740, 210, 50, 50);
          ctxGUI.drawImage(profileFrame, 0, 0, 27, 27, 740, 210, 50, 50);
          if(friendGamesPlayed[0].toString() > 0)
          {
          	ctxGUI.drawImage(starSprite, 25*test, 0, 25, 25, 730 - temp, 204 - temp, 20 + (temp*2), 20 + (temp*2));
          }
          else
          {
          	ctxGUI.drawImage(starEmpty, 0, 0, 25, 25, 730, 204, 20, 20);
          }
          ctxGUI.fillText(friendNames[0], 800, 242);
          
          var friend1= new Image();
            friend1.src = friendPics[1];
          ctxGUI.drawImage(friend1, 740, 290, 50, 50);
          ctxGUI.drawImage(profileFrame, 0, 0, 27, 27, 740, 290, 50, 50);
           if(friendGamesPlayed[1].toString() > 0)
          {
          	ctxGUI.drawImage(starSprite, 25*test, 0, 25, 25, 730 - temp, 290 - temp, 20 + (temp*2), 20 + (temp*2));
          }
          else
          {
          	ctxGUI.drawImage(starEmpty, 0, 0, 25, 25, 730, 284, 20, 20);
          }
          
          ctxGUI.fillText(friendNames[1], 800, 322);
          
          var friend2 = new Image();
          friend2.src = friendPics[2];
          ctxGUI.drawImage(friend2, 740, 370, 50, 50);
          ctxGUI.drawImage(profileFrame, 0, 0, 27, 27, 740, 370, 50, 50);
           if(friendGamesPlayed[2].toString() > 0)
          {
          	ctxGUI.drawImage(starSprite, 25*test, 0, 25, 25, 730 - temp, 364 - temp, 20 + (temp*2), 20 + (temp*2));
          }
          else
          {
          	ctxGUI.drawImage(starEmpty, 0, 0, 25, 25, 730, 364, 20, 20);
          }
          
          ctxGUI.fillText(friendNames[2], 800, 402);
          
           var friend3 = new Image();
          friend3.src = friendPics[3];
          ctxGUI.drawImage(friend3, 740, 450, 50, 50);
          ctxGUI.drawImage(profileFrame, 0, 0, 27, 27, 740, 450, 50, 50);
           if(friendGamesPlayed[3].toString() > 0)
          {
          	ctxGUI.drawImage(starSprite, 25*test, 0, 25, 25, 730 - temp, 444 - temp, 20 + (temp*2), 20 + (temp*2));
          }
          else
          {
          	ctxGUI.drawImage(starEmpty, 0, 0, 25, 25, 730, 444, 20, 20);
          }
          ctxGUI.drawImage(starEmpty, 0, 0, 25, 25, 730, 444, 20, 20);
          ctxGUI.fillText(friendNames[3], 800, 482);
          }
          else
          {
            ctxGUI.fillText("Overwhelmed? Login with", 740, 290 );
            ctxGUI.fillText("   Facebook so your", 740, 320 );
            ctxGUI.fillText("friends can help you out!", 740, 350 );

          }
        
        if(introActive)
        {
          ctxGUI.drawImage(skipState[skipMouse], 0, 0, 92, 35, 750, 520, 92, 35);
        }
        else if(play){
                ctxGUI.drawImage(gameState[playState], 0, 0, 92, 35, 750, 520, 92, 35);
        }
        ctxGUI.drawImage(musicState[soundState], 0, 0, 92, 35, 860, 520, 92, 35);
        
        if(play && !introActive && score < 5){
          ctxGUI.fillStyle = "#000000";
          ctxGUI.globalAlpha = .5;
          ctxGUI.fillRect(0,15, canvas.width-GUIWidth, 50);
          ctxGUI.globalAlpha = 1;
          ctxGUI.drawImage(directions, 2, 15);
        }
}

function drawDamage(){
        ctx.fillStyle="#FFFFFF";
        for(var i = 0; i < damagedList.length; i++){
                ctx.globalAlpha = damagedList[i].alpha;
                ctx.fillText("-" + damagedList[i].damage.toString(), damagedList[i].posX, damagedList[i].posY);
                damagedList[i].alpha -= (1/damagedList[i].linger)*(3/5);
                damagedList[i].posX += 0.3;
                damagedList[i].posY -= 0.3;
                damagedList[i].time += 1;
                
                ctx.globalAlpha = 1;
        }
        for(var i = 0; i < damagedList.length; i++){
                if(damagedList[i].time >= damagedList[i].linger){
                        damagedList.splice(i, 1);
                        if(i < 0){
                                i--;
                        }
                        else{
                                i = 0;
                        }
                }
        }
}

function drawSmoke(){
        for(var i = 0; i < smokeList.length; i++){
                var progress = Math.floor(smokeList[i].time/10);
                ctx.translate(smokeList[i].posX, smokeList[i].posY);
                ctx.globalAlpha = smokeList[i].alpha;
                ctx.drawImage(smoke, 300, 0, 50, 50, -squareWidth, -squareHeight, squareWidth, squareHeight);
                ctx.translate(-smokeList[i].posX, -smokeList[i].posY);
                smokeList[i].alpha -= (1/smokeList[i].linger);
                smokeList[i].time += 1;
                ctx.globalAlpha = 1;
        }
        for(var i = 0; i < smokeList.length; i++){
                if(smokeList[i].time >= smokeList[i].linger){
                        smokeList.splice(i, 1);
                        if(i < 0){
                                i--;
                        }
                        else{
                                i = 0;
                        }
                }
        }
}

function birdAttack(x){
        var x1 = randomInterval(roomXmin+1, roomXmax-1);
        var y1 = randomInterval(roomYmin+1, roomYmax-1);
        //attack from the left
        if(Enemies[x].stage == 6){
                for(var i = roomXmin; i < roomXmax; i++){
                        if(board[i][y1].type == 4 && !(board[i][y1-1].type == 9 || board[i][y1+1].type == 10)  && !board[i][y1].beingAttacked){
                                Enemies[x].startPosX = Enemies[x].desiredPosX;
                                Enemies[x].startPosY = Enemies[x].desiredPosY;
                                Enemies[x].desiredPosX = i*squareWidth;
                                Enemies[x].desiredPosY = y1*squareHeight;
                                Enemies[x].translateX = -squareWidth/2;
                                Enemies[x].translateY = squareHeight/2;
                                board[i][y1].beingAttacked = true;
                                Enemies[x].attackBoardX = i;
                                Enemies[x].attackBoardY = y1;
                                Enemies[x].phase = 2;
                                break;
                        }
                        else{
                                birdAttack(x);
                                break;
                        }
                }
        }
                                        //Attack from top
                                        else if(Enemies[x].stage == 4){
                                                for(var i = roomYmin; i < roomYmax; i++){
                                                        if(board[x1][i].index == 0){
                                                                if(board[x1][i].type == 6 && !(board[x1-1][i].type == 11 || board[x1+1][i].type == 10) && !board[x1][i].beingAttacked){
                                                                        //Enemies.push(new enemy(birdImage, 2, x1*squareWidth, 0, x1*squareWidth, 0, x1*squareWidth, (i-1)*squareHeight, 0, 1, 0, 1, 0, squareWidth/2, squareHeight/2));
                                                                        Enemies[x].startPosX = Enemies[x].desiredPosX;
                                                                        Enemies[x].startPosY = Enemies[x].desiredPosY;
                                                                        Enemies[x].desiredPosX = x1*squareWidth;
                                                                        Enemies[x].desiredPosY = (i-1)*squareHeight;
                                                                        Enemies[x].translateX = (squareWidth/2);
                                                                        Enemies[x].translateY = squareHeight/2;
                                                                        Enemies[x].posX -= (squareWidth/2);
                                                                        Enemies[x].posY -= squareHeight/2;
                                                                        board[x1][i].beingAttacked = true;
                                                                        Enemies[x].attackBoardX = x1;
                                                                        Enemies[x].attackBoardY = i;
                                                                        Enemies[x].phase = 2;
                                                                        break;
                                                                }
                                                                else{
                                                                        birdAttack(x);
                                                                        break;
                                                                }
                                                        }
                                                }
                                        }
                                        //Attack from right
                                        else if(Enemies[x].stage == 10){
                                                for(var i = roomXmax; i > roomXmin; i--){
                                                        if(board[i][y1].index == 0){
                                                                if(board[i][y1].type == 5 && !(board[i][y1-1].type == 8 || board[i][y1+1].type == 11) && !board[i][y1].beingAttacked){
                                                                        Enemies[x].startPosX = Enemies[x].desiredPosX;
                                                                        Enemies[x].startPosY = Enemies[x].desiredPosY;
                                                                        Enemies[x].desiredPosX = i*squareWidth;
                                                                        Enemies[x].desiredPosY = y1*squareHeight;
                                                                        Enemies[x].translateX = squareWidth+(squareWidth/2);
                                                                        Enemies[x].translateY = squareHeight/2;
                                                                        Enemies[x].posX -= squareWidth+(squareWidth/2);
                                                                        Enemies[x].posY -= squareHeight/2;
                                                                        board[i][y1].beingAttacked = true;
                                                                        Enemies[x].attackBoardX = i;
                                                                        Enemies[x].attackBoardY = y1;
                                                                        Enemies[x].phase = 2;
                                                                        break;
                                                                }
                                                                else{
                                                                        birdAttack(x);
                                                                        break;
                                                                }
                                                        }
                                                }
                                        }
                                        //Attack from bottom
                                        else if(Enemies[x].stage == 8){
                                                for(var i = roomYmax; i > roomYmin; i--){
                                                        if(board[x1][i].index == 0){
                                                                if(board[x1][i].type == 7 && !(board[x1-1][i].type == 8 || board[x1+1][i].type == 9) && !board[x1][i].beingAttacked){
                                                                        Enemies[x].startPosX = Enemies[x].desiredPosX;
                                                                        Enemies[x].startPosY = Enemies[x].desiredPosY;
                                                                        Enemies[x].desiredPosX = x1*squareWidth;
                                                                        Enemies[x].desiredPosY = (i-1)*squareHeight;
                                                                        Enemies[x].translateX = squareWidth/2;
                                                                        Enemies[x].translateY = (squareHeight*2)+(squareHeight/2);
                                                                        Enemies[x].posX -= squareWidth/2;
                                                                        Enemies[x].posY -= (squareHeight*2)+(squareHeight/2);
                                                                        board[x1][i].beingAttacked = true;
                                                                        Enemies[x].attackBoardX = x1;
                                                                        Enemies[x].attackBoardY = i;
                                                                        Enemies[x].phase = 2;
                                                                        break;
                                                                }
                                                                else{
                                                                        birdAttack(x);
                                                                        break;
                                                                }
                                                        }
                                                }
                                        }
                                        else{
                                                newBird = 0;
                                                Btime = randomInterval(birdMin, birdMax);
                                        }
                                if(Enemies[x].phase == 2){
                                        var deltaY, deltaX;
                                        deltaY = Enemies[x].desiredPosY - Enemies[x].posY;
                                        deltaX = Enemies[x].desiredPosX - Enemies[x].posX;
                                        var rotate = (Math.atan2(deltaY, deltaX) * 180/Math.PI)+90;
                                        Enemies[x].rotation = rotate-180;
                                }
}

function draw() {
        ctx.save();
        ctx.setTransform(1, 0, 0, 1, 0, 0);
        
        //CLEAR CANVAS
        ctx.clearRect(0,0,700,600);
        
        ctx.restore();
        
        ctx.beginPath();
        
        var attack = false;
        
        
        if(offset == 60){
                offset = 0;
        }
        if (newBear == bearTime) {
            newBear = 0;
            bearTime = randomInterval(bearMin, bearMax);
            if (bearMin < 50) {
                if (bearMax > 150 && bearflag) {
                    bearMax--;
                }
                bearflag = !bearflag;
                placeBear();
            }
            else if (bearMin <= 100) {
                if (bearflag) {
                    bearMin--;
                    bearMax--;
                }
                bearflag = !bearflag;
                placeBear();
            }
            else if (bearMin <= 150) {
                bearMin--;
                bearMax--;
                placeBear();
            }
            else {
                bearMin = bearMin - 2;
                bearMax = bearMax - 2;
                placeBear();
            }
        }
        if(newFox == Ftime){
            newFox = 0;
            if (foxpack > 0) {
                Ftime = randomInterval(30, 90);
                foxpack--;
            }
            else {
                Ftime = randomInterval(foxMin, foxMax);
                foxpack = 3;
            }
                placeFox();
        }
        if(newRam == ramTime){
                newRam = 0;
                ramTime = randomInterval(ramMin, ramMax);
                placeRam();
        }
        if(newBird == Btime){
                attack = true;
        }
        if(newBird2 == Btime2){
                newBird2 = 0;
                Btime2 = randomInterval(1800, 3600);
                placeBird();
        }
        
        ctx.save();
        ctx.translate(((xMax+xMin)/2)*25, ((yMax+yMin)/2)*25);
        ctx.rotate(90*Math.PI/180);
        ctx.drawImage(table, 0, 0, 100, 50, -squareWidth, -37.5, 75, 50);
        ctx.restore();
        
        for(var x = 0; x < Enemies.length; x++){
                ctx.save();
                ctx.translate(Math.floor(Enemies[x].posX+Enemies[x].translateX), Math.floor(Enemies[x].posY+Enemies[x].translateY));
                ctx.rotate(Enemies[x].rotation*(Math.PI/180));
                if(Enemies[x].posX != Enemies[x].desiredPosX || Enemies[x].posY != Enemies[x].desiredPosY){
                        if(Enemies[x].type == 0){
                                if(Enemies[x].stage == 0){
                                        var test = Math.floor(Enemies[x].frame/7);
                                        ctx.drawImage(Enemies[x].image, 75*test, 0, 75, 75, -(squareWidth+8), -(squareHeight+8), (squareWidth*2)+16, (squareHeight*2)+16);
                                        if(Enemies[x].frame == 55){
                                                Enemies[x].frame = 0;
                                        }
                                        else{
                                                Enemies[x].frame += 1;
                                        }
                                }
                                else if(Enemies[x].stage == 2){
                                        var test = Math.floor(Enemies[x].frame/5);
                                        ctx.drawImage(Enemies[x].image, 75*test, 0, 75, 75, -(squareWidth+8), -(squareHeight+8), (squareWidth*2)+16, (squareHeight*2)+16);
                                        if(Enemies[x].frame == 39){
                                                Enemies[x].frame = 0;
                                        }
                                        else{
                                                Enemies[x].frame += 1;
                                        }
                                }
                        }
                        else if(Enemies[x].type == 1){
                                if(Enemies[x].stage == 0){
                                        var test = Math.floor(Enemies[x].frame/7);
                                        ctx.drawImage(Enemies[x].image, 25*test, 0, 25, 42, -squareWidth/2, -squareHeight, squareWidth, squareHeight*2);
                                        if(Enemies[x].frame == 55){
                                                Enemies[x].frame = 0;
                                        }
                                        else{
                                                Enemies[x].frame += 1;
                                        }
                                }
                                else if(Enemies[x].stage == 2){
                                        var test = Math.floor(Enemies[x].frame/5);
                                        ctx.drawImage(Enemies[x].image, 25*test, 0, 25, 42, -squareWidth/2, -squareHeight, squareWidth, squareHeight*2);
                                        if(Enemies[x].frame == 39){
                                                Enemies[x].frame = 0;
                                        }
                                        else{
                                                Enemies[x].frame += 1;
                                        }
                                }
                        }
                        else if(Enemies[x].type == 2){
                                if(attack){
                                        attack = false;
                                        birdAttack(x);
                                }
                                if(Enemies[x].stage >= 4 && Enemies[x].stage <= 11){
                                        var test = Math.floor(Enemies[x].frame/6);
                                        ctx.drawImage(Enemies[x].image, 35.75*test, 0, 35.75, 25, -squareWidth/2, -squareHeight/2, squareWidth, squareHeight);
                                        if(Enemies[x].frame == 23){
                                                Enemies[x].frame = 0;
                                        }
                                        else{
                                                Enemies[x].frame += 1;
                                        }
                                }
                        }
                        else if(Enemies[x].type == 3){
                                if(Enemies[x].stage == 0){
                                        ctx.drawImage(Enemies[x].image, 0, 0, 30, 36, -squareWidth/2, -squareHeight/2, squareWidth, squareHeight);
                                }
                                if(Enemies[x].stage == 1){
                                        ctx.drawImage(Enemies[x].image, 0, 0, 30, 36, -squareWidth/2, -squareHeight/2, squareWidth, squareHeight);
                                        if(Enemies[x].frame%5 == 0){
                                                
                                                if(Enemies[x].rotation == 270){
                                                        smokeList.push(new smokeObject(Enemies[x].posX-squareWidth/2, Enemies[x].posY+squareHeight, 1, 50, 0));
                                                }
                                                else if(Enemies[x].rotation == 180){
                                                        smokeList.push(new smokeObject(Enemies[x].posX+squareWidth, Enemies[x].posY+squareHeight*(5/2), 1, 50, 0));
                                                }
                                                else if(Enemies[x].rotation == 90){
                                                        smokeList.push(new smokeObject(Enemies[x].posX+squareWidth*(5/2), Enemies[x].posY+squareHeight, 1, 50, 0));
                                                }
                                                //Top
                                                else if(Enemies[x].rotation == 0){
                                                        smokeList.push(new smokeObject(Enemies[x].posX+squareWidth, Enemies[x].posY-squareHeight/2, 1, 50, 0));
                                                }
                                                Enemies[x].frame += 1;
                                        }
                                        else{
                                                Enemies[x].frame += 1;
                                        }
                                }
                                else if(Enemies[x].stage == 3){
                                        var test = Math.floor(Enemies[x].frame/7);
                                        ctx.drawImage(Enemies[x].image, test*30, 36, 30, 36, -squareWidth/2, -squareHeight/2, squareWidth, squareHeight);
                                        if(Enemies[x].frame == 48){
                                                Enemies[x].frame = 0;
                                        }
                                        else{
                                                Enemies[x].frame += 1;
                                        }
                                }
                        }
                }
                else{
                        if(Enemies[x].type == 0){
                                if(Enemies[x].stage == 0){
                                        var test = Math.floor(Enemies[x].frame/7);
                                        ctx.drawImage(Enemies[x].image, 75*test, 0, 75, 75, -(squareWidth+8), -(squareHeight+8), (squareWidth*2)+16, (squareHeight*2)+16);
                                        Enemies[x].stage = 1;
                                        Enemies[x].frame = 0;
                                }
                                else if(Enemies[x].stage == 1){
                                        var test = Math.floor(Enemies[x].frame/8);
                                        if(Enemies[x].frame == 68){
                                                if(Enemies[x].rotation == 270){
                                                        board[Math.floor(Enemies[x].posX/squareWidth)][Math.floor(Enemies[x].posY/squareHeight)].health -= Enemies[x].damage;
                                                        board[Math.floor(Enemies[x].posX/squareWidth)][Math.floor(Enemies[x].posY/squareHeight)-1].health -= Enemies[x].damage/2;
                                                        board[Math.floor(Enemies[x].posX/squareWidth)][Math.floor(Enemies[x].posY/squareHeight)+1].health -= Enemies[x].damage/2;
                                                        damagedList.push(new damagedObject(Enemies[x].posX, Enemies[x].posY, Enemies[x].damage, 1, 50, 0));
                                                        damagedList.push(new damagedObject(Enemies[x].posX, Enemies[x].posY-25, Enemies[x].damage/2, 1, 50, 0));
                                                        damagedList.push(new damagedObject(Enemies[x].posX, Enemies[x].posY+25, Enemies[x].damage/2, 1, 50, 0));
                                                }
                                                else if(Enemies[x].rotation == 180){
                                                        board[Math.floor(Enemies[x].posX/squareWidth)][Math.floor(Enemies[x].posY/squareHeight)+1].health -= Enemies[x].damage;
                                                        board[Math.floor(Enemies[x].posX/squareWidth)-1][Math.floor(Enemies[x].posY/squareHeight)+1].health -= Enemies[x].damage/2;
                                                        board[Math.floor(Enemies[x].posX/squareWidth)+1][Math.floor(Enemies[x].posY/squareHeight)+1].health -= Enemies[x].damage/2;
                                                        damagedList.push(new damagedObject(Enemies[x].posX, Enemies[x].posY+25, Enemies[x].damage, 1, 50, 0));
                                                        damagedList.push(new damagedObject(Enemies[x].posX-25, Enemies[x].posY+25, Enemies[x].damage/2, 1, 50, 0));
                                                        damagedList.push(new damagedObject(Enemies[x].posX+25, Enemies[x].posY+25, Enemies[x].damage/2, 1, 50, 0));
                                                }
                                                else if(Enemies[x].rotation == 90){
                                                        board[Math.floor(Enemies[x].posX/squareWidth)][Math.floor(Enemies[x].posY/squareHeight)].health -= Enemies[x].damage;
                                                        board[Math.floor(Enemies[x].posX/squareWidth)][Math.floor(Enemies[x].posY/squareHeight)-1].health -= Enemies[x].damage/2;
                                                        board[Math.floor(Enemies[x].posX/squareWidth)][Math.floor(Enemies[x].posY/squareHeight)+1].health -= Enemies[x].damage/2;
                                                        damagedList.push(new damagedObject(Enemies[x].posX, Enemies[x].posY, Enemies[x].damage, 1, 50, 0));
                                                        damagedList.push(new damagedObject(Enemies[x].posX, Enemies[x].posY-25, Enemies[x].damage/2, 1, 50, 0));
                                                        damagedList.push(new damagedObject(Enemies[x].posX, Enemies[x].posY+25, Enemies[x].damage/2, 1, 50, 0));
                                                }
                                                else if(Enemies[x].rotation == 0){
                                                        board[Math.floor(Enemies[x].posX/squareWidth)][Math.floor(Enemies[x].posY/squareHeight)+1].health -= Enemies[x].damage;
                                                        board[Math.floor(Enemies[x].posX/squareWidth)-1][Math.floor(Enemies[x].posY/squareHeight)+1].health -= Enemies[x].damage/2;
                                                        board[Math.floor(Enemies[x].posX/squareWidth)+1][Math.floor(Enemies[x].posY/squareHeight)+1].health -= Enemies[x].damage/2;
                                                        damagedList.push(new damagedObject(Enemies[x].posX, Enemies[x].posY+25, Enemies[x].damage, 1, 50, 0));
                                                        damagedList.push(new damagedObject(Enemies[x].posX-25, Enemies[x].posY+25, Enemies[x].damage/2, 1, 50, 0));
                                                        damagedList.push(new damagedObject(Enemies[x].posX+25, Enemies[x].posY+25, Enemies[x].damage/2, 1, 50, 0));
                                                }
                                        }
                                        if(test >= 9 && test <= 12){
                                                ctx.save();
                                                ctx.translate(0, squareHeight/2);
                                                ctx.rotate(180*(Math.PI/180));
                                                ctx.drawImage(splinters, 25*(test-9), 0, 25, 25, -squareWidth/2, -squareHeight/2, squareWidth, squareHeight);
                                                ctx.translate(15, 0);
                                                ctx.drawImage(splinters, 25*(test-9), 0, 25, 25, -squareWidth/2, -squareHeight/2, squareWidth, squareHeight);
                                                ctx.translate(-30, 0);
                                                ctx.drawImage(splinters, 25*(test-9), 0, 25, 25, -squareWidth/2, -squareHeight/2, squareWidth, squareHeight);
                                                ctx.restore();
                                        }
                                        ctx.drawImage(Enemies[x].image, 75*test, 75, 75, 75, -(squareWidth+8), -(squareHeight+8), (squareWidth*2)+16, (squareHeight*2)+16);
                                        if(Enemies[x].frame == 125){
                                                Enemies[x].frame = 0;
                                                Enemies[x].stage = 2;
                                                Enemies[x].speed = 1.5;
                                                Enemies[x].desiredPosX = Enemies[x].startPosX;
                                                Enemies[x].desiredPosY = Enemies[x].startPosY;
                                                Enemies[x].rotation -= 180;
                                        }
                                        else{
                                                Enemies[x].frame += 1;
                                        }
                                }
                                else if(Enemies[x].stage == 2){
                                        Enemies[x].stage = 3;
                                }
                        }
                        else if(Enemies[x].type == 1){
                                var person = false;
                                if(Enemies[x].posX/squareWidth > 1 && Enemies[x].posY/squareHeight > 1 && Enemies[x].posY/squareHeight < roomYmax && Enemies[x].posX/squareWidth < roomXmax){
                                        if(Enemies[x].rotation == 270){
                                                if(board[Math.floor(Enemies[x].posX/squareWidth)+1][Math.floor(Enemies[x].posY/squareHeight)].index == 2 || 
                                                board[Math.floor(Enemies[x].posX/squareWidth)+1][Math.floor(Enemies[x].posY/squareHeight)+1].index == 2 || 
                                                board[Math.floor(Enemies[x].posX/squareWidth)+1][Math.floor(Enemies[x].posY/squareHeight)-1].index == 2){
                                                        person = true;
                                                }
                                        }
                                        else if(Enemies[x].rotation == 0){
                                                if(board[Math.floor(Enemies[x].posX/squareWidth)][Math.floor(Enemies[x].posY/squareHeight)+2].index == 2 || 
                                                board[Math.floor(Enemies[x].posX/squareWidth)+1][Math.floor(Enemies[x].posY/squareHeight)+2].index == 2 || 
                                                board[Math.floor(Enemies[x].posX/squareWidth)-1][Math.floor(Enemies[x].posY/squareHeight)+2].index == 2){
                                                        person = true;
                                                }
                                        }
                                        else if(Enemies[x].rotation == 90){
                                                if(board[Math.floor(Enemies[x].posX/squareWidth)-1][Math.floor(Enemies[x].posY/squareHeight)].index == 2 || 
                                                board[Math.floor(Enemies[x].posX/squareWidth)-1][Math.floor(Enemies[x].posY/squareHeight)+1].index == 2 || 
                                                board[Math.floor(Enemies[x].posX/squareWidth)-1][Math.floor(Enemies[x].posY/squareHeight)-1].index == 2){
                                                        person = true;
                                                }
                                        }
                                        else if(Enemies[x].rotation == 180){
                                                if(board[Math.floor(Enemies[x].posX/squareWidth)][Math.floor(Enemies[x].posY/squareHeight)].index == 2 || 
                                                board[Math.floor(Enemies[x].posX/squareWidth)+1][Math.floor(Enemies[x].posY/squareHeight)].index == 2 || 
                                                board[Math.floor(Enemies[x].posX/squareWidth)-1][Math.floor(Enemies[x].posY/squareHeight)].index == 2){
                                                        person = true;
                                                }
                                        }
                                }
                                if(Enemies[x].stage == 0 && !person){
                                        var test = Math.floor(Enemies[x].frame/7);
                                        ctx.drawImage(Enemies[x].image, 25*test, 0, 25, 42, -squareWidth/2, -squareHeight, squareWidth, squareHeight*2);
                                        Enemies[x].stage = 1;
                                        Enemies[x].frame = 0;
                                }
                                else if(Enemies[x].stage == 1 && !person){
                                        var test = Math.floor(Enemies[x].frame/4);
                                        if(Enemies[x].frame == 8){
                                                if(Enemies[x].rotation == 270){
                                                        board[Math.floor(Enemies[x].posX/squareWidth)][Math.floor(Enemies[x].posY/squareHeight)].health -= Enemies[x].damage;
                                                        damagedList.push(new damagedObject(Enemies[x].posX, Enemies[x].posY, Enemies[x].damage, 1, 50, 0));
                                                }
                                                else if(Enemies[x].rotation == 180){
                                                        board[Math.floor(Enemies[x].posX/squareWidth)][Math.floor(Enemies[x].posY/squareHeight)+1].health -= Enemies[x].damage;
                                                        damagedList.push(new damagedObject(Enemies[x].posX, Enemies[x].posY+25, Enemies[x].damage, 1, 50, 0));
                                                }
                                                else if(Enemies[x].rotation == 90){
                                                        board[Math.floor(Enemies[x].posX/squareWidth)][Math.floor(Enemies[x].posY/squareHeight)].health -= Enemies[x].damage;
                                                        damagedList.push(new damagedObject(Enemies[x].posX, Enemies[x].posY, Enemies[x].damage, 1, 50, 0));
                                                }
                                                else if(Enemies[x].rotation == 0){
                                                        board[Math.floor(Enemies[x].posX/squareWidth)][Math.floor(Enemies[x].posY/squareHeight)+1].health -= Enemies[x].damage;
                                                        damagedList.push(new damagedObject(Enemies[x].posX, Enemies[x].posY+25, Enemies[x].damage, 1, 50, 0));
                                                }
                                        }
                                        if(test >= 2 && test <= 4){
                                                ctx.save();
                                                ctx.translate(squareWidth/2, squareHeight/2);
                                                ctx.rotate(180*(Math.PI/180));
                                                ctx.translate(15, -2);
                                                ctx.drawImage(splinters, 25*(test-2), 0, 25, 25, -squareWidth/2, -squareHeight/2, squareWidth, squareHeight);
                                                ctx.restore();
                                        }
                                        ctx.drawImage(Enemies[x].image, 25*test, 42, 25, 42, -squareWidth/2, -squareHeight, squareWidth, squareHeight*2);
                                        if(Enemies[x].frame == 20){
                                                Enemies[x].frame = 0;
                                        }
                                        else{
                                                Enemies[x].frame += 1;
                                        }
                                }
                                else if(Enemies[x].stage == 2 || person){
                                        if(person){
                                                Enemies[x].frame = 0;
                                                Enemies[x].stage = 2;
                                                Enemies[x].speed = 1.5;
                                                Enemies[x].desiredPosX = Enemies[x].startPosX;
                                                Enemies[x].desiredPosY = Enemies[x].startPosY;
                                                Enemies[x].rotation -= 180;
                                        }
                                        else{
                                                Enemies[x].stage = 3;
                                        }
                                }
                        }
                        else if(Enemies[x].type == 2){
                                var person = false;
                                
                                if(Enemies[x].posX/squareWidth > 1 && Enemies[x].posY/squareHeight > 1 && Enemies[x].posX/squareWidth < roomXmax && Enemies[x].posY/squareHeight < roomYmax){
                                if(Enemies[x].stage == 6){
                                        if(board[Math.floor(Enemies[x].posX/squareWidth)+1][Math.floor(Enemies[x].posY/squareHeight)].index == 2 || 
                                        board[Math.floor(Enemies[x].posX/squareWidth)+1][Math.floor(Enemies[x].posY/squareHeight)+1].index == 2 || 
                                        board[Math.floor(Enemies[x].posX/squareWidth)+1][Math.floor(Enemies[x].posY/squareHeight)-1].index == 2){
                                                person = true;
                                        }
                                }
                                else if(Enemies[x].stage == 4){
                                        if(board[Math.floor(Enemies[x].posX/squareWidth)][Math.floor(Enemies[x].posY/squareHeight)+2].index == 2 || 
                                        board[Math.floor(Enemies[x].posX/squareWidth)+1][Math.floor(Enemies[x].posY/squareHeight)+2].index == 2 || 
                                        board[Math.floor(Enemies[x].posX/squareWidth)-1][Math.floor(Enemies[x].posY/squareHeight)+2].index == 2){
                                                person = true;
                                        }
                                }
                                else if(Enemies[x].stage == 10){
                                        if(board[Math.floor(Enemies[x].posX/squareWidth)-1][Math.floor(Enemies[x].posY/squareHeight)].index == 2 || 
                                        board[Math.floor(Enemies[x].posX/squareWidth)-1][Math.floor(Enemies[x].posY/squareHeight)+1].index == 2 || 
                                        board[Math.floor(Enemies[x].posX/squareWidth)-1][Math.floor(Enemies[x].posY/squareHeight)-1].index == 2){
                                                person = true;
                                        }
                                }
                                else if(Enemies[x].stage == 8){
                                        if(board[Math.floor(Enemies[x].posX/squareWidth)][Math.floor(Enemies[x].posY/squareHeight)].index == 2 || 
                                        board[Math.floor(Enemies[x].posX/squareWidth)+1][Math.floor(Enemies[x].posY/squareHeight)].index == 2 || 
                                        board[Math.floor(Enemies[x].posX/squareWidth)-1][Math.floor(Enemies[x].posY/squareHeight)].index == 2){
                                                person = true;
                                        }
                                }
                                }
    
                                if(!person && (Enemies[x].phase == 0 || Enemies[x].phase == 1)){
                                        var test = Math.floor(Enemies[x].frame/6);
                                        ctx.drawImage(Enemies[x].image, 35.75*test, 0, 35.75, 25, -squareWidth/2, -squareHeight/2, squareWidth, squareHeight);
                                
                                        if(Enemies[x].stage != 11){
                                                Enemies[x].stage = Enemies[x].stage + 1;
                                        }
                                        else{
                                                Enemies[x].stage = 4;
                                        }
                                        if(Enemies[x].phase == 0){
                                                Enemies[x].phase = 1;
                                        }
                                        
                                        Enemies[x].desiredPosX = (birdPath[Enemies[x].stage-4].x)*squareWidth;
                                        Enemies[x].desiredPosY = (birdPath[Enemies[x].stage-4].y)*squareHeight;
                                        Enemies[x].frame = 0;
                                        
                                        var deltaY, deltaX;
                                        deltaY = Enemies[x].desiredPosY - Enemies[x].posY;
                                        deltaX = Enemies[x].desiredPosX - Enemies[x].posX;
                                        var rotate = (Math.atan2(deltaY, deltaX) * 180/Math.PI)+90;
                                        Enemies[x].rotation = rotate-180;
                                }
                                else if((Enemies[x].phase == 2 || Enemies[x].phase == 4 || Enemies[x].phase == 5) && !person){
                                        var test = Math.floor(Enemies[x].frame/6);
                                        
                                        if(Enemies[x].phase == 2){
                                                Enemies[x].phase = 4;
                                                if(Enemies[x].stage == 6){
                                                        Enemies[x].rotation = 270;
                                                }
                                                else if(Enemies[x].stage == 4){
                                                        Enemies[x].rotation = 0;
                                                }
                                                else if(Enemies[x].stage == 10){
                                                        Enemies[x].rotation = 90;
                                                }
                                                else if(Enemies[x].stage == 8){
                                                        Enemies[x].rotation = 180;
                                                }
                                        }
                                        
                                        if(Enemies[x].frame == 18 && Enemies[x].phase == 4){
                                                if(Enemies[x].rotation == 270){
                                                        board[Math.floor(Enemies[x].posX/squareWidth)][Math.floor(Enemies[x].posY/squareHeight)].health -= Enemies[x].damage;
                                                        damagedList.push(new damagedObject(Enemies[x].posX, Enemies[x].posY, Enemies[x].damage, 1, 50, 0));
                                                }
                                                else if(Enemies[x].rotation == 180){
                                                        board[Math.floor(Enemies[x].posX/squareWidth)][Math.floor(Enemies[x].posY/squareHeight)+1].health -= Enemies[x].damage;
                                                        damagedList.push(new damagedObject(Enemies[x].posX, Enemies[x].posY+25, Enemies[x].damage, 1, 50, 0));
                                                }
                                                else if(Enemies[x].rotation == 90){
                                                        board[Math.floor(Enemies[x].posX/squareWidth)][Math.floor(Enemies[x].posY/squareHeight)].health -= Enemies[x].damage;
                                                        damagedList.push(new damagedObject(Enemies[x].posX, Enemies[x].posY, Enemies[x].damage, 1, 50, 0));
                                                }
                                                else if(Enemies[x].rotation == 0){
                                                        board[Math.floor(Enemies[x].posX/squareWidth)][Math.floor(Enemies[x].posY/squareHeight)+1].health -= Enemies[x].damage;
                                                        damagedList.push(new damagedObject(Enemies[x].posX, Enemies[x].posY+25, Enemies[x].damage, 1, 50, 0));
                                                }
                                        }
                                        if(test >= 2 && test <= 3){
                                                ctx.save();
                                                ctx.translate(squareWidth/2, (squareHeight/2));
                                                ctx.rotate(180*(Math.PI/180));
                                                ctx.translate(13, 9);
                                                ctx.drawImage(splinters, 25*(test-2), 0, 25, 25, -squareWidth/2, -squareHeight/2, squareWidth, squareHeight);
                                                ctx.restore();
                                        }
                                        ctx.drawImage(Enemies[x].image, 35.75*test, 25, 35.75, 25, -squareWidth/2, -squareHeight/2, squareWidth, squareHeight);
                                        if(Enemies[x].frame == 24){
                                                Enemies[x].frame = 12;
                                                if(Enemies[x].phase == 4){
                                                        Enemies[x].phase = 5;
                                                }
                                                else{
                                                        Enemies[x].phase = 4;
                                                }
                                        }
                                        else{
                                                Enemies[x].frame += 1;
                                        }
                                }
                                else if(person){
                                        Enemies[x].phase = 1;
                                        Enemies[x].frame = 0;
                                        Enemies[x].speed = 2;
                                        Enemies[x].desiredPosX = Enemies[x].startPosX;
                                        Enemies[x].desiredPosY = Enemies[x].startPosY;
                                        Enemies[x].translateX = -squareWidth/2;
                                        Enemies[x].translateY = squareHeight/2;
                                        if(Enemies[x].stage == 8){
                                                Enemies[x].posX += squareWidth/2;
                                                Enemies[x].posY += (squareHeight*2)+(squareHeight/2);
                                        }
                                        else if(Enemies[x].stage == 10){
                                                Enemies[x].posX += squareWidth+(squareWidth/2);
                                                Enemies[x].posY += squareHeight/2;
                                        }
                                        else if(Enemies[x].stage == 4){
                                                Enemies[x].posX += (squareWidth/2);
                                                Enemies[x].posY += squareHeight/2;
                                        }
                                        var deltaY, deltaX;
                                        deltaY = Enemies[x].desiredPosY - Enemies[x].posY;
                                        deltaX = Enemies[x].desiredPosX - Enemies[x].posX;
                                        var rotate = (Math.atan2(deltaY, deltaX) * 180/Math.PI)+90;
                                        Enemies[x].rotation = rotate-180;	
                                        
                                        newBird = 0;
                                        Btime = randomInterval(birdMin, birdMax);
                                        board[Enemies[x].attackBoardX][Enemies[x].attackBoardY].beingAttacked = false;
                                }
                        }
                        else if(Enemies[x].type == 3){
                                if(Enemies[x].stage == 0){
                                        ctx.drawImage(Enemies[x].image, 0, 0, 30, 36, -squareWidth/2, -squareHeight/2, squareWidth, squareHeight);
                                        if(Enemies[x].frame == 30){
                                                Enemies[x].speed = 3.0;
                                                Enemies[x].desiredPosY = Enemies[x].attackBoardY*squareHeight;
                                                Enemies[x].desiredPosX = Enemies[x].attackBoardX*squareWidth;
                                                Enemies[x].frame = 0;
                                                Enemies[x].stage = 1;
                                        }
                                        else{
                                                Enemies[x].frame += 1;
                                        }
                                }
                                else if(Enemies[x].stage == 1){
                                        ctx.drawImage(Enemies[x].image, 0, 0, 30, 36, -squareWidth/2, -squareHeight/2, squareWidth, squareHeight);
                                        Enemies[x].frame = 0;
                                        Enemies[x].stage = 2;
                                }
                                else if(Enemies[x].stage == 2){
                                        var test = Math.floor(Enemies[x].frame/8);
                                        if(Enemies[x].frame == 0){
                                                if(Enemies[x].rotation == 270){
                                                        board[Math.floor(Enemies[x].posX/squareWidth)][Math.floor(Enemies[x].posY/squareHeight)].health -= Enemies[x].damage;
                                                        damagedList.push(new damagedObject(Enemies[x].posX, Enemies[x].posY, Enemies[x].damage, 1, 50, 0));
                                                }
                                                else if(Enemies[x].rotation == 180){
                                                        board[Math.floor(Enemies[x].posX/squareWidth)][Math.floor(Enemies[x].posY/squareHeight)].health -= Enemies[x].damage;
                                                        damagedList.push(new damagedObject(Enemies[x].posX, Enemies[x].posY+25, Enemies[x].damage, 1, 50, 0));
                                                }
                                                else if(Enemies[x].rotation == 90){
                                                        board[Math.floor(Enemies[x].posX/squareWidth)][Math.floor(Enemies[x].posY/squareHeight)].health -= Enemies[x].damage;
                                                        damagedList.push(new damagedObject(Enemies[x].posX, Enemies[x].posY, Enemies[x].damage, 1, 50, 0));
                                                }
                                                //Top
                                                else if(Enemies[x].rotation == 0){
                                                        board[Math.floor(Enemies[x].posX/squareWidth)][Math.floor(Enemies[x].posY/squareHeight)].health -= Enemies[x].damage;
                                                        damagedList.push(new damagedObject(Enemies[x].posX, Enemies[x].posY+25, Enemies[x].damage, 1, 50, 0));
                                                }
                                        }
                                        if(test >= 0 && test <= 3){
                                                ctx.save();
                                                ctx.rotate(180*(Math.PI/180));
                                                ctx.drawImage(splinters, 25*(test), 0, 25, 25, -squareWidth/2, -squareHeight/2, squareWidth, squareHeight);
                                                ctx.translate(15, 0);
                                                ctx.drawImage(splinters, 25*(test), 0, 25, 25, -squareWidth/2, -squareHeight/2, squareWidth, squareHeight);
                                                ctx.translate(-30, 0);
                                                ctx.drawImage(splinters, 25*(test), 0, 25, 25, -squareWidth/2, -squareHeight/2, squareWidth, squareHeight);
                                                ctx.restore();
                                        }
                                        ctx.drawImage(Enemies[x].image, 0, 0, 30, 36, -squareWidth/2, -squareHeight/2, squareWidth, squareHeight);
                                        if(Enemies[x].frame == 24){
                                                Enemies[x].frame = 0;
                                                Enemies[x].stage = 3;
                                                Enemies[x].speed = 0.6;
                                                Enemies[x].desiredPosX = Enemies[x].startPosX;
                                                Enemies[x].desiredPosY = Enemies[x].startPosY;
                                                Enemies[x].rotation -= 180;
                                        }
                                        else{
                                                Enemies[x].frame += 1;
                                        }
                                }
                                else if(Enemies[x].stage == 3){
                                        Enemies[x].stage = 4;
                                }
                        }
                }
                ctx.restore();
        }
        
        ctx.clearRect(700, 0, 300, 600);
        
        for(var i = 0; i < Enemies.length; i++){
                if(Enemies[i].type == 0 || Enemies[i].type == 1){
                        if(Enemies[i].stage == 3){
                                board[Enemies[i].attackBoardX][Enemies[i].attackBoardY].beingAttacked = false;
                                Enemies.splice(i, 1);
                        }
                }
                else if(Enemies[i].type == 3){
                        if(Enemies[i].stage == 4){
                                board[Enemies[i].attackBoardX][Enemies[i].attackBoardY].beingAttacked = false;
                                Enemies.splice(i, 1);
                        }
                }
        }
        
        //Highlight selected character
        if(characterSelected){
                if(pulseFriend >= 360){
                        pulseFriend = 0;
                }
                else{
                        pulseFriend = pulseFriend + 6;
                }
                ctx.fillStyle = "#003EFF";
                ctx.globalAlpha = 0.35;
                ctx.arc(selectionX, selectionY, squareWidth/2 + (Math.cos(pulseFriend*Math.PI/180)*2), 0, 2*Math.PI);
                if(moveX > 0 && moveX < c.width && moveY > 0 && moveY < c.height){
                    if(board[Math.floor(moveX/squareWidth)][Math.floor(moveY/squareHeight)].index == 3){
                            ctx.arc(Math.floor(moveX/squareWidth)*squareWidth + squareWidth/2, Math.floor(moveY/squareHeight)*squareHeight + squareHeight/2, squareWidth/2, 0, 2*Math.PI);
                    }
                }
                ctx.fill();
                ctx.globalAlpha = 1.0;
        }
        else{
                pulseFriend = 0;
        }
        
        for(var x = roomXmin; x < roomXmax; x++){
                for(var y = roomYmin; y < roomYmax; y++){
                        board[x][y].amountHealing = 0;
                }
        }
        
        //move the characters
        for(i = 0; i < Characters.length; i++){
                var Px = Characters[i].boardX;
                var Py = Characters[i].boardY;

                //if next to a wall
                //right
                if(board[Characters[i].boardX+1][Characters[i].boardY].index == 0 && board[Characters[i].boardX+1][Characters[i].boardY].health < 180){
                        board[Characters[i].boardX+1][Characters[i].boardY].health = board[Characters[i].boardX+1][Characters[i].boardY].health + Characters[i].power/10;
                        board[Characters[i].boardX+1][Characters[i].boardY].amountHealing++;
                        score = score + Characters[i].power/100;
                }
                if(board[Characters[i].boardX+1][Characters[i].boardY+1].index == 0 && board[Characters[i].boardX+1][Characters[i].boardY+1].health < 180){
                        board[Characters[i].boardX+1][Characters[i].boardY+1].health = board[Characters[i].boardX+1][Characters[i].boardY+1].health + Characters[i].power/10;
                        board[Characters[i].boardX+1][Characters[i].boardY+1].amountHealing++;
                        score = score + Characters[i].power/100;
                }
                if(board[Characters[i].boardX+1][Characters[i].boardY-1].index == 0 && board[Characters[i].boardX+1][Characters[i].boardY-1].health < 180){
                        board[Characters[i].boardX+1][Characters[i].boardY-1].health = board[Characters[i].boardX+1][Characters[i].boardY-1].health + Characters[i].power/10;
                        board[Characters[i].boardX+1][Characters[i].boardY-1].amountHealing++;
                        score = score + Characters[i].power/100;
                }
                //left
                if(board[Characters[i].boardX-1][Characters[i].boardY].index == 0 && board[Characters[i].boardX-1][Characters[i].boardY].health < 180){
                        board[Characters[i].boardX-1][Characters[i].boardY].health = board[Characters[i].boardX-1][Characters[i].boardY].health + Characters[i].power/10;
                        board[Characters[i].boardX-1][Characters[i].boardY].amountHealing++;
                        score = score + Characters[i].power/100;
                }
                if(board[Characters[i].boardX-1][Characters[i].boardY+1].index == 0 && board[Characters[i].boardX-1][Characters[i].boardY+1].health < 180){
                        board[Characters[i].boardX-1][Characters[i].boardY+1].health = board[Characters[i].boardX-1][Characters[i].boardY+1].health + Characters[i].power/10;
                        board[Characters[i].boardX-1][Characters[i].boardY+1].amountHealing++;
                        score = score + Characters[i].power/100;
                }
                if(board[Characters[i].boardX-1][Characters[i].boardY-1].index == 0 && board[Characters[i].boardX-1][Characters[i].boardY-1].health < 180){
                        board[Characters[i].boardX-1][Characters[i].boardY-1].health = board[Characters[i].boardX-1][Characters[i].boardY-1].health + Characters[i].power/10;
                        board[Characters[i].boardX-1][Characters[i].boardY-1].amountHealing++;
                        score = score + Characters[i].power/100;
                }
                //bottom
                if(board[Characters[i].boardX][Characters[i].boardY+1].index == 0 && board[Characters[i].boardX][Characters[i].boardY+1].health < 180){
                        board[Characters[i].boardX][Characters[i].boardY+1].health = board[Characters[i].boardX][Characters[i].boardY+1].health + Characters[i].power/10;
                        board[Characters[i].boardX][Characters[i].boardY+1].amountHealing++;
                        score = score + Characters[i].power/100;
                }
                //top
                if(board[Characters[i].boardX][Characters[i].boardY-1].index == 0 && board[Characters[i].boardX][Characters[i].boardY-1].health < 180){
                        board[Characters[i].boardX][Characters[i].boardY-1].health = board[Characters[i].boardX][Characters[i].boardY-1].health + Characters[i].power/10;
                        board[Characters[i].boardX][Characters[i].boardY-1].amountHealing++;
                        score = score + Characters[i].power/100;
                }
                
                ctx.save();
                ctx.translate(Characters[i].PosX, Characters[i].PosY);
                ctx.rotate((Characters[i].rotate)*Math.PI/180);
                if(Characters[i].PosX != Characters[i].desiredPosX || Characters[i].PosY != Characters[i].desiredPosY){
                        var test = Math.floor(offset/8);
                        ctx.drawImage(Characters[i].image, 27.77*(test+1), 0, 27.77, 25, -(squareHeight/2), -(squareWidth/2), squareHeight, squareWidth);
                }
                else{
                        ctx.drawImage(Characters[i].image, 0, 0, 25, 25, -(squareHeight/2), -(squareWidth/2), squareHeight, squareWidth);
                }
                ctx.restore();
        }
        
        offset += 1;
        newBear += 1;
        newRam += 1;
        newFox += 1;
        newBird += 1;
	newBird2 += 1;
        
        if(drawFriend && connectedFacebook){
                var xSnap = Math.floor(moveX/25);
                var ySnap = Math.floor(moveY/25);
                for(var i = 0; i < Characters.length; i++){
                    if(Characters[i].boardX == xSnap && Characters[i].boardY == ySnap){
                        friendImage.src = friendPics[Characters[i].friendNumber];
                    }
                }
                if(board[xSnap][ySnap].type != -2){
                    ctx.drawImage(friendImage, xSnap*25-3, ySnap*25-33, 31, 31);
                }
        }
}

function initializeWalls(type){
        if(type <= 3 && type >= 0){
                return outerCorner;
        }
        else if(type <= 11 && type >= 8){
                return innerCorner;
        }
        else{
                return randomWall(randomInterval(1, 4));
        }
        return randomWall(randomNumber);
}

function updateWalls(type, health, x, y){
        if(type <= 3 && type >= 0){
                switch(true){
                        case (health < 0):
                                return cornerBroken;
                                break;
                        case ((health>=0) && (health<89)):
                                return cornerCritical;
                                break;
                        case ((health>=90) && (health<180)):
                                return cornerDamaged;
                                break;
                        default:
                                return outerCorner;
                                break;
                }
        }
        else if(type <= 11 && type >= 8){
                switch(true){
                        case ((health>=0) && (health<89)):
                                return wallDamaged;
                                break;
                        case ((health>=90) && (health<180)):
                                return wallDamaged;
                                break;
                        default:
                                return innerCorner;
                                break;
                }
        }
        else{
                switch(true){
                                case (health <= 0):
                                        return wallBroken;
                                        break;
                                case ((health >= 0) && (health<89)):
                                        return wallCritical;
                                        break;
                                case ((health>=90) && (health<180)):
                                        return wallDamaged;
                                        break;
                                default:
                                        if(board[x][y].image != wallDamaged){
                                                return board[x][y].image;
                                        }
                                        else{
                                                return randomWall(randomInterval(1, 4));
                                        }
                                        break;
                        }
        }
        return randomWall(randomInterval(1, 4));
}

function findRotation(type){
        switch(type){
                case 0:
                        return 270;
                        break;
                case 1:
                        return 0;
                        break;
                case 2:
                        return 90;
                        break;
                case 3:
                        return 180;
                        break;
                case 8:
                        return 90;
                        break;
                case 9:
                        return 180;
                        break;
                case 10:
                        return 270;
                        break;
                case 11:
                        return 0;
                        break;
                case 4:
                        return 270;
                        break;
                case 5:
                        return 90;
                        break;
                case 6:
                        return 0;
                        break;
                case 7:
                        return 180;
                        break;
                default:
                        //alert("Wall type unknown");
                        break;
        }
        return null;
}

function animate(PosX, PosY, PosXDesired, PosYDesired, rotate, speed){
        if(PosX != PosXDesired || PosY != PosYDesired){
                var deltaY, deltaX;
                deltaY = PosYDesired - PosY;
                deltaX = PosXDesired - PosX;
                rotate = (Math.atan2(deltaY, deltaX) * 180/Math.PI)+90;
                
                var temp1 = (Math.sin((rotate)*Math.PI/180))*speed;
                var temp2 = (Math.cos((rotate)*Math.PI/180))*speed;
                var dist = Math.sqrt(((PosXDesired-PosX)*(PosXDesired-PosX))
                                     + ((PosYDesired-PosY)*(PosYDesired-PosY)));
                
                if(dist < speed) {
                        PosX = PosXDesired;
                        PosY = PosYDesired;	
                }
                else {
                        PosX += temp1;
                        PosY -= temp2;
                }
        }
        return [PosX, PosY, rotate];
}

function playSound()
{
        document.getElementById("MyAudio").play();
}
function pauseSound()
{
        document.getElementById("MyAudio").pause();
}
function playGameSound()
{
        document.getElementById("PlayAudio").play();
}
function pauseGameSound()
{
        document.getElementById("PlayAudio").pause();
}

//find the path from(startX, startY) to (endX, endY)
function findPath(startX, startY, endX, endY){
        startNode = [startX, startY];
        endNode = [endX, endY];

        board[startX][startY].g = 0;
        board[startX][startY].f = 0;

        //push the start node onto the open list
        openList.push([startX, startY]);
        board[startX][startY].opened = true;

        while(openList.count != 0){
        //while(openList.length != 0){
                //pop the position of the node which has the minimum 'f' value
                var node = openList.pop();
                board[node[0]][node[1]].closed = true;

                if(node[0] == endX && node[1] == endY){
                        var path = [[node[0], node[1]]];
                        var par = board[node[0]][node[1]].parent;
                        while (par.length != 0) {
                                var node1 = node;
                                node = board[node[0]][node[1]].parent;
                                board[node1[0]][node1[1]].parent = [];
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
        for(i = 0; i< neighbors.length; i++){
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

                        //distance between the two points 
                        var d = Math.sqrt(((jx-x)*(jx-x))+((jy-y)*(jy-y)));
                        var ng = board[x][y].g + d; //next g value
                
                        if(!board[jx][jy].opened || ng < board[jx][jy].g){
                                board[jx][jy].g = ng;
                                if(board[jx][jy].h < Math.sqrt(((jx-endNode[0])*(jx-endNode[0]))+((jy-endNode[1])*(jy-endNode[1])))){
                                        board[jx][jy].h = Math.sqrt(((jx-endNode[0])*(jx-endNode[0]))+((jy-endNode[1])*(jy-endNode[1])))
                                }
                                //cost of moving from[x,y] to the jump point
                                board[jx][jy].f = board[jx][jy].g + board[jx][jy].h;
                                board[jx][jy].parent = [x, y];
                        
                                if(!board[jx][jy].opened){
                                        openList.push([jx, jy]);
                                        //sort openList in reverse order on f value
                                        //b[0]b[1] - a[0]b[1]
                                        openList.sort(function(a,b) {return board[b[0]][b[1]].f-board[a[0]][a[1]].f});
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
        if(board[x][y].index == 0 || board[x][y].index == 2){
                return null;
        }
        //if your at the end
        else if(x == endNode[0] && y == endNode[1]){
                return[x, y];
        }

        //check for forced neighbors
        //along the diagonal
        if(dx != 0 && dy != 0){
                if(((board[x-dx][y+dy].index != 0 && board[x-dx][y+dy].index != 2) && 
                (board[x-dx][y].index == 0 || board[x-dx][y].index == 2)) ||
                ((board[x+dx][y-dy].index != 0 && board[x+dx][y-dy].index != 2) && 
                (board[x][y-dy].index == 0 || board[x][y-dy].index == 2))){
                        return[x, y];
                }
        }
        //horizonally/vertically
        else{
                //vertical
                if(dx != 0){
                        if(((board[x+dx][y+1].index != 0 && board[x+dx][y+1].index != 2) && 
                        (board[x][y+1].index == 0 || board[x][y+1].index == 2)) ||
                        ((board[x+dx][y-1].index != 0 && board[x+dx][y-1].index != 2) && 
                        (board[x][y-1].index == 0 || board[x][y-1].index == 2))){
                                return[x, y];
                        }
                }
                else{
                        if(((board[x+1][y+dy].index != 0 && board[x+1][y+dy].index != 2) && 
                        (board[x+1][y].index == 0 || board[x+1][y].index == 2)) ||
                        ((board[x-1][y+dy].index != 0 && board[x-1][y+dy].index != 2) && 
                        (board[x-1][y].index == 0 || board[x-1][y].index == 2))){
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
        if((board[x+dx][y].index != 0) || (board[x][y+dy].index != 0)){
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
                        if(board[x][y+dy].index != 0 && board[x][y+dy].index != 2){
                                neighbors.push({xpos: x, ypos: y+dy});
                        }	
                        //horizontal
                        if(board[x+dx][y].index != 0 && board[x+dy][y].index != 2){
                                neighbors.push({xpos:x+dx, ypos: y});
                        }
                        //diagonal
                        if(board[x+dx][y+dy].index != 0 && board[x+dx][y+dy].index != 2){
                                neighbors.push({xpos:x+dx, ypos: y+dy});
                        }
                        //forced neightbor
                        if((board[x-dx][y].index == 0 || board[x-dx][y].index == 2) && 
                        (board[x][y+dy].index != 0 && board[x][y+dy].index != 2)){
                                neighbors.push({xpos:x-dx, ypos: y+dy});
                        }
                        //forced neightbor
                        if((board[x][y-dy].index == 0 || board[x][y-dy].index == 2) && 
                        (board[x+dx][y].index != 0 && board[x+dx][y].index != 2)){
                                neighbors.push({xpos: x+dx, ypos: y-dy});
                        }
                }
                //search horizontally/ vertically
                else{
                        //vertical
                        if(dx == 0){
                                if(board[x][y+dy].index != 0 && board[x][y+dy].index != 2){
                                        if(board[x][y+dy].index != 0 && board[x][y+dy].index != 2){
                                                neighbors.push({xpos: x, ypos: y+dy});
                                        }
                                        if(board[x+1][y].index == 0 || board[x+1][y].index == 2){
                                                neighbors.push({xpos: x+1, ypos: y+dy});
                                        }
                                        if(board[x-1][y].index == 0 || board[x-1][y].index == 2){
                                                neighbors.push({xpos: x-1, ypos: y+dy});
                                        }
                                }
                        }
                        else{
                                if(board[x+dx][y].index != 0 && board[x+dx][y].index != 2){
                                        if(board[x+dx][y].index != 0 && board[x+dx][y].index != 2){
                                                neighbors.push({xpos: x+dx, ypos: y});
                                        }
                                        if(board[x][y+1].index == 0 || board[x][y+1].index == 2){
                                                neighbors.push({xpos: x+dx, ypos: y+1});
                                        }
                                        if(board[x][y-1].index == 0 || board[x][y-1].index == 2){
                                                neighbors.push({xpos: x+dx, ypos: y-1});
                                        }
                                }
                        }
                }
        }
        else{
                if(board[x][y-1].index != 0 && board[x][y-1].index != 2){
                        neighbors.push({xpos: x, ypos: y-1});
                }	
                if(board[x+1][y].index != 0 && board[x+1][y].index != 2){
                        neighbors.push({xpos: x+1, ypos: y});
                }
                if(board[x][y+1].index != 0 && board[x][y+1].index != 2){
                        neighbors.push({xpos: x, ypos: y+1});
                }
                if(board[x-1][y].index != 0 && board[x-1][y].index != 2){
                        neighbors.push({xpos: x-1, ypos: y});
                }
                if(board[x-1][y-1].index != 0 && board[x-1][y-1].index != 2){
                        neighbors.push({xpos: x-1, ypos: y-1});
                }
                if(board[x+1][y-1].index != 0 && board[x+1][y-1].index != 2){
                        neighbors.push({xpos: x+1, ypos: y-1});
                }
                if(board[x+1][y+1].index != 0 && board[x+1][y+1].index != 2){
                        neighbors.push({xpos: x+1, ypos: y+1});
                }
                if(board[x-1][y+1].index != 0 && board[x-1][y+1].index != 2){
                        neighbors.push({xpos: x-1, ypos: y+1});
                }	
        }
}

function restart()
{

ctxEnd.clearRect(0, 0, canvas.width, canvas.height);

clearInterval(stopEnd);
clearInterval(clearEndDisplay);

digits = new Array();
//how many characters to draw
 numCharacters = 5;
 characterValue = 0;

 activePlayer = -1;
 characterSelected = false;

var board = new Array(boardWidth);

 damagedList = []; //value to draw regarding damaged walls
 Characters = []; //set of characters
 Enemies = [];
 neighbors = []; //neighbors
 openList = [];
 
 //reset difficulty vars
  newBear = 0;
 bearTime = -1;
 newFox = -3000;
 Ftime = -1;
 newRam = -7000;
 ramTime = -1;
 
 ramAttacked = false;
 newBird = 0;
 Btime = -1;
 newBird2 = 0;
 Btime2 = -1;
 secondBird = true;
 foxpack = 1;
 birdcount = 1;
 bearflag = false;
 bearMin = 175;
 bearMax = 300;
 foxMin = 500;
 foxMax = 700;
 ramMin = 400;
 ramMax = 500;
 birdMin = 120;
 birdMax = 240;
 bearDamage = 50; //must be even
 foxDamage = 2;
 woodPeckerDamage = 1;
 ramDamage = 70;
 offset = 0;
 
  gradientX = 0;
 gradientY = 0;
 gradientScale = 10;
 
 endGraphic = false;
 endUndim = false;
 
 bearTime = randomInterval(bearMin, bearMax);
        Ftime = randomInterval(foxMin, foxMax);
        ramTime = randomInterval(ramMin, ramMax);
        Btime = randomInterval(birdMin, birdMax);
        Btime2 = randomInterval(1800, 3600);
        placeBird();
 
 init();
 
refresh();
 playing = true;
}

function playIntro()
{
    
    ctxMenu.clearRect(0, 0, canvasMenu.width, canvasMenu.height);
    if (count > 12) {
        introActive = false;
				playing = true;
    }
    else{
      ctxMenu.drawImage(comicArray[count], 0, 0);
      if(count  < 12)
      {
      intro = setTimeout(playIntro, 1000);
      }
      else
      {
      intro = setTimeout(playIntro, 1500);
      }
      count++;
    } 
}
	
