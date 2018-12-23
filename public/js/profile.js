function deleteUser(idUser) {
	if (!window.confirm("Are you sure?")) {
		return;
	}

	$("button").prop("disabled", true);

	$.ajax({
		url: returnFWAlias()+"user/"+idUser,
		method: "POST",
		data: {
			"_method": "delete"
		},
		success: function(res) {
			if(res.error != false) {
				alert("<strong>Error!</strong> Could not save changes to your profile. "+res.errormsg, "danger");
			} else {
				alert("<strong>Sucess!</strong> You're off to a brand new start", "success");
			}
		},
		error: function() {
			alert('Cannot connect to the server at this time :\'(', "danger");
		},
		complete: function() {
			$("button").removeAttr("disabled");
		}
	});
}
