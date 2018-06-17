<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			User Management
			<button class="btn btn-success" onclick="editModal()"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add new User</button>
		</h1>
	</div>
</div>
<div class="row">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="table-bordered">
				<table class="table">
					<thead>
						<tr>
							<th>Username</th>
							<th>Email</th>
							<th>Admin?</td>
							<th># of boxes created</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($users as $user): ?>
							<tr>
								<td><?=$user->name?></td>
								<td><?=$user->email?></td>
								<td><?=$user->isAdmin() ? "Yes" : "No"?></td>
								<td><?=count($user->box)?></td>
								<td>
									<div class="btn-group" role="group" aria-label="...">
										<a class="btn btn-default" href="#" onclick="editModal(<?=$user->id?>)"><i class="fa fa-edit" aria-hidden="true"></i> Edit</a>
										<a class="btn btn-default" href="#" onclick="deleteUser(<?=$user->id?>)"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
									</div>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="row alertArea"></div>
<div id="editModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body"></div>
		</div>
	</div>
</div>
<script src="<?=linkJs("admin")?>"></script>