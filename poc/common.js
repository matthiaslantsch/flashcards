var studybox = [
	{
		"idCard": 1,
		"idBox": 2,
		"tier": 5,
		"rightCount": 2,
		"wrongCount": 3,
		"question": "first question",
		"answer": "(v) first answer / 1st answer",
		"check": [
			"(v) first answer / 1st answer",
			"first answer", "1st answer"
		]
	},
	{
		"idCard": 2,
		"idBox": 2,
		"tier": 3,
		"rightCount": 4,
		"wrongCount": 2,
		"question": "second question",
		"answer": "(v) second answer / 2nd answer",
		"check": [
			"(v) second answer / 2nd answer",
			"second answer", "2nd answer"
		]
	},
	{
		"idCard": 3,
		"idBox": 2,
		"tier": 2,
		"rightCount": 4,
		"wrongCount": 2,
		"question": "third question",
		"answer": "3rd answer",
		"check": ["3rd answer"]
	},
	{
		"idCard": 4,
		"idBox": 2,
		"tier": 2,
		"rightCount": 4,
		"wrongCount": 2,
		"question": "4th question",
		"answer": "4th answer",
		"check": ["4th answer"]
	},
	{
		"idCard": 5,
		"idBox": 2,
		"tier": 2,
		"rightCount": 4,
		"wrongCount": 2,
		"question": "5th question",
		"answer": "5th answer",
		"check": ["5th answer"]
	},
	{
		"idCard": 6,
		"idBox": 2,
		"tier": 2,
		"rightCount": 4,
		"wrongCount": 2,
		"question": "6th question",
		"answer": "6th answer",
		"check": ["6th answer"]
	}
]

function alert(msg, level) {
	$(".alertArea").html('<div class="alert alert-'+level+'">'+msg+'</div>');
	$(".alert").fadeOut(2000);
}

function sendUpdate(idBox, idCard, update) {
	$.ajax({
		url: returnFWAlias()+"boxes/"+idBox+"/cards/"+idCard+"/update",
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

function shuffle(array) {
  var currentIndex = array.length, temporaryValue, randomIndex;

  // While there remain elements to shuffle...
  while (0 !== currentIndex) {

    // Pick a remaining element...
    randomIndex = Math.floor(Math.random() * currentIndex);
    currentIndex -= 1;

    // And swap it with the current element.
    temporaryValue = array[currentIndex];
    array[currentIndex] = array[randomIndex];
    array[randomIndex] = temporaryValue;
  }

  return array;
}
