<div class="container-fluid">
	<input id="idBox" type="hidden" value="<?=$box->id?>">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?=$box->name?></h1>
		</div>
	</div>
	<h4>Created by <a href="<?=linkTo("user/$box->idUser")?>"><?=$box->user->name?></a> <?=$box->createtime->format("j M o g:i a")?></h4>
	<p><?=$box->desc?></p>
	<p>Last activity was <?=$box->updatetime->format("ago")?> ago</p>
	<hr>
	<h4>Cards:
		<?php if($box->idUser == $user->id): ?>
			<button class="btn" onclick="editModal()"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add a new card</button>
		<?php endif; ?>
	</h4>
	<table class="table">
		<tbody>
			<?php foreach($box->cards as $card): ?>
				<tr>
					<td><h4><?=$card->qSide?></h4></td>
					<td><h4><?=$card->aSide?></h4></td>
					<?php if(($cardprogress = $card->progressOf($user->id)) !== null): ?>
						<td>
							<h4>
								<span class="label label-danger"><span id="wrongCount"></span><?=$cardprogress->wrongC?>x wrong</span>
								<span class="label label-success"><span id="rightCount"></span><?=$cardprogress->corrC?>x correct</span>
							</h4>
						</td>
						<td><h4><?=str_repeat('<i class="fa fa-star" aria-hidden="true"></i>', $cardprogress->tier)?></h4></td>
					<?php else: ?>
						<td colspan="2">new</td>
					<?php endif; ?>
					<?php if($box->idUser == $user->id): ?>
						<td>
							<div class="btn-group pull-right" role="group" aria-label="...">
								<button class="btn" onclick="editModal(<?=$card->id?>)">
									<i class="fa fa-edit" aria-hidden="true"></i> Edit
								</button>
								<button class="btn" onclick="deleteCard(<?=$card->id?>)">
									<i class="fa fa-trash" aria-hidden="true"></i> Delete
								</button>
							</div>
						</td>
					<?php endif; ?>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<div id="editModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body"></div>
		</div>
	</div>
</div>
<script src="<?=linkJs("box")?>"></script>
