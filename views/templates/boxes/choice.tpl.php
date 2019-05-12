<div class="alertArea"></div>
<div class="container centeredcontainer" data-idBox="<?=$box->id?>" data-studybox="<?=$cardsjson?>">
  <div id="studyField" class="row h-100 justify-content-center align-items-center">
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
        <div class="card-body p-0">
          <div class="row justify-content-center align-items-center h-100">
            <div id="questionArea">
              <h4></h4>
              <hr>
              <div></div>
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
<script src="<?=linkJs("choice")?>"></script>
