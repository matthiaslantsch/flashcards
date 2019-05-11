$(function(){
	displayCard();

	$("#answerField").on("keyup", function(e) {
		//check if we're already in "do it right" mode
		if($("#checkBtn").prop("disabled")) {
			if(checkAnswer($("#answerField").val().trim())) {
				$("#checkBtn").prop("disabled", false);
				$(".alertArea").html('<div class="alert alert-success">Well done!</div>');
				$(".alert").fadeOut(500, nextCard);
			}
		} else if(e.keyCode === 13) {
			//enter just check if it's correct
			verifyAnswer();
		}
	});

	$("#skipBtn").on("click", function() {
		//check if we're already in "do it right" mode
		if($("#checkBtn").prop("disabled")) {
			//sendUpdate($("#idCard").val(), "CORRECTION");
			$("#skipBtn").text("Skip this card");
			$("#checkBtn").prop("disabled", false);
			nextCard();
		} else {
			nextCard();
		}
	});

	$("#showFirst").on("change", displayCard);
	updatePager(0);
});

function displayCard() {
	var currentOffset = ($("#cardProgress").attr("aria-valuenow") - 1);

	if(currentOffset == studybox.length) {
		$(".card-footer").hide();
		$(".card-header").hide();
		$("#studyField").html(
			'<div class="btn-group btn-group-lg" role="group" aria-label="...">'+
			'<button type="button" onclick="location.reload()" class="btn btn-dark">Again</button>'+
			'<button type="button" onclick="window.location.replace(\''+"returnFWAlias"+"boxes/"+$("#idBox").val()+'\')" class="btn btn-dark">Back</button>'+
			'</div>'
		);
		return;
	}

	var currentItem = studybox[currentOffset];
	$("#studyField").data("currentItem", currentItem);

	if($("#showFirst").val() === "question") {
		$("#question").text(currentItem.question);
	} else {
		$("#question").text(currentItem.answer);
	}

	$("#answerField").val("");
	$("#answerField").focus();
	$("#rightCount").text(currentItem.rightCount);
	$("#wrongCount").text(currentItem.wrongCount)
	$("#tierField").html('<i class="fa fa-star" aria-hidden="true"></i> '.repeat(currentItem.tier))
	$("#alertArea").html("");
}

function nextCard() {
	updatePager(1);
	displayCard();
}

function verifyAnswer() {
	var currentItem = $("#studyField").data("currentItem");
	if(checkAnswer($("#answerField").val().trim())) {
		//sendUpdate($("#idCard").val(), "RIGHT");
		$(".alertArea").html('<div class="alert alert-success">Correct!</div>');
		$(".alert").fadeOut(800, nextCard);
	} else {
		//sendUpdate($("#idCard").val(), "WRONG");
		$(".alertArea").html('<div class="alert alert-danger">Wrong! The correct answer would be "'
			+($("#showFirst").val() === "question" ? currentItem.answer : currentItem.question)
			+'" Type it now</div>'
		);
		$("#checkBtn").prop("disabled", true);
		$("#skipBtn").text("I was right");
		$("#answerField").val("").focus();
	}
}

function checkAnswer(givenAnswer) {
	var givenAnswer = $("#answerField").val().trim();
	var currentItem = $("#studyField").data("currentItem");

	if($("#showFirst").val() === "question" && currentItem.check.includes(givenAnswer)) {
		return true;
	} else if($("#showFirst").val() === "answer" && givenAnswer === currentItem.question) {
		return true;
	}

	return false;
}
