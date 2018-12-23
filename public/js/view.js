$(function(){
	$(".card").flip({
		axis: "x",
		trigger: "click"
	});

	$(document).keydown(function(e) {
		if(e.which == 38 || e.which == 40 || e.which == 32) {
			$(".item.active .card").flip("toggle");
		} else if(e.which == 37) {
			prev();
		} else if(e.which == 39) {
			next();
		} else {
			return;
		}

		e.preventDefault(); // prevent the default action (scroll / move caret)
	});

	$(document).on("slid.bs.carousel", function(e) {
		sendUpdate($(".item.active").data("idcard"), "VIEW");
	});

	updatePager(0);
	sendUpdate($(".item.active").data("idcard"), "VIEW");
});

function prev() {
	if($("#cardProgress").attr("aria-valuenow") == 1) {
		return;
	}

	$("#myCarousel").carousel("prev");
	updatePager(-1);
}

function next() {
	if($("#cardProgress").attr("aria-valuenow") == $("#cardProgress").attr("aria-valuemax")) {
		return;
	}

	$("#myCarousel").carousel("next");
	updatePager(1);
}
