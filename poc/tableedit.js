$(function(){
	$(document).on("click", ".tedit-editbutton", function (e) {
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

	$(document).on("click", ".tedit-deletebutton", function (e) {
		var editLine = $(this).parents(".tedit-item");
		//delete logic - on success remove the line
		editLine.remove();
	});

	$(document).on("click", ".tedit-newbutton", function (e) {
		var newLine = $(this).parents(".tedit-table").find("#tedit-newline");
		var createdLine = newLine.clone().removeClass("d-none");
		newLine.parent().append(createdLine);
		createdLine.find(".tedit-editbutton").trigger("click");
	});

	$(document).on("click", ".tedit-savebutton", function (e) {
		var editLine = $(this).parents(".tedit-item");
		if(editLine.data("isedit")) {
			var data = {};
			$.each(editLine.find(".tedit-txfield"), function(e) {
				if(editLine.data("itemid") == "" || $(this).val() != editLine.find("*[data-teditkey='"+$(this).prop("name")+"']").text()) {
					data[$(this).prop("name")] = $(this).val();
				}
			});

			//save logic - for now assume success
			$.each(data, function(key, val) {
				editLine.find("*[data-teditkey='"+key+"']").text(val);
			});
			resetLineDisplay(editLine);
		}
	});

	$(document).on("click", ".tedit-cancelbutton", function (e) {
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
