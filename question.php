<?php 
	include 'db.php';
	session_start(); 
	//Set Question Number
	$number = $_GET['n'];

	//Query for the Question
	$query = "SELECT * FROM questions WHERE question_number = $number";

	// Get the question
	$result = mysqli_query($connection,$query);
	$question = mysqli_fetch_assoc($result); 

	//Get Choices
	$query = "SELECT * FROM options WHERE question_number = $number";
	$choices = mysqli_query($connection,$query);


	// Get Total questions
	$query = "SELECT * FROM questions";
	$total_questions = mysqli_num_rows(mysqli_query($connection,$query));
 	

 	$query = "SELECT * FROM options WHERE question_number = $number AND is_correct = 1";
    $result = mysqli_query($connection,$query);
    $row = mysqli_fetch_assoc($result);

    $correct_choice = $row['id'];




	
?>
<html>
<head>
	<title>TRIVIA SPACE</title>
    <link rel="stylesheet" type="text/css" href="assets\css\main.css">
    
</head>
<body>



<main>
<div class="contain">
	<div class="congrats">
    <div style="font-size: xx-large; font-weight: bold;">Level <?php echo $number; ?> of <?php echo $total_questions; ?> <label id='level'> Deaths: 0 </label></div>
    
          
          <p style="font-size: xx-large;" class="question"><?php echo $question['question_text']; ?> </p>
          
              <form>
                  <?php $qnum = 0; $classnum = 0?>
                      <?php while($row=mysqli_fetch_assoc($choices)){ $qnum++; $classnum++ ?>
                     
                      <a style="font-weight: bold; font-size: x-large; padding-left: 10px; padding-right: 10px" class="answer<?php echo $classnum?>"><label name="choice" value="<?php echo $row['id']; ?>"> '<?php echo $row['coption'];?>'  </a>
                
                      <?php } ?>
                      
                      
                
                  <input type="hidden" name="number" value="<?php echo $number; ?>">



              </form>
          
<canvas id="Canvas" width="1100" height="675"></canvas>
<ul>
<button class="button button1" onClick='skip(1)'>Level 1</button>
<button class="button button1" onClick='skip(2)'>Level 2</button>
<button class="button button1" onClick='skip(3)'>Level 3</button>
<button class="button button1" onClick='skip(4)'>Level 4</button>
<button class="button button1" onClick='skip(5)'>Level 5</button>
</ul>


	</div>
</div>

<script>
var c = document.getElementById("Canvas");

var ctx = c.getContext("2d");
var size=30

if(document.URL.indexOf("question.php?n=1") >= 0){ 
    var level=1
}
if(document.URL.indexOf("question.php?n=2") >= 0){ 
    var level=2
}
if(document.URL.indexOf("question.php?n=3") >= 0){ 
    var level=3
}
if(document.URL.indexOf("question.php?n=4") >= 0){ 
    var level=4
}
if(document.URL.indexOf("question.php?n=5") >= 0){ 
    var level=5
}

var deaths=0
var numcoins=0
var choice = "<?php echo"$correct_choice"?>"
function move(x) {
	
    if(x.keyCode == 39 || x.keyCode == 68) {
        moveright=1
    }
    else if(x.keyCode == 37 || x.keyCode == 65) {
        moveleft=1
    } else if(x.keyCode == 38 || x.keyCode == 87) {
        moveup=1
    } else if(x.keyCode == 40 || x.keyCode == 83) {
        movedown=1
    }
}

function noMove(x) {
	if(x.keyCode == 39 || x.keyCode == 68) {
        moveright=0
    } else if(x.keyCode == 37 || x.keyCode == 65) {
        moveleft=0
    } else if(x.keyCode == 38 || x.keyCode == 87) {
        moveup=0
    } else if(x.keyCode == 40 || x.keyCode == 83) {
        movedown=0
    }
}

function movePlayer() {
	var oldx=player['x']
    var oldy=player['y']
	if (moveright==1) {player['x']+=speed}
    if (moveleft==1) {player['x']-=speed}
    collide(oldx,oldy)
    var oldx=player['x']
    var oldy=player['y']
    if (moveup==1) {player['y']-=speed}
    if (movedown==1) {player['y']+=speed}
    collide(oldx,oldy)
}

