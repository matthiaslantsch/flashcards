<div class="jumbotron jumbotron-fluid bg-dark">
  <div class="container">
    <h1><?=$user->name?> User Profile</h1>
    <input id="idUser" type="hidden" value="<?=isset($user) ? $user->id : "" ?>">
    <button onclick="deleteUser(<?=$user->id?>)" class="btn btn-danger btn-lg btn-block">Delete all my stuff (Deletes all boxes, all your progress, everything...)</button>
  </div>
</div>
<hr>
<div class="row alertArea"></div>
<script src="<?=linkJs("admin")?>"></script>
