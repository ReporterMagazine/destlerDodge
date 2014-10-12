<style>
@keyframes spin {
	from { transform: rotate(0deg); }
	to { transform: rotate(360deg); }
}

@keyframes spin_backwards {
	from { transform: rotate(360deg); }
	to { transform: rotate(0deg); }
}

.destler_forward {
	animation-name: spin; 
	animation-duration: 1000ms; /* 40 seconds */
	animation-iteration-count: infinite; 
	animation-timing-function: linear;
}

.destler_backwards{
	animation-name: spin_backwards; 
	animation-duration: 1000ms; /* 40 seconds */
	animation-iteration-count: infinite; 
	animation-timing-function: linear;
}

#destlerToggle {
	width: 100%;
	margin: 10px 0px;
	border: 1px solid #D9D9D9;
	padding: 5px;
	background-color: #F4F4F4;
	border-radius: 3px;
}

#destlerPlayButton {
	background-color:#513127;
	color:white;
	border-radius:3px;
	border:#5e3a2f 1px solid;
	text-align:center;
	font: bold 15px/40px 'Open Sans';
	cursor: pointer;
	text-transform: uppercase;
	text-shadow: 0 -1px 0 rgba(0, 0 ,0, .3);
	display:table-cell;
}

#destlerShareButton {
	background-color:#3c5a98;
	color:white;
	border-radius:3px;
	border:#3d61aa 1px solid;
	text-align:center;
	font: bold 15px/40px 'Open Sans';
	cursor: pointer;
	text-transform: uppercase;
	text-shadow: 0 -1px 0 rgba(0, 0 ,0, .3);
	display:none;
}

#destlerButtonSeperator {
	width:10px;
	height:1px;
	display:none;
}

#destlerPlayButton:hover {
	background-color:#F36E21;
}

#destlerShareButton:hover {
	background-color:#2a57b4;
}


