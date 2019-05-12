<main class="container pt-5">
  <div class="row pt-5">
    <div class="col-lg-12">
      <h1 class="page-header">User Management</h1>
    </div>
  </div>
  <div class="row alertArea"></div>
  <div class="card bg-dark">
    <div class="card-body">
      <table class="table text-center table-responsive">
        <thead>
          <tr>
            <th>Username</th>
            <th># of boxes created</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($users as $user): ?>
            <tr>
              <td><?=$user->name?></td>
              <td><?=count($user->boxes)?></td>
              <td>
                <div class="btn-group" role="group" aria-label="...">
                  <a class="btn btn-default" href="#" onclick="deleteUser(<?=$user->id?>)"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</main>
<script src="<?=linkJs("admin")?>"></script>
