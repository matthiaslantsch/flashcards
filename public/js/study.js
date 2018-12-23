$(function(){
	nextCard();

	$("#answerField").on("keyup", function(e) {
		//check if we're already in "do it right" mode
		if($(".studyBtn").prop("disabled")) {
			if($("#answerField").val().trim() == $("#answer").val()) {
				$(".alertArea").html('<div class="alert alert-success">Well done!</div>');
				$(".studyBtn").removeProp("disabled");
				$(".alert").fadeOut(250, nextCard);
			}
		} else if(e.keyCode === 13) {
			//enter just check if it's correct
			checkAnswer();
		}
	});
});

function nextCard() {
	var index = parseInt($(".cardArea").data("index"));
	var cards = $(".cardArea").data("cards");

	if(index == cards.length) {
		$(".alertArea").html(
			'<div class="btn-group" role="group" aria-label="...">'+
				'<button type="button" onclick="location.reload()" class="btn btn-default">Again</button>'+
				'<button type="button" onclick="window.location.replace(\''+returnFWAlias()+"boxes/"+$("#idBox").val()+'\')" class="btn btn-default">Back</button>'+
			'</div>'
		);
		return;
	}

	$("#answerField").val("");
	$("#question").text(cards[index].question);
	$("#answer").text(cards[index].answer);
	$("#rightCount").text(cards[index].rightCount);
	$("#wrongCount").text(cards[index].wrongCount)
	$("#idCard").val(cards[index].idCard);
	$("#answer").val(cards[index].answer);
	$("#tierField").html('<i class="fa fa-star" aria-hidden="true"></i> '.repeat(cards[index].tier))
	$("#alertArea").html("");

	$(".cardArea").data("index", index + 1);
	updatePager(1);
}

function checkAnswer() {
	if($("#answerField").val().trim() == $("#answer").val()) {
		sendUpdate($("#idCard").val(), "RIGHT");
		$(".alertArea").html('<div class="alert alert-success">Correct!</div>');
		$(".alert").fadeOut(250, nextCard);
	} else {
		sendUpdate($("#idCard").val(), "WRONG");
		$(".alertArea").html('<div class="alert alert-danger">Wrong! The correct answer would be "'+$("#answer").val()+'" Type it now</div>');
		$(".studyBtn").prop("disabled", true);
		$("#answerField").val("").focus();

	}
}
