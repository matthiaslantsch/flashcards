//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
//Sets the min-height of #page-wrapper to window size
$(function() {
	$('#side-menu').metisMenu();
	$(window).bind("load resize", function() {
		var topOffset = 50;
		var width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
		if (width < 768) {
			$('div.navbar-collapse').addClass('collapse');
			topOffset = 100; // 2-row-menu
		} else {
			$('div.navbar-collapse').removeClass('collapse');
		}

		var height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
		height = height - topOffset;
		if (height < 1) height = 1;
		if (height > topOffset) {
			$("#page-wrapper").css("min-height", (height) + "px");
		}
	});

	var url = window.location;
	// var element = $('ul.nav a').filter(function() {
	//     return this.href == url;
	// }).addClass('active').parent().parent().addClass('in').parent();
	var element = $('ul.nav a').filter(function() {
	 return this.href == url;
	}).addClass('active').parent();

	while(true){
		if (element.is('li')){
			element = element.parent().addClass('in').parent();
		} else {
			break;
		}
	}
});

function alert(msg, level) {
	$(".alertArea").html('<div class="alert alert-'+level+'">'+msg+'</div>');
	$(".alert").fadeOut(2000);
}

function sendUpdate(idCard, update) {
	$.ajax({
		url: returnFWAlias()+"card/"+idCard+"/update.json",
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