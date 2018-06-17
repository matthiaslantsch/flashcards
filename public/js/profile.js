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
					alert("<strong>Error!</strong> Could not save changes to your profile. "+res.errormsg, "danger");
				} else {
					alert("<strong>Sucess!</strong> Saved changes", "success");
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