<form id="userForm" method="post" role="form">
	<input id="idUser" type="hidden" value="<?=isset($user) ? $user->id : "" ?>">
	<p class="input-group">
		<label for="nameTf"><span class="glyphicon glyphicon-user"></span> Name</label>
		<input id="nameTf" value="<?=isset($user) ? $user->name : "" ?>" type="text" class="form-control"
			placeholder="Username" pattern=".{4,40}" required title="Between 4 and 40 characters">
	</p>
	<p class="input-group">
		<label for="emailTf"><span class="glyphicon glyphicon-envelope"></span> Email</label>
		<input id="emailTf" value="<?=isset($user) ? $user->email : "" ?>" type="text" class="form-control"
			placeholder="Email" pattern=".{10,40}" required title="Between 10 and 40 characters">
	</p>
	<p class="input-group">
		<label for="passwordTf">Password <?=isset($user) ? "(Leave empty for not changing it)" : ""?></label>
		<input id="passwordTf" type="password"  class="form-control" <?=isset($user) ? "" : "required"?> placeholder="<?=isset($user) ? "New " : ""?>Password" pattern=".{1,40}">
	</p>
	<?php if(isset($user) && $user->isAdmin()): ?>
		<p>
			Admin? <input id="isAdminCb" type="checkbox" <?=$user->isAdmin() ? "checked" : ""?>>
		</p>
	<?php endif; ?>
	<button id="submitBtn" class="btn btn-default btn-success btn-block">Save</button>
</form>