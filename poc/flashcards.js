$(function(){
	$(".card-body").flip({
		axis: "x",
		trigger: "click"
	});

	$(document).keydown(function(e) {
		if(e.which == 38 || e.which == 40 || e.which == 32) {
			$(".card-body").flip("toggle");
		} else if(e.which == 37) {
			prev();
		} else if(e.which == 39) {
			next();
		} else {
			return;
		}

		e.preventDefault(); // prevent the default action (scroll / move caret)
	});

	$("#showFirst").on("change", displayCard);

	updatePager(0);
	displayCard();
});

function displayCard() {
	var currentOffset = ($("#cardProgress").attr("aria-valuenow") - 1);
	var currentItem = studybox[currentOffset];

	if($("#showFirst").val() === "question") {
		$(".front h2").text(currentItem.question);
		$(".back h2").text(currentItem.answer);
	} else {
		$(".front h2").text(currentItem.answer);
		$(".back h2").text(currentItem.question);
	}

	sendUpdate(currentItem.idBox, currentItem.idCard, "VIEW");
}

function prev() {
	if($("#cardProgress").attr("aria-valuenow") == 1) {
		return;
	}

	updatePager(-1);
	displayCard();
}

function next() {
	if($("#cardProgress").attr("aria-valuenow") == $("#cardProgress").attr("aria-valuemax")) {
		return;
	}

	updatePager(1);
	displayCard();
}
