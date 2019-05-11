$(function(){
	$("#showFirst").on("change", displayCard);

	console.log($('#questionArea div'));
	$('#questionArea div').on('click', '.answerbtn', function(){
		var currentOffset = ($("#cardProgress").attr("aria-valuenow") - 1);
		var currentItem = studybox[currentOffset];

		$(".answerbtn").prop("disabled", true);
		if($(this).data("idcard") == currentItem.idCard) {
			$(this).removeClass("btn-dark").addClass("btn-success");
		} else {
			$(this).removeClass("btn-dark").addClass("btn-danger");
			$('*[data-idcard="'+currentItem.idCard+'"]').removeClass("btn-dark").addClass("btn-outline-success");
			//sendupdate false -1
		}
		setTimeout(function(){
			updatePager(1);
			displayCard();
		}, 750);
	});

	updatePager(0);
	displayCard();
});

function displayCard() {
	var currentOffset = ($("#cardProgress").attr("aria-valuenow") - 1);
	var currentItem = studybox[currentOffset];

	if(currentOffset == studybox.length) {
		$(".card-footer").hide();
		$(".card-header").hide();
		$("#questionArea").html(
			'<div class="btn-group btn-group-lg" role="group" aria-label="...">'+
			'<button type="button" onclick="location.reload()" class="btn btn-dark">Again</button>'+
			'<button type="button" onclick="window.location.replace(\''+"returnFWAlias"+"boxes/"+$("#idBox").val()+'\')" class="btn btn-dark">Back</button>'+
			'</div>'
		);
		return;
	}

	if(studybox.length < 5) {
		var randomItems = studybox;
	} else {
		var randomItems = [currentItem];
		while (randomItems.length < 5) {
			var randItem = studybox[Math.floor(Math.random()*studybox.length)];
			if(!randomItems.includes(randItem)) {
				randomItems.push(randItem);
			}
		}
	}

	randomItems = shuffle(randomItems);

	if($("#showFirst").val() === "question") {
		$("#questionArea h4").text(currentItem.question);
		$("#questionArea div").html("");
		$.each(randomItems, function(e, i) {
			$("#questionArea div").append(
				'<button type="button" class="answerbtn btn btn-dark btn-block" data-idcard="'+i.idCard+'">'+i.answer+'</button>'
			);
		});
	} else {
		$("#questionArea h4").text(currentItem.answer);
		$("#questionArea div").html("");
		$.each(randomItems, function(e, i) {
			$("#questionArea div").append(
				'<button type="button" class="answerbtn btn btn-dark btn-block" data-idcard="'+i.idCard+'">'+i.question+'</button>'
			);
		});
	}
}
