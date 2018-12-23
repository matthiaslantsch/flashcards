<form id="cardForm" method="post" role="form"
	action="<?=isset($card) ? linkTo("boxes/{$box->id}/cards/{$card->id}") : linkTo("boxes/{$box->id}/cards")?>">
	<input id="methodOverrideField" type="hidden" name="_method" value="<?=isset($card) ? "put" : "post"?>"/>
	<input id="idCard" type="hidden" value="<?=isset($card) ? $card->id : "" ?>">
	<p class="input-group">
		<label for="quesTa"><i class="fa fa-question" aria-hidden="true"></i> Question</label>
		<textarea id="quesTa" class="form-control" placeholder="Question" required><?=isset($card) ? $card->qSide : "" ?></textarea>
	</p>
	<p class="input-group">
		<label for="ansTa"><i class="fa fa-exclamation" aria-hidden="true"></i> Answer</label>
		<textarea id="ansTa" class="form-control" placeholder="Answer" required><?=isset($card) ? $card->aSide : "" ?></textarea>
	</p>
	<p class="alertArea"></p>
	<button id="submitBtn" class="btn btn-default btn-success btn-block">Save</button>
</form>