function moveEnemies() {
	var i=0
    while (enemies[level].length>i) {
        enemies[level][i]['x']+=enemies[level][i]['xv']
        if (collideEnemy(enemies[level][i])) {
        	enemies[level][i]['xv']=0-enemies[level][i]['xv']
            //enemies[level][i]['x']+=enemies[level][i]['xv']
        }
        if (enemies[level][i]['minx']>=enemies[level][i]['x']) {enemies[level][i]['xv']=Math.abs(enemies[level][i]['xv'])}
        if (enemies[level][i]['x']>=enemies[level][i]['maxx']) {enemies[level][i]['xv']=0-Math.abs(enemies[level][i]['xv'])}
        enemies[level][i]['y']+=enemies[level][i]['yv']
        if (collideEnemy(enemies[level][i]) || enemies[level][i]['miny']>=enemies[level][i]['y'] || enemies[level][i]['y']>=enemies[level][i]['maxy']) {
        	enemies[level][i]['yv']=0-enemies[level][i]['yv']
            //enemies[level][i]['y']+=enemies[level][i]['yv']
        }
        i++
	}
}

function collide(x,y) {
	var i=0
    var player_rect={x:player['x'],y:player['y'],width:size*0.6,height:size*0.6}
    while (blocks[level].length>i) {
    	var block_rect={x:blocks[level][i]['x']*size,y:blocks[level][i]['y']*size,width:size,height:size}
			if (colliding(player_rect,block_rect) && blocks[level][i]['type']===1) {
            player['x']=x
        	player['y']=y
        }


        if (colliding(player_rect,block_rect) && blocks[level][i]['type']===3 && numcoins>=coinsneeded[level] ) {
            if (choice == 1 || choice == 5 || choice == 9 || choice == 13 || choice == 17){
        	level+=1
            if (level == 6){
                window.location.replace("http://localhost/quiz/final.php");
            }
            else
            window.location.replace("http://localhost/quiz/question.php?n=" + level);
            numcoins=0
            player['x']=spawnpoints[level][0]
        	player['y']=spawnpoints[level][1]
            }else{
                player['x']=spawnpoints[level][0]
        	    player['y']=spawnpoints[level][1]
                j=0
    		while (coins[level].length>j) {
    			coins[level][j]['collected']=0
                j++
			}
                
            }
        
        }

        if (colliding(player_rect,block_rect) && blocks[level][i]['type']===5 && numcoins>=coinsneeded[level]) {
            if ((choice == 2) || (choice == 6) || (choice == 10) || (choice == 14) || (choice == 18)){
        	level+=1
            if (level == 6){
                window.location.replace("http://localhost/quiz/final.php");
            }
            else
            window.location.replace("http://localhost/quiz/question.php?n=" + level);
            numcoins=0
            player['x']=spawnpoints[level][0]
        	player['y']=spawnpoints[level][1]
        }else{
                player['x']=spawnpoints[level][0]
        	    player['y']=spawnpoints[level][1]
                j=0
    		while (coins[level].length>j) {
    			coins[level][j]['collected']=0
                j++
			}
                
            }
        }

        if (colliding(player_rect,block_rect) && blocks[level][i]['type']===6 && numcoins>=coinsneeded[level]) {
            if ((choice == 3) || (choice == 7) || (choice == 11) || (choice == 15) || (choice == 19)){
        	level+=1
            if (level == 6){
                window.location.replace("http://localhost/quiz/final.php");
            }
            else
            window.location.replace("http://localhost/quiz/question.php?n=" + level);
            numcoins=0
            player['x']=spawnpoints[level][0]
        	player['y']=spawnpoints[level][1]
        }else{
                player['x']=spawnpoints[level][0]
        	    player['y']=spawnpoints[level][1]
                j=0
    		while (coins[level].length>j) {
    			coins[level][j]['collected']=0
                j++
			}
                
            }
        }

        if (colliding(player_rect,block_rect) && blocks[level][i]['type']===7 && numcoins>=coinsneeded[level]) {
            if ((choice == 4) || (choice == 8) || (choice == 12) || (choice == 16) || (choice == 20)){
        	level+=1
            if (level == 6){
                window.location.replace("http://localhost/quiz/final.php");
            }
            else
            window.location.replace("http://localhost/quiz/question.php?n=" + level);
            numcoins=0
            player['x']=spawnpoints[level][0]
        	player['y']=spawnpoints[level][1]
        }else{
                player['x']=spawnpoints[level][0]
        	    player['y']=spawnpoints[level][1]
                j=0
    		while (coins[level].length>j) {
    			coins[level][j]['collected']=0
                j++
			}
            }
        }
        
        
        i++
	}


    i=0
    while (enemies[level].length>i) {
    	enemy=enemies[level][i]
    	var enemy_rect={x:enemy['x']*size+(size*0.2),y:enemy['y']*size+(size*0.2),width:size*0.6,height:size*0.6}
        if (colliding(player_rect,enemy_rect)) {
        	player['x']=spawnpoints[level][0]
        	player['y']=spawnpoints[level][1]
            deaths+=1
            numcoins=0
            j=0
    		while (coins[level].length>j) {
    			coins[level][j]['collected']=0
                j++
			}
        }
    i++
    }
    i=0
    while (coins[level].length>i) {
    	coin=coins[level][i]
    	var coin_rect={x:coin['x']*size+(size*0.25),y:coin['y']*size+(size*0.25),width:size*0.5,height:size*0.5}
        if (colliding(player_rect,coin_rect) && coin['collected']===0) {
        	coin['collected']=1
            numcoins+=1
        }
    i++
    }
}

