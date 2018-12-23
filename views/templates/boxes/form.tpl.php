<form id="boxForm" method="post" role="form"
	action="<?=isset($box) ? linkTo("boxes/{$box->id}") : linkTo("boxes")?>">
	<input id="methodOverrideField" type="hidden" name="_method" value="<?=isset($box) ? "put" : "post"?>"/>
	<input type="hidden" value="<?=isset($box) ? $box->id : "" ?>">
	<p class="input-group">
		<label for="nameTf"><span class="glyphicon glyphicon-folder-close"></span> Name</label>
		<input id="nameTf" value="<?=isset($box) ? $box->name : "" ?>" type="text" class="form-control"
			placeholder="Flashcard Box Name" pattern=".{5,255}" required title="Between 5 and 255 characters">
	</p>
	<p class="input-group">
		<label for="descTa"><span class="glyphicon glyphicon-modal-window"></span> Description</label>
		<textarea id="descTa" class="form-control" placeholder="Flashcard Box Description" name="desc" required><?=isset($box) ? $box->desc : "" ?></textarea>
	</p>
	<button class="btn btn-default btn-success btn-block">Save</button>
</form>
