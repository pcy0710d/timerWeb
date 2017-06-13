<html>
<?php require_once('./includes/global.php');?>
<head>
<body>
<?php require_once('./templates/header.php');?>

<div class="container" style="text-align:center;padding-top:70">
	<div class="row">
		<input type="text" id="input" placeholder="Enter Task Name">
		<button id="add"></button>
	</div>
</div>

<div class="container" align='center' id='taskList'>
</div>

<div class="container" align='center' id='finishedList'>
</div>

<div class="container" style="height:49%">
</div>

<?php require_once('./templates/footer.php'); ?>

</body>

<script>
var tasks=[];
var numWorking = 0;

$("#add").click(function(){
	if ($('input:text').val()!=''){
		var input = $('input:text').val();
		addTask(input);
		$('input:text').val('');
	}
	else alert("Task name cannot be empty.");
});

function addTask(input){
	tasks.push([input, 0, numWorking, 0]);//inputText, timeCount, id, isPause
	//box
	var element = document.createElement("div");
	element.className = "element";
	element.id = "box" + numWorking;
	//left element
	var left = document.createElement("div");
	left.innerHTML = input;
	left.className = "left";
	//middle element
	var mid = document.createElement("div");
	mid.className = "mid";
	mid.innerHTML = "0 sec";
	mid.id = "timerNum" + numWorking;
	//right element
	var right = document.createElement("div");
	right.className = "right";
	//pauseButton
	var pauseButton = document.createElement("button");
	pauseButton.className = "pauseBtn";
	pauseButton.id = "pauseBtn" + numWorking;
	pauseButton.onclick = function(){
		var cur = this.id[this.id.length-1];//get the current element's id
		if (tasks[cur][3]==0){//change isPaused flag
			tasks[cur][3] = 1;
		}
		else {
			tasks[cur][3] = 0;
		}
	}
	//finishButton
	var finishButton = document.createElement("button");
	finishButton.className = 'finishBtn';
	finishButton.id = "finishBtn" + numWorking;
	finishButton.onclick = function(){
		var cur = this.id[this.id.length-1];//get the current element's id
		$("#box"+cur).hide();
		addFinished(cur);
	}

	var taskList = document.getElementById("taskList");
	taskList.appendChild(element);
	element.appendChild(left);
	element.appendChild(mid);
	element.appendChild(right);
	right.appendChild(pauseButton);
	right.appendChild(finishButton);
	numWorking++;
}

function addFinished(index){
	//box
	var element = document.createElement("div");
	element.className = "elementFinished";
	element.id = "box" + index;
	//left element
	var left = document.createElement("div");
	left.className = "left";
	//middle element
	var mid = document.createElement("div");
	mid.className = "mid";
	//right element
	var right = document.createElement("div");
	right.className = "right";
	var min = Math.floor(tasks[index][1] / 60);
	var sec = tasks[index][1]%60;
	if (min<=0){
		right.innerHTML = sec + " sec";
	}
	else{
		right.innerHTML = min + " min " + sec + " sec";
	}

	var tick = document.createElement('span');
	tick.setAttribute('class', 'glyphicon glyphicon-ok');
	tick.id = "tick";

	var t = document.createTextNode(tasks[index][0]);

	var taskList = document.getElementById("finishedList");
	taskList.appendChild(element);
	element.appendChild(left);
	element.appendChild(mid);
	element.appendChild(right);
	left.appendChild(tick);
	left.appendChild(t);
}


var counter=setInterval(timer, 1000); //1000 will  run it every 1 second
function timer()
{
  for (var i=0;i<numWorking;i++){
  	if (tasks[i][3]==0){ //!isPaused
	  	tasks[i][1]++; //timerCount increment
	  	var min = Math.floor(tasks[i][1] / 60);
	  	var sec = tasks[i][1]%60;
	  	//printing format
	  	if (min<=0){
	  		$("#timerNum"+i).html(sec + " sec");
	  	}
	  	else{
			$("#timerNum"+i).html(min + " min " + sec + " sec");
	  	}
	  }
  }
}

</script>