function skip(lv) {
	level=lv
    window.location.replace("http://localhost/quiz/question.php?n=" + level);
 
    numcoins=0
    player['x']=spawnpoints[level][0]
    player['y']=spawnpoints[level][1]
}



function collideEnemy(enemy) {
	var i=0
    var enemy_rect={x:enemy['x']*size,y:enemy['y']*size,width:size,height:size}
    while (blocks[level].length>i) {
    	var block_rect={x:blocks[level][i]['x']*size,y:blocks[level][i]['y']*size,width:size,height:size}
    	if (colliding(enemy_rect,block_rect) && (blocks[level][i]['type']===1 || blocks[level][i]['type']===4)) {
        	return true
        }
        i++
	}
    return false
}

function colliding(rect1,rect2) {
if (rect1.x < rect2.x + rect2.width &&
   rect1.x + rect1.width > rect2.x &&
   rect1.y < rect2.y + rect2.height &&
   rect1.y + rect1.height > rect2.y) {return true}
   return false
}

function draw() {
	document.getElementById('level').innerHTML='|| Deaths: '+deaths
	ctx.fillStyle = "rgb(163, 163, 163)"
	ctx.fillRect(0, 0, c.width, c.height)
    var i=0
    while (blocks[level].length>i) {
    	var color='black'
        if (blocks[level][i]['type']===0) {
        	if (blocks[level][i]['x']%2===0 && blocks[level][i]['y']%2===0) {color='white'}
        	if (blocks[level][i]['x']%2===0 && blocks[level][i]['y']%2===1) {color='lightgrey'}
        	if (blocks[level][i]['x']%2===1 && blocks[level][i]['y']%2===0) {color='lightgrey'}
        	if (blocks[level][i]['x']%2===1 && blocks[level][i]['y']%2===1) {color='white'}
        }
    	if (blocks[level][i]['type']===1) {color='black'}
        if (blocks[level][i]['type']===2) {color='#55bec0'}
        if (blocks[level][i]['type']===3) {color='#67d0dd'}
        if (blocks[level][i]['type']===5) {color='#9fe481'}
        if (blocks[level][i]['type']===6) {color='#f8e785'}
        if (blocks[level][i]['type']===7) {color='#faafa5'}
        ctx.fillStyle = color+""
		if (!(blocks[level][i]['type']===4)) {ctx.fillRect(blocks[level][i]['x']*size, blocks[level][i]['y']*size, size, size)}
        i++
	}
    ctx.fillStyle = "blue"
	ctx.fillRect(player['x'], player['y'], size*0.6, size*0.6)
    ctx.strokeStyle="black"
	ctx.strokeRect(player['x'], player['y'], size*0.6, size*0.6)
    var i=0
    while (enemies[level].length>i) {
        ctx.beginPath()
		ctx.arc(enemies[level][i]['x']*size+size/2,enemies[level][i]['y']*size+size/2,(size*0.6)/2,0,2*Math.PI)
		ctx.fillStyle = '#543884'
        ctx.strokeStyle = 'black'
		ctx.fill()
        ctx.stroke()
		ctx.closePath()
        i++
	}
    var i=0
    while (coins[level].length>i) {
        if (coins[level][i]['collected']===0) {
        	ctx.beginPath()
			ctx.arc(coins[level][i]['x']*size+size/2,coins[level][i]['y']*size+size/2,(size*0.5)/2,0,2*Math.PI)
			ctx.fillStyle = 'yellow'

			ctx.fill()
        	ctx.stroke()
			ctx.closePath()
        }
        i++
	}
}

