$(function(){
	$(".tedit-table").on("click", ".tedit-editbutton", function (e) {
		var editLine = $(this).parents(".tedit-item");
		if(!editLine.data("isedit")) {
			$.each(editLine.find(".tedit-field"), function(e) {
				$(this).addClass("d-none");
				$(this).parent().append('<input class="tedit-txfield" name="'+$(this).data("teditkey")+'" type="text" value="'+$(this).text()+'">');
			});
			editLine.find(".tedit-editbutton, .tedit-deletebutton").addClass("d-none");
			editLine.find(".tedit-savebutton, .tedit-cancelbutton").removeClass("d-none");

			editLine.find(".tedit-txfield").get(0).select();
			editLine.data("isedit", true);
		}
	});

	$(".tedit-table").on("click", ".tedit-deletebutton", function (e) {
		var editLine = $(this).parents(".tedit-item");
		$.ajax({
			url: returnFWAlias()+"boxes/"+$("#idBox").val()+"/cards/"+editLine.data("itemid"),
			method: "POST",
			data: {
				"_method": "delete"
			},
			success: function(res) {
				if(res.error) {
					alert("<strong>Error!</strong> Could not delete that flashcard", "danger");
				} else {
					alert("<strong>Sucess!</strong> The flashcard has been deleted", "success");
					editLine.remove();
				}
			},
			error: function() {
				alert('Cannot connect to the server at this time :\'(', "danger");
			}
		});
	});

	$(".tedit-table").on("click", ".tedit-newbutton", function (e) {
		var newLine = $(this).parents(".tedit-table").find("#tedit-newline");
		var createdLine = newLine.clone().removeClass("d-none");
		newLine.parent().append(createdLine);
		createdLine.find(".tedit-editbutton").trigger("click");
	});

	$(".tedit-table").on("click", ".tedit-savebutton", function (e) {
		var editLine = $(this).parents(".tedit-item");
		if(editLine.data("isedit")) {
			if(editLine.data("itemid") == "") {
				var newItem = true;
			} else {
				var newItem = false;
			}

			var data = {
				"_method" : (newItem ? "POST" : "PUT")
			};

			$.each(editLine.find(".tedit-txfield"), function(e) {
				console.log("should we save", $(this));
				console.log(editLine.data("itemid") == "");
				if(editLine.data("itemid") == "" || $(this).val() != editLine.find("*[data-teditkey='"+$(this).prop("name")+"']").text()) {
					data[$(this).prop("name")] = $(this).val();
				}
			});
			console.log(data);

			$(this).prop("disabled", true);
			$.ajax({
				url: returnFWAlias()+"boxes/"+$("#idBox").val()+"/cards/"+(newItem ? "" : editLine.data("itemid")),
				method: "POST",
				data: data,
				success: function(res) {
					if(res.error) {
						alert("<strong>Error!</strong> Could not save flashcard", "danger");
					} else {
						alert("<strong>Sucess!</strong> Saved your flashcard", "success");
						$.each(data, function(key, val) {
							editLine.find("*[data-teditkey='"+key+"']").text(val);
						});
						resetLineDisplay(editLine);
					}
				},
				error: function() {
					alert('Cannot connect to the server at this time :\'(', "danger");
				},
				complete: function() {
					editLine.find(".tedit-savebutton").prop("disabled", false);
				}
			});
		}
	});

	$(".tedit-table").on("click", ".tedit-cancelbutton", function (e) {
		var editLine = $(this).parents(".tedit-item");
		if(editLine.data("itemid") == "") {
			editLine.remove();
		} else {
			resetLineDisplay(editLine);
		}
	});
});

function resetLineDisplay(editLine) {
	if(editLine.data("isedit")) {
		editLine.find(".tedit-txfield").remove();
		editLine.find(".tedit-field").removeClass("d-none");
		editLine.find(".tedit-editbutton, .tedit-deletebutton").removeClass("d-none");
		editLine.find(".tedit-savebutton, .tedit-cancelbutton").addClass("d-none");
		editLine.data("isedit", false);
	}
}
