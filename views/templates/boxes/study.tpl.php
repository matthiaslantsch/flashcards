<div class="container-fluid">
	<input id="idBox" type="hidden" value="<?=$box->id?>">
	<?php if(!$box->cards->empty()): ?>
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header"><?=$box->name?> <span class="progressLabel"></span></h1>
			</div>
		</div>
		<div class="cardArea" data-cards="<?=$cardsjson?>" data-index="0">
			<div class="panel panel-default">
				<div class="panel-heading"></div>
				<div class="panel-body">
					<input id="idCard" type="hidden">
					<input id="answer" type="hidden">
					<h2 id="question"></h2>
					<div class="row">
						<div class="col-md-6">
							<input class="form-control" id="answerField"></input>
						</div>
						<div class="col-md-3">
							<button class="studyBtn btn btn-default btn-success btn-block" onclick="checkAnswer()">Check answer</button>
							<button class="studyBtn btn btn-default btn-block" onclick="nextCard()">Skip this card</button>
						</div>
						<div class="col-md-3">
							<h5><span id="tierField" class="label label-default"></span></h5>
							<h5><span class="label label-danger"><span id="wrongCount"></span>x wrong</span>&nbsp;<span class="label label-success"><span id="rightCount"></span>x &nbsp; correct</span></h5>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<div class="progress">
						<div id="cardProgress" class="progress-bar" role="progressbar"
							aria-valuenow="0" aria-valuemin="1" aria-valuemax="<?=$cardcount?>">
						</div>
					</div>
					<div class="progressLabel">1 / <?=$cardcount?></div>
				</div>
			</div>
			<div class="alertArea"></div>
		</div>
	<?php else: ?>
		<h3><?=$box->name?> appears to be empty right now :(</h3>
		<?php if($box->idUser === $user->id): ?>
			<a href="<?=linkTo("boxes/{$box->id}")?>">Add some new cards right now</a>
		<?php endif; ?>
	<?php endif; ?>
</div>
<script src="<?=linkJs("study")?>"></script>
