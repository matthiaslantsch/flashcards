<main class="container pt-5">
  <div class="row pt-5">
    <div class="col-lg-12">
      <h1 class="page-header"><?=$listName?></h1>
    </div>
  </div>
  <div class="row alertArea"></div>
  <div id="listingTable" class="card bg-dark">
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
        </tbody>
      </table>
    </div>
    <div class="card-footer">
      <div class="row">
        <div class="col-sm-4">
          <form class="form-inline">
            <input id="pager" type="hidden" value="1">
            <button type="button" class="btn btn-secondary btn-sm mr-1"><i class="fa fa-step-backward" aria-hidden="true"></i></button>
            <button type="button" class="btn btn-secondary btn-sm mr-2"><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
            <div class="mr-1"><b>Page </b></div>
            <input class="pageinput form-control form-control-sm" style="width:calc(1.8125rem + 2px)" type="number" min="1" max="1" value="1">
            <div class="mx-1"><b> of </b></div>
            <button type="button" class="btn btn-secondary btn-sm mx-1"><i class="fa fa-chevron-right" aria-hidden="true"></i></button>
            <button type="button" class="btn btn-secondary btn-sm mr-2"><i class="fa fa-step-forward" aria-hidden="true"></i></button>
            <button type="button" class="btn btn-secondary btn-sm mr-1"><i class="fa fa-undo" aria-hidden="true"></i></button>
            <button type="button" class="btn btn-secondary btn-sm" onclick="editModal()"><i class="fa fa-plus" aria-hidden="true"></i></button>
          </form>
        </div>
        <div class="col-sm-4">
          <div id="loading" class="d-none text-center">Loading...</div>
        </div>
        <div class="col-sm-4">
          <div class="text-center">Displaying records <b>1 - 5</b> of <b>10</b></div>
        </div>
      </div>
    </div>
  </div>
  <div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body"></div>
      </div>
    </div>
  </div>
  <input id="backendRequest" type="hidden" value="<?=$backendRequest?>">
  <script src="<?=linkJs("boxlisting")?>"></script>
</main>
