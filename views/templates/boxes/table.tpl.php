<div class="card-body">
  <table class="table text-center table-responsive">
    <thead>
      <tr>
        <th>Name</th>
        <th># of cards</th>
        <th>Created</th>
        <th>Last activity</th>
        <th>Progress</th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php if(!empty($boxes)): ?>
        <?php foreach($boxes as $box): ?>
          <tr data-idbox="<?=$box->id?>">
            <td class="boxRow"><?=$box->name?></td>
            <td class="boxRow"><?=$box->countCards()?></td>
            <td class="boxRow"><?=$box->createtime->format("ago")?> ago</td>
            <td class="boxRow"><?=$box->updatetime->format("ago")?> ago</td>
            <td class="boxRow"><?=$box->progressOf($user->id)?>%</td>
            <td>
              <div class="btn-group" role="group" aria-label="...">
                <a class="btn btn-outline-dark btn-sm" href="<?=linkTo("boxes/$box->id")?>"><i class="fa fa-eye" aria-hidden="true"></i> Overview</a>
                <a class="btn btn-outline-dark btn-sm" href="<?=linkTo("boxes/$box->id/view")?>"><i class="fa fa-th-large" aria-hidden="true"></i> Flashcards</a>
                <a class="btn btn-outline-dark btn-sm" href="<?=linkTo("boxes/$box->id/study")?>"><i class="fa fa-leanpub" aria-hidden="true"></i> Study</a>
                <a class="btn btn-outline-dark btn-sm" href="#" onclick="resetProgress(<?=$box->id?>)"><i class="fa fa-stop-circle-o" aria-hidden="true"></i> Reset</a>
              </div>
            </td>
            <td>
              <?php if($user->id == $box->idUser): ?>
                <div class="btn-group" role="group" aria-label="...">
                  <a class="btn btn-outline-dark btn-sm" href="#" onclick="editModal(<?=$box->id?>)"><i class="fa fa-edit" aria-hidden="true"></i> Edit</a>
                  <a class="btn btn-outline-dark btn-sm" href="#" onclick="deleteBox(<?=$box->id?>)"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
                </div>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="6"><span>Oops... There seems to be nothing here</span></td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
<div class="card-footer">
  <div class="row">
    <div class="col-sm-4">
      <form class="form-inline">
        <input id="pager" type="hidden" value="<?=$pager?>">
        <button type="button" class="btn btn-secondary btn-sm mr-1" <?=($pager == 1 ? "disabled" : "")?> onclick="setPager(1)">
          <i class="fa fa-step-backward" aria-hidden="true"></i>
        </button>
        <button type="button" class="btn btn-secondary btn-sm mr-2" <?=($pager == 1 ? "disabled" : "")?> onclick="movePager(-1)">
          <i class="fa fa-chevron-left" aria-hidden="true"></i>
        </button>
        <div class="mr-1"><b>Page </b></div>
        <input class="pageinput form-control form-control-sm" style="width:calc(1.8125rem + 2px)"
          type="number" min="1" max="<?=$totalpages?>" value="<?=$pager?>" <?=($totalpages == 1 ? "disabled" : "")?>>
        <div class="mx-1"><b> of <?=$totalpages?></b></div>
        <button type="button" class="btn btn-secondary btn-sm mx-1" <?=($pager == $totalpages ? "disabled" : "")?> onclick="movePager(1)">
          <i class="fa fa-chevron-right" aria-hidden="true"></i>
        </button>
        <button type="button" class="btn btn-secondary btn-sm mr-2" <?=($pager == $totalpages ? "disabled" : "")?> onclick="setPager(<?=$totalpages?>)">
          <i class="fa fa-step-forward" aria-hidden="true"></i>
        </button>
        <button type="button" class="btn btn-secondary btn-sm mr-1" onclick="loadBoxes()">
          <i class="fa fa-undo" aria-hidden="true"></i>
        </button>
        <button type="button" class="btn btn-secondary btn-sm" onclick="editModal()">
          <i class="fa fa-plus" aria-hidden="true"></i>
        </button>
      </form>
    </div>
    <div class="col-sm-4">
      <div id="loading" class="d-none text-center alertArea">Loading...</div>
    </div>
    <div class="col-sm-4">
      <div class="text-center">Displaying records <b><?=$showingresult?> - <?=$showingtoresult?></b> of <b><?=$totalresults?></b></div>
    </div>
  </div>
</div>
