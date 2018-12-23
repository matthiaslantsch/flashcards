function alert(msg, level) {
	$(".alertArea").html('<div class="alert alert-'+level+'">'+msg+'</div>');
	$(".alert").fadeOut(2000);
}

function sendUpdate(idCard, update) {
	$.ajax({
		url: returnFWAlias()+"boxes/"+$("#idBox").val()+"/cards/"+idCard+"/update",
		method: "POST",
		data: {"update": update},
		error: function() {
			alert('Cannot connect to the server at this time :\'(', "danger");
		}
	});
}

function updatePager(numb) {
	var progressBar = $("#cardProgress");

	progressBar.attr("aria-valuenow", parseInt(progressBar.attr("aria-valuenow")) + numb);
	var percentage = Math.floor((progressBar.attr("aria-valuenow") / progressBar.attr("aria-valuemax")) * 100);
	progressBar.css("width", percentage+"%");

	if(progressBar.attr("aria-valuenow") == 1) {
		$("#prevBtn").attr("disabled", true);
	} else {
		$("#prevBtn").removeAttr("disabled");
	}

	if(progressBar.attr("aria-valuenow") == progressBar.attr("aria-valuemax")) {
		$("#nextBtn").attr("disabled", true);
	} else {
		$("#nextBtn").removeAttr("disabled");
	}

	$(".progressLabel").text(progressBar.attr("aria-valuenow") + " / " + progressBar.attr("aria-valuemax"));
}
