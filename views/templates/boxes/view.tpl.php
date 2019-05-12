<div class="container centeredcontainer" data-idBox="<?=$box->id?>" data-studybox="<?=htmlspecialchars(json_encode($box->getStudySetFor($user->id)))?>">
  <div class="row h-100 justify-content-center align-items-center">
    <div class="card bg-secondary h-50 w-50 text-center">
      <?php if(count($box->cards) !== 0): ?>
        <div class="card-header">
          <div class="row">
            <div class="col-md-7"><?=$box->name?> <span class="progressLabel">1 / <?=count($box->cards)?></span></div>
            <div class="col-md-5">
              <select id="showFirst" class="form-control form-inline form-control-sm float-right">
                <option value="question">Show question first</option>
                <option value="answer">Show answer first</option>
              </select>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="row justify-content-center align-items-center front">
            <h2></h2>
          </div>
          <div class="row justify-content-center align-items-center back">
            <h2></h2>
          </div>
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="col-md-2 d-none d-lg-block">
              <button id="prevBtn" class="btn btn-dark btn-lg" disabled onclick="prev()">
                <i class="fa fa-step-backward" aria-hidden="true"></i>
              </button>
            </div>
            <div class="col-md-4 offset-md-2">
              <div class="progress">
                <div id="cardProgress" class="progress-bar" role="progressbar"
                  aria-valuenow="1" aria-valuemin="1" aria-valuemax="<?=count($box->cards)?>">
                </div>
              </div>
              <div class="progressLabel">1 / <?=count($box->cards)?></div>
            </div>
            <div class="col-md-2 offset-md-2 d-none d-lg-block">
              <button id="nextBtn" class="btn btn-dark btn-lg" disabled onclick="next()">
                <i class="fa fa-step-forward" aria-hidden="true"></i>
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
  </div>
</div>
<script src="https://cdn.rawgit.com/nnattawat/flip/master/dist/jquery.flip.min.js"></script>
<script src="<?=linkJs("flashcards")?>"></script>
