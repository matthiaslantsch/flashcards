<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><?=$user->name?> User Profile</h1>
	</div>
	<input id="idUser" type="hidden" value="<?=isset($user) ? $user->id : "" ?>">
	<button onclick="deleteUser(<?=$user->id?>)" class="btn btn-danger btn-lg btn-block">Delete all my stuff (Deletes all boxes, all your progress, everything...)</button>
</div>
<hr>
<div class="row alertArea"></div>
<script src="<?=linkJs("admin")?>"></script>
