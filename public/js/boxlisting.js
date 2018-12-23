$(function(){
	$("#listing").on("click", ".boxRow", function() {
		window.location.assign(returnFWAlias()+"boxes/"+$(this).data("idbox"));
	});

	$(document).on("submit", "#boxForm", function (e) {
		e.preventDefault();
		$("#nameTf").attr("disabled", true);
		$("#descTa").attr("disabled", true);
		$("#submitBtn").attr("disabled", true);
		$.ajax({
			url: $("#boxForm").get(0).action,
			method: "POST",
			data: {
				"_method": $("#methodOverrideField").val(),
				"name": $("#nameTf").val(),
				"desc": $("#descTa").val()
			},
			success: function(res) {
				if(res.error) {
					alert("<strong>Error!</strong> Could not save your flashcard box", "danger");
					$("#nameTf").val("");
					$("#descTa").val("");
				} else {
					$('#editModal').modal('hide');
					loadBoxes();
					alert("<strong>Sucess!</strong> Saved changes to your flashcard box", "success");
				}
			},
			error: function() {
				alert('Cannot connect to the server at this time :\'(', "danger");
			},
			complete: function() {
				$("#nameTf").removeAttr("disabled");
				$("#descTa").removeAttr("disabled");
				$("#submitBtn").removeAttr("disabled");
			}
		});
	});

	loadBoxes();
});

function loadBoxes() {
	$("#loading").show();
	var ret = true;
	$.ajax({
		url: returnFWAlias()+"boxes/api?pager="+$("#pager").val()+$("#backendRequest").val(),
		method: "GET",
		async: false,
		success: function(res) {
			//mmmmm I love hacks
			if(res.trim() != '<tr><td colspan="6"><span>Oops... There seems to be nothing here</span></td></tr>' || $("#pager").val() == 1) {
				$("#listing").html(res);
				if($("#pager").val() != 1) {
					ret = false;
				}
			} else {
				ret = false;
			}
		},
		error: function(res) {
			var msg = "Sorry but there was an error: ";
			alert(msg+xhr.status+" "+xhr.statusText, "danger");
			ret = false;
		},
		complete: function(res) {
			$("#loading").hide();
		}
	});
	return ret;
}

function resetProgress(idBox) {
	$.ajax({
		url: returnFWAlias()+"boxes/"+idBox+"/reset",
		method: "POST",
		success: function(res) {
			if(res.error) {
				alert("<strong>Error!</strong> Could not reset your progress", "danger");
			} else {
				alert("<strong>Sucess!</strong> Your progress has been reset", "success");
				loadBoxes();
			}
		},
		error: function() {
			alert('Cannot connect to the server at this time :\'(', "danger");
		}
	});
}

function deleteBox(idBox) {
	$.ajax({
		url: returnFWAlias()+"boxes/"+idBox,
		method: "POST",
		data: {"_method": "delete"},
		success: function(res) {
			if(res.error) {
				alert("<strong>Error!</strong> Could not delete that box", "danger");
			} else {
				alert("<strong>Sucess!</strong> The box has been deleted", "success");
				loadBoxes();
			}
		},
		error: function() {
			alert('Cannot connect to the server at this time :\'(', "danger");
		}
	});
}

function editModal(idBox) {
	if(typeof(idBox) == "undefined") {
		idBox = "";
		$("#editModal .modal-title").text("Create a new flashcard box");
		$("#editModal .modal-body").load(returnFWAlias()+"boxes/new");
	} else {
		$("#editModal .modal-title").text("Edit flashcard box #"+idBox);
		$("#editModal .modal-body").load(returnFWAlias()+"boxes/"+idBox+"/edit");
	}
	$('#editModal').modal('show');
}

function pager(value) {
	$("#prevBtn").removeAttr("disabled");
	$("#nextBtn").removeAttr("disabled");

	var oldPage = parseInt($("#pager").val());
	var newPage = oldPage + value;
	if(newPage < 1) {
		newPage = 1;
	}
	$("#pager").val(newPage);

	if(!loadBoxes()) {
		$("#pager").val(oldPage);
		if(value < 2) {
			$("#prevBtn").attr("disabled", true);
		}

		if(value > 0) {
			$("#nextBtn").attr("disabled", true);
		}
	}
}