function addblock(type,x,y) {
	blocks[blocklevel].push({'type':type,'x':x,'y':y})
}

function addblocks(type,x1,y1,x2,y2) {
	var i=x1*1
    while (x2+1>i) {
    	var j=y1*1
        while (y2+1>j) {
        	addblock(type,i,j)
            j++
        }
    	i++
    }
}

var blocks=[[],[],[],[],[],[],[]]
var blocklevel = 1
addblocks(1,7,2,10,2)
addblocks(1,13,2,16,2)
addblocks(1,19,2,23,2)
addblocks(1,25,2,29,2)
addblocks(1,7,3,7,17)
addblocks(1,11,2,11,4)
addblocks(1,12,4,13,4)
addblocks(1,13,3,13,3)
addblocks(1,17,2,17,4)
addblocks(1,19,2,19,4)
addblocks(1,23,2,23,4)
addblocks(1,25,2,25,4)
addblocks(1,29,2,29,17)

addblocks(1,8,17,16,17)
addblocks(1,16,17,16,19)
addblocks(1,17,20,20,20)
addblocks(1,20,17,29,17)

addblock(1,18,4)
addblock(1,24,4)
addblock(1,20,18)
addblock(1,20,19)
addblock(1,16,20)




addblocks(0,8,5,28,16)
addblocks(2,17,17,19,19)
addblocks(3,8,3,10,4)
addblocks(5,14,3,16,4)
addblocks(6,20,3,22,4)
addblocks(7,26,3,28,4)


var blocklevel = 2
addblocks(1,5,10,5,13)
addblocks(1,5,10,8,10)
addblocks(1,6,13,8,13)
addblock(1,8,9)
addblock(1,8,14)
addblocks(1,8,8,21,8)
addblocks(1,8,15,21,15)
addblock(1,21,9)
addblock(1,21,14)

//after enemies horizontal lines
addblocks(1,21,10,24,10)
addblocks(1,21,13,26,13)

addblocks(1,27,10,28,10)
addblocks(1,21,13,26,13)

addblocks(1,29,13,30,13)
addblocks(1,31,10,32,10)

addblocks(1,33,10,33,15)


//first up
addblocks(1,24,8,24,9)
addblocks(1,27,8,27,9)
addblocks(1,24,8,30,8)

//first down
addblocks(1,26,13,26,15)
addblocks(1,29,13,29,15)

//sedond up
addblocks(1,28,8,28,9)
addblocks(1,31,8,31,9)


//second down
addblocks(1,30,13,30,15)
addblocks(1,27,15,33,15)

//finish
addblocks(3,25,9,26,10)
addblocks(5,29,9,30,10)
addblocks(6,27,13,28,14)
addblocks(7,31,13,32,14)

addblocks(2,6,11,8,12)
addblocks(0,9,9,20,14)
addblocks(0,21,11,32,12)


var blocklevel = 3
addblocks(1,10,4,10,7)
addblocks(1,11,4,14,4)
addblocks(1,14,3,16,3)
addblocks(1,16,4,20,4)
addblocks(1,20,3,22,3)
addblocks(1,22,4,28,4)
addblocks(1,13,7,17,7)
addblocks(1,17,8,19,8)
addblocks(1,19,7,23,7)
addblocks(1,23,8,25,8)
addblocks(1,25,7,28,7)
addblocks(1,29,4,29,7)

addblocks(1,10,7,10,15)
addblocks(1,13,7,13,12)

