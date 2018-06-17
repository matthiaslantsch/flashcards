<div class="navbar-default sidebar" role="navigation">
	<div class="sidebar-nav navbar-collapse">
			<ul class="nav" id="side-menu">
					<li class="sidebar-search">
							<div class="input-group custom-search-form">
									<input type="text" class="form-control" placeholder="Search...">
									<span class="input-group-btn">
									<button class="btn btn-default" type="button">
											<i class="fa fa-search"></i>
									</button>
							</span>
							</div>
					</li>
					<li>
						<a href="<?=linkTo()?>"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
					</li>
					<li>
						<a href="<?=linkTo("my")?>"><i class="fa fa-cubes fa-fw"></i> My own Boxes</a>
					</li>
					<li>
						<a href="<?=linkTo("box")?>"><span class="glyphicon glyphicon-th-list"></span> All Boxes</a>
					</li>
					<?php if(isset($user) && $user->isAdmin()): ?>
						<li>
							<a href="<?=linkTo("admin")?>"><i class="fa fa-users fa-fw"></i></span> User Management</a>
						</li>					
					<?php endif; ?>
			</ul>
	</div>
</div>
<div id="page-wrapper">