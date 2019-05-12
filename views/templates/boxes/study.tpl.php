<div class="alertArea"></div>
<div class="container centeredcontainer" data-idBox="<?=$box->id?>" data-studybox="<?=$cardsjson?>">
  <div class="row h-100 justify-content-center align-items-center">
    <div class="card bg-secondary h-50 w-50 text-center">
      <?php if($cardcount !== 0): ?>
        <div class="card-header">
          <div class="row">
            <div class="col-md-7"><?=$box->name?> <span class="progressLabel">1 / <?=$cardcount?></span></div>
            <div class="col-md-5">
              <select id="showFirst" class="form-control form-inline form-control-sm float-right">
                <option value="question">Show question first</option>
                <option value="answer">Show answer first</option>
              </select>
            </div>
          </div>
        </div>
        <div id="studyField" class="card-body row justify-content-center align-items-center">
          <div class="row w-100">
            <div class="col-md-6">
              <h5 id="question"></h5>
            </div>
            <div class="col-md-6">
              <h5>
                <span id="tierField" class="badge badge-default"></span>
              </h5>
              <h5>
                <span class="badge badge-danger"><span id="wrongCount"></span>x wrong</span>
                <span class="badge badge-success"><span id="rightCount"></span>x correct</span>
              </h5>
            </div>
          </div>
          <div class="row justify-content-center align-items-center">
            <div class="col-md-6">
              <input class="form-control" id="answerField"></input>
            </div>
            <div class="col-md-6">
              <button id="checkBtn" class="btn btn-success btn-sm" onclick="verifyAnswer()">Check answer</button>
              <button id="skipBtn" class="btn btn-dark btn-sm">Skip this card</button>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="row justify-content-center align-items-center">
            <div class="col-md-4">
              <div class="progress">
                <div id="cardProgress" class="progress-bar" role="progressbar"
                  aria-valuenow="1" aria-valuemin="1" aria-valuemax="<?=$cardcount?>">
                </div>
              </div>
              <div class="progressLabel">1 / <?=$cardcount?></div>
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
  </div>
</div>
<script src="<?=linkJs("study")?>"></script>
