$(function(){
	$(document).on("submit", "#userForm", function (e) {
		e.preventDefault();
		$("#submitBtn").attr("disabled", true);
		$.ajax({
			url: returnFWAlias()+"user/save/"+$("#idUser").val()+".json",
			method: "POST",
			data: {
				"name": $("#nameTf").val(),
				"email": $("#emailTf").val(),
				"password": $("#passwordTf").val(),
				"admin": $("#isAdminCb").is(":checked"),
				"idUser": $("#idUser").val()
			},
			success: function(res) {
				if(res.errormsg.length != 0) {
					alert("<strong>Error!</strong> Could not save user. "+res.errormsg, "danger");
				} else {
					alert("<strong>Sucess!</strong> Saved changes to user", "success");
					location.reload();
				}
			},
			error: function() {
				alert('Cannot connect to the server at this time :\'(', "danger");
			},
			complete: function() {
				$("#submitBtn").removeAttr("disabled");
			}
		});
	});
});

function editModal(idUser) {
	if(typeof(idUser) == "undefined") {
		idUser = "";
		$("#editModal .modal-title").text("Create a new user");
	} else {
		$("#editModal .modal-title").text("Edit user #"+idUser);
	}
	$("#editModal .modal-body").load(returnFWAlias()+"user/form/"+idUser);
	$('#editModal').modal('show');
}

function deleteUser(idUser) {
	$.ajax({
		url: returnFWAlias()+"user/"+idUser+"/delete.json",
		method: "POST",
		success: function(res) {
			if(res.error) {
				alert("<strong>Error!</strong> Could not delete that user", "danger");
			} else {
				alert("<strong>Sucess!</strong> The user has been deleted", "success");
				location.reload();
			}
		},
		error: function() {
			alert('Cannot connect to the server at this time :\'(', "danger");
		}
	});
}