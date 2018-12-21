<div class="container-fluid">
	<input id="idBox" type="hidden" value="<?=$box->id?>">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?=$box->name?> <span class="progressLabel">1</span></h1>
		</div>
	</div>
	<div class="cardArea">
		<div id="myCarousel" class="carousel slide" data-interval="false">
			<div class="carousel-inner">
				<?php foreach($cards as $i => $card): ?>
					<div class="item <?=($i == 0 ? "active" : "")?> card-outer" data-idCard="<?=$card->id?>">
						<div class="card">
							<div class="front">
								<div class="well card-outer">
									<div class="card-inner">
										<?=$card->qSide?>
									</div>
								</div>
							</div>
							<div class="back">
								<div class="well card-outer">
									<div class="card-inner">
										<?=$card->aSide?>
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
						aria-valuenow="1" aria-valuemin="1" aria-valuemax="<?=count($cards)?>">
					</div>
				</div>
				<div class="progressLabel">1 / <?=count($cards)?></div>
			</div>
			<div class="col-md-1 col-md-offset-3">
				<button id="nextBtn" type="button" class="btn btn-primary btn-lg pull-right" onclick="next()">
					<span class="glyphicon glyphicon-chevron-right"></span>
				</button>
			</div>
		</div>
	</div>
</div>
<script src="<?=linkJs("view")?>"></script>
<script src="https://cdn.rawgit.com/nnattawat/flip/master/dist/jquery.flip.min.js"></script>