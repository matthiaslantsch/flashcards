<main class="container pt-5">
  <div class="pt-5">
    <input id="idBox" type="hidden" value="<?=$box->id?>">
    <div class="col-lg-12">
      <h1 class="page-header"><?=$box->name?></h1>
    </div>
    <h4>Created by <?=$box->user->name?> <?=$box->createtime->format("ago")?> ago</h4>
    <p><?=$box->desc?></p>
    <p>Last activity was <?=$box->updatetime->format("ago")?> ago</p>
    <div class="row alertArea"></div>
  </div>
  <table class="table tedit-table" data-tediturl="boxes/<?=$box->id?>/cards">
    <caption style="caption-side: top;">
      <h4>
        Cards:
        <?php if($box->idUser == $user->id): ?>
          <button class="btn btn-outline-secondary tedit-newbutton">
            <i class="fa fa-plus" aria-hidden="true"></i> Add a new card
          </button>
        <?php endif; ?>
      </h4>
    </caption>
    <tbody>
      <tr id="tedit-newline" class="tedit-item d-none" data-isedit="false" data-itemid="">
        <td><h4 class="tedit-field" data-teditkey="qSide"></h4></td>
        <td><h4 class="tedit-field" data-teditkey="aSide"></h4></td>
        <td colspan="2">new</td>
        <td>
          <div class="btn-group pull-right" role="group" aria-label="...">
            <button class="btn btn-outline-secondary btn-sm tedit-editbutton">
              <i class="fa fa-edit" aria-hidden="true"></i> Edit
            </button>
            <button class="btn btn-outline-secondary btn-sm tedit-savebutton d-none">
              <i class="fa fa-save" aria-hidden="true"></i> Save
            </button>
            <button class="btn btn-outline-secondary btn-sm tedit-deletebutton">
              <i class="fa fa-trash" aria-hidden="true"></i> Delete
            </button>
            <button class="btn btn-outline-secondary btn-sm tedit-cancelbutton d-none">
              <i class="fa fa-remove" aria-hidden="true"></i> Cancel
            </button>
          </div>
        </td>
      </tr>
      <?php foreach($box->cards as $card): ?>
        <tr class="tedit-item" data-isedit="false" data-itemid="<?=$card->idCard?>">
          <td><h4 class="tedit-field" data-teditkey="qSide"><?=$card->qSide?></h4></td>
          <td><h4 class="tedit-field" data-teditkey="aSide"><?=$card->aSide?></h4></td>
          <?php if(($cardprogress = $card->progressOf($user->id)) !== null): ?>
            <td><h4>
              <span class="badge badge-danger"><span id="wrongCount"></span><?=$cardprogress->wrongC?>x wrong</span>
              <span class="badge badge-success"><span id="rightCount"></span><?=$cardprogress->corrC?>x correct</span>
            </h4></td>
            <td><h4><?=str_repeat('<i class="fa fa-star" aria-hidden="true"></i>', $cardprogress->tier)?></h4></td>
          <?php else: ?>
            <td colspan="2">new</td>
          <?php endif; ?>
            <td>
            <?php if($box->idUser == $user->id): ?>
              <div class="btn-group pull-right" role="group" aria-label="...">
                <button class="btn btn-outline-secondary btn-sm tedit-editbutton">
                  <i class="fa fa-edit" aria-hidden="true"></i> Edit
                </button>
                <button class="btn btn-outline-secondary btn-sm tedit-savebutton d-none">
                  <i class="fa fa-save" aria-hidden="true"></i> Save
                </button>
                <button class="btn btn-outline-secondary btn-sm tedit-deletebutton">
                  <i class="fa fa-trash" aria-hidden="true"></i> Delete
                </button>
                <button class="btn btn-outline-secondary btn-sm tedit-cancelbutton d-none">
                  <i class="fa fa-remove" aria-hidden="true"></i> Cancel
                </button>
              </div>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</main>
<script src="<?=linkJs("box")?>"></script>
