<?php foreach($boxes as $box): ?>
	<tr>
		<td class="boxRow" data-idbox="<?=$box->id?>"><?=$box->name?></td>
		<td class="boxRow" data-idbox="<?=$box->id?>"><?=count($box->card)?></td>
		<td class="boxRow" data-idbox="<?=$box->id?>"><?=$box->created?></td>
		<td class="boxRow" data-idbox="<?=$box->id?>"><?=$box->updated?></td>
		<td class="boxRow" data-idbox="<?=$box->id?>"><?=$box->progressOf($user->id)?>%</td>
		<td>
			<div class="btn-group" role="group" aria-label="...">
				<a class="btn btn-default" href="<?=linkTo("box/$box->id")?>"><i class="fa fa-eye" aria-hidden="true"></i> Overview</a>
				<a class="btn btn-default" href="<?=linkTo("box/$box->id/view")?>"><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> Flashcards</a>
				<a class="btn btn-default" href="<?=linkTo("box/$box->id/study")?>"><i class="fa fa-leanpub" aria-hidden="true"></i> Study</a>
				<a class="btn btn-default" href="#" onclick="resetProgress(<?=$box->id?>)"><i class="fa fa-stop-circle-o" aria-hidden="true"></i> Reset Progress</a>
			</div>
			<?php if($user->id == $box->idUser): ?>
				<div class="btn-group" role="group" aria-label="...">
					<a class="btn btn-default" href="#" onclick="editModal(<?=$box->id?>)"><i class="fa fa-edit" aria-hidden="true"></i> Edit</a>
					<a class="btn btn-default" href="#" onclick="deleteBox(<?=$box->id?>)"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
				</div>
			<?php endif; ?>
		</td>
	</tr>
<?php endforeach; ?>