//bottom line
addblocks(1,11,15,29,15)

//top lines x
addblocks(1,14,12,15,12)
addblocks(1,18,12,19,12)
addblocks(1,22,12,23,12)
addblocks(1,26,12,27,12)

addblocks(1,15,10,30,10)

//toplines y

addblocks(1,15,10,15,12)
addblocks(1,18,10,18,12)
addblocks(1,19,10,19,12)
addblocks(1,22,10,22,12)
addblocks(1,23,10,23,12)
addblocks(1,26,10,26,12)
addblocks(1,27,10,27,12)
addblocks(1,30,10,30,15)

//path
addblocks(0,13,5,28,6)
addblocks(0,11,7,12,14)
addblocks(0,13,13,29,14)
addblock(0,15,4)
addblock(0,18,7)
addblock(0,21,4)
addblock(0,24,7)

//start
addblocks(2,11,5,12,6)

//finish
addblocks(3,16,11,17,12)
addblocks(5,20,11,21,12)
addblocks(6,24,11,25,12)
addblocks(7,28,11,29,12)

var blocklevel = 4
addblocks(0,10,13,34,13)
addblocks(0,11,10,11,14)
addblocks(0,13,9,13,14)
addblocks(0,15,8,15,14)
addblocks(0,17,7,17,14)
addblocks(0,19,6,19,14)
addblocks(0,21,5,21,14)
addblocks(1,10,9,11,9)
addblocks(1,12,8,13,8)
addblocks(1,14,7,15,7)
addblocks(1,16,6,17,6)
addblocks(1,18,5,19,5)
addblocks(1,20,4,22,4)
addblocks(1,10,10,10,12)
addblocks(1,12,9,12,12)
addblocks(1,14,8,14,12)
addblocks(1,16,7,16,12)
addblocks(1,18,6,18,12)
addblocks(1,20,5,20,12)
addblocks(1,22,5,22,12)
addblocks(1,10,15,22,15)


addblocks(0,24,12,25,12)
addblocks(0,27,12,28,12)
addblocks(0,30,12,31,12)
addblocks(0,33,12,34,12)

addblocks(1,23,9,35,9)

addblocks(1,23,9,23,11)
addblocks(1,26,9,26,11)
addblocks(1,29,9,29,11)
addblocks(1,32,9,32,11)
addblocks(1,35,9,35,11)

addblock(1,23,12)
addblock(1,26,12)
addblock(1,29,12)
addblock(1,32,12)
addblock(1,35,12)
addblock(1,35,13)

addblocks(3,24,10,25,11)
addblocks(5,27,10,28,11)
addblocks(6,30,10,31,11)
addblocks(7,33,10,34,11)

addblocks(1,23,14,35,14)

addblock(1,9,12)
addblock(1,9,13)
addblock(1,9,14)
addblock(1,10,14)
addblock(1,12,14)
addblock(1,14,14)
addblock(1,16,14)
addblock(1,18,14)
addblock(1,20,14)
addblock(1,22,14)
addblock(2,10,13)

var blocklevel = 5
///main floor
addblocks(0,14,6,17,20)

//left side wall
addblocks(0,12,6,13,17)
addblocks(0,11,7,11,16)
addblocks(0,10,8,10,15)

//right side wall
addblocks(0,18,6,19,17)
addblocks(0,20,7,20,16)
addblocks(0,21,8,21,15)

//start
addblocks(2,14,4,17,5)

//path to finish
addblocks(0,17,20,26,20)
addblocks(0,26,13,27,20)

//finish lines
addblocks(3,28,19,29,20)
addblocks(1,28,17,29,18)
addblocks(5,28,15,29,16)
addblocks(6,24,17,25,18)
addblocks(1,24,15,25,16)
addblocks(7,24,13,25,14)

