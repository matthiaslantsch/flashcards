<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><?=$listName?></h1>
	</div>
</div>
<div class="row">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="table-bordered">
				<table class="table">
					<thead>
						<tr>
							<th>Name</th>
							<th># of cards</th>
							<th>Created</th>
							<th>Last activity</th>
							<th>Progress</th>
						</tr>
					</thead>
					<tbody id="listing">
					</tbody>
				</table>
			</div>
		</div>
		<div class="panel-footer">
			<div class="row">
				<div class="col-sm-2">
					<button class="btn btn-success btn-block" onclick="editModal()"><i class="fa fa-plus-circle" aria-hidden="true"></i> Create new</button>
				</div>
				<div class="col-sm-2 col-sm-offset-3">
					<div id="loading" style="display:none">
						<div class="loader">Loading...</div>
					</div>
				</div>
				<div class="col-sm-2 col-sm-offset-3">
					<input id="pager" type="hidden" value="1">
					<div class="btn-group pull-right" role="group" aria-label="...">
						<button id="prevBtn" type="button" class="btn btn-default" onclick="pager(-1)" disabled>&laquo;</button>
						<button id="nextBtn" type="button" class="btn btn-default" onclick="pager(1)">&raquo;</button>
					</div>
				</div>
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
<input id="backendRequest" type="hidden" value="<?=$backendRequest?>">
<script src="<?=linkJs("boxlisting")?>"></script>