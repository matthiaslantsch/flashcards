$(function(){
	$(document).on("submit", "#cardForm", function (e) {
		e.preventDefault();
		$("#quesTa").attr("disabled", true);
		$("#ansTa").attr("disabled", true);
		$("#submitBtn").attr("disabled", true);
		$.ajax({
			url: $("#cardForm").get(0).action,
			method: "POST",
			data: {
				"_method": $("#methodOverrideField").val(),
				"question": $("#quesTa").val(),
				"answer": $("#ansTa").val(),
				"idBox": $("#idBox").val()
			},
			success: function(res) {
				if(res.error) {
					alert("<strong>Error!</strong> Could not create new flashcard", "danger");
					$("#quesTa").val("");
					$("#ansTa").val("");
				} else {
					alert("<strong>Sucess!</strong> Created your new flashcard", "success");
					location.reload();
				}
			},
			error: function() {
				alert('Cannot connect to the server at this time :\'(', "danger");
			},
			complete: function() {
				$("#quesTa").removeAttr("disabled");
				$("#ansTa").removeAttr("disabled");
				$("#submitBtn").removeAttr("disabled");
				$("#quesTa").val("");
				$("#ansTa").val("");
			}
		});
	});
});

function editModal(idCard) {
	baseUrl = returnFWAlias()+"boxes/"+$("#idBox").val()+"/cards/";
	if(typeof(idCard) == "undefined") {
		$("#editModal .modal-body").load(baseUrl+"new");
		$("#editModal .modal-title").text("Create a new flashcard");
	} else {
		$("#editModal .modal-title").text("Edit flashcard #"+idCard);
		$("#editModal .modal-body").load(baseUrl+idCard+"/edit");
	}
	$('#editModal').modal('show');
}

function deleteCard(idCard) {
	$.ajax({
		url: returnFWAlias()+"boxes/"+$("#idBox").val()+"/cards/"+idCard,
		method: "POST",
		data: {
			"_method": "delete"
		},
		success: function(res) {
			if(res.error) {
				alert("<strong>Error!</strong> Could not delete that flashcard", "danger");
			} else {
				alert("<strong>Sucess!</strong> The flashcard has been deleted", "success");
				location.reload();
			}
		},
		error: function() {
			alert('Cannot connect to the server at this time :\'(', "danger");
		}
	});
}
