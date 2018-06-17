$(function(){
	$("#listing").on("click", ".boxRow", function() {
		window.location.assign(returnFWAlias()+"box/"+$(this).data("idbox"));
	});

	$(document).on("submit", "#boxForm", function (e) {
		e.preventDefault();
		$("#nameTf").attr("disabled", true);
		$("#descTa").attr("disabled", true);
		$("#submitBtn").attr("disabled", true);
		$.ajax({
			url: returnFWAlias()+"box/save/"+$("#idBoxField").val()+".json",
			method: "POST",
			data: {
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
				$("#nameTf").removeAttr("disabled");
				$("#descTa").removeAttr("disabled");
				$("#submitBtn").removeAttr("disabled");
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
	$("#listing").load(returnFWAlias()+"box/list?pager="+$("#pager").val()+$("#backendRequest").val(), function(response, status, xhr) {
		if (status == "error") {
			var msg = "Sorry but there was an error: ";
			alert(msg+xhr.status+" "+xhr.statusText, "danger");
			ret = false;
		}
		$("#loading").hide();
	});
	return ret;
}

function resetProgress(idBox) {
	$.ajax({
		url: returnFWAlias()+"box/"+idBox+"/reset.json",
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
		url: returnFWAlias()+"box/"+idBox+"/delete.json",
		method: "POST",
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
	} else {
		$("#editModal .modal-title").text("Edit flashcard box #"+idBox);
	}
	$("#editModal .modal-body").load(returnFWAlias()+"box/form/"+idBox);
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
		loadBoxes();
	}
}