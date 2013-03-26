<?php Header("Content-Type: application/x-javascript; charset=UTF-8"); ?>

var buttonDown = false;
var play = false;
var stopMenu;

var muted = true;

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

var c; //canvas
var ctx; //canvas context

var canvasFloor;
var ctxFloor;

var canvasWalls;
var ctxWalls;

var canvasMenu;
var ctxMenu;

var menuImage;
var playButtonImage;
var pulseImage = 0;
var pulseOver = false;

var pulseFriend = 0;
var drawFriend = false;

var characterImage;
var friendImage;
var wall1;
var wall2;
var wall3;
var wall4;
var brokenWall;
var grassLight;
var grassDark;
var grass;
var inside;
var insideLight;
var innerCorner;
var outerCorner;
var logPoint1;
var logPoint2;
var offset = 0;

//how many characters to draw
var numCharacters = 5;

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

var Characters = []; //set of pongs
var neighbors = []; //neighbors
var startNode;
var endNode;
var openList = [];

//Inner floor bound variables
var xMin = Math.floor((boardWidth/2)-(boardWidth/8));
var xMax = Math.floor((boardWidth/2)+(boardWidth/8)-1);
var yMin = Math.floor((boardHeight/2)-(boardWidth/8));
var yMax = Math.floor((boardHeight/2)+(boardWidth/8)-1);

//Room mins and maxes for X and Y
var roomXmin, roomXmax, roomYmin, roomYmax;

function object(index, health, type, opened, closed, g, f, h, parent, image, rotate){
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
}

function character(image, rotation, boardX, boardY, PosX, PosY, desiredPosX, desiredPosY, Path, power, mouseX, mouseY, moved){
        this.image = image;
        this.rotation = rotation;
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
        
        if(!play){
                var temp = Math.abs(Math.cos(pulseImage*Math.PI/180))*10;
                ctxMenu.drawImage(menuImage, 0, 0, 1000, 600, 0, 0, 1000, 600);
                if(pulseOver){
                        if(pulseImage >= 360){
                                pulseImage = 0;
                        }
                        else{
                                pulseImage = pulseImage + 4;
                        }
                        ctxMenu.drawImage(playButtonImage, 0, 0, 200, 120, 440 - temp, 400 - temp, 120 + (temp*2), 72 + (temp*2));
                }
                else{
                        pulseImage = 0;
                        ctxMenu.drawImage(playButtonImage, 0, 0, 200, 120, 440, 400, 120, 72);
                }
        }
        else{
                clearInterval(stopMenu);
                playGame();
        }
}

function menu(){
        canvasMenu = document.getElementById("menu");
        ctxMenu = canvasMenu.getContext("2d");
        menuImage = new Image();
        playButtonImage = new Image();
        menuImage.src = "gameHome.png";
        playButtonImage.src = "playGameImage.png";
        
        drawMenu();
        stopMenu = setInterval(drawMenu, 30);
}

function playGame(){
        refresh();
        drawWalls();
        setInterval(drawWalls, 400);
        gameLoop();
}