//walls 
addblocks(1,13,3,18,3)
addblock(1,13,4)
addblock(1,13,5)
addblock(1,12,5)
addblock(1,11,5)
addblock(1,11,6)
addblock(1,10,6)
addblock(1,10,7)
addblock(1,9,7)
addblocks(1,9,7,9,16)
addblock(1,10,16)
addblock(1,10,17)
addblock(1,11,17)
addblock(1,11,18)
addblock(1,12,18)
addblock(1,13,18)
addblock(1,13,19)
addblock(1,13,20)
addblock(1,13,21)
addblocks(1,14,21,30,21)
addblocks(1,30,14,30,21)
addblock(1,28,14)
addblock(1,29,14)
addblock(1,28,13)
addblock(1,28,12)
addblocks(1,23,12,28,12)
addblocks(1,23,12,23,18)
addblocks(1,18,19,25,19)
addblocks(1,18,18,20,18)
addblocks(1,20,17,21,17)
addblocks(1,21,16,22,16)
addblocks(1,22,7,22,16)
addblock(1,21,7)
addblock(1,21,6)
addblock(1,20,6)
addblocks(1,18,5,20,5)
addblock(1,18,4)




var spawnpoints = [[0,0],[size*18.2,size*18.2],[size*7,size*11.5],[size*11.5,size*5.5],[size*10.2,size*13.2],[size*15.7,size*4.7]]
var coinsneeded = [0,0,1,1,6,0]
var player = {'x':spawnpoints[level][0],'y':spawnpoints[level][1]}
var moveright=0
var moveleft=0
var moveup=0
var movedown=0
var speed=1
document.addEventListener("keydown", move, false);
document.addEventListener("keyup", noMove, false);



function addenemy(x,y,xv,yv,minx=0,maxx=100,miny=0,maxy=100) {
	enemies[enemylevel].push({'x':x,'y':y,'xv':xv/size,
    'yv':yv/size,'minx':minx,'maxx':maxx,'miny':miny,
    'maxy':maxy})
}



var enemies = [[],[],[],[],[],[],[],[]]
var enemylevel = 2
addenemy(9,9,0,-0.5)
addenemy(10,14,0,0.5)
addenemy(11,9,0,-0.5)
addenemy(12,14,0,0.5)
addenemy(13,9,0,-0.5)
addenemy(14,14,0,0.5)
addenemy(15,9,0,-0.5)
addenemy(16,14,0,0.5)
addenemy(17,9,0,-0.5)
addenemy(18,14,0,0.5)
addenemy(19,9,0,-0.5)
addenemy(20,14,0,0.5)
var enemylevel = 3
addenemy(13,5,0.7,0,13,19)
addenemy(13,6,0.7,0,13,19)
addenemy(20,5,0.7,0,20,26)
addenemy(20,6,0.7,0,20,26)
var enemylevel = 4
addenemy(11,13,0,0.4,0,0,11)
addenemy(13,13,0,0.4,0,0,10)
addenemy(15,13,0,0.4,0,0,9)
addenemy(17,13,0,0.4,0,0,8)
addenemy(19,13,0,0.4,0,0,7)
addenemy(21,13,0,0.4,0,0,6)
var enemylevel = 5
addenemy(12,6,0,1,0,0,6,17)
addenemy(14,6,0,1,0,17,6,17)
addenemy(16,6,0,1,0,17,6,17)
addenemy(18,6,0,1,0,17,6,17)

addenemy(13,17,0,-1,0,0,6,17)
addenemy(15,17,0,-1,0,0,6,17)
addenemy(17,17,0,-1,0,0,6,17)
addenemy(19,17,0,-1,0,0,6,17)

addenemy(10,8,1,0,10,21,0,0)
addenemy(10,10,1,0,10,21,0,0)
addenemy(10,12,1,0,10,21,0,0)
addenemy(10,14,1,0,10,21,0,0)

addenemy(21,9,-1,0,10,21,0,0)
addenemy(21,11,-1,0,10,21,0,0)
addenemy(21,13,-1,0,10,21,0,0)
addenemy(21,15,-1,0,10,21,0,0)


function addcoin(x,y) {
	coins[coinlevel].push({'x':x,'y':y,'collected':0})
}

var coins = [[],[],[],[],[],[],[]]
var coinlevel=2
addcoin(14.5,11.5)
var coinlevel=3
addcoin(27.5,5.5)
var coinlevel=4
addcoin(11,10)
addcoin(13,9)
addcoin(15,8)
addcoin(17,7)
addcoin(19,6)
addcoin(21,5)



function tick() {
	draw()
    movePlayer()
    moveEnemies()
}

setInterval(tick,8)
</script>
	</main>

</body>

</html>