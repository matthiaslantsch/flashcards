$(function(){
	$("#listingTable").on("click", ".boxRow", function() {
		window.location.assign(returnFWAlias()+"boxes/"+$(this).parent("tr").data("idbox"));
	});

	$("#listingTable").on("change", ".pageinput", function() {
		setPager($(this).val());
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
	$("#loading").removeClass("d-none");

	$.ajax({
		url: returnFWAlias()+"boxes/api?pager="+$("#pager").val()+$("#backendRequest").val(),
		method: "GET",
		async: false,
		success: function(res) {
			$("#listingTable").html(res);
		},
		error: function(res) {
			var msg = "Sorry but there was an error: ";
			alert(msg+xhr.status+" "+xhr.statusText, "danger");
		},
		complete: function(res) {
			$("#loading").addClass("d-none");
		}
	});
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
			alert('An error occurred :\'(', "danger");
		}
	});
}

function editModal(idBox) {
	if(typeof(idBox) == "undefined") {
		idBox = "";
		$("#editModal .modal-title").text("Create a new flashcard box");
		var load = returnFWAlias()+"boxes/new";
	} else {
		$("#editModal .modal-title").text("Edit flashcard box #"+idBox);
		var load = returnFWAlias()+"boxes/"+idBox+"/edit";
	}

	$("#editModal .modal-body").load(load, function(html, res) {
		if(res === "error") {
			alert('An error occurred :\'(', "danger");
		} else {
			$('#editModal').modal('show');
		}
	});

}

function movePager(value) {
	var oldPage = parseInt($("#pager").val());
	setPager(oldPage + value);
}

function setPager(value) {
	if(value < 1) {
		value = 1;
	}
	$("#pager").val(value);

	loadBoxes();
}
