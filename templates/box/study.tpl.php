<div class="container-fluid">
	<input id="idBox" type="hidden" value="<?=$box->id?>">
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
				<h4 id="question"></h4>
				<div class="row">
					<div class="col-md-6">
						<textarea id="answerField"></textarea>
					</div>
					<div class="col-md-3">
						<button class="btn btn-default btn-success btn-block" onclick="checkAnswer()">Check answer</button>
						<button class="btn btn-default btn-block" onclick="nextCard()">Skip this card</button>
					</div>
					<div class="col-md-3">
						<ul>
							<li><h4>
								<span class="label label-danger"><span id="wrongCount"></span>x wrong</span>
								<span class="label label-success"><span id="rightCount"></span>x correct</span>
							</h4></li>
							<li id="tierField"></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="panel-footer">
				<div class="alertArea"></div>
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
	</div>
</div>
<script src="<?=linkJs("study")?>"></script>