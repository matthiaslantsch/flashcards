<?php if(!empty($boxes)): ?>
	<?php foreach($boxes as $box): ?>
		<tr>
			<td class="boxRow" data-idbox="<?=$box->id?>"><?=$box->name?></td>
			<td class="boxRow" data-idbox="<?=$box->id?>"><?=$box->countCards()?></td>
			<td class="boxRow" data-idbox="<?=$box->id?>"><?=$box->createtime->format("ago")?> ago</td>
			<td class="boxRow" data-idbox="<?=$box->id?>"><?=$box->updatetime->format("ago")?> ago</td>
			<td class="boxRow" data-idbox="<?=$box->id?>"><?=$box->progressOf($user->id)?>%</td>
			<td>
				<div class="btn-group" role="group" aria-label="...">
					<a class="btn btn-default" href="<?=linkTo("boxes/$box->id")?>"><i class="fa fa-eye" aria-hidden="true"></i> Overview</a>
					<a class="btn btn-default" href="<?=linkTo("boxes/$box->id/view")?>"><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> Flashcards</a>
					<a class="btn btn-default" href="<?=linkTo("boxes/$box->id/study")?>"><i class="fa fa-leanpub" aria-hidden="true"></i> Study</a>
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
<?php else: ?>
	<tr><td colspan="6"><span>Oops... There seems to be nothing here</span></td></tr>
<?php endif; ?>
