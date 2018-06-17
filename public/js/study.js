$(function(){
	nextCard();
});

function nextCard() {
	var index = parseInt($(".cardArea").data("index"));
	var cards = $(".cardArea").data("cards");

	if(index == cards.length) {
		window.location.replace(returnFWAlias()+"box/"+$("#idBox").val());
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
		$(".alert").fadeOut(1500, nextCard);
	} else {
		sendUpdate($("#idCard").val(), "WRONG");
		$(".alertArea").html('<div class="alert alert-danger">Wrong! The correct answer would be "'+$("#answer").val()+'"</div>');
		$(".alert").fadeOut(1500, nextCard);
	}
}