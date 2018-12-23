<div class="container-fluid">
	<input id="idBox" type="hidden" value="<?=$box->id?>">
	<?php if(!$box->cards->empty()): ?>
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header"><?=$box->name?> <span class="progressLabel">1</span></h1>
			</div>
		</div>
		<div class="cardArea">
			<div id="myCarousel" class="carousel slide" data-interval="false">
				<div class="carousel-inner">
					<?php foreach($box->cards as $i => $card): ?>
						<div class="item <?=($i == 0 ? "active" : "")?> card-outer" data-idCard="<?=$card->id?>">
							<div class="card">
								<div class="front">
									<div class="well card-outer">
										<div class="card-inner">
											<h1><?=$card->qSide?></h1>
										</div>
									</div>
								</div>
								<div class="back">
									<div class="well card-outer">
										<div class="card-inner">
											<h1><?=$card->aSide?></h1>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-1">
					<button id="prevBtn" type="button" class="btn btn-primary btn-lg" disabled onclick="prev()">
						<span class="glyphicon glyphicon-chevron-left"></span>
					</button>
				</div>
				<div class="col-md-4 col-md-offset-3">
					<div class="progress">
						<div id="cardProgress" class="progress-bar" role="progressbar"
							aria-valuenow="1" aria-valuemin="1" aria-valuemax="<?=count($box->cards)?>">
						</div>
					</div>
					<div class="progressLabel">1 / <?=count($box->cards)?></div>
				</div>
				<div class="col-md-1 col-md-offset-3">
					<button id="nextBtn" type="button" class="btn btn-primary btn-lg pull-right" onclick="next()">
						<span class="glyphicon glyphicon-chevron-right"></span>
					</button>
				</div>
			</div>
		</div>
	<?php else: ?>
		<h3><?=$box->name?> appears to be empty right now :(</h3>
		<?php if($box->idUser === $user->id): ?>
			<a href="<?=linkTo("boxes/{$box->id}")?>">Add some new cards right now</a>
		<?php endif; ?>
	<?php endif; ?>
</div>
<script src="<?=linkJs("view")?>"></script>
<script src="https://cdn.rawgit.com/nnattawat/flip/master/dist/jquery.flip.min.js"></script>