</style>
<script>
	var numBill = 0;
	var timer = 1;
	var interval;
	var numStudent = 0;
	var studentID = 0;
	var studentsSaved = 0;
	var score = 0;

	$(document).ready(function() {
		$("#destlerPlayButton").click(function(){
			if($(window).width() < 992) {
				alert("Destler Dodge is not available on mobile.");
			} else {
				destler_toggle();
			}
		});
               $("#destlerShareButton").click(function(){
                        FBshare();
               });
	});
	
	function destler_toggle() {
		clearInterval(interval);
		interval = null;
		if(numBill != 0) {
			numBill = 0;
			numStudent = 0;
			studentID = 0;
			studentsSaved = 0;

			$("#destlers").empty();
			$("#destlers").css({"border":"0px","z-index":"0"});
			$("#destlers").hide();
		} else {
			$("#deslter_lost").hide();
			$("#destlers").show();
			timer = 1;
			$("#destlers").css({"border":"15px solid #e86d00","z-index":"1999"});
			$("#destlerButtonSeperator").css('display','none');
			$("#destlerShareButton").css('display','none');
			$("#destlerPlayButton").css('display','none');
			$("#deslterGameInfo").css({'padding-top':'0px'});
			interval = setInterval(function() {
				$("#destler_timer").html(timer + " seconds");
				timer++;
				if(timer % 2 == 0) {
					numBill++;
					bouncingBill(numBill);
				}
				if(randomNumber(1) == 1 && numStudent == 0) {
					bouncingStudent(studentID);
					studentID++;
				}
				score = score + 1 + studentsSaved;
				$("#deslter_score").html("Score: "+score+" Points");
				$("#destler_number").html(numBill + " Destlers Spawned");
			},1000);
			score = 0
			numBill = 5;
			for(var n = 0; n < numBill; n++) bouncingBill(n);
			$("#destler_timer").html("0 seconds");
			$("#destler_students").html("0 Reporter Staff Saved");
			$("#destler_number").html(numBill+ " Destlers Spawned");
			$("#deslter_score").html("Score: "+score+" Points");
			$("#deslterGameInfo").show();
		}
	}
	
	var phrases = new Array();
	phrases[0] = "drinking in the dorms!";
	phrases[1] = "smoking on campus!";
	phrases[2] = "peeing in a fountain!";
	phrases[3] = "strumming his banjo!";
	phrases[4] = "stealing silverware from Gracie's!";
	phrases[5] = "not innovating hard enough!";
	phrases[6] = "making fun of his Chevy Volt!";
	phrases[7] = "climbing the Sentinel!";
	phrases[8] = "putting soap in a fountain!";
	phrases[9] = "riding the tiger statue!";
	function destler_hit() {
		if(numBill > 0) {
			destler_toggle();
			$("#deslterGameInfo").css({'padding-top':'5px'});
			$("#deslter_lost").show();
			$("#deslter_lost_saying").html(phrases[randomNumber(phrases.length-1)]);
			$("#destlerButtonSeperator").css('display','table-cell');
			$("#destlerShareButton").css('display','table-cell');
			$("#destlerPlayButton").html("Play Again").css('display','table-cell');;
		}
	}
	
	function student_saved(e) {
		studentsSaved++;
		$(e).remove();
		numStudent--;
		$("#destler_students").html(studentsSaved + " Reporter Staff Saved");
	}	
	
	function randomNumber(val) {
		return Math.floor(Math.random() * (val + 1));
	}

	function bouncingBill(num) {
		var side = randomNumber(1);
		var y = randomNumber($(window).height());
		var x = randomNumber($(window).width());
		
		if(!$("#dslt_"+num).length && numBill > 0) {
			$("#destlers").append("<img class='"+(side == 0 ? "destler_backwards":"destler_forward")+"' id='dslt_"+num+"' onmouseover=destler_hit(); src='http://reporter.rit.edu/sites/pubDir/DestlerDodge/destler.png' style='position:fixed ;z-index:999;top:"+y+"px;left:"+x+"px;height:0px;'>");
			y = randomNumber($(window).height());
			x = randomNumber($(window).width());
		}
		
		if(side == 0) x = (randomNumber(1) == 0 ? 0 : $(window).width());
		else y = (randomNumber(1) == 0 ? 0 : $(window).height());
			
		var s = Math.floor(Math.random() * (5000 - 500 + 1)) + 500;
		var size = Math.random()+.1;
		$("#dslt_"+num).animate({ top: y, left: x, height: 125*size}, s, "linear", function() {
			bouncingBill(num);
		})
	};
	
	$("#destlers").mouseleave(function() {
		destler_hit();
	});
	
	var students = new Array();
	students[0] = "http://reporter.rit.edu/sites/pubDir/DestlerDodge/nathan.png";
	students[1] = "http://reporter.rit.edu/sites/pubDir/DestlerDodge/joannie.png";
	students[2] = "http://reporter.rit.edu/sites/pubDir/DestlerDodge/zak.png";
	students[3] = "http://reporter.rit.edu/sites/pubDir/DestlerDodge/joe.png";
	
	function bouncingStudent(num) {
		var side = randomNumber(1);
		var y = randomNumber($(window).height());
		var x = randomNumber($(window).width());
		
		if(!$("#dslt_student_"+num).length && numBill > 0) {
			$("#destlers").append("<img id='dslt_student_"+num+"' onmouseover=student_saved(this); src='"+students[randomNumber(students.length-1)]+"' style='position:fixed ;z-index:999;top:"+y+"px;left:"+x+"px;height:0px;'>");
			y = randomNumber($(window).height());
			x = randomNumber($(window).width());
			numStudent++;
		}
		
		if(side == 0) x = (randomNumber(1) == 0 ? 0 : $(window).width());
		else y = (randomNumber(1) == 0 ? 0 : $(window).height());
			
		var s = Math.floor(Math.random() * (5000 - 500 + 1)) + 500;
		var size = Math.random()+.1;
		$("#dslt_student_"+num).animate({ top: y, left: x, height: 125*size}, s, "linear", function() {
			bouncingStudent(num);
		})
	};

	function FBshare() {
		FB.ui(
		{
			method: 'feed',
			name: 'I scored '+score+' points playing Destler Dodge',
			link: 'http://reporter.rit.edu',
			picture: 'http://reporter.rit.edu/glyphScaled.png',
			caption: 'Play Destler Dodge at reporter.rit.edu!',
			description: 'Dodge the floating Destlers that are trying to catch your mouse. Along the way, use your cursor to save the Reporter staff to earn more points. The longer you last, the more Destlers will be after you! Leaving the brick perimeter will cause you to lose.'
		});
	};
	
</script>
<div id='destlerToggle'>
	<div id='deslter_lost' style='display:none;'>
			<div style='font-family:Open Sans;font-size:24px;text-align:center;font-weight:bold;'>DESTLER CAUGHT YOU</div>
			<div id='deslter_lost_saying' style='font-size:18px;text-align:center;padding-bottom:5px;'></div>
		</div>
	<div style='display:table;width:100%;'>
	<div id='destlerPlayButton'>Play Destler Dodge</div>
	<div id='destlerButtonSeperator'></div>
	<div id='destlerShareButton'>Share</div>
	</div>
	<div id='deslterGameInfo' style='display:none;'>
		<div id='deslter_score' style='font-family:Open Sans;font-size:18px;font-weight:bold;'></div>
		<div id='destler_timer'></div>
		<div id='destler_number'></div>
		<div id='destler_students'></div>
		<div style='height:5px;width:1px;'></div>
	</div>
	<div id='destlerInstructions'>
		<div style='font-family:Open Sans;font-size:18px;font-weight:bold;'>How to Play:</div>
		<div style='font-size:12px;'>Dodge the floating Destlers that are trying to catch your mouse. Along the way, use your cursor to save the Reporter staff to earn more points. The longer you last, the more Destlers will be after you! Leaving the brick perimeter will cause you to lose.</div>
	</div>

</div>