function init() {
        document.onkeydown = keyDown;
        document.onmousedown = mouseDown;
        document.onmousemove = mouseMove;
        
        c = document.getElementById("canvas");
        ctx = c.getContext("2d");
        
        canvasFloor = document.getElementById("canvasFloor");
        ctxFloor = canvasFloor.getContext("2d");
        
        canvasWalls = document.getElementById("canvasWalls");
        ctxWalls = canvasWalls.getContext("2d");
        
        //Image variables
        characterImage = new Image();
        friendImage = new Image();
        wall1 = new Image();
        wall2 = new Image();
        wall3 = new Image();
        wall4 = new Image();
        brokenWall = new Image();
        grassLight = new Image();
        grassDark = new Image();
        grass = new Image();
        inside = new Image();
        insideLight = new Image();
        innerCorner = new Image();
        outerCorner = new Image();
        logPoint1 = new Image();
        logPoint2 = new Image();
        
        //Loading images
        characterImage.src = "blonde_male.png";
        friendImage.src = friendPics[4];
        wall1.src = "tiles/Log1_Test.png";
        wall2.src = "tiles/Log2_Test.png";
        wall3.src = "tiles/Log3_Test.png";
        wall4.src = "tiles/log4_Test.png";
        brokenWall.src = "tiles/brokenWall_Test.png";
        grassLight.src = "tiles/Grass_Light_Test.png";
        grassDark.src = "tiles/Grass_Dark_Test.png";
        grass.src = "grass_continuous.png";
        inside.src = "tiles/Floor_Dark_Test.png";
        insideLight.src = "tiles/Floor_Light_Test.png";
        innerCorner.src = "tiles/LOG_InteriorCorner_Test.png";
        outerCorner.src = "tiles/Log_ExteriorCorner_Test.png";
        logPoint1.src = "tiles/Log_Point1_Test.png";
        logPoint2.src = "tiles/Log_Point2_Test.png";

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
                                board[x][y] = (new object(3, -1, -1, false, false, 0, 0, 0, [], wall1, 0));
                        }
                        //Else set as outside
                        else{
                                board[x][y] = (new object(1, -1, -1, false, false, 0, 0, 0, [], inside, 0));
                        }
                }
        }
        
        //Create random levels
        for(var i = 0; i < 4; i++){
                var randomX = randomInterval(3, 5);
                var randomY = randomInterval(3, 4);
                if(i == 0){
                        for(var j = 0; j < randomY; j++){
                                for(var k = 0; k < randomX; k++){
                                        board[halfBoardWidth-k-3][halfBoardHeight-j-3].index = 3;
                                }
                        }
                        roomXmin = xMin - randomX + 3;
                        roomYmin = yMin - randomY + 3;
                }
                if(i == 1){
                        for(var j = 0; j < randomY; j++){
                                for(var k = 0; k < randomX; k++){
                                        board[halfBoardWidth+k+2][halfBoardHeight-j-3].index = 3;
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
                                        board[halfBoardWidth-k-3][halfBoardHeight+j+2].index = 3;
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
                                        board[halfBoardWidth+k+2][halfBoardHeight+j+2].index = 3;
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
        
        //place walls
        //Possibly think about cleaning up...
        for(var y = roomYmin; y < roomYmax; y++){
                for(var x = roomXmin; x < roomXmax; x++){
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
                        }
                        //check
                        if(board[x+1][y-1].index == 3 && (board[x-1][y+1].index == 1 || board[x-1][y+1].index == 0) && board[x][y].index == 1){
                                board[x][y].index = 0; //bottom left corner
                                board[x][y].health = 0;
                        }
                        //check
                        if(board[x-1][y+1].index == 3 && (board[x+1][y-1].index == 1 || board[x+1][y-1].index == 0) && board[x][y].index == 1){
                                board[x][y].index = 0; //top right corner
                                board[x][y].health = 0;
                        }
                        //check		
                        if(board[x+1][y+1].index == 3 && (board[x-1][y-1].index == 1 || board[x-1][y-1].index == 0) && board[x][y].index == 1){
                                board[x][y].index = 0; //top left corner
                                board[x][y].health = 0;
                        }
                        if((board[x][y].index == 0 || board[x][y].index == 1) && 
                        (((board[x+1][y].index == 3 || board[x+2][y].index == 3) && board[x-1][y].index == 3) || 
                        ((board[x][y+1].index == 3 || board[x][y+2].index == 3) && board[x][y-1].index == 3))){
                                board[x][y].index = 3;
                        }
                }
        }
        
        //topleft = 0, 8 = outside, topright = 1, 9 = outside, bottomleft = 2, 10 = outside, bottomright = 3, 11 = outside, left = 4, right = 5, up = 6, bottom = 7
        //Possibly think about cleaning up...
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

        //Possibly think about cleaning up...
        for(var y = roomYmin; y < roomYmax; y++){
                for(var x = roomXmin; x < roomXmax; x++){
                        //bottom right
                        if(board[x][y].index == 0 && board[x][y-1].index == 0 && board[x-1][y].index == 0 && board[x-1][y-1].index == 3){
                                if(numCharacters != 0){
                                        board[x-1][y-1].index = 2;
                                        Characters.push(new character(characterImage, 0, x-1, y-1, (squareWidth*(x-1)) + (squareWidth/2), (squareHeight*(y-1)) + (squareHeight/2), 
                                        (squareWidth*(x-1)) + (squareWidth/2), (squareHeight*(y-1)) + (squareHeight/2), [], 1, 0, 0, false));
                                        numCharacters = numCharacters - 1;
                                }
                        }
                        //bottom left
                        if(board[x][y].index == 0 && board[x][y-1].index == 0 && board[x+1][y].index == 0 && board[x+1][y-1].index == 3){
                                if(numCharacters != 0){
                                        board[x+1][y-1].index = 2;
                                        Characters.push(new character(characterImage, 0, x+1, y-1, (squareWidth*(x+1)) + (squareWidth/2), (squareHeight*(y-1)) + (squareHeight/2), 
                                        (squareWidth*(x+1)) + (squareWidth/2), (squareHeight*(y-1)) + (squareHeight/2), [], 1, 0, 0, false));
                                        numCharacters = numCharacters - 1;
                                }
                        }
                        //top right
                        if(board[x][y].index == 0 && board[x-1][y].index == 0 && board[x][y+1].index == 0 && board[x-1][y+1].index == 3){
                                if(numCharacters != 0){
                                        board[x-1][y+1].index = 2;
                                        Characters.push(new character(characterImage, 0, x-1, y+1, (squareWidth*(x-1)) + (squareWidth/2), (squareHeight*(y+1)) + (squareHeight/2), 
                                        (squareWidth*(x-1)) + (squareWidth/2), (squareHeight*(y+1)) + (squareHeight/2), [], 1, 0, 0, false));
                                        numCharacters = numCharacters - 1;
                                }
                        }
                        //top left	
                        if(board[x][y].index == 0 && board[x+1][y].index == 0 && board[x][y+1].index == 0 && board[x+1][y+1].index == 3){
                                if(numCharacters != 0){
                                        board[x+1][y+1].index = 2;
                                        Characters.push(new character(characterImage, 0, x+1, y+1, (squareWidth*(x+1)) + (squareWidth/2), (squareHeight*(y+1)) + (squareHeight/2), 
                                        (squareWidth*(x+1)) + (squareWidth/2), (squareHeight*(y+1)) + (squareHeight/2), [], 1, 0, 0, false));
                                        numCharacters = numCharacters - 1;
                                }
                        }
                }
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
}

function keyDown(e) {
        if(!e) {
                e = window.event;
        }
        //h key for test
        else if(e.keyCode == 72){
                var path = findPath(Characters[0].boardX, Characters[0].boardY, 15, 16);
                alert(path);
        }
        else if(e.keyCode == 107){
                board[13][10].index = 2;
                Characters.push({boardX: 13, boardY: 10, PosX: (squareWidth*13) + (squareWidth/2), PosY: (squareHeight*10) + (squareHeight/2), Rotate: 0, power: 1});
        }
}

function mouseDown(e){
        mouseX = e.clientX + document.body.scrollLeft +
        document.documentElement.scrollLeft - c.offsetLeft;
        mouseY = e.clientY + document.body.scrollTop +
        document.documentElement.scrollTop - c.offsetTop;
        
        //Mouse click on play game
        if(!play && mouseX <= 560 && mouseX >= 440 && mouseY <= 472 && mouseY >= 400){
                play = !play;
        }
        
        //Mouse click on play/pause...or mute/unmute
        if(mouseX <= 100 && mouseX >= 0 && mouseY <= 100 && mouseY >= 0){
                if(muted){
                        playSound();
                        muted = !muted;
                }
                else{
                        pauseSound();
                        muted = !muted;
                }
        }
        
        //Have mouse x and y snapped to grid
        mouseDownX = (Math.floor((mouseX/squareWidth))*squareWidth) + (squareWidth/2);
        mouseDownY = (Math.floor((mouseY/squareHeight))*squareHeight) + (squareHeight/2);

        gameSelection();
}

function mouseMove(e){
        moveX = e.clientX + document.body.scrollLeft +
        document.documentElement.scrollLeft - c.offsetLeft;
        moveY = e.clientY + document.body.scrollTop +
        document.documentElement.scrollTop - c.offsetTop;
        if(moveX > 0 && moveX < c.width && moveY > 0 && moveY < c.height){
            if(!play){
                if(moveX <= 560 && moveX >= 440 && moveY <= 472 && moveY >= 400){
                        pulseOver = true;
                }
                else{
                        pulseOver = false;
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
        }
}

function gameSelection(){
        if(mouseX > 0 && mouseX < c.width && mouseY > 0 && mouseY < c.height){
                //if clicked on player
                for(var i = 0; i < Characters.length; i++){
                        if(mouseX > (Characters[i].PosX - (squareWidth/2)) && mouseX < (Characters[i].PosX + (squareWidth/2)) &&
                        mouseY > (Characters[i].PosY - (squareWidth/2)) && mouseY < (Characters[i].PosY + (squareHeight/2))){
                                activePlayer = i;
                                characterSelected = true;
                                selectionX = mouseDownX;
                                selectionY = mouseDownY;
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
                        var path = findPath(Characters[activePlayer].boardX, Characters[activePlayer].boardY, x1, y1);
                        alert(path);
                        Characters[activePlayer].Path = path;
                        alert(Characters[activePlayer].Path);
                        Characters[activePlayer].desiredPosX = ((squareWidth*Characters[activePlayer].Path[1][0]) + (squareWidth/2));
                        Characters[activePlayer].desiredPosY = ((squareHeight*Characters[activePlayer].Path[1][1]) + (squareHeight/2));
                        Characters[activePlayer].Path = Characters[activePlayer].Path.splice(2, Characters[activePlayer].Path.length-2);
                        board[x1][y1].index = 2;
                        activePlayer = -1;
                        characterSelected = false;
                }
        }
}

function gameLoop() {
        draw();
        moveCharacter();
        requestAnimFrame(gameLoop);
}

function moveCharacter(){
        for(var x = 0; x < Characters.length; x++){
                if(Characters[x].PosX != Characters[x].desiredPosX || Characters[x].PosY != Characters[x].desiredPosY){
                        var set = animate(Characters[x].PosX, Characters[x].PosY, Characters[x].desiredPosX, Characters[x].desiredPosY, Characters[x].rotate);
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
                                }
                        }
                }
        }
}

function drawFloor(){
        ctxFloor.clearRect(0, 0, canvasFloor.width, canvasFloor.height);
        ctxFloor.beginPath();
        
        ctxFloor.drawImage(grass, 0, 0, 1000, 600, 0, 0, 1000, 600);
        
        //Drawing floor with alternating pattern
        for(var i = roomXmin; i < roomXmax; i++){
                for(var j = roomYmin; j < roomYmax; j++){
                        if(i%2 == 0 && j%2 == 0 && (board[i][j].index == 0 || board[i][j].index == 3 || board[i][j].index == 2)){
                                ctxFloor.drawImage(insideLight, 0, 0, 25, 25, squareWidth*i, squareHeight*j, squareWidth, squareHeight);
                        }
                        else if(i%2 == 0 && j%2 == 1 && (board[i][j].index == 0 || board[i][j].index == 3 || board[i][j].index == 2)){
                                ctxFloor.drawImage(inside, 0, 0, 25, 25, squareWidth*i, squareHeight*j, squareWidth, squareHeight);
                        }
                        else if(i%2 == 1 && j%2 == 0 && (board[i][j].index == 0 || board[i][j].index == 3 || board[i][j].index == 2)){
                                ctxFloor.drawImage(inside, 0, 0, 25, 25, squareWidth*i, squareHeight*j, squareWidth, squareHeight);
                        }
                        else if(i%2 == 1 && j%2 == 1 && (board[i][j].index == 0 || board[i][j].index == 3 || board[i][j].index == 2)){
                                ctxFloor.drawImage(insideLight, 0, 0, 25, 25, squareWidth*i, squareHeight*j, squareWidth, squareHeight);
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
        
        for(var x = roomXmin; x < roomXmax; x++){
                for(var y = roomYmin; y < roomYmax; y++){
                        if(board[x][y].index == 0){
                                board[x][y].image = updateWalls(board[x][y].type, board[x][y].health, x, y);
                        
                                ctxWalls.translate((squareWidth*x)+(squareWidth/2), (squareHeight*y)+(squareHeight/2));
                                //Walls
                                if(board[x][y].index == 0){
                                        ctxWalls.rotate(board[x][y].rotate*Math.PI/180);
                                        ctxWalls.drawImage(board[x][y].image, 0, 0, 25, 25, -squareWidth/2, -squareHeight/2, squareWidth, squareHeight);
                                        ctxWalls.rotate(-board[x][y].rotate*Math.PI/180);	
                                }
                                ctxWalls.translate(-((squareWidth*x)+(squareWidth/2)), -((squareHeight*y)+(squareHeight/2)));
                        }
                }
        }
}

function draw() {
        ctx.save();
        ctx.setTransform(1, 0, 0, 1, 0, 0);
        
        //CLEAR CANVAS
        ctx.clearRect(0,0,canvas.width, canvas.height);
        
        ctx.restore();
        
        ctx.beginPath();
        
        if(offset == 60){
                offset = 0;
        }
        
        //Highlight selected character
        if(characterSelected){
                if(pulseFriend >= 360){
                        pulseFriend = 0;
                }
                else{
                        pulseFriend = pulseFriend + 6;
                }
                ctx.fillStyle = "#00FF00";
                ctx.globalAlpha = 0.35;
                ctx.arc(selectionX, selectionY, squareWidth/2 + (Math.cos(pulseFriend*Math.PI/180)*2), 0, 2*Math.PI);
                ctx.fill();
                ctx.globalAlpha = 1.0;
        }
        else{
                pulseFriend = 0;
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
                
                ctx.save();
                ctx.translate(Characters[i].PosX, Characters[i].PosY);
                ctx.rotate((Characters[i].rotate)*Math.PI/180);
                if(Characters[i].PosX != Characters[i].desiredPosX || Characters[i].PosY != Characters[i].desiredPosY){
                        var test = Math.floor(offset/8);
                        ctx.drawImage(Characters[i].image, 142.222*(test+1), 0, 142.22, 128, -(squareHeight/2), -(squareWidth/2), squareHeight, squareWidth);
                }
                else{
                        ctx.drawImage(Characters[i].image, 0, 0, 128, 128, -(squareHeight/2), -(squareWidth/2), squareHeight, squareWidth);
                }
                ctx.translate(Characters[i].PosX, Characters[i].PosY);
                ctx.restore();
        }
        offset += 1;
        
        if(drawFriend && connectedFacebook){
                ctx.drawImage(friendImage, Math.floor(moveX/25)*25-3, Math.floor(moveY/25)*25-33, 31, 31);
        }
        
        rotate = rotate + 3;
        
        //update score
        ctx.save();
        ctx.font="40px Georgia";
        ctx.fillStyle ="#000000";
        score++;
        ctx.fillText("Score: " + Math.round(score / 6), 20, canvas.height-50);
        ctx.restore();
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
                        case ((health>=0) && (health<119)):
                                return outerCorner;
                                break;
                        case ((health>=120) && (health<180)):
                                return brokenWall;
                                break;
                        default:
                                return outerCorner;
                                break;
                }
        }
        else if(type <= 11 && type >= 8){
                switch(true){
                        case ((health>=0) && (health<119)):
                                return innerCorner;
                                break;
                        case ((health>=120) && (health<180)):
                                return brokenWall;
                                break;
                        default:
                                return innerCorner;
                                break;
                }
        }
        else{
                switch(true){
                                case ((health>=0) && (health<119)):
                                        if(board[x][y].image != brokenWall){
                                                return board[x][y].image;
                                        }
                                        else{
                                                return randomWall(randomInterval(1, 4));
                                        }
                                        break;
                                case ((health>=120) && (health<180)):
                                        return brokenWall;
                                        break;
                                default:
                                        if(board[x][y].image != brokenWall){
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
                        alert("Wall type unknown");
                        break;
        }
        return null;
}

function animate(PosX, PosY, PosXDesired, PosYDesired, rotate){
        if(PosX != PosXDesired || PosY != PosYDesired){
                var deltaY, deltaX;
                deltaY = PosYDesired - PosY;
                deltaX = PosXDesired - PosX;
                rotate = (Math.atan2(deltaY, deltaX) * 180/Math.PI)+90;
                
                var temp1 = (Math.sin((rotate)*Math.PI/180))*2;
                var temp2 = (Math.cos((rotate)*Math.PI/180))*2;
                var dist = Math.sqrt(((PosXDesired-PosX)*(PosXDesired-PosX))
                                     + ((PosYDesired-PosY)*(PosYDesired-PosY)));
                
                if(dist < 2.0) {
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

        while(openList.count != 0){